<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domain;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Domain>
 */
final class DomainFactory extends Factory
{
    protected $model = Domain::class;

    public function definition(): array
    {
        return [
            'site_id' => Site::factory(),
            'hostname' => $this->faker->unique()->domainName(),
            'is_primary' => false,
            'redirect_to_primary' => true,
        ];
    }

    public function primary(): self
    {
        return $this->state(['is_primary' => true]);
    }
}
