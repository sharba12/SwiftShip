@extends('agent.layout')

@section('content')

<div class="dash-wrap">

    {{-- HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <h1 class="dash-title">Welcome back, {{ auth()->user()->name }}</h1>
            <p class="dash-sub">{{ now()->format('l, d M Y') }} · Here's your delivery overview</p>
        </div>
        <a href="{{ route('agent.deliveries') }}" class="btn-primary-action">
            <i class="bi bi-truck"></i> View Deliveries
        </a>
    </div>

    {{-- KPI CARDS --}}
    <div class="row g-4 mt-1">

        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.05s">
                <div class="kpi-icon-wrap" style="background:rgba(14,165,233,0.12);color:#0ea5e9;">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <p class="kpi-label">Total</p>
                    <h2 class="kpi-value">{{ $total }}</h2>
                </div>
                <div class="kpi-bar" style="background:#0ea5e9;"></div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.1s">
                <div class="kpi-icon-wrap" style="background:rgba(251,191,36,0.12);color:#fbbf24;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <p class="kpi-label">Pending</p>
                    <h2 class="kpi-value">{{ $pending }}</h2>
                </div>
                <div class="kpi-bar" style="background:#fbbf24;"></div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.15s">
                <div class="kpi-icon-wrap" style="background:rgba(52,211,153,0.12);color:#34d399;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <p class="kpi-label">Delivered</p>
                    <h2 class="kpi-value">{{ $delivered }}</h2>
                </div>
                <div class="kpi-bar" style="background:#34d399;"></div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="kpi-card fade-in" style="animation-delay:0.2s">
                <div class="kpi-icon-wrap" style="background:rgba(248,113,113,0.12);color:#f87171;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <p class="kpi-label">Failed</p>
                    <h2 class="kpi-value">{{ $failed }}</h2>
                </div>
                <div class="kpi-bar" style="background:#f87171;"></div>
            </div>
        </div>

    </div>

    {{-- PROGRESS BAR --}}
    <div class="progress-card mt-4 fade-in" style="animation-delay:0.25s">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="progress-label">Delivery Completion Rate</span>
            @php $rate = $total > 0 ? round(($delivered / $total) * 100) : 0; @endphp
            <span class="progress-pct">{{ $rate }}%</span>
        </div>
        <div class="progress-track">
            <div class="progress-fill" style="width:{{ $rate }}%;"></div>
        </div>
        <p class="progress-sub mt-2">{{ $delivered }} of {{ $total }} deliveries completed</p>
    </div>

    {{-- CTA --}}
    <div class="cta-banner mt-4 fade-in" style="animation-delay:0.3s">
        <div>
            <h6 class="cta-title">Ready for your next delivery?</h6>
            <p class="cta-sub">Check your pending parcels and start delivering.</p>
        </div>
        <a href="{{ route('agent.deliveries') }}" class="btn-primary-action">
            <i class="bi bi-arrow-right-circle"></i> View All Deliveries
        </a>
    </div>

</div>

<style>
.dash-wrap { max-width: 1100px; }
.dash-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title { font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:-0.03em;margin:0; }
.dash-sub { font-size:0.78rem;color:rgba(255,255,255,0.3);margin:4px 0 0; }

.btn-primary-action {
    background:#0ea5e9;color:#fff;border:none;border-radius:8px;
    padding:0.55rem 1.2rem;font-size:0.85rem;font-weight:600;
    text-decoration:none;cursor:pointer;
    display:inline-flex;align-items:center;gap:0.4rem;
    transition:background 0.2s;white-space:nowrap;
}
.btn-primary-action:hover { background:#0284c7;color:#fff; }

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
.kpi-icon-wrap {
    width:46px;height:46px;border-radius:12px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.25rem;flex-shrink:0;
}
.kpi-label { font-size:0.72rem;font-weight:600;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.08em;margin:0; }
.kpi-value { font-size:2rem;font-weight:800;color:#fff;line-height:1.1;margin:2px 0 0; }

/* PROGRESS */
.progress-card {
    background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);
    border-radius:14px;padding:1.4rem;
}
.progress-label { font-size:0.85rem;font-weight:600;color:rgba(255,255,255,0.7); }
.progress-pct { font-size:0.85rem;font-weight:700;color:#34d399; }
.progress-track {
    height:8px;background:rgba(255,255,255,0.06);
    border-radius:100px;overflow:hidden;
}
.progress-fill {
    height:100%;background:linear-gradient(90deg,#0ea5e9,#34d399);
    border-radius:100px;transition:width 1s ease;
}
.progress-sub { font-size:0.75rem;color:rgba(255,255,255,0.3);margin:0; }

/* CTA */
.cta-banner {
    background:rgba(14,165,233,0.06);border:1px solid rgba(14,165,233,0.18);
    border-radius:14px;padding:1.4rem 1.75rem;
    display:flex;align-items:center;justify-content:space-between;
    flex-wrap:wrap;gap:1rem;
}
.cta-title { font-size:0.95rem;font-weight:700;color:#fff;margin:0 0 3px; }
.cta-sub { font-size:0.78rem;color:rgba(255,255,255,0.35);margin:0; }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@endsection