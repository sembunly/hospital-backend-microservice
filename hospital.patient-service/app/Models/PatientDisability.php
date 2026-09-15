<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientIdentification extends Model
{
    protected $fillable = [
        'patient_id',
        'card_code',
        'card_type',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
