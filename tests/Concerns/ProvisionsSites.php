<?php

declare(strict_types=1);

namespace Tests\Concerns;

use App\Models\Site;
use App\Tenancy\SiteProvisioner;
use App\Tenancy\Tenancy;

/**
 * Provisions sites WITH real tenant databases (test-prefixed) and
 * guarantees they're dropped afterward. Only use in tests that
 * exercise tenant data; page-serving tests only need landlord rows.
 */
trait ProvisionsSites
{
    /** @var list<Site> */
    private array $provisionedSites = [];

    protected function provisionSite(string $slug, array $features = []): Site
    {
        $site = app(SiteProvisioner::class)->provision($slug, ucfirst($slug), $features);

        $site->domains()->create(['hostname' => $slug.'.test', 'is_primary' => true]);

        $this->provisionedSites[] = $site;

        return $site;
    }

    protected function cleanupProvisionedSites(): void
    {
        Tenancy::forget();

        foreach ($this->provisionedSites as $site) {
            app(SiteProvisioner::class)->dropTenantDatabase($site);
        }

        $this->provisionedSites = [];
    }
}
