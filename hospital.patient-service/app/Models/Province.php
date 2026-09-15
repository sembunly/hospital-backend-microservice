<?php

namespace App\Models;

use Database\Factories\ProvinceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    /** @use HasFactory<ProvinceFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'name_other',
        'created_by',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'created' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
