<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Status Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            margin: 10px 0;
        }
        .status-pending { background-color: #FEF3C7; color: #92400E; }
        .status-in_transit { background-color: #DBEAFE; color: #1E40AF; }
        .status-out_for_delivery { background-color: #FED7AA; color: #9A3412; }
        .status-delivered { background-color: #D1FAE5; color: #065F46; }
        .status-failed { background-color: #FEE2E2; color: #991B1B; }
        .info-box {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-row {
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #6B7280;
            font-size: 14px;
        }
        .value {
            color: #111827;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6B7280;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 Parcel Status Update</h1>
    </div>

    <div class="content">
        <p>Dear {{ $customer->name }},</p>

        <p>Your parcel status has been updated:</p>

        <div style="text-align: center;">
            <span class="status-badge status-{{ $status }}">
                {{ ucfirst(str_replace('_', ' ', $status)) }}
            </span>
        </div>

        <div class="info-box">
            <div class="info-row">
                <div class="label">Tracking ID</div>
                <div class="value">{{ $parcel->tracking_id }}</div>
            </div>
            <div class="info-row">
                <div class="label">From</div>
                <div class="value">{{ $parcel->sender_name }}</div>
            </div>
            <div class="info-row">
                <div class="label">To</div>
                <div class="value">{{ $parcel->receiver_name }}</div>
            </div>
            <div class="info-row">
                <div class="label">Delivery Address</div>
                <div class="value">{{ $parcel->address_to }}</div>
            </div>
        </div>

        @if($status === 'in_transit')
            <p>✅ Your parcel is now on its way!</p>
        @elseif($status === 'out_for_delivery')
            <p>🚚 Great news! Your parcel is out for delivery and should arrive today.</p>
        @elseif($status === 'delivered')
            <p>🎉 Your parcel has been successfully delivered!</p>
        @elseif($status === 'failed')
            <p>⚠️ We encountered an issue delivering your parcel. Our team will attempt redelivery soon.</p>
        @endif

        <div style="text-align: center;">
            <a href="{{ route('track', $parcel->tracking_id) }}" class="btn">Track Your Parcel</a>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for choosing our delivery service!</p>
        <p>If you have any questions, please contact our support team.</p>
    </div>
</body>
</html>