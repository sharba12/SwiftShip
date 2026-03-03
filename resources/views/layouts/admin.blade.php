<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwiftShip Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --sidebar-w: 252px;
        --sidebar-bg: #0a0f1e;
        --sidebar-border: rgba(255,255,255,0.06);
        --accent: #0ea5e9;
        --accent-amber: #fbbf24;
        --surface: #111827;
        --surface2: #1a2235;
        --text: #f1f5f9;
        --muted: rgba(255,255,255,0.38);
        --page-bg: #f0f4f8;
    }

    body {
        display: flex;
        min-height: 100vh;
        background: var(--page-bg);
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    /* ── SIDEBAR ── */
    .sidebar {
        width: var(--sidebar-w);
        height: 100vh;
        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
        position: fixed;
        top: 0; left: 0;
        display: flex;
        flex-direction: column;
        z-index: 200;
        overflow: hidden;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 1.5rem 1.4rem 1.2rem;
        border-bottom: 1px solid var(--sidebar-border);
        text-decoration: none;
    }
    .sidebar-brand-text {
        font-size: 1.15rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.02em;
    }
    .sidebar-brand-text span { color: var(--accent); }

    .sidebar-label {
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--muted);
        padding: 1.2rem 1.4rem 0.5rem;
    }

    .sidebar-nav { padding: 0 0.75rem; flex: 1; overflow-y: auto; }
    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: rgba(255,255,255,0.55);
        padding: 0.62rem 0.85rem;
        border-radius: 8px;
        margin-bottom: 2px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s;
        position: relative;
    }
    .sidebar-link i { font-size: 15px; width: 18px; text-align: center; flex-shrink: 0; }
    .sidebar-link:hover { background: rgba(255,255,255,0.06); color: #fff; }
    .sidebar-link.active { background: rgba(14,165,233,0.14); color: var(--accent); }
    .sidebar-link.active::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; bottom: 20%;
        width: 3px;
        background: var(--accent);
        border-radius: 0 3px 3px 0;
    }

    .sidebar-footer {
        padding: 1rem 0.75rem 1.2rem;
        border-top: 1px solid var(--sidebar-border);
    }
    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.6rem 0.85rem;
        border-radius: 8px;
        background: rgba(255,255,255,0.04);
        margin-bottom: 0.75rem;
    }
    .sidebar-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent), #7c3aed);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;
    }
    .sidebar-username { font-size: 0.82rem; color: rgba(255,255,255,0.75); font-weight: 600; }
    .sidebar-role    { font-size: 0.68rem; color: var(--muted); }

    .btn-logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: rgba(239,68,68,0.1);
        color: #f87171;
        border: 1px solid rgba(239,68,68,0.2);
        border-radius: 8px;
        padding: 0.55rem;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-logout:hover { background: rgba(239,68,68,0.2); color: #fca5a5; }

    /* ── CONTENT ── */
    .content-wrapper {
        margin-left: var(--sidebar-w);
        width: calc(100% - var(--sidebar-w));
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: var(--page-bg);
    }

    /* ── TOPBAR ── */
    .topbar {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
        padding: 0 1.75rem;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 100;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .topbar-left { display: flex; align-items: center; gap: 0.75rem; }
    .topbar-breadcrumb { font-size: 0.82rem; color: #6b7280; }
    .topbar-breadcrumb span { color: #111827; font-weight: 600; }
    .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
    .topbar-clock {
        font-size: 0.78rem;
        color: #9ca3af;
        font-family: 'Courier New', monospace;
    }
    .topbar-greeting { font-size: 0.85rem; color: #374151; font-weight: 500; }
    .topbar-greeting strong { color: #0ea5e9; }
    .topbar-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 6px rgba(34,197,94,0.6);
    }

    /* ── PAGE BODY ── */
    .page-body { padding: 1.75rem; flex: 1; }

    /* ── RESPONSIVE ── */
    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
        .sidebar.open { transform: translateX(0); }
        .content-wrapper { margin-left: 0; width: 100%; }
    }

    /* ═══════════════════════════════════════════════════
       GLOBAL INPUT FIX
       Bootstrap forces white background + dark text on
       all inputs. These rules override that so every
       admin form renders correctly with dark inputs.
    ═══════════════════════════════════════════════════ */

    /* Base: all text inputs, selects, textareas */
    .page-body input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
    .page-body select,
    .page-body textarea {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
        border: 1px solid rgba(100,116,139,0.5) !important;
        border-radius: 8px !important;
        -webkit-text-fill-color: #f1f5f9 !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
    }

    /* Placeholder text */
    .page-body input::placeholder,
    .page-body textarea::placeholder {
        color: rgba(148,163,184,0.6) !important;
        -webkit-text-fill-color: rgba(148,163,184,0.6) !important;
        opacity: 1 !important;
    }

    /* Focus state */
    .page-body input:focus:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
    .page-body select:focus,
    .page-body textarea:focus {
        background-color: #263448 !important;
        border-color: #0ea5e9 !important;
        box-shadow: 0 0 0 3px rgba(14,165,233,0.18) !important;
        color: #fff !important;
        -webkit-text-fill-color: #fff !important;
        outline: none !important;
    }

    /* Chrome/Safari autofill yellow override */
    .page-body input:-webkit-autofill,
    .page-body input:-webkit-autofill:hover,
    .page-body input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px #1e293b inset !important;
        -webkit-text-fill-color: #f1f5f9 !important;
        caret-color: #fff;
    }

    /* Select option dropdown items */
    .page-body option {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
    }

    /* Readonly — slightly dimmer */
    .page-body input[readonly] {
        background-color: #172032 !important;
        color: rgba(241,245,249,0.45) !important;
        -webkit-text-fill-color: rgba(241,245,249,0.45) !important;
        cursor: default !important;
    }

    /* Bootstrap validation — keep red border visible */
    .page-body .is-invalid,
    .page-body input.is-invalid,
    .page-body select.is-invalid,
    .page-body textarea.is-invalid {
        border-color: #f87171 !important;
        box-shadow: 0 0 0 3px rgba(248,113,113,0.18) !important;
    }

    /* Form labels — make them readable on the light page bg */
    .page-body .form-label,
    .page-body label {
        color: #374151;
        font-weight: 500;
        font-size: 0.875rem;
    }

    /* Form control sizing fix (Bootstrap adds padding that can shift icons) */
    .page-body .form-control,
    .page-body .form-select {
        background-color: #1e293b !important;
        color: #f1f5f9 !important;
        border-color: rgba(100,116,139,0.5) !important;
    }
    .page-body .form-control:focus,
    .page-body .form-select:focus {
        background-color: #263448 !important;
        color: #fff !important;
        border-color: #0ea5e9 !important;
        box-shadow: 0 0 0 3px rgba(14,165,233,0.18) !important;
    }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<aside class="sidebar">
    <a class="sidebar-brand" href="{{ route('home') }}">
        <svg width="24" height="24" viewBox="0 0 32 32" fill="none">
            <path d="M4 16L14 6L28 16L14 26L4 16Z" fill="#0ea5e9" opacity="0.9"/>
            <path d="M10 16L18 10L26 16L18 22L10 16Z" fill="#fbbf24"/>
        </svg>
        <span class="sidebar-brand-text">Swift<span>Ship</span></span>
    </a>

    <div class="sidebar-nav">
        <div class="sidebar-label">Overview</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="sidebar-label">Management</div>

        <a href="{{ route('admin.parcels.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.parcels.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Parcels
        </a>

        <a href="{{ route('admin.customers.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Customers
        </a>

        <a href="{{ route('admin.agents.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.agents.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Agents
        </a>

        <div class="sidebar-label">Analytics</div>

        <a href="{{ route('admin.reports') }}"
           class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-line"></i> Reports
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="sidebar-username">{{ auth()->user()->name }}</div>
                <div class="sidebar-role">Administrator</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="bi bi-box-arrow-right"></i> Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ── MAIN ── --}}
<div class="content-wrapper">
    <div class="topbar">
        <div class="topbar-left">
            <span class="topbar-breadcrumb">
                SwiftShip &rsaquo; <span>Admin</span>
            </span>
        </div>
        <div class="topbar-right">
            <span class="topbar-clock" id="topbarClock"></span>
            <div class="topbar-dot"></div>
            <span class="topbar-greeting">Welcome, <strong>{{ auth()->user()->name }}</strong></span>
        </div>
    </div>

    <div class="page-body">
        @yield('content')
    </div>
</div>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
function updateClock() {
    document.getElementById('topbarClock').textContent =
        new Date().toLocaleTimeString('en-IN', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
}
updateClock();
setInterval(updateClock, 1000);
</script>
</body>
</html>
<!-- PATCH: override dark input fix back to light since page-bg is #f0f4f8 -->
<style>
.page-body input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
.page-body select,
.page-body textarea {
    background-color: #f9fafb !important;
    color: #111827 !important;
    border: 1px solid #d1d5db !important;
    -webkit-text-fill-color: #111827 !important;
}
.page-body input::placeholder, .page-body textarea::placeholder {
    color: #9ca3af !important;
    -webkit-text-fill-color: #9ca3af !important;
}
.page-body input:focus:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
.page-body select:focus, .page-body textarea:focus {
    background-color: #fff !important;
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.15) !important;
    color: #111827 !important;
    -webkit-text-fill-color: #111827 !important;
}
.page-body input:-webkit-autofill,
.page-body input:-webkit-autofill:hover,
.page-body input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 1000px #f9fafb inset !important;
    -webkit-text-fill-color: #111827 !important;
}
.page-body option { background:#fff !important; color:#111827 !important; }
.page-body input[readonly] {
    background-color: #f3f4f6 !important;
    color: #6b7280 !important;
    -webkit-text-fill-color: #6b7280 !important;
}
.page-body .form-control, .page-body .form-select {
    background-color: #f9fafb !important;
    color: #111827 !important;
    border-color: #d1d5db !important;
}
.page-body .form-control:focus, .page-body .form-select:focus {
    background-color: #fff !important;
    color: #111827 !important;
    border-color: #0ea5e9 !important;
}
</style>