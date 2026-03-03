@extends('admin.layout')

@section('content')
<div class="card shadow-sm col-md-7 mx-auto">
    <div class="card-body">
        <h2 class="fw-bold mb-4">Add Customer</h2>

        <form method="POST" action="{{ route('admin.customers.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Customer Name">
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.com">
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" placeholder="+91 9876543210">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="3" placeholder="Complete address"></textarea>
            </div>

            <button type="submit" class="btn btn-success w-100 py-2">Save Customer</button>
        </form>
    </div>
</div>
@endsection
