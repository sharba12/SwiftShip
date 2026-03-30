<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\Customer;
use App\Models\User;
use App\Services\NotificationService;

class ParcelController extends Controller
{
    /**
     * List parcels with optional search
     */
    public function index(Request $request)
    {
        $query = Parcel::query()->with(['customer', 'agent']);

        // Filter by tracking ID
        if ($request->filled('tracking_id')) {
            $query->where('tracking_id', 'like', '%'.$request->tracking_id.'%');
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $parcels = $query->latest()->paginate(15);
        $customers = Customer::all();

        return view('admin.parcels.index', compact('parcels', 'customers'));
    }

    /**
     * Show parcel details
     */
    public function show($id)
    {
        $parcel = Parcel::with(['customer', 'agent', 'timelines', 'rating'])
            ->findOrFail($id);

        return view('admin.parcels.show', compact('parcel'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $customers = Customer::all();
        $agents = User::where('role', 'agent')->get();

        return view('admin.parcels.create', compact('customers', 'agents'));
    }

    /**
     * Store new parcel
     */
    public function store(Request $request)
    {
        // Validate form
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'agent_id' => 'required|exists:users,id',
            'sender_name' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_contact' => 'required|string',
            'weight' => 'required|numeric',
            'address_from' => 'required|string',
            'address_to' => 'required|string',
        ]);

        // Create parcel with explicit fields
        Parcel::create([
            'customer_id' => $request->customer_id,
            'agent_id' => $request->agent_id,
            'sender_name' => $request->sender_name,
            'receiver_name' => $request->receiver_name,
            'receiver_contact' => $request->receiver_contact,
            'weight' => $request->weight,
            'address_from' => $request->address_from,
            'address_to' => $request->address_to,
            'tracking_id' => 'TRK' . strtoupper(uniqid()),
            'status' => 'pending',
            'current_lat' => null,
            'current_lng' => null
        ]);

        return redirect()->route('admin.parcels.index')
            ->with('success', 'Parcel created successfully.');
    }

    /**
     * Edit parcel
     */
    public function edit($id)
    {
        $parcel = Parcel::findOrFail($id);
        $customers = Customer::all();
        $agents = User::where('role', 'agent')->get();

        return view('admin.parcels.edit', compact('parcel', 'customers', 'agents'));
    }

    /**
     * Update parcel
     */
    public function update(Request $request, $id, NotificationService $notificationService)
    {
        $parcel = Parcel::findOrFail($id);
        $oldStatus = $parcel->status;

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'agent_id' => 'required|exists:users,id',
            'sender_name' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_contact' => 'required|string',
            'weight' => 'required|numeric',
            'address_from' => 'required|string',
            'address_to' => 'required|string',
            'status' => 'required|in:pending,in_transit,out_for_delivery,delivered,failed',
        ]);

        $parcel->update($request->only([
            'customer_id',
            'agent_id',
            'sender_name',
            'receiver_name',
            'receiver_contact',
            'weight',
            'address_from',
            'address_to',
            'status',
        ]));

        $newStatus = $parcel->status;
        if ($oldStatus !== $newStatus) {
            $notificationService->notifyStatusChange($parcel, $oldStatus, $newStatus);

            if ($newStatus === 'delivered' && $oldStatus !== 'delivered') {
                $notificationService->sendDeliveryConfirmation($parcel);
            }
        }

        return redirect()->route('admin.parcels.show', $parcel->id)
            ->with('success', 'Parcel updated successfully.');
    }

    /**
     * Delete parcel
     */
    public function destroy($id)
    {
        $parcel = Parcel::findOrFail($id);
        $parcel->delete();

        return redirect()->route('admin.parcels.index')
            ->with('success', 'Parcel deleted successfully.');
    }

    /**
     * Trigger customer notification email manually from admin panel
     */
    public function notify($id, NotificationService $notificationService)
    {
        $parcel = Parcel::with('customer')->findOrFail($id);

        if (!$parcel->customer || !$parcel->customer->email) {
            return redirect()->route('admin.parcels.show', $parcel->id)
                ->with('error', 'Customer email is not available for this parcel.');
        }

        $sent = $notificationService->sendStatusEmail($parcel);

        if (!$sent) {
            return redirect()->route('admin.parcels.show', $parcel->id)
                ->with('error', 'Failed to send notification email. Please check mail settings/logs.');
        }

        return redirect()->route('admin.parcels.show', $parcel->id)
            ->with('success', 'Notification email sent successfully.');
    }
}
