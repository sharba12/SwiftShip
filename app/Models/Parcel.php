<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    protected $fillable = [
        'tracking_id', 
        'customer_id', 
        'agent_id',
        'sender_name', 
        'receiver_name', 
        'receiver_contact',
        'parcel_description', 
        'weight',
        'address_from', 
        'address_to',
        'status', 
        'notes',
        'current_lat', 
        'current_lng',
        'in_transit_at', 
        'out_for_delivery_at', 
        'delivered_at',
        'signature_data',
        'delivery_photo',
        'recipient_name_confirmed',
        'proof_submitted_at',
    ];

    protected $casts = [
        'in_transit_at' => 'datetime',
        'out_for_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'proof_submitted_at' => 'datetime',
    ];

    public function rating()
    {
        return $this->hasOne(ParcelRating::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function timelines()
    {
        return $this->hasMany(ParcelTimeline::class)->latest();
    }

    public function statusLogs()
    {
        return $this->hasMany(ParcelStatusLog::class)->latest();
    }

    public function notifications()
    {
        return $this->hasMany(ParcelNotification::class)->latest();
    }
}