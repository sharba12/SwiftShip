@extends('admin.layout')

@section('content')

<div class="dash-wrap">

    {{-- PAGE HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <h1 class="dash-title">Dashboard</h1>
            <p class="dash-sub">Operational overview · {{ now()->format('l, d M Y') }}</p>
        </div>
        <a href="{{ route('admin.parcels.create') }}" class="btn-new-parcel">
            <i class="bi bi-plus-lg"></i> New Parcel
        </a>
    </div>

    {{-- KPI CARDS --}}
    <div class="row g-4 mt-1">
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card fade-in" style="animation-delay:0.05s">
                <div class="kpi-icon-wrap" style="background:rgba(52,211,153,0.12);color:#34d399;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="kpi-body">
                    <p class="kpi-label">Delivered</p>
                    <h2 class="kpi-value">{{ $delivered }}</h2>
                </div>
                <div class="kpi-bar" style="background:#34d399;"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="kpi-card fade-in" style="animation-delay:0.1s">
                <div class="kpi-icon-wrap" style="background:rgba(251,191,36,0.12);color:#fbbf24;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="kpi-body">
                    <p class="kpi-label">Pending</p>
                    <h2 class="kpi-value">{{ $pending }}</h2>
                </div>
                <div class="kpi-bar" style="background:#fbbf24;"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="kpi-card fade-in" style="animation-delay:0.15s">
                <div class="kpi-icon-wrap" style="background:rgba(14,165,233,0.12);color:#0ea5e9;">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="kpi-body">
                    <p class="kpi-label">In Transit</p>
                    <h2 class="kpi-value">{{ $inTransit }}</h2>
                </div>
                <div class="kpi-bar" style="background:#0ea5e9;"></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="kpi-card fade-in" style="animation-delay:0.2s">
                <div class="kpi-icon-wrap" style="background:rgba(248,113,113,0.12);color:#f87171;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="kpi-body">
                    <p class="kpi-label">Failed</p>
                    <h2 class="kpi-value">{{ $failed }}</h2>
                </div>
                <div class="kpi-bar" style="background:#f87171;"></div>
            </div>
        </div>
    </div>

    {{-- LIVE MAP --}}
    <div class="row mt-4">
        <div class="col-12 fade-in" style="animation-delay:0.25s">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div>
                        <h5 class="admin-card-title">Live Delivery Map</h5>
                        <p class="admin-card-sub">Active agent locations — refreshes every 10s</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="live-dot"></span>
                        <span class="live-label">LIVE</span>
                    </div>
                </div>
                <div id="agentMap"></div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="row g-3 mt-2">
        <div class="col-12 fade-in" style="animation-delay:0.3s">
            <p class="section-mini-label">Quick Actions</p>
        </div>
        <div class="col-6 col-md-3 fade-in" style="animation-delay:0.35s">
            <a href="{{ route('admin.parcels.create') }}" class="quick-action-card">
                <i class="bi bi-box-seam" style="color:#0ea5e9;"></i>
                <span>New Parcel</span>
            </a>
        </div>
        <div class="col-6 col-md-3 fade-in" style="animation-delay:0.4s">
            <a href="{{ route('admin.agents.create') }}" class="quick-action-card">
                <i class="bi bi-person-plus" style="color:#34d399;"></i>
                <span>Add Agent</span>
            </a>
        </div>
        <div class="col-6 col-md-3 fade-in" style="animation-delay:0.45s">
            <a href="{{ route('admin.customers.index') }}" class="quick-action-card">
                <i class="bi bi-people" style="color:#fbbf24;"></i>
                <span>Customers</span>
            </a>
        </div>
        <div class="col-6 col-md-3 fade-in" style="animation-delay:0.5s">
            <a href="{{ route('admin.reports') }}" class="quick-action-card">
                <i class="bi bi-bar-chart-line" style="color:#a78bfa;"></i>
                <span>Reports</span>
            </a>
        </div>
    </div>

</div>

<style>
/* ── LAYOUT ── */
.dash-wrap { max-width: 1300px; }
.dash-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title { font-size:1.6rem;font-weight:800;color:#111827;letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.82rem;color:#6b7280;margin:4px 0 0; }

.btn-new-parcel {
    background:#0ea5e9;color:#fff;border:none;
    border-radius:8px;padding:0.55rem 1.25rem;
    font-size:0.85rem;font-weight:600;
    text-decoration:none;
    display:flex;align-items:center;gap:0.4rem;
    transition:background 0.2s;
}
.btn-new-parcel:hover { background:#0284c7;color:#fff; }

/* KPI */
.kpi-card {
    background:#fff;border:1px solid #e5e7eb;
    border-radius:14px;padding:1.4rem 1.4rem 1.2rem;
    display:flex;align-items:center;gap:1rem;
    position:relative;overflow:hidden;
    box-shadow:0 1px 3px rgba(0,0,0,0.05);
    transition:transform 0.25s,box-shadow 0.25s;
}
.kpi-card:hover { transform:translateY(-4px);box-shadow:0 8px 24px rgba(0,0,0,0.08); }
.kpi-bar { position:absolute;bottom:0;left:0;right:0;height:3px;opacity:0.7; }
.kpi-icon-wrap {
    width:48px;height:48px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.3rem;flex-shrink:0;
}
.kpi-label { font-size:0.72rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.08em;margin:0; }
.kpi-value { font-size:2rem;font-weight:800;color:#111827;line-height:1.1;margin:2px 0 0; }

/* ADMIN CARD */
.admin-card {
    background:#fff;border:1px solid #e5e7eb;
    border-radius:16px;overflow:hidden;
    box-shadow:0 1px 3px rgba(0,0,0,0.05);
}
.admin-card-header {
    padding:1.1rem 1.5rem;border-bottom:1px solid #f1f5f9;
    display:flex;align-items:center;justify-content:space-between;
}
.admin-card-title { font-size:0.95rem;font-weight:700;color:#111827;margin:0; }
.admin-card-sub { font-size:0.73rem;color:#6b7280;margin:2px 0 0; }

/* LIVE */
.live-dot {
    width:8px;height:8px;border-radius:50%;
    background:#22c55e;
    animation:livePulse 1.5s ease-in-out infinite;
}
.live-label { font-size:0.65rem;font-weight:700;letter-spacing:0.12em;color:#16a34a; }
@keyframes livePulse {
    0%,100%{box-shadow:0 0 0 0 rgba(34,197,94,0.4)}
    50%{box-shadow:0 0 0 5px rgba(34,197,94,0)}
}

#agentMap { height:420px;width:100%; }

/* QUICK ACTIONS */
.section-mini-label {
    font-size:0.65rem;font-weight:700;letter-spacing:0.14em;
    text-transform:uppercase;color:#9ca3af;margin:0;
}
.quick-action-card {
    display:flex;flex-direction:column;align-items:center;gap:0.5rem;
    padding:1.2rem 1rem;
    background:#fff;border:1px solid #e5e7eb;border-radius:12px;
    text-decoration:none;color:#374151;font-size:0.82rem;font-weight:600;
    text-align:center;transition:all 0.2s;
    box-shadow:0 1px 2px rgba(0,0,0,0.04);
}
.quick-action-card i { font-size:1.4rem; }
.quick-action-card:hover {
    background:#f0f9ff;border-color:#bae6fd;
    color:#0284c7;transform:translateY(-3px);
    box-shadow:0 4px 12px rgba(14,165,233,0.1);
}

/* ANIMATION */
.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }

</style>

<script>
let map = L.map('agentMap').setView([20.5937,78.9629],5);
let markers = {};

L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png',{
    attribution:'&copy; OpenStreetMap &copy; CARTO',maxZoom:19
}).addTo(map);

const agentIcon = L.divIcon({
    html:`<div style="width:14px;height:14px;background:#0ea5e9;border:3px solid #fff;border-radius:50%;box-shadow:0 0 10px rgba(14,165,233,0.8);"></div>`,
    className:'',iconAnchor:[7,7]
});

function loadAgentLocations(){
    fetch("{{ route('admin.agents.locations') }}")
        .then(r=>r.json())
        .then(data=>{
            data.forEach(agent=>{
                const ll=[agent.latitude,agent.longitude];
                if(markers[agent.id]){
                    markers[agent.id].setLatLng(ll);
                } else {
                    markers[agent.id]=L.marker(ll,{icon:agentIcon})
                        .addTo(map)
                        .bindPopup(`<strong style="color:#0ea5e9">${agent.name}</strong><br><small>Active Delivery</small>`);
                }
            });
        });
}
loadAgentLocations();
setInterval(loadAgentLocations,10000);
</script>

@endsection