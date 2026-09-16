<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Patient::query()->where('is_active', '!=', 0)->latest()->get()]);
    }

    public function show(Patient $patient)
    {
        return response()->json(['data' => ['patient' => $patient]]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $patient = Patient::create([
            ...$validated['patient'],
            'is_active' => 1,
            'created_by' => auth()->id(),
            'patient_code' => $this->generatePatientCode(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Patient registered successfully.',
            'data' => [
                'patient' => $patient,
            ],
        ], 201);
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate($this->rules(true));

        $patient->fill($validated['patient']);
        $patient->is_active = 2;
        $patient->modified_by = auth()->id();
        $patient->save();

        return response()->json([
            'success' => true,
            'message' => 'Patient updated successfully.',
            'data' => [
                'patient' => $patient->fresh(),
            ],
        ]);
    }

    public function destroy(Patient $patient)
    {
        $patient->is_active = 0;
        $patient->modified_by = auth()->id();
        $patient->save();

        return response()->json(['success' => true, 'message' => 'Patient deactivated successfully.']);
    }

    private function rules(bool $updating = false): array
    {
        $required = $updating ? 'sometimes|required' : 'required';
        $optional = $updating ? 'sometimes|nullable' : 'nullable';

        return [
            'patient' => 'required|array',
            'patient.first_name' => "$required|string|max:100",
            'patient.last_name' => "$optional|string|max:100",
            'patient.gender' => "$optional|string|max:20",
            'patient.date_of_birth' => "$optional|date|before_or_equal:today",
            'patient.phone' => "$optional|string|max:30",
            'patient.email' => "$optional|email|max:255",
            'patient.identification_type' => "$optional|string|max:100",
            'patient.identification_number' => "$optional|string|max:100",
            'patient.disability' => "$optional|string|max:255",
            'patient.photo' => "$optional|string|max:500",
            'patient.province_id' => "$optional|integer|min:1",
            'patient.district_id' => "$optional|integer|min:1",
            'patient.commune_id' => "$optional|integer|min:1",
            'patient.village_id' => "$optional|integer|min:1",
            'patient.address' => "$optional|string|max:500",
        ];
    }

    private function generatePatientCode(): string
    {
        do {
            $code = 'P' . date('y') . random_int(100000, 999999);
        } while (Patient::where('patient_code', $code)->exists());

        return $code;
    }
}
