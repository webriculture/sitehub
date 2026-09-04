<?php

declare(strict_types=1);

use App\Models\Site;

function registerNeedNavigator(): Site
{
    $site = Site::factory()->create(['slug' => 'neednavigator']);
    $site->domains()->create(['hostname' => 'www.neednavigator.com', 'is_primary' => true]);
    $site->domains()->create(['hostname' => 'nn.webriculture.com', 'redirect_to_primary' => false]);

    return $site;
}

it('canonicalizes to the primary domain even when served on staging', function (): void {
    registerNeedNavigator();

    $this->get('http://nn.webriculture.com/')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://www.neednavigator.com/">', escape: false)
        ->assertSee('property="og:url" content="https://www.neednavigator.com/"', escape: false);

    $this->get('http://nn.webriculture.com/features/shelters')
        ->assertOk()
        ->assertSee('<link rel="canonical" href="https://www.neednavigator.com/features/shelters">', escape: false);
});

it('publishes the transparent price in SoftwareApplication structured data', function (): void {
    registerNeedNavigator();

    $this->get('http://www.neednavigator.com/')
        ->assertOk()
        ->assertSee('"@type":"SoftwareApplication"', escape: false)
        ->assertSee('"price":"25.00"', escape: false);
});

it('mirrors the shelters FAQ into FAQPage structured data', function (): void {
    registerNeedNavigator();

    $this->get('http://www.neednavigator.com/features/shelters')
        ->assertOk()
        ->assertSee('"@type":"FAQPage"', escape: false)
        ->assertSee('Can families be checked in and out together?', escape: false);
});
