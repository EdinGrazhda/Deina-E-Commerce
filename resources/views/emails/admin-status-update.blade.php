<!DOCTYPE html>
<html>
<head>
    <title>Order Status Updated - Admin Notification</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; background-color: #1976d2; color: white; padding: 20px; border-radius: 10px; }
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
            <h1>Order Status Updated</h1>
            <p>Admin Notification</p>
        </div>
        
        <p>An order status has been updated in the system.</p>
        
        <div class="status-update">
            <h3>Status Change</h3>
            <p>Order <strong>{{ $order_number }}</strong> status changed:</p>
            <p>
                <span class="status-badge status-{{ strtolower($old_status) }}">{{ $old_status }}</span>
                →
                <span class="status-badge status-{{ strtolower($new_status) }}">{{ $new_status }}</span>
            </p>
        </div>
        
        <div class="order-details">
            <h4>Order Information</h4>
            <p><strong>Order Number:</strong> {{ $order_number }}</p>
            <p><strong>Customer:</strong> {{ $customer_name }}</p>
            <p><strong>Order Date:</strong> {{ $order_date }}</p>
            <p><strong>New Status:</strong> {{ $new_status }}</p>
            @if($tracking_number)
                <p><strong>Tracking Number:</strong> {{ $tracking_number }}</p>
            @endif
        </div>
        
        <div class="footer">
            <p>This is an automated notification from your e-commerce system.</p>
            <p>Deina Admin Panel</p>
        </div>
    </div>
</body>
</html>
