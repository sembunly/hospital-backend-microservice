<?php

namespace Tests\Feature;

use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_only_active_locations_in_the_requested_hierarchy(): void
    {
        $province = Province::create([
            'code' => '12',
            'name' => 'រាជធានីភ្នំពេញ',
            'name_other' => 'Phnom Penh',
        ]);
        $otherProvince = Province::create([
            'code' => '13',
            'name' => 'ព្រះវិហារ',
            'name_other' => 'Preah Vihear',
        ]);
        Province::create([
            'code' => '99',
            'name' => 'Inactive province',
            'is_active' => false,
        ]);

        $district = District::create([
            'province_id' => $province->getKey(),
            'code' => '1201',
            'name' => 'ចំការមន',
            'name_other' => 'Chamkar Mon',
        ]);
        District::create([
            'province_id' => $otherProvince->getKey(),
            'code' => '1301',
            'name' => 'Other district',
        ]);
        District::create([
            'province_id' => $province->getKey(),
            'code' => '1299',
            'name' => 'Inactive district',
            'is_active' => false,
        ]);

        $commune = Commune::create([
            'district_id' => $district->getKey(),
            'code' => '120101',
            'name' => 'ទន្លេបាសាក់',
            'name_other' => 'Tonle Basak',
        ]);
        Commune::create([
            'district_id' => $district->getKey(),
            'code' => '120199',
            'name' => 'Inactive commune',
            'is_active' => false,
        ]);

        $village = Village::create([
            'commune_id' => $commune->getKey(),
            'code' => '12010101',
            'name' => 'ភូមិ ១',
            'name_other' => 'Village 1',
        ]);
        Village::create([
            'commune_id' => $commune->getKey(),
            'code' => '12010199',
            'name' => 'Inactive village',
            'is_active' => false,
        ]);

        $this->getJson('/api/addresses/provinces')
            ->assertOk()
            ->assertJsonPath('data.0.id', $province->getKey())
            ->assertJsonPath('data.0.name_other', 'Phnom Penh')
            ->assertJsonCount(2, 'data');

        $this->getJson("/api/addresses/provinces/{$province->getKey()}/districts")
            ->assertOk()
            ->assertJsonPath('data.0.id', $district->getKey())
            ->assertJsonCount(1, 'data');

        $this->getJson("/api/addresses/districts/{$district->getKey()}/communes")
            ->assertOk()
            ->assertJsonPath('data.0.id', $commune->getKey())
            ->assertJsonCount(1, 'data');

        $this->getJson("/api/addresses/communes/{$commune->getKey()}/villages")
            ->assertOk()
            ->assertJsonPath('data.0.id', $village->getKey())
            ->assertJsonCount(1, 'data');
    }
}
