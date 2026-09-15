<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\JsonResponse;

class CommuneController extends Controller
{
    public function index(District $district): JsonResponse
    {
        return response()->json(
            $district->communes()
                ->where('is_active', true)
                ->orderBy('code')
                ->get(['id', 'code', 'name']),
        );
    }
}
