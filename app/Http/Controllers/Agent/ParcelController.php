<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parcel;
use App\Models\ParcelTimeline;

class ParcelController extends Controller
{
    /**
     * Return live location of a parcel (polled by public tracking page every 5s).
     * Route: GET /parcel/location/{parcel}  →  name: parcel.location
     */
    public function liveLocation(Parcel $parcel)
    {
        return response()->json([
            'lat' => $parcel->current_lat,   // ✅ correct column
            'lng' => $parcel->current_lng,   // ✅ correct column
        ]);
    }

    /**
     * Receive GPS coordinates from the agent device and persist them.
     * Route: POST /agent/update-location  →  name: agent.update.location
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'parcel_id' => 'required|integer|exists:parcels,id',
            'lat'       => 'required|numeric|between:-90,90',
            'lng'       => 'required|numeric|between:-180,180',
        ]);

        $parcel = Parcel::findOrFail($request->parcel_id);

        if ($parcel->agent_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $parcel->update([
            'current_lat' => $request->lat,  // ✅ correct column
            'current_lng' => $request->lng,  // ✅ correct column
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * List all deliveries for the logged-in agent.
     * Route: GET /agent/deliveries  →  name: agent.deliveries
     */
    public function index()
    {
        $parcels = Parcel::where('agent_id', Auth::id())->get(); // ✅ Auth now imported

        return view('agent.deliveries', compact('parcels'));
    }

    /**
     * Show a single delivery in detail.
     * Route: GET /agent/deliveries/{id}  →  name: agent.delivery.show
     */
    public function show($id)
    {
        $parcel = Parcel::where('agent_id', Auth::id())
                        ->with('timelines')
                        ->findOrFail($id);

        return view('agent.deliveries.show', compact('parcel'));
    }

    /**
     * Update delivery status + log the change to parcel_timelines.
     * Route: POST /agent/deliveries/{id}/status  →  name: agent.delivery.update
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,in_transit,out_for_delivery,delivered,failed',
            'notes'  => 'nullable|string|max:500',
        ]);

        $parcel = Parcel::findOrFail($id);

        if ($parcel->agent_id !== Auth::id()) {
            abort(403);
        }

        // Auto-stamp timestamp fields only once per status
        $timestamps = [];
        if ($request->status === 'in_transit'       && !$parcel->in_transit_at)       $timestamps['in_transit_at']       = now();
        if ($request->status === 'out_for_delivery' && !$parcel->out_for_delivery_at) $timestamps['out_for_delivery_at'] = now();
        if ($request->status === 'delivered'        && !$parcel->delivered_at)        $timestamps['delivered_at']        = now();

        $parcel->update(array_merge([
            'status' => $request->status,
            'notes'  => $request->notes,
        ], $timestamps));

        // Write to parcel_timelines — this powers the timeline UI on the delivery detail page
        ParcelTimeline::create([
            'parcel_id' => $parcel->id,
            'status'    => $request->status,
            'notes'     => $request->notes,
        ]);

        return back()->with('success', 'Status updated successfully.');
    }
}