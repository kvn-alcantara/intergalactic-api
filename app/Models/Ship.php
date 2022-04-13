<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Ship
 *
 * @mixin Eloquent
 */
class Ship extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pilot_id',
        'fuel_capacity',
        'fuel_level',
        'weight_capacity',
    ];

    /**
     * Get the pilot that owns the ship.
     */
    public function pilot(): BelongsTo
    {
        return $this->belongsTo(Pilot::class);
    }
}
