<?php

declare(strict_types=1);

namespace Tests\Concerns;

use App\Models\Site;
use App\Tenancy\SiteProvisioner;
use App\Tenancy\Tenancy;
use Illuminate\Support\Facades\File;

/**
 * Provisions sites WITH real tenant databases (test-prefixed) and
 * guarantees they're dropped afterward, along with any site
 * directories the provisioner scaffolded. Directories that already
 * existed before provisioning (committed sites) are left alone.
 * Only use in tests that exercise tenant data; page-serving tests
 * only need landlord rows.
 */
trait ProvisionsSites
{
    /** @var list<Site> */
    private array $provisionedSites = [];

    /** @var list<string> */
    private array $scaffoldedDirectories = [];

    protected function provisionSite(string $slug, array $features = []): Site
    {
        $directories = [resource_path('sites/'.$slug), public_path('sites/'.$slug)];

        $preExisting = array_filter($directories, fn (string $dir): bool => File::isDirectory($dir));

        $site = app(SiteProvisioner::class)->provision($slug, ucfirst($slug), $features);

        $site->domains()->create(['hostname' => $slug.'.test', 'is_primary' => true]);

        $this->provisionedSites[] = $site;

        foreach (array_diff($directories, $preExisting) as $dir) {
            $this->scaffoldedDirectories[] = $dir;
        }

        return $site;
    }

    protected function cleanupProvisionedSites(): void
    {
        Tenancy::forget();

        foreach ($this->provisionedSites as $site) {
            app(SiteProvisioner::class)->dropTenantDatabase($site);
        }

        foreach ($this->scaffoldedDirectories as $dir) {
            File::deleteDirectory($dir);
        }

        $this->provisionedSites = [];
        $this->scaffoldedDirectories = [];
    }
}
