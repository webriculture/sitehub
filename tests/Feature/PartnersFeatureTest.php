<?php

declare(strict_types=1);

use App\Models\Tenant\Partner;
use App\Models\User;
use App\Tenancy\Tenancy;
use Illuminate\Support\Facades\Blade;
use Tests\Concerns\ProvisionsSites;

uses(ProvisionsSites::class);

afterEach(fn () => $this->cleanupProvisionedSites());

it('renders published partners bilingually through the component', function (): void {
    $site = $this->provisionSite('pf-a', ['partners']);
    Tenancy::makeCurrent($site);

    Partner::query()->create([
        'name' => 'Helping Hands',
        'description' => ['en' => 'Food assistance', 'es' => 'Asistencia alimentaria'],
        'programs' => [['name' => ['en' => 'Pantry', 'es' => 'Despensa'], 'description' => []]],
        'published' => true,
    ]);

    Partner::query()->create([
        'name' => 'Retired Org',
        'description' => ['en' => 'Old'],
        'published' => false,
    ]);

    $html = Blade::render('<x-site-partners />');

    expect($html)
        ->toContain('Helping Hands')
        ->toContain('Food assistance')
        ->toContain('Pantry')
        ->not->toContain('Retired Org');

    app()->setLocale('es');

    expect(Blade::render('<x-site-partners />'))
        ->toContain('Asistencia alimentaria')
        ->toContain('Despensa');

    app()->setLocale('en');
});

it('renders nothing when the partners feature is disabled', function (): void {
    $site = $this->provisionSite('pf-b');
    Tenancy::makeCurrent($site);

    expect(trim(Blade::render('<x-site-partners />')))->toBe('');
});

it('exposes the admin resource only when the feature is enabled', function (): void {
    $enabled = $this->provisionSite('pf-c', ['partners']);
    $disabled = $this->provisionSite('pf-d');

    $member = User::factory()->create();
    $member->sites()->attach([$enabled->id, $disabled->id]);

    $this->actingAs($member)
        ->get('http://pf-c.test/admin/partners')
        ->assertOk();

    $this->actingAs($member)
        ->get('http://pf-d.test/admin/partners')
        ->assertForbidden();
});
