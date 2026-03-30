<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwiftShip Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/swiftship-logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/swiftship-logo.svg') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/css/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}"/>
    @include('partials.theme')
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>

    <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --sidebar-w: 252px;
        --sidebar-bg: var(--color-bg-deep);
        --sidebar-border: rgba(255,255,255,0.06);
        --accent: var(--color-primary);
        --accent-amber: var(--color-warning);
        --surface: var(--color-text-strong);
        --surface2: #1a2235;
        --text: var(--color-surface-muted);
        --muted: rgba(255,255,255,0.38);
        --page-bg: #f0f4f8;
    }

    body {
        display: flex;
        min-height: 100vh;
        background: var(--page-bg);
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    /* SIDEBAR */
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
    .sidebar-logo {
        width: 24px;
        height: 24px;
        display: block;
        object-fit: contain;
    }
    .sidebar-brand-text {
        font-size: 1.15rem;
        font-weight: 800;
        color: var(--color-white);
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
    .sidebar-link:hover { background: rgba(255,255,255,0.06); color: var(--color-white); }
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
        color: var(--color-white); font-weight: 700; font-size: 0.8rem; flex-shrink: 0;
    }
    .sidebar-username { font-size: 0.82rem; color: rgba(255,255,255,0.75); font-weight: 600; }
    .sidebar-role { font-size: 0.68rem; color: var(--muted); }

    .btn-logout {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: rgba(239,68,68,0.1);
        color: var(--color-danger);
        border: 1px solid rgba(239,68,68,0.2);
        border-radius: 8px;
        padding: 0.55rem;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-logout:hover { background: rgba(239,68,68,0.2); color: var(--color-danger-soft); }

    /* CONTENT */
    .content-wrapper {
        margin-left: var(--sidebar-w);
        width: calc(100% - var(--sidebar-w));
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: var(--page-bg);
    }

    /* TOPBAR */
    .topbar {
        background: var(--color-white);
        border-bottom: 1px solid var(--color-border);
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
    .topbar-logo {
        width: 20px;
        height: 20px;
        object-fit: contain;
        display: block;
    }
    .topbar-breadcrumb { font-size: 0.82rem; color: var(--color-text-muted); }
    .topbar-breadcrumb span { color: var(--color-text-strong); font-weight: 600; }
    .topbar-right { display: flex; align-items: center; gap: 0.75rem; }
    .topbar-clock {
        font-size: 0.78rem;
        color: var(--color-text-subtle);
        font-family: 'Courier New', monospace;
    }
    .topbar-greeting { font-size: 0.85rem; color: var(--color-text); font-weight: 500; }
    .topbar-greeting strong { color: var(--color-primary); }
    .topbar-dot {
        width: 8px; height: 8px; border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 6px rgba(34,197,94,0.6);
    }

    /* PAGE BODY */
    .page-body { padding: 1.75rem; flex: 1; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
        .sidebar.open { transform: translateX(0); }
        .content-wrapper { margin-left: 0; width: 100%; }
    }

    /* Light admin form controls */
    .page-body input:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
    .page-body select,
    .page-body textarea {
        background-color: #f9fafb !important;
        color: var(--color-text-strong) !important;
        border: 1px solid #d1d5db !important;
        border-radius: 8px !important;
        -webkit-text-fill-color: var(--color-text-strong) !important;
        transition: border-color 0.2s, box-shadow 0.2s !important;
    }

    .page-body input::placeholder,
    .page-body textarea::placeholder {
        color: var(--color-text-subtle) !important;
        -webkit-text-fill-color: var(--color-text-subtle) !important;
        opacity: 1 !important;
    }

    .page-body input:focus:not([type="checkbox"]):not([type="radio"]):not([type="submit"]):not([type="button"]),
    .page-body select:focus,
    .page-body textarea:focus {
        background-color: var(--color-white) !important;
        border-color: var(--color-primary) !important;
        box-shadow: 0 0 0 3px rgba(14,165,233,0.15) !important;
        color: var(--color-text-strong) !important;
        -webkit-text-fill-color: var(--color-text-strong) !important;
        outline: none !important;
    }

    .page-body input:-webkit-autofill,
    .page-body input:-webkit-autofill:hover,
    .page-body input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0 1000px #f9fafb inset !important;
        -webkit-text-fill-color: var(--color-text-strong) !important;
        caret-color: var(--color-text-strong);
    }

    .page-body option {
        background-color: var(--color-white) !important;
        color: var(--color-text-strong) !important;
    }

    .page-body input[readonly] {
        background-color: #f3f4f6 !important;
        color: var(--color-text-muted) !important;
        -webkit-text-fill-color: var(--color-text-muted) !important;
        cursor: default !important;
    }

    .page-body .is-invalid,
    .page-body input.is-invalid,
    .page-body select.is-invalid,
    .page-body textarea.is-invalid {
        border-color: var(--color-danger) !important;
        box-shadow: 0 0 0 3px rgba(248,113,113,0.18) !important;
    }

    .page-body .form-label,
    .page-body label {
        color: var(--color-text);
        font-weight: 500;
        font-size: 0.875rem;
    }

    .page-body .form-control,
    .page-body .form-select {
        background-color: #f9fafb !important;
        color: var(--color-text-strong) !important;
        border-color: #d1d5db !important;
    }
    .page-body .form-control:focus,
    .page-body .form-select:focus {
        background-color: var(--color-white) !important;
        color: var(--color-text-strong) !important;
        border-color: var(--color-primary) !important;
        box-shadow: 0 0 0 3px rgba(14,165,233,0.15) !important;
    }

    /* Compatibility for legacy "dark" classes used by some admin pages */
    .page-body .dark-modal {
        background: var(--color-white) !important;
        border: 1px solid var(--color-border) !important;
    }
    .page-body .field-input,
    .page-body .field-textarea {
        background: #f9fafb !important;
        border: 1px solid #d1d5db !important;
        color: var(--color-text-strong) !important;
        -webkit-text-fill-color: var(--color-text-strong) !important;
    }
    .page-body .field-input::placeholder,
    .page-body .field-textarea::placeholder {
        color: var(--color-text-subtle) !important;
    }
    .page-body .field-input:focus,
    .page-body .field-textarea:focus {
        background: var(--color-white) !important;
        border-color: var(--color-primary) !important;
        box-shadow: 0 0 0 3px rgba(14,165,233,0.15) !important;
    }
    .page-body .table-dark,
    .page-body .table-dark > :not(caption) > * > * {
        background-color: #1f2937 !important;
        color: #f9fafb !important;
        border-color: #374151 !important;
    }
    .page-body .text-muted,
    .page-body .text-body-secondary {
        color: var(--color-text-muted) !important;
    }
    </style>
</head>
<body>

<aside class="sidebar">
    <a class="sidebar-brand" href="{{ route('home') }}">
        <img src="{{ asset('images/swiftship-logo.svg') }}" alt="SwiftShip logo" class="sidebar-logo">
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

<div class="content-wrapper">
    <div class="topbar">
        <div class="topbar-left">
            <img src="{{ asset('images/swiftship-logo.svg') }}" alt="SwiftShip logo" class="topbar-logo">
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
