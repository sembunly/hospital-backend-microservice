<?php

namespace App\Models;

use Database\Factories\VillageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Village extends Model
{
    /** @use HasFactory<VillageFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'commune_id',
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

    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
}
