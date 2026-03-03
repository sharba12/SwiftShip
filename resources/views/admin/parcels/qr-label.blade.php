<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Parcel Label - {{ $parcel->tracking_id }}</title>
    <style>
        @page {
            size: A6;
            margin: 10mm;
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        
        .label-container {
            border: 3px solid #000;
            padding: 15px;
            text-align: center;
        }
        
        .header {
            background: #2563eb;
            color: white;
            padding: 10px;
            margin: -15px -15px 15px -15px;
            font-size: 20px;
            font-weight: bold;
        }
        
        .qr-code {
            margin: 20px auto;
            text-align: center;
        }
        
        .qr-code img {
            width: 200px;
            height: 200px;
            border: 2px solid #000;
            padding: 10px;
            background: white;
        }
        
        .tracking-id {
            font-size: 28px;
            font-weight: bold;
            margin: 15px 0;
            letter-spacing: 2px;
        }
        
        .info-section {
            text-align: left;
            margin: 20px 0;
            border-top: 2px dashed #ccc;
            padding-top: 15px;
        }
        
        .info-row {
            margin: 8px 0;
            font-size: 12px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            color: #000;
        }
        
        .from-to {
            display: flex;
            justify-content: space-between;
            margin: 15px 0;
        }
        
        .address-box {
            width: 48%;
            border: 1px solid #ccc;
            padding: 10px;
            background: #f9fafb;
            text-align: left;
            font-size: 11px;
        }
        
        .address-title {
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 20px;
            border-top: 2px solid #000;
            padding-top: 10px;
            font-size: 10px;
            color: #666;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #fef3c7;
            color: #92400e;
            border-radius: 15px;
            font-weight: bold;
            font-size: 12px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="label-container">
        <div class="header">
            PARCEL SHIPPING LABEL
        </div>

        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
        </div>

        <div class="tracking-id">
            {{ $parcel->tracking_id }}
        </div>

        <div class="status-badge">
            {{ strtoupper(str_replace('_', ' ', $parcel->status)) }}
        </div>

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Weight:</span>
                <span class="info-value">{{ $parcel->weight }} kg</span>
            </div>
            <div class="info-row">
                <span class="info-label">Customer:</span>
                <span class="info-value">{{ $parcel->customer->name ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Agent:</span>
                <span class="info-value">{{ $parcel->agent->name ?? 'Not Assigned' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Created:</span>
                <span class="info-value">{{ $parcel->created_at->format('M d, Y h:i A') }}</span>
            </div>
        </div>

        <div style="margin: 20px 0;">
            <div style="text-align: left; margin-bottom: 15px;">
                <div class="address-title">📦 FROM:</div>
                <div style="font-weight: bold; margin: 5px 0;">{{ $parcel->sender_name }}</div>
                <div style="font-size: 11px;">{{ $parcel->address_from }}</div>
            </div>

            <div style="text-align: left;">
                <div class="address-title">📍 TO:</div>
                <div style="font-weight: bold; margin: 5px 0;">{{ $parcel->receiver_name }}</div>
                <div style="font-size: 11px;">{{ $parcel->receiver_contact }}</div>
                <div style="font-size: 11px;">{{ $parcel->address_to }}</div>
            </div>
        </div>

        <div class="footer">
            <p style="margin: 5px 0;"><strong>{{ config('app.name') }}</strong></p>
            <p style="margin: 5px 0;">Scan QR code to track parcel</p>
            <p style="margin: 5px 0;">Generated: {{ now()->format('M d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>