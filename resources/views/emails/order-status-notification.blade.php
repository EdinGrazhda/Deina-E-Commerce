<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px 10px 0 0;
            margin: -30px -30px 30px -30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .order-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .label {
            font-weight: 600;
            color: #495057;
        }
        .value {
            color: #212529;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Order Status Notification</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">{{ $order_number }}</p>
        </div>

        <p>Dear {{ $customer_name }},</p>
        
        <p>We wanted to update you on your recent order with us. Here's the current status of your order:</p>

        <div class="order-details">
            <div class="detail-row">
                <span class="label">Order Number:</span>
                <span class="value">{{ $order_number }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Order Date:</span>
                <span class="value">{{ $order_date }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Total Amount:</span>
                <span class="value">${{ number_format($total_amount, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="label">Current Status:</span>
                <span class="value">{{ $current_status }}</span>
            </div>
            @if(isset($tracking_number) && $tracking_number)
            <div class="detail-row">
                <span class="label">Tracking Number:</span>
                <span class="value">{{ $tracking_number }}</span>
            </div>
            @endif
        </div>

        <p>Thank you for your business!</p>
        
        <p>Best regards,<br>
        <strong>The Deina Team</strong></p>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; 2025 Deina E-Commerce. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
