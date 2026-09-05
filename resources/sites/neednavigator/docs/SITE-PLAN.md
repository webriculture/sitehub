# SITE-PLAN.md — neednavigator.com v2 on SiteHub

Status: **Approved by Dave 2026-07-24 — Step 2 in progress.** Feature sync 2026-09-04: see §8 for the copy backlog from the July/August 2026 releases. Decisions recorded: 16 feature pages ✓; primary domain www.neednavigator.com ✓; reuse the platform Turnstile widget ✓; mail stays `log` for now (real transport remains a launch item); backup claims expanded per [BACKUP-CLAIMS.md](BACKUP-CLAIMS.md) (verified 2026-07-23 — binding, same standing as FEATURES.md).
Sources: [FEATURES.md](FEATURES.md) (authoritative, incl. Decisions & Answers #1–20), [BACKUP-CLAIMS.md](BACKUP-CLAIMS.md), the build brief (2026-07-24), a crawl of the current live www.neednavigator.com, and SiteHub platform/conventions research. This plan passed an adversarial verification pass (constraint compliance, module coverage, SEO) and incorporates its findings.

One deliberate deviation from the brief, approved: the brief suggested ~10–14 feature pages; this plan has **16**. Verification showed 14 forced two problems — a "casework" page carrying six modules under one keyword, and Billing (the successor to the current site's headline HRSN-billing claim) buried in a parenthetical where no billing-intent buyer would find it.

---

## 1. Stack decision

**A SiteHub site, slug `neednavigator`, following the FRAN conventions.** This is the platform the site will be maintained on, and it satisfies every non-negotiable in the brief:

- **Effectively static:** Blade pages served through Spatie full-page response cache (cache hits skip even tenant resolution). No client-side rendering.
- **Copy is plain text:** every page is one `resources/sites/neednavigator/pages/*.blade.php` file; git history is page history.
- **Hand-rolled CSS with tokens:** one `public/sites/neednavigator/css/site.css`, design tokens as CSS custom properties in `:root`. No framework, no build step (matches actual practice — FRAN/MVP serve plain CSS; the Vite mention in adding-a-site.md is stale).
- **JS:** one deferred vanilla IIFE (`public/sites/neednavigator/js/site.js`) for mobile nav toggle + FAQ accordions only. Accordions are `<details>/<summary>` (fully functional without JS). Nav is server-rendered and reachable without JS.
- **Dynamic islands:** only `<x-site-form key="demo" />` on /contact (forms feature). Its `.sh-form__*` DOM is styled, never altered.
- **Included platform components:** `<x-accessibility-toolbar />` + `<x-scroll-to-top />` (required on every SiteHub site).

### Provisioning (once approved)

```bash
php artisan sites:create neednavigator --name="Need Navigator"
php artisan sites:domain neednavigator www.neednavigator.com --primary   # registered now; DNS moves later
php artisan sites:domain neednavigator neednavigator.com                 # apex → 301 to www
php artisan sites:domain neednavigator nn.webriculture.com --no-redirect # staging serves 200s
php artisan sites:feature neednavigator forms
```

Registering the real primary domain **now** (DNS untouched) makes nn.webriculture.com a non-primary host from day one. **Honest caveat found in verification:** the platform's current protection for non-primary hosts is a robots.txt `Disallow: /` — which blocks *crawling* but does not reliably prevent URL-only *indexing* (and it hides our cross-host canonicals from Google). The fix is a small platform change (§6): send `X-Robots-Tag: noindex, nofollow` on all non-primary-host responses and allow crawling there so the header is actually seen. Canonical/OG URLs point at `https://www.neednavigator.com/...` even on staging — correct at cutover, harmless before it. `www` as primary: **confirmed by Dave 2026-07-24.**

### Typography & palette (tokens finalized in Step 2)

- Display serif: **Source Serif 4** (variable, latin + latin-ext woff2, self-hosted, preloaded). Deliberately not Fraunces — midvalleyparenting owns Fraunces in our portfolio.
- Body/UI sans: **Public Sans** (variable, self-hosted). Distinct from MVP's Inter; a civic-neutral face right for this buyer.
- Palette: warm near-white background, near-black ink, **deep evergreen** accent, one warm neutral surface tone. WCAG AA minimum everywhere, AAA for body text. Depth from type and spacing; hairline borders; subtle consistent radius; motion = gentle fade/slide only, disabled under `prefers-reduced-motion`.

English only at launch (platform supports `/es/` later if ever wanted).

---

## 2. Sitemap — 28 pages

Keyword discipline: one primary long-tail keyword per **content** page, worked in naturally (H1/title/intro), never stuffed; no two pages targeting the same phrase *or the same search intent*. The two hub pages (/features, /solutions) are deliberately navigational — substantive intro copy, no competing keyword target, authority flows to their spokes.

### Top level

| URL | Page | Primary keyword | Feeds from FEATURES.md |
|---|---|---|---|
| `/` | Home — outcome-led hero, 3–4 pain→solution blocks, feature grid, compact audience router (links to /solutions/*), trust strip, demo CTA | nonprofit case management software | "What Need Navigator is"; differentiators from every module; trust strip: isolated per-agency instances/databases, encryption wording exactly per Decision #15, audit trail & access monitoring, transparent $25 pricing. Configurable dashboard v2 gets a featured moment here (ready to market, Decision #2) |
| `/features` | Feature hub — scannable module map grouped like Parts 1–6, with 100–200 substantive words per group (who it's for, what job it does) so it's a real guide, not a link farm | (navigational) | All Parts 1–6; includes entries pointing to /reporting and /security; carries the "configured to your agency" positioning line |
| `/reporting` | Reports + dashboards + exports (doubles as the "reports-dashboards" feature page) | funder reporting software for nonprofits | Part 6 Reports (builder, PII redaction levels, scheduled delivery, charts), Dashboards (home + configurable v2 — ready to market, Decision #2), Excel export (~16 record types), honest framing per Decision #14: HMIS-adjacent data model, "supports your funder reporting," no HUD/CSBG claims, no pre-built funder templates |
| `/security` | Security & trust (doubles as the "audit & access monitoring" feature page) — written for a board member and a funder questionnaire | case management data security | Cross-Cutting: isolation (own instance + private database, AWS, SSM), encryption exactly per Decision #15 (the one approved sentence, nothing more), RBAC (~80 permissions), record-level visibility, SSO/passkeys/per-user 2FA, IP access modes, Turnstile (fail-open), impersonation controls, session security; backups per BACKUP-CLAIMS.md (nightly per-database, encrypted in transit and at rest, integrity-verified every run with alerting, 35-day/13-month rolling retention, multiple independent locations, deletion-protected from production credentials — never "immutable"); Part 6 Audit Trail & Access Monitoring (8 suspicious-access rules — featured differentiator) |
| `/pricing` | $25/user/month, plainly; what's included; positioned against opaque enterprise pricing; FAQ (seats, instances, data ownership, onboarding, migration-as-a-service) | case management software pricing | Decision #16; Cross-Cutting per-seat licensing; "no bulk importer — migrations handled as services" stated honestly in FAQ |
| `/about` | Webriculture story — ~25 years in Salem, Oregon; built in partnership with the agencies that use it | (brand: Webriculture / Need Navigator) | Partnership-development narrative; features exist because caseworkers asked for them |
| `/contact` | Low-pressure demo request | case management software demo | `<x-site-form key="demo" />` (the platform's real backend, not a placeholder); phone numbers carried over from the current site |

### /features/&lt;module&gt; — 16 pages

Every page: H1, benefit-led intro, capabilities, one generic "day in the life" vignette (no real names), one stylized honest UI representation (HTML/CSS/SVG of a real capability only), 3–5 FAQ, cross-links, demo CTA.

| URL | Modules from FEATURES.md | Primary keyword | UI representation |
|---|---|---|---|
| `/features/client-records` | Individuals (configurable field layout, duplicate prevention + merge, data freshness, test records, photo/search); Client Alerts; Insurance; ROI | client records software for human services | One-page dossier with alert banner + radial quick-action menu |
| `/features/documents` | Documents & Files: client files (types, folders, team visibility), PDF merge, Document Inbox (Decision #12) — **not** Document Manager/partner sharing | client document management software | Document Inbox triage screen |
| `/features/households-care-team` | Households & Relationships; Care Team (caseload transfer) | household tracking software for social services | Household relationship matrix + address-sync prompt |
| `/features/income-eligibility` | Income & Program Eligibility (guided capture, verified vs self-reported, FPL/AMI engine) | income eligibility screening software | Eligibility verdict: household income vs program limit |
| `/features/emergency-assistance` | Needs & Emergency Assistance (status ladder, funding pools, disbursements, printable voucher) | emergency assistance tracking software | Printable voucher with eligibility math + funding-pool split |
| `/features/casework` | Visits (manager review); Goals & Case Plans; Notes, Messages & Threads; Tasks & Task Lists and Calendar as compact sections (meeting links as convenience, Decision #13) | case notes software for social services | Case-note thread with @mention + undo-window timer |
| `/features/billing` | Billing: auto-generation from visits/needs, insurance coverage-date validation, 8-minute rule, batching, Excel export — **claim preparation, never claim submission** (Decision #8); the HRSN reframe from the old site lands here (pending OPEN-QUESTIONS #7 on naming HRSN) | human services billing software | Billing batch: minutes→units under the 8-minute rule, coverage-date exclusions |
| `/features/programs-automation` | Programs & Enrollment (rule builder, episodes, program homepage); Smart Buttons; Automations; admin Settings hub (agency-maintained demographic answer sets + operational vocabularies — "no vendor request to change a dropdown") and per-user workflow defaults | program enrollment software for nonprofits | Smart Button composer |
| `/features/referrals-partners` | Referrals (QR loop closure); Organizations & Contacts; Partner Portal (Decisions #6, #18); Need Navigator Network (**capability agencies can opt into** — Decision #7) | referral tracking software for nonprofits | Printed referral with QR + loop-closure timestamp |
| `/features/forms` | Form Builder; Multilingual Forms & AI Translation (reviewed starting point, not a replacement for bilingual staff); form portability | nonprofit form builder software | Side-by-side EN/ES translation editor |
| `/features/intake-management` | Quick Forms (real-time grid); Submission-to-Client Matching; household capture | nonprofit intake management software | Live submissions grid with cell presence + match badges |
| `/features/public-intake-portal` | MyNeedNav Public Intake Portal | online application portal for social services | Portal form in a phone frame, "unverified" income tag on arrival |
| `/features/events` | Events (**no waitlists, no online payments** — registration, promo codes as discounts on recorded orders, QR check-in, self-service cancel by emailed code, donation pledges + offline recording); Website Event & Class Feed | nonprofit event registration software | Event page with capacity indicator + day-of check-in list |
| `/features/parent-education-classes` | Parent Education Classes (courses→offerings→sessions, verify-before-store, SMS/email reminders, enumeration-proof QR check-in, fidelity completion, certificates) — ready for prime time (Decision #5); prominent placement per brief | parent education class management software | Facilitator mobile attendance grid |
| `/features/shelters` | Shelters & Bed Reservations (floor-plan editor + AI drafting, bed-by-date matrix, family reservations, exit reasons) — **no HMIS CSV export claims** | homeless shelter bed management software | Bed-availability week matrix with occupant spans |
| `/features/geotracker` | GeoTracker — "market it hard" (Decision #11); PIT-count angle | street outreach tracking software | Clustered map with named places |

### /solutions — 5 pages

A slim `/solutions` hub (the audience router promoted to its own URL — one paragraph per audience + links) gives the four audience pages a structural parent and gives the legacy who-we-serve URL a legitimate redirect target. Audience pages map features to that audience's workflows and funding pressures.

| URL | Primary keyword | Leads with |
|---|---|---|
| `/solutions` | (navigational) | Which describes your agency? — router with a paragraph per audience |
| `/solutions/community-action-agencies` | case management software for community action agencies | Income/eligibility (FPL/AMI), needs & funding pools, demographics reporting "supports your funder reporting" (never HUD/CSBG-compliant), programs, audit trail |
| `/solutions/shelters-housing` | case management software for homeless shelters | Beds & floor plans, group check-in, exit reasons, GeoTracker/PIT, audit & access monitoring |
| `/solutions/food-banks-community-aid` | food pantry client tracking software | Needs/resource catalog, quick intake (grid + matching), households, referrals, events |
| `/solutions/parent-education` | case management for parent education programs | Classes end-to-end, bilingual forms, MyNeedNav, website feed, DV-survivor confidentiality protections |

Acronyms (HMIS, FPL, AMI, CoC, ROI, PIT) defined on first use per page. Voice per brief: plain-spoken, warm, specific; banned-word list enforced; `[TESTIMONIAL: …]` placeholders only — no fabricated quotes, stats, or client names.

---

## 3. Deliberately NOT on the site (binding)

- Event **waitlists**; **online payment processing / Stripe**; **Document Manager & partner document sharing**; **HMIS CSV export**.
- **HUD/CSBG compliance claims** of any kind. Allowed framing only: flexible report builder, HMIS-adjacent data model, breakdowns that *support* funder reporting, Excel export.
- **Electronic claim submission / clearinghouse** anything. Billing = claim preparation + Excel export.
- Blanket encryption claims. The two allowed scopes (per Decision #15 + BACKUP-CLAIMS.md): "client data is encrypted at rest on the application server," and backup-scoped encryption (AES-256 at rest, TLS in transit). Never "all data everywhere." Also banned per BACKUP-CLAIMS.md: "immutable," "continuous"/"real-time"/"zero data loss," "HIPAA-compliant backups," "regularly tested restore procedures" (per-run integrity verification is the claimable fact), any snapshot mention until verified, "military-grade"/"bank-level."
- AI beyond the two shipped features (form translation with human review; floor-plan drafting). No "AI-powered" as a headline noun.
- Need Navigator Network described as an active network (it's an opt-in capability).
- Claims the current site makes that v2 drops: the "HMIS & Case Management Software" category claim — v2's home targets "nonprofit case management software" and body copy frames the category as case-management software for human-services organizations, mentioning HMIS number/fields factually only; "HRSN billing … submit for reimbursement" (reframed to claim preparation on /features/billing); "HIPPA compliant" (replaced by /security's honest specifics); "push notifications" (not in FEATURES.md → OPEN-QUESTIONS.md).
- Held back pending verification (logged in OPEN-QUESTIONS.md): portal paystub-photo upload end-to-end; multi-household-member income from a single public submission (per-tenant confirmation required); global 2FA enforcement (flag non-functional — per-user 2FA is what we say).

---

## 4. Legacy URL redirect map (activates at DNS cutover)

Current live pages crawled 2026-07-24:

| Legacy URL | v2 target |
|---|---|
| `/pages/home` | `/` (platform already 301s this) |
| `/pages/core-features` | `/features` |
| `/pages/how-it-works` | `/features` |
| `/pages/who-we-serve` | `/solutions` |
| `/pages/referrals` | `/features/referrals-partners` |
| `/pages/about-us` | `/about` |
| `/pages/contact` | `/contact` |

**✅ Implemented 2026-07-25 (blessed platform feature):** `Site::redirectTarget()` + PageController consult `settings['redirects']` when no template matches (existing templates always win), with tests. The map above is already set in the neednavigator site settings. Old-site numeric `#scroll_to_section_NN` anchors are not preserved (path-level redirects only).

**Re-verified 2026-09-04 against the live site's sitemap.xml and a link crawl:** still exactly these seven pages; nothing to add. Per Dave, the map sends **302** for the cutover (`redirect_status` site setting, added 2026-09-04) so a target can be corrected without fighting browser caches; flip to 301 once the new URLs have held for a couple of weeks: `php artisan sites:setting neednavigator redirect_status --unset`. `/pages/home` → `/` stays 301 (platform rule).

---

## 5. SEO / AIO implementation

- **Per page:** unique `<title>` ≤60 chars, meta description ≤155, single H1, canonical (built from the primary domain, so staging never canonicalizes to itself), OG + Twitter cards, descriptive alt text. Implemented in our site layout via `@section('title') / @section('description')` + new hooks — first SiteHub site to carry canonical/OG/JSON-LD.
- **JSON-LD:** Organization + SoftwareApplication (offers: $25/user/month) sitewide; FAQPage on every page with an FAQ (answers self-contained, 2–4 sentences); BreadcrumbList on subpages.
- **sitemap.xml / robots.txt:** automatic per platform. Staging protection needs the §6 `X-Robots-Tag` platform change — robots.txt Disallow alone does not prevent URL-only indexing.
- **llms.txt:** no per-site mechanism exists. Proposal: tiny platform route in the `SiteMetaController` pattern serving `resources/sites/{slug}/llms.txt` as text/plain (with tests). Content: factual product summary + page index + the same honesty constraints.
- **OG image:** one branded SVG composed in-repo, rasterized to PNG at build time (tool availability checked in Step 2; if none on the box, flagged in BUILD-NOTES launch checklist).
- **Per-site favicon:** SVG + PNG under `public/sites/neednavigator/`, linked from the layout (first site to do so; platform `/favicon.ico` remains the fallback).
- Semantic landmarks, skip link (platform convention), keyboard-navigable nav/accordions, visible focus states, WCAG 2.1 AA minimum.

### Imagery
All imagery generated as inline SVG / CSS compositions: one 1.5px-stroke icon set, abstract-warm illustrations, and the honest stylized UI representations listed in §2 (real capabilities only, per FEATURES.md). Every slot wrapped in `<!-- IMAGE SLOT: id | replace with: … -->` and appended to `image-manifest.md` (id, page, current placeholder, desired real asset) for Dave to work through.

---

## 6. Platform prerequisites & launch dependencies (outside page authoring)

> Dave 2026-07-24: platform additions with broad applicability (redirect map, llms.txt route, X-Robots-Tag middleware) are blessed — build them rather than waiting on per-item approval. Each ships with tests.
>
> **Blocker found during Step 2:** `storage/` + `bootstrap/cache` ACLs grant `ubuntu` and `sitehub` but not `dlux`, so `php artisan` (provisioning, tests, tinker) fails for dlux entirely — apparently a hardening oversight, since server-hardening.md lists dlux as a deploy user. One-time fix (needs sudo): `sudo setfacl -R -m u:dlux:rwX -m d:u:dlux:rwX /var/www/sitehub/storage /var/www/sitehub/bootstrap/cache`

| Item | When needed | Notes |
|---|---|---|
| `X-Robots-Tag: noindex, nofollow` on non-primary hosts | ✅ Done 2026-07-25 | ResolveSite stamps the header on every non-primary-host response; non-primary robots.txt now allows crawling so the header is seen. Tests in SiteMetaFeaturesTest + PageServingTest. Benefits every SiteHub site. |
| Outbound mail transport | Before form goes live | **Dave 2026-07-24: `log` is fine for now.** Submissions store in the tenant DB but no email delivers until a real transport is wired (launch checklist item). SES fits existing AWS plumbing; needs from-domain + SPF/DKIM decision. |
| Turnstile hostname | Staging | **Decided: reuse the platform widget.** Dave adds nn.webriculture.com + www.neednavigator.com to its Cloudflare allowed-hostnames list; no per-site settings/secret needed. |
| `form_recipients` / `form_subject` | Before launch | Landlord `sites.settings` via tinker (P2 admin absent). |
| `/llms.txt` route | ✅ Done 2026-07-25 | `SiteMetaController::llms()` serves `resources/sites/{slug}/llms.txt` as text/plain (404 when absent), with tests; neednavigator's llms.txt is written. |
| Redirect map mechanism | ✅ Done 2026-07-25 | See §4 — implemented and configured for this site. |
| nginx: gzip_types, http2, static cache headers | Before Lighthouse sign-off | CSS/JS/SVG currently ship uncompressed over HTTP/1.1 with no cache policy — the main Lighthouse-performance risk, and it's server config, not page weight. Needs sudo. |
| `responsecache:clear` | After any domain/settings change | Cached 200s (incl. robots/sitemap) persist up to 7 days otherwise. |
| nginx vhost + certbot for nn.webriculture.com | Staging | Standard shared snippet. |
| **DNS cutover** | ✅ **Done 2026-09-04 17:34 PT** | Dave moved the apex A record (www is a CNAME to it) from the legacy box 50.112.240.166 to 52.25.76.118. Production vhost `sites-available/www.neednavigator.com` (port-80 template staged, enabled pre-flip); a watcher polled Cloudflare's authoritative NS and ran certbot once on the change: cert issued 00:34 UTC for www + apex, expires 2026-12-03, auto-renew registered, http→https redirect added by certbot. Verified live: www 200, apex 301→www, legacy `/pages/*` 302 via the map, `/pages/home` 301. Response cache cleared. **Follow-ups:** confirm www.neednavigator.com is on the Turnstile allowed-hostname list by submitting the live form once (staging form verified 2026-09-04, live not yet); submit the sitemap in Search Console; unset `redirect_status` (302→301) around 2026-09-18; legacy box keeps serving nothing for www but stays up for rollback. |

---

## 7. Process from here (per the brief)

1. ~~This plan~~ → **Dave approves / amends** (incl. the 16-vs-14 feature-page call and OPEN-QUESTIONS.md).
2. Design tokens + base layout + **Home** + **/features/shelters** (richest UI-representation test: the bed matrix) → pause for review.
3. All remaining pages, image-manifest.md, llms.txt, OG assets, the two small platform routes (llms.txt, X-Robots-Tag) with tests.
4. BUILD-NOTES.md: run/build/deploy, where copy lives, how to edit, launch checklist (analytics, mail backend, OG finalization, favicon, DNS cutover, redirect map, nginx perf items, `responsecache:clear`).

Anything FEATURES.md is ambiguous about is excluded and logged in [OPEN-QUESTIONS.md](OPEN-QUESTIONS.md). Accuracy outranks completeness.

---

## 8. September 2026 feature sync — copy backlog

[FEATURES.md](FEATURES.md) was refreshed 2026-09-04 from the Need Navigator repo's export (July + August 2026 releases). The export was truncated partway through GeoTracker, so Part 6 onward still reflects 2026-07-24 — re-sync when the rest arrives.

**Corrected in the copy already** (the source now contradicted the page):

| Page | Was | Now |
|---|---|---|
| `/features/emergency-assistance` (FAQ) | "a **fixed** status ladder" | Ladder ships as-is and the agency can rename/recolor/reorder/disable statuses and scope them to resources; status changes also show as a timeline on the request. |
| `/features/geotracker` (FAQ + capability) | staff "dissolve a place when it stops being one" | Staff name a place, freeze its center against drift, reposition it by hand, and remove one once it holds nothing. (The old "merge/re-pin are back-end only" caveat is gone.) |
| `/features/income-eligibility` (capability) | "a client's **own** income must be staff-verified before it counts" | Only staff-verified income counts — the client's and every household member's alike (tightened August 2026). |

**Not yet on the site — needs Dave's call on placement** (all confirmed features, none blocked; the biggest is a candidate 17th feature page, which is a §2 sitemap change):

| Feature (FEATURES.md section) | Shipped | Where it would land |
|---|---|---|
| **Service Usage Limits** — ration a service per calendar period or rolling window, individual or household, warn or block, enforced on every screen, with an audited override | Aug 2026 | Strongest new material of the batch, and a stated differentiator. Candidate own feature page; otherwise `/solutions/food-banks-community-aid` (food boxes, bus passes) plus `/features/emergency-assistance` and `/features/programs-automation`. |
| Need **status timeline** rail (every change, who and when, off-ramp marker) | Aug 2026 | `/features/emergency-assistance` — partially covered by the FAQ fix above. |
| **Caseload summary PDF** (per-client or whole caseload, 7/30/90 days, permission-gated, logged) | Aug 2026 | `/features/households-care-team` |
| **Visit summary PDF** — branded record of service, optional combined household document | Aug 2026 | `/features/casework` |
| Goal **Journey** row (created → steps → completed, dated) | Aug 2026 | `/features/casework` |
| Billing **rate history** (effective-dated codes) and **batches freeze on submit** | Aug 2026 | `/features/billing` — strong compliance material. |
| Organization **vetting badge** (who vetted, when, what was checked; filter and audit log) | Aug 2026 | `/features/referrals-partners` |
| **Incoming referrals** (record the organization a referral came *from*) | Aug 2026 | `/features/referrals-partners` — currently the page only covers referrals sent. |
| **New intake on re-enrollment** (per program; HMIS 5.03 one Project Start per period) + enrollment periods as their own report type | Aug 2026 | `/features/programs-automation`, `/solutions/community-action-agencies`, `/solutions/shelters-housing` |
| Smart Button **household visit in one click** and the run-time prompt dialog | Aug 2026 | `/features/programs-automation` |
| Quick Forms Excel export now honors status/search/"in program only" filters | Aug 2026 | `/features/intake-management` — no page currently claims the old limitation, so this is a gain, not a fix. |
| Client profile: enrollment-period selector, household member-count badge, record id in header | Aug 2026 | Minor; `/features/client-records` if the section is touched. |

**Still not marketable** — unchanged by this sync: event online payments and waitlists (Stripe pending a first end-to-end run), Document Manager / partner document sharing (beta), Need Navigator Network as an *active* network, portal paystub-photo upload, electronic claim submission.

**No client names, ever** (OPEN-QUESTIONS #4): the export notes Mid-Valley Parenting's site cut over to the class feed and registration pages in September 2026 and that the first partner site is connected. Usable only as unnamed proof ("live with agencies today"), never by name.

**⚠️ Open item from this sync — the "eleven record types" count.** Six places quote it: `/reporting` (meta description, FAQ, lede), `/features/referrals-partners` (FAQ), `/` (home), `/features` (index). FEATURES.md §Reports is carried over from July and still says eleven, but the September export's Programs section states enrollment periods are now their own report type — so the real number is at least twelve. Left unchanged rather than guessed at. Fix all six together once the rest of the export lands and the true list is known; if the count keeps moving, consider dropping the number from the copy entirely.
