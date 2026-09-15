<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\JsonResponse;

class VillageController extends Controller
{
    public function index(Commune $commune): JsonResponse
    {
        return response()->json(
            $commune->villages()
                ->where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'code', 'name']),
        );
    }
}
