<?php
namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Parcel;

class DashboardController extends Controller
{
    public function index()
    {
        // Get currently logged-in agent
        $agentId = Auth::id(); // or Auth::user()->id

        // Get all parcels assigned to this agent
        $parcels = Parcel::where('agent_id', $agentId)->get();

        return view('agent.dashboard', [
            'total' => $parcels->count(),
            'pending' => $parcels->where('status', 'pending')->count(),
            'delivered' => $parcels->where('status', 'delivered')->count(),
            'failed' => $parcels->where('status', 'failed')->count(),
        ]);
    }

    public function profile()
    {
        return view('agent.profile');
    }
}
