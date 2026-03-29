@extends('layouts.main')

@section('title', 'Create Account | SwiftShip')

@section('content')

<section class="auth-hero d-flex align-items-center justify-content-center">
    <canvas id="auth-canvas"></canvas>
    <div class="auth-hero-overlay"></div>

    <div class="container auth-hero-content">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">

                {{-- BRAND --}}
                <div class="text-center mb-5 fade-up">
                    <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-4">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M4 16L14 6L28 16L14 26L4 16Z" fill="var(--color-primary)" opacity="0.9"/>
                            <path d="M10 16L18 10L26 16L18 22L10 16Z" fill="var(--color-warning)"/>
                        </svg>
                        <span class="brand-text">Swift<span class="brand-accent">Ship</span></span>
                    </a>
                    <h1 class="fw-bold text-white" style="font-size:1.9rem;letter-spacing:-0.02em;">Create your account</h1>
                    <p class="text-muted-light mt-2">Join SwiftShip and start shipping smarter</p>
                </div>

                {{-- CARD --}}
                <div class="auth-card fade-up" style="animation-delay:0.1s">

                    @if($errors->any())
                    <div class="auth-alert-error mb-4">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        <div>
                            @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label class="auth-label" for="name">Full name</label>
                            <div class="auth-input-wrap">
                                <svg class="auth-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                </svg>
                                <input id="name" type="text" name="name"
                                       value="{{ old('name') }}"
                                       class="auth-input @error('name') is-error @enderror"
                                       placeholder="John Doe"
                                       required autofocus autocomplete="name">
                            </div>
                            @error('name')
                            <p class="auth-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="auth-label" for="email">Email address</label>
                            <div class="auth-input-wrap">
                                <svg class="auth-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                                </svg>
                                <input id="email" type="email" name="email"
                                       value="{{ old('email') }}"
                                       class="auth-input @error('email') is-error @enderror"
                                       placeholder="you@example.com"
                                       required autocomplete="username">
                            </div>
                            @error('email')
                            <p class="auth-field-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label class="auth-label" for="password">Password</label>
                                <div class="auth-input-wrap">
                                    <svg class="auth-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                                    </svg>
                                    <input id="password" type="password" name="password"
                                           class="auth-input @error('password') is-error @enderror"
                                           placeholder="Min. 8 characters"
                                           required autocomplete="new-password">
                                    <button type="button" class="auth-eye-btn" onclick="togglePassword('password')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('password')
                                <p class="auth-field-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="auth-label" for="password_confirmation">Confirm password</label>
                                <div class="auth-input-wrap">
                                    <svg class="auth-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/>
                                    </svg>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                           class="auth-input"
                                           placeholder="Repeat password"
                                           required autocomplete="new-password">
                                    <button type="button" class="auth-eye-btn" onclick="togglePassword('password_confirmation')">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- STRENGTH INDICATOR --}}
                        <div class="mb-5">
                            <div class="password-strength-bar" id="strengthBar">
                                <div id="strengthFill" style="width:0%;height:100%;border-radius:4px;transition:all 0.3s;"></div>
                            </div>
                            <p id="strengthText" class="strength-text"></p>
                        </div>

                        <button type="submit" class="btn-auth-submit w-100">
                            Create account
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="ms-2">
                                <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                            </svg>
                        </button>
                    </form>

                    <div class="auth-divider my-4">
                        <span>already have an account?</span>
                    </div>

                    <a href="{{ route('login') }}" class="btn-auth-outline w-100 d-flex align-items-center justify-content-center">
                        Sign in instead
                    </a>

                </div>

                <p class="text-center mt-4 fade-up" style="color:rgba(255,255,255,0.2);font-size:0.75rem;animation-delay:0.25s;">
                    Protected by SwiftShip &mdash; &copy; {{ date('Y') }}
                </p>

            </div>
        </div>
    </div>
</section>

<style>
.auth-hero {
    position: relative;
    min-height: 100vh;
    background: var(--color-bg-section-2);
    overflow: hidden;
    padding: 3rem 0;
}
#auth-canvas {
    position: absolute; inset: 0;
    width: 100%; height: 100%; z-index: 1;
}
.auth-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, rgba(8,12,18,0.7), rgba(8,12,18,0.85));
    z-index: 2;
}
.auth-hero-content { position: relative; z-index: 3; }

.brand-text { font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:-0.02em; }
.brand-accent { color:var(--color-primary); }
.text-muted-light { color:rgba(255,255,255,0.45);font-size:0.9rem; }

.auth-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.09);
    border-radius: 20px;
    padding: 2.5rem;
    backdrop-filter: blur(12px);
}

.auth-label {
    display:block;font-size:0.78rem;font-weight:600;
    color:rgba(255,255,255,0.55);text-transform:uppercase;
    letter-spacing:0.08em;margin-bottom:0.45rem;
}

.auth-input-wrap { position:relative; }
.auth-input-icon {
    position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);
    color:rgba(255,255,255,0.3);pointer-events:none;
}
.auth-input {
    width:100%;background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:10px;padding:0.78rem 2.75rem;
    color:#fff;font-size:0.9rem;outline:none;
    transition:border-color 0.2s,box-shadow 0.2s;
}
.auth-input::placeholder { color:rgba(255,255,255,0.22); }
.auth-input:focus {
    border-color:var(--color-primary);
    box-shadow:0 0 0 3px rgba(14,165,233,0.15);
    background:rgba(255,255,255,0.08);
}
.auth-input.is-error { border-color:rgba(248,113,113,0.6); }
.auth-eye-btn {
    position:absolute;right:0.9rem;top:50%;transform:translateY(-50%);
    background:none;border:none;color:rgba(255,255,255,0.3);cursor:pointer;padding:0;
    transition:color 0.2s;
}
.auth-eye-btn:hover { color:rgba(255,255,255,0.6); }
.auth-field-error { color:var(--color-danger);font-size:0.78rem;margin:0.3rem 0 0; }

/* STRENGTH */
.password-strength-bar {
    height:4px;background:rgba(255,255,255,0.08);
    border-radius:4px;margin-bottom:0.4rem;overflow:hidden;
}
.strength-text { font-size:0.75rem;color:rgba(255,255,255,0.35);margin:0; }

/* SUBMIT */
.btn-auth-submit {
    background:var(--color-primary);color:#fff;border:none;
    border-radius:12px;padding:0.85rem;
    font-size:0.95rem;font-weight:700;
    cursor:pointer;transition:background 0.2s,transform 0.15s;
    display:flex;align-items:center;justify-content:center;
}
.btn-auth-submit:hover { background:var(--color-primary-strong);transform:translateY(-1px); }
.btn-auth-submit:active { transform:translateY(0); }

.btn-auth-outline {
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(255,255,255,0.12);
    border-radius:12px;padding:0.8rem;
    color:rgba(255,255,255,0.6);font-size:0.9rem;font-weight:600;
    text-decoration:none;transition:all 0.2s;
}
.btn-auth-outline:hover {
    background:rgba(255,255,255,0.08);
    border-color:rgba(255,255,255,0.2);
    color:#fff;
}

.auth-divider {
    display:flex;align-items:center;gap:1rem;
}
.auth-divider::before,.auth-divider::after {
    content:'';flex:1;height:1px;background:rgba(255,255,255,0.08);
}
.auth-divider span { color:rgba(255,255,255,0.25);font-size:0.78rem;white-space:nowrap; }

.auth-link-accent { color:var(--color-primary);text-decoration:none;font-weight:600; }
.auth-link-accent:hover { color:var(--color-primary-soft); }

.auth-alert-error {
    display:flex;align-items:flex-start;gap:0.6rem;
    background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.25);
    border-radius:10px;padding:0.75rem 1rem;
    color:var(--color-danger);font-size:0.85rem;
}
.auth-alert-error p { font-size:0.82rem; }

.fade-up { opacity:0;transform:translateY(20px);animation:fadeUp 0.75s ease forwards; }
@keyframes fadeUp { to { opacity:1;transform:translateY(0); } }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}

document.getElementById('password').addEventListener('input', function(){
    const v = this.value;
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    let score = 0;
    if(v.length >= 8) score++;
    if(/[A-Z]/.test(v)) score++;
    if(/[0-9]/.test(v)) score++;
    if(/[^A-Za-z0-9]/.test(v)) score++;
    const levels = [
        {w:'0%',c:'transparent',t:''},
        {w:'25%',c:'#f87171',t:'Weak'},
        {w:'50%',c:'#fbbf24',t:'Fair'},
        {w:'75%',c:'#34d399',t:'Good'},
        {w:'100%',c:'#0ea5e9',t:'Strong'}
    ];
    const l = levels[score];
    fill.style.width = l.w;
    fill.style.background = l.c;
    text.textContent = l.t;
    text.style.color = l.c;
});

(function(){
    const canvas = document.getElementById('auth-canvas');
    const section = canvas.parentElement;
    const W = ()=>section.offsetWidth, H = ()=>section.offsetHeight;
    const renderer = new THREE.WebGLRenderer({canvas,antialias:true,alpha:false});
    renderer.setPixelRatio(Math.min(devicePixelRatio,2));
    renderer.setSize(W(),H());
    renderer.setClearColor(0x080c12,1);
    const scene = new THREE.Scene();
    scene.fog = new THREE.FogExp2(0x080c12,0.02);
    const camera = new THREE.PerspectiveCamera(65,W()/H(),0.1,200);
    camera.position.z=20;
    const n=2500,pos=new Float32Array(n*3);
    for(let i=0;i<n*3;i++) pos[i]=(Math.random()-.5)*80;
    const geo=new THREE.BufferGeometry();
    geo.setAttribute('position',new THREE.BufferAttribute(pos,3));
    scene.add(new THREE.Points(geo,new THREE.PointsMaterial({color:0x38bdf8,size:0.12,transparent:true,opacity:0.4})));
    scene.add(new THREE.AmbientLight(0xffffff,0.5));
    let mx=0,my=0,smx=0,smy=0;
    window.addEventListener('mousemove',e=>{mx=(e.clientX/window.innerWidth-.5)*2;my=-(e.clientY/window.innerHeight-.5)*2;});
    window.addEventListener('resize',()=>{renderer.setSize(W(),H());camera.aspect=W()/H();camera.updateProjectionMatrix();});
    const clk=new THREE.Clock();
    (function animate(){
        requestAnimationFrame(animate);
        smx+=(mx-smx)*.03;smy+=(my-smy)*.03;
        camera.position.x=smx*1.5;camera.position.y=smy*1;
        camera.lookAt(0,0,0);
        renderer.render(scene,camera);
    })();
})();
</script>

@endsection