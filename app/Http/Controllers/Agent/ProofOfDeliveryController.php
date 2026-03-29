<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        // Validate - make photo optional since we have photo_data
        $request->validate([
            'signature' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'photo_data' => 'nullable|string',
            'recipient_name' => 'required|string|max:255',
        ]);

        // Store signature (base64)
        $signaturePath = $this->saveBase64Image($request->signature, 'signatures');

        // Store photo - handle both file upload and base64
        $photoPath = null;
        
        if ($request->hasFile('photo')) {
            // Photo uploaded as file
            $photoPath = $request->file('photo')->store('delivery-photos', 'public');
        } elseif ($request->photo_data) {
            // Photo from camera (base64)
            $photoPath = $this->saveBase64Image($request->photo_data, 'delivery-photos');
        }

        // Validate that we have both signature and photo
        if (!$signaturePath) {
            return back()->withErrors(['signature' => 'Failed to save signature.'])->withInput();
        }

        if (!$photoPath) {
            return back()->withErrors(['photo' => 'Please capture or upload a delivery photo.'])->withInput();
        }

        // Update parcel
        $parcel->update([
            'signature_data' => $signaturePath,
            'delivery_photo' => $photoPath,
            'recipient_name_confirmed' => $request->recipient_name,
            'proof_submitted_at' => now(),
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        // Add timeline entry
        $parcel->timelines()->create([
            'status' => 'delivered',
            'notes' => 'Delivered with proof of delivery to ' . $request->recipient_name,
        ]);

        // Log status change
        if ($parcel->relationLoaded('statusLogs') || method_exists($parcel, 'statusLogs')) {
            $parcel->statusLogs()->create([
                'old_status' => 'out_for_delivery',
                'new_status' => 'delivered',
                'changed_by' => auth()->id(),
                'notes' => 'Proof of delivery submitted',
            ]);
        }

        return redirect()
            ->route('agent.deliveries')
            ->with('success', '✅ Proof of delivery submitted successfully! Parcel marked as delivered.');
    }

    /**
     * View proof of delivery
     */
    public function show($id)
    {
        $parcel = Parcel::where('agent_id', auth()->id())
            ->findOrFail($id);

        if (!$parcel->signature_data && !$parcel->delivery_photo) {
            return redirect()
                ->route('agent.delivery.show', $id)
                ->with('error', 'No proof of delivery found.');
        }

        return view('agent.proof-view', compact('parcel'));
    }

    /**
     * Save base64 image to storage
     * 
     * @param string $base64String
     * @param string $folder
     * @return string|null
     */
    private function saveBase64Image($base64String, $folder)
    {
        try {
            // Remove data URI prefix if present
            if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
                $base64String = substr($base64String, strpos($base64String, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif, etc.

                // Validate image type
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    \Log::error('Invalid image type: ' . $type);
                    return null;
                }
            } else {
                // Assume PNG if no type specified
                $type = 'png';
            }

            // Clean up base64 string
            $base64String = str_replace(' ', '+', $base64String);
            $imageData = base64_decode($base64String);

            if ($imageData === false) {
                \Log::error('Base64 decode failed');
                return null;
            }

            // Verify it's actually image data
            if (strlen($imageData) < 100) {
                \Log::error('Image data too small: ' . strlen($imageData) . ' bytes');
                return null;
            }

            // Generate unique filename
            $fileName = $folder . '/' . date('Y-m-d') . '-' . Str::random(20) . '.' . $type;

            // Save to storage
            $saved = Storage::disk('public')->put($fileName, $imageData);

            if (!$saved) {
                \Log::error('Failed to save file to storage: ' . $fileName);
                return null;
            }

            \Log::info('Image saved successfully: ' . $fileName . ' (' . strlen($imageData) . ' bytes)');
            
            return $fileName;

        } catch (\Exception $e) {
            \Log::error('Error saving base64 image: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }
}