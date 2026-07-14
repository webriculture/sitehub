<?php

declare(strict_types=1);

use App\Models\Site;
use App\Models\User;

function siteWithDomain(string $slug): Site
{
    $site = Site::factory()->create(['slug' => $slug]);
    $site->domains()->create(['hostname' => $slug.'.test', 'is_primary' => true]);

    return $site;
}

it('lets a super admin into any site admin', function (): void {
    siteWithDomain('site-a');

    $admin = User::factory()->create();
    $admin->forceFill(['is_super_admin' => true])->save();

    $this->actingAs($admin)
        ->get('http://site-a.test/admin')
        ->assertOk();
});

it('blocks users who do not belong to the site', function (): void {
    siteWithDomain('site-a');

    $this->actingAs(User::factory()->create())
        ->get('http://site-a.test/admin')
        ->assertForbidden();
});

it('allows members on their own site but not others', function (): void {
    $siteA = siteWithDomain('site-a');
    siteWithDomain('site-b');

    $member = User::factory()->create();
    $member->sites()->attach($siteA);

    $this->actingAs($member)->get('http://site-a.test/admin')->assertOk();
    $this->actingAs($member)->get('http://site-b.test/admin')->assertForbidden();
});
