@extends('layouts.main')

@section('title', 'Premium Delivery Services | Fast & Secure Shipping')

@section('content')

{{-- ═══════════════════ HERO ═══════════════════ --}}
<section class="services-hero d-flex align-items-center justify-content-center text-center">
    <div class="services-hero-overlay"></div>
    <div class="container services-hero-content">
        <span class="section-badge">What We Offer</span>
        <h1 class="fw-bold display-3 text-white mt-3 fade-up">
            Premium Delivery<br><span class="text-sky">Services</span>
        </h1>
        <p class="lead text-white opacity-50 mt-3 fade-up delay-1" style="max-width:500px;margin:0 auto;">
            Fast, secure &amp; reliable shipping for your business and personal needs.
        </p>
    </div>
</section>

{{-- ═══════════════════ SERVICES GRID ═══════════════════ --}}
<section class="py-5 section-dark">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="section-label">Our Capabilities</span>
            <h2 class="fw-bold text-white mt-2">Everything You Need to Ship</h2>
        </div>

        @php
        $services = [
            ['icon'=>'📍','color'=>'var(--color-primary)','bg'=>'rgba(14,165,233,0.1)','title'=>'Real-Time Tracking','desc'=>'Track your shipment anytime using our GPS-enabled live tracking system with accurate ETA updates.'],
            ['icon'=>'🚚','color'=>'var(--color-success)','bg'=>'rgba(52,211,153,0.1)','title'=>'Fast Delivery','desc'=>'Quick, reliable delivery across multiple cities with optimised routing for the fastest possible transit.'],
            ['icon'=>'💬','color'=>'var(--color-violet)','bg'=>'rgba(167,139,250,0.1)','title'=>'24/7 Customer Support','desc'=>'Our support team is available around the clock to assist with any delivery questions or concerns.'],
            ['icon'=>'🔐','color'=>'var(--color-warning)','bg'=>'rgba(251,191,36,0.1)','title'=>'Secure Packaging','desc'=>'Every parcel is handled with extra care and protection, with audit-ready tracking at every step.'],
            ['icon'=>'🏠','color'=>'var(--color-danger)','bg'=>'rgba(248,113,113,0.1)','title'=>'Door-to-Door Pickup','desc'=>'We pick up parcels directly from your location — no need to travel to a drop-off point.'],
            ['icon'=>'🗺️','color'=>'var(--color-primary)','bg'=>'rgba(14,165,233,0.1)','title'=>'Multi-City Delivery','desc'=>'Deliver across 250+ cities with real-time updates and full chain-of-custody transparency.'],
            ['icon'=>'📦','color'=>'var(--color-success)','bg'=>'rgba(52,211,153,0.1)','title'=>'Business Shipping','desc'=>'Bulk &amp; scheduled deliveries designed for businesses of all sizes with dedicated account management.'],
            ['icon'=>'💳','color'=>'var(--color-warning)','bg'=>'rgba(251,191,36,0.1)','title'=>'Cash on Delivery','desc'=>'Convenient COD options available — we collect on your behalf and remit securely.'],
        ];
        @endphp

        <div class="row g-4">
            @foreach($services as $i => $s)
            <div class="col-lg-3 col-md-4 col-sm-6 fade-up" style="animation-delay:{{ $i * 0.08 }}s">
                <div class="service-card h-100">
                    <div class="service-icon" style="background:{{ $s['bg'] }};color:{{ $s['color'] }};">
                        {{ $s['icon'] }}
                    </div>
                    <h5 class="text-white fw-bold mt-4">{{ $s['title'] }}</h5>
                    <p class="text-muted-light mt-2 mb-0">{!! $s['desc'] !!}</p>
                    <div class="service-card-line" style="background:{{ $s['color'] }};"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════ PROCESS ═══════════════════ --}}
<section class="py-5 section-deeper">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="section-label">How It Works</span>
            <h2 class="fw-bold text-white mt-2">Ship in 3 Simple Steps</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 fade-up text-center">
                <div class="step-circle">1</div>
                <h5 class="text-white fw-bold mt-4">Book a Pickup</h5>
                <p class="text-muted-light mt-2">Schedule a pickup from your location at a time that suits you.</p>
            </div>
            <div class="col-md-4 fade-up delay-1 text-center">
                <div class="step-circle step-circle-amber">2</div>
                <h5 class="text-white fw-bold mt-4">We Handle It</h5>
                <p class="text-muted-light mt-2">Our verified agents collect and route your parcel with full tracking.</p>
            </div>
            <div class="col-md-4 fade-up delay-2 text-center">
                <div class="step-circle step-circle-green">3</div>
                <h5 class="text-white fw-bold mt-4">Delivered On Time</h5>
                <p class="text-muted-light mt-2">Your parcel arrives safely, with delivery confirmation sent instantly.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ CTA ═══════════════════ --}}
<section class="services-cta py-5 text-center">
    <div class="container fade-up">
        <h2 class="fw-bold text-white mb-3">Ready to Send a Parcel?</h2>
        <p class="text-white opacity-50 mb-4">Track your shipment and enjoy premium delivery.</p>
        <a href="{{ route('track.page') }}" class="btn btn-sky btn-lg px-5 rounded-pill me-3">Track Your Parcel</a>
        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill">Get In Touch</a>
    </div>
</section>

<style>
.section-dark   { background: var(--color-bg-section); }
.section-deeper { background: var(--color-bg-section-2); }
.text-muted-light { color: rgba(255,255,255,0.45); font-size: 0.9rem; line-height: 1.75; }
.text-sky { color: var(--color-primary); }

/* HERO */
.services-hero {
    position: relative;
    height: 68vh;
    background: linear-gradient(135deg, var(--color-bg-section-2) 0%, var(--color-bg-overlay) 100%);
    overflow: hidden;
}
.services-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(14,165,233,0.12) 0%, transparent 60%),
                radial-gradient(ellipse at 20% 80%, rgba(251,191,36,0.07) 0%, transparent 50%);
}
.services-hero-overlay {
    position: absolute; inset: 0;
    background: rgba(8,12,18,0.4);
    z-index: 1;
}
.services-hero-content { position: relative; z-index: 2; }

.section-badge {
    display: inline-block;
    background: rgba(14,165,233,0.12);
    color: var(--color-primary);
    border: 1px solid rgba(14,165,233,0.3);
    border-radius: 100px;
    padding: 0.3rem 1.1rem;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

.section-label {
    display: inline-block;
    color: var(--color-primary);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
}

/* FADE */
.fade-up {
    opacity: 0;
    transform: translateY(24px);
    animation: fadeUp 0.8s ease forwards;
}
.delay-1 { animation-delay: 0.15s; }
.delay-2 { animation-delay: 0.3s; }
@keyframes fadeUp { to { opacity:1; transform:translateY(0); } }

/* SERVICE CARDS */
.service-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 16px;
    padding: 2rem 1.5rem;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}
.service-card:hover {
    border-color: rgba(14,165,233,0.25);
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.35);
}
.service-card-line {
    position: absolute;
    bottom: 0; left: 0;
    width: 0; height: 2px;
    transition: width 0.4s ease;
    border-radius: 0 2px 0 0;
}
.service-card:hover .service-card-line { width: 100%; }

.service-icon {
    width: 56px; height: 56px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
}

/* STEPS */
.step-circle {
    width: 72px; height: 72px;
    border-radius: 50%;
    background: rgba(14,165,233,0.1);
    border: 2px solid rgba(14,165,233,0.35);
    color: var(--color-primary);
    font-size: 1.5rem;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto;
    transition: all 0.3s;
}
.step-circle:hover { background: rgba(14,165,233,0.2); transform: scale(1.08); }
.step-circle-amber {
    background: rgba(251,191,36,0.1);
    border-color: rgba(251,191,36,0.35);
    color: var(--color-warning);
}
.step-circle-green {
    background: rgba(52,211,153,0.1);
    border-color: rgba(52,211,153,0.35);
    color: var(--color-success);
}

/* BTN */
.btn-sky { background:var(--color-primary);color:var(--color-white);border:none;font-weight:600;transition:background 0.2s; }
.btn-sky:hover { background:var(--color-primary-strong);color:var(--color-white); }

/* CTA */
.services-cta {
    background: linear-gradient(135deg, var(--color-bg-section-2) 0%, var(--color-bg-overlay) 100%);
    border-top: 1px solid rgba(255,255,255,0.06);
}
</style>

@endsection
