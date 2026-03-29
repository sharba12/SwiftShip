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

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}