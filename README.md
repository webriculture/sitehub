# SiteHub

Webriculture's multi-tenant successor to `laravelcms` — client sites as Blade templates, one app, many domains.

One Laravel 13 application hosts every site: a request's hostname resolves to a **Site**, which selects its own **database** (hard isolation, one Postgres DB per site) and its own **page templates** (`resources/sites/{slug}/`). Pages are code, deployed via git; full-page response caching makes brochure sites serve like static files. Clients edit only through deliberately built surfaces — galleries first.

- **Full specification:** [docs/sitehub-spec.md](docs/sitehub-spec.md)
- **Adding a new client site:** [docs/adding-a-site.md](docs/adding-a-site.md)
- **Agent conventions:** [CLAUDE.md](CLAUDE.md)

## Local development

Requirements: PHP 8.4, Composer 2.7+, PostgreSQL 16, Node 20+.

```bash
composer install
cp .env.example .env          # point DB_* at your Postgres, then:
php artisan key:generate
createdb sitehub              # or your preferred way to create the landlord DB
php artisan migrate
php artisan db:seed           # provisions the demo sites (local env only)
```

Add the demo hosts to `/etc/hosts`:

```
127.0.0.1  site-a.test www.site-a.test site-b.test
```

Serve and browse:

```bash
php artisan serve
curl -H "Host: site-a.test" http://127.0.0.1:8000/
```

The Postgres role needs `CREATEDB` — each site gets its own tenant database (`site_{slug}`), provisioned by `sites:create`.

## Everyday commands

```bash
php artisan sites:create fransalem --name="Fran Salem"   # provision a site
php artisan sites:domain fransalem fransalem.com --primary
php artisan sites:feature fransalem galleries forms
php artisan tenants:migrate                              # migrate every tenant DB
```

## Tests & style

```bash
php artisan test      # Pest — includes a smoke test over every site's pages
vendor/bin/pint       # Laravel preset; CI enforces both
```

Tests run against `sitehub_test`; tenant test databases are prefixed `test_site_` and cleaned up automatically.
