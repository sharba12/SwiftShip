@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-lg border-0 rounded-4">
            <div class="row g-0">

                <!-- Image -->
                <div class="col-md-6 d-none d-md-block">
                    <div class="position-relative h-100">
                        <img src="{{ asset('images/images.jpg') }}" class="img-fluid h-100 w-100 object-fit-cover rounded-start">

                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex flex-column justify-content-center p-4">
                            <h2 class="text-white fw-bold">Fast. Reliable. Secure.</h2>
                            <p class="text-white-50">Track and manage parcels effortlessly.</p>
                        </div>
                    </div>
                </div>

                <!-- Login Form -->
                <div class="col-md-6 p-4">
                    <h3 class="fw-bold mb-3">Welcome Back 👋</h3>
                    <p class="text-muted mb-4">Login to continue</p>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="form-control rounded-3">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" required class="form-control rounded-3">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input">
                                <label class="form-check-label">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 rounded-3">
                            Login
                        </button>
                    </form>

                    <p class="text-center mt-3">
                        New user?
                        <a href="{{ route('register') }}">Create an account</a>
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection