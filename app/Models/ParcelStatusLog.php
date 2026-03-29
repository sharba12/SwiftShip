<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelStatusLog extends Model
{
    protected $fillable = [
        'parcel_id',
        'old_status',
        'new_status',
        'changed_by',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}