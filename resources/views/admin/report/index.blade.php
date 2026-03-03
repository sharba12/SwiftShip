@extends('admin.layout')

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
                <div class="report-icon" style="background:#f0fdf4;color:#16a34a;">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <h5 class="report-title">Delivered Today</h5>
                <p class="report-desc">View all parcels successfully delivered today</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:#22c55e;"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay:0.1s">
            <a href="{{ route('admin.reports.pending') }}" class="report-card">
                <div class="report-icon" style="background:#fefce8;color:#ca8a04;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5 class="report-title">Pending Parcels</h5>
                <p class="report-desc">All shipments currently awaiting pickup or delivery</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:#eab308;"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay:0.15s">
            <a href="{{ route('admin.reports.agents') }}" class="report-card">
                <div class="report-icon" style="background:#eff6ff;color:#2563eb;">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <h5 class="report-title">Agent Performance</h5>
                <p class="report-desc">Delivered vs pending breakdown per delivery agent</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:#3b82f6;"></div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 fade-in" style="animation-delay:0.2s">
            <a href="{{ route('admin.reports.customers') }}" class="report-card">
                <div class="report-icon" style="background:#faf5ff;color:#7c3aed;">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h5 class="report-title">Customer Usage</h5>
                <p class="report-desc">Total parcels shipped per customer account</p>
                <div class="report-footer">
                    <span class="report-link">View Report</span>
                    <i class="bi bi-arrow-right report-arrow"></i>
                </div>
                <div class="report-bar" style="background:#8b5cf6;"></div>
            </a>
        </div>

    </div>

    {{-- PDF EXPORTS --}}
    <div class="mt-5 fade-in" style="animation-delay:0.25s">
        <p class="section-mini-label mb-3">Export as PDF</p>
        <div class="row g-3">

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.daily.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:#16a34a;"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <p class="pdf-title">Daily Delivered</p>
                        <p class="pdf-sub">Download PDF</p>
                    </div>
                    <i class="bi bi-download pdf-dl ms-auto"></i>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.pending.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:#ca8a04;"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <p class="pdf-title">Pending Parcels</p>
                        <p class="pdf-sub">Download PDF</p>
                    </div>
                    <i class="bi bi-download pdf-dl ms-auto"></i>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.agents.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:#2563eb;"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div>
                        <p class="pdf-title">Agent Performance</p>
                        <p class="pdf-sub">Download PDF</p>
                    </div>
                    <i class="bi bi-download pdf-dl ms-auto"></i>
                </a>
            </div>

            <div class="col-lg-3 col-md-6">
                <a href="{{ route('admin.reports.customers.pdf') }}" class="pdf-card">
                    <div class="pdf-icon" style="color:#7c3aed;"><i class="bi bi-file-earmark-pdf-fill"></i></div>
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
.dash-title  { font-size:1.6rem;font-weight:800;color:#111827;letter-spacing:-0.03em;margin:0; }
.dash-sub    { font-size:0.82rem;color:#6b7280;margin:4px 0 0; }

.section-mini-label {
    font-size:0.65rem;font-weight:700;letter-spacing:0.14em;
    text-transform:uppercase;color:#9ca3af;
}

/* ── REPORT CARDS ── */
.report-card {
    display:flex;flex-direction:column;
    background:#fff;
    border:1px solid #e5e7eb;
    border-radius:16px;padding:1.75rem 1.5rem 1.25rem;
    text-decoration:none;position:relative;overflow:hidden;
    transition:all 0.25s ease;height:100%;
    box-shadow:0 1px 3px rgba(0,0,0,0.05);
}
.report-card:hover {
    border-color:#d1d5db;
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
    font-size:0.95rem;font-weight:700;color:#111827;margin:0 0 0.5rem;
}
.report-desc {
    font-size:0.82rem;color:#6b7280;line-height:1.6;margin:0;flex:1;
}
.report-footer {
    display:flex;align-items:center;justify-content:space-between;
    margin-top:1.25rem;padding-top:1rem;
    border-top:1px solid #f1f5f9;
}
.report-link  { font-size:0.78rem;font-weight:600;color:#0ea5e9; }
.report-arrow { color:#9ca3af;font-size:0.85rem;transition:transform 0.2s; }
.report-card:hover .report-arrow { color:#0ea5e9; }
.report-bar {
    position:absolute;bottom:0;left:0;right:0;
    height:3px;opacity:0.5;transition:opacity 0.25s;
}

/* ── PDF CARDS ── */
.pdf-card {
    display:flex;align-items:center;gap:0.85rem;
    background:#fff;border:1px solid #e5e7eb;
    border-radius:12px;padding:1rem 1.1rem;
    text-decoration:none;transition:all 0.2s;
    box-shadow:0 1px 2px rgba(0,0,0,0.04);
}
.pdf-card:hover {
    background:#f9fafb;border-color:#d1d5db;
    transform:translateY(-2px);
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}
.pdf-icon  { font-size:1.5rem;flex-shrink:0; }
.pdf-title { font-size:0.85rem;font-weight:600;color:#111827;margin:0; }
.pdf-sub   { font-size:0.72rem;color:#6b7280;margin:2px 0 0; }
.pdf-dl    { font-size:0.9rem;color:#9ca3af;transition:color 0.2s; }
.pdf-card:hover .pdf-dl { color:#374151; }

/* ── ANIMATION ── */
.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@endsection