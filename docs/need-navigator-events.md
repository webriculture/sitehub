# Need Navigator → SiteHub Events Feed — Integration Spec

**Audience:** the team/agent implementing the feed on the Need Navigator side.
**Consumer:** SiteHub (`webriculture/sitehub`), which polls this feed and caches
events per-site. First consuming site: fransalem.com (FRAN).
**Status:** v1 contract. SiteHub's consumer (`App\NeedNavigator\HttpClient`,
`events:sync`) is already built and tested against this shape.

## 1. Design principles

- **The stream is benign.** Plain structured JSON. No HTML, no Markdown, no
  styling hints, no presentation decisions. SiteHub owns 100% of rendering
  and restyles per client site. If a field ever seems to need formatting,
  we change this contract first, not the payload.
- **The feed is a snapshot, not a changelog.** Every request returns the
  full set of *currently relevant* events for the authenticated site.
  SiteHub upserts by `id` and deletes anything absent — so "removing an
  event from the feed" IS the delete mechanism. No tombstones needed.
- **Server-to-server only.** SiteHub polls every 30 minutes per site. The
  public FRAN site never touches this API — visitors read SiteHub's cache,
  so a Need Navigator outage never takes event listings down (last-known-good
  persists).

## 2. Endpoint

```
GET /api/v1/events
Host: <need navigator host — TBD, provided to SiteHub as NEED_NAVIGATOR_URL>
Authorization: Bearer <per-site token>
Accept: application/json
```

- **No query parameters in v1.** The token identifies the site/organization;
  the server decides what "currently relevant" means (see §4).
- Version lives in the path. Additive field changes are fine within v1;
  renames/removals/semantic changes bump to /v2.

## 3. Response format

`200 OK`, `Content-Type: application/json`:

```json
{
    "data": [
        {
            "id": "evt_8f3k2",
            "kind": "event",
            "title": { "en": "FRAN Center Open House", "es": "Casa Abierta del Centro FRAN" },
            "description": { "en": "Meet the partner organizations…", "es": "Conozca a las organizaciones…" },
            "location": { "en": "FRAN Center, Northeast Salem", "es": "Centro FRAN, Noreste de Salem" },
            "starts_at": "2026-08-01T10:00:00-07:00",
            "ends_at": "2026-08-01T14:00:00-07:00",
            "all_day": false,
            "registration_url": null
        }
    ]
}
```

(A bare top-level array is also accepted, but the `data` envelope is
preferred — it leaves room for `meta` later.)

### Field reference

| Field | Type | Required | Rules |
|---|---|---|---|
| `id` | string | ✅ | **Stable forever** for a given event — it's SiteHub's upsert key. Never reuse an id for a different event; never change an event's id. Opaque format (prefix like `evt_`/`cls_` is nice, not required). |
| `kind` | string | ✅ | `"event"` or `"class"`. Classes ship in Phase 2; the field exists from day one so v1 doesn't need a schema change. |
| `title` | locale map | ✅ | `{"en": "…"}` minimum; `"es"` when available. Plain text, ≤255 chars per locale. |
| `description` | locale map | — | Plain text (newlines OK, no markup), sensible length (≤2,000 chars/locale). Omit or `{}` if none. |
| `location` | locale map | — | Plain text, ≤255 chars per locale. |
| `starts_at` | string | ✅ | **ISO 8601 with UTC offset** (e.g. `2026-08-01T10:00:00-07:00`). Never naive/local timestamps — DST bugs die here. |
| `ends_at` | string \| null | — | Same format. `null`/omitted = no defined end. |
| `all_day` | boolean | — | Defaults false. When true, SiteHub hides clock times. |
| `registration_url` | string \| null | — | Phase 2: absolute HTTPS URL into Need Navigator's registration flow. `null`/omitted in Phase 1. |

Unknown extra fields are ignored by SiteHub (and stored in a `raw` copy),
so Need Navigator may add fields freely without coordination.

**Malformed items** (missing `id`, `title`, or `starts_at`) are skipped and
logged by SiteHub — one bad item never poisons a sync. But don't rely on
that; validate on the way out.

## 4. Which events belong in the feed

Everything **still relevant to a visitor**: any event whose `ends_at`
(or `starts_at`, if no end) is **today or later**, in the event's own
timezone. Past events should drop out of the feed naturally — SiteHub
prunes them from its cache when they disappear.

Expected volume is tens of events, not thousands — **no pagination in v1**.
If a site ever exceeds ~500 items we'll revisit.

## 5. Security mechanism

**Per-site bearer tokens**, treated exactly like personal access tokens:

1. **Issuance:** Need Navigator generates one token per consuming site
   (FRAN first). ≥32 bytes of cryptographic randomness, e.g.
   `nn_evt_` + 43 base62 chars. Shown once at creation.
2. **Storage (NN side):** store only a **hash** of the token (SHA-256 is
   fine for high-entropy tokens). Record: site name, created date,
   last-used date.
3. **Scope:** the token grants **read-only access to this one endpoint,
   for one organization's events**. It must not work anywhere else in the
   Need Navigator API. Token ↔ organization mapping happens server-side;
   the client can't request anyone else's data.
4. **Transport:** HTTPS only. Reject plain HTTP at the server.
5. **Responses:** missing/invalid token → `401` with an empty body or
   `{"error": "unauthenticated"}`. Never vary event data by anything
   other than the token's organization.
6. **Rate limiting:** SiteHub polls each site every 30 minutes (plus
   occasional manual runs). A limit of 60 requests/hour per token is
   generous; `429` on excess.
7. **Rotation/revocation:** tokens must be individually revocable and
   re-issuable without affecting other sites. Rotation procedure:
   issue new → Webriculture updates SiteHub's encrypted secret → revoke
   old. (SiteHub stores the token encrypted at rest in its landlord DB;
   it never appears in git or logs.)
8. **Optional hardening (nice-to-have, not required for v1):** allowlist
   the SiteHub server's IP; support `ETag`/`If-None-Match` with `304`
   responses to make polling nearly free.

**Explicitly not needed:** OAuth, cookies, sessions, CORS headers (no
browser ever calls this), webhooks (polling is fine at this cadence),
signed payloads (TLS + bearer covers the threat model at these stakes).

## 6. Failure behavior (what SiteHub does)

- Timeout 15s, 2 retries with 500ms backoff, then the sync run logs a
  failure and **keeps the previous cache** — the public site is unaffected.
- A `200` with an empty `data: []` is honored: SiteHub deletes all cached
  events for that site. So never return an empty array as an error
  fallback — return a real `5xx` instead.

## 7. Acceptance checklist (SiteHub will verify against a staging token)

- [ ] `GET /api/v1/events` with valid token → 200, schema per §3
- [ ] Same request without / with bad token → 401
- [ ] Token for site A never returns site B's events
- [ ] `id` values stable across requests; edited events keep their id
- [ ] Timestamps carry UTC offsets
- [ ] No HTML/markup in any text field (`<`, `>` only as literal content)
- [ ] Removing an event in Need Navigator removes it from the feed
- [ ] Plain-HTTP request refused

## 8. Phase 2 (heads-up, not in scope now)

- `kind: "class"` items appear in the same feed.
- `registration_url` populated, linking into Need Navigator's public
  registration flow (registration UX and data stay entirely on the Need
  Navigator side; the FRAN site just links out).
- Possible additional fields (capacity/spots remaining, session series) —
  additive, coordinated via this document.

## Appendix: SiteHub-side reference (for context)

- Config: `NEED_NAVIGATOR_DRIVER=http`, `NEED_NAVIGATOR_URL=https://…`
- Token lives in the site's encrypted secrets (`need_navigator_token`)
- Sync: `php artisan events:sync` — scheduled every 30 min, upsert by
  `external_id`, prune absent, flush that site's response cache on change
- Until the real endpoint exists, SiteHub runs `NEED_NAVIGATOR_DRIVER=stub`
  (sample data) — the swap to live is config-only, no code changes.

---

# Appendix B: Need Navigator side — implementation & reply

*Written by the Need Navigator implementers. This is the authoritative description of
what NN actually serves; where it clarifies or tightens the wishlist above, this section
wins. The wire contract in §3 is honored exactly — nothing here changes the JSON shape.*

## B.1 Status

- **Phase 1 (event feed + auth): implemented and verified.** `GET /api/v1/events`
  returns the §3 shape. Ships emitting `title/description/location` as `{"en": …}`.
- **Spanish (`es`): implemented additively.** NN authors optional Spanish per event;
  the feed adds `"es"` to any locale map when present, omits it otherwise. No contract
  change — SiteHub's English fallback already covers events that lack `es`.
- **Phase 2 (`kind:"class"`, `registration_url`): not built.** `kind` is always
  `"event"` and `registration_url` is always `null` for now, exactly as §8 anticipates.

## B.2 How NN decides "which events" (answering §2/§4)

We agree with the wishlist's instinct: **the token decides scope; the client sends no
query parameters.** Concretely, an event is in a token's feed when **all** hold:

1. `is_public = true` **and** `status = 'published'` — the same gate that powers NN's
   own public event pages (`/e/{slug}`). "Public" is the single authoritative flag.
2. It is still relevant: `COALESCE(end_date, start_date) >= today`, where *today* is
   computed in the tenant's timezone (`APP_TIMEZONE`; FRAN = `America/Los_Angeles`).
   Past events fall out of the feed on their own → SiteHub prunes them.
3. It matches the **token's server-side scope** (see B.4): an optional allow-list of
   Event **classifications** and/or **types** baked into the token. A future event
   created under an in-scope classification appears automatically — no re-issuance.

This is the reconciliation of "pull by classification/type" with "no query params":
the filtering is real, but it lives on the token, not in the request. The client
cannot widen its own scope or probe NN's taxonomy.

## B.3 Field mapping notes (NN data → §3 wire shape)

| Wire field | Source in NN | Notes |
|---|---|---|
| `id` | `evt_{events.id}` | Integer PK, prefixed. Stable forever; never reused (soft-deletes). |
| `kind` | constant `"event"` | Phase 2 will introduce `"class"` from a separate source. |
| `title` / `location` | `events.title` / `events.location` (+ `es` from `translations`) | Plain text. |
| `description` | `events.description_html`, **stripped to plain text** | Block tags → newlines, entities decoded, markup removed. Newlines preserved. |
| `starts_at` / `ends_at` | `start_date`+`start_time` / `end_date`+`end_time` | **Naive local** columns (no per-event zone) interpreted in `APP_TIMEZONE`, emitted ISO-8601 **with offset**. `ends_at` is `null` when `end_date` is null. DST is handled by the zone (Aug `-07:00`, Jan `-08:00`). |
| `all_day` | constant `false` | NN has no all-day concept yet; add a column later if needed (additive). |
| `registration_url` | `null` | Phase 2 will link into `/e/{slug}`. |

**Timezone caveat (worth a shared eye):** NN events store *naive* local date/times, so
we interpret them in the tenant's single configured zone. This is correct as long as an
event's local time really is in that zone — true for a single-org, single-region tenant
like FRAN. If NN ever runs events in another zone, we add a per-event zone column and
the offset math updates here (still no wire change).

## B.4 Security — as implemented (answering §5)

We went **beyond** the "env token is fine" floor, because this token sits in front of a
system that may hold HIPAA data. The feed itself carries **zero PII** by construction
(marketing metadata only — never attendees, submissions, or registrants), and the token
is scoped so a leak can't become a foothold:

- **Storage:** dedicated `events_api_tokens` table. Only a **SHA-256 hash** of the token
  is stored (never the plaintext). Format `nn_evt_` + 43 base62 chars (~256 bits). Shown
  once, at mint.
- **One narrow guard:** a purpose-built middleware authenticates **only** `GET
  /api/v1/events`. It creates no session, resolves no user, and reaches nothing else in
  the NN API. Token ↔ scope mapping is entirely server-side.
- **Per-site, individually revocable:** each consuming site gets its own token with its
  own classification/type scope, IP allow-list, and `last_used_at`. Revoking or rotating
  one never touches another. Rotation = mint new → update SiteHub secret → revoke old.
- **Transport:** HTTPS enforced in production (`$request->secure()` behind the ALB via
  TrustProxies); plain HTTP is refused.
- **Rate limit:** `60 requests/hour` per token (`429` on excess) — generous for a
  30-minute poll.
- **Caching:** `ETag` + `If-None-Match` → `304` so a no-change poll is nearly free.
- **Errors:** missing/invalid token → `401 {"error":"unauthenticated"}`; disallowed
  source IP → `403`. Event data never varies by anything but the token's scope.

### Provisioning (NN operator)

```bash
# 1. Deploy — the additive migrations create events_api_tokens + events.translations.
# 2. Mint a scoped token for the consuming site (choose classification/type ids):
php artisan events:token:mint "FRAN / SiteHub" --classification=3 --type=2
#    → prints the nn_evt_… token ONCE. Hand it to SiteHub's encrypted secret.
#    (Use --all to intentionally serve every public event; --ip=… to pin source IPs.)
php artisan events:token:list           # names, scope, last-used — never the token
php artisan events:token:revoke <id>    # revoke one site without affecting others
```

## B.5 Acceptance checklist (§7) — status

- [x] `GET /api/v1/events` + valid token → 200, schema per §3
- [x] Missing/bad token → 401
- [x] Token for site A never returns site B's events (server-side scope; per-token)
- [x] `id` stable across requests; edited events keep their id (integer PK)
- [x] Timestamps carry UTC offsets (built from `APP_TIMEZONE`)
- [x] No HTML/markup in any text field (`description_html` stripped to plain text)
- [x] Removing an event (soft-delete / unpublish / out-of-window) removes it from the feed
- [x] Plain-HTTP request refused (production)
