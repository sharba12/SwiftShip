@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4 py-md-5">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-2">Forgot Password</h3>
                <p class="text-muted mb-4">Enter your email address and we will send you a password reset link.</p>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control form-control-lg @error('email') is-invalid @enderror">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Email Password Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
