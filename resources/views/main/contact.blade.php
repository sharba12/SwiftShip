@extends('layouts.main')

@section('title', 'Contact Us')

@section('content')

{{-- ═══════════════════ HERO ═══════════════════ --}}
<section class="contact-hero d-flex align-items-center justify-content-center text-center">
    <div class="container contact-hero-content">
        <span class="section-badge">Get In Touch</span>
        <h1 class="fw-bold display-3 text-white mt-3 fade-up">We're Here to <span class="text-sky">Help</span></h1>
        <p class="lead text-white opacity-50 mt-3 fade-up delay-1" style="max-width:460px;margin:0 auto;">
            Have a question about your delivery? Our team responds within 24 hours.
        </p>
    </div>
</section>

{{-- ═══════════════════ MAIN CONTENT ═══════════════════ --}}
<section class="py-5 section-dark">
    <div class="container">
        <div class="row g-5">

            {{-- CONTACT FORM --}}
            <div class="col-lg-7 fade-up">
                <div class="contact-form-card">
                    <h3 class="text-white fw-bold mb-1">Send Us a Message</h3>
                    <p class="text-muted-light mb-4">Fill out the form and we'll get back to you shortly.</p>

                    <form action="#" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-sm-6">
                                <label class="form-label-dark">Your Name</label>
                                <input type="text" class="form-control form-control-dark"
                                       name="name" placeholder="John Doe" required>
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label-dark">Email Address</label>
                                <input type="email" class="form-control form-control-dark"
                                       name="email" placeholder="john@email.com" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-dark">Subject</label>
                                <input type="text" class="form-control form-control-dark"
                                       name="subject" placeholder="e.g. Shipment enquiry">
                            </div>
                            <div class="col-12">
                                <label class="form-label-dark">Message</label>
                                <textarea class="form-control form-control-dark"
                                          name="message" rows="5"
                                          placeholder="Write your message here…" required></textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-sky btn-lg px-5 rounded-pill w-100">
                                    Send Message
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ms-2">
                                        <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- CONTACT INFO --}}
            <div class="col-lg-5 fade-up delay-1">
                <div class="d-flex flex-column gap-3 mb-4">
                    <div class="contact-info-card">
                        <div class="contact-info-icon" style="background:rgba(14,165,233,0.1);color:#0ea5e9;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-info-label">Office Address</p>
                            <p class="contact-info-value">21st Street, Business Park,<br>Mumbai, India</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon" style="background:rgba(52,211,153,0.1);color:#34d399;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.22 1.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.29 6.29l1.28-1.28a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-info-label">Phone Number</p>
                            <p class="contact-info-value">+91 98765 43210</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon" style="background:rgba(251,191,36,0.1);color:#fbbf24;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-info-label">Email Address</p>
                            <p class="contact-info-value">support@swiftship.in</p>
                        </div>
                    </div>

                    <div class="contact-info-card">
                        <div class="contact-info-icon" style="background:rgba(167,139,250,0.1);color:#a78bfa;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div>
                            <p class="contact-info-label">Working Hours</p>
                            <p class="contact-info-value">Mon – Sat: 9:00 AM – 6:00 PM<br><span style="color:rgba(255,255,255,0.3)">Sun: Closed</span></p>
                        </div>
                    </div>
                </div>

                {{-- Quick Track --}}
                <div class="quick-track-card">
                    <h6 class="text-white fw-bold mb-1">Quick Track</h6>
                    <p class="text-muted-light mb-3" style="font-size:0.82rem;">Have a tracking number? Check your parcel status instantly.</p>
                    <form action="{{ route('track.result') }}" method="POST" class="d-flex gap-2">
                        @csrf
                        <input type="text" name="tracking_number"
                               placeholder="Enter tracking number…"
                               class="form-control form-control-dark flex-grow-1">
                        <button type="submit" class="btn btn-sky px-4 rounded-pill">Track</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════ MAP ═══════════════════ --}}
<section class="section-deeper pb-5">
    <div class="container">
        <div class="map-wrap fade-up">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241319.91732115654!2d72.74110166292875!3d19.082197839949224!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c630586a1fb9%3A0x8f1f4277afd1d48a!2sMumbai%2C%20Maharashtra!5e0!3m2!1sen!2sin!4v1706012345678"
                width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
    </div>
</section>

<style>
.section-dark   { background: #0d1117; }
.section-deeper { background: #080c12; }
.text-muted-light { color: rgba(255,255,255,0.45); font-size: 0.875rem; line-height: 1.75; }
.text-sky { color: #0ea5e9; }

/* HERO */
.contact-hero {
    height: 55vh;
    background: linear-gradient(135deg, #080c12 0%, #0d1828 100%);
    position: relative;
    overflow: hidden;
}
.contact-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(14,165,233,0.1) 0%, transparent 60%);
}
.contact-hero-content { position: relative; z-index: 2; }

.section-badge {
    display: inline-block;
    background: rgba(14,165,233,0.12);
    color: #0ea5e9;
    border: 1px solid rgba(14,165,233,0.3);
    border-radius: 100px;
    padding: 0.3rem 1.1rem;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
}

/* FADE */
.fade-up { opacity:0; transform:translateY(24px); animation:fadeUp 0.8s ease forwards; }
.delay-1 { animation-delay: 0.2s; }
@keyframes fadeUp { to { opacity:1; transform:translateY(0); } }

/* FORM CARD */
.contact-form-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 20px;
    padding: 2.5rem;
}

.form-label-dark {
    color: rgba(255,255,255,0.6);
    font-size: 0.82rem;
    font-weight: 600;
    margin-bottom: 0.4rem;
    display: block;
}

.form-control-dark {
    background: rgba(255,255,255,0.05) !important;
    border: 1px solid rgba(255,255,255,0.1) !important;
    color: #fff !important;
    border-radius: 10px;
    padding: 0.7rem 1rem;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control-dark::placeholder { color: rgba(255,255,255,0.25) !important; }
.form-control-dark:focus {
    border-color: #0ea5e9 !important;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.12) !important;
    outline: none;
    background: rgba(255,255,255,0.07) !important;
}

/* CONTACT INFO CARDS */
.contact-info-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    padding: 1.25rem;
    transition: border-color 0.2s;
}
.contact-info-card:hover { border-color: rgba(14,165,233,0.25); }
.contact-info-icon {
    width: 44px; height: 44px; flex-shrink: 0;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
}
.contact-info-label {
    color: rgba(255,255,255,0.35);
    font-size: 0.72rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin: 0 0 2px;
}
.contact-info-value {
    color: rgba(255,255,255,0.85);
    font-size: 0.88rem;
    margin: 0;
    line-height: 1.5;
}

/* QUICK TRACK */
.quick-track-card {
    background: rgba(14,165,233,0.06);
    border: 1px solid rgba(14,165,233,0.2);
    border-radius: 14px;
    padding: 1.5rem;
}

/* MAP */
.map-wrap {
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.07);
}

/* BUTTONS */
.btn-sky { background:#0ea5e9;color:#fff;border:none;font-weight:600;transition:background 0.2s; }
.btn-sky:hover { background:#0284c7;color:#fff; }
</style>

@endsection