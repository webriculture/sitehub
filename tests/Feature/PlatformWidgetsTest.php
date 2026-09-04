<?php

declare(strict_types=1);

use App\Models\Site;

function widgetSite(): Site
{
    $site = Site::factory()->create(['slug' => 'fransalem']);
    $site->domains()->create(['hostname' => 'fransalem.test', 'is_primary' => true]);

    return $site;
}

it('renders the accessibility toolbar collapsed and collapsible', function (): void {
    widgetSite();

    $this->get('http://fransalem.test/')
        ->assertOk()
        ->assertSee('id="sh-a11y-panel" hidden', escape: false)
        // Author display rule must not defeat the hidden attribute.
        ->assertSee('.sh-a11y__panel[hidden] { display: none; }', escape: false);
});

it('renders the scroll-to-top button, hidden until scrolled', function (): void {
    widgetSite();

    $this->get('http://fransalem.test/')
        ->assertOk()
        ->assertSee('id="sh-top" hidden', escape: false)
        ->assertSee('.sh-top[hidden] { display: none; }', escape: false);
});
