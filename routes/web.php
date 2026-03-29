<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ParcelController as AdminParcelController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::get('/', [MainPageController::class, 'landingPage'])->name('home');
Route::get('/about', [MainPageController::class, 'about'])->name('about');
Route::get('/services', [MainPageController::class, 'services'])->name('services');
Route::get('/contact', [MainPageController::class, 'contact'])->name('contact');

// Track form page
Route::get('/track', [MainPageController::class, 'trackPage'])->name('track.page');

// Track result
Route::post('/track', [TrackingController::class, 'trackResult'])->name('track.result');
Route::get('/track/{tracking_id}', [TrackingController::class, 'show'])->name('track');

// Live location endpoint
Route::get('/parcel/location/{parcel}', [TrackingController::class, 'getLocation'])
    ->name('parcel.location');

/*
|--------------------------------------------------------------------------
| Rating Routes (Public)
|--------------------------------------------------------------------------
*/

Route::get('/rate/{trackingId}', [RatingController::class, 'create'])->name('rating.create');
Route::post('/rate/{trackingId}', [RatingController::class, 'store'])->name('rating.store');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'agent') {
        return redirect()->route('agent.dashboard');
    }

    abort(403);
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Agent live locations
        Route::get('/agents/live-locations', [AdminDashboardController::class, 'agentLocations'])
            ->name('agents.locations');

        // Resources
        Route::resource('agents', AgentController::class);
        Route::resource('customers', CustomerController::class);

        // Parcel routes
        Route::get('parcels', [AdminParcelController::class, 'index'])->name('parcels.index');
        Route::get('parcels/create', [AdminParcelController::class, 'create'])->name('parcels.create');
        Route::post('parcels', [AdminParcelController::class, 'store'])->name('parcels.store');
        Route::get('parcels/{id}', [AdminParcelController::class, 'show'])->name('parcels.show');
        Route::get('parcels/{id}/edit', [AdminParcelController::class, 'edit'])->name('parcels.edit');
        Route::put('parcels/{id}', [AdminParcelController::class, 'update'])->name('parcels.update');
        Route::delete('parcels/{id}', [AdminParcelController::class, 'destroy'])->name('parcels.destroy');
        
        // QR Code routes
        Route::get('parcel/{trackingId}/qr', [\App\Http\Controllers\Agent\QrCodeController::class, 'generate'])
            ->name('parcel.qr');
        Route::get('parcel/{trackingId}/qr-label', [\App\Http\Controllers\Agent\QrCodeController::class, 'downloadLabel'])
            ->name('parcel.qr.label');

        // Agent Ratings
        Route::get('/agents/{agentId}/ratings', [RatingController::class, 'agentRatings'])
            ->name('agent.ratings');

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/reports/agent-performance', [ReportController::class, 'agentPerformance'])->name('reports.agents');
        Route::get('/reports/customers', [ReportController::class, 'customerUsage'])->name('reports.customers');
        Route::get('/reports/daily-delivered', [ReportController::class, 'dailyDelivered'])->name('reports.daily');
        Route::get('/reports/pending', [ReportController::class, 'pendingParcels'])->name('reports.pending');

        // Report PDFs
        Route::get('/reports/agents/pdf', [ReportController::class, 'AgentReportPDF'])->name('reports.agents.pdf');
        Route::get('/reports/customers/pdf', [ReportController::class, 'customerReportPDF'])->name('reports.customers.pdf');
        Route::get('/reports/daily/pdf', [ReportController::class, 'DailyReportPDF'])->name('reports.daily.pdf');
        Route::get('/reports/pending/pdf', [ReportController::class, 'PendingReportPDF'])->name('reports.pending.pdf');
    });

/*
|--------------------------------------------------------------------------
| Agent Routes (EXTERNAL FILE)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/agent.php';

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';