@extends('agent.layout')

@section('content')

<div style="max-width:800px;">

    {{-- PAGE HEADER --}}
    <div class="fade-in">
        <h1 class="profile-title">My Profile</h1>
        <p class="profile-sub">View and manage your account information</p>
    </div>

    {{-- PROFILE CARD --}}
    <div class="profile-card mt-4 fade-in" style="animation-delay:0.08s">

        {{-- AVATAR + NAME --}}
        <div class="profile-top">
            <div class="profile-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h3 class="profile-name">{{ auth()->user()->name }}</h3>
                <span class="profile-role-badge">Delivery Agent</span>
            </div>
        </div>

        <hr class="profile-divider">

        {{-- INFO ROWS --}}
        <div class="profile-info-grid">
            <div class="profile-info-item">
                <i class="bi bi-envelope"></i>
                <div>
                    <p class="info-label">Email Address</p>
                    <p class="info-value">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="profile-info-item">
                <i class="bi bi-person-badge"></i>
                <div>
                    <p class="info-label">Role</p>
                    <p class="info-value">{{ ucfirst(auth()->user()->role) }}</p>
                </div>
            </div>

            <div class="profile-info-item">
                <i class="bi bi-calendar3"></i>
                <div>
                    <p class="info-label">Member Since</p>
                    <p class="info-value">{{ auth()->user()->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="profile-info-item">
                <i class="bi bi-shield-check"></i>
                <div>
                    <p class="info-label">Account Status</p>
                    <p class="info-value" style="color:var(--color-success);">Active</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ACTIONS --}}
    <div class="profile-actions mt-4 fade-in" style="animation-delay:0.16s">
        <a href="{{ route('agent.dashboard') }}" class="btn-profile-action">
            <i class="bi bi-speedometer2"></i> Back to Dashboard
        </a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn-profile-logout">
                <i class="bi bi-box-arrow-right"></i> Sign Out
            </button>
        </form>
    </div>

</div>

<style>
.profile-title { font-size:1.5rem;font-weight:800;color:var(--color-white);letter-spacing:-0.03em;margin:0; }
.profile-sub { font-size:0.78rem;color:rgba(255,255,255,0.3);margin:4px 0 0; }

.profile-card {
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.07);
    border-radius:16px;
    padding:2rem;
}

.profile-top {
    display:flex;align-items:center;gap:1.25rem;
}
.profile-avatar {
    width:64px;height:64px;border-radius:50%;
    background:linear-gradient(135deg,var(--color-success),var(--color-success-strong));
    display:flex;align-items:center;justify-content:center;
    font-size:1.5rem;font-weight:800;color:var(--color-white);
    flex-shrink:0;
}
.profile-name { font-size:1.25rem;font-weight:700;color:var(--color-white);margin:0 0 4px; }
.profile-role-badge {
    display:inline-block;
    background:rgba(52,211,153,0.12);color:var(--color-success);
    border:1px solid rgba(52,211,153,0.25);
    border-radius:6px;padding:0.2rem 0.7rem;
    font-size:0.72rem;font-weight:700;letter-spacing:0.06em;
    text-transform:uppercase;
}

.profile-divider {
    border:none;border-top:1px solid rgba(255,255,255,0.07);
    margin:1.5rem 0;
}

.profile-info-grid {
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:1.25rem;
}
.profile-info-item {
    display:flex;align-items:flex-start;gap:0.85rem;
    padding:1rem;
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(255,255,255,0.06);
    border-radius:10px;
}
.profile-info-item i {
    font-size:1.1rem;color:var(--color-primary);margin-top:2px;flex-shrink:0;
}
.info-label { font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.08em;margin:0 0 2px; }
.info-value { font-size:0.9rem;font-weight:600;color:rgba(255,255,255,0.85);margin:0; }

.profile-actions {
    display:flex;gap:0.75rem;flex-wrap:wrap;
}
.btn-profile-action {
    background:var(--color-primary);color:var(--color-white);border:none;border-radius:8px;
    padding:0.55rem 1.2rem;font-size:0.85rem;font-weight:600;
    text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;
    transition:background 0.2s;
}
.btn-profile-action:hover { background:var(--color-primary-strong);color:var(--color-white); }

.btn-profile-logout {
    background:rgba(239,68,68,0.1);color:var(--color-danger);
    border:1px solid rgba(239,68,68,0.2);border-radius:8px;
    padding:0.55rem 1.2rem;font-size:0.85rem;font-weight:600;
    cursor:pointer;display:inline-flex;align-items:center;gap:0.4rem;
    transition:all 0.2s;
}
.btn-profile-logout:hover { background:rgba(239,68,68,0.2);color:var(--color-danger-soft); }

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@endsection
