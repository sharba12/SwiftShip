@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 flex items-center justify-center p-4">

    <div class="bg-white/90 backdrop-blur-lg shadow-2xl rounded-2xl overflow-hidden w-full max-w-5xl grid grid-cols-1 md:grid-cols-2">

        <!-- Image Section -->
        <div class="hidden md:block relative">
            <img src="{{ asset('images/images.jpg') }}" class="h-full w-full object-cover">

            <div class="absolute inset-0 bg-black/40 flex flex-col justify-center px-10">
                <h1 class="text-white text-3xl font-bold mb-3">Join DTDC Today 🚚</h1>
                <p class="text-white/90 text-sm">
                    Create your account and start managing deliveries smarter.
                </p>
            </div>
        </div>

        <!-- Register Form -->
        <div class="p-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
            <p class="text-gray-500 mb-6">It only takes a minute</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Password</label>
                    <input type="password" name="password" required
                        class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full mt-1 px-4 py-3 rounded-xl border focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <button type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold 
                           hover:scale-[1.02] hover:shadow-lg transition">
                    Create Account
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                    Login here
                </a>
            </p>
        </div>
    </div>

</div>
@endsection