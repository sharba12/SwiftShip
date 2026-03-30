@extends('layouts.main')

@section('content')

<!-- ================= HERO SECTION (3D Background) ================= -->
<section class="hero-3d d-flex align-items-center">
    <canvas id="hero-canvas"></canvas>
    <div class="video-overlay"></div>

    <div class="container hero-content">
        <div class="row">
            <div class="col-lg-7">
                <h1 class="display-4 fw-bold hero-title fade-up">
                    Reliable Logistics.<br>
                    Delivered With Precision.
                </h1>

                <p class="lead mt-3 text-light opacity-75 fade-up delay-1">
                    Smart delivery solutions with real-time tracking, secure handling,
                    and complete operational transparency.
                </p>

                <div class="mt-4 fade-up delay-2">
                    <a href="{{ route('track.page') }}"
                       class="btn btn-primary btn-lg px-5 rounded-pill me-3">
                        Track Shipment
                    </a>

                    <a href="{{ route('services') }}"
                       class="btn btn-outline-light btn-lg px-5 rounded-pill">
                        Our Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= TRUST METRICS ================= -->
<section class="py-4" style="background:var(--color-bg-section);border-bottom:1px solid rgba(255,255,255,0.06);">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 fade-up">
                <h4 class="fw-bold" style="color:var(--color-primary);">10K+</h4>
                <p class="small mb-0" style="color:rgba(255,255,255,0.4);">Daily Deliveries</p>
            </div>
            <div class="col-md-3 fade-up delay-1">
                <h4 class="fw-bold" style="color:var(--color-primary);">250+</h4>
                <p class="small mb-0" style="color:rgba(255,255,255,0.4);">Service Locations</p>
            </div>
            <div class="col-md-3 fade-up delay-2">
                <h4 class="fw-bold" style="color:var(--color-primary);">99.8%</h4>
                <p class="small mb-0" style="color:rgba(255,255,255,0.4);">On-Time Delivery</p>
            </div>
            <div class="col-md-3 fade-up delay-3">
                <h4 class="fw-bold" style="color:var(--color-primary);">24/7</h4>
                <p class="small mb-0" style="color:rgba(255,255,255,0.4);">Live Tracking</p>
            </div>
        </div>
    </div>
</section>

<!-- ================= WHY CHOOSE US ================= -->
<section class="py-5" style="background:var(--color-bg-section-2);">
    <div class="container">

        <div class="text-center mb-5 fade-up">
            <h2 class="fw-bold text-white">Why Choose SwiftShip</h2>
            <p class="mt-2" style="color:rgba(255,255,255,0.45);">
                A logistics platform engineered for reliability, speed, and scale
            </p>
        </div>

        <!-- Feature Row 1 -->
        <div class="row g-4 mb-4">
            <div class="col-md-4 fade-up">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon mb-3">📍</div>
                    <h5 class="fw-semibold text-white">Real-Time Tracking</h5>
                    <p style="color:rgba(255,255,255,0.45);">
                        Live shipment visibility with accurate ETA updates.
                    </p>
                </div>
            </div>

            <div class="col-md-4 fade-up delay-1">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon mb-3">🚚</div>
                    <h5 class="fw-semibold text-white">Optimized Routing</h5>
                    <p style="color:rgba(255,255,255,0.45);">
                        Faster deliveries using intelligent route optimization.
                    </p>
                </div>
            </div>

            <div class="col-md-4 fade-up delay-2">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon mb-3">🔐</div>
                    <h5 class="fw-semibold text-white">Secure Handling</h5>
                    <p style="color:rgba(255,255,255,0.45);">
                        End-to-end parcel security with audit-ready tracking.
                    </p>
                </div>
            </div>
        </div>

        <!-- Feature Row 2 -->
        <div class="row g-4">
            <div class="col-md-4 fade-up">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon mb-3">📊</div>
                    <h5 class="fw-semibold text-white">Operational Analytics</h5>
                    <p style="color:rgba(255,255,255,0.45);">
                        Monitor delivery performance and delay metrics in real time.
                    </p>
                </div>
            </div>

            <div class="col-md-4 fade-up delay-1">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon mb-3">🧭</div>
                    <h5 class="fw-semibold text-white">Smart Agent Assignment</h5>
                    <p style="color:rgba(255,255,255,0.45);">
                        Automatic agent allocation based on proximity and workload.
                    </p>
                </div>
            </div>

            <div class="col-md-4 fade-up delay-2">
                <div class="feature-card h-100 p-4 text-center">
                    <div class="feature-icon mb-3">🗂️</div>
                    <h5 class="fw-semibold text-white">Delivery History</h5>
                    <p style="color:rgba(255,255,255,0.45);">
                        Complete shipment timeline with status logs and traceability.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ================= CTA ================= -->
<section class="py-5 cta-section text-center text-light">
    <div class="container fade-up">
        <h2 class="fw-bold mb-3">Become a Delivery Partner</h2>
        <p class="lead opacity-75 mb-4">
            Operate smarter with our professional agent dashboard.
        </p>

        <a href="{{ route('login') }}"
           class="btn btn-outline-light btn-lg px-5 rounded-pill">
            Partner Login
        </a>
    </div>
</section>

<!-- ================= STYLES ================= -->
<style>
/* HERO */
.hero-3d {
    position: relative;
    height: 92vh;
    overflow: hidden;
    background: var(--color-bg-hero);
}

#hero-canvas {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.video-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to right,
        rgba(15, 23, 42, 0.82),
        rgba(15, 23, 42, 0.35) 60%,
        transparent
    );
    z-index: 2;
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 3;
}

.hero-title {
    color: var(--color-white);
    text-shadow: 0 3px 12px rgba(0,0,0,0.75);
}

/* ANIMATIONS */
.fade-up {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.8s ease forwards;
}

@keyframes fadeUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.delay-1 { animation-delay: 0.15s; }
.delay-2 { animation-delay: 0.3s; }
.delay-3 { animation-delay: 0.45s; }

/* FEATURES */
.feature-card {
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    background: rgba(255,255,255,0.03);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.35);
    border-color: rgba(14,165,233,0.25);
}

.feature-icon {
    font-size: 42px;
}

/* CTA */
.cta-section {
    background: linear-gradient(135deg, var(--color-bg-hero), var(--color-slate-800));
}
</style>

<!-- ================= THREE.JS 3D HERO ================= -->
<script src="{{ asset('vendor/three/three.min.js') }}"></script>
<script>
(function () {
    const canvas = document.getElementById('hero-canvas');
    const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: false });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x0f172a, 1);

    const W = () => canvas.parentElement.offsetWidth;
    const H = () => canvas.parentElement.offsetHeight;
    renderer.setSize(W(), H());

    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x0f172a, 0.022);

    const camera = new THREE.PerspectiveCamera(60, W() / H(), 0.1, 300);
    camera.position.set(0, 0, 22);

    /* ── STARS ── */
    const starGeo = new THREE.BufferGeometry();
    const N = 5000;
    const pos = new Float32Array(N * 3);
    for (let i = 0; i < N * 3; i++) pos[i] = (Math.random() - 0.5) * 160;
    starGeo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    scene.add(new THREE.Points(starGeo, new THREE.PointsMaterial({
        color: 0xffffff, size: 0.14, sizeAttenuation: true, transparent: true, opacity: 0.55
    })));

    /* ── GLOBE (Earth-like node network) ── */
    const globeRadius = 6.5;
    const globeGeo = new THREE.SphereGeometry(globeRadius, 48, 48);
    const globeMat = new THREE.MeshStandardMaterial({
        color: 0x0ea5e9,
        emissive: 0x0369a1,
        emissiveIntensity: 0.35,
        roughness: 0.65,
        metalness: 0.3,
        wireframe: false,
        transparent: true,
        opacity: 0.18,
    });
    const globe = new THREE.Mesh(globeGeo, globeMat);
    globe.position.set(5, 0, 0);
    scene.add(globe);

    /* Wire overlay on globe */
    const wireGeo = new THREE.SphereGeometry(globeRadius + 0.05, 28, 28);
    const wireMat = new THREE.MeshBasicMaterial({
        color: 0x38bdf8, wireframe: true, transparent: true, opacity: 0.12
    });
    const wireGlobe = new THREE.Mesh(wireGeo, wireMat);
    wireGlobe.position.copy(globe.position);
    scene.add(wireGlobe);

    /* ── ROUTE NODES on globe surface ── */
    const nodeColor = 0xfbbf24; // amber — delivery node colour
    const nodes = [];
    const nodeCount = 22;
    const nodeGeoSmall = new THREE.SphereGeometry(0.14, 8, 8);
    const nodeMat = new THREE.MeshStandardMaterial({
        color: nodeColor, emissive: nodeColor, emissiveIntensity: 0.9, roughness: 0.2
    });

    const nodePositions = [];
    for (let i = 0; i < nodeCount; i++) {
        const phi = Math.acos(2 * Math.random() - 1);
        const theta = Math.random() * Math.PI * 2;
        const r = globeRadius + 0.18;
        const x = r * Math.sin(phi) * Math.cos(theta) + globe.position.x;
        const y = r * Math.sin(phi) * Math.sin(theta);
        const z = r * Math.cos(phi);
        nodePositions.push(new THREE.Vector3(x, y, z));
        const n = new THREE.Mesh(nodeGeoSmall, nodeMat.clone());
        n.position.set(x, y, z);
        scene.add(n);
        nodes.push(n);
    }

    /* ── ROUTE ARCS between nodes ── */
    function makeCurvedLine(a, b, color) {
        const mid = new THREE.Vector3().addVectors(a, b).multiplyScalar(0.5);
        // push midpoint outward from globe centre (globe.position)
        const globeCenter = globe.position.clone();
        const dir = mid.clone().sub(globeCenter).normalize();
        mid.add(dir.multiplyScalar(globeRadius * 0.5));

        const curve = new THREE.QuadraticBezierCurve3(a, mid, b);
        const pts = curve.getPoints(40);
        const geo = new THREE.BufferGeometry().setFromPoints(pts);
        const mat = new THREE.LineBasicMaterial({ color, transparent: true, opacity: 0.45 });
        return new THREE.Line(geo, mat);
    }

    const arcColors = [0x38bdf8, 0xfbbf24, 0x34d399];
    // connect each node to 2 random neighbours
    for (let i = 0; i < nodeCount; i++) {
        for (let k = 0; k < 2; k++) {
            const j = (i + 1 + Math.floor(Math.random() * (nodeCount - 2))) % nodeCount;
            const arc = makeCurvedLine(nodePositions[i], nodePositions[j], arcColors[k % 3]);
            scene.add(arc);
        }
    }

    /* ── FLOATING PARCELS (small cubes) ── */
    const parcelGeo = new THREE.BoxGeometry(0.35, 0.25, 0.25);
    const parcelColors = [0xfbbf24, 0xf97316, 0xffffff];
    const parcels = [];
    for (let i = 0; i < 18; i++) {
        const mat = new THREE.MeshStandardMaterial({
            color: parcelColors[i % 3],
            emissive: parcelColors[i % 3],
            emissiveIntensity: 0.3,
            roughness: 0.4,
            metalness: 0.5,
        });
        const mesh = new THREE.Mesh(parcelGeo, mat);
        const theta = Math.random() * Math.PI * 2;
        const phi = Math.acos(2 * Math.random() - 1);
        const r = 8 + Math.random() * 7;
        mesh.position.set(
            r * Math.sin(phi) * Math.cos(theta) + globe.position.x,
            r * Math.sin(phi) * Math.sin(theta),
            r * Math.cos(phi)
        );
        mesh.userData = {
            axis: new THREE.Vector3(Math.random(), Math.random(), Math.random()).normalize(),
            speed: 0.004 + Math.random() * 0.01,
            floatPhase: Math.random() * Math.PI * 2,
            floatAmp: 0.15 + Math.random() * 0.3,
            floatFreq: 0.4 + Math.random() * 0.6,
            origY: mesh.position.y,
        };
        scene.add(mesh);
        parcels.push(mesh);
    }

    /* ── ORBIT RINGS around globe ── */
    const ringColors = [0x38bdf8, 0x34d399, 0xfbbf24];
    const rings = [];
    for (let i = 0; i < 3; i++) {
        const rGeo = new THREE.TorusGeometry(globeRadius + 1.2 + i * 0.9, 0.018, 8, 100);
        const rMat = new THREE.MeshBasicMaterial({ color: ringColors[i], transparent: true, opacity: 0.3 });
        const ring = new THREE.Mesh(rGeo, rMat);
        ring.position.copy(globe.position);
        ring.rotation.x = Math.PI / 4 + (i * Math.PI) / 5;
        ring.rotation.y = (i * Math.PI) / 4;
        ring.userData = { speed: 0.004 + i * 0.003 };
        scene.add(ring);
        rings.push(ring);
    }

    /* ── LIGHTS ── */
    scene.add(new THREE.AmbientLight(0xffffff, 0.5));
    const sunLight = new THREE.DirectionalLight(0x93c5fd, 2.5);
    sunLight.position.set(-10, 10, 10);
    scene.add(sunLight);
    const rimLight = new THREE.PointLight(0xfbbf24, 1.8, 40);
    rimLight.position.set(15, -5, 8);
    scene.add(rimLight);
    const blueLight = new THREE.PointLight(0x38bdf8, 1.2, 35);
    blueLight.position.set(-6, 8, 5);
    scene.add(blueLight);

    /* ── MOUSE PARALLAX ── */
    let mx = 0, my = 0;
    window.addEventListener('mousemove', e => {
        mx = (e.clientX / window.innerWidth - 0.5) * 2;
        my = -(e.clientY / window.innerHeight - 0.5) * 2;
    });

    /* ── RESIZE ── */
    window.addEventListener('resize', () => {
        renderer.setSize(W(), H());
        camera.aspect = W() / H();
        camera.updateProjectionMatrix();
    });

    /* ── NODE PULSE ── */
    let smx = 0, smy = 0;
    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);
        const t = clock.getElapsedTime();

        smx += (mx - smx) * 0.03;
        smy += (my - smy) * 0.03;

        // Camera gentle drift
        camera.position.x = smx * 2.5;
        camera.position.y = smy * 1.5;
        camera.lookAt(globe.position);

        // Globe & wire rotation
        globe.rotation.y = t * 0.06;
        wireGlobe.rotation.y = -t * 0.04;
        wireGlobe.rotation.x = t * 0.02;

        // Ring orbits
        rings.forEach((r, i) => {
            r.rotation.z += r.userData.speed * (i % 2 === 0 ? 1 : -1);
        });

        // Node pulse (scale)
        nodes.forEach((n, i) => {
            const s = 1 + 0.35 * Math.sin(t * 1.8 + i * 0.6);
            n.scale.setScalar(s);
        });

        // Parcel float & rotate
        parcels.forEach(p => {
            const d = p.userData;
            p.position.y = d.origY + Math.sin(t * d.floatFreq + d.floatPhase) * d.floatAmp;
            p.rotateOnAxis(d.axis, d.speed);
        });

        renderer.render(scene, camera);
    }
    animate();
})();
</script>

@endsection
