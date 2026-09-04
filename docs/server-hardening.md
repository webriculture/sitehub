# Server Hardening — Shared Box Isolation Model

Follow-up to the July 2026 WordPress incident. The pattern that survived that
attack — deploy user owns the code, the runtime user can't write it — is now
implemented for SiteHub on this box and documented here as the rollout target
for every legacy site. One-line rule: **a web runtime may write its own
runtime dirs and nothing else, and code changes only ever arrive as deploys.**

## What is implemented for SiteHub (2026-07-24)

### 1. Dedicated runtime user + pool

- OS user `sitehub` (system account, `nologin`, no home). Never `www-data`.
- php-fpm pool `/etc/php/8.4/fpm/pool.d/sitehub.conf`: runs as `sitehub`,
  socket `/run/php/php8.4-fpm-sitehub.sock` (owner `www-data` so nginx can
  connect), and `disable_functions` on all process-execution primitives —
  the web runtime never legitimately spawns a process (`MAIL_MAILER` needs
  no sendmail). CLI/artisan is unaffected (runs as the deploy user).
- The three SiteHub vhosts (`fransalem.webriculture.com`,
  `mid-valleyparenting.org`, `ht.demo.webriculture.com`) point at this
  socket. New SiteHub domains must too — it's part of the shared shape.

### 2. Ownership model

| Path | Owner | Runtime (`sitehub`) | `www-data` / others |
|---|---|---|---|
| code (everything not below) | `ubuntu` (deploy) | read+execute (ACL `u:sitehub:rX`, incl. default ACLs for future files) | read via `other` (nginx statics), **no write** |
| `storage/`, `bootstrap/cache/` | `ubuntu`, group `sitehub` | read+write | **none** (`o-rwx`, no ACLs) |
| `.env` | `ubuntu:sitehub` `640` | read-only | none; `u:dlux:rw` ACL for Dave |

- Both deploy users (`ubuntu`=Chris, `dlux`=Dave) may own files in the
  checkout; the runtime user owns nothing outside `storage/`+`bootstrap/cache`.
- If `php artisan config:cache` is ever used in production, the cached
  config in `bootstrap/cache/` contains the decrypted secrets — that dir is
  already `o-rwx`; keep it that way.
- If `php artisan storage:link` is ever created (public media disk), grant
  nginx narrow read back: `u:www-data:rX` on `storage/app/public` (recursive
  + default) and `u:www-data:--x` traverse on `storage/` and `storage/app/`
  only.

### 3. Writable paths are not web-executable

Each SiteHub vhost refuses PHP under the upload path before the generic PHP
location: `location ~ ^/storage/.*\.php$ { return 404; }`. A dropped shell in
a writable dir is a dead file, not an entry point.

### 4. Tamper tripwire (cron, every 10 min)

`/usr/local/bin/webroot-tripwire` (config `/etc/webroot-tripwire.conf`,
state `/var/lib/webroot-tripwire/`, log `/var/log/webroot-tripwire.log`,
cron `/etc/cron.d/webroot-tripwire`):

- **git drift** — `git status --porcelain` (with `--no-optional-locks`) in
  every checkout under `/var/www`; this is the detector that caught the
  marble `index.php` drop.
- **ownership drift** — files in a configured code root not owned by a
  listed deploy user (runtime-writable dirs excluded).
- Alerts fire on **changes** to the drift fingerprint, so chronic
  working-tree noise alarms once, not every 10 minutes. Alerts go to the
  log + syslog (`auth.warning`, tag `webroot-tripwire`) and stdout — cron
  will email `MAILTO` once an MTA exists on the box (none today).
- After a deploy or intentional working-tree change, the next run alerts
  once; that's the expected acknowledgment cost.

## Rollout runbook for legacy sites (not yet done)

Per site, in this order (template = what was done for SiteHub):

1. `useradd -r -M -s /usr/sbin/nologin site_<name>`
2. Pool file in the right PHP version's `pool.d/`: user `site_<name>`,
   socket `/run/php/php<ver>-fpm-<name>.sock`, `listen.owner www-data`,
   copy `disable_functions` unless the site provably shells out (WP mail
   via SMTP plugins doesn't; `wp-cron` spawned via fpm doesn't).
3. Ownership: deploy user owns code; only runtime-writable dirs
   (`wp-content/uploads`, cache dirs) get `u:site_<name>:rwX` + defaults;
   `wp-config.php` (or `.env`) `640` deploy-owner:runtime-group.
4. nginx: swap `fastcgi_pass` to the new socket **and** add the
   uploads-are-not-executable rule
   (`location ~ ^/wp-content/uploads/.*\.php$ { return 404; }`).
5. Check the site's cron jobs: anything running as `www-data` for this site
   moves to `site_<name>` (see `crontab -u www-data -l` — harristhermal's
   `wp hcp poll` is one).
6. Add the site to `/etc/webroot-tripwire.conf` (git checkouts are picked
   up automatically; the ownership line is per-site).
7. Verify: site renders; `sudo -u site_<name> test -w <code>` fails;
   `sudo -u www-data test -r <secrets-file>` fails.

**Priority order:** `kft.neednavigator.com` first (Need Navigator fronts
sensitive data and currently shares the 8.1 pool with every WordPress site
on the box), then externally-facing WordPress sites, then the rest. Do a
couple per maintenance window; each is ~15 minutes with the template.

## Process anomaly detection (blocked on per-site users)

Per-site users make process ancestry a high-signal alarm: `site_marble`
should only ever run `php-fpm`, so `sh`/`curl`/`wget`/`nc` under that uid is
an incident, full stop. Under shared `www-data` the signal drowns.

- auditd is **not installed** yet. Once per-site users exist:
  `apt install auditd` and one rule per site user, e.g.
  `-a always,exit -F arch=b64 -S execve -F uid=site_<name> -k web-exec`.
  SiteHub's pool already blunts this class by disabling exec primitives in
  PHP — auditd then watches for anything that slips around PHP.

## Secrets scoping (findings #5, mostly pre-existing in SiteHub)

- SiteHub: per-site secrets live encrypted (per-site rows, `encrypted:array`)
  in the landlord DB; set via `sites:secret` (hidden prompt — see
  [adding-a-site.md](adding-a-site.md)). A contained SiteHub breach still
  only yields secrets the app itself can decrypt — the layer that bounds
  blast radius here is the per-site *upstream* scoping: one Need Navigator
  token per site, scoped server-side to that site's data.
- Legacy S3: per-site IAM users with per-bucket policies (the
  legacy-laravel-s3 thread) — do alongside the pool rollout so a popped
  site yields one bucket's creds, not the fleet's.

## Explicitly out of scope / still open

- No MTA on the box — tripwire alerts reach log + syslog only. Wire
  Postfix-with-relay (or a webhook alerter) if email alerts are wanted.
- Legacy per-site pool rollout itself: coordinate with Dave; several sites
  have live working-tree drift the tripwire baselined on day one
  (`dentalhealthguides`, `harristhermal` — including an untracked
  `wp-content/`, `mgs`, `themarblecenter`, `thequarry`, `wine.compassvisual`)
  — reconcile those trees (commit or clean) so git drift returns to zero
  meaning "tampering".
