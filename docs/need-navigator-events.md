# Need Navigator → SiteHub Events Contract

Events and classes are **authored in Need Navigator** and pulled into SiteHub by
`php artisan events:sync` (scheduled every 30 minutes) for each site with the
`events` feature enabled. SiteHub never edits them; it caches them per-site
(tenant `events` table) and owns 100% of the presentation.

## Design principles

- **The stream is benign.** Plain structured JSON — no HTML, no markup, no
  styling hints. If a field ever needs formatting, we discuss it here first.
- **All styling happens in SiteHub**, via `<x-site-events>` default markup
  (`sh-event__*` classes) restyled per site's own CSS.
- **Auth:** per-site bearer token, stored encrypted in SiteHub
  (`sites.secrets → need_navigator_token`). One token per site, revocable
  independently.

## Endpoint (SiteHub's expectation — adjust here if Need Nav differs)

```
GET {NEED_NAVIGATOR_URL}/api/v1/events
Authorization: Bearer <per-site token>
Accept: application/json
```

Response: a JSON array (bare, or wrapped in `{"data": [...]}`) of:

| Field | Type | Notes |
|---|---|---|
| `id` | string | Stable Need Navigator identifier — SiteHub's upsert key. Never reuse. |
| `kind` | `"event"` \| `"class"` | Classes arrive with FRAN Phase 2 |
| `title` | object | Locale map: `{"en": "...", "es": "..."}` — `en` required |
| `description` | object | Locale map; plain text only |
| `location` | object | Locale map; plain text only |
| `starts_at` | string | ISO 8601 with offset |
| `ends_at` | string \| null | ISO 8601 with offset |
| `all_day` | boolean | |
| `registration_url` | string \| null | Phase 2: link into Need Navigator registration |

Items missing `id`, `title`, or `starts_at` are skipped (logged), never fatal.
Events absent from the feed are deleted from the site's cache (the feed is the
source of truth for the upcoming window — include everything still relevant).

## Drivers

- `NEED_NAVIGATOR_DRIVER=stub` (default): representative sample data, used
  until the real API is wired. Lets design/QA proceed with zero coupling.
- `NEED_NAVIGATOR_DRIVER=http` + `NEED_NAVIGATOR_URL=...`: the real thing
  (`App\NeedNavigator\HttpClient`).
