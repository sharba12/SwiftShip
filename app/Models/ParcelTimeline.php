<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelTimeline extends Model
{
    protected $fillable = [
        'parcel_id',
        'status',
        'notes',
        'lat',
        'lng',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}