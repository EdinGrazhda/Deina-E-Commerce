<!DOCTYPE html>
<html>
<head>
    <title>Order Status Update</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .status-update { background-color: #e3f2fd; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .status-badge { display: inline-block; padding: 8px 16px; border-radius: 20px; color: white; font-weight: bold; margin: 0 5px; }
        .status-confirmed { background-color: #2196f3; }
        .status-processing { background-color: #3f51b5; }
        .status-shipped { background-color: #9c27b0; }
        .status-completed { background-color: #4caf50; }
        .status-cancelled { background-color: #f44336; }
        .status-pending { background-color: #ff9800; }
        .order-details { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #333;">Order Status Update</h1>
        </div>
        
        <p>Dear {{ $customer_name }},</p>
        
        <p>We wanted to update you on the status of your order.</p>
        
        <div class="status-update">
            <h3>Status Update</h3>
            <p>Your order <strong>{{ $order_number }}</strong> status has been updated:</p>
            <p>
                <span class="status-badge status-{{ strtolower($old_status) }}">{{ $old_status }}</span>
                →
                <span class="status-badge status-{{ strtolower($new_status) }}">{{ $new_status }}</span>
            </p>
        </div>
        
        <div class="order-details">
            <h4>Order Details</h4>
            <p><strong>Order Number:</strong> {{ $order_number }}</p>
            <p><strong>Order Date:</strong> {{ $order_date }}</p>
            <p><strong>Current Status:</strong> {{ $new_status }}</p>
            @if($tracking_number)
                <p><strong>Tracking Number:</strong> {{ $tracking_number }}</p>
            @endif
        </div>
        
        @if($new_status === 'Shipped' && $tracking_number)
            <div style="background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <h4 style="color: #2e7d32;">Your order has been shipped!</h4>
                <p>You can track your package using tracking number: <strong>{{ $tracking_number }}</strong></p>
            </div>
        @endif
        
        @if($new_status === 'Completed')
            <div style="background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 15px 0;">
                <h4 style="color: #2e7d32;">Your order has been delivered!</h4>
                <p>Thank you for choosing us. We hope you enjoy your purchase!</p>
            </div>
        @endif
        
        <p>If you have any questions about your order, please don't hesitate to contact us.</p>
        
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Best regards,<br>Deina Team</p>
        </div>
    </div>
</body>
</html>
