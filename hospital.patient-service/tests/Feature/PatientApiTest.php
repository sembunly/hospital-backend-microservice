<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PatientApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_and_updates_a_patient_in_one_table(): void
    {
        $response = $this->postJson('/api/patients', [
            'patient' => [
                'first_name' => 'Sokha',
                'last_name' => 'Chan',
                'gender' => 'F',
                'date_of_birth' => '1995-05-10',
                'phone' => '012345678',
                'email' => 'sokha@example.com',
                'identification_type' => 'national_id',
                'identification_number' => 'ID-1234',
                'disability' => null,
                'photo' => 'patients/sokha.jpg',
                'province_id' => 1,
                'district_id' => 2,
                'commune_id' => 3,
                'village_id' => 4,
                'address' => '12 Main Street',
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.patient.first_name', 'Sokha')
            ->assertJsonPath('data.patient.identification_number', 'ID-1234');

        $patientId = $response->json('data.patient.id');

        $this->patchJson("/api/patients/{$patientId}", [
            'patient' => [
                'email' => 'updated@example.com',
                'disability' => 'Visual impairment',
            ],
        ])->assertOk()
            ->assertJsonPath('data.patient.email', 'updated@example.com')
            ->assertJsonPath('data.patient.disability', 'Visual impairment');

        $this->assertDatabaseHas('patients', [
            'id' => $patientId,
            'first_name' => 'Sokha',
            'email' => 'updated@example.com',
            'disability' => 'Visual impairment',
        ]);

        $this->assertFalse(Schema::hasTable('patient_identifications'));
        $this->assertFalse(Schema::hasTable('patient_disabilities'));
        $this->assertFalse(Schema::hasTable('patient_photos'));
    }

    public function test_optional_patient_fields_accept_null(): void
    {
        $this->postJson('/api/patients', [
            'patient' => [
                'first_name' => 'Dara',
                'last_name' => null,
                'email' => null,
                'address' => null,
            ],
        ])->assertCreated();

        $this->assertDatabaseHas('patients', [
            'first_name' => 'Dara',
            'last_name' => null,
            'email' => null,
            'address' => null,
        ]);
    }
}
