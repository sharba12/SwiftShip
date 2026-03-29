@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4 py-md-5">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
                <h3 class="fw-bold mb-2">Confirm Password</h3>
                <p class="text-muted mb-4">This is a secure area. Please confirm your password before continuing.</p>

                <form method="POST" action="{{ route('password.confirm') }}" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control form-control-lg @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
