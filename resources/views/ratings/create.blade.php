<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Your Delivery - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .star {
            cursor: pointer;
            transition: all 0.2s;
        }
        .star:hover {
            transform: scale(1.2);
        }
        .star.active {
            color: #fbbf24;
        }
        .star.inactive {
            color: #d1d5db;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Rate Your Delivery Experience</h1>
                <p class="text-gray-600">Help us improve our service</p>
            </div>

            <!-- Parcel Info Card -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm text-gray-600">Tracking ID</p>
                        <p class="text-lg font-bold text-blue-600">{{ $parcel->tracking_id }}</p>
                    </div>
                    <div class="text-right">
                        <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                            ✓ Delivered
                        </span>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Delivered To</p>
                        <p class="font-semibold">{{ $parcel->receiver_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Delivered By</p>
                        <p class="font-semibold">{{ $parcel->agent->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Rating Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form action="{{ route('rating.store', $parcel->tracking_id) }}" method="POST">
                    @csrf
                    
                    <!-- Star Rating -->
                    <div class="mb-8">
                        <label class="block text-lg font-semibold text-gray-800 mb-4 text-center">
                            How would you rate your delivery experience?
                        </label>
                        
                        <div class="flex justify-center gap-2 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="star inactive w-16 h-16" data-rating="{{ $i }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        
                        <input type="hidden" name="rating" id="rating-input" required>
                        
                        <p id="rating-text" class="text-center text-gray-600 mt-2"></p>
                        
                        @error('rating')
                        <p class="text-red-600 text-sm text-center mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Feedback -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">
                            Share your feedback (Optional)
                        </label>
                        <textarea 
                            name="feedback" 
                            rows="4" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Tell us about your experience...">{{ old('feedback') }}</textarea>
                        @error('feedback')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Your Name <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="customer_name" 
                                value="{{ old('customer_name', $parcel->customer->name ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                            @error('customer_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">
                                Email (Optional)
                            </label>
                            <input 
                                type="email" 
                                name="customer_email" 
                                value="{{ old('customer_email', $parcel->customer->email ?? '') }}"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('customer_email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition duration-200 transform hover:scale-105">
                        Submit Rating
                    </button>
                </form>
            </div>

            <!-- Back to Tracking -->
            <div class="text-center mt-6">
                <a href="{{ route('track.page') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Tracking
                </a>
            </div>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating-input');
        const ratingText = document.getElementById('rating-text');
        
        const ratingLabels = {
            1: 'Poor - Not satisfied',
            2: 'Fair - Below expectations',
            3: 'Good - Met expectations',
            4: 'Very Good - Above expectations',
            5: 'Excellent - Outstanding service!'
        };

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                ratingInput.value = rating;
                ratingText.textContent = ratingLabels[rating];
                
                // Update star colors
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.remove('inactive');
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                        s.classList.add('inactive');
                    }
                });
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = this.dataset.rating;
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.add('active');
                    }
                });
            });
        });

        // Reset on mouse leave
        document.querySelector('.flex.justify-center.gap-2').addEventListener('mouseleave', function() {
            const currentRating = ratingInput.value;
            if (currentRating) {
                stars.forEach((s, index) => {
                    if (index < currentRating) {
                        s.classList.add('active');
                        s.classList.remove('inactive');
                    } else {
                        s.classList.remove('active');
                        s.classList.add('inactive');
                    }
                });
            } else {
                stars.forEach(s => {
                    s.classList.remove('active');
                    s.classList.add('inactive');
                });
            }
        });
    </script>
</body>
</html>