<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 10px;
        }
        .alert {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .order-number {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .order-number h2 {
            margin: 0;
            color: #dc3545;
            font-size: 24px;
        }
        .section {
            margin: 30px 0;
        }
        .section h3 {
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .customer-info {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .order-items {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-info {
            flex-grow: 1;
        }
        .item-name {
            font-weight: bold;
            color: #374151;
        }
        .item-details {
            color: #6b7280;
            font-size: 14px;
        }
        .item-price {
            font-weight: bold;
            color: #dc3545;
        }
        .total {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
        .payment-method {
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
        .quick-actions {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">🚨 NEW ORDER ALERT</div>
            <p>You have received a new order on Deina E-Commerce!</p>
        </div>

        <!-- Alert -->
        <div class="alert">
            <strong>Action Required:</strong> A new customer has placed an order and is waiting for processing.
        </div>

        <!-- Order Number -->
        <div class="order-number">
            <h2>Order #{{ $orderNumber }}</h2>
            <p>Order Date: {{ \Carbon\Carbon::parse($orderDate ?? now())->format('F j, Y g:i A') }}</p>
        </div>

        <!-- Customer Information -->
        <div class="section">
            <h3>Customer Details</h3>
            <div class="customer-info">
                <strong>Name:</strong> {{ $customer['name'] }}<br>
                <strong>Email:</strong> {{ $customer['email'] }}<br>
                <strong>Phone:</strong> {{ $customer['phone'] }}<br>
                <strong>Shipping Address:</strong> {{ $customer['address'] }}
            </div>
        </div>

        <!-- Order Items -->
        <div class="section">
            <h3>Items Ordered</h3>
            <div class="order-items">
                @foreach($items as $item)
                <div class="item">
                    <div class="item-info">
                        <div class="item-name">{{ $item['name'] }}</div>
                        <div class="item-details">
                            Quantity: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}
                            @if(isset($item['product_number']))
                                <br>Product #: {{ $item['product_number'] }}
                            @endif
                        </div>
                    </div>
                    <div class="item-price">
                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
                @endforeach
                
                <div class="total">
                    Total Revenue: ${{ number_format($total, 2) }}
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="section">
            <h3>Payment Information</h3>
            <div class="payment-method">
                <strong>Payment Method:</strong> 
                @if($paymentMethod === 'cash')
                    💵 Cash on Delivery (Payment Pending)
                @elseif($paymentMethod === 'stripe')
                    💳 Credit/Debit Card (Payment Completed)
                @else
                    {{ ucfirst($paymentMethod) }}
                @endif
                
                @if($paymentMethod === 'cash')
                    <br><em style="color: #856404;">⚠️ Ensure delivery person collects payment upon delivery.</em>
                @else
                    <br><em style="color: #155724;">✅ Payment has been processed successfully.</em>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3>Quick Actions</h3>
            <p>Access your admin panel to manage this order:</p>
            <a href="{{ url('/admin/orders') }}" class="btn">View Order in Admin Panel</a>
            <br>
            <small style="color: #6b7280;">
                Remember to update the order status and add tracking information when available.
            </small>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Order Processing Checklist:</strong></p>
            <p style="font-size: 12px; text-align: left; max-width: 400px; margin: 0 auto;">
                1. ✅ Order received and logged<br>
                2. ⏳ Verify inventory and process order<br>
                3. ⏳ Update order status to "Processing"<br>
                4. ⏳ Prepare items for shipment<br>
                5. ⏳ Add tracking number<br>
                6. ⏳ Update status to "Shipped"<br>
                7. ⏳ Mark as "Completed" when delivered
            </p>
            
            <p style="margin-top: 30px; font-size: 12px;">
                This notification was sent to: edingrazhda17@gmail.com<br>
                © {{ date('Y') }} Deina E-Commerce Admin System
            </p>
        </div>
    </div>
</body>
</html>
