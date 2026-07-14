# SiteHub

Multi-tenant hub serving Webriculture client sites as code. One Laravel app, one checkout, many domains. Full spec: [docs/sitehub-spec.md](docs/sitehub-spec.md). New-site runbook: [docs/adding-a-site.md](docs/adding-a-site.md).

## Stack (fixed — do not substitute)

- Laravel 13, PHP 8.4, `declare(strict_types=1)` in every file, `final` classes by default
- PostgreSQL 16: **landlord database + one database per site** (hard isolation, a values decision — never collapse to shared-schema `site_id` scoping)
- Blade + anonymous components; Alpine.js only where needed; Pest for tests; Pint (laravel preset)
- Add no composer packages beyond the spec's list without flagging for approval

## Architecture invariants

- **Pages are code.** Site pages live in `resources/sites/{slug}/pages/*.blade.php`, assets in `public/sites/{slug}/`. URL path maps to template path (`/about` → `pages/about.blade.php`, home = `pages/home.blade.php`). No pages/menus/blocks tables — git history is page history.
- **Tenant vs landlord:** models in `App\Models\Tenant\*` declare `$connection = 'tenant'` and only work after `App\Tenancy\Tenancy::makeCurrent($site)` (done per-request by `ResolveSite` middleware). Landlord models (`Site`, `Domain`, `User`) use the default connection. Never cross these.
- Tenant migrations live in `database/migrations/tenant/` and run via `tenants:migrate` (loops all sites). Landlord migrations run normally.
- **Features** (`sites.features` jsonb, keys registered in `config/sitehub.php`) are first-party modules enabled per site. Platform concerns (security headers, robots/sitemap, caching, accessibility) are always-on and never per-site.
- Flattened legacy sites keep their `/pages/{slug}` URLs verbatim; `/pages/home` 301s to `/` platform-wide. Never "improve" flattened markup or URLs outside a deliberate redesign.
- `<x-site-gallery>` / `<x-site-form>` components must emit DOM structurally identical to the legacy blades (captured CSS/JS targets it).

## Commands

- `sites:create {slug} --name=` — provision site (landlord row + tenant DB + skeleton); idempotent
- `sites:domain {slug} {hostname} --primary|--no-redirect`
- `sites:feature {slug} {features...} [--disable]`
- `tenants:migrate [--site=] [--fresh]`

## Testing rules

- Tests are required with every change; run `php artisan test` before any commit (`vendor/bin/pint` too).
- Tests needing real tenant DBs use `Tests\Concerns\ProvisionsSites` (+ `afterEach(fn () => $this->cleanupProvisionedSites())`) — tenant test DBs are prefixed `test_site_` and must be dropped.
- The smoke test auto-discovers every committed site's pages; adding a page file adds coverage automatically.

## Local dev

DB is PostgreSQL 16 on port **5433** on this box (production 14 runs on 5432 — leave it alone). Demo hosts `site-a.test` / `site-b.test` via `/etc/hosts`, seeded by `php artisan db:seed`.
