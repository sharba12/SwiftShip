@extends('agent.layout')

@section('content')
<div style="max-width:900px;">
    <div class="mb-3 fade-in">
        <a href="{{ route('agent.deliveries') }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Deliveries
        </a>
    </div>

    <div class="detail-card fade-in" style="animation-delay:0.05s">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-3">
            <h2 class="card-heading">Delivery Details</h2>
            <span class="status-badge
                @if($parcel->status == 'delivered') status-delivered
                @elseif($parcel->status == 'pending') status-pending
                @elseif($parcel->status == 'in_transit' || $parcel->status == 'out_for_delivery') status-transit
                @else status-failed
                @endif">
                {{ ucfirst(str_replace('_', ' ', $parcel->status)) }}
            </span>
        </div>

        <div class="row g-3">
            <div class="col-sm-6 col-md-3">
                <p class="field-label">Tracking ID</p>
                <p class="field-value" style="color:var(--color-primary);font-weight:700;">{{ $parcel->tracking_id }}</p>
            </div>
            <div class="col-sm-6 col-md-3">
                <p class="field-label">Sender</p>
                <p class="field-value">{{ $parcel->sender_name }}</p>
            </div>
            <div class="col-sm-6 col-md-3">
                <p class="field-label">Receiver</p>
                <p class="field-value">{{ $parcel->receiver_name }}</p>
                <p class="field-sub">{{ $parcel->receiver_contact }}</p>
            </div>
            <div class="col-sm-6 col-md-3">
                <p class="field-label">Weight</p>
                <p class="field-value">{{ $parcel->weight }} kg</p>
            </div>
            <div class="col-sm-6">
                <p class="field-label">From</p>
                <p class="field-value">{{ $parcel->address_from }}</p>
            </div>
            <div class="col-sm-6">
                <p class="field-label">To</p>
                <p class="field-value">{{ $parcel->address_to }}</p>
            </div>
        </div>
    </div>

    @if($parcel->status !== 'delivered')
    <div class="detail-card mt-3 fade-in" style="animation-delay:0.1s;border-color:rgba(14,165,233,0.2);">
        <h3 class="card-heading mb-3">
            <i class="bi bi-geo-alt" style="color:var(--color-primary);"></i> Live GPS Tracking
        </h3>
        <div id="gps-alert" class="gps-alert" style="display:none;"></div>

        <div id="gps-status" class="mb-3">
            <p style="color:rgba(255,255,255,0.5);">Enable GPS tracking to share your location with customers</p>
        </div>

        <div class="d-flex gap-3 flex-wrap">
            <button id="start-tracking" class="btn-agent btn-agent-green">
                <i class="bi bi-broadcast"></i> Start GPS Tracking
            </button>
            <button id="stop-tracking" class="btn-agent btn-agent-red" style="display:none;">
                <i class="bi bi-stop-circle"></i> Stop GPS Tracking
            </button>
        </div>

        <div id="location-info" class="mt-3" style="display:none;">
            <p style="color:rgba(255,255,255,0.4);font-size:0.82rem;">Last updated: <span id="last-update" style="color:var(--color-success);">Never</span></p>
            <p style="color:rgba(255,255,255,0.4);font-size:0.82rem;">Coordinates: <span id="coordinates" style="color:rgba(255,255,255,0.7);">-</span></p>
        </div>
    </div>
    @endif

    @if($parcel->status !== 'delivered')
    <div class="detail-card mt-3 fade-in" style="animation-delay:0.15s">
        <h3 class="card-heading mb-3">Update Delivery Status</h3>

        <form action="{{ route('agent.delivery.update', $parcel->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label-dark">Status</label>
                <select name="status" class="form-control form-control-dark" required>
                    <option value="pending" {{ $parcel->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_transit" {{ $parcel->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="out_for_delivery" {{ $parcel->status == 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="delivered" {{ $parcel->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="failed" {{ $parcel->status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label-dark">Notes (Optional)</label>
                <textarea name="notes" rows="3" class="form-control form-control-dark" placeholder="Add any remarks..."></textarea>
            </div>

            <button type="submit" class="btn-agent btn-agent-blue">
                <i class="bi bi-check2-circle"></i> Update Status
            </button>
        </form>
    </div>
    @endif

    @if($parcel->status == 'out_for_delivery' && !$parcel->signature_data)
    <div class="mt-3 fade-in" style="animation-delay:0.2s">
        <a href="{{ route('agent.proof.create', $parcel->id) }}" class="btn-agent btn-agent-purple w-100 text-center d-block py-3">
            <i class="bi bi-camera"></i> Submit Proof of Delivery
        </a>
    </div>
    @endif

    <div class="detail-card mt-3 fade-in" style="animation-delay:0.25s">
        <h3 class="card-heading mb-4">Delivery Timeline</h3>

        @if($parcel->timelines && $parcel->timelines->count() > 0)
            <div class="timeline">
                @foreach($parcel->timelines as $timeline)
                <div class="timeline-item {{ $loop->first ? 'timeline-active' : '' }}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-body">
                        <p class="timeline-status">{{ ucfirst(str_replace('_', ' ', $timeline->status)) }}</p>
                        @if($timeline->notes)
                        <p class="timeline-note">{{ $timeline->notes }}</p>
                        @endif
                        <p class="timeline-time">{{ $timeline->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p style="color:rgba(255,255,255,0.35);">No timeline entries yet</p>
        @endif
    </div>
</div>

<style>
.back-link { color:var(--color-primary);text-decoration:none;font-size:0.85rem;font-weight:600;transition:color 0.2s; }
.back-link:hover { color:var(--color-primary-soft); }

.detail-card {
    background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);
    border-radius:14px;padding:1.5rem;
}
.card-heading { font-size:1.1rem;font-weight:700;color:var(--color-white);margin:0; }

.field-label { font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.08em;margin:0 0 2px; }
.field-value { font-size:0.9rem;font-weight:600;color:rgba(255,255,255,0.85);margin:0; }
.field-sub { font-size:0.78rem;color:rgba(255,255,255,0.4);margin:2px 0 0; }

.status-badge { padding:0.3rem 0.8rem;border-radius:100px;font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em; }
.status-delivered { background:rgba(52,211,153,0.12);color:var(--color-success);border:1px solid rgba(52,211,153,0.25); }
.status-pending { background:rgba(251,191,36,0.12);color:var(--color-warning);border:1px solid rgba(251,191,36,0.25); }
.status-transit { background:rgba(14,165,233,0.12);color:var(--color-primary);border:1px solid rgba(14,165,233,0.25); }
.status-failed { background:rgba(248,113,113,0.12);color:var(--color-danger);border:1px solid rgba(248,113,113,0.25); }

.form-label-dark { color:rgba(255,255,255,0.6);font-size:0.82rem;font-weight:600;margin-bottom:0.35rem;display:block; }
.form-control-dark {
    background:rgba(255,255,255,0.05) !important;border:1px solid rgba(255,255,255,0.1) !important;
    color:var(--color-white) !important;border-radius:8px;padding:0.6rem 0.85rem;font-size:0.9rem;
}
.form-control-dark::placeholder { color:rgba(255,255,255,0.25) !important; }
.form-control-dark:focus { border-color:var(--color-primary) !important;box-shadow:0 0 0 3px rgba(14,165,233,0.12) !important; }
.form-control-dark option { background:var(--color-slate-850);color:var(--color-white); }

.btn-agent {
    border:none;border-radius:8px;padding:0.55rem 1.2rem;font-size:0.85rem;font-weight:600;
    cursor:pointer;display:inline-flex;align-items:center;gap:0.4rem;transition:all 0.2s;text-decoration:none;
}
.btn-agent-blue { background:var(--color-primary);color:var(--color-white); }
.btn-agent-blue:hover { background:var(--color-primary-strong);color:var(--color-white); }
.btn-agent-green { background:var(--color-success-strong);color:var(--color-white); }
.btn-agent-green:hover { background:var(--color-success-deep);color:var(--color-white); }
.btn-agent-red { background:rgba(239,68,68,0.15);color:var(--color-danger);border:1px solid rgba(239,68,68,0.25); }
.btn-agent-red:hover { background:rgba(239,68,68,0.25);color:var(--color-danger-soft); }
.btn-agent-purple { background:var(--color-violet-deep);color:var(--color-white); }
.btn-agent-purple:hover { background:var(--color-violet-ink);color:var(--color-white); }

.gps-alert {
    border: 1px solid rgba(248,113,113,0.45);
    background: rgba(127,29,29,0.4);
    color: var(--color-alert-error-text);
    border-radius: 10px;
    padding: 0.7rem 0.85rem;
    margin-bottom: 0.85rem;
    font-size: 0.83rem;
    font-weight: 600;
}

.timeline { position:relative;padding-left:1.5rem; }
.timeline::before { content:'';position:absolute;left:5px;top:0;bottom:0;width:1px;background:rgba(255,255,255,0.08); }
.timeline-item { position:relative;margin-bottom:1.5rem; }
.timeline-dot { position:absolute;left:-1.5rem;top:3px;width:12px;height:12px;border-radius:50%;background:var(--color-slate-900);border:2px solid rgba(255,255,255,0.15); }
.timeline-active .timeline-dot { background:var(--color-primary);border-color:var(--color-primary);box-shadow:0 0 8px rgba(14,165,233,0.5); }
.timeline-status { color:rgba(255,255,255,0.85);font-weight:600;font-size:0.88rem;margin:0 0 2px; }
.timeline-note { color:rgba(255,255,255,0.45);font-size:0.82rem;margin:2px 0 0; }
.timeline-time { color:rgba(255,255,255,0.25);font-size:0.75rem;margin:4px 0 0; }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    let watchId = null;
    const parcelId = {{ $parcel->id }};
    const updateUrl = "{{ route('agent.update.location') }}";

    const startBtn = document.getElementById('start-tracking');
    const stopBtn = document.getElementById('stop-tracking');
    const statusDiv = document.getElementById('gps-status');
    const locationInfo = document.getElementById('location-info');
    const lastUpdate = document.getElementById('last-update');
    const coordinates = document.getElementById('coordinates');
    const gpsAlert = document.getElementById('gps-alert');

    if (!startBtn || !stopBtn || !statusDiv || !locationInfo || !lastUpdate || !coordinates || !gpsAlert) return;

    function showGpsAlert(message) {
        gpsAlert.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + message;
        gpsAlert.style.display = 'block';
    }

    function hideGpsAlert() {
        gpsAlert.innerHTML = '';
        gpsAlert.style.display = 'none';
    }

    startBtn.addEventListener('click', () => {
        if (!navigator.geolocation) {
            showGpsAlert('Geolocation is not supported by your browser.');
            return;
        }

        hideGpsAlert();
        statusDiv.innerHTML = '<p style="color:var(--color-success);font-weight:600;"><i class="bi bi-check-circle-fill me-1"></i> GPS Tracking Active</p>';
        startBtn.style.display = 'none';
        stopBtn.style.display = 'inline-flex';
        locationInfo.style.display = 'block';

        watchId = navigator.geolocation.watchPosition(
            sendLocation,
            handleError,
            { enableHighAccuracy: true, maximumAge: 0, timeout: 10000 }
        );
    });

    stopBtn.addEventListener('click', () => {
        hideGpsAlert();
        if (watchId !== null) {
            navigator.geolocation.clearWatch(watchId);
            watchId = null;
        }
        statusDiv.innerHTML = '<p style="color:rgba(255,255,255,0.5);">GPS Tracking Stopped</p>';
        startBtn.style.display = 'inline-flex';
        stopBtn.style.display = 'none';
    });

    function sendLocation(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ parcel_id: parcelId, lat, lng })
        })
        .then((response) => response.json())
        .then((data) => {
            if (!data.success) return;
            lastUpdate.textContent = new Date().toLocaleTimeString();
            coordinates.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        })
        .catch(() => showGpsAlert('Could not send location update. Check your network and try again.'));
    }

    function handleError(error) {
        let message = 'Error getting location: ';
        switch (error.code) {
            case error.PERMISSION_DENIED: message += 'Permission denied.'; break;
            case error.POSITION_UNAVAILABLE: message += 'Location unavailable.'; break;
            case error.TIMEOUT: message += 'Request timed out.'; break;
            default: message += 'Unknown error.'; break;
        }
        statusDiv.innerHTML = `<p style="color:var(--color-danger);">${message}</p>`;
        showGpsAlert(message);
        startBtn.style.display = 'inline-flex';
        stopBtn.style.display = 'none';
    }
});
</script>
@endpush
@endsection
