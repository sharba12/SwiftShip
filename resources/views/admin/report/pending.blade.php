@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>⏳ Pending Parcels</h3>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Customer</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parcels as $p)
            <tr>
                <td>{{ $p->tracking_id }}</td>
                <td>{{ $p->customer->name ?? '—' }}</td>
                <td>{{ $p->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.reports.pending.pdf') }}" class="btn btn-danger">
                <i class="fa fa-file-pdf"></i> Download PDF
            </a>

</div>
@endsection
