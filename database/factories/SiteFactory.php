<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Site>
 */
final class SiteFactory extends Factory
{
    protected $model = Site::class;

    public function definition(): array
    {
        $slug = $this->faker->unique()->slug(2);

        return [
            'name' => str($slug)->replace('-', ' ')->title()->toString(),
            'slug' => $slug,
            'features' => [],
            'settings' => [],
        ];
    }
}
