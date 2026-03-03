<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use Illuminate\Support\Facades\Storage;

class ProofOfDeliveryController extends Controller
{
    /**
     * Show proof of delivery form
     */
    public function create($id)
    {
        $parcel = Parcel::where('agent_id', auth()->id())
            ->where('status', 'out_for_delivery')
            ->findOrFail($id);

        return view('agent.proof-of-delivery', compact('parcel'));
    }

    /**
     * Store proof of delivery
     */
    public function store(Request $request, $id)
    {
        $parcel = Parcel::where('agent_id', auth()->id())
            ->findOrFail($id);

        // Validate
        $request->validate([
            'signature' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
            'recipient_name' => 'required|string|max:255',
        ]);

        // Store photo
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('delivery-photos', 'public');
        }

        // Update parcel
        $parcel->update([
            'signature_data' => $request->signature,
            'delivery_photo' => $photoPath,
            'recipient_name_confirmed' => $request->recipient_name,
            'proof_submitted_at' => now(),
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        // Add timeline entry
        $parcel->timelines()->create([
            'status' => 'delivered',
            'notes' => 'Delivered with proof of delivery',
        ]);

        return redirect()
            ->route('agent.deliveries')
            ->with('success', 'Proof of delivery submitted successfully!');
    }

    /**
     * View proof of delivery
     */
    public function show($id)
    {
        $parcel = Parcel::where('agent_id', auth()->id())
            ->findOrFail($id);

        if (!$parcel->signature_data) {
            return redirect()
                ->route('agent.delivery.show', $id)
                ->with('error', 'No proof of delivery found.');
        }

        return view('agent.proof-view', compact('parcel'));
    }
}