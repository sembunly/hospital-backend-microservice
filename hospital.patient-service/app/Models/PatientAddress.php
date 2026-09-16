<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientAddress extends Model
{
    protected $fillable = [
        'patient_id', 'province_id', 'district_id', 'commune_id', 'village_id',
        'house_number', 'street_number', 'location',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
