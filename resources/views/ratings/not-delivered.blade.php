@extends('layouts.main')

@section('content')

<section class="notdel-hero d-flex align-items-center justify-content-center text-center">
    <div class="container">
        <div class="notdel-card fade-up">
            <div class="notdel-icon">📦</div>
            <h1 class="fw-bold text-white mt-4">Not Yet Delivered</h1>
            <p class="text-muted-light mt-3" style="max-width:440px;margin:0 auto;">
                Parcel <strong class="text-sky">{{ $parcel->tracking_id }}</strong>
                hasn't been delivered yet. You can rate your delivery experience once the parcel is delivered.
            </p>

            <div class="notdel-status-badge mt-4">
                <span class="status-dot"></span>
                Current status: <strong>{{ ucfirst(str_replace('_', ' ', $parcel->status)) }}</strong>
            </div>

            <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('track.page') }}" class="btn btn-sky btn-lg px-5 rounded-pill">
                    Track This Parcel
                </a>
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.notdel-hero {
    min-height: 80vh;
    background: linear-gradient(135deg, var(--color-bg-section-2) 0%, var(--color-bg-overlay) 100%);
}
.notdel-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 3rem 2rem;
    max-width: 560px;
    margin: 0 auto;
}
.notdel-icon { font-size: 4rem; }
.text-muted-light { color: rgba(255,255,255,0.45); font-size: 0.95rem; line-height: 1.75; }
.text-sky { color: var(--color-primary); }

.notdel-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(251,191,36,0.1);
    border: 1px solid rgba(251,191,36,0.25);
    border-radius: 100px;
    padding: 0.45rem 1.2rem;
    color: var(--color-warning);
    font-size: 0.85rem;
    font-weight: 600;
}
.status-dot {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: var(--color-warning);
    box-shadow: 0 0 8px rgba(251,191,36,0.6);
}

.btn-sky { background:var(--color-primary);color:var(--color-white);border:none;font-weight:600;transition:background 0.2s; }
.btn-sky:hover { background:var(--color-primary-strong);color:var(--color-white); }

.fade-up { opacity:0;transform:translateY(24px);animation:fadeUp 0.8s ease forwards; }
@keyframes fadeUp { to { opacity:1;transform:translateY(0); } }
</style>

@endsection
