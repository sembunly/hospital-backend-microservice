<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient.surname' => 'nullable|string|max:100',
            'patient.name' => 'required|string|max:100',

            'patient.sex' => 'required|in:M,F',
            'patient.birthdate' => 'required|date|before_or_equal:today',

            'patient.phone' => 'required|string|max:30',

            'patient.nationality' => 'nullable|string|max:100',
            'patient.occupation' => 'nullable|string|max:100',
            'patient.marital_status' => 'nullable|string|max:50',

            'patient.death_date' => 'nullable|date',
            'patient.spid' => 'nullable|string|max:50|unique:patients,spid',

            'patient.disabilities' => 'nullable|array',
            'patient.disabilities.*' => 'nullable|string|max:150',

            'patient.photos' => 'nullable|array',
            'patient.photos.*' => 'nullable|url|max:500',

            'patient.address' => 'nullable|array',

            'patient.address.province.code' => 'nullable|string|max:20',
            'patient.address.province.name' => 'nullable|string|max:100',

            'patient.address.district.code' => 'nullable|string|max:20',
            'patient.address.district.name' => 'nullable|string|max:100',

            'patient.address.commune.code' => 'nullable|string|max:20',
            'patient.address.commune.name' => 'nullable|string|max:100',

            'patient.address.village.code' => 'nullable|string|max:20',
            'patient.address.village.name' => 'nullable|string|max:100',

            'patient.address.house_number' => 'nullable|string|max:50',
            'patient.address.street_number' => 'nullable|string|max:50',
            'patient.address.location' => 'nullable|string|max:255',

            'patient.identifications' => 'nullable|array',

            'patient.identifications.*.card_code' =>
                'required|string|max:100',

            'patient.identifications.*.card_type' =>
                'required|string|max:100',
        ]);

        $data = $validated['patient'];

        $patient = DB::transaction(function () use ($data) {

            $patient = Patient::create([
                'patient_code' => $this->generatePatientCode(),

                'surname' => $data['surname'] ?? null,
                'name' => $data['name'],
                'sex' => $data['sex'],
                'birthdate' => $data['birthdate'],

                'phone' => $data['phone'],

                'nationality' => $data['nationality'] ?? null,
                'occupation' => $data['occupation'] ?? null,
                'marital_status' => $data['marital_status'] ?? null,

                'death_date' => $data['death_date'] ?? null,

                'spid' => $data['spid'] ?? null,
            ]);

            if (!empty($data['address'])) {
                $address = $data['address'];

                $patient->address()->create([
                    'province_code' =>
                        $address['province']['code'] ?? null,

                    'province_name' =>
                        $address['province']['name'] ?? null,

                    'district_code' =>
                        $address['district']['code'] ?? null,

                    'district_name' =>
                        $address['district']['name'] ?? null,

                    'commune_code' =>
                        $address['commune']['code'] ?? null,

                    'commune_name' =>
                        $address['commune']['name'] ?? null,

                    'village_code' =>
                        $address['village']['code'] ?? null,

                    'village_name' =>
                        $address['village']['name'] ?? null,

                    'house_number' =>
                        $address['house_number'] ?? null,

                    'street_number' =>
                        $address['street_number'] ?? null,

                    'location' =>
                        $address['location'] ?? null,
                ]);
            }

            foreach ($data['identifications'] ?? [] as $identification) {
                $patient->identifications()->create([
                    'card_code' => $identification['card_code'],
                    'card_type' => $identification['card_type'],
                ]);
            }

            foreach ($data['disabilities'] ?? [] as $disability) {
                if (!empty($disability)) {
                    $patient->disabilities()->create([
                        'name' => $disability,
                    ]);
                }
            }

            foreach ($data['photos'] ?? [] as $photo) {
                if (!empty($photo)) {
                    $patient->photos()->create([
                        'url' => $photo,
                    ]);
                }
            }

            return $patient;
        });

        $patient->load([
            'address',
            'identifications',
            'disabilities',
            'photos',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Patient registered successfully.',
            'data' => [
                'patient' => $this->formatPatient($patient),
            ],
        ], 201);
    }

    private function generatePatientCode()
    {
        do {
            $year = date('y');

            $number = random_int(100000, 999999);

            $code = 'P' . $year . $number;

        } while (
            Patient::where('patient_code', $code)->exists()
        );

        return $code;
    }

    private function formatPatient(Patient $patient)
    {
        return [
            'code' => $patient->patient_code,

            'surname' => $patient->surname,
            'name' => $patient->name,

            'sex' => $patient->sex,

            'birthdate' => $patient->birthdate
                ? $patient->birthdate->format('Y-m-d')
                : null,

            'phone' => $patient->phone,

            'nationality' => $patient->nationality,

            'disabilities' => $patient
                ->disabilities
                ->pluck('name')
                ->values(),

            'occupation' => $patient->occupation,

            'marital_status' => $patient->marital_status,

            'photos' => $patient
                ->photos
                ->pluck('url')
                ->values(),

            'address' => $patient->address ? [
                'province' => [
                    'code' => $patient->address->province_code,
                    'name' => $patient->address->province_name,
                ],

                'district' => [
                    'code' => $patient->address->district_code,
                    'name' => $patient->address->district_name,
                ],

                'commune' => [
                    'code' => $patient->address->commune_code,
                    'name' => $patient->address->commune_name,
                ],

                'village' => [
                    'code' => $patient->address->village_code,
                    'name' => $patient->address->village_name,
                ],

                'house_number' =>
                    $patient->address->house_number,

                'street_number' =>
                    $patient->address->street_number,

                'location' =>
                    $patient->address->location,
            ] : null,

            'identifications' => $patient
                ->identifications
                ->map(function ($identification) use ($patient) {
                    return [
                        'patient_code' => $patient->patient_code,
                        'card_code' => $identification->card_code,
                        'card_type' => $identification->card_type,
                    ];
                })
                ->values(),

            'death_date' => $patient->death_date
                ? $patient->death_date->format('Y-m-d')
                : null,

            'spid' => $patient->spid,

            'created_at' => $patient->created_at,
            'updated_at' => $patient->updated_at,
        ];
    }
}
