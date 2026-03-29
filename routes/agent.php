<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Agent\DashboardController;
use App\Http\Controllers\Agent\AgentDeliveryController;
use App\Http\Controllers\Agent\ParcelController;
use App\Http\Controllers\Agent\ProofOfDeliveryController;
use App\Http\Controllers\Agent\QrCodeController;
use App\Http\Controllers\TrackingController;

Route::middleware(['auth', 'role:agent'])
    ->prefix('agent')
    ->name('agent.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/profile', [DashboardController::class, 'profile'])
            ->name('profile');

        // Deliveries
        Route::get('/deliveries', [AgentDeliveryController::class, 'index'])
            ->name('deliveries');

        Route::get('/deliveries/{id}', [AgentDeliveryController::class, 'show'])
            ->name('delivery.show');

        Route::post('/deliveries/{id}/status', [AgentDeliveryController::class, 'updateStatus'])
            ->name('delivery.update');

        // Live location update
        Route::post('/update-location', [ParcelController::class, 'updateLocation'])
            ->name('update.location');

        // Proof of Delivery
        Route::get('/delivery/{id}/proof', [ProofOfDeliveryController::class, 'create'])
            ->name('proof.create');
        
        Route::post('/delivery/{id}/proof', [ProofOfDeliveryController::class, 'store'])
            ->name('proof.store');
        
        Route::get('/delivery/{id}/proof/view', [ProofOfDeliveryController::class, 'show'])
            ->name('proof.show');

        // QR Code Scanner
        Route::get('/qr-scanner', [QrCodeController::class, 'scanner'])
            ->name('qr.scanner');
        
        Route::post('/qr-scan', [QrCodeController::class, 'scan'])
            ->name('qr.scan');
        
        Route::post('/qr-quick-update', [QrCodeController::class, 'quickUpdate'])
            ->name('qr.quick-update');
    });