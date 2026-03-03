@extends('layouts.agent')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('agent.deliveries') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to Deliveries
        </a>
    </div>

    <!-- Parcel Details Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Delivery Details</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600">Tracking ID</p>
                <p class="font-semibold text-lg">{{ $parcel->tracking_id }}</p>
            </div>
            
            <div>
                <p class="text-gray-600">Status</p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($parcel->status == 'delivered') bg-green-100 text-green-800
                    @elseif($parcel->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($parcel->status == 'in_transit' || $parcel->status == 'out_for_delivery') bg-blue-100 text-blue-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst(str_replace('_', ' ', $parcel->status)) }}
                </span>
            </div>
            
            <div>
                <p class="text-gray-600">Sender</p>
                <p class="font-semibold">{{ $parcel->sender_name }}</p>
            </div>
            
            <div>
                <p class="text-gray-600">Receiver</p>
                <p class="font-semibold">{{ $parcel->receiver_name }}</p>
                <p class="text-sm text-gray-500">{{ $parcel->receiver_contact }}</p>
            </div>
            
            <div>
                <p class="text-gray-600">From</p>
                <p class="text-sm">{{ $parcel->address_from }}</p>
            </div>
            
            <div>
                <p class="text-gray-600">To</p>
                <p class="text-sm">{{ $parcel->address_to }}</p>
            </div>
            
            <div>
                <p class="text-gray-600">Weight</p>
                <p class="font-semibold">{{ $parcel->weight }} kg</p>
            </div>
        </div>
    </div>

    <!-- GPS Tracking Card -->
    @if($parcel->status !== 'delivered')
    <div class="bg-blue-50 rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">Live GPS Tracking</h3>
        
        <div id="gps-status" class="mb-4">
            <p class="text-gray-700">Enable GPS tracking to share your location with customers</p>
        </div>
        
        <div class="flex gap-4">
            <button id="start-tracking" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold">
                Start GPS Tracking
            </button>
            <button id="stop-tracking" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-semibold hidden">
                Stop GPS Tracking
            </button>
        </div>
        
        <div id="location-info" class="mt-4 text-sm text-gray-600 hidden">
            <p>Last updated: <span id="last-update">Never</span></p>
            <p>Coordinates: <span id="coordinates">-</span></p>
        </div>
    </div>
    @endif

    <!-- Update Status Form -->
    @if($parcel->status !== 'delivered')
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-xl font-bold mb-4">Update Delivery Status</h3>
        
        <form action="{{ route('agent.delivery.update', $parcel->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2" required>
                    <option value="pending" {{ $parcel->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_transit" {{ $parcel->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="out_for_delivery" {{ $parcel->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ $parcel->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="failed" {{ $parcel->status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Notes (Optional)</label>
                <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2" placeholder="Add any remarks..."></textarea>
            </div>
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold">
                Update Status
            </button>
        </form>
    </div>
    @endif
    @if($parcel->status == 'out_for_delivery' && !$parcel->signature_data)
<div class="mt-4">
    <a href="{{ route('agent.proof.create', $parcel->id) }}" 
       class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg text-center">
        📸 Submit Proof of Delivery
    </a>
</div>
@endif

    <!-- Timeline -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold mb-4">Delivery Timeline</h3>
        
        @if($parcel->timelines && $parcel->timelines->count() > 0)
            <div class="space-y-4">
                @foreach($parcel->timelines as $timeline)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-3 h-3 bg-blue-600 rounded-full mt-1.5"></div>
                    <div class="ml-4 flex-1">
                        <p class="font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $timeline->status)) }}</p>
                        @if($timeline->notes)
                        <p class="text-gray-600 text-sm">{{ $timeline->notes }}</p>
                        @endif
                        <p class="text-gray-400 text-xs">{{ $timeline->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No timeline entries yet</p>
        @endif
    </div>
</div>

@push('scripts')
<script>
let watchId = null;
let isTracking = false;
const parcelId = {{ $parcel->id }};
const updateUrl = "{{ route('agent.update.location') }}";

const startBtn = document.getElementById('start-tracking');
const stopBtn = document.getElementById('stop-tracking');
const statusDiv = document.getElementById('gps-status');
const locationInfo = document.getElementById('location-info');
const lastUpdate = document.getElementById('last-update');
const coordinates = document.getElementById('coordinates');

// Start GPS tracking
startBtn.addEventListener('click', function() {
    if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser');
        return;
    }
    
    statusDiv.innerHTML = '<p class="text-green-600 font-semibold">🟢 GPS Tracking Active</p>';
    startBtn.classList.add('hidden');
    stopBtn.classList.remove('hidden');
    locationInfo.classList.remove('hidden');
    isTracking = true;
    
    // Get location every 10 seconds
    watchId = navigator.geolocation.watchPosition(
        sendLocation,
        handleError,
        {
            enableHighAccuracy: true,
            maximumAge: 0,
            timeout: 10000
        }
    );
});

// Stop GPS tracking
stopBtn.addEventListener('click', function() {
    if (watchId !== null) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
    }
    
    isTracking = false;
    statusDiv.innerHTML = '<p class="text-gray-600">GPS Tracking Stopped</p>';
    startBtn.classList.remove('hidden');
    stopBtn.classList.add('hidden');
});

// Send location to server
function sendLocation(position) {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;
    
    fetch(updateUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            parcel_id: parcelId,
            lat: lat,
            lng: lng
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            lastUpdate.textContent = new Date().toLocaleTimeString();
            coordinates.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }
    })
    .catch(error => {
        console.error('Error updating location:', error);
    });
}

// Handle geolocation errors
function handleError(error) {
    let message = 'Error getting location: ';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message += 'Permission denied. Please enable location access.';
            break;
        case error.POSITION_UNAVAILABLE:
            message += 'Location unavailable.';
            break;
        case error.TIMEOUT:
            message += 'Request timed out.';
            break;
    }
    statusDiv.innerHTML = `<p class="text-red-600">${message}</p>`;
    startBtn.classList.remove('hidden');
    stopBtn.classList.add('hidden');
}
</script>
@endpush
@endsection