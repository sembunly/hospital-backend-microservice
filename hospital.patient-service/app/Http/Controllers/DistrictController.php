<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\JsonResponse;

class DistrictController extends Controller
{
    public function index(Province $province): JsonResponse
    {
        return response()->json(
            $province->districts()
                ->where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'code', 'name']),
        );
    }
}
