# BUILD-NOTES.md — neednavigator.com v2 on SiteHub

How to run, edit, and launch the Need Navigator marketing site. Companion docs: [SITE-PLAN.md](SITE-PLAN.md) (sitemap, keywords, exclusions), [FEATURES.md](FEATURES.md) + [BACKUP-CLAIMS.md](BACKUP-CLAIMS.md) (binding content truth), [OPEN-QUESTIONS.md](OPEN-QUESTIONS.md) (unresolved = excluded), [image-manifest.md](image-manifest.md) (every image slot awaiting a real asset).

## Where everything lives

| Thing | Path |
|---|---|
| Page copy (one file per URL) | `resources/sites/neednavigator/pages/**.blade.php` (`home` → `/`, `features/shelters.blade.php` → `/features/shelters`) |
| Layout (head/SEO/JSON-LD, nav, footer) | `resources/sites/neednavigator/partials/layout.blade.php` |
| Demo-CTA band | `resources/sites/neednavigator/partials/cta.blade.php` |
| CSS (design tokens in `:root`, page-scoped blocks at the end) | `public/sites/neednavigator/css/site.css` |
| JS (nav toggle + reveal only) | `public/sites/neednavigator/js/site.js` |
| Fonts (Source Serif 4 + Public Sans, variable woff2) | `public/sites/neednavigator/fonts/` |
| Logos, favicon, OG image | `public/sites/neednavigator/{img,og}/` |
| llms.txt (served at `/llms.txt`) | `resources/sites/neednavigator/llms.txt` |
| SEO invariant tests | `tests/Feature/NeedNavigatorSiteTest.php`, `tests/Feature/SiteMetaFeaturesTest.php` |

No build step. CSS/JS/fonts are plain files served straight from `public/` — edits are live on the next uncached request. robots.txt and sitemap.xml are platform-generated from the page files on disk.

## Editing copy

- Every page is plain text in its blade file. Change words, commit, done — **git history is the page history**.
- Per-page SEO lives at the top of each page: `@section('title', …)` (≤60 chars) and `@section('description', …)` (≤155 chars).
- FAQs: each page's `$faqs` array in the `@php` block drives **both** the visible accordion and the FAQPage JSON-LD — edit the array, never just the HTML.
- Content rules are binding: claims must trace to FEATURES.md/BACKUP-CLAIMS.md; the "Deliberately NOT on the site" list in SITE-PLAN §3 applies to every edit; anything ambiguous goes to OPEN-QUESTIONS.md instead of onto the page.
- Images: each slot is wrapped in an `IMAGE SLOT` comment matching a row in image-manifest.md. Drop the real asset into `public/sites/neednavigator/img/`, swap the placeholder markup, and check the row off.
- Adding a page: create the blade file — it is automatically in the sitemap and covered by the smoke test suite. Deleting one: also add a 301 to `settings['redirects']` (see below).

## Deploying a change

```bash
php artisan test && vendor/bin/pint --dirty   # required before any commit
git commit …                                   # deploy per platform practice
php artisan responsecache:clear               # IMPORTANT: full-page cache holds old HTML up to 7 days
```

`responsecache:clear` is needed after **blade/content** changes and after any domain/settings change. Plain `public/` asset edits bypass the page cache but the HTML referencing them may be cached — clear when in doubt.

## Platform features this site introduced (available to every SiteHub site)

- **Staging noindex done right:** non-primary hosts get `X-Robots-Tag: noindex, nofollow` on every response (ResolveSite), with robots.txt left crawlable so the header is seen.
- **Per-site `/llms.txt`:** served from `resources/sites/{slug}/llms.txt` when present.
- **Per-site 301 map:** `settings['redirects']` (`['/old' => '/new']`), consulted only when no template matches. Already configured here with the six legacy `/pages/*` URLs (`/pages/home → /` was already platform-wide). To edit:

```bash
php artisan tinker --execute="\$s=App\Models\Site::where('slug','neednavigator')->first();\$x=\$s->settings;\$x['redirects']['/old-path']='/new-path';\$s->update(['settings'=>\$x]);"
```

## Site facts

- Slug `neednavigator`. Domains: **www.neednavigator.com (primary — registered pre-DNS on purpose)**, `neednavigator.com` (301 → www once DNS points here), `nn.webriculture.com` (staging; serves directly, noindexed). Features enabled: `forms`.
- Contact form: `<x-site-form key="demo" />` on /contact — platform backend, honeypot + Turnstile, submissions stored in the tenant DB (`site_neednavigator`), emailed to `settings['form_recipients']` once mail works.

## Launch checklist

**Staging (now)**
- [ ] nginx vhost + `certbot` for nn.webriculture.com (shared snippet; needs sudo) — *Dave*
- [ ] Add nn.webriculture.com + www.neednavigator.com to the platform Turnstile widget's allowed hostnames in Cloudflare — *Dave*
- [ ] Visual pass on staging in a real browser (spot-check mobile nav, FAQs, the UI illustrations)

**Before launch**
- [ ] **Mail transport** — production is `MAIL_MAILER=log` with a placeholder from-address; the demo form stores but delivers no email until a real transport (SES fits the AWS setup) + from-domain with SPF/DKIM is wired — *Dave*
- [x] `form_recipients` = support@neednavigator.com, `form_subject` set (2026-07-25)
- [x] Analytics: launching without (Dave 2026-07-25); add later if wanted
- [x] OPEN-QUESTIONS #11–19 all resolved (2026-07-25)
- [ ] Real imagery: work through [image-manifest.md](image-manifest.md) (30 slots — logo SVGs, OG card, screenshots, photography)
- [ ] Replace `[TESTIMONIAL: …]` placeholders with real quotes (none fabricated)
- [ ] nginx performance (needs sudo): enable `gzip_types` (snippets/gzip.conf exists, unused), `http2`, and cache-control headers for statics — currently CSS/JS/SVG ship uncompressed over HTTP/1.1; this is the main Lighthouse-performance dependency
- [ ] Lighthouse 95+ pass on staging after the nginx fixes

**DNS cutover day**
- [ ] Point www.neednavigator.com + apex DNS at this box; extend nginx `server_name` + certbot for both
- [ ] `php artisan responsecache:clear`
- [ ] Verify: `/` 200s on www; apex 301s to www; the six legacy `/pages/*` URLs 301 to their new homes; `/robots.txt` invites indexing + `/sitemap.xml` + `/llms.txt` respond on www; staging still sends `X-Robots-Tag: noindex`
- [ ] Submit sitemap in Search Console; add uptime monitoring
- [ ] Old server: nothing to keep — all legacy URLs are mapped

**After cutover**
- [ ] Optionally flip staging to a redirect: `php artisan sites:domain neednavigator nn.webriculture.com` (re-attach without `--no-redirect`)
- [ ] Watch form submissions arrive (tenant DB + email)
