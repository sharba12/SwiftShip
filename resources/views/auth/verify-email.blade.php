@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4 py-md-5">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-2">Verify Email</h3>
                <p class="text-muted mb-4">Before getting started, verify your email address using the link we sent. If you did not receive it, request another.</p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success" role="alert">A new verification link has been sent to your email address.</div>
                @endif

                <div class="d-grid gap-3">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-lg w-100">Resend Verification Email</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100">Log Out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
