<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'nullable|string|max:100',
            'gender'        => 'required|in:male,female',
            'date_of_birth' => 'required|date',
            'phone'         => 'required|string|max:20',
            'email'         => 'nullable|email|max:255',
            'address'       => 'nullable|string|max:255',
        ]);

        $patient = Patient::create([
            'patient_code'  => $this->generatePatientCode(),
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'] ?? null,
            'gender'        => $validated['gender'],
            'date_of_birth' => $validated['date_of_birth'],
            'phone'         => $validated['phone'],
            'email'         => $validated['email'] ?? null,
            'address'       => $validated['address'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Patient registered successfully.',
            'data' => $patient,
        ], 201);
    }

    private function generatePatientCode()
    {
        do {
            $code = 'P' . date('Ymd') . random_int(1000, 9999);
        } while (Patient::where('patient_code', $code)->exists());

        return $code;
    }
}
