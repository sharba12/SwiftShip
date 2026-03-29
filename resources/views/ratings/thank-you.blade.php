@extends('layouts.main')

@section('title', 'Thank You')

@section('content')

<section class="thankyou-hero d-flex align-items-center justify-content-center text-center">
    <div class="container">
        <div class="thankyou-card fade-up">
            <div style="font-size:4rem;">🎉</div>
            <h1 class="fw-bold text-white mt-3">Thank You!</h1>
            <p class="text-muted-light mt-3" style="max-width:380px;margin:0 auto;">
                Your feedback helps us improve our service. We truly appreciate you taking the time to rate your delivery.
            </p>
            <div class="mt-4 d-flex gap-3 justify-content-center flex-wrap">
                <a href="{{ route('home') }}" class="btn btn-sky btn-lg px-5 rounded-pill">
                    Back to Home
                </a>
                <a href="{{ route('track.page') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill">
                    Track Another Parcel
                </a>
            </div>
        </div>
    </div>
</section>

<style>
.thankyou-hero {
    min-height: 80vh;
    background: linear-gradient(135deg, var(--color-bg-section-2) 0%, var(--color-bg-overlay) 100%);
}
.thankyou-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 3rem 2rem;
    max-width: 520px;
    margin: 0 auto;
}
.text-muted-light { color: rgba(255,255,255,0.45); font-size: 0.95rem; line-height: 1.75; }

.btn-sky { background:var(--color-primary);color:var(--color-white);border:none;font-weight:600;transition:background 0.2s; }
.btn-sky:hover { background:var(--color-primary-strong);color:var(--color-white); }

.fade-up { opacity:0;transform:translateY(24px);animation:fadeUp 0.8s ease forwards; }
@keyframes fadeUp { to { opacity:1;transform:translateY(0); } }
</style>

@endsection
