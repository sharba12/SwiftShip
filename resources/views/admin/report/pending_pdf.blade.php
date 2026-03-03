<!DOCTYPE html>
<html>
<head>
    <title>Pending Parcels - PDF</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top:20px; }
        th, td { border: 1px solid #333; padding: 8px; }
    </style>
</head>
<body>
<h2>⏳ Pending Parcels Report</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Tracking No</th>
            <th>Customer</th>
            <th>Address</th>
            <th>Assigned To</th>
        </tr>
    </thead>
    <tbody>
        @foreach($parcels as $p)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $p->tracking_number }}</td>
            <td>{{ $p->customer->name }}</td>
            <td>{{ $p->customer->address }}</td>
            <td>{{ $p->assigned_to ?? 'Unassigned' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
