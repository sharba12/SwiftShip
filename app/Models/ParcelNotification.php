<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelNotification extends Model
{
    protected $fillable = [
        'parcel_id',
        'type',
        'status',
        'recipient',
        'message',
        'error_message',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}