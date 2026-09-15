<?php

namespace Database\Factories;

use App\Models\Commune;
use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Commune>
 */
class CommuneFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'district_id' => District::factory(),
            'code' => fake()->unique()->numerify('######'),
            'name' => fake()->city(),
            'name_other' => fake()->city(),
            'created_by' => null,
            'is_active' => true,
        ];
    }
}
