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
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'settings' => 'array',
        ];
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
