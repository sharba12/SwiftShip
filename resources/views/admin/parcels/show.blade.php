@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div id="admin-parcel-notice" class="hidden mb-4 px-4 py-3 rounded-lg text-sm font-semibold"></div>
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 rounded-lg text-sm font-semibold bg-red-100 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('admin.parcels.index') }}" class="text-blue-600 hover:text-blue-800">
            Back to Parcels
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Parcel Details</h2>
                        <p class="text-gray-600">Tracking ID: <span class="font-semibold text-blue-600">{{ $parcel->tracking_id }}</span></p>
                    </div>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($parcel->status == 'delivered') bg-green-100 text-green-800
                        @elseif($parcel->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($parcel->status == 'in_transit' || $parcel->status == 'out_for_delivery') bg-blue-100 text-blue-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $parcel->status)) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Sender Information</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-semibold">{{ $parcel->sender_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">From</p>
                                <p class="text-sm">{{ $parcel->address_from }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Receiver Information</h3>
                        <div class="space-y-2">
                            <div>
                                <p class="text-sm text-gray-600">Name</p>
                                <p class="font-semibold">{{ $parcel->receiver_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Contact</p>
                                <p class="text-sm">{{ $parcel->receiver_contact }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">To</p>
                                <p class="text-sm">{{ $parcel->address_to }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Weight</p>
                            <p class="font-semibold">{{ $parcel->weight }} kg</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Customer</p>
                            <p class="font-semibold">{{ $parcel->customer->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Assigned Agent</p>
                            <p class="font-semibold">{{ $parcel->agent->name ?? 'Not Assigned' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Created</p>
                            <p class="font-semibold text-sm">{{ $parcel->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                @if($parcel->notes)
                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm font-semibold text-gray-700">Notes:</p>
                    <p class="text-sm text-gray-600">{{ $parcel->notes }}</p>
                </div>
                @endif
            </div>

            @if($parcel->signature_data || $parcel->delivery_photo)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Proof of Delivery</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($parcel->signature_data)
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Digital Signature</p>
                        <div class="border-2 border-gray-300 rounded-lg p-2 bg-white">
                            <img src="{{ $parcel->signature_data }}" alt="Signature" class="w-full h-32 object-contain">
                        </div>
                    </div>
                    @endif

                    @if($parcel->delivery_photo)
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-2">Delivery Photo</p>
                        <div class="border-2 border-gray-300 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $parcel->delivery_photo) }}" alt="Delivery Photo" class="w-full h-48 object-cover">
                        </div>
                    </div>
                    @endif
                </div>

                @if($parcel->recipient_name_confirmed)
                <div class="mt-4 p-3 bg-green-50 rounded-lg">
                    <p class="text-sm"><span class="font-semibold">Received by:</span> {{ $parcel->recipient_name_confirmed }}</p>
                    <p class="text-xs text-gray-600">Submitted: {{ $parcel->proof_submitted_at->format('M d, Y h:i A') }}</p>
                </div>
                @endif
            </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Delivery Timeline</h3>

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
                    <p class="text-gray-500">No timeline entries yet</p>
                @endif
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 text-center">QR Code</h3>

                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <img src="{{ route('admin.parcel.qr', $parcel->tracking_id) }}" alt="QR Code" class="w-full max-w-xs mx-auto">
                </div>

                <div class="space-y-2">
                    <button onclick="printQR()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Print QR Code
                    </button>
                    <a href="{{ route('admin.parcel.qr.label', $parcel->tracking_id) }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg text-center">
                        Download Label (PDF)
                    </a>
                    <button onclick="copyTrackingId()" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Copy Tracking ID
                    </button>
                </div>
            </div>

            @if($parcel->rating)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Customer Rating</h3>

                <div class="text-center mb-4">
                    <div class="text-4xl mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $parcel->rating->rating ? 'text-yellow-400' : 'text-gray-300' }}">*</span>
                        @endfor
                    </div>
                    <p class="text-2xl font-bold text-gray-800">{{ $parcel->rating->rating }}/5</p>
                </div>

                @if($parcel->rating->feedback)
                <div class="bg-gray-50 p-3 rounded-lg">
                    <p class="text-sm text-gray-700">"{{ $parcel->rating->feedback }}"</p>
                </div>
                @endif

                <div class="mt-4 text-sm text-gray-600">
                    <p><strong>By:</strong> {{ $parcel->rating->customer_name }}</p>
                    <p><strong>Date:</strong> {{ $parcel->rating->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            @endif

            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>

                <div class="space-y-2">
                    <a href="{{ route('track.page') }}?tracking={{ $parcel->tracking_id }}" target="_blank" class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg text-center">
                        View Public Tracking
                    </a>

                    @if($parcel->status !== 'delivered')
                    <a href="{{ route('admin.parcels.edit', $parcel->id) }}" class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-lg text-center">
                        Edit Parcel
                    </a>
                    @endif

                    @if($parcel->customer && $parcel->customer->email)
                    <form method="POST" action="{{ route('admin.parcels.notify', $parcel->id) }}" onsubmit="return confirm('Send status notification to customer now?');">
                        @csrf
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg">
                            Send Notification
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function setAdminNotice(message, type = 'info') {
    const notice = document.getElementById('admin-parcel-notice');
    if (!notice) return;

    const typeClassMap = {
        success: 'bg-green-100 text-green-800',
        error: 'bg-red-100 text-red-800',
        info: 'bg-blue-100 text-blue-800'
    };

    notice.className = `mb-4 px-4 py-3 rounded-lg text-sm font-semibold ${typeClassMap[type] || typeClassMap.info}`;
    notice.textContent = message;
}

function printQR() {
    const qrImage = '{{ route("admin.parcel.qr", $parcel->tracking_id) }}';
    const trackingId = '{{ $parcel->tracking_id }}';

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>QR Code - ${trackingId}</title>
                <style>
                    body {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        height: 100vh;
                        margin: 0;
                        font-family: Arial, sans-serif;
                    }
                    img { max-width: 400px; }
                    h2 { margin-top: 20px; }
                </style>
            </head>
            <body>
                <img src="${qrImage}" alt="QR Code">
                <h2>${trackingId}</h2>
                <script>
                    window.onload = function() {
                        window.print();
                        window.onafterprint = function() {
                            window.close();
                        }
                    }
                </script>
            </body>
        </html>
    `);
    printWindow.document.close();
}

function copyTrackingId() {
    const trackingId = '{{ $parcel->tracking_id }}';
    navigator.clipboard.writeText(trackingId).then(() => {
        setAdminNotice('Tracking ID copied to clipboard.', 'success');
    }, () => {
        setAdminNotice('Failed to copy tracking ID.', 'error');
    });
}

</script>
@endpush
@endsection
