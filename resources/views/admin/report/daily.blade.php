@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>📦 Delivered Parcels - {{ $today->format('d M Y') }}</h3>

    @if($parcels->count() == 0)
        <p>No parcels delivered today.</p>
    @else
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Tracking ID</th>
                <th>Customer</th>
                <th>Agent</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parcels as $p)
            <tr>
                <td>{{ $p->tracking_id }}</td>
                <td>{{ $p->customer->name ?? '—' }}</td>
                <td>{{ $p->agent->name ?? '-' }}</td>
                <td>{{ $p->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    <a href="{{ route('admin.reports.daily.pdf') }}" class="btn btn-danger">
                <i class="fa fa-file-pdf"></i> Download PDF
            </a>
</div>
@endsection
