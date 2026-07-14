# Webriculture Site Hub — Build Specification (v2, Flatten-First)

**Project:** `sitehub` (confirmed repo name; replaces `webriculture/laravelcms` v1). Composer package `webriculture/sitehub`, default `App\` namespace.
**Audience:** AI coding agent + David Lux (reviewer)
**Status:** Phase 1 authorization — build the skeleton and core platform
**Date:** July 2026
**Supersedes:** SiteHub spec v1 (block-CMS approach). The block content system is now a *future direction* (§14), not a committed deliverable.

---

## 1. Context & Purpose

Webriculture operates a legacy CMS (`webriculture/laravelcms`: Laravel 7, PHP 7.1, EOL) hosting small client brochure sites (~$1,500/month recurring). **The legacy platform is not multi-tenant**: it is one shared codebase deployed once per site, each deployment with its own PostgreSQL database, its own S3 bucket, and a theme fixed at boot by a `THEME_NAME` env var (igaster/laravel-theme is used only for view fallback). Six themes ship in the shared repo — `fredsbistro`, `shine`, `stPauls`, `theMarbleCenter`, `theQuarry`, `westSalemNursery` — with `theQuarry` and `theMarbleCenter` live on this server and the others on a second server pointed at the same git remote. A full audit of the live theMarbleCenter deployment is condensed in Appendix A.

**Product vision (revised):** a single multi-tenant Laravel application that hosts all sites as **code** — each site's pages are Blade templates produced by *flattening* the rendered output of its legacy deployment, pixel-perfect and URL-identical. Content editing by clients is removed except for narrowly scoped, deliberately built surfaces; **gallery management is the only such surface at launch**. Routine content changes become AI-assisted code edits made by Webriculture and deployed via git. Full-page caching makes the app behave like a static site generator without a build pipeline. Constrained block editing (spec v1's centerpiece) is deferred until real client demand proves it out (§14).

**Why flatten-first:**
- Kills the EOL Laravel 7 / PHP 7.1 servers fast — the actual urgent problem.
- Migration is lossless by construction: we capture exactly what the browser renders today. No lossy section-tree → block conversion, no Builder UI, no revision system, no editor-role matrix on the critical path.
- Zero SEO risk: URLs (including the legacy `/pages/{slug}` scheme) are preserved verbatim.
- Pages-as-code fits the AI-assisted development workflow that is the point of the business.

## 2. Stack (fixed decisions — do not substitute)

- **Laravel 13** (`^13.0`), **PHP 8.4**, `declare(strict_types=1)` in all new files
- **PostgreSQL 16** — one cluster, **landlord database + one database per site** (see §3). Hard isolation was an explicit values decision: a scoping bug in app code must have nothing to leak. Note: legacy DBs are already PostgreSQL, so importers use additional `pgsql` connections per legacy site.
- **Filament v4** (latest stable with Laravel 13 support) for the small admin panel
- **Blade + anonymous Blade components** for the dynamic components (`<x-site-gallery>`, `<x-site-form>`); **Alpine.js** only where new components need interactivity; **Vite** for platform/admin assets
- Flattened pages keep their captured front-end stack (jQuery, Slick, Fancybox, compiled Tailwind 1.x CSS) as static per-site assets until a site's theme is deliberately reworked. Do not "modernize" flattened markup.
- **No** igaster/laravel-theme, no Laravel Mix.
- Packages: `spatie/laravel-medialibrary` (^11), `spatie/laravel-responsecache`, `spatie/laravel-permission` (^6), `spatie/laravel-sitemap`, `spatie/laravel-backup`. `intervention/image` (^3) only if medialibrary conversions prove insufficient.
- Testing: **Pest**, with factories for every model.
- Do not add packages beyond this list without flagging for approval.
- **Licensing:** every package above is MIT-licensed open source (Laravel, Filament core, all Spatie packages, Pest, Alpine, Tailwind, Vite, Intervention). **Do not install paid Filament marketplace plugins or `spatie/laravel-medialibrary-pro`** — the free MIT versions cover everything specced. Filament v4 ships multi-factor authentication in core, so no 2FA plugin is needed at all. External services: Cloudflare Turnstile (free tier), AWS S3/SES (existing infra billing). One license rides along from legacy: flattened sites carry self-hosted **FontAwesome Pro** webfonts — confirm Webriculture's license is active before redistributing those assets on the new platform.
- Explicitly excluded (see §15): everything the legacy platform had that we are dropping — commerce, blog, events, biographies, form builder, Algolia/Scout, Constant Contact (dead v2 API), Excel exports, content scheduling.

## 3. Multi-Tenancy Model (landlord + database-per-site)

One codebase, one checkout, one deploy — but **hard data isolation**: each site gets its own small PostgreSQL database on the shared PG16 cluster, alongside a central **landlord** database.

- **Landlord DB** (`sitehub`): `sites`, `domains`, `users`, roles/permissions, site↔user pivot. The platform registry.
- **Tenant DBs** (`site_{slug}`): everything a site owns — `galleries`, `media`, `submissions`. No `site_id` columns needed here; isolation is by connection. Cross-site queries are *physically impossible*, so an application scoping bug has nothing to leak.
- **Domain resolution:** `domains` table in landlord (`hostname` unique, `site_id`, `is_primary`, `redirect_to_primary` bool). A `ResolveSite` middleware (web group, runs first) matches the request host, binds the `Site` singleton, **configures the `tenant` connection to that site's database**, and 404s unknown hosts. Non-primary domains 301 to the primary when flagged.
- Tenant models declare `$connection = 'tenant'`; landlord models use the default connection. Never point a tenant model at the landlord connection or vice versa.
- **Migrations:** tenant migrations live in `database/migrations/tenant/`; `php artisan tenants:migrate` loops every registered site (seconds each at this scale). `sites:create {slug}` provisions the database + runs tenant migrations. Landlord migrates normally.
- **Backups:** per-database dumps — the same operational pattern as the existing nightly `sqldump.sh`. spatie/laravel-backup configured to include all `site_*` databases.
- Local dev: seed `site-a.test`, `site-b.test` style hosts; document `/etc/hosts` or Herd/Valet setup in README.
- Artisan commands accept `--site=` wherever site context matters.
- A `config/legacy.php` map registers each legacy site's import sources: legacy `pgsql` connection settings + S3 bucket name, keyed by site slug. (The legacy platform had one DB and one bucket *per site* — importers and the flattener connect per-site.)

## 4. Sites-as-Code (replaces v1's theme system)

Each site is a directory: `resources/sites/{site-slug}/` containing:

- `pages/` — one Blade template per public page, path-preserving: `pages/home.blade.php` serves `/pages/home`, nested paths mirror URL paths. These are the flattened legacy pages (§6).
- `partials/` — shared fragments factored out during flattening where obviously repeated (header, footer, `<head>`), at the flattener's discretion — sharing is an optimization, not a requirement.
- `site.json` — manifest: site name, page list (slug → template) if not purely convention-derived, form config defaults, notes.
- Static assets live in `public/sites/{site-slug}/` (css/js/img/webfonts captured from the legacy deployment). References inside flattened pages are rewritten to `/sites/{site-slug}/...`. Asset URLs are not SEO-relevant; page URLs are, and those never change.

Per-site views are registered under a view namespace (e.g. `site::pages.home`) resolved from the bound Site. Pages are code, deployed via git — **clients cannot alter markup at all**. This is the design-protection boundary, now total.

**New-build sites** (sites created directly on SiteHub, starting with the pilot) use the same directory convention but are not bound by legacy baggage: clean **root-level slugs** (`/about`, home served at `/`), hand-authored Blade pages, and the platform Vite build (Tailwind v4 + Alpine, one entry per site) instead of captured legacy assets. Only *flattened* sites keep the `/pages/{slug}` scheme and their snapshot CSS/JS.

**Kept from legacy S3:** absolute `https://{bucket}.s3...amazonaws.com/...` image URLs embedded in flattened pages continue to work — legacy buckets are retained read-only (§16 open decision on long-term consolidation). CDN-loaded libraries (jQuery, Slick, Fancybox, Google Fonts) may remain CDN-loaded in flattened pages; note this as an accepted availability risk, cleaned up per-site later.

## 5. Content Model (core tables — deliberately small)

**Landlord DB:**
- `sites` — name, slug, `features` (jsonb array of enabled feature keys — see §5a), settings (jsonb: contact info, form recipients/subject, analytics snippet, locale, notes)
- `domains` — as §3
- `users` — global users; site access via `site_user` pivot. Roles via spatie/permission with **team feature enabled** (team = site): `super_admin` (Webriculture, all sites), `site_admin` (the client role — gallery management + submission viewing for their site)

**Tenant DB (per site):**
- `galleries` — slug, title, optional description; photos attached via **spatie/laravel-medialibrary** (S3 disk, conversions: `thumb`, `medium`, `large`, `webp`; manual ordering preserved)
- `media` — medialibrary's table, per tenant DB
- `submissions` — form_key, payload (jsonb), created_at. Stored form posts (§9).

**There are no pages, sections, blocks, menus, redirects, or revisions tables.** Pages are files; navigation is baked into the flattened templates; URLs don't change so no redirect mapping is needed; page history is git history.

## 5a. Features — first-party "plugins" without the plugin hell

Optional capabilities are **features**: platform modules written once in the monorepo, tested once, shipped to every deploy, but **enabled per site** via the `sites.features` array (e.g. `["galleries", "forms"]`). This is the deliberate answer to the WordPress plugin experience — same per-site flexibility, but every "plugin" is first-party code riding the shared upgrade train. Rules:

- A feature is a self-contained module: migrations (tenant), routes/components, admin resources, tests. Disabled = its routes 404, its admin resources hidden, its components render nothing.
- **Galleries (§8) and Forms (§9) are features #1 and #2.** Future candidates: slides/hero editing, blog — built only against concrete client demand.
- **Platform-layer concerns are NOT features and are never per-site:** accessibility baseline, cookie consent / privacy compliance, security headers, asset deployment/caching structure, sitemap/robots. Uniform everywhere, always on, one implementation — for sanity.
- **Membership rule (the commodity tier):** a site in SiteHub rides the shared upgrade train and expresses per-site needs only through features. A site needing a different stack, frozen versions, or heavy bespoke server-side work *graduates out* (WordPress, bespoke app) via the documented extraction path: copy `resources/sites/{slug}/` + `public/sites/{slug}/`, dump its tenant DB, export gallery media. Divergence is handled by exclusion, not accommodation — small custom features live inside the feature system; big ones live outside SiteHub.

## 6. Flattening Pipeline (the migration story)

A per-site, one-time, semi-automated process. Build `php artisan legacy:flatten {site}` as an *assistant*, not a guarantee — every page gets human/agent visual QA afterward.

The flattener is **DB-aware and crawl-based**:

1. **Enumerate** pages from the legacy site's DB (`pages` table: slug, published) via the per-site legacy connection.
2. **Capture** each page's rendered HTML as a *guest* (no auth — avoids inline-editor chrome).
3. **Strip** known junk (see disposition table below): cart/login UI, inline-editor JS (`inline_editor.js`, `clickable_sections.js`, CKEditor/Dropzone CDN loads), the `check_for_new_content` polling, `.editable` class attributes, CSRF-dependent fragments.
4. **Localize assets:** download same-host assets (`/css/app.css`, `/themes/{t}/css/style.css`, `/js/*`, `/img/*`, `/webfonts/*`) into `public/sites/{slug}/` and rewrite references. Leave legacy-S3 absolute URLs and CDN library URLs untouched.
5. **Swap dynamic islands**, located via the legacy `sections` table (not HTML guesswork — `sections.type` + `sections.html` payload identify them precisely):
   - `gallery_grid` / `gallery_carousel` / `gallery_singleimage` (payload = gallery id) → `<x-site-gallery slug="..." mode="grid|carousel|single">`
   - `form` (payload = form id) → `<x-site-form key="...">`
6. **Report** manual-review items per page: custom theme sections with data dependencies (e.g. theMarbleCenter `section_two` reads legacy gallery IDs 4/5/6 — decide per instance whether those image strips stay gallery-driven or get baked in), forms with conditional-logic fields (simplified per §9, needs sign-off), any section type not in the disposition table.

**Component DOM parity rule (critical):** `<x-site-gallery>` and `<x-site-form>` must emit the same DOM structure the legacy blades produced (`resources/views/sections/types/gallery_*.blade.php`, `form.blade.php` in the legacy repo), because the captured CSS and jQuery/Slick/Fancybox init code target that structure. Match markup first; improve later per-site.

**Legacy section-type disposition table** (every type accounted for):

| Legacy section type | Disposition |
|---|---|
| `content`, `plain_text`, `image`, `video`, `background_image`, `background_color`, `structure` (+ its DB-stored Tailwind layout classes) | Flattened inline — become static markup in the page template |
| `slider` | Flattened inline (slides rarely change; Slick init survives in captured JS). If a client needs slide edits, that's a future editable surface. |
| `gallery_grid`, `gallery_carousel`, `gallery_singleimage` | Replaced by `<x-site-gallery>` (day-1 editable) |
| `form` | Replaced by `<x-site-form>` (day-1 dynamic) |
| `menu_tabbed` | Flattened inline (navigation is code now) |
| `blog_post`, `event_rotator`, `biography_grid`, `list_products_by_category`, `featured_items_carousel` | Dropped modules (§15). If present on a live page, flag for content decision during that site's flatten. |
| Custom theme sections (`section_one`, `section_two`, …) | Flattened inline; gallery-dependent instances flagged for per-instance decision |

**URL preservation:** legacy `/pages/{slug}` URLs never change, so no redirects table is needed. One deliberate exception — the home page: legacy served `/` as a 302 to `/pages/home`; SiteHub serves the home page **directly at `/` (200)** and 301s `/pages/home` → `/`. The flattener rewrites internal home links to `/` so navigation never bounces through the redirect. All other slugs stay byte-identical. Restructuring a flattened site to root-level slugs is a per-site future cleanup, done with redirects at that time.

## 7. Public Rendering Pipeline

- `ResolveSite` → route lookup → site page template render → **response cache** (spatie/laravel-responsecache) for guest traffic, tagged per site. Target: cached pages serve in <50ms app time.
- Cache flush: saving a gallery (or site settings) flushes that site's tags. Nothing else on a flattened site is dynamic, so cache correctness is trivial — no request-time scheduling, no per-view composers (both were legacy anti-patterns; see Appendix A).
- Standard security-headers middleware.
- Per-site `sitemap.xml` (generated from the site's page template list) and `robots.txt` — both net-new; the legacy platform had neither.
- Themed 404 per site (flattened from the legacy site's error page or a simple branded fallback).

## 8. Gallery Management (the day-1 editable feature)

- Filament **Gallery resource**, site-scoped: create/rename galleries; upload, reorder (drag), retitle, and delete photos via medialibrary. This is the feature clients actually use routinely (e.g. The Marble Center's project photos).
- `<x-site-gallery slug mode>` renders the gallery server-side (good for image SEO) in legacy-parity DOM, using appropriate conversions (`thumb`/`medium` in grids, `large` in lightbox/carousel).
- Saving anything gallery-related flushes the site's response-cache tags.
- **`php artisan legacy:import-galleries {site}`** — pulls `galleries` + `galleryphotos` rows from the legacy per-site DB, downloads each photo's S3 object (`galleryphotos.src`), attaches via medialibrary preserving `sort_order` and titles. Idempotent: keyed on legacy photo id/source URL; re-runnable; prints a report (imported / skipped / failed).

## 9. Forms (day-1, minimal)

- One `POST /forms/{key}` endpoint per site (site-scoped): validates, checks **honeypot + Cloudflare Turnstile** (replacing legacy reCAPTCHA v3, which silently `exit`ed on failure with no user feedback — do not reproduce that), stores a `submissions` row, and emails the recipients configured in `sites.settings`.
- Standard non-AJAX POST with server-side validation errors and a rendered thank-you/flash state — simpler and more robust than the legacy jQuery/JSON flow.
- `<x-site-form key>` emits the site's contact-form markup (legacy-parity DOM/classes) pointing at the endpoint.
- Legacy conditional-logic form fields are **simplified to flat fields** during flattening; each affected form is flagged in the flatten report for client/Webriculture sign-off.
- Constant Contact opt-in integration is dropped (dead v2 API — do not port).

## 10. Admin Panel (Filament)

- Single panel at `/admin` on any site domain; all resources scoped through the bound site. Super admins get a site switcher.
- Resources: **Galleries** (with photo management), **Submissions** (read-only list/detail), **Users** (site_admin manages own site's users). Super-admin-only: **Sites**, **Domains**.
- **Route-level auth middleware + model policies are mandatory**, enforced in addition to Filament visibility. Two explicit lessons from the legacy app: admin security lived only in controller `authorize()` calls (guests got 403s instead of login redirects), and a data-import endpoint (`GET /migrate`) was publicly reachable. Never UI-only authorization; no unauthenticated maintenance routes, ever.
- Auth: Filament login, email password reset, optional 2FA (plugin choice — §16). No public registration (legacy had open registration routes; drop them).
- Dashboard: minimal — recent submissions, gallery counts.

## 11. Testing & Conventions ("ratchet" applies from day one)

Pest feature tests required with every phase:

- Tenant resolution: host → site; unknown host → 404; secondary domain → 301 to primary; the `tenant` connection points at the right database after resolution (and at nothing before).
- Isolation: site A's `site_admin` cannot see/edit site B's galleries or submissions — tested at the policy level AND by asserting tenant-connection separation (create a gallery as site A, prove it does not exist in site B's database).
- Feature gating: a disabled feature's routes 404 and its components render nothing.
- **Flattened-page smoke tests:** iterate every template under each site's `pages/` and assert HTTP 200 + no Blade errors on the matching URL.
- Gallery CRUD + response-cache invalidation (page reflects new photo after save).
- Form endpoint: valid post stores + mails; Turnstile/honeypot failure path returns a user-visible error (not a silent drop).
- Importer idempotency: running `legacy:import-galleries` twice produces no duplicates.

Conventions: strict_types, final classes by default, Laravel Pint (laravel preset) in CI; GitHub Actions runs pint + pest on PR. Factories for every model; a `DemoSeeder` creates 2 demo sites with sample flattened pages, galleries, and a form — doubles as the manual QA environment. Maintain `CLAUDE.md` at repo root: stack decisions, "never bypass SiteScope," component DOM-parity rule, flatten conventions, test-before-merge.

## 12. Per-Site Migration Runbook (repeat per legacy site — applies from Phase 4)

0. **Client communication first:** before any migration work, confirm with the client which tools they actually use (galleries? forms? anything else?) and make sure those surfaces exist on SiteHub before their site moves. No client migrates until the tools they need are in place.
1. Register the site + domains in SiteHub; add its legacy connection/bucket to `config/legacy.php`.
2. Run `legacy:flatten {site}`; work the manual-review report (custom sections, conditional forms, dropped-module remnants).
3. Run `legacy:import-galleries {site}`; verify counts against legacy admin.
4. Deploy; QA on a staging host with side-by-side visual comparison against the live legacy site, page by page. Tooling: a small **Playwright screenshot-diff script** (part of Phase 4 work) that captures every page on both hosts at 3 viewport widths and pixel-diffs the pairs — flatten sign-off is reviewing the diff images, not eyeballing pages.
5. Print the **dropped-data inventory** from the legacy DB (posts, events, biographies, submissions, orders counts) so nothing disappears silently; confirm with the client where relevant.
6. DNS cutover. Monitor.
7. Archive: final legacy DB dump stored; legacy S3 bucket set read-only and retained; legacy deployment decommissioned.

Legacy migration order (Phase 4 onward): internal/lowest-risk Webriculture site first to absorb turbulence, then theMarbleCenter and theQuarry, then the second server's sites — each gated by the step-0 client conversation.

## 13. Phases & Acceptance

- **Phase 1 — Platform core:** skeleton, tenancy (§3), sites-as-code serving (§4), response cache + security headers + sitemap/robots (§7), demo seeder, CI, tests green. *Accept:* two seeded demo sites serve distinct pages on distinct local hosts from one app, cached.
- **Phase 2 — Editable surfaces:** galleries (§8) and forms (§9) end-to-end: models, Filament resources, components with DOM parity, cache invalidation, importers, roles/policies. *Accept:* a `site_admin` on site A can reorder gallery photos and see the public page update, and cannot touch site B; a form post stores + emails; Turnstile failure shows a user-visible error.
- **Phase 3 — Pilot: a brand-new site built on SiteHub** (not a legacy port) — hand-authored pages, galleries, a form, launched on a real domain. Validates tenancy, admin, caching, and the day-1 surfaces with zero flattening risk. *Accept:* the new site is live in production on SiteHub with a client (or Webriculture) using the gallery admin.
- **Phase 4 — First legacy migration:** build the flattener + Playwright diff tooling; flatten the lowest-risk legacy site end-to-end per §12; runbook refined from the live experience. *Accept:* the site serves from SiteHub with visual parity and its legacy instance is decommissioned.
- **Phase 5 — Fleet migration:** remaining legacy sites on both servers, each preceded by the §12 step-0 client conversation; legacy platform fully retired.

## 14. Future Directions (explicitly uncommitted — do not build)

- **Constrained block editing** (spec v1's Filament Builder + typed jsonb blocks): the tenancy core, admin panel, and sites-as-code substrate are exactly what it would sit on. If a client demands editing, convert *that client's* pages to blocks — one site at a time, under real requirements — rather than migrating everyone through a CMS on day one. Slides/heroes are the likely first block candidates after galleries.
- **True static export / publish pipeline** — when client editing eventually arrives, the flow becomes "client saves → new version of the site is generated, JS/CSS fingerprinted/versioned, atomic deploy with rollback" (the Webflow/Netlify publish model). That is the point where real CI/CD investment lands; until then, response cache already gives static-like serving and deploys stay simple.
- **Per-site front-end cleanup** (drop jQuery/Slick/CDN deps, move to Tailwind v4 + Alpine) whenever a site's theme is deliberately redesigned — never as part of flattening.
- Re-adding dropped modules (blog, events, biographies, form builder) only against a concrete client need.

## 15. Non-Goals / Dropped Legacy Features

Out of scope for SiteHub, deliberately: e-commerce (the legacy cart/checkout/Stripe/Authorize.Net/promo-code/shipping/tax stack is vestigial — no migrating site sells online), Algolia/Scout product search, blog/publications + RSS feed, events calendar + ICS export, staff biographies, the dynamic form builder (fields/conditional logic/submission spreadsheets), Constant Contact, content scheduling (`contentschedules` recurrence), per-page role gating, inline on-page editing, the visual layout composer (DB-stored Tailwind classes), dashboard widgets, the policies module (legal pages flatten like any other page), menus-as-data, payments of any kind, multi-language, public user accounts, theme-editing UI, per-tenant databases. Do not add packages beyond §2 without approval.

## 16. Decisions Log & Remaining Open Items

**Resolved (July 2026, Chris):**

1. Repo name: **`sitehub`** (`webriculture/sitehub`, `App\` namespace).
2. 2FA: **Filament v4 built-in MFA** — no plugin. All dependencies MIT open source; no paid plugins (§2 licensing note).
3. Hosting: **AWS EC2**, simple deploys (git pull / Deployer). GitHub Actions runs tests only for now; the build/publish/asset-versioning pipeline is deferred to the future client-editing phase (§14).
   **Deploy blast-radius mitigation (chosen over two-ring rollout):** CI runs the full per-site smoke suite before any deploy, and deploys are atomic with one-command rollback (Deployer release/symlink style). A bad deploy can briefly affect all sites; the answer is catching it pre-deploy and reverting in seconds.
4. Pilot: **a brand-new site built on SiteHub** before any legacy port (§13 Phase 3). Legacy clients are contacted before their migration to confirm needed tools exist first (§12 step 0).
5. Home URL: serve `/` directly (200), 301 `/pages/home` → `/` (§6).
6. Flatten QA: Playwright screenshot-diff script (§12 step 4).
7. Tenancy topology (values discussion, 2026-07-13): **one checkout + landlord/database-per-site** (§3) — hard isolation was non-negotiable; single-schema logical scoping rejected. Deploy safety = CI smoke tests + atomic rollback (no two-ring rollout at this scale).
8. Per-site variation happens **only** through the first-party feature system (§5a); compliance/platform concerns stay uniform; real divergence = the site lives outside SiteHub.

**Still open (low stakes, decide when relevant):**

1. Which new site is the Phase 3 pilot.
2. S3 long-term topology: new uploads go to one new platform bucket with per-site prefixes; legacy buckets stay read-only. Open bit: whether/when to consolidate legacy-embedded URLs into the new bucket (recommend: opportunistically, per-site, never as a blocking step).
3. FontAwesome Pro license status check before Phase 4 (§2).

---

## Appendix A: Legacy Platform Reference (from the July 2026 audit of the live theMarbleCenter deployment)

Condensed so future agents don't re-derive it. Paths refer to the legacy repo.

**Architecture.** One codebase (`webriculture/laravelcms`), deployed per site; per-deployment Postgres DB + S3 bucket; theme fixed by `THEME_NAME` env, activated via `Theme::set()` in `AppServiceProvider` (igaster/laravel-theme used for view fallback only; front-end asset scoping via `ASSET_URL` + `mix()`). No parent-theme inheritance (`extends: ""` in every `theme.json`); "shared base" = fallback views in `resources/views/*` plus a global `app.css` (`resources/sass/_webricultureBase.scss` + `_pages-section-types`, `_form-themes`, `_galleries`). Laravel Mix builds one theme per deployment (`MIX_THEME_NAME`); Tailwind 1.x, unpurged.

**Page model.** `pages` (title, slug unique w/ auto-dedupe `-{id}`, `layout` column selecting the extended layout, published, softDeletes; `Page` uses spatie `HasRoles` for per-page gating) → `sections` self-referential tree (`parent_id`, root = 0, `sort_order`): `structure` containers + typed content sections. Layout is data: columns `width`, `width_sm..xl`, `hide*`, `padding`, `flex`, `flex_direction`, `justify_content`, `align_items`, `flex_wrap`, `css_classes` hold literal Tailwind class strings concatenated into wrapper divs. Render chain: `/pages/{slug}` → `PagesController@show` → `pages/show.blade.php` → `sections/display_types.blade.php` `@switch` → `sections/types/{type}.blade.php` (+ recursion partial). `/` 302-redirects to `/pages/home`.

**Section payload (`sections.html`) by type:** `content` = raw HTML (CKEditor); `plain_text` = text; `image` = image URL; `background_color` = color; `background_image` = JSON {image, position}; `video` = embed markup; `form` = form id; `gallery_grid|carousel|singleimage` = gallery id; `list_products_by_category` = category id; `slider` / `event_rotator` = CSV of slide ids; `blog_post` = JSON {blog_id, post_id | 'most_recent_post' | 'all_posts'}; `menu_tabbed` = JSON {menu_id, menuitem_id}; `structure` / `featured_items_carousel` = empty. Custom theme sections (per-theme `sections/{id}/manifest.json` + create/edit/show blades, runtime-scanned by `Sectiontype::get_types()`) store field data as JSON in `sectioncontents` key/value rows. theMarbleCenter defines `section_one` (heading + paragraph) and `section_two` (three review cards; hardcodes gallery IDs 4/5/6).

**Other data.** `pagehistories` = full JSON snapshot of page + sections on every edit (author hardcoded to user 1; restore deletes and recreates sections). `menus` (title) + `menuitems` tree, wired to header/footer via settings (`main_menu_id` etc.). `galleries` + `galleryphotos` (src URL, sort_order). Forms engine: `forms` → `fields` (type, options JSON, `conditions` JSON conditional logic, confirmation-email flag) → `submissions` → `submissionvalues`; reCAPTCHA v3 (threshold 0.8, silent `exit` on failure); convention-named fields feed Constant Contact. Modules: blogs/posts/tags (+`/feed` RSS), events (+ICS), biographies, slides, policies, `contentschedules` (request-time recurrence visibility), `dashboardwidgets`. Full commerce: items/specifications/categories, orders (inline billing/shipping blocks, Stripe or Authorize.Net chosen per-site in `global_settings`), promocodes + pricing breaks, shipping regions, CA-only 7.25% tax, Algolia item search + search-history logging. Settings split between env-backed `config('app.*')` and the `global_settings` table — and duplicated as hardcoded values in theme partials (contact/social/logo).

**Media.** No media table (a polymorphic `images` table was created then dropped; `App\Image` is dead code). `UploadTrait`: Intervention orientate + resize to a single 1920px-wide variant → S3 `img/{domain}/{id}/...`; the resulting URL string is stored on the owning row or embedded in HTML.

**Cautionary list (do not reproduce).** No route-level auth on admin (controller `authorize()` only; guests get 403 not login); publicly reachable `GET /migrate` import endpoint; `$guarded = []` on every model; global `View::composer('*')` running cart/menu/category queries on every view including emails; inline CKEditor editing on live pages; DB-stored Tailwind classes (unpurgeable CSS, schema coupled to Tailwind 1.x); relation methods that call `->get()` internally (not eager-loadable); duplicate route name `galleries.edit`; `class field` declared lowercase; dead job referencing a nonexistent mailable; empty console kernel (no backups, no cron); all-CDN front-end dependencies; reCAPTCHA failures silently `exit`ing.

**Live-site dynamic surface after v2 scope cuts:** galleries and contact forms. Everything else flattens or gets stripped (cart chrome, login links, editor JS, `check_for_new_content` polling).
