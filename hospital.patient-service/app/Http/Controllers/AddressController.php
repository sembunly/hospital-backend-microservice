<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    public function provinces(): JsonResponse
    {
        return $this->response(Province::query()->where('is_active', true)->orderBy('code')->get());
    }

    public function districts(Province $province): JsonResponse
    {
        return $this->response($province->districts()->where('is_active', true)->orderBy('code')->get());
    }

    public function communes(District $district): JsonResponse
    {
        return $this->response($district->communes()->where('is_active', true)->orderBy('code')->get());
    }

    public function villages(Commune $commune): JsonResponse
    {
        return $this->response($commune->villages()->where('is_active', true)->orderBy('code')->get());
    }

    private function response(Collection $locations): JsonResponse
    {
        return response()->json([
            'data' => $locations->map(fn ($location) => [
                'id' => $location->getKey(),
                'code' => $location->code,
                'name' => $location->name,
                'name_other' => $location->name_other,
            ])->values(),
        ]);
    }
}
