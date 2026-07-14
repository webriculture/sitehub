<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use App\Support\Translate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Partner extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'name',
        'description',
        'programs',
        'website_url',
        'phone',
        'logo_path',
        'sort_order',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'description' => 'array',
            'programs' => 'array',
            'published' => 'boolean',
        ];
    }

    /** @param Builder<self> $query */
    protected function scopePublished(Builder $query): Builder
    {
        return $query->where('published', true)->orderBy('sort_order')->orderBy('name');
    }

    public function localizedDescription(): ?string
    {
        return Translate::pick($this->description);
    }
}
