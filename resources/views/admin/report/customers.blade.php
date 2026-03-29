@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">Customer Report</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            @if($customers->count() == 0)
                <p>No customers found.</p>
            @else
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Total Parcels</th>
                            <th>Joined At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key => $customer)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->parcels_count }}</td>
                            <td>{{ $customer->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <a href="{{ route('admin.reports.customers.pdf') }}" class="btn btn-danger">
                <i class="fa fa-file-pdf"></i> Download PDF
            </a>

        </div>
    </div>

</div>
@endsection
