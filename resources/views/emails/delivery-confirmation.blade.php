<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Confirmation</title>
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
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .success-icon {
            font-size: 60px;
            margin-bottom: 10px;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
        }
        .info-box {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #10B981;
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
        .rating-section {
            background: linear-gradient(135deg, #DBEAFE 0%, #BFDBFE 100%);
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
            text-align: center;
        }
        .rating-section h3 {
            color: #1E40AF;
            margin-top: 0;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #4F46E5 0%, #4338CA 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(79, 70, 229, 0.3);
        }
        .btn:hover {
            box-shadow: 0 6px 8px rgba(79, 70, 229, 0.4);
        }
        .stars {
            font-size: 30px;
            margin: 15px 0;
            color: #FBBF24;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6B7280;
            font-size: 14px;
        }
        .signature-box {
            background-color: #FEF3C7;
            padding: 15px;
            border-radius: 5px;
            margin: 15px 0;
            border-left: 4px solid #F59E0B;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="success-icon">✓</div>
        <h1>Delivered Successfully!</h1>
    </div>

    <div class="content">
        <p style="font-size: 18px; color: #10B981; font-weight: bold;">Dear {{ $customer->name }},</p>

        <p>Great news! Your parcel has been successfully delivered.</p>

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
            <div class="info-row">
                <div class="label">Delivered At</div>
                <div class="value">{{ $parcel->delivered_at->format('F j, Y g:i A') }}</div>
            </div>
            @if($parcel->agent)
            <div class="info-row">
                <div class="label">Delivery Agent</div>
                <div class="value">{{ $parcel->agent->name }}</div>
            </div>
            @endif
        </div>

        @if($parcel->recipient_name_confirmed)
        <div class="signature-box">
            <div class="label">Received By</div>
            <div class="value" style="color: #92400E;">{{ $parcel->recipient_name_confirmed }}</div>
        </div>
        @endif

        <div class="rating-section">
            <h3>How was your delivery experience?</h3>
            <p>We'd love to hear your feedback!</p>
            <div class="stars">⭐⭐⭐⭐⭐</div>
            <p style="color: #1E40AF; font-size: 14px;">
                Your feedback helps us improve our service and recognize our best delivery agents.
            </p>
            <a href="{{ $ratingUrl }}" class="btn">Rate Your Experience</a>
        </div>

        <p style="margin-top: 30px;">
            Thank you for choosing our delivery service. We hope to serve you again soon!
        </p>
    </div>

    <div class="footer">
        <p><strong>Need help?</strong></p>
        <p>Contact our support team if you have any questions or concerns.</p>
        <p style="color: #9CA3AF; font-size: 12px; margin-top: 20px;">
            This is an automated message. Please do not reply to this email.
        </p>
    </div>
</body>
</html>