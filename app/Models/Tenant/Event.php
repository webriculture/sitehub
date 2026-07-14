<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use App\Support\Translate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class Event extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'external_id',
        'kind',
        'title',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'all_day',
        'registration_url',
        'raw',
        'synced_at',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'location' => 'array',
            'raw' => 'array',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'all_day' => 'boolean',
            'synced_at' => 'datetime',
        ];
    }

    /** @param Builder<self> $query */
    protected function scopeUpcoming(Builder $query): Builder
    {
        return $query
            ->where(fn (Builder $q) => $q
                ->where('starts_at', '>=', now()->startOfDay())
                ->orWhere('ends_at', '>=', now()))
            ->orderBy('starts_at');
    }

    public function localizedTitle(): ?string
    {
        return Translate::pick($this->title);
    }

    public function localizedDescription(): ?string
    {
        return Translate::pick($this->description);
    }

    public function localizedLocation(): ?string
    {
        return Translate::pick($this->location);
    }
}
