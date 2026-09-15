<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPhoto extends Model
{
    protected $fillable = [
        'patient_id',
        'url',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
