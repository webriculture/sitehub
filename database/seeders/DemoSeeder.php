<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Tenancy\SiteProvisioner;
use Illuminate\Database\Seeder;

/**
 * Local development environment: the two committed demo sites,
 * reachable at http://site-a.test and http://site-b.test (add both
 * hostnames to /etc/hosts — see README).
 */
final class DemoSeeder extends Seeder
{
    public function run(SiteProvisioner $provisioner): void
    {
        $siteA = $provisioner->provision('site-a', 'Site A', ['galleries', 'forms']);
        $siteA->domains()->updateOrCreate(['hostname' => 'site-a.test'], ['is_primary' => true]);
        $siteA->domains()->updateOrCreate(['hostname' => 'www.site-a.test'], ['is_primary' => false, 'redirect_to_primary' => true]);

        $siteB = $provisioner->provision('site-b', 'Site B');
        $siteB->domains()->updateOrCreate(['hostname' => 'site-b.test'], ['is_primary' => true]);
    }
}
