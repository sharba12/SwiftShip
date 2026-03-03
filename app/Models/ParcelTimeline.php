<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelTimeline extends Model
{
    protected $fillable = [
        'parcel_id',
        'status',
        'notes',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}