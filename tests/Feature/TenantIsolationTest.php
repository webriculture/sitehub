<?php

declare(strict_types=1);

use App\Models\Tenant\Gallery;
use App\Tenancy\Tenancy;
use Illuminate\Support\Facades\DB;
use Tests\Concerns\ProvisionsSites;

uses(ProvisionsSites::class);

afterEach(fn () => $this->cleanupProvisionedSites());

it('keeps tenant data physically separated per database', function (): void {
    $a = $this->provisionSite('iso-a');
    $b = $this->provisionSite('iso-b');

    Tenancy::makeCurrent($a);
    Gallery::query()->create(['slug' => 'projects', 'title' => 'Projects']);

    expect(Gallery::query()->count())->toBe(1);

    Tenancy::makeCurrent($b);

    // Site B's database has no trace of site A's gallery.
    expect(Gallery::query()->count())->toBe(0);

    // Belt and suspenders: assert at the PostgreSQL level.
    $inA = DB::connection('landlord-admin')
        ->selectOne('select 1 from pg_database where datname = ?', [Tenancy::databaseName($a)]);

    expect($inA)->not->toBeNull()
        ->and(Tenancy::databaseName($a))->toBe('test_site_iso_a')
        ->and(Tenancy::databaseName($b))->toBe('test_site_iso_b');
});

it('refuses tenant queries when no site is current', function (): void {
    Tenancy::forget();

    expect(fn () => Gallery::query()->count())->toThrow(Exception::class);
});
