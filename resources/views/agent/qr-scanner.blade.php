@extends('agent.layout')

@section('content')
<div style="max-width:700px;">
    <div class="text-center mb-4 fade-in">
        <h1 class="page-title">QR Code Scanner</h1>
        <p class="page-sub">Scan parcel QR codes for quick updates</p>
    </div>

    <div id="scanner-alert" class="scanner-alert" style="display:none;"></div>

    <div class="scanner-card fade-in" style="animation-delay:0.08s">
        <div id="scanner-container" style="position:relative;">
            <div id="qr-reader" style="width:100%;min-height:280px;border-radius:10px;overflow:hidden;border:1px solid rgba(255,255,255,0.1);"></div>
            <div id="scanner-overlay" style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;display:none;">
                <div style="border:3px solid var(--color-primary);width:200px;height:200px;border-radius:12px;"></div>
            </div>
        </div>

        <div class="d-flex gap-3 mt-4 flex-wrap">
            <button id="start-scan" class="btn-agent btn-agent-green flex-fill">
                <i class="bi bi-camera"></i> Start Scanner
            </button>
            <button id="stop-scan" class="btn-agent btn-agent-red flex-fill" style="display:none;">
                <i class="bi bi-stop-circle"></i> Stop Scanner
            </button>
        </div>

        <div id="scan-status" class="mt-3 text-center" style="display:none;">
            <p style="color:var(--color-success);font-weight:600;">Ready to scan...</p>
            <p style="color:rgba(255,255,255,0.35);font-size:0.82rem;">Position the QR code within the frame</p>
        </div>

        <hr style="border-color:rgba(255,255,255,0.07);margin:1.5rem 0;">
        <p style="color:rgba(255,255,255,0.6);font-weight:600;font-size:0.85rem;margin-bottom:0.5rem;">Or enter tracking ID manually:</p>
        <div class="d-flex gap-2">
            <input type="text" id="manual-tracking-id" placeholder="Enter tracking ID" class="form-control form-control-dark flex-fill">
            <button id="manual-submit" class="btn-agent btn-agent-blue">Submit</button>
        </div>
    </div>

    <div id="result-card" class="scanner-card mt-3 fade-in" style="display:none;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 style="color:var(--color-white);font-weight:700;margin:0;">Parcel Found</h5>
            <span id="status-badge" class="status-pill"></span>
        </div>

        <div class="row g-3">
            <div class="col-6">
                <p class="field-label">Tracking ID</p>
                <p id="result-tracking-id" class="field-value" style="color:var(--color-primary);"></p>
            </div>
            <div class="col-6">
                <p class="field-label">Receiver</p>
                <p id="result-receiver" class="field-value"></p>
            </div>
            <div class="col-6">
                <p class="field-label">Contact</p>
                <p id="result-contact" class="field-value"></p>
            </div>
            <div class="col-6">
                <p class="field-label">Destination</p>
                <p id="result-address" class="field-value" style="font-size:0.82rem;"></p>
            </div>
        </div>

        <div class="mt-4">
            <a id="view-details-btn" href="#" class="btn-agent btn-agent-blue w-100 text-center d-block py-2 mb-2">
                View Full Details
            </a>
            <div class="row g-2">
                <div class="col-4">
                    <button onclick="quickUpdate('picked_up')" class="btn-agent btn-agent-yellow w-100 py-2" style="font-size:0.78rem;">
                        <i class="bi bi-box-seam"></i> Pick Up
                    </button>
                </div>
                <div class="col-4">
                    <button onclick="quickUpdate('in_transit')" class="btn-agent btn-agent-blue w-100 py-2" style="font-size:0.78rem;">
                        <i class="bi bi-truck"></i> In Transit
                    </button>
                </div>
                <div class="col-4">
                    <button onclick="quickUpdate('delivered')" class="btn-agent btn-agent-green w-100 py-2" style="font-size:0.78rem;">
                        <i class="bi bi-check2-circle"></i> Delivered
                    </button>
                </div>
            </div>
        </div>

        <button onclick="scanAgain()" class="btn-agent btn-agent-gray w-100 mt-3">Scan Another</button>
    </div>

    <div class="scanner-card mt-3 fade-in" style="animation-delay:0.12s">
        <h5 style="color:var(--color-white);font-weight:700;margin:0 0 1rem;">Recent Scans</h5>
        <div id="recent-scans">
            <p style="color:rgba(255,255,255,0.35);font-size:0.85rem;">No recent scans</p>
        </div>
    </div>
</div>

<style>
.page-title { font-size:1.5rem;font-weight:800;color:var(--color-white);margin:0; }
.page-sub { font-size:0.82rem;color:rgba(255,255,255,0.3);margin:4px 0 0; }

.scanner-card {
    background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);
    border-radius:14px;padding:1.5rem;
}

.field-label { font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.08em;margin:0 0 2px; }
.field-value { font-size:0.88rem;font-weight:600;color:rgba(255,255,255,0.85);margin:0; }

.form-control-dark {
    background:rgba(255,255,255,0.05) !important;border:1px solid rgba(255,255,255,0.1) !important;
    color:var(--color-white) !important;border-radius:8px;padding:0.6rem 0.85rem;font-size:0.9rem;
}
.form-control-dark::placeholder { color:rgba(255,255,255,0.25) !important; }
.form-control-dark:focus { border-color:var(--color-primary) !important;box-shadow:0 0 0 3px rgba(14,165,233,0.12) !important; }

.btn-agent { border:none;border-radius:8px;padding:0.55rem 1rem;font-size:0.85rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:0.4rem;transition:all 0.2s;text-decoration:none; }
.btn-agent-blue { background:var(--color-primary);color:var(--color-white); }
.btn-agent-blue:hover { background:var(--color-primary-strong);color:var(--color-white); }
.btn-agent-green { background:var(--color-success-strong);color:var(--color-white); }
.btn-agent-green:hover { background:var(--color-success-deep);color:var(--color-white); }
.btn-agent-red { background:rgba(239,68,68,0.15);color:var(--color-danger);border:1px solid rgba(239,68,68,0.25); }
.btn-agent-red:hover { background:rgba(239,68,68,0.25); }
.btn-agent-yellow { background:rgba(251,191,36,0.15);color:var(--color-warning);border:1px solid rgba(251,191,36,0.25); }
.btn-agent-yellow:hover { background:rgba(251,191,36,0.25); }
.btn-agent-gray { background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.6);border:1px solid rgba(255,255,255,0.1); }
.btn-agent-gray:hover { background:rgba(255,255,255,0.1);color:var(--color-white); }

.status-pill { padding:0.25rem 0.7rem;border-radius:100px;font-size:0.7rem;font-weight:700;text-transform:uppercase; }

.recent-scan-item {
    display:flex;justify-content:space-between;align-items:center;
    padding:0.6rem 0.8rem;background:rgba(255,255,255,0.03);
    border-radius:8px;margin-bottom:0.4rem;
}

.scanner-alert {
    border: 1px solid rgba(248,113,113,0.45);
    background: rgba(127,29,29,0.4);
    color: var(--color-alert-error-text);
    border-radius: 10px;
    padding: 0.75rem 0.9rem;
    margin-bottom: 0.9rem;
    font-size: 0.85rem;
    font-weight: 600;
}
.scanner-alert.success {
    border-color: rgba(74,222,128,0.45);
    background: rgba(21,128,61,0.3);
    color: var(--color-alert-success-text);
}

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    let html5QrCode = null;
    let scannerActive = false;
    let currentParcel = null;
    const recentScans = [];

    const startBtn = document.getElementById('start-scan');
    const stopBtn = document.getElementById('stop-scan');
    const scanStatus = document.getElementById('scan-status');
    const resultCard = document.getElementById('result-card');
    const manualInput = document.getElementById('manual-tracking-id');
    const manualSubmit = document.getElementById('manual-submit');
    const scannerAlert = document.getElementById('scanner-alert');
    const overlay = document.getElementById('scanner-overlay');
    const readerEl = document.getElementById('qr-reader');

    if (!startBtn || !stopBtn || !scanStatus || !resultCard || !manualInput || !manualSubmit || !scannerAlert || !overlay || !readerEl) {
        return;
    }

    function showAlert(message, success = false) {
        scannerAlert.innerHTML = `<i class="bi ${success ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'} me-2"></i>${message}`;
        scannerAlert.classList.toggle('success', success);
        scannerAlert.style.display = 'block';
        if (!success) scannerAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function hideAlert() {
        scannerAlert.style.display = 'none';
        scannerAlert.classList.remove('success');
        scannerAlert.innerHTML = '';
    }

    async function startScanner() {
        hideAlert();
        if (scannerActive) return;
        if (typeof Html5Qrcode === 'undefined') {
            showAlert('QR scanner library failed to load. Please refresh the page.');
            return;
        }

        startBtn.disabled = true;
        startBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Starting...';

        try {
            html5QrCode = new Html5Qrcode('qr-reader');
            await html5QrCode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                onScanSuccess,
                () => {}
            );
            scannerActive = true;
            startBtn.style.display = 'none';
            stopBtn.style.display = 'inline-flex';
            scanStatus.style.display = 'block';
            overlay.style.display = 'flex';
        } catch (err) {
            showAlert('Unable to start camera. Check camera permission and try again.');
        } finally {
            startBtn.disabled = false;
            startBtn.innerHTML = '<i class="bi bi-camera"></i> Start Scanner';
        }
    }

    async function stopScanner() {
        if (!html5QrCode || !scannerActive) return;
        try {
            await html5QrCode.stop();
            await html5QrCode.clear();
        } catch (_) {
            // No-op for cleanup failures.
        } finally {
            html5QrCode = null;
            scannerActive = false;
            startBtn.style.display = 'inline-flex';
            stopBtn.style.display = 'none';
            scanStatus.style.display = 'none';
            overlay.style.display = 'none';
        }
    }

    async function onScanSuccess(decodedText) {
        await stopScanner();
        processTrackingId(decodedText);
    }

    function processTrackingId(trackingId) {
        hideAlert();
        fetch('{{ route("agent.qr.scan") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ tracking_id: trackingId })
        })
        .then((r) => r.json())
        .then((data) => {
            if (!data.success) {
                showAlert(data.message || 'Parcel not found');
                return;
            }
            displayParcel(data.parcel);
            addToRecentScans(data.parcel);
            showAlert('Parcel loaded successfully.', true);
        })
        .catch(() => showAlert('Error processing scan. Please try again.'));
    }

    function displayParcel(parcel) {
        currentParcel = parcel;
        document.getElementById('result-tracking-id').textContent = parcel.tracking_id;
        document.getElementById('result-receiver').textContent = parcel.receiver_name;
        document.getElementById('result-contact').textContent = parcel.receiver_contact;
        document.getElementById('result-address').textContent = parcel.address_to;

        const badge = document.getElementById('status-badge');
        badge.textContent = parcel.status.replaceAll('_', ' ').toUpperCase();
        if (parcel.status === 'delivered') badge.style.cssText = 'background:rgba(52,211,153,0.12);color:var(--color-success);';
        else if (parcel.status === 'pending') badge.style.cssText = 'background:rgba(251,191,36,0.12);color:var(--color-warning);';
        else badge.style.cssText = 'background:rgba(14,165,233,0.12);color:var(--color-primary);';

        document.getElementById('view-details-btn').href = `/agent/deliveries/${parcel.id}`;
        resultCard.style.display = 'block';
    }

    window.quickUpdate = function(action) {
        if (!currentParcel) return;
        if (!confirm('Update status to: ' + action.replace('_', ' ') + '?')) return;

        hideAlert();
        fetch('{{ route("agent.qr.quick-update") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ tracking_id: currentParcel.tracking_id, action })
        })
        .then((r) => r.json())
        .then((data) => {
            if (!data.success) {
                showAlert(data.message || 'Update failed');
                return;
            }
            showAlert('Status updated successfully.', true);
            window.scanAgain();
        })
        .catch(() => showAlert('Error updating status.'));
    };

    window.scanAgain = function() {
        resultCard.style.display = 'none';
        currentParcel = null;
        hideAlert();
    };

    manualSubmit.addEventListener('click', () => {
        const v = manualInput.value.trim();
        if (!v) return;
        processTrackingId(v);
        manualInput.value = '';
    });

    manualInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            manualSubmit.click();
        }
    });

    function addToRecentScans(parcel) {
        recentScans.unshift({
            tracking_id: parcel.tracking_id,
            receiver: parcel.receiver_name,
            time: new Date().toLocaleTimeString()
        });
        if (recentScans.length > 5) recentScans.pop();
        updateRecentScans();
    }

    function updateRecentScans() {
        const c = document.getElementById('recent-scans');
        if (!recentScans.length) {
            c.innerHTML = '<p style="color:rgba(255,255,255,0.35);font-size:0.85rem;">No recent scans</p>';
            return;
        }
        c.innerHTML = recentScans.map((s) => `
            <div class="recent-scan-item">
                <div>
                    <p style="color:var(--color-primary);font-weight:600;font-size:0.85rem;margin:0;">${s.tracking_id}</p>
                    <p style="color:rgba(255,255,255,0.4);font-size:0.75rem;margin:0;">${s.receiver}</p>
                </div>
                <span style="color:rgba(255,255,255,0.3);font-size:0.75rem;">${s.time}</span>
            </div>
        `).join('');
    }

    startBtn.addEventListener('click', startScanner);
    stopBtn.addEventListener('click', stopScanner);
    window.addEventListener('beforeunload', stopScanner);
});
</script>
@endpush
@endsection
