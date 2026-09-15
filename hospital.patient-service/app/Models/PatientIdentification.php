<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientDisability extends Model
{
    protected $fillable = [
        'patient_id',
        'name',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
