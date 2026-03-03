@extends('admin.layout')

@section('content')
<div class="container">
    <h3>🧑‍💼 Agent Performance Report</h3>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Agent</th>
                <th>Delivered</th>
                <th>Pending</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agents as $agent)
            <tr>
                <td>{{ $agent->name }}</td>
                <td>{{ $agent->delivered_count }}</td>
                <td>{{ $agent->pending_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.reports.agents.pdf') }}" class="btn btn-danger">
                <i class="fa fa-file-pdf"></i> Download PDF
            </a>

</div>
@endsection
