@extends('layouts.main')

@section('title', 'Track Parcel')

@section('content')

{{-- ═══════════════════ RESULT SECTION ═══════════════════ --}}
<section class="py-5 section-dark">
    <div class="container">

        @if($parcel)
        <div class="row justify-content-center">
            <div class="col-lg-9">

                {{-- HEADER --}}
                <div class="text-center mb-5 fade-up">
                    <span class="section-badge">Tracking Result</span>
                    <h1 class="fw-bold display-5 text-white mt-3">Parcel Found</h1>
                </div>

                {{-- PARCEL INFO CARD --}}
                <div class="result-card fade-up" style="animation-delay:0.1s">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <p class="result-label">Tracking Number</p>
                            <h4 class="text-white fw-bold mb-0">{{ $parcel->tracking_id }}</h4>
                        </div>
                        <span class="status-pill status-{{ strtolower(str_replace(['_', ' '], '-', $parcel->status)) }}">
                            {{ ucfirst(str_replace('_', ' ', $parcel->status)) }}
                        </span>
                    </div>

                    <hr class="result-divider">

                    <div class="row g-4">
                        <div class="col-sm-6 col-md-3">
                            <p class="result-label">Sender</p>
                            <p class="result-value">{{ $parcel->sender_name ?? '—' }}</p>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <p class="result-label">Receiver</p>
                            <p class="result-value">{{ $parcel->receiver_name ?? '—' }}</p>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <p class="result-label">From</p>
                            <p class="result-value">{{ $parcel->address_from ?? '—' }}</p>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <p class="result-label">To</p>
                            <p class="result-value">{{ $parcel->address_to ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- PARCEL DETAILS ROW --}}
                <div class="row g-4 mt-1">
                    <div class="col-md-6 fade-up" style="animation-delay:0.15s">
                        <div class="detail-card h-100">
                            <h5 class="text-white fw-bold mb-3">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2" class="me-2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Sender Details
                            </h5>
                            <div class="detail-row">
                                <span class="detail-key">Name</span>
                                <span class="detail-val">{{ $parcel->sender_name }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-key">Address</span>
                                <span class="detail-val">{{ $parcel->address_from ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 fade-up" style="animation-delay:0.2s">
                        <div class="detail-card h-100">
                            <h5 class="text-white fw-bold mb-3">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-success)" stroke-width="2" class="me-2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Receiver Details
                            </h5>
                            <div class="detail-row">
                                <span class="detail-key">Name</span>
                                <span class="detail-val">{{ $parcel->receiver_name }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-key">Contact</span>
                                <span class="detail-val">{{ $parcel->receiver_contact ?? '—' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-key">Address</span>
                                <span class="detail-val">{{ $parcel->address_to ?? '—' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PARCEL INFO --}}
                <div class="detail-card mt-4 fade-up" style="animation-delay:0.25s">
                    <h5 class="text-white fw-bold mb-3">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-warning)" stroke-width="2" class="me-2"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                        Parcel Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-6 col-md-3">
                            <p class="result-label">Weight</p>
                            <p class="result-value">{{ $parcel->weight ?? '—' }} kg</p>
                        </div>
                        @if($parcel->in_transit_at)
                        <div class="col-6 col-md-3">
                            <p class="result-label">In Transit</p>
                            <p class="result-value">{{ $parcel->in_transit_at->format('M d, h:i A') }}</p>
                        </div>
                        @endif
                        @if($parcel->out_for_delivery_at)
                        <div class="col-6 col-md-3">
                            <p class="result-label">Out for Delivery</p>
                            <p class="result-value">{{ $parcel->out_for_delivery_at->format('M d, h:i A') }}</p>
                        </div>
                        @endif
                        @if($parcel->delivered_at)
                        <div class="col-6 col-md-3">
                            <p class="result-label">Delivered</p>
                            <p class="result-value" style="color:var(--color-success)">{{ $parcel->delivered_at->format('M d, h:i A') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- LIVE MAP --}}
                @if(in_array($parcel->status, ['in_transit', 'out_for_delivery']))
                <div class="detail-card mt-4 fade-up" style="animation-delay:0.3s">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-white fw-bold mb-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2" class="me-2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            Live Location
                        </h5>
                        <span class="live-badge"><span class="live-dot"></span> Tracking Active</span>
                    </div>
                    <div class="map-wrap">
                        <div id="map" style="height:400px;"></div>
                    </div>
                    <p class="text-muted-light mt-2" style="font-size:0.78rem;">Location updates every 10 seconds</p>
                </div>
                @endif

                {{-- TIMELINE --}}
                @if($parcel->timelines && $parcel->timelines->count() > 0)
                <div class="detail-card mt-4 fade-up" style="animation-delay:0.35s">
                    <h5 class="text-white fw-bold mb-4">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--color-violet)" stroke-width="2" class="me-2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Delivery Timeline
                    </h5>
                    <div class="timeline">
                        @foreach($parcel->timelines->sortByDesc('created_at') as $timeline)
                        <div class="timeline-item {{ $loop->first ? 'timeline-item-active' : '' }}">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="timeline-status">{{ ucfirst(str_replace('_', ' ', $timeline->status)) }}</p>
                                @if($timeline->notes)
                                <p class="timeline-note">{{ $timeline->notes }}</p>
                                @endif
                                <p class="timeline-time">{{ $timeline->created_at->format('M d, Y · h:i A') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- BACK BUTTON --}}
                <div class="text-center mt-4 fade-up" style="animation-delay:0.4s">
                    <a href="{{ route('track.page') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill">
                        ← Track Another Parcel
                    </a>
                </div>

            </div>
        </div>

        @else
        {{-- PARCEL NOT FOUND --}}
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="not-found-card text-center fade-up">
                    <div style="font-size:4rem;">📦</div>
                    <h2 class="fw-bold text-white mt-3">Parcel Not Found</h2>
                    <p class="text-muted-light mt-2">We couldn't find a parcel with that tracking number. Please check and try again.</p>
                    <a href="{{ route('track.page') }}" class="btn btn-sky btn-lg px-5 rounded-pill mt-3">
                        Try Again
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" />
@endpush

<style>
.section-dark { background: var(--color-bg-section); min-height: 70vh; }
.text-muted-light { color: rgba(255,255,255,0.45); font-size: 0.875rem; line-height: 1.75; }
.text-sky { color: var(--color-primary); }

.section-badge {
    display:inline-block;
    background:rgba(14,165,233,0.12);color:var(--color-primary);
    border:1px solid rgba(14,165,233,0.3);border-radius:100px;
    padding:0.3rem 1.1rem;font-size:0.78rem;font-weight:600;
    letter-spacing:0.12em;text-transform:uppercase;
}

/* CARDS */
.result-card, .detail-card, .not-found-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 16px;
    padding: 2rem;
}
.result-label {
    color: rgba(255,255,255,0.35);
    font-size: 0.72rem; font-weight: 600;
    letter-spacing: 0.08em; text-transform: uppercase;
    margin: 0 0 4px;
}
.result-value { color: rgba(255,255,255,0.8); font-size: 0.9rem; margin: 0; }
.result-divider { border-color: rgba(255,255,255,0.07); margin: 1.5rem 0; }

/* STATUS */
.status-pill {
    padding: 0.35rem 1rem; border-radius: 100px;
    font-size: 0.75rem; font-weight: 700;
    letter-spacing: 0.06em; text-transform: uppercase;
}
.status-delivered { background:rgba(52,211,153,0.12);color:var(--color-success);border:1px solid rgba(52,211,153,0.25); }
.status-pending   { background:rgba(251,191,36,0.12);color:var(--color-warning);border:1px solid rgba(251,191,36,0.25); }
.status-in-transit{ background:rgba(14,165,233,0.12);color:var(--color-primary);border:1px solid rgba(14,165,233,0.25); }
.status-out-for-delivery { background:rgba(167,139,250,0.12);color:var(--color-violet);border:1px solid rgba(167,139,250,0.25); }
.status-cancelled { background:rgba(239,68,68,0.12);color:var(--color-danger);border:1px solid rgba(239,68,68,0.25); }

/* DETAIL ROWS */
.detail-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    padding: 0.65rem 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.detail-row:last-child { border-bottom: none; }
.detail-key { color: rgba(255,255,255,0.4); font-size: 0.85rem; }
.detail-val { color: rgba(255,255,255,0.85); font-size: 0.85rem; font-weight: 600; text-align: right; }

/* LIVE BADGE */
.live-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(52,211,153,0.1); color: var(--color-success);
    border: 1px solid rgba(52,211,153,0.25);
    border-radius: 8px; padding: 0.3rem 0.75rem;
    font-size: 0.75rem; font-weight: 600;
}
.live-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--color-success);
    box-shadow: 0 0 8px rgba(52,211,153,0.6);
    animation: livePulse 2s infinite;
}
@keyframes livePulse { 0%, 100% { opacity:1; } 50% { opacity:0.4; } }

/* MAP */
.map-wrap { border-radius: 12px; overflow: hidden; border: 1px solid rgba(255,255,255,0.07); }

/* TIMELINE */
.timeline { position: relative; padding-left: 1.75rem; }
.timeline::before {
    content: ''; position: absolute; left: 7px; top: 0; bottom: 0;
    width: 1px; background: rgba(255,255,255,0.08);
}
.timeline-item { position: relative; margin-bottom: 1.75rem; }
.timeline-dot {
    position: absolute; left: -1.75rem; top: 4px;
    width: 14px; height: 14px; border-radius: 50%;
    background: var(--color-bg-section); border: 2px solid rgba(255,255,255,0.2);
    transition: all 0.2s;
}
.timeline-item-active .timeline-dot {
    background: var(--color-primary); border-color: var(--color-primary);
    box-shadow: 0 0 10px rgba(14,165,233,0.5);
}
.timeline-status { color: rgba(255,255,255,0.85); font-weight: 600; font-size: 0.9rem; margin: 0 0 2px; }
.timeline-time { color: rgba(255,255,255,0.3); font-size: 0.78rem; margin: 0; }
.timeline-note { color: rgba(255,255,255,0.45); font-size: 0.82rem; margin: 2px 0 0; }

/* BTN */
.btn-sky { background:var(--color-primary);color:var(--color-white);border:none;font-weight:600;transition:background 0.2s; }
.btn-sky:hover { background:var(--color-primary-strong);color:var(--color-white); }

/* FADE */
.fade-up { opacity:0; transform:translateY(24px); animation:fadeUp 0.8s ease forwards; }
@keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
</style>

@if($parcel && in_array($parcel->status, ['in_transit', 'out_for_delivery']))
@push('scripts')
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const initialLat = {{ $parcel->current_lat ?? 10.0261 }};
    const initialLng = {{ $parcel->current_lng ?? 76.3125 }};

    const map = L.map('map', { zoomControl: true }).setView([initialLat, initialLng], 13);
    document.getElementById('map').style.background = '#0f172a';

    const icon = L.divIcon({
        html: '<div style="width:14px;height:14px;background:var(--color-primary);border:3px solid var(--color-white);border-radius:50%;box-shadow:0 0 12px rgba(14,165,233,0.8);"></div>',
        className: '', iconAnchor: [7, 7]
    });

    const marker = L.marker([initialLat, initialLng], { icon }).addTo(map)
        .bindPopup('<b style="color:var(--color-primary)">Parcel Location</b><br>{{ $parcel->tracking_id }}').openPopup();

    setInterval(function(){
        fetch("{{ route('parcel.location', $parcel->id) }}")
            .then(r => r.json())
            .then(data => {
                if(data.lat && data.lng){
                    const ll = L.latLng(data.lat, data.lng);
                    marker.setLatLng(ll);
                    map.panTo(ll);
                }
            }).catch(() => {});
    }, 10000);
});
</script>
@endpush
@endif

@endsection
