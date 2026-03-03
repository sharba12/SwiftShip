<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Parcel - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 0.5rem;
            z-index: 1;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">
                    {{ config('app.name', 'Parcel Tracker') }}
                </a>
                <div class="space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="{{ route('track.page') }}" class="text-gray-700 hover:text-blue-600">Track</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        @if($parcel)
            <!-- Parcel Found -->
            <div class="max-w-6xl mx-auto">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Tracking Details</h1>
                    <p class="text-gray-600">Tracking ID: <span class="font-semibold text-blue-600">{{ $parcel->tracking_id }}</span></p>
                </div>

                <!-- Status Badge -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold mb-3">Current Status</h2>
                    <div class="flex items-center gap-3">
                        <span class="px-4 py-2 rounded-full text-lg font-semibold
                            @if($parcel->status == 'delivered') bg-green-100 text-green-800
                            @elseif($parcel->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($parcel->status == 'in_transit' || $parcel->status == 'out_for_delivery') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $parcel->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Live Map - Show for in_transit and out_for_delivery -->
                @if(in_array($parcel->status, ['in_transit', 'out_for_delivery']))
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Live Location</h2>
                        <span class="text-sm text-green-600 font-semibold">🟢 Tracking Active</span>
                    </div>
                    <div id="map" class="mb-2"></div>
                    <p class="text-sm text-gray-600">Location updates every 10 seconds</p>
                </div>
                @endif

                <!-- Parcel Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4">Sender Information</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600">Name</p>
                            <p class="font-semibold">{{ $parcel->sender_name }}</p>
                            <p class="text-gray-600 mt-3">From</p>
                            <p class="text-sm">{{ $parcel->address_from }}</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold mb-4">Receiver Information</h3>
                        <div class="space-y-2">
                            <p class="text-gray-600">Name</p>
                            <p class="font-semibold">{{ $parcel->receiver_name }}</p>
                            <p class="text-gray-600 mt-3">Contact</p>
                            <p class="text-sm">{{ $parcel->receiver_contact }}</p>
                            <p class="text-gray-600 mt-3">To</p>
                            <p class="text-sm">{{ $parcel->address_to }}</p>
                        </div>
                    </div>
                </div>

                <!-- Parcel Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-bold mb-4">Parcel Information</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Weight</p>
                            <p class="font-semibold">{{ $parcel->weight }} kg</p>
                        </div>
                        @if($parcel->in_transit_at)
                        <div>
                            <p class="text-gray-600 text-sm">In Transit</p>
                            <p class="font-semibold text-sm">{{ $parcel->in_transit_at->format('M d, h:i A') }}</p>
                        </div>
                        @endif
                        @if($parcel->out_for_delivery_at)
                        <div>
                            <p class="text-gray-600 text-sm">Out for Delivery</p>
                            <p class="font-semibold text-sm">{{ $parcel->out_for_delivery_at->format('M d, h:i A') }}</p>
                        </div>
                        @endif
                        @if($parcel->delivered_at)
                        <div>
                            <p class="text-gray-600 text-sm">Delivered</p>
                            <p class="font-semibold text-sm">{{ $parcel->delivered_at->format('M d, h:i A') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold mb-4">Delivery Timeline</h3>
                    
                    @if($parcel->timelines && $parcel->timelines->count() > 0)
                        <div class="space-y-4">
                            @foreach($parcel->timelines as $timeline)
                            <div class="flex items-start border-l-4 border-blue-500 pl-4 py-2">
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $timeline->status)) }}</p>
                                    @if($timeline->notes)
                                    <p class="text-gray-600 text-sm mt-1">{{ $timeline->notes }}</p>
                                    @endif
                                    <p class="text-gray-400 text-xs mt-1">{{ $timeline->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No timeline entries available</p>
                    @endif
                </div>
            </div>
        @else
            <!-- Parcel Not Found -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <div class="text-6xl mb-4">📦</div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Parcel Not Found</h2>
                    <p class="text-gray-600 mb-6">We couldn't find a parcel with that tracking number.</p>
                    <a href="{{ route('track.page') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
                        Try Again
                    </a>
                </div>
            </div>
        @endif
    </div>

    @if($parcel && in_array($parcel->status, ['in_transit', 'out_for_delivery']))
    <script>
        // Initialize map with default or actual coordinates
        const initialLat = {{ $parcel->current_lat ?? 10.0261 }};
        const initialLng = {{ $parcel->current_lng ?? 76.3125 }};
        
        const map = L.map('map').setView([initialLat, initialLng], 13);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);
        
        // Add marker for parcel
        const marker = L.marker([initialLat, initialLng]).addTo(map);
        marker.bindPopup('<b>Parcel Location</b><br>{{ $parcel->tracking_id }}').openPopup();
        
        // Update location every 10 seconds
        setInterval(function() {
            fetch("{{ route('parcel.location', $parcel->id) }}")
                .then(response => response.json())
                .then(data => {
                    if (data.lat && data.lng) {
                        const newLatLng = L.latLng(data.lat, data.lng);
                        marker.setLatLng(newLatLng);
                        map.panTo(newLatLng);
                    }
                })
                .catch(error => console.error('Error fetching location:', error));
        }, 10000); // 10 seconds
    </script>
    @endif

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
