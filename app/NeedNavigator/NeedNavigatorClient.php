<?php

declare(strict_types=1);

namespace App\NeedNavigator;

use App\Models\Site;

/**
 * The contract for pulling events/classes authored in Need Navigator.
 * The stream is deliberately benign: plain structured data, no markup,
 * no styling — ALL presentation belongs to SiteHub.
 *
 * Expected item shape (see docs/need-navigator-events.md):
 * {
 *   "id": "evt_123",
 *   "kind": "event" | "class",
 *   "title": {"en": "...", "es": "..."},
 *   "description": {"en": "...", "es": "..."},
 *   "location": {"en": "...", "es": "..."},
 *   "starts_at": "2026-08-01T17:00:00-07:00",
 *   "ends_at": "2026-08-01T19:00:00-07:00" | null,
 *   "all_day": false,
 *   "registration_url": null
 * }
 */
interface NeedNavigatorClient
{
    /** @return list<array<string, mixed>> */
    public function events(Site $site): array;
}
