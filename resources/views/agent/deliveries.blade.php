@extends('agent.layout')

@section('content')

<div style="max-width:1100px;">

    {{-- HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <h1 class="dash-title">My Deliveries</h1>
            <p class="dash-sub">Manage and track your assigned parcels</p>
        </div>
    </div>

    {{-- KPI CARDS --}}
    <div class="row g-4 mt-1">
        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.05s">
                <div class="kpi-icon-wrap" style="background:rgba(14,165,233,0.12);color:var(--color-primary);">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <p class="kpi-label">Total</p>
                    <h2 class="kpi-value">{{ $total }}</h2>
                </div>
                <div class="kpi-bar" style="background:var(--color-primary);"></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.1s">
                <div class="kpi-icon-wrap" style="background:rgba(251,191,36,0.12);color:var(--color-warning);">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <p class="kpi-label">Pending</p>
                    <h2 class="kpi-value">{{ $pending }}</h2>
                </div>
                <div class="kpi-bar" style="background:var(--color-warning);"></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.15s">
                <div class="kpi-icon-wrap" style="background:rgba(52,211,153,0.12);color:var(--color-success);">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <p class="kpi-label">Delivered</p>
                    <h2 class="kpi-value">{{ $delivered }}</h2>
                </div>
                <div class="kpi-bar" style="background:var(--color-success);"></div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.2s">
                <div class="kpi-icon-wrap" style="background:rgba(248,113,113,0.12);color:var(--color-danger);">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <p class="kpi-label">Failed</p>
                    <h2 class="kpi-value">{{ $failed }}</h2>
                </div>
                <div class="kpi-bar" style="background:var(--color-danger);"></div>
            </div>
        </div>
    </div>

    {{-- DELIVERIES TABLE --}}
    <div class="table-card mt-4 fade-in" style="animation-delay:0.25s">
        <div class="table-card-head">
            <h5 class="table-card-title">All Deliveries</h5>
        </div>

        @if($parcels->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0" style="font-size:0.875rem;">
                <thead>
                    <tr class="table-head-row">
                        <th class="th-cell">Tracking ID</th>
                        <th class="th-cell">Receiver</th>
                        <th class="th-cell">Destination</th>
                        <th class="th-cell">Status</th>
                        <th class="th-cell">Weight</th>
                        <th class="th-cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parcels as $parcel)
                    <tr class="table-row">
                        <td class="td-cell">
                            <span style="color:var(--color-primary);font-weight:600;">{{ $parcel->tracking_id }}</span>
                        </td>
                        <td class="td-cell">
                            <div style="color:rgba(255,255,255,0.85);font-weight:600;">{{ $parcel->receiver_name }}</div>
                            <div style="color:rgba(255,255,255,0.35);font-size:0.78rem;">{{ $parcel->receiver_contact }}</div>
                        </td>
                        <td class="td-cell">
                            <div style="color:rgba(255,255,255,0.7);max-width:200px;" class="text-truncate" title="{{ $parcel->address_to }}">
                                {{ $parcel->address_to }}
                            </div>
                        </td>
                        <td class="td-cell">
                            <span class="status-pill
                                @if($parcel->status == 'delivered') sp-delivered
                                @elseif($parcel->status == 'pending') sp-pending
                                @elseif($parcel->status == 'in_transit' || $parcel->status == 'out_for_delivery') sp-transit
                                @else sp-failed
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $parcel->status)) }}
                            </span>
                        </td>
                        <td class="td-cell" style="color:rgba(255,255,255,0.7);">{{ $parcel->weight }} kg</td>
                        <td class="td-cell">
                            <a href="{{ route('agent.delivery.show', $parcel->id) }}" class="action-link">
                                View Details <i class="bi bi-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="padding:3rem;text-align:center;">
            <i class="bi bi-inbox" style="font-size:2.5rem;color:rgba(255,255,255,0.15);"></i>
            <p style="color:rgba(255,255,255,0.4);margin:1rem 0 0;font-size:0.9rem;">No deliveries assigned yet</p>
            <p style="color:rgba(255,255,255,0.25);font-size:0.82rem;">Check back later for new assignments</p>
        </div>
        @endif
    </div>

</div>

<style>
.dash-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title { font-size:1.5rem;font-weight:800;color:var(--color-white);letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.78rem;color:rgba(255,255,255,0.3);margin:4px 0 0; }

/* KPI */
.kpi-card {
    background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);
    border-radius:14px;padding:1.4rem 1.4rem 1.2rem;
    display:flex;align-items:center;gap:1rem;
    position:relative;overflow:hidden;
    transition:transform 0.25s,border-color 0.25s;
}
.kpi-card:hover { transform:translateY(-4px);border-color:rgba(255,255,255,0.14); }
.kpi-bar { position:absolute;bottom:0;left:0;right:0;height:2px;opacity:0.5; }
.kpi-icon-wrap { width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0; }
.kpi-label { font-size:0.72rem;font-weight:600;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.08em;margin:0; }
.kpi-value { font-size:2rem;font-weight:800;color:var(--color-white);line-height:1.1;margin:2px 0 0; }

/* TABLE */
.table-card { background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);border-radius:14px;overflow:hidden; }
.table-card-head { padding:1.1rem 1.5rem;border-bottom:1px solid rgba(255,255,255,0.06); }
.table-card-title { font-size:0.95rem;font-weight:700;color:var(--color-white);margin:0; }
.table-head-row { background:rgba(255,255,255,0.03); }
.th-cell { padding:0.8rem 1rem !important;font-weight:600;color:rgba(255,255,255,0.4);font-size:0.72rem;text-transform:uppercase;letter-spacing:0.06em;border-bottom:1px solid rgba(255,255,255,0.06) !important; }
.table-row { transition:background 0.15s; }
.table-row:hover { background:rgba(255,255,255,0.03) !important; }
.td-cell { padding:0.8rem 1rem !important;vertical-align:middle;border-bottom:1px solid rgba(255,255,255,0.04) !important; }

/* STATUS */
.status-pill { padding:0.25rem 0.7rem;border-radius:100px;font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em; }
.sp-delivered { background:rgba(52,211,153,0.12);color:var(--color-success); }
.sp-pending { background:rgba(251,191,36,0.12);color:var(--color-warning); }
.sp-transit { background:rgba(14,165,233,0.12);color:var(--color-primary); }
.sp-failed { background:rgba(248,113,113,0.12);color:var(--color-danger); }

.action-link { color:var(--color-primary);font-size:0.82rem;font-weight:600;text-decoration:none;transition:color 0.2s; }
.action-link:hover { color:var(--color-primary-soft); }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@endsection
