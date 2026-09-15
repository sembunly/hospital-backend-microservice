<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'patient_code',
        'surname',
        'name',
        'sex',
        'birthdate',
        'phone',
        'nationality',
        'occupation',
        'marital_status',
        'death_date',
        'spid',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'death_date' => 'date',
    ];

    public function address()
    {
        return $this->hasOne(PatientAddress::class);
    }

    public function identifications()
    {
        return $this->hasMany(PatientIdentification::class);
    }

    public function disabilities()
    {
        return $this->hasMany(PatientDisability::class);
    }

    public function photos()
    {
        return $this->hasMany(PatientPhoto::class);
    }
}
