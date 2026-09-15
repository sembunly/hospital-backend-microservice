<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<District>
 */
class DistrictFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'province_id' => Province::factory(),
            'code' => fake()->unique()->numerify('####'),
            'name' => fake()->city(),
            'name_other' => fake()->city(),
            'created_by' => null,
            'is_active' => true,
        ];
    }
}
