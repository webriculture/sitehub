<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SiteFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Site extends Model
{
    /** @use HasFactory<SiteFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'features',
        'settings',
        'secrets',
    ];

    protected $hidden = [
        'secrets',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'settings' => 'array',
            'secrets' => 'encrypted:array',
        ];
    }

    public function secret(string $key): ?string
    {
        return $this->secrets[$key] ?? null;
    }

    /** Locales beyond the default 'en', e.g. ['es'] for a bilingual site. */
    public function extraLocales(): array
    {
        return $this->settings['locales'] ?? [];
    }

    /**
     * Site-defined 301 target for a URL that moved in a redesign
     * (e.g. legacy CMS paths). Keys and targets are absolute paths.
     */
    public function redirectTarget(string $path): ?string
    {
        $map = $this->settings['redirects'] ?? [];

        if (isset($map[$path])) {
            return $map[$path];
        }

        // Prefix rules: a key ending in "/*" matches every path below it
        // (e.g. "/courses/view/*" for a legacy CMS with hundreds of detail
        // URLs). Exact keys always win; among prefixes, the longest wins.
        $best = null;

        foreach ($map as $pattern => $target) {
            if (! str_ends_with($pattern, '/*')) {
                continue;
            }

            $prefix = substr($pattern, 0, -1); // keep the trailing slash

            if (str_starts_with($path, $prefix) && ($best === null || strlen($prefix) > strlen($best[0]))) {
                $best = [$prefix, $target];
            }
        }

        return $best[1] ?? null;
    }

    /**
     * Need Navigator hosts are per-organization (fran.neednavigator.com,
     * dev.neednavigator.com, …), so a site may override the platform-wide
     * base URL via settings; the env default covers single-feed installs.
     */
    public function needNavigatorUrl(): ?string
    {
        return $this->settings['need_navigator_url']
            ?? config('sitehub.need_navigator.base_url');
    }

    public function domains(): HasMany
    {
        return $this->hasMany(Domain::class);
    }

    public function primaryDomain(): ?Domain
    {
        return $this->domains->firstWhere('is_primary', true) ?? $this->domains->first();
    }

    public function hasFeature(string $feature): bool
    {
        return in_array($feature, $this->features ?? [], true);
    }

    public function viewPath(): string
    {
        return resource_path('sites/'.$this->slug);
    }
}
