<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px 0;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-in_transit { background: #dbeafe; color: #1e40af; }
        .status-out_for_delivery { background: #e0e7ff; color: #4338ca; }
        .status-delivered { background: #d1fae5; color: #065f46; }
        .status-failed { background: #fee2e2; color: #991b1b; }
        .info-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .tracking-id {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 Parcel Status Update</h1>
    </div>
    
    <div class="content">
        <p>Hi {{ $customer->name }},</p>
        
        <p>Your parcel status has been updated:</p>
        
        <div class="tracking-id">{{ $parcel->tracking_id }}</div>
        
        <div class="status-badge status-{{ $status }}">
            {{ ucfirst(str_replace('_', ' ', $status)) }}
        </div>
        
        @if($status == 'in_transit')
            <p>🚚 Your parcel is on the move! You can now track its live location in real-time.</p>
        @elseif($status == 'out_for_delivery')
            <p>🎉 Great news! Your parcel is out for delivery and should arrive today.</p>
        @elseif($status == 'delivered')
            <p>✅ Your parcel has been successfully delivered! We hope you're satisfied with our service.</p>
        @elseif($status == 'failed')
            <p>⚠️ We encountered an issue delivering your parcel. Our team will contact you shortly to reschedule.</p>
        @endif
        
        <div class="info-box">
            <strong>Parcel Details:</strong><br>
            <strong>From:</strong> {{ $parcel->sender_name }}<br>
            <strong>To:</strong> {{ $parcel->receiver_name }}<br>
            <strong>Destination:</strong> {{ $parcel->address_to }}<br>
            <strong>Weight:</strong> {{ $parcel->weight }} kg
        </div>
        
        <center>
            <a href="{{ route('track.page') }}" class="button">
                Track Your Parcel
            </a>
        </center>
        
        @if($parcel->notes)
        <div class="info-box">
            <strong>Note from Agent:</strong><br>
            {{ $parcel->notes }}
        </div>
        @endif
    </div>
    
    <div class="footer">
        <p>This is an automated notification. Please do not reply to this email.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>