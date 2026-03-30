<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;

class TrackingController extends Controller
{
    /**
     * Show the track form page.
     * Route: GET /track  →  name: track.page
     */
    public function trackPage()
    {
        return view('track');
    }

    /**
     * Handle tracking form submission and show result.
     * Route: POST /track  →  name: track.result
     */
    public function trackResult(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string',
        ]);

        $parcel = Parcel::with(['timelines', 'rating'])
            ->where('tracking_id', trim($request->tracking_number))
            ->first();

        // Set default coordinates if parcel exists but has no coordinates
        if ($parcel && (!$parcel->current_lat || !$parcel->current_lng)) {
            $parcel->current_lat = 10.0261;  // Kochi, Kerala
            $parcel->current_lng = 76.3125;
        }

        return view('main.track-result', compact('parcel'));
    }

    /**
     * Return current GPS coordinates for a parcel (polled every 5s by the map).
     * Route: GET /parcel/location/{parcel}  →  name: parcel.location
     */
    public function getLocation(Parcel $parcel)
    {
        return response()->json([
            'lat' => $parcel->current_lat ?? 10.0261,
            'lng' => $parcel->current_lng ?? 76.3125,
        ]);
    }

    /**
     * Show tracking details by tracking ID (direct URL access)
     * Route: GET /track/{tracking_id}  →  name: track
     */
    public function show($tracking_id)
    {
        $parcel = Parcel::with(['timelines', 'rating'])
            ->where('tracking_id', $tracking_id)
            ->firstOrFail();
        
        // Set default coordinates if not available (Kochi, Kerala)
        if (!$parcel->current_lat || !$parcel->current_lng) {
            $parcel->current_lat = 10.0261;
            $parcel->current_lng = 76.3125;
        }
        
        return view('main.track-result', compact('parcel'));
    }
}
