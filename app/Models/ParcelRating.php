<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelRating extends Model
{
    protected $fillable = [
        'parcel_id',
        'agent_id',
        'rating',
        'feedback',
        'customer_name',
        'customer_email',
    ];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Update agent's average rating when a new rating is added
     */
    protected static function booted()
    {
        static::created(function ($rating) {
            $rating->updateAgentRating();
        });

        static::updated(function ($rating) {
            $rating->updateAgentRating();
        });

        static::deleted(function ($rating) {
            $rating->updateAgentRating();
        });
    }

    /**
     * Recalculate and update agent's average rating
     */
    protected function updateAgentRating()
    {
        $agent = $this->agent;
        
        if (!$agent) {
            return;
        }

        $ratings = ParcelRating::where('agent_id', $agent->id)->get();
        
        $agent->update([
            'average_rating' => $ratings->avg('rating'),
            'total_ratings' => $ratings->count(),
        ]);
    }
}