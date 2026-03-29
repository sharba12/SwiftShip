@extends('layouts.main')

@section('title', 'Rate Your Delivery')

@section('content')

<section class="py-5 section-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7">

                {{-- HEADER --}}
                <div class="text-center mb-5 fade-up">
                    <span class="section-badge">Feedback</span>
                    <h1 class="fw-bold display-5 text-white mt-3">Rate Your <span class="text-sky">Delivery</span></h1>
                    <p class="text-muted-light mt-2">Help us improve our service with your feedback</p>
                </div>

                {{-- PARCEL INFO --}}
                <div class="rating-card fade-up" style="animation-delay:0.1s">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <p class="rating-label">Tracking ID</p>
                            <p class="rating-value fw-bold" style="color:var(--color-primary);font-size:1.05rem;">{{ $parcel->tracking_id }}</p>
                        </div>
                        <span class="delivered-badge">✓ Delivered</span>
                    </div>

                    <hr class="rating-divider">

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <p class="rating-label">Delivered To</p>
                            <p class="rating-value">{{ $parcel->receiver_name }}</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="rating-label">Delivered By</p>
                            <p class="rating-value">{{ $parcel->agent->name }}</p>
                        </div>
                    </div>
                </div>

                {{-- RATING FORM --}}
                <div class="rating-card mt-4 fade-up" style="animation-delay:0.2s">
                    <form action="{{ route('rating.store', $parcel->tracking_id) }}" method="POST">
                        @csrf

                        {{-- STAR RATING --}}
                        <div class="mb-4 text-center">
                            <p class="text-white fw-bold mb-3" style="font-size:1.05rem;">How would you rate your experience?</p>

                            <div class="d-flex justify-content-center gap-2 star-container" id="starContainer">
                                @for($i = 1; $i <= 5; $i++)
                                <svg class="star-icon" data-rating="{{ $i }}" width="48" height="48" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                @endfor
                            </div>

                            <input type="hidden" name="rating" id="ratingInput" required>
                            <p id="ratingText" class="text-muted-light mt-2 mb-0"></p>

                            @error('rating')
                            <p style="color:var(--color-danger);font-size:0.85rem;" class="mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- FEEDBACK --}}
                        <div class="mb-4">
                            <label class="form-label-dark">Share your feedback (Optional)</label>
                            <textarea name="feedback" rows="4" class="form-control form-control-dark"
                                      placeholder="Tell us about your delivery experience…">{{ old('feedback') }}</textarea>
                            @error('feedback')
                            <p style="color:var(--color-danger);font-size:0.82rem;" class="mt-1 mb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- CUSTOMER INFO --}}
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="form-label-dark">Your Name <span style="color:var(--color-danger);">*</span></label>
                                <input type="text" name="customer_name"
                                       value="{{ old('customer_name', $parcel->customer->name ?? '') }}"
                                       class="form-control form-control-dark" required>
                                @error('customer_name')
                                <p style="color:var(--color-danger);font-size:0.82rem;" class="mt-1 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label-dark">Email (Optional)</label>
                                <input type="email" name="customer_email"
                                       value="{{ old('customer_email', $parcel->customer->email ?? '') }}"
                                       class="form-control form-control-dark">
                                @error('customer_email')
                                <p style="color:var(--color-danger);font-size:0.82rem;" class="mt-1 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit" class="btn btn-sky btn-lg w-100 rounded-pill">
                            Submit Rating
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ms-2">
                                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </button>
                    </form>
                </div>

                {{-- BACK --}}
                <div class="text-center mt-4 fade-up" style="animation-delay:0.3s">
                    <a href="{{ route('track.page') }}" class="btn btn-outline-light px-4 rounded-pill">
                        ← Back to Tracking
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
.section-dark { background: var(--color-bg-section); min-height: 70vh; }
.text-muted-light { color: rgba(255,255,255,0.45); font-size: 0.9rem; line-height: 1.75; }
.text-sky { color: var(--color-primary); }

.section-badge {
    display:inline-block;background:rgba(14,165,233,0.12);color:var(--color-primary);
    border:1px solid rgba(14,165,233,0.3);border-radius:100px;
    padding:0.3rem 1.1rem;font-size:0.78rem;font-weight:600;
    letter-spacing:0.12em;text-transform:uppercase;
}

.rating-card {
    background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.07);
    border-radius:16px;padding:2rem;
}
.rating-label { color:rgba(255,255,255,0.35);font-size:0.72rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;margin:0 0 4px; }
.rating-value { color:rgba(255,255,255,0.85);font-size:0.9rem;margin:0; }
.rating-divider { border-color:rgba(255,255,255,0.07);margin:1.25rem 0; }

.delivered-badge {
    background:rgba(52,211,153,0.12);color:var(--color-success);
    border:1px solid rgba(52,211,153,0.25);
    border-radius:100px;padding:0.35rem 1rem;
    font-size:0.78rem;font-weight:700;
}

/* STARS */
.star-icon {
    color:rgba(255,255,255,0.15);cursor:pointer;
    transition:all 0.2s ease;
}
.star-icon:hover { transform:scale(1.15); }
.star-icon.active { color:var(--color-warning); }

/* FORM */
.form-label-dark {
    color:rgba(255,255,255,0.6);font-size:0.82rem;
    font-weight:600;margin-bottom:0.4rem;display:block;
}
.form-control-dark {
    background:rgba(255,255,255,0.05) !important;
    border:1px solid rgba(255,255,255,0.1) !important;
    color:var(--color-white) !important;border-radius:10px;
    padding:0.7rem 1rem;font-size:0.9rem;
    transition:border-color 0.2s,box-shadow 0.2s;
}
.form-control-dark::placeholder { color:rgba(255,255,255,0.25) !important; }
.form-control-dark:focus {
    border-color:var(--color-primary) !important;
    box-shadow:0 0 0 3px rgba(14,165,233,0.12) !important;
    outline:none;background:rgba(255,255,255,0.07) !important;
}

/* BTN */
.btn-sky { background:var(--color-primary);color:var(--color-white);border:none;font-weight:600;transition:background 0.2s;display:inline-flex;align-items:center;justify-content:center; }
.btn-sky:hover { background:var(--color-primary-strong);color:var(--color-white); }

/* FADE */
.fade-up { opacity:0;transform:translateY(24px);animation:fadeUp 0.8s ease forwards; }
@keyframes fadeUp { to { opacity:1;transform:translateY(0); } }
</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const stars = document.querySelectorAll('.star-icon');
    const ratingInput = document.getElementById('ratingInput');
    const ratingText = document.getElementById('ratingText');

    const labels = {
        1: 'Poor — Not satisfied',
        2: 'Fair — Below expectations',
        3: 'Good — Met expectations',
        4: 'Very Good — Above expectations',
        5: 'Excellent — Outstanding service!'
    };

    function updateStars(rating, permanent) {
        stars.forEach((s, i) => {
            if (i < rating) { s.classList.add('active'); }
            else { s.classList.remove('active'); }
        });
        if (permanent) {
            ratingInput.value = rating;
            ratingText.textContent = labels[rating];
        }
    }

    stars.forEach(star => {
        star.addEventListener('click', () => updateStars(star.dataset.rating, true));
        star.addEventListener('mouseenter', () => updateStars(star.dataset.rating, false));
    });

    document.getElementById('starContainer').addEventListener('mouseleave', () => {
        const v = ratingInput.value;
        stars.forEach((s, i) => {
            if (v && i < v) { s.classList.add('active'); }
            else { s.classList.remove('active'); }
        });
    });
});
</script>

@endsection
