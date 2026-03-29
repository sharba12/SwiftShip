@extends('layouts.admin')

@section('content')

<div class="dash-wrap">

    {{-- HEADER --}}
    <div class="dash-header fade-in">
        <div>
            <h1 class="dash-title">Reports</h1>
            <p class="dash-sub">Analytics and operational summaries · {{ now()->format('d M Y') }}</p>
        </div>
    </div>

    {{-- REPORT CARDS --}}
    <div class="row g-4 mt-1">

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay:0.05s">
            <a href="{{ route('admin.reports.daily') }}" class="report-card">
                <div class="report-icon" style="background:rgba(52,211,153,0.12);color:var(--color-success-strong);">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <h5 class="report-title">Delivered Today</h5>
                <p class="report-desc">View all parcels successfully delivered today</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:var(--color-success);"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay:0.1s">
            <a href="{{ route('admin.reports.pending') }}" class="report-card">
                <div class="report-icon" style="background:rgba(251,191,36,0.12);color:var(--color-warning);">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5 class="report-title">Pending Parcels</h5>
                <p class="report-desc">All shipments currently awaiting pickup or delivery</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:var(--color-warning);"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay:0.15s">
            <a href="{{ route('admin.reports.agents') }}" class="report-card">
                <div class="report-icon" style="background:rgba(14,165,233,0.12);color:var(--color-primary);">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <h5 class="report-title">Agent Performance</h5>
                <p class="report-desc">Delivered vs pending breakdown per delivery agent</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:var(--color-primary);"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay:0.2s">
            <a href="{{ route('admin.reports.customers') }}" class="report-card">
                <div class="report-icon" style="background:rgba(167,139,250,0.12);color:var(--color-violet-deep);">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h5 class="report-title">Customer Usage</h5>
                <p class="report-desc">Total parcels shipped per customer account</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:var(--color-violet);"></div>
            </a>
        </div>

    </div>

    {{-- PDF EXPORTS --}}
    <div class="mt-5 fade-in" style="animation-delay:0.25s">
        <p class="section-mini-label mb-3">Export as PDF</p>
        <div class="row g-3">

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.daily.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:var(--color-success-strong);"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <p class="pdf-title">Daily Delivered</p>
                        <p class="pdf-sub">Download PDF</p>
                    </div>
                    <i class="bi bi-download pdf-dl ms-auto"></i>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.pending.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:var(--color-warning);"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <p class="pdf-title">Pending Parcels</p>
                        <p class="pdf-sub">Download PDF</p>
                    </div>
                    <i class="bi bi-download pdf-dl ms-auto"></i>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.agents.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:var(--color-primary);"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <p class="pdf-title">Agent Performance</p>
                        <p class="pdf-sub">Download PDF</p>
                    </div>
                    <i class="bi bi-download pdf-dl ms-auto"></i>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.customers.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:var(--color-violet-deep);"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <p class="pdf-title">Customer Usage</p>
                        <p class="pdf-sub">Download PDF</p>
                    </div>
                    <i class="bi bi-download pdf-dl ms-auto"></i>
                </a>
            </div>

        </div>
    </div>

</div>

<style>
.dash-wrap { max-width: 1200px; }
.dash-header { display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem; }
.dash-title  { font-size:1.6rem;font-weight:800;color:var(--color-text-strong);letter-spacing:-0.03em;margin:0; }
.dash-sub    { font-size:0.82rem;color:var(--color-text-muted);margin:4px 0 0; }

.section-mini-label {
    font-size:0.65rem;font-weight:700;letter-spacing:0.14em;
    text-transform:uppercase;color:var(--color-text-subtle);
}

/* ── REPORT CARDS ── */
.report-card {
    display:flex;flex-direction:column;
    background:var(--color-white);
    border:1px solid var(--color-border);
    border-radius:16px;padding:1.75rem 1.5rem 1.25rem;
    text-decoration:none;position:relative;overflow:hidden;
    transition:all 0.25s ease;height:100%;
    box-shadow:0 1px 3px rgba(0,0,0,0.05);
}
.report-card:hover {
    border-color:var(--color-border-soft);
    transform:translateY(-5px);
    box-shadow:0 12px 28px rgba(0,0,0,0.1);
}
.report-card:hover .report-arrow { transform:translateX(4px); }
.report-card:hover .report-bar   { opacity:1; }

.report-icon {
    width:52px;height:52px;border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:1.4rem;margin-bottom:1.25rem;flex-shrink:0;
}
.report-title {
    font-size:0.95rem;font-weight:700;color:var(--color-text-strong);margin:0 0 0.5rem;
}
.report-desc {
    font-size:0.82rem;color:var(--color-text-muted);line-height:1.6;margin:0;flex:1;
}
.report-footer {
    display:flex;align-items:center;justify-content:space-between;
    margin-top:1.25rem;padding-top:1rem;
    border-top:1px solid var(--color-surface-muted);
}
.report-link  { font-size:0.78rem;font-weight:600;color:var(--color-primary); }
.report-arrow { color:var(--color-text-subtle);font-size:0.85rem;transition:transform 0.2s; }
.report-card:hover .report-arrow { color:var(--color-primary); }
.report-bar {
    position:absolute;bottom:0;left:0;right:0;
    height:3px;opacity:0.5;transition:opacity 0.25s;
}

/* ── PDF CARDS ── */
.pdf-card {
    display:flex;align-items:center;gap:0.85rem;
    background:var(--color-white);border:1px solid var(--color-border);
    border-radius:12px;padding:1rem 1.1rem;
    text-decoration:none;transition:all 0.2s;
    box-shadow:0 1px 2px rgba(0,0,0,0.04);
}
.pdf-card:hover {
    background:var(--color-surface-soft);border-color:var(--color-border-soft);
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}
.pdf-icon  { font-size:1.5rem;flex-shrink:0; }
.pdf-title { font-size:0.85rem;font-weight:600;color:var(--color-text-strong);margin:0; }
.pdf-sub   { font-size:0.72rem;color:var(--color-text-muted);margin:2px 0 0; }
.pdf-dl    { font-size:0.9rem;color:var(--color-text-subtle);transition:color 0.2s; }
.pdf-card:hover .pdf-dl { color:var(--color-text); }

/* ── ANIMATION ── */
.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@endsection
