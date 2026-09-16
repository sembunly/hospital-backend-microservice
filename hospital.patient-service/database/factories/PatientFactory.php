<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Patient> */
class PatientFactory extends Factory
{
    protected $model = Patient::class;
    public function definition(): array
    {
        return [
            'patient_code' => fake()->unique()->numerify('P26#####'),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'date_of_birth' => fake()->date(),
            'phone' => fake()->numerify('0########'),
            'email' => fake()->unique()->safeEmail(),
            'identification_type' => 'National ID',
            'identification_number' => fake()->unique()->numerify('#########'),
            'disability' => null,
            'province_id' => 5,
            'district_id' => 43,
            'commune_id' => 366,
            'village_id' => 3244,
            'photo' => null,
            'is_active' => 1,
            'created_by' => null,
            'modified_by' => null,
        ];
    }
}
