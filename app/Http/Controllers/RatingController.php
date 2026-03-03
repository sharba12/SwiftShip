<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\ParcelRating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Show rating form
     */
    public function create($trackingId)
    {
        $parcel = Parcel::where('tracking_id', $trackingId)
            ->with(['agent', 'customer'])
            ->firstOrFail();

        // Check if already rated
        if ($parcel->rating) {
            return view('ratings.already-rated', compact('parcel'));
        }

        // Only allow rating for delivered parcels
        if ($parcel->status !== 'delivered') {
            return view('ratings.not-delivered', compact('parcel'));
        }

        return view('ratings.create', compact('parcel'));
    }

    /**
     * Store rating
     */
    public function store(Request $request, $trackingId)
    {
        $parcel = Parcel::where('tracking_id', $trackingId)->firstOrFail();

        // Validate
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
        ]);

        // Check if already rated
        if ($parcel->rating) {
            return redirect()
                ->route('rating.create', $trackingId)
                ->with('error', 'This parcel has already been rated.');
        }

        // Create rating
        ParcelRating::create([
            'parcel_id' => $parcel->id,
            'agent_id' => $parcel->agent_id,
            'rating' => $validated['rating'],
            'feedback' => $validated['feedback'] ?? null,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'] ?? null,
        ]);

        return view('ratings.thank-you', compact('parcel'));
    }

    /**
     * Show agent ratings (for admin)
     */
    public function agentRatings($agentId)
    {
        $agent = \App\Models\User::where('role', 'agent')->findOrFail($agentId);
        
        $ratings = ParcelRating::where('agent_id', $agentId)
            ->with('parcel')
            ->latest()
            ->paginate(20);

        return view('admin.agent-ratings', compact('agent', 'ratings'));
    }
}