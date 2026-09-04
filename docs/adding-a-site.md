# Adding a New Client Site to SiteHub

The platform work for a new site is **minutes**; the real time goes into designing and authoring pages. This runbook covers a *new-build* site (like fransalem.com). Migrating a legacy laravelcms site has its own runbook: [sitehub-spec.md §12](sitehub-spec.md).

Commands marked **(P2)** arrive with the Phase 2 admin panel — until then the equivalent is a seeder/tinker one-liner.

---

## What you DON'T do (the whole point)

- ❌ No new checkout, folder-per-site, or `composer install`
- ❌ No separate `.env`, vendor tree, or Laravel upgrade schedule
- ❌ No separate backup setup — tenant databases are auto-included
- ❌ No per-site security patching — the site rides the shared train

## 1. Create the site — one command

```bash
php artisan sites:create fransalem --name="Fran Salem"
```

This provisions everything:
- `sites` row in the landlord database
- a fresh tenant database (`site_fransalem`) with tenant migrations run
- starter skeleton at `resources/sites/fransalem/` (pages/, partials/, site.json) and `public/sites/fransalem/` (assets)

## 2. Point domains at it

```bash
php artisan sites:domain fransalem fransalem.com --primary
php artisan sites:domain fransalem www.fransalem.com --redirect
```

For local dev, also add a `.test` host to `/etc/hosts`:
```
127.0.0.1  fransalem.test
```
```bash
php artisan sites:domain fransalem fransalem.test
```

## 3. Enable the features this client needs

```bash
php artisan sites:feature fransalem galleries forms
```

Features are first-party modules (our "plugins") — enabling one turns on its routes, components, and admin surface for this site only. Platform concerns (security headers, cookie consent, accessibility baseline, caching, sitemap/robots) are always on and are not configurable per site.

### Integration secrets (only if a feature needs one)

Some features consume an external API — e.g. `events` polls the Need Navigator feed and needs that site's bearer token. Secrets live encrypted in the landlord database (never in `.env`, git, or logs) and are set via a hidden prompt:

```bash
php artisan sites:secret fransalem need_navigator_token   # prompts for the value; input hidden
php artisan sites:secret fransalem need_navigator_token --unset   # remove
```

Never pass the value as an argument or paste it into `tinker` — the hidden prompt exists to keep secrets out of shell history, process listings, and the psysh history file. Rotation is: mint the new credential upstream → `sites:secret` here → revoke the old one upstream ([need-navigator-events.md §5](need-navigator-events.md)).

## 4. Build the pages (the actual work)

Author Blade templates in `resources/sites/fransalem/pages/` — `home.blade.php` serves `/`, `about.blade.php` serves `/about`, subdirectories map to URL paths. AI-assisted dev happens here; every content change is a git commit, so **git history is the page history**. Site assets (Tailwind entry, images) live with the site and build through Vite.

Dynamic islands drop in as components:
```blade
<x-site-gallery slug="projects" mode="grid" />
<x-site-form key="contact" />
```

### Site-specific docs live with the site

The repo root and `docs/` stay **tenant-agnostic** — platform docs only. Anything that belongs to one client site (a product feature inventory, content/claims constraints, a site plan, build notes, an image manifest, open questions) goes in that site's own docs folder:

```
resources/sites/{slug}/docs/    # e.g. resources/sites/neednavigator/docs/FEATURES.md
```

Nothing routes or ships from there — pages are served only from `pages/`, and the sitemap scans only `pages/` — so the folder is purely for humans. The payoff: the site's whole story (what may be claimed, why decisions were made, what's left to launch) travels with the site, and deleting or handing off a site takes its paperwork with it.

## 5. Seed content & settings

- Create galleries and upload photos via the admin panel **(P2)** — or `tinker` until then.
- Set form recipients/subject, locales, and the per-org Need Navigator host with `php artisan sites:setting {slug} {key} {value} [--json]` (e.g. `sites:setting fransalem need_navigator_url https://fran.neednavigator.com`; `--json` for arrays like `form_recipients`, `--unset` to remove). Admin UI **(P2)**.

## 6. Client access (only if they need it)

Invite the client user and grant `site_admin` **on this site only** **(P2)**. That role sees: their galleries, their form submissions. Nothing else exists for them.

## 7. Test before launch

```bash
php artisan test
```

The smoke suite auto-discovers every site's pages and asserts they render — your new site is covered the moment its files exist. CI runs the same suite on every PR, and nothing deploys without it passing.

## 8. Go live

1. Merge + deploy (atomic; one-command rollback if anything smells wrong).
2. Add the nginx server block — every SiteHub domain uses the **same shared snippet** pointing at `/var/www/sitehub/public`; only the `server_name` changes.
3. `certbot --nginx -d fransalem.com -d www.fransalem.com`
4. Cut DNS over.
5. Verify: `/` renders, `www.` 301s to the primary domain, `/sitemap.xml` + `/robots.txt` respond, a test form submission arrives by email, gallery pages show photos.

## 9. Aftercare

- Add the domain to uptime monitoring.
- Done. Ongoing content edits = git commits; gallery/photo updates = the client's admin; everything else is the platform's problem, once, for everyone.
