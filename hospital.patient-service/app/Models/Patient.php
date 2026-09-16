<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'patient_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'identification_type',
        'identification_number',
        'disability',
        'photo',
        'province_id',
        'district_id',
        'commune_id',
        'village_id',
        'address',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}
