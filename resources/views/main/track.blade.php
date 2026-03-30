@extends('layouts.main')

@section('title', 'Track Your Parcel')

@section('content')

{{-- ═══════════════════ HERO + TRACK FORM ═══════════════════ --}}
<section class="track-hero d-flex align-items-center justify-content-center">
    <canvas id="track-canvas"></canvas>
    <div class="track-hero-overlay"></div>

    <div class="container track-hero-content text-center">
        <span class="section-badge">Live Tracking</span>
        <h1 class="fw-bold display-3 text-white mt-3 fade-up">
            Where's Your <span class="text-sky">Parcel?</span>
        </h1>
        <p class="lead text-white opacity-50 mt-3 fade-up delay-1" style="max-width:440px;margin:0 auto;">
            Enter your tracking number below for real-time shipment updates.
        </p>

        {{-- TRACK FORM --}}
        <div class="track-form-wrap fade-up delay-2 mt-5">
            <form method="POST" action="{{ route('track.result') }}">
                @csrf
                <div class="track-input-group">
                    <div class="track-input-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                    <input type="text"
                           name="tracking_number"
                           class="track-input"
                           placeholder="Enter tracking number e.g. SS-2024-001234"
                           autocomplete="off"
                           required>
                    <button type="submit" class="track-btn">
                        Track Now
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ms-2">
                            <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                        </svg>
                    </button>
                </div>
            </form>

            @if(session('error'))
            <div class="alert-dark-error mt-3">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif
        </div>

        {{-- SAMPLE HINT --}}
        <p class="text-white opacity-25 mt-4 fade-up delay-2" style="font-size:0.78rem;letter-spacing:0.05em;">
            Find your tracking number in your booking confirmation email
        </p>
    </div>
</section>

{{-- ═══════════════════ TRACK RESULT (if exists) ═══════════════════ --}}
@if(isset($parcel))
<section class="py-5 section-dark">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- PARCEL HEADER --}}
                <div class="result-header-card fade-up">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <p class="result-label">Tracking Number</p>
                            <h4 class="text-white fw-bold">{{ $parcel->tracking_number }}</h4>
                        </div>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $parcel->status)) }}">
                            {{ $parcel->status }}
                        </span>
                    </div>
                    <hr class="divider">
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <p class="result-label">Sender</p>
                            <p class="result-value">{{ $parcel->sender_name ?? '—' }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p class="result-label">Recipient</p>
                            <p class="result-value">{{ $parcel->recipient_name ?? '—' }}</p>
                        </div>
                        <div class="col-sm-4">
                            <p class="result-label">Destination</p>
                            <p class="result-value">{{ $parcel->destination ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                {{-- TIMELINE --}}
                @if(isset($parcel->statusLogs) && $parcel->statusLogs->count())
                <div class="mt-4 fade-up delay-1">
                    <h5 class="text-white fw-bold mb-4">Shipment Timeline</h5>
                    <div class="timeline">
                        @foreach($parcel->statusLogs->sortByDesc('created_at') as $log)
                        <div class="timeline-item {{ $loop->first ? 'timeline-item-active' : '' }}">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <p class="timeline-status">{{ $log->status }}</p>
                                <p class="timeline-time">{{ $log->created_at->format('d M Y · h:i A') }}</p>
                                @if($log->note)
                                <p class="timeline-note">{{ $log->note }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- MAP --}}
                @if(isset($parcel->id))
                <div class="mt-4 fade-up delay-2">
                    <h5 class="text-white fw-bold mb-3">Live Location</h5>
                    <div class="map-wrap">
                        <div id="parcel-map" style="height:320px;"></div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════ HOW TRACKING WORKS ═══════════════════ --}}
<section class="py-5 section-deeper">
    <div class="container">
        <div class="text-center mb-5 fade-up">
            <span class="section-label">How It Works</span>
            <h2 class="fw-bold text-white mt-2">Real-Time Tracking in 3 Steps</h2>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 text-center fade-up">
                <div class="step-circle">1</div>
                <h6 class="text-white fw-bold mt-4">Enter Your Number</h6>
                <p class="text-muted-light mt-2">Find the tracking ID in your booking confirmation and paste it above.</p>
            </div>
            <div class="col-md-4 text-center fade-up delay-1">
                <div class="step-circle step-amber">2</div>
                <h6 class="text-white fw-bold mt-4">We Locate Your Parcel</h6>
                <p class="text-muted-light mt-2">Our system pings the assigned agent's GPS for the latest location.</p>
            </div>
            <div class="col-md-4 text-center fade-up delay-2">
                <div class="step-circle step-green">3</div>
                <h6 class="text-white fw-bold mt-4">Get Live Updates</h6>
                <p class="text-muted-light mt-2">See the full status timeline and estimated delivery time instantly.</p>
            </div>
        </div>
    </div>
</section>

<style>
.section-dark   { background: var(--color-bg-section); }
.section-deeper { background: var(--color-bg-section-2); }
.text-muted-light { color:rgba(255,255,255,0.45);font-size:0.875rem;line-height:1.75; }
.text-sky { color:var(--color-primary); }

/* HERO */
.track-hero {
    position: relative;
    min-height: 80vh;
    background: var(--color-bg-section-2);
    overflow: hidden;
}
#track-canvas {
    position: absolute; inset: 0;
    width: 100%; height: 100%; z-index: 1;
}
.track-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, rgba(8,12,18,0.55), rgba(8,12,18,0.88));
    z-index: 2;
}
.track-hero-content { position:relative; z-index:3; }

.section-badge {
    display:inline-block;
    background:rgba(14,165,233,0.12);color:var(--color-primary);
    border:1px solid rgba(14,165,233,0.3);border-radius:100px;
    padding:0.3rem 1.1rem;font-size:0.78rem;font-weight:600;
    letter-spacing:0.12em;text-transform:uppercase;
}
.section-label {
    display:inline-block;color:var(--color-primary);
    font-size:0.75rem;font-weight:700;letter-spacing:0.18em;text-transform:uppercase;
}

/* FADE */
.fade-up { opacity:0;transform:translateY(24px);animation:fadeUp 0.8s ease forwards; }
.delay-1 { animation-delay:0.2s; }
.delay-2 { animation-delay:0.4s; }
@keyframes fadeUp { to { opacity:1;transform:translateY(0); } }

/* TRACK FORM */
.track-form-wrap { max-width: 620px; margin: 0 auto; }
.track-input-group {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(14,165,233,0.35);
    border-radius: 16px;
    padding: 0.5rem 0.5rem 0.5rem 1rem;
    gap: 0.75rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.track-input-group:focus-within {
    border-color: var(--color-primary);
    box-shadow: 0 0 0 4px rgba(14,165,233,0.12);
}
.track-input-icon { flex-shrink: 0; }
.track-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--color-white);
    font-size: 0.95rem;
    min-width: 0;
}
.track-input::placeholder { color: rgba(255,255,255,0.3); }
.track-btn {
    background: var(--color-primary);
    color: var(--color-white);
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    white-space: nowrap;
    display: flex;
    align-items: center;
    transition: background 0.2s, transform 0.15s;
    flex-shrink: 0;
}
.track-btn:hover { background:var(--color-primary-strong); transform:translateX(2px); }

.alert-dark-error {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.25);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    color: var(--color-danger);
    font-size: 0.875rem;
}

/* RESULT CARD */
.result-header-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 2rem;
}
.result-label { color:rgba(255,255,255,0.35);font-size:0.72rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;margin:0 0 4px; }
.result-value { color:rgba(255,255,255,0.8);font-size:0.9rem;margin:0; }
.divider { border-color:rgba(255,255,255,0.07);margin:1.5rem 0; }

/* STATUS BADGES */
.status-badge { padding:0.35rem 1rem;border-radius:100px;font-size:0.75rem;font-weight:700;letter-spacing:0.06em;text-transform:uppercase; }
.status-delivered { background:rgba(52,211,153,0.12);color:var(--color-success);border:1px solid rgba(52,211,153,0.25); }
.status-pending   { background:rgba(251,191,36,0.12);color:var(--color-warning);border:1px solid rgba(251,191,36,0.25); }
.status-in-transit{ background:rgba(14,165,233,0.12);color:var(--color-primary);border:1px solid rgba(14,165,233,0.25); }
.status-cancelled { background:rgba(239,68,68,0.12);color:var(--color-danger);border:1px solid rgba(239,68,68,0.25); }

/* TIMELINE */
.timeline { position:relative;padding-left:1.75rem; }
.timeline::before {
    content:'';position:absolute;left:7px;top:0;bottom:0;
    width:1px;background:rgba(255,255,255,0.08);
}
.timeline-item { position:relative;margin-bottom:1.75rem; }
.timeline-dot {
    position:absolute;left:-1.75rem;top:4px;
    width:14px;height:14px;border-radius:50%;
    background:var(--color-bg-section);border:2px solid rgba(255,255,255,0.2);
    transition:all 0.2s;
}
.timeline-item-active .timeline-dot {
    background:var(--color-primary);border-color:var(--color-primary);
    box-shadow:0 0 10px rgba(14,165,233,0.5);
}
.timeline-status { color:rgba(255,255,255,0.85);font-weight:600;font-size:0.9rem;margin:0 0 2px; }
.timeline-time { color:rgba(255,255,255,0.3);font-size:0.78rem;margin:0; }
.timeline-note { color:rgba(255,255,255,0.45);font-size:0.82rem;margin-top:4px;margin-bottom:0; }

/* MAP */
.map-wrap { border-radius:16px;overflow:hidden;border:1px solid rgba(255,255,255,0.07); }

/* STEPS */
.step-circle {
    width:72px;height:72px;border-radius:50%;margin:0 auto;
    background:rgba(14,165,233,0.1);border:2px solid rgba(14,165,233,0.3);
    color:var(--color-primary);font-size:1.5rem;font-weight:800;
    display:flex;align-items:center;justify-content:center;
}
.step-amber { background:rgba(251,191,36,0.1);border-color:rgba(251,191,36,0.3);color:var(--color-warning); }
.step-green { background:rgba(52,211,153,0.1);border-color:rgba(52,211,153,0.3);color:var(--color-success); }

@media(max-width:576px){
    .track-btn { padding:0.7rem 1rem;font-size:0.82rem; }
    .track-input-group { padding:0.4rem 0.4rem 0.4rem 0.75rem; }
}
</style>

{{-- 3D PARTICLE BACKGROUND --}}
<script src="{{ asset('vendor/three/three.min.js') }}"></script>
<script>
(function(){
    const canvas = document.getElementById('track-canvas');
    const section = canvas.parentElement;
    const W = ()=>section.offsetWidth, H = ()=>section.offsetHeight;
    const renderer = new THREE.WebGLRenderer({canvas,antialias:true,alpha:false});
    renderer.setPixelRatio(Math.min(devicePixelRatio,2));
    renderer.setSize(W(),H());
    renderer.setClearColor(0x080c12,1);

    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x080c12,0.015);
    const camera = new THREE.PerspectiveCamera(65,W()/H(),0.1,200);
    camera.position.z=22;

    // Particles
    const n=3500,pos=new Float32Array(n*3);
    for(let i=0;i<n*3;i++) pos[i]=(Math.random()-.5)*90;
    const geo=new THREE.BufferGeometry();
    geo.setAttribute('position',new THREE.BufferAttribute(pos,3));
    scene.add(new THREE.Points(geo,new THREE.PointsMaterial({color:0x0ea5e9,size:0.1,transparent:true,opacity:0.45})));

    // Floating boxes (parcels)
    const boxGeo=new THREE.BoxGeometry(0.3,0.22,0.22);
    const boxes=[];
    const cols=[0xfbbf24,0x0ea5e9,0x34d399];
    for(let i=0;i<20;i++){
        const m=new THREE.MeshStandardMaterial({color:cols[i%3],emissive:cols[i%3],emissiveIntensity:0.3,roughness:0.4,metalness:0.5});
        const b=new THREE.Mesh(boxGeo,m);
        b.position.set((Math.random()-.5)*30,(Math.random()-.5)*15,(Math.random()-.5)*15);
        b.userData={ax:new THREE.Vector3(Math.random(),Math.random(),Math.random()).normalize(),sp:0.005+Math.random()*0.01,oy:b.position.y,ph:Math.random()*Math.PI*2};
        scene.add(b); boxes.push(b);
    }

    scene.add(new THREE.AmbientLight(0xffffff,0.5));
    const pl=new THREE.PointLight(0x0ea5e9,2,40); pl.position.set(0,0,10); scene.add(pl);

    let mx=0,my=0,smx=0,smy=0;
    window.addEventListener('mousemove',e=>{mx=(e.clientX/window.innerWidth-.5)*2;my=-(e.clientY/window.innerHeight-.5)*2;});
    window.addEventListener('resize',()=>{renderer.setSize(W(),H());camera.aspect=W()/H();camera.updateProjectionMatrix();});

    const clk=new THREE.Clock();
    (function animate(){
        requestAnimationFrame(animate);
        const t=clk.getElapsedTime();
        smx+=(mx-smx)*.03; smy+=(my-smy)*.03;
        camera.position.x=smx*2.5; camera.position.y=smy*1.5; camera.lookAt(0,0,0);
        boxes.forEach(b=>{
            b.rotateOnAxis(b.userData.ax,b.userData.sp);
            b.position.y=b.userData.oy+Math.sin(t*0.6+b.userData.ph)*0.4;
        });
        renderer.render(scene,camera);
    })();
})();
</script>

@if(isset($parcel) && isset($parcel->id))
<link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}"/>
<script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){
    const map = L.map('parcel-map', { zoomControl: true }).setView([20.5937, 78.9629], 5);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap &copy; CARTO', maxZoom: 18
    }).addTo(map);

    fetch('{{ route("parcel.location", $parcel->id) }}')
        .then(r=>r.json())
        .then(data=>{
            if(data.lat && data.lng){
                const icon = L.divIcon({
                    html: '<div style="width:14px;height:14px;background:var(--color-primary);border:3px solid var(--color-white);border-radius:50%;box-shadow:0 0 10px rgba(14,165,233,0.8);"></div>',
                    className:'',iconAnchor:[7,7]
                });
                L.marker([data.lat,data.lng],{icon}).addTo(map)
                    .bindPopup('<b style="color:var(--color-primary)">Parcel Location</b>').openPopup();
                map.setView([data.lat,data.lng],13);
            }
        }).catch(()=>{});
});
</script>
@endif

@endsection

