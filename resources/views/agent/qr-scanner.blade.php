@extends('layouts.agent')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">QR Code Scanner</h1>
            <p class="text-gray-600">Scan parcel QR codes for quick updates</p>
        </div>

        <!-- Scanner Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <!-- Camera Preview -->
            <div id="scanner-container" class="relative">
                <video id="qr-video" class="w-full rounded-lg border-2 border-gray-300"></video>
                <div id="scanner-overlay" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="border-4 border-blue-500 w-64 h-64 rounded-lg"></div>
                </div>
            </div>

            <!-- Controls -->
            <div class="flex gap-4 mt-6">
                <button id="start-scan" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg">
                    📷 Start Scanner
                </button>
                <button id="stop-scan" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 rounded-lg hidden">
                    ⏹ Stop Scanner
                </button>
            </div>

            <!-- Status Message -->
            <div id="scan-status" class="mt-4 text-center text-gray-600 hidden">
                <p class="font-semibold">Ready to scan...</p>
                <p class="text-sm">Position the QR code within the frame</p>
            </div>

            <!-- Manual Entry -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-gray-700 font-semibold mb-2">Or enter tracking ID manually:</p>
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        id="manual-tracking-id" 
                        placeholder="Enter tracking ID"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button 
                        id="manual-submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                        Submit
                    </button>
                </div>
            </div>
        </div>

        <!-- Result Card -->
        <div id="result-card" class="bg-white rounded-lg shadow-lg p-6 hidden">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Parcel Found</h3>
                <span id="status-badge" class="px-3 py-1 rounded-full text-sm font-semibold"></span>
            </div>

            <div class="space-y-3">
                <div>
                    <p class="text-gray-600 text-sm">Tracking ID</p>
                    <p id="result-tracking-id" class="font-semibold text-lg text-blue-600"></p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Receiver</p>
                    <p id="result-receiver" class="font-semibold"></p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Contact</p>
                    <p id="result-contact" class="font-semibold"></p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Destination</p>
                    <p id="result-address" class="text-sm"></p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 space-y-2">
                <a id="view-details-btn" href="#" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg text-center">
                    View Full Details
                </a>
                
                <div class="grid grid-cols-3 gap-2">
                    <button onclick="quickUpdate('picked_up')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 rounded-lg text-sm">
                        📦 Pick Up
                    </button>
                    <button onclick="quickUpdate('in_transit')" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-lg text-sm">
                        🚚 In Transit
                    </button>
                    <button onclick="quickUpdate('delivered')" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg text-sm">
                        ✓ Delivered
                    </button>
                </div>
            </div>

            <button onclick="scanAgain()" class="w-full mt-4 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 rounded-lg">
                Scan Another
            </button>
        </div>

        <!-- Recent Scans -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Scans</h3>
            <div id="recent-scans" class="space-y-2">
                <p class="text-gray-500 text-sm">No recent scans</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrCode = null;
let currentParcel = null;
let recentScans = [];

const startBtn = document.getElementById('start-scan');
const stopBtn = document.getElementById('stop-scan');
const scanStatus = document.getElementById('scan-status');
const resultCard = document.getElementById('result-card');
const manualInput = document.getElementById('manual-tracking-id');
const manualSubmit = document.getElementById('manual-submit');

// Start scanner
startBtn.addEventListener('click', function() {
    html5QrCode = new Html5Qrcode("qr-video");
    
    html5QrCode.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        },
        onScanSuccess,
        onScanError
    ).then(() => {
        startBtn.classList.add('hidden');
        stopBtn.classList.remove('hidden');
        scanStatus.classList.remove('hidden');
    }).catch(err => {
        alert('Unable to start camera: ' + err);
    });
});

// Stop scanner
stopBtn.addEventListener('click', function() {
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            startBtn.classList.remove('hidden');
            stopBtn.classList.add('hidden');
            scanStatus.classList.add('hidden');
        });
    }
});

// Handle successful scan
function onScanSuccess(decodedText, decodedResult) {
    console.log('Scanned:', decodedText);
    
    // Stop scanner
    if (html5QrCode) {
        html5QrCode.stop();
        startBtn.classList.remove('hidden');
        stopBtn.classList.add('hidden');
        scanStatus.classList.add('hidden');
    }
    
    // Process the scan
    processTrackingId(decodedText);
}

function onScanError(error) {
    // Ignore scan errors (camera is constantly scanning)
}

// Process tracking ID
function processTrackingId(trackingId) {
    fetch('{{ route("agent.qr.scan") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ tracking_id: trackingId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayParcel(data.parcel);
            addToRecentScans(data.parcel);
        } else {
            alert(data.message || 'Parcel not found');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error processing scan');
    });
}

// Display parcel details
function displayParcel(parcel) {
    currentParcel = parcel;
    
    document.getElementById('result-tracking-id').textContent = parcel.tracking_id;
    document.getElementById('result-receiver').textContent = parcel.receiver_name;
    document.getElementById('result-contact').textContent = parcel.receiver_contact;
    document.getElementById('result-address').textContent = parcel.address_to;
    
    const statusBadge = document.getElementById('status-badge');
    statusBadge.textContent = parcel.status.replace('_', ' ').toUpperCase();
    statusBadge.className = 'px-3 py-1 rounded-full text-sm font-semibold ';
    
    if (parcel.status === 'delivered') {
        statusBadge.className += 'bg-green-100 text-green-800';
    } else if (parcel.status === 'pending') {
        statusBadge.className += 'bg-yellow-100 text-yellow-800';
    } else {
        statusBadge.className += 'bg-blue-100 text-blue-800';
    }
    
    document.getElementById('view-details-btn').href = `/agent/deliveries/${parcel.id}`;
    resultCard.classList.remove('hidden');
}

// Quick status update
function quickUpdate(action) {
    if (!currentParcel) return;
    
    if (!confirm('Update status to: ' + action.replace('_', ' ') + '?')) {
        return;
    }
    
    fetch('{{ route("agent.qr.quick-update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            tracking_id: currentParcel.tracking_id,
            action: action
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Status updated successfully!');
            scanAgain();
        } else {
            alert(data.message || 'Update failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating status');
    });
}

// Scan another parcel
function scanAgain() {
    resultCard.classList.add('hidden');
    currentParcel = null;
}

// Manual entry
manualSubmit.addEventListener('click', function() {
    const trackingId = manualInput.value.trim();
    if (trackingId) {
        processTrackingId(trackingId);
        manualInput.value = '';
    }
});

manualInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        manualSubmit.click();
    }
});

// Recent scans
function addToRecentScans(parcel) {
    recentScans.unshift({
        tracking_id: parcel.tracking_id,
        receiver: parcel.receiver_name,
        time: new Date().toLocaleTimeString()
    });
    
    if (recentScans.length > 5) {
        recentScans.pop();
    }
    
    updateRecentScans();
}

function updateRecentScans() {
    const container = document.getElementById('recent-scans');
    
    if (recentScans.length === 0) {
        container.innerHTML = '<p class="text-gray-500 text-sm">No recent scans</p>';
        return;
    }
    
    container.innerHTML = recentScans.map(scan => `
        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
            <div>
                <p class="font-semibold text-sm">${scan.tracking_id}</p>
                <p class="text-xs text-gray-600">${scan.receiver}</p>
            </div>
            <span class="text-xs text-gray-500">${scan.time}</span>
        </div>
    `).join('');
}
</script>
@endpush
@endsection