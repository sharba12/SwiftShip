<footer class="swiftship-footer">

    <div class="footer-top">
        <div class="container">
            <div class="row g-5">

                <!-- Brand Column -->
                <div class="col-lg-4">
                    <a class="d-flex align-items-center gap-2 mb-3 text-decoration-none" href="{{ route('home') }}">
                        <svg width="26" height="26" viewBox="0 0 32 32" fill="none">
                            <path d="M4 16L14 6L28 16L14 26L4 16Z" fill="var(--color-primary)" opacity="0.9"/>
                            <path d="M10 16L18 10L26 16L18 22L10 16Z" fill="var(--color-warning)"/>
                        </svg>
                        <span style="font-size:1.2rem;font-weight:800;color:var(--color-white);letter-spacing:-0.02em;">
                            Swift<span style="color:var(--color-primary);">Ship</span>
                        </span>
                    </a>
                    <p class="footer-desc">
                        Precision logistics for a connected world. Real-time tracking, smart routing,
                        and end-to-end delivery transparency.
                    </p>
                    <div class="footer-socials mt-4">
                        <a href="#" class="social-icon" title="Twitter">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-icon" title="LinkedIn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
                                <circle cx="4" cy="4" r="2"/>
                            </svg>
                        </a>
                        <a href="#" class="social-icon" title="Facebook">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-6 col-lg-2">
                    <h6 class="footer-heading">Company</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('services') }}">Services</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-6 col-lg-2">
                    <h6 class="footer-heading">Services</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('track.page') }}">Track Shipment</a></li>
                        <li><a href="{{ route('services') }}">Express Delivery</a></li>
                        <li><a href="{{ route('services') }}">Bulk Logistics</a></li>
                        <li><a href="{{ route('services') }}">Secure Handling</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4">
                    <h6 class="footer-heading">Get In Touch</h6>
                    <ul class="footer-contact">
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                            123 Logistics Park, Mumbai, India
                        </li>
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.22 1.18 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.91a16 16 0 006.29 6.29l1.28-1.28a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                            </svg>
                            +91 98765 43210
                        </li>
                        <li>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            support@swiftship.in
                        </li>
                    </ul>

                    <!-- Track quick input -->
                    <div class="footer-track mt-4">
                        <form action="{{ route('track.result') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="tracking_number" placeholder="Quick track…"
                                   class="form-control form-control-sm footer-input">
                            <button type="submit" class="btn btn-track-sm">Go</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="mb-0">© {{ date('Y') }} SwiftShip. All rights reserved.</p>
            <p class="mb-0 footer-legal">
                <a href="#">Privacy Policy</a> · <a href="#">Terms of Service</a>
            </p>
        </div>
    </div>

</footer>

<style>
.swiftship-footer {
    background: var(--color-bg-deep);
    border-top: 1px solid rgba(255,255,255,0.06);
    font-family: 'Segoe UI', system-ui, sans-serif;
}

.footer-top {
    padding: 4rem 0 3rem;
}

.footer-desc {
    color: rgba(255,255,255,0.45);
    font-size: 0.875rem;
    line-height: 1.7;
    max-width: 300px;
}

.footer-heading {
    color: rgba(255,255,255,0.9);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    margin-bottom: 1.1rem;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}
.footer-links a {
    color: rgba(255,255,255,0.45);
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.2s;
}
.footer-links a:hover { color: var(--color-primary); }

.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
.footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: 0.6rem;
    color: rgba(255,255,255,0.45);
    font-size: 0.875rem;
    line-height: 1.5;
}
.footer-contact svg { color: var(--color-primary); flex-shrink: 0; margin-top: 2px; }

.footer-input {
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    color: var(--color-white);
    border-radius: 6px;
    font-size: 0.82rem;
}
.footer-input::placeholder { color: rgba(255,255,255,0.3); }
.footer-input:focus {
    background: rgba(255,255,255,0.1);
    border-color: var(--color-primary);
    box-shadow: none;
    color: var(--color-white);
}

.btn-track-sm {
    background: var(--color-primary);
    color: var(--color-white);
    border: none;
    border-radius: 6px;
    padding: 0 1rem;
    font-size: 0.82rem;
    font-weight: 600;
    white-space: nowrap;
    transition: background 0.2s;
}
.btn-track-sm:hover { background: var(--color-primary-strong); color: var(--color-white); }

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px;
    color: rgba(255,255,255,0.55);
    text-decoration: none;
    margin-right: 0.4rem;
    transition: all 0.2s;
}
.social-icon:hover {
    background: rgba(14,165,233,0.15);
    border-color: var(--color-primary);
    color: var(--color-primary);
}

.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.06);
    padding: 1.2rem 0;
}
.footer-bottom p {
    color: rgba(255,255,255,0.3);
    font-size: 0.8rem;
}
.footer-legal a {
    color: rgba(255,255,255,0.3);
    text-decoration: none;
    font-size: 0.8rem;
    transition: color 0.2s;
}
.footer-legal a:hover { color: var(--color-primary); }
</style>
