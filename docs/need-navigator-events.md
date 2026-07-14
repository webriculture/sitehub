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
