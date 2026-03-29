<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parcel;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.index');
    }

    public function dailyDelivered()
    {
        $today = Carbon::today();
        $parcels = Parcel::whereDate('updated_at', $today)
                         ->where('status', 'delivered')
                         ->get();

        return view('admin.report.daily', compact('parcels', 'today'));
    }

    public function pendingParcels()
    {
        $parcels = Parcel::where('status', 'pending')->get();
        return view('admin.report.pending', compact('parcels'));
    }

    public function agentPerformance()
    {
        $agents = User::where('role', 'agent')
            ->withCount([
                'parcels as delivered_count' => function ($q) {
                    $q->where('status', 'delivered');
                },
                'parcels as pending_count' => function ($q) {
                    $q->where('status', 'pending');
                }
            ])
            ->get();

        return view('admin.report.agents', compact('agents'));
    }


    public function customerUsage()
    {
        $customers = Customer::withCount('parcels')->get();

        return view('admin.report.customers', compact('customers'));
    }

    public function customerReportPDF()
    {
        $customers = Customer::withCount('parcels')->get();

        $pdf = Pdf::loadView('admin.report.customers_pdf', compact('customers'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('customer_report.pdf');
    }

    public function DailyReportPDF()
    {
        $today = now()->toDateString();
        $parcels = Parcel::where('status', 'delivered')
                         ->whereDate('updated_at', $today)
                         ->get();

        $pdf = Pdf::loadView('admin.report.daily_pdf', compact('parcels', 'today'));
        return $pdf->download('delivered_today_report.pdf');
    }

    // 2️⃣ Pending Parcels PDF
    public function PendingReportPDF()
    {
        $parcels = Parcel::where('status', 'pending')->get();

        $pdf = Pdf::loadView('admin.report.pending_pdf', compact('parcels'));
        return $pdf->download('pending_parcels_report.pdf');
    }

    // 3️⃣ Agent Performance PDF
    public function AgentReportPDF()
    {
        $performance = Parcel::selectRaw('users.name as agent_name,
                SUM(CASE WHEN parcels.status = "delivered" THEN 1 ELSE 0 END) AS delivered_count,
                SUM(CASE WHEN parcels.status = "pending" THEN 1 ELSE 0 END) AS pending_count'
            )
            ->leftJoin('users', 'parcels.agent_id', '=', 'users.id')
            ->groupBy('users.name')
            ->get();

        $pdf = Pdf::loadView('admin.report.agent_pdf', compact('performance'));
        return $pdf->download('agent_performance_report.pdf');
    }

}
