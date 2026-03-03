<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parcel;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalParcels = Parcel::count();
        $delivered = Parcel::where('status', 'delivered')->count();
        $pending = Parcel::where('status', 'pending')->count();
        $inTransit = Parcel::where('status', 'in_transit')->count();
        $failed = Parcel::where('status', 'failed')->count();

        return view('admin.dashboard', compact(
            'totalParcels', 'delivered', 'pending', 'inTransit', 'failed'
        ));
    }
    public function agentLocations()
    {
        $agents = User::where('role', 'agent')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get(['id', 'name', 'latitude', 'longitude']);

        return response()->json($agents);
    }

}
