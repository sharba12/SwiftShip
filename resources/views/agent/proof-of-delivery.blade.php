@extends('layouts.agent')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('agent.delivery.show', $parcel->id) }}" class="text-blue-600 hover:text-blue-800">
            ← Back to Delivery Details
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Proof of Delivery</h1>
        <p class="text-gray-600">Capture signature and photo to confirm delivery</p>
    </div>

    <!-- Parcel Info -->
    <div class="bg-blue-50 rounded-lg p-4 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600">Tracking ID</p>
                <p class="text-lg font-bold text-blue-600">{{ $parcel->tracking_id }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-600">Receiver</p>
                <p class="font-semibold">{{ $parcel->receiver_name }}</p>
            </div>
        </div>
    </div>

    <form action="{{ route('agent.proof.store', $parcel->id) }}" method="POST" enctype="multipart/form-data" id="proof-form">
        @csrf

        <!-- Signature Pad -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold mb-4">1. Customer Signature</h3>
            <p class="text-gray-600 mb-4">Ask the customer to sign below:</p>
            
            <div class="border-2 border-gray-300 rounded-lg bg-white">
                <canvas id="signature-pad" class="w-full" height="200"></canvas>
            </div>
            
            <div class="flex gap-4 mt-4">
                <button type="button" id="clear-signature" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                    Clear Signature
                </button>
                <p class="text-sm text-gray-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Draw with your finger or mouse
                </p>
            </div>
            
            <input type="hidden" name="signature" id="signature-input" required>
            
            @error('signature')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Photo Upload -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold mb-4">2. Delivery Photo</h3>
            <p class="text-gray-600 mb-4">Take a photo of the delivered parcel:</p>
            
            <!-- Camera Preview -->
            <div class="mb-4">
                <video id="camera-preview" class="w-full max-w-md mx-auto rounded-lg border-2 border-gray-300 hidden" autoplay playsinline></video>
                <canvas id="photo-canvas" class="w-full max-w-md mx-auto rounded-lg border-2 border-gray-300 hidden"></canvas>
            </div>

            <div class="flex flex-wrap gap-4 mb-4">
                <button type="button" id="start-camera" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    📷 Open Camera
                </button>
                <button type="button" id="take-photo" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg hidden">
                    📸 Capture Photo
                </button>
                <button type="button" id="retake-photo" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg hidden">
                    🔄 Retake
                </button>
                <label class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg cursor-pointer">
                    📁 Upload from Gallery
                    <input type="file" name="photo" id="photo-upload" accept="image/*" class="hidden">
                </label>
            </div>

            <div id="photo-preview" class="hidden">
                <p class="text-green-600 font-semibold mb-2">✓ Photo captured</p>
                <img id="photo-preview-img" class="max-w-md mx-auto rounded-lg border-2 border-green-500">
            </div>

            @error('photo')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Recipient Confirmation -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-bold mb-4">3. Confirm Recipient</h3>
            <p class="text-gray-600 mb-4">Enter the name of the person who received the parcel:</p>
            
            <input 
                type="text" 
                name="recipient_name" 
                value="{{ old('recipient_name', $parcel->receiver_name) }}"
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Recipient's full name"
                required>
            
            @error('recipient_name')
            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <button 
                type="submit" 
                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg text-lg transition duration-200 transform hover:scale-105">
                ✓ Confirm Delivery with Proof
            </button>
            <p class="text-center text-gray-600 text-sm mt-3">
                This will mark the parcel as delivered
            </p>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
// Signature Pad
const canvas = document.getElementById('signature-pad');
const signaturePad = new SignaturePad(canvas, {
    backgroundColor: 'rgb(255, 255, 255)',
    penColor: 'rgb(0, 0, 0)'
});

// Resize canvas
function resizeCanvas() {
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    canvas.width = canvas.offsetWidth * ratio;
    canvas.height = canvas.offsetHeight * ratio;
    canvas.getContext("2d").scale(ratio, ratio);
    signaturePad.clear();
}

window.addEventListener("resize", resizeCanvas);
resizeCanvas();

// Clear signature
document.getElementById('clear-signature').addEventListener('click', function() {
    signaturePad.clear();
});

// Save signature on form submit
document.getElementById('proof-form').addEventListener('submit', function(e) {
    if (signaturePad.isEmpty()) {
        e.preventDefault();
        alert('Please provide a signature');
        return false;
    }
    document.getElementById('signature-input').value = signaturePad.toDataURL();
});

// Camera functionality
const video = document.getElementById('camera-preview');
const photoCanvas = document.getElementById('photo-canvas');
const startCameraBtn = document.getElementById('start-camera');
const takePhotoBtn = document.getElementById('take-photo');
const retakePhotoBtn = document.getElementById('retake-photo');
const photoPreview = document.getElementById('photo-preview');
const photoPreviewImg = document.getElementById('photo-preview-img');
const photoUpload = document.getElementById('photo-upload');

let stream = null;
let photoTaken = false;

// Start camera
startCameraBtn.addEventListener('click', async function() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: 'environment' } 
        });
        video.srcObject = stream;
        video.classList.remove('hidden');
        startCameraBtn.classList.add('hidden');
        takePhotoBtn.classList.remove('hidden');
    } catch (err) {
        alert('Unable to access camera: ' + err.message);
    }
});

// Take photo
takePhotoBtn.addEventListener('click', function() {
    photoCanvas.width = video.videoWidth;
    photoCanvas.height = video.videoHeight;
    photoCanvas.getContext('2d').drawImage(video, 0, 0);
    
    const dataUrl = photoCanvas.toDataURL('image/jpeg');
    photoPreviewImg.src = dataUrl;
    photoPreview.classList.remove('hidden');
    
    // Stop camera
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
    
    video.classList.add('hidden');
    takePhotoBtn.classList.add('hidden');
    retakePhotoBtn.classList.remove('hidden');
    
    // Convert to file for upload
    fetch(dataUrl)
        .then(res => res.blob())
        .then(blob => {
            const file = new File([blob], "delivery-photo.jpg", { type: "image/jpeg" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            photoUpload.files = dataTransfer.files;
            photoTaken = true;
        });
});

// Retake photo
retakePhotoBtn.addEventListener('click', function() {
    photoPreview.classList.add('hidden');
    startCameraBtn.classList.remove('hidden');
    retakePhotoBtn.classList.add('hidden');
    photoTaken = false;
});

// File upload preview
photoUpload.addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            photoPreviewImg.src = e.target.result;
            photoPreview.classList.remove('hidden');
            
            // Hide camera controls
            video.classList.add('hidden');
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            takePhotoBtn.classList.add('hidden');
            startCameraBtn.classList.add('hidden');
            retakePhotoBtn.classList.remove('hidden');
            photoTaken = true;
        };
        reader.readAsDataURL(e.target.files[0]);
    }
});

// Form validation
document.getElementById('proof-form').addEventListener('submit', function(e) {
    if (!photoTaken && !photoUpload.files.length) {
        e.preventDefault();
        alert('Please capture or upload a delivery photo');
        return false;
    }
});
</script>
@endpush
@endsection