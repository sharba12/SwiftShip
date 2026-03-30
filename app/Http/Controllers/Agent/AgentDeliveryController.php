<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class AgentDeliveryController extends Controller
{
    public function index()
    {
        $agentId = Auth::id();

        $parcels = Parcel::where('agent_id', $agentId)->get();

        $total = $parcels->count();
        $pending = $parcels->where('status', 'pending')->count();
        $delivered = $parcels->where('status', 'delivered')->count();
        $failed = $parcels->where('status', 'failed')->count();

        return view('agent.deliveries', compact(
            'total',
            'pending',
            'delivered',
            'failed',
            'parcels'
        ));
    }
    

    public function show($id)
{
    $parcel = Parcel::where('agent_id', auth()->id())
        ->with('timelines')
        ->findOrFail($id);

    return view('agent.delivery_show', compact('parcel'));
}


public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,in_transit,out_for_delivery,delivered,failed',
        'notes' => 'nullable|string|max:1000',
    ]);

    // Fetch the parcel first
    $parcel = Parcel::findOrFail($id);
    
    // Store the old status
    $oldStatus = $parcel->status;
    
    // Update the parcel
    $parcel->update([
        'status' => $request->status,
        'notes' => $request->notes,
    ]);
    
    // Send notification
    $notificationService = new NotificationService();
    $notificationService->notifyStatusChange($parcel, $oldStatus, $request->status);
    
    // If delivered, send confirmation with rating link
    if ($request->status === 'delivered' && $oldStatus !== 'delivered') {
        $notificationService->sendDeliveryConfirmation($parcel);
    }
    
    return redirect()->back()->with('success', 'Delivery status updated successfully');
}

}
