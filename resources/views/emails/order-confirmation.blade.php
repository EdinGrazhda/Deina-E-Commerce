<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
            color: #2563eb;
            margin-bottom: 10px;
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
            color: #2563eb;
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
            background-color: #f9fafb;
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
            color: #2563eb;
        }
        .total {
            background-color: #2563eb;
            color: white;
            padding: 15px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }
        .payment-method {
            background-color: #f0f9ff;
            border: 1px solid #bfdbfe;
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
        .tracking-info {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">Deina E-Commerce</div>
            <p>Thank you for your order!</p>
        </div>

        <!-- Order Number -->
        <div class="order-number">
            <h2>Order #{{ $orderNumber }}</h2>
            <p>Order Date: {{ \Carbon\Carbon::parse($orderDate ?? now())->format('F j, Y g:i A') }}</p>
        </div>

        <!-- Customer Information -->
        <div class="section">
            <h3>Shipping Information</h3>
            <div class="customer-info">
                <strong>{{ $customer['name'] }}</strong><br>
                Email: {{ $customer['email'] }}<br>
                Phone: {{ $customer['phone'] }}<br>
                Address: {{ $customer['address'] }}
            </div>
        </div>

        <!-- Order Items -->
        <div class="section">
            <h3>Order Items</h3>
            <div class="order-items">
                @foreach($items as $item)
                <div class="item">
                    <div class="item-info">
                        <div class="item-name">{{ $item['name'] }}</div>
                        <div class="item-details">
                            Quantity: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}
                        </div>
                    </div>
                    <div class="item-price">
                        ${{ number_format($item['price'] * $item['quantity'], 2) }}
                    </div>
                </div>
                @endforeach
                
                <div class="total">
                    Total: ${{ number_format($total, 2) }}
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="section">
            <h3>Payment Information</h3>
            <div class="payment-method">
                <strong>Payment Method:</strong> 
                @if($paymentMethod === 'cash')
                    Cash on Delivery
                @elseif($paymentMethod === 'stripe')
                    Credit/Debit Card
                @else
                    {{ ucfirst($paymentMethod) }}
                @endif
                
                @if($paymentMethod === 'cash')
                    <br><em>Please have the exact amount ready when your order arrives.</em>
                @else
                    <br><em>Payment has been successfully processed.</em>
                @endif
            </div>
        </div>

        <!-- Tracking Information -->
        <div class="section">
            <h3>Order Status & Tracking</h3>
            <div class="tracking-info">
                <strong>Status:</strong> Order Confirmed<br>
                <strong>Estimated Delivery:</strong> 3-5 business days<br>
                @if(isset($trackingNumber))
                    <strong>Tracking Number:</strong> {{ $trackingNumber }}<br>
                @endif
                <p><em>You will receive another email with tracking information once your order ships.</em></p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Questions about your order?</p>
            <p>Contact us at <a href="mailto:edingrazhda17@gmail.com">support@deina.com</a> or call (555) 123-4567</p>
            
            <p style="margin-top: 30px;">
                <a href="{{ url('/') }}" class="btn">Continue Shopping</a>
            </p>
            
            <p style="margin-top: 30px; font-size: 12px;">
                This email was sent to {{ $customer['email'] }}.<br>
                © {{ date('Y') }} Deina E-Commerce. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
