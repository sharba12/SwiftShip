<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParcelStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'parcel_id',
        'status',
        'remarks',
        'latitude',
        'longitude',
    ];
}
