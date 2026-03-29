@extends('agent.layout')

@section('content')

<div style="max-width:700px;">

    {{-- BACK --}}
    <div class="mb-3 fade-in">
        <a href="{{ route('agent.delivery.show', $parcel->id) }}" class="back-link">
            <i class="bi bi-arrow-left"></i> Back to Delivery Details
        </a>
    </div>

    <div class="fade-in" style="animation-delay:0.05s">
        <h1 class="page-title">Proof of Delivery</h1>
        <p class="page-sub">Capture signature and photo to confirm delivery</p>
    </div>

    {{-- PARCEL INFO --}}
    <div class="pod-card mt-4 fade-in" style="animation-delay:0.1s;border-color:rgba(14,165,233,0.2);">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="field-label">Tracking ID</p>
                <p style="color:var(--color-primary);font-weight:700;font-size:1rem;margin:0;">{{ $parcel->tracking_id }}</p>
            </div>
            <div class="text-end">
                <p class="field-label">Receiver</p>
                <p class="field-value">{{ $parcel->receiver_name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('agent.proof.store', $parcel->id) }}" method="POST" enctype="multipart/form-data" id="proof-form">
        @csrf
        <div id="pod-alert" class="pod-alert" style="display:none;"></div>

        {{-- SIGNATURE --}}
        <div class="pod-card mt-3 fade-in" style="animation-delay:0.15s">
            <h5 class="card-heading mb-3">1. Customer Signature</h5>
            <p style="color:rgba(255,255,255,0.45);font-size:0.85rem;margin-bottom:1rem;">Ask the customer to sign below:</p>

            <div id="signature-container" style="border:2px solid rgba(255,255,255,0.15);border-radius:10px;overflow:hidden;background:var(--color-white);position:relative;">
                <canvas id="signature-pad" width="650" height="200" style="display:block;width:100%;cursor:crosshair;touch-action:none;" aria-label="Signature pad"></canvas>
            </div>

            <div class="d-flex gap-3 mt-3 align-items-center">
                <button type="button" id="clear-signature" class="btn-agent btn-agent-gray">
                    <i class="bi bi-eraser"></i> Clear
                </button>
                <span id="signature-status" style="color:rgba(255,255,255,0.3);font-size:0.78rem;">
                    <i class="bi bi-info-circle"></i> Draw with finger or mouse
                </span>
            </div>

            <input type="hidden" name="signature" id="signature-input" required>
            @error('signature')
            <p style="color:var(--color-danger);font-size:0.82rem;margin-top:0.5rem;">{{ $message }}</p>
            @enderror
        </div>

        {{-- PHOTO --}}
        <div class="pod-card mt-3 fade-in" style="animation-delay:0.2s">
            <h5 class="card-heading mb-3">2. Delivery Photo</h5>
            <p style="color:rgba(255,255,255,0.45);font-size:0.85rem;margin-bottom:1rem;">Take a photo of the delivered parcel:</p>

            <div class="text-center mb-3">
                <video id="camera-preview" style="width:100%;max-width:400px;display:none;border-radius:10px;border:2px solid rgba(14,165,233,0.3);" autoplay playsinline muted></video>
                <canvas id="photo-canvas" style="display:none;"></canvas>
            </div>

            <div class="d-flex flex-wrap gap-2 mb-3">
                <button type="button" id="start-camera" class="btn-agent btn-agent-blue">
                    <i class="bi bi-camera-video"></i> Open Camera
                </button>
                <button type="button" id="take-photo" class="btn-agent btn-agent-green" style="display:none;">
                    <i class="bi bi-camera"></i> Capture Photo
                </button>
                <button type="button" id="retake-photo" class="btn-agent btn-agent-gray" style="display:none;">
                    <i class="bi bi-arrow-repeat"></i> Retake
                </button>
                <label class="btn-agent btn-agent-purple" style="cursor:pointer;margin:0;">
                    <i class="bi bi-folder2-open"></i> Upload Photo
                    <input type="file" name="photo" id="photo-upload" accept="image/*" capture="environment" style="display:none;">
                </label>
            </div>

            <div id="photo-preview" style="display:none;text-align:center;">
                <p style="color:var(--color-success);font-weight:600;font-size:0.85rem;margin-bottom:0.5rem;">
                    <i class="bi bi-check-circle-fill"></i> Photo captured successfully
                </p>
                <img id="photo-preview-img" alt="Delivery preview" style="max-width:400px;width:100%;border-radius:10px;border:2px solid rgba(52,211,153,0.4);">
            </div>

            <input type="hidden" id="photo-data" name="photo_data">

            @error('photo')
            <p style="color:var(--color-danger);font-size:0.82rem;margin-top:0.5rem;">{{ $message }}</p>
            @enderror
        </div>

        {{-- RECIPIENT --}}
        <div class="pod-card mt-3 fade-in" style="animation-delay:0.25s">
            <h5 class="card-heading mb-3">3. Confirm Recipient</h5>
            <p style="color:rgba(255,255,255,0.45);font-size:0.85rem;margin-bottom:1rem;">Enter the name of the person who received the parcel:</p>

            <input type="text" name="recipient_name"
                   value="{{ old('recipient_name', $parcel->receiver_name) }}"
                   class="form-control form-control-dark"
                   placeholder="Recipient's full name" required>
            @error('recipient_name')
            <p style="color:var(--color-danger);font-size:0.82rem;margin-top:0.5rem;">{{ $message }}</p>
            @enderror
        </div>

        {{-- SUBMIT --}}
        <div class="mt-4 mb-5 fade-in" style="animation-delay:0.3s">
            <button type="submit" class="btn-agent btn-agent-green w-100 py-3" style="font-size:1rem;" id="submit-btn">
                <i class="bi bi-check-circle"></i> Confirm Delivery with Proof
            </button>
            <p style="color:rgba(255,255,255,0.3);font-size:0.78rem;text-align:center;margin-top:0.5rem;">
                This will mark the parcel as delivered
            </p>
        </div>
    </form>
</div>

<style>
.back-link { color:var(--color-primary);text-decoration:none;font-size:0.85rem;font-weight:600;transition:color 0.2s; }
.back-link:hover { color:var(--color-primary-soft); }

.page-title { font-size:1.5rem;font-weight:800;color:var(--color-white);margin:0; }
.page-sub { font-size:0.82rem;color:rgba(255,255,255,0.3);margin:4px 0 0; }

.pod-card { background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.07);border-radius:14px;padding:1.5rem; }
.card-heading { font-size:1rem;font-weight:700;color:var(--color-white);margin:0; }
.field-label { font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.35);text-transform:uppercase;letter-spacing:0.08em;margin:0 0 2px; }
.field-value { font-size:0.9rem;font-weight:600;color:rgba(255,255,255,0.85);margin:0; }

.form-control-dark {
    background:rgba(255,255,255,0.05) !important;border:1px solid rgba(255,255,255,0.1) !important;
    color:var(--color-white) !important;border-radius:8px;padding:0.7rem 1rem;font-size:0.9rem;
}
.form-control-dark::placeholder { color:rgba(255,255,255,0.25) !important; }
.form-control-dark:focus { border-color:var(--color-primary) !important;box-shadow:0 0 0 3px rgba(14,165,233,0.12) !important; }

.btn-agent { border:none;border-radius:8px;padding:0.55rem 1rem;font-size:0.85rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:0.4rem;transition:all 0.2s;text-decoration:none; }
.btn-agent-blue { background:var(--color-primary);color:var(--color-white); }
.btn-agent-blue:hover { background:var(--color-primary-strong);color:var(--color-white); }
.btn-agent-green { background:var(--color-success-strong);color:var(--color-white); }
.btn-agent-green:hover { background:var(--color-success-deep);color:var(--color-white); }
.btn-agent-purple { background:var(--color-violet-deep);color:var(--color-white); }
.btn-agent-purple:hover { background:var(--color-violet-ink);color:var(--color-white); }
.btn-agent-gray { background:rgba(255,255,255,0.06);color:rgba(255,255,255,0.6);border:1px solid rgba(255,255,255,0.1); }
.btn-agent-gray:hover { background:rgba(255,255,255,0.1);color:var(--color-white); }

.pod-alert {
    border: 1px solid rgba(125,211,252,0.35);
    background: rgba(14,116,144,0.25);
    color: var(--color-info-soft);
    border-radius: 10px;
    padding: 0.75rem 0.9rem;
    margin-top: 0.75rem;
    margin-bottom: 0.9rem;
    font-size: 0.85rem;
    font-weight: 600;
}
.pod-alert.error {
    border-color: rgba(248,113,113,0.45);
    background: rgba(127,29,29,0.4);
    color: var(--color-alert-error-text);
}
.pod-alert.success {
    border-color: rgba(74,222,128,0.45);
    background: rgba(21,128,61,0.3);
    color: var(--color-alert-success-text);
}

.fade-in { opacity:0;transform:translateY(16px);animation:fadeIn 0.6s ease forwards; }
@keyframes fadeIn { to { opacity:1;transform:translateY(0); } }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('signature-pad');
    const signatureStatus = document.getElementById('signature-status');
    const signatureInput = document.getElementById('signature-input');
    const clearSignatureBtn = document.getElementById('clear-signature');

    const video = document.getElementById('camera-preview');
    const photoCanvas = document.getElementById('photo-canvas');
    const startCameraBtn = document.getElementById('start-camera');
    const takePhotoBtn = document.getElementById('take-photo');
    const retakePhotoBtn = document.getElementById('retake-photo');
    const photoPreview = document.getElementById('photo-preview');
    const photoPreviewImg = document.getElementById('photo-preview-img');
    const photoUpload = document.getElementById('photo-upload');
    const photoDataInput = document.getElementById('photo-data');
    const form = document.getElementById('proof-form');
    const submitBtn = document.getElementById('submit-btn');
    const podAlert = document.getElementById('pod-alert');

    if (!canvas || !signatureStatus || !signatureInput || !clearSignatureBtn || !video ||
        !photoCanvas || !startCameraBtn || !takePhotoBtn || !retakePhotoBtn ||
        !photoPreview || !photoPreviewImg || !photoUpload || !photoDataInput ||
        !form || !submitBtn || !podAlert) {
        console.error('Proof of Delivery: required elements not found.');
        return;
    }

    const ctx = canvas.getContext('2d');
    if (!ctx) {
        console.error('Proof of Delivery: unable to get canvas context.');
        return;
    }

    let stream = null;
    let photoTaken = false;
    let hasSignature = false;
    let isDrawing = false;
    let isSubmitting = false;
    let lastX = 0;
    let lastY = 0;

    function clearCanvas() {
        ctx.fillStyle = getComputedStyle(document.documentElement).getPropertyValue('--color-white').trim() || 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    function getCanvasPoint(clientX, clientY) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        return {
            x: (clientX - rect.left) * scaleX,
            y: (clientY - rect.top) * scaleY
        };
    }

    function drawTo(x, y) {
        ctx.strokeStyle = getComputedStyle(document.documentElement).getPropertyValue('--color-black').trim() || 'black';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(x, y);
        ctx.stroke();
        lastX = x;
        lastY = y;
        hasSignature = true;
    }

    function stopCameraStream() {
        if (stream) {
            stream.getTracks().forEach((track) => track.stop());
            stream = null;
        }
    }

    function showAlert(message, type = 'error') {
        podAlert.classList.remove('error', 'success');
        podAlert.classList.add(type);
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        podAlert.innerHTML = '<i class="bi ' + icon + ' me-2"></i>' + message;
        podAlert.style.display = 'block';
        if (type === 'error') {
            podAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function hideError() {
        podAlert.style.display = 'none';
        podAlert.innerHTML = '';
        podAlert.classList.remove('error', 'success');
    }

    function resizeCanvasForDpr() {
        const rect = canvas.getBoundingClientRect();
        const dpr = window.devicePixelRatio || 1;
        const newWidth = Math.max(1, Math.floor(rect.width * dpr));
        const newHeight = Math.max(1, Math.floor(200 * dpr));

        if (canvas.width === newWidth && canvas.height === newHeight) return;

        const previous = canvas.toDataURL('image/png');
        canvas.width = newWidth;
        canvas.height = newHeight;
        clearCanvas();

        if (hasSignature) {
            const img = new Image();
            img.onload = () => {
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            };
            img.src = previous;
        }
    }

    clearCanvas();
    resizeCanvasForDpr();
    window.addEventListener('resize', resizeCanvasForDpr);

    canvas.addEventListener('pointerdown', (e) => {
        hideError();
        e.preventDefault();
        canvas.setPointerCapture(e.pointerId);
        const point = getCanvasPoint(e.clientX, e.clientY);
        isDrawing = true;
        lastX = point.x;
        lastY = point.y;
    });

    canvas.addEventListener('pointermove', (e) => {
        if (!isDrawing) return;
        e.preventDefault();
        const point = getCanvasPoint(e.clientX, e.clientY);
        drawTo(point.x, point.y);
    });

    const finishDrawing = () => {
        if (isDrawing && hasSignature) {
            signatureStatus.innerHTML = '<i class="bi bi-check-circle-fill" style="color:var(--color-success);"></i> Signature captured';
            signatureStatus.style.color = 'var(--color-success)';
        }
        isDrawing = false;
    };

    canvas.addEventListener('pointerup', finishDrawing);
    canvas.addEventListener('pointercancel', finishDrawing);
    canvas.addEventListener('pointerleave', finishDrawing);

    clearSignatureBtn.addEventListener('click', () => {
        clearCanvas();
        signatureInput.value = '';
        hasSignature = false;
        signatureStatus.innerHTML = '<i class="bi bi-info-circle"></i> Draw with finger or mouse';
        signatureStatus.style.color = 'rgba(255,255,255,0.3)';
    });

    startCameraBtn.addEventListener('click', async () => {
        if (isSubmitting) return;

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            showAlert('Camera is not supported in this browser. Use "Upload Photo" instead.');
            return;
        }

        try {
            hideError();
            startCameraBtn.disabled = true;
            startCameraBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Opening...';
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'environment' },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                }
            });
            video.srcObject = stream;
            await video.play();
            video.style.display = 'block';
            startCameraBtn.style.display = 'none';
            takePhotoBtn.style.display = 'inline-flex';
            startCameraBtn.disabled = false;
            startCameraBtn.innerHTML = '<i class="bi bi-camera-video"></i> Open Camera';
        } catch (err) {
            const message = err && err.message ? err.message : 'Permission denied or camera unavailable.';
            showAlert('Unable to access camera: ' + message + ' Use "Upload Photo" instead.');
            startCameraBtn.disabled = false;
            startCameraBtn.innerHTML = '<i class="bi bi-camera-video"></i> Open Camera';
        }
    });

    takePhotoBtn.addEventListener('click', () => {
        if (!video.videoWidth || !video.videoHeight) {
            showAlert('Camera is not ready. Please try again.');
            return;
        }

        hideError();
        photoCanvas.width = video.videoWidth;
        photoCanvas.height = video.videoHeight;
        photoCanvas.getContext('2d').drawImage(video, 0, 0);

        const dataUrl = photoCanvas.toDataURL('image/jpeg', 0.85);
        photoPreviewImg.src = dataUrl;
        photoPreview.style.display = 'block';
        photoDataInput.value = dataUrl;
        photoTaken = true;
        showAlert('Photo captured successfully.', 'success');

        stopCameraStream();
        video.style.display = 'none';
        takePhotoBtn.style.display = 'none';
        retakePhotoBtn.style.display = 'inline-flex';
    });

    retakePhotoBtn.addEventListener('click', () => {
        photoPreview.style.display = 'none';
        photoDataInput.value = '';
        photoTaken = false;
        hideError();
        startCameraBtn.style.display = 'inline-flex';
        takePhotoBtn.style.display = 'none';
        retakePhotoBtn.style.display = 'none';
        photoUpload.value = '';
    });

    photoUpload.addEventListener('change', (e) => {
        const file = e.target.files && e.target.files[0];
        if (!file) return;

        hideError();
        const reader = new FileReader();
        reader.onload = (ev) => {
            photoPreviewImg.src = ev.target.result;
            photoPreview.style.display = 'block';
            photoDataInput.value = ev.target.result;
            photoTaken = true;
            showAlert('Photo selected successfully.', 'success');

            stopCameraStream();
            video.style.display = 'none';
            takePhotoBtn.style.display = 'none';
            startCameraBtn.style.display = 'none';
            retakePhotoBtn.style.display = 'inline-flex';
        };
        reader.readAsDataURL(file);
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (isSubmitting) return;

        if (!hasSignature) {
            showAlert('Please provide a signature before submitting.');
            canvas.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        if (!photoTaken && !photoDataInput.value && !photoUpload.files.length) {
            showAlert('Please capture or upload a delivery photo.');
            return;
        }

        hideError();
        signatureInput.value = canvas.toDataURL('image/png');

        if (photoDataInput.value && !photoUpload.files.length) {
            fetch(photoDataInput.value)
                .then((r) => r.blob())
                .then((blob) => {
                    const file = new File([blob], 'delivery-photo.jpg', { type: 'image/jpeg' });
                    if (typeof DataTransfer !== 'undefined') {
                        const dt = new DataTransfer();
                        dt.items.add(file);
                        photoUpload.files = dt.files;
                    }
                    submitForm();
                })
                .catch(() => {
                    showAlert('Error processing photo. Please try again.');
                });
            return;
        }

        submitForm();
    });

    function submitForm() {
        isSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Submitting...';
        form.submit();
    }

    window.addEventListener('beforeunload', stopCameraStream);
});
</script>
@endpush
@endsection
