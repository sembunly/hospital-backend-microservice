<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;
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
        'is_active',
        'created_by',
        'modified_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        // Keep the three-state lifecycle value (0 = deleted, 1 = active, 2 = edited).
        'is_active' => 'integer',
    ];
}
