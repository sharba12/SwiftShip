<!DOCTYPE html>
<html>
<head>
    <title>Agent Performance - PDF</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top:20px; }
        th, td { border: 1px solid #333; padding: 8px; }
    </style>
</head>
<body>
<h2>🧑‍💼 Agent Performance Report</h2>

<table>
    <thead>
        <tr>
            <th>Agent</th>
            <th>Delivered</th>
            <th>Pending</th>
        </tr>
    </thead>
    <tbody>
        @foreach($performance as $p)
        <tr>
            <td>{{ $p->assigned_to }}</td>
            <td>{{ $p->delivered_count }}</td>
            <td>{{ $p->pending_count }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
