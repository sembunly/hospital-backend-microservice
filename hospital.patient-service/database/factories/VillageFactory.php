<?php

namespace Database\Factories;

use App\Models\Commune;
use App\Models\Village;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Village>
 */
class VillageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'commune_id' => Commune::factory(),
            'code' => fake()->unique()->numerify('########'),
            'name' => fake()->streetName(),
            'name_other' => fake()->streetName(),
            'created_by' => null,
            'is_active' => true,
        ];
    }
}
