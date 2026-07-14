<?php

declare(strict_types=1);

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

final class Gallery extends Model
{
    protected $connection = 'tenant';

    protected $fillable = [
        'slug',
        'title',
        'description',
        'sort_order',
    ];
}
