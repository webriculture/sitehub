#!/usr/bin/env bash
#
# Import the Harris Thermal V2 Eleventy build into SiteHub as pages-as-code.
#
# The client's Eleventy project (examples/harris/harris-thermal-website, see its
# README and CURRENT-PROJECT-STATUS.md) is the SOURCE OF TRUTH for this site.
# Nothing under resources/sites/harristhermal2/pages/ or public/sites/harristhermal2/
# is hand-edited: this script regenerates both from a fresh Eleventy build.
#
# What it does, in order:
#   1. Stages a copy of the client repo (never touching the repo itself), sets
#      config/site.json "url" to the staging URL (the client's own contract:
#      "staging MUST override it") and runs the client's build.
#   2. Flattens site/**/index.html into pages/**.blade.php (home = site/index.html),
#      rewriting root-absolute /assets/ and /wp-content/ paths (and their absolute
#      https://<site-url>/... forms in JSON-LD and og:image) to /sites/<slug>/...,
#      escaping directive-shaped @word tokens as @@word (JSON-LD keys such as
#      @context collide with Blade directives; Blade renders @@ back to @), and
#      injecting the platform widgets before </body>.
#   3. Copies site/assets and site/wp-content under public/sites/<slug>/ and
#      applies the same path rewrite inside CSS/JS.
#   4. Loads the client's 301 map (build/redirects/redirects.json) into the site's
#      settings.redirects. 410 rows cannot be expressed by SiteHub today and fall
#      through to 404 — the client's docs call that expected for a preview.
#   5. Clears the response cache and writes docs/last-import.txt.
#
# Usage:
#   resources/sites/harristhermal2/docs/import.sh [--src DIR] [--url URL] [--build-dir DIR]
#
#   --src        client repo (default: examples/harris/harris-thermal-website)
#   --url        site URL baked into canonicals/JSON-LD (default: https://ht2.demo.webriculture.com)
#   --build-dir  scratch dir for the staged build (default: mktemp -d)
#
# Re-runnable. Every run replaces pages and assets wholesale, so retired pages
# disappear and nothing stale survives. Run `php artisan test` afterwards — the
# smoke suite renders every imported page.

set -euo pipefail

SLUG=harristhermal2
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/../../../.." && pwd)"
SRC="$ROOT/examples/harris/harris-thermal-website"
SITE_URL="https://ht2.demo.webriculture.com"
BUILD_DIR=""

while [ $# -gt 0 ]; do
    case "$1" in
        --src) SRC="$2"; shift 2 ;;
        --url) SITE_URL="$2"; shift 2 ;;
        --build-dir) BUILD_DIR="$2"; shift 2 ;;
        -h|--help) sed -n '2,32p' "$0"; exit 0 ;;
        *) echo "unknown option: $1" >&2; exit 2 ;;
    esac
done

SITE_URL="${SITE_URL%/}"
BUILD_DIR="${BUILD_DIR:-$(mktemp -d)}"
PAGES="$ROOT/resources/sites/$SLUG/pages"
PUB="$ROOT/public/sites/$SLUG"
PREFIX="/sites/$SLUG"
export SITE_URL PREFIX

[ -f "$SRC/.eleventy.js" ] || { echo "not an Eleventy project: $SRC" >&2; exit 1; }
[ -f "$SRC/node_modules/@11ty/eleventy/cmd.cjs" ] || { echo "run 'npm ci' in $SRC first (node_modules missing)" >&2; exit 1; }
[ -d "$ROOT/resources/sites/$SLUG" ] || { echo "site [$SLUG] is not provisioned — run: php artisan sites:create $SLUG" >&2; exit 1; }

SRC_COMMIT="$(git -C "$SRC" rev-parse --short HEAD 2>/dev/null || echo unknown)"
SRC_DIRTY="$(git -C "$SRC" status --short 2>/dev/null | wc -l | tr -d ' ')"

echo "== 1/5 build  (source $SRC @ $SRC_COMMIT, $SRC_DIRTY uncommitted; url $SITE_URL)"
mkdir -p "$BUILD_DIR"
rsync -a --delete \
    --exclude node_modules --exclude site --exclude build --exclude .git \
    --exclude legacy --exclude .visual-diff --exclude snapshots --exclude _to_delete --exclude .claude \
    "$SRC/" "$BUILD_DIR/"
ln -sfn "$SRC/node_modules" "$BUILD_DIR/node_modules"

# Staging override per the client's config/site.json contract. Only "url" changes.
node -e '
    const fs = require("fs");
    const [file, url] = process.argv.slice(1);
    const cfg = JSON.parse(fs.readFileSync(file, "utf8"));
    cfg.url = url;
    fs.writeFileSync(file, JSON.stringify(cfg, null, 2) + "\n");
' "$BUILD_DIR/config/site.json" "$SITE_URL"

# The .bin shims may lack an execute bit on a copied tree; call Eleventy via node.
(
    cd "$BUILD_DIR"
    rm -rf site build
    node node_modules/@11ty/eleventy/cmd.cjs --quiet > build.log 2>&1 || { cat build.log >&2; exit 1; }
    node tools/gen-redirects.mjs >> build.log 2>&1 || { cat build.log >&2; exit 1; }
)
[ -f "$BUILD_DIR/site/index.html" ] || { echo "build produced no site/index.html" >&2; exit 1; }

echo "== 2/5 pages  -> $PAGES"
read -r -d '' REWRITE <<'PERL' || true
s{\Q$ENV{SITE_URL}\E/(assets|wp-content)/}{$ENV{SITE_URL}$ENV{PREFIX}/$1/}g;
s{(["'(=\s,])/(assets|wp-content)/}{$1$ENV{PREFIX}/$2/}g;
PERL
# Pages only — never applied to static CSS/JS, where @media etc. must stay literal.
# Blade treats any \B@word as a potential directive (JSON-LD "@context" collides
# with Laravel's @context); @@word renders back as @word, so output is unchanged.
read -r -d '' ESCAPE <<'PERL' || true
s/\B@(\w)/\@\@$1/g;
PERL
read -r -d '' INJECT <<'PERL' || true
s{</body>}{<x-accessibility-toolbar />\n<x-scroll-to-top />\n</body>};
PERL

rm -rf "$PAGES"
mkdir -p "$PAGES"
while IFS= read -r -d '' file; do
    rel="${file#"$BUILD_DIR/site/"}"
    rel="${rel%index.html}"
    rel="${rel%/}"
    if [ -z "$rel" ]; then rel=home; fi
    out="$PAGES/$rel.blade.php"
    mkdir -p "$(dirname "$out")"
    perl -pe "$REWRITE $ESCAPE $INJECT" "$file" > "$out"
done < <(find "$BUILD_DIR/site" -name index.html -print0)

echo "== 3/5 assets -> $PUB"
mkdir -p "$PUB"
rsync -a --delete "$BUILD_DIR/site/assets/" "$PUB/assets/"
rsync -a --delete "$BUILD_DIR/site/wp-content/" "$PUB/wp-content/"
find "$PUB/assets" -type f \( -name '*.css' -o -name '*.js' \) -print0 \
    | xargs -0 perl -pi -e "$REWRITE"

echo "== 4/5 redirects"
REDIRECTS_JSON="$BUILD_DIR/build/redirects/redirects.json"
php "$ROOT/artisan" tinker --execute="
\$site = \App\Models\Site::query()->where('slug', '$SLUG')->firstOrFail();
\$rules = json_decode(file_get_contents('$REDIRECTS_JSON'), true)['rules'];
\$map = [];
foreach (\$rules as \$rule) {
    if (in_array(\$rule['status'], [301, 302], true)) {
        \$map[rtrim(\$rule['from'], '/') ?: '/'] = \$rule['to'];
    }
}
\$site->update(['settings' => array_merge(\$site->settings ?? [], ['redirects' => \$map])]);
\$gone = count(array_filter(\$rules, fn (\$rule) => \$rule['status'] === 410));
echo '   ', count(\$map), ' redirects loaded into settings.redirects; ', \$gone, ' 410 rows fall through to 404.', PHP_EOL;
"

echo "== 5/5 cache + record"
php "$ROOT/artisan" responsecache:clear --quiet

set +o pipefail  # report greps legitimately match nothing; a no-match exit 1 must not abort
page_count=$(find "$PAGES" -name '*.blade.php' | wc -l | tr -d ' ')
asset_count=$(find "$PUB/assets" "$PUB/wp-content" -type f | wc -l | tr -d ' ')
unrewritten=$(grep -rlE '(["'"'"'(=[[:space:],])/(assets|wp-content)/' "$PAGES" "$PUB/assets" 2>/dev/null | wc -l | tr -d ' ')
no_widgets=$(grep -rL '<x-accessibility-toolbar />' "$PAGES" | wc -l | tr -d ' ')
blade_hazards=$(grep -rlE '\{\{|\{!!|<\?|(^|[^[:alnum:]_@])@[A-Za-z_]' "$PAGES" | wc -l | tr -d ' ')
missing_assets=$(grep -rhoE "$PREFIX/[A-Za-z0-9._/%-]+" "$PAGES" "$PUB/assets" | sort -u | while read -r u; do [ -e "$ROOT/public${u}" ] || echo "$u"; done | tee "$ROOT/resources/sites/$SLUG/docs/missing-assets.txt" | wc -l | tr -d ' ')
[ "$missing_assets" = 0 ] && rm -f "$ROOT/resources/sites/$SLUG/docs/missing-assets.txt"

cat > "$ROOT/resources/sites/$SLUG/docs/last-import.txt" <<RECORD
imported:        $(date -u +%Y-%m-%dT%H:%M:%SZ)
source:          $SRC
source commit:   $SRC_COMMIT ($SRC_DIRTY uncommitted files)
site url:        $SITE_URL
pages:           $page_count
asset files:     $asset_count
RECORD

echo
echo "   pages            $page_count"
echo "   asset files      $asset_count"
echo "   unrewritten refs $unrewritten   (files still holding root-absolute /assets or /wp-content)"
echo "   missing assets   $missing_assets   (referenced under $PREFIX but absent on disk)"
echo "   widget-less pages $no_widgets"
echo "   blade hazards    $blade_hazards   (files containing {{, {!!, <? or an unescaped @word)"
echo "   build dir        $BUILD_DIR"
echo "   record           resources/sites/$SLUG/docs/last-import.txt"
echo
echo "next: php artisan test"
