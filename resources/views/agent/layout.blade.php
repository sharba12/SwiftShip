<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwiftShip Agent</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/css/bootstrap-icons.min.css') }}">
    <script src="{{ asset('vendor/tailwind/tailwindcss-cdn.js') }}"></script>
    <style>
    @font-face {
        font-display: block;
        font-family: "bootstrap-icons";
        src: url("{{ asset('vendor/bootstrap-icons/fonts/bootstrap-icons.woff2') }}") format("woff2"),
             url("{{ asset('vendor/bootstrap-icons/fonts/bootstrap-icons.woff') }}") format("woff");
    }
    </style>
    @include('partials.theme')

    <style>
    :root {
        --sidebar-w: 230px;
        --sidebar-bg: var(--color-bg-dark);
        --sidebar-border: rgba(255,255,255,0.06);
        --accent: var(--color-primary);
        --accent-green: var(--color-success);
        --content-bg: var(--color-bg-panel);
        --text-muted-s: rgba(255,255,255,0.72);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Segoe UI', system-ui, sans-serif;
        background: var(--content-bg);
        color: var(--color-white);
        display: flex;
        min-height: 100vh;
    }

    /* ── SIDEBAR ── */
    .agent-sidebar {
        width: var(--sidebar-w);
        min-height: 100vh;
        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; left: 0;
        z-index: 100;
        transition: transform 0.3s ease;
    }

    .sidebar-brand {
        padding: 1.4rem 1.25rem 1rem;
        border-bottom: 1px solid var(--sidebar-border);
        display: flex;
        align-items: center;
        gap: 0.6rem;
        text-decoration: none;
    }
    .sidebar-brand-text {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--color-white);
        letter-spacing: -0.02em;
    }
    .sidebar-brand-text span { color: var(--accent); }

    .sidebar-section-label {
        padding: 1.1rem 1.25rem 0.35rem;
        font-size: 0.63rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--text-muted-s);
    }

    .sidebar-nav {
        flex: 1;
        padding: 0.4rem 0.7rem;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.62rem 0.85rem;
        border-radius: 8px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 2px;
        transition: all 0.18s ease;
        position: relative;
    }
    .sidebar-link i { width: 18px; text-align: center; font-size: 0.9rem; }
    .sidebar-link:hover { background: rgba(255,255,255,0.05); color: var(--color-white); }
    .sidebar-link.active {
        background: rgba(14,165,233,0.12);
        color: var(--accent);
        font-weight: 600;
    }
    .sidebar-link.active::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; bottom: 20%;
        width: 3px;
        background: var(--accent);
        border-radius: 0 3px 3px 0;
    }

    .sidebar-footer {
        padding: 1rem 0.7rem;
        border-top: 1px solid var(--sidebar-border);
    }
    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.6rem 0.85rem;
        border-radius: 8px;
        background: rgba(255,255,255,0.04);
        margin-bottom: 0.6rem;
    }
    .sidebar-avatar {
        width: 34px; height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--accent-green), var(--color-success-strong));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; font-weight: 700; color: var(--color-white);
        flex-shrink: 0;
    }
    .sidebar-user-name {
        font-size: 0.82rem; font-weight: 600;
        color: rgba(255,255,255,0.85);
        white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .sidebar-user-role { font-size: 0.7rem; color: var(--text-muted-s); }

    .btn-sidebar-logout {
        width: 100%;
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.2);
        color: var(--color-danger);
        padding: 0.55rem;
        border-radius: 8px;
        font-size: 0.82rem; font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 0.5rem;
    }
    .btn-sidebar-logout:hover { background: rgba(239,68,68,0.2); color: var(--color-danger-soft); }

    /* ── CONTENT ── */
    .agent-content {
        margin-left: var(--sidebar-w);
        flex: 1; min-height: 100vh;
        display: flex; flex-direction: column;
    }

    .agent-topbar {
        background: var(--sidebar-bg);
        border-bottom: 1px solid var(--sidebar-border);
        padding: 0.85rem 1.75rem;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0; z-index: 50;
    }
    .topbar-breadcrumb { font-size: 0.82rem; color: var(--text-muted-s); }
    .topbar-breadcrumb strong { color: rgba(255,255,255,0.8); }
    .topbar-time {
        font-size: 0.78rem; color: var(--text-muted-s);
        font-family: 'Courier New', monospace;
    }
    .topbar-badge {
        background: rgba(52,211,153,0.12); color: var(--accent-green);
        border: 1px solid rgba(52,211,153,0.2);
        border-radius: 6px; padding: 0.25rem 0.75rem;
        font-size: 0.72rem; font-weight: 700; letter-spacing: 0.06em;
    }

    .agent-main { padding: 1.75rem; flex: 1; }

    .sidebar-toggle {
        display: none; background: none; border: none;
        color: var(--color-white); font-size: 1.2rem; cursor: pointer;
    }

    @media (max-width: 991px) {
        .agent-sidebar { transform: translateX(-100%); }
        .agent-sidebar.open { transform: translateX(0); }
        .agent-content { margin-left: 0; }
        .sidebar-toggle { display: block; }
        .agent-topbar { padding: 0.85rem 1rem; }
        .agent-main { padding: 1rem; }
    }
    </style>
</head>
<body>

<!-- ── SIDEBAR ── -->
<aside class="agent-sidebar" id="agentSidebar">
    <a class="sidebar-brand" href="{{ route('agent.dashboard') }}">
        <svg width="26" height="26" viewBox="0 0 32 32" fill="none">
            <path d="M4 16L14 6L28 16L14 26L4 16Z" fill="var(--color-primary)" opacity="0.9"/>
            <path d="M10 16L18 10L26 16L18 22L10 16Z" fill="var(--color-warning)"/>
        </svg>
        <span class="sidebar-brand-text">Swift<span>Ship</span></span>
    </a>

    <div class="sidebar-section-label">Navigation</div>
    <nav class="sidebar-nav">
        <a href="{{ route('agent.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('agent.deliveries') }}"
           class="sidebar-link {{ request()->routeIs('agent.deliveries') || request()->routeIs('agent.delivery.*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> My Deliveries
        </a>
        <a href="{{ route('agent.qr.scanner') }}"
           class="sidebar-link {{ request()->routeIs('agent.qr.scanner') ? 'active' : '' }}">
            <i class="bi bi-qr-code-scan"></i> QR Scanner
        </a>
        <a href="{{ route('agent.profile') }}"
           class="sidebar-link {{ request()->routeIs('agent.profile') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> My Profile
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Delivery Agent</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-sidebar-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</aside>

<!-- ── MAIN ── -->
<div class="agent-content">
    <div class="agent-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="sidebar-toggle" id="sidebarToggle"><i class="bi bi-list"></i></button>
            <div class="topbar-breadcrumb">SwiftShip &rsaquo; <strong>Agent Panel</strong></div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="topbar-time" id="topbarClock"></span>
            <span class="topbar-badge">Agent</span>
        </div>
    </div>

    <main class="agent-main">
        @yield('content')
    </main>
</div>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
function updateClock(){
    document.getElementById('topbarClock').textContent =
        new Date().toLocaleTimeString('en-IN',{hour:'2-digit',minute:'2-digit',second:'2-digit'});
}
updateClock(); setInterval(updateClock,1000);
document.getElementById('sidebarToggle').addEventListener('click',()=>{
    document.getElementById('agentSidebar').classList.toggle('open');
});
</script>
@stack('scripts')
</body>
</html>
