<nav class="swiftship-nav navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <svg class="brand-logo" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                <rect width="64" height="64" rx="14" fill="#0f172a"></rect>
                <path d="M8 32L26 14L56 32L26 50L8 32Z" fill="url(#navLogoBlue)"></path>
                <path d="M18 32L33 22L49 32L33 42L18 32Z" fill="url(#navLogoAmber)"></path>
                <defs>
                    <linearGradient id="navLogoBlue" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#38bdf8"></stop>
                        <stop offset="100%" stop-color="#0284c7"></stop>
                    </linearGradient>
                    <linearGradient id="navLogoAmber" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#fbbf24"></stop>
                        <stop offset="100%" stop-color="#f59e0b"></stop>
                    </linearGradient>
                </defs>
            </svg>
            <span class="brand-text">Swift<span class="brand-accent">Ship</span></span>
        </a>

        <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link nav-pill {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill {{ request()->routeIs('track.*') ? 'active' : '' }}"
                       href="{{ route('track.page') }}">Track</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill {{ request()->routeIs('services') ? 'active' : '' }}"
                       href="{{ route('services') }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill {{ request()->routeIs('about') ? 'active' : '' }}"
                       href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-pill {{ request()->routeIs('contact') ? 'active' : '' }}"
                       href="{{ route('contact') }}">Contact</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a class="btn btn-nav-dashboard" href="{{ route('admin.dashboard') }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                <path d="M3 3h8v8H3V3zm0 10h8v8H3v-8zm10-10h8v8h-8V3zm0 10h8v8h-8v-8z"/>
                            </svg>
                            Admin
                        </a>
                    @elseif(auth()->user()->role === 'agent')
                        <a class="btn btn-nav-dashboard" href="{{ route('agent.dashboard') }}">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                <path d="M3 3h8v8H3V3zm0 10h8v8H3v-8zm10-10h8v8h-8V3zm0 10h8v8h-8v-8z"/>
                            </svg>
                            Agent
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-nav-logout">Logout</button>
                    </form>
                @else
                    <a class="btn btn-nav-login" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
/* ── NAV BASE ── */
.swiftship-nav {
    background: rgba(15, 23, 42, 0.92);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    padding: 0.75rem 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    transition: background 0.3s ease;
}

/* ── BRAND ── */
.brand-text {
    font-size: 1.3rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    color: var(--color-white);
    font-family: 'Segoe UI', system-ui, sans-serif;
}
.brand-accent { color: var(--color-primary); }
.brand-logo {
    width: 28px;
    height: 28px;
    display: block;
    object-fit: contain;
}

/* ── NAV LINKS ── */
.nav-pill {
    color: rgba(255,255,255,0.7) !important;
    padding: 0.45rem 1rem !important;
    border-radius: 6px;
    font-size: 0.88rem;
    font-weight: 500;
    transition: all 0.2s ease;
    position: relative;
}
.nav-pill:hover {
    color: var(--color-white) !important;
    background: rgba(255,255,255,0.08);
}
.nav-pill.active {
    color: var(--color-primary) !important;
    background: rgba(14, 165, 233, 0.12);
}

/* ── BUTTONS ── */
.btn-nav-login {
    background: var(--color-primary);
    color: var(--color-white);
    border: none;
    border-radius: 6px;
    padding: 0.42rem 1.2rem;
    font-size: 0.86rem;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-nav-login:hover { background: var(--color-primary-strong); color: var(--color-white); }

.btn-nav-dashboard {
    background: rgba(251, 191, 36, 0.15);
    color: var(--color-warning);
    border: 1px solid rgba(251,191,36,0.3);
    border-radius: 6px;
    padding: 0.42rem 1.1rem;
    font-size: 0.86rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    transition: all 0.2s;
}
.btn-nav-dashboard:hover {
    background: rgba(251,191,36,0.25);
    color: var(--color-warning);
}

.btn-nav-logout {
    background: rgba(239, 68, 68, 0.12);
    color: var(--color-danger);
    border: 1px solid rgba(239,68,68,0.25);
    border-radius: 6px;
    padding: 0.42rem 1rem;
    font-size: 0.86rem;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-nav-logout:hover {
    background: rgba(239,68,68,0.22);
    color: var(--color-danger-soft);
}

/* ── SCROLL EFFECT ── */
.swiftship-nav.scrolled {
    background: rgba(15, 23, 42, 0.98);
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
}

@media (max-width: 991px) {
    .swiftship-nav .navbar-collapse {
        background: rgba(15, 23, 42, 0.98);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 0.5rem;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .d-flex.gap-2 { margin-top: 0.75rem; }
}
</style>

<script>
window.addEventListener('scroll', () => {
    const nav = document.querySelector('.swiftship-nav');
    nav.classList.toggle('scrolled', window.scrollY > 20);
});
</script>
