<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Services\NotificationService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    /**
     * Show QR scanner page
     */
    public function scanner()
    {
        return view('agent.qr-scanner');
    }

    /**
     * Process scanned QR code
     */
    public function scan(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string'
        ]);

        $parcel = Parcel::where('tracking_id', $request->tracking_id)
            ->where('agent_id', auth()->id())
            ->first();

        if (!$parcel) {
            return response()->json([
                'success' => false,
                'message' => 'Parcel not found or not assigned to you'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'parcel' => [
                'id' => $parcel->id,
                'tracking_id' => $parcel->tracking_id,
                'receiver_name' => $parcel->receiver_name,
                'receiver_contact' => $parcel->receiver_contact,
                'address_to' => $parcel->address_to,
                'status' => $parcel->status,
                'weight' => $parcel->weight,
            ],
            'redirect' => route('agent.delivery.show', $parcel->id)
        ]);
    }

    /**
     * Quick status update via QR scan
     */
    public function quickUpdate(Request $request, NotificationService $notificationService)
    {
        $request->validate([
            'tracking_id' => 'required|string',
            'action' => 'required|in:picked_up,in_transit,delivered'
        ]);

        $parcel = Parcel::where('tracking_id', $request->tracking_id)
            ->where('agent_id', auth()->id())
            ->first();

        if (!$parcel) {
            return response()->json([
                'success' => false,
                'message' => 'Parcel not found'
            ], 404);
        }

        $statusMap = [
            'picked_up' => 'in_transit',
            'in_transit' => 'out_for_delivery',
            'delivered' => 'delivered'
        ];

        $newStatus = $statusMap[$request->action];
        $oldStatus = $parcel->status;

        $parcel->update([
            'status' => $newStatus,
            $newStatus . '_at' => now()
        ]);

        $parcel->timelines()->create([
            'status' => $newStatus,
            'notes' => 'Updated via QR scan'
        ]);

        $notificationService->notifyStatusChange($parcel, $oldStatus, $newStatus);
        if ($newStatus === 'delivered' && $oldStatus !== 'delivered') {
            $notificationService->sendDeliveryConfirmation($parcel);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'new_status' => $newStatus
        ]);
    }

    /**
     * Generate QR code for parcel (Admin use)
     */
    public function generate($trackingId)
    {
        $parcel = Parcel::where('tracking_id', $trackingId)->firstOrFail();

        $qrCode = QrCode::size(300)
            ->margin(2)
            ->format('png')
            ->generate($trackingId);

        return response($qrCode)->header('Content-Type', 'image/png');
    }

    /**
     * Download QR code as PDF label
     */
    public function downloadLabel($trackingId)
    {
        $parcel = Parcel::where('tracking_id', $trackingId)->firstOrFail();

        $qrCode = base64_encode(QrCode::size(200)
            ->format('png')
            ->generate($trackingId));

        $pdf = \PDF::loadView('admin.parcels.qr-label', compact('parcel', 'qrCode'));

        return $pdf->download("label-{$trackingId}.pdf");
    }
}
