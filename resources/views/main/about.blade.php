@extends('layouts.main')

@section('title', 'About Us')

@section('content')

{{-- ═══════════════════ HERO ═══════════════════ --}}
<section class="about-hero d-flex align-items-center justify-content-center text-center">
    <canvas id="about-canvas"></canvas>
    <div class="about-hero-overlay"></div>
    <div class="container about-hero-content">
        <span class="about-badge">Our Story</span>
        <h1 class="fw-bold display-3 text-white mt-3 fade-up">About <span class="text-sky">Swift</span><span class="text-amber">Ship</span></h1>
        <p class="lead text-white opacity-50 mt-3 fade-up delay-1" style="max-width:520px;margin:0 auto;">
            Fast. Safe. Premium delivery service for businesses &amp; individuals across India.
        </p>
    </div>
</section>

{{-- ═══════════════════ WHO WE ARE ═══════════════════ --}}
<section class="py-5 section-dark">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 fade-up">
                <span class="section-label">Who We Are</span>
                <h2 class="fw-bold text-white mt-2 mb-4" style="font-size:2.2rem;line-height:1.2;">
                    Built for speed,<br>engineered for trust.
                </h2>
                <p class="text-muted-light">
                    SwiftShip is a modern courier and logistics company built with the vision
                    of delivering parcels with precision, speed, and safety.
                </p>
                <p class="text-muted-light mt-3">
                    We combine smart GPS tracking, reliable delivery agents, and a seamless
                    customer experience to ensure that every parcel reaches its destination
                    on time — every time.
                </p>
                <div class="row g-3 mt-4">
                    <div class="col-6">
                        <div class="stat-pill">
                            <span class="stat-num">10K+</span>
                            <span class="stat-label">Daily Deliveries</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-pill">
                            <span class="stat-num">250+</span>
                            <span class="stat-label">Cities Covered</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-pill">
                            <span class="stat-num">99.8%</span>
                            <span class="stat-label">On-Time Rate</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="stat-pill">
                            <span class="stat-num">24/7</span>
                            <span class="stat-label">Live Tracking</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 fade-up delay-1">
                <div class="about-img-wrap">
                    <img src="{{ asset('images/images.jpg') }}" alt="Delivery" class="img-fluid rounded-4 about-img">
                    <div class="img-glow"></div>
                    <div class="floating-badge-card">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0ea5e9" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span>Verified &amp; Secure</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ MISSION / VISION / VALUES ═══════════════════ --}}
<section class="py-5 section-deeper">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="section-label">What Drives Us</span>
            <h2 class="fw-bold text-white mt-2">Mission, Vision &amp; Values</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 fade-up">
                <div class="mvv-card h-100">
                    <div class="mvv-icon" style="background:rgba(14,165,233,0.12);color:#0ea5e9;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h4 class="text-white fw-bold mt-4">Our Mission</h4>
                    <p class="text-muted-light mt-2">
                        To deliver parcels with unmatched speed, safety, and real-time transparency — making logistics invisible to our customers.
                    </p>
                </div>
            </div>
            <div class="col-md-4 fade-up delay-1">
                <div class="mvv-card h-100 mvv-card-featured">
                    <div class="mvv-icon" style="background:rgba(251,191,36,0.12);color:#fbbf24;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h4 class="text-white fw-bold mt-4">Our Vision</h4>
                    <p class="text-muted-light mt-2">
                        To become India's most trusted and technology-driven delivery partner, connecting every corner of the country.
                    </p>
                </div>
            </div>
            <div class="col-md-4 fade-up delay-2">
                <div class="mvv-card h-100">
                    <div class="mvv-icon" style="background:rgba(52,211,153,0.12);color:#34d399;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                    <h4 class="text-white fw-bold mt-4">Our Values</h4>
                    <p class="text-muted-light mt-2">
                        Integrity, Speed, Customer Happiness, Reliability &amp; Safety — these aren't just words, they're our daily standard.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ WHY CHOOSE US ═══════════════════ --}}
<section class="py-5 section-dark">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="section-label">Why SwiftShip</span>
            <h2 class="fw-bold text-white mt-2">The SwiftShip Advantage</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 fade-up">
                <div class="why-card h-100">
                    <div class="why-num">01</div>
                    <h5 class="text-white fw-bold mt-3">Real-Time Tracking</h5>
                    <p class="text-muted-light mt-2">Know exactly where your parcel is with live GPS updates and accurate ETA.</p>
                </div>
            </div>
            <div class="col-md-4 fade-up delay-1">
                <div class="why-card h-100">
                    <div class="why-num">02</div>
                    <h5 class="text-white fw-bold mt-3">Fast Delivery</h5>
                    <p class="text-muted-light mt-2">Professional agents using optimised routes ensure quick, on-time delivery every time.</p>
                </div>
            </div>
            <div class="col-md-4 fade-up delay-2">
                <div class="why-card h-100">
                    <div class="why-num">03</div>
                    <h5 class="text-white fw-bold mt-3">24/7 Support</h5>
                    <p class="text-muted-light mt-2">Our support team is always ready to assist you — anytime, anywhere.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════ CTA ═══════════════════ --}}
<section class="py-5 about-cta text-center">
    <div class="container fade-up">
        <h2 class="fw-bold text-white mb-3">Ready to ship with confidence?</h2>
        <p class="text-white opacity-50 mb-4">Join thousands of businesses trusting SwiftShip every day.</p>
        <a href="{{ route('track.page') }}" class="btn btn-sky btn-lg px-5 rounded-pill me-3">Track a Parcel</a>
        <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill">Contact Us</a>
    </div>
</section>

<style>
/* ── BASE ── */
.section-dark   { background: #0d1117; }
.section-deeper { background: #080c12; }
.text-muted-light { color: rgba(255,255,255,0.45); font-size: 0.95rem; line-height: 1.75; }
.text-sky   { color: #0ea5e9; }
.text-amber { color: #fbbf24; }

/* ── HERO ── */
.about-hero {
    position: relative;
    height: 72vh;
    background: #080c12;
    overflow: hidden;
}
#about-canvas {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    z-index: 1;
}
.about-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, rgba(8,12,18,0.5), rgba(8,12,18,0.85));
    z-index: 2;
}
.about-hero-content { position: relative; z-index: 3; }

.about-badge {
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

.section-label {
    display: inline-block;
    color: #0ea5e9;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
}

/* ── FADE UP ── */
.fade-up {
    opacity: 0;
    transform: translateY(24px);
    animation: fadeUp 0.85s ease forwards;
}
.delay-1 { animation-delay: 0.2s; }
.delay-2 { animation-delay: 0.4s; }
@keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }

/* ── STAT PILLS ── */
.stat-pill {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    padding: 1rem 1.2rem;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.stat-num { color: #0ea5e9; font-size: 1.5rem; font-weight: 800; line-height: 1; }
.stat-label { color: rgba(255,255,255,0.4); font-size: 0.75rem; }

/* ── ABOUT IMAGE ── */
.about-img-wrap { position: relative; display: inline-block; width: 100%; }
.about-img { width: 100%; object-fit: cover; max-height: 420px; border: 1px solid rgba(255,255,255,0.07); }
.img-glow {
    position: absolute; inset: -1px;
    border-radius: 16px;
    box-shadow: 0 0 60px rgba(14,165,233,0.15);
    pointer-events: none;
}
.floating-badge-card {
    position: absolute;
    bottom: -16px; left: 24px;
    background: #0d1117;
    border: 1px solid rgba(14,165,233,0.25);
    border-radius: 10px;
    padding: 0.6rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #fff;
    font-size: 0.82rem;
    font-weight: 600;
    backdrop-filter: blur(8px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.4);
}

/* ── MVV CARDS ── */
.mvv-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 16px;
    padding: 2rem;
    transition: all 0.3s;
}
.mvv-card:hover {
    border-color: rgba(14,165,233,0.3);
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}
.mvv-card-featured {
    border-color: rgba(251,191,36,0.2);
    background: rgba(251,191,36,0.03);
}
.mvv-icon {
    width: 52px; height: 52px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
}

/* ── WHY CARDS ── */
.why-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 16px;
    padding: 2rem;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}
.why-card:hover {
    border-color: rgba(14,165,233,0.25);
    transform: translateY(-5px);
}
.why-num {
    font-size: 3.5rem;
    font-weight: 800;
    color: rgba(14,165,233,0.1);
    line-height: 1;
    position: absolute;
    top: 1rem; right: 1.5rem;
}

/* ── BTN ── */
.btn-sky {
    background: #0ea5e9;
    color: #fff;
    border: none;
    font-weight: 600;
    transition: background 0.2s;
}
.btn-sky:hover { background: #0284c7; color: #fff; }

/* ── CTA ── */
.about-cta {
    background: linear-gradient(135deg, #080c12 0%, #0d1828 100%);
    border-top: 1px solid rgba(255,255,255,0.06);
}
</style>

{{-- ── MINI 3D PARTICLE HERO ── --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
(function(){
    const canvas = document.getElementById('about-canvas');
    const section = canvas.parentElement;
    const W = () => section.offsetWidth, H = () => section.offsetHeight;
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
    renderer.setSize(W(), H());
    renderer.setClearColor(0x080c12, 1);

    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x080c12, 0.018);
    const camera = new THREE.PerspectiveCamera(65, W()/H(), 0.1, 200);
    camera.position.z = 20;

    // Particles
    const geo = new THREE.BufferGeometry();
    const n = 3000, pos = new Float32Array(n*3);
    for(let i=0;i<n*3;i++) pos[i]=(Math.random()-.5)*80;
    geo.setAttribute('position', new THREE.BufferAttribute(pos,3));
    const pts = new THREE.Points(geo, new THREE.PointsMaterial({color:0x38bdf8,size:0.12,transparent:true,opacity:0.5}));
    scene.add(pts);

    // Lines network
    const lineMat = new THREE.LineBasicMaterial({color:0x0ea5e9,transparent:true,opacity:0.08});
    for(let i=0;i<30;i++){
        const lGeo = new THREE.BufferGeometry();
        const p = new Float32Array(6);
        for(let k=0;k<6;k++) p[k]=(Math.random()-.5)*40;
        lGeo.setAttribute('position', new THREE.BufferAttribute(p,3));
        scene.add(new THREE.Line(lGeo, lineMat));
    }

    scene.add(new THREE.AmbientLight(0xffffff,0.4));

    let mx=0, my=0;
    window.addEventListener('mousemove', e=>{
        mx=(e.clientX/window.innerWidth-.5)*2;
        my=-(e.clientY/window.innerHeight-.5)*2;
    });
    window.addEventListener('resize',()=>{
        renderer.setSize(W(),H());
        camera.aspect=W()/H();
        camera.updateProjectionMatrix();
    });

    let smx=0,smy=0;
    const clock = new THREE.Clock();
    (function animate(){
        requestAnimationFrame(animate);
        const t = clock.getElapsedTime();
        smx+=(mx-smx)*.03; smy+=(my-smy)*.03;
        camera.position.x = smx*2;
        camera.position.y = smy*1.5;
        camera.lookAt(0,0,0);
        pts.rotation.y = t*0.03;
        renderer.render(scene,camera);
    })();
})();
</script>

@endsection