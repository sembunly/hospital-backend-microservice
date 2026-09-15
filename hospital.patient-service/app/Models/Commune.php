<?php

namespace App\Models;

use Database\Factories\CommuneFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commune extends Model
{
    /** @use HasFactory<CommuneFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'district_id',
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

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function villages(): HasMany
    {
        return $this->hasMany(Village::class);
    }
}
