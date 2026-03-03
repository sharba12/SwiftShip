<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Report</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background: #000;
            color: #fff;
            padding: 8px;
        }
        td {
            padding: 6px;
            font-size: 13px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h2>Customer Report</h2>

<table>
    <thead>
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

</body>
</html>
