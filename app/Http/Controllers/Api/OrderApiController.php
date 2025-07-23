<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderApiController extends Controller
{
    public function processPayment(Request $request)
    {
        try {
            $request->validate([
                'paymentMethodId' => 'required|string',
                'amount' => 'required|integer|min:1',
                'customer' => 'required|array',
                'customer.name' => 'required|string|max:255',
                'customer.email' => 'required|email|max:255',
                'customer.phone' => 'required|string|max:20',
                'customer.address' => 'required|string',
                'items' => 'required|array|min:1',
            ]);

            // Initialize Stripe
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Create payment intent
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'payment_method' => $request->paymentMethodId,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => url('/'),
                'metadata' => [
                    'customer_name' => $request->customer['name'],
                    'customer_email' => $request->customer['email'],
                ]
            ]);

            if ($paymentIntent->status == 'succeeded') {
                // Start database transaction for atomic operations
                DB::beginTransaction();
                
                try {
                    // Check stock availability and collect products
                    $stockValidation = [];
                    foreach ($request->items as $item) {
                        $product = Product::find($item['id']);
                        if (!$product) {
                            throw new \Exception("Product with ID {$item['id']} not found");
                        }
                        
                        if ($product->stock < $item['quantity']) {
                            throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->stock}, Requested: {$item['quantity']}");
                        }
                        
                        $stockValidation[] = [
                            'product' => $product,
                            'quantity' => $item['quantity']
                        ];
                    }
                    
                    // Create order in database
                    $order = Order::create([
                        'order_number' => Order::generateOrderNumber(),
                        'customer_name' => $request->customer['name'],
                        'customer_email' => $request->customer['email'],
                        'customer_phone' => $request->customer['phone'],
                        'shipping_address' => $request->customer['address'],
                        'total_amount' => $request->amount / 100, // Convert back from cents
                        'total_price' => $request->amount / 100, // For compatibility with old system
                        'payment_method' => 'stripe',
                        'payment_status' => 'completed',
                        'stripe_payment_intent_id' => $paymentIntent->id,
                        'order_status' => 'confirmed',
                    ]);

                    // Create order items and reduce stock
                    foreach ($stockValidation as $validation) {
                        $product = $validation['product'];
                        $quantity = $validation['quantity'];
                        
                        // Find the original item data for order item creation
                        $itemData = collect($request->items)->firstWhere('id', $product->id);
                        
                        // Create order item
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'price' => $itemData['price'],
                            'quantity' => $quantity,
                        ]);
                        
                        // Reduce stock
                        if (!$product->decreaseStock($quantity)) {
                            throw new \Exception("Failed to update stock for {$product->name}");
                        }
                        
                        Log::info("Stock reduced for product {$product->name} (ID: {$product->id}): {$quantity} units. New stock: {$product->stock}");
                    }
                    
                    // Commit the transaction
                    DB::commit();
                    
                    $orderNumber = $order->order_number;

                // Send email confirmation to customer
                try {
                    $orderData = [
                        'customer' => $request->customer,
                        'items' => collect($request->items)->map(function($item) {
                            return [
                                'name' => $item['name'],
                                'price' => $item['price'],
                                'quantity' => $item['quantity'],
                                'product_number' => 'PRD-' . str_pad($item['id'], 6, '0', STR_PAD_LEFT)
                            ];
                        })->toArray(),
                        'total' => $request->amount / 100,
                        'paymentMethod' => 'stripe',
                        'orderNumber' => $orderNumber,
                        'orderDate' => now()->toISOString()
                    ];

                    // Send confirmation email to customer
                    Mail::send('emails.order-confirmation', $orderData, function ($message) use ($request, $orderNumber) {
                        $message->to($request->customer['email'], $request->customer['name'])
                                ->subject('Order Confirmation - ' . $orderNumber)
                                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });

                    // Send notification email to admin
                    Mail::send('emails.admin-order-notification', $orderData, function ($message) use ($orderNumber) {
                        $message->to('edingrazhda17@gmail.com', 'Admin')
                                ->subject('New Order Received - ' . $orderNumber)
                                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    });

                    Log::info('Emails sent successfully for order: ' . $orderNumber);

                } catch (\Exception $e) {
                    Log::error('Email sending error for order ' . $orderNumber . ': ' . $e->getMessage());
                    // Don't throw error, just log it so payment can still succeed
                }

                return response()->json([
                    'success' => true,
                    'orderNumber' => $orderNumber,
                    'message' => 'Payment successful'
                ]);
                
                } catch (\Exception $e) {
                    // Rollback transaction on error
                    DB::rollback();
                    Log::error('Order processing error: ' . $e->getMessage());
                    throw $e;
                }
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment requires additional action'
                ], 400);
            }

        } catch (\Stripe\Exception\CardException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getError()->message
            ], 400);
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Payment processing failed'
            ], 500);
        }
    }

    public function sendOrderConfirmation(Request $request)
    {
        try {
            $request->validate([
                'customer' => 'required|array',
                'customer.email' => 'required|email',
                'customer.name' => 'required|string',
                'items' => 'required|array',
                'total' => 'required|numeric',
                'paymentMethod' => 'required|string',
            ]);

            $orderData = $request->all();
            
            // Generate order number if not provided
            if (!isset($orderData['orderNumber'])) {
                $orderData['orderNumber'] = 'ORD-' . time();
            }

            // Create order in database for cash orders
            if ($orderData['paymentMethod'] === 'cash') {
                // Start database transaction for atomic operations
                DB::beginTransaction();
                
                try {
                    // Check stock availability and collect products
                    $stockValidation = [];
                    foreach ($orderData['items'] as $item) {
                        $product = Product::find($item['id']);
                        if (!$product) {
                            throw new \Exception("Product with ID {$item['id']} not found");
                        }
                        
                        if ($product->stock < $item['quantity']) {
                            throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->stock}, Requested: {$item['quantity']}");
                        }
                        
                        $stockValidation[] = [
                            'product' => $product,
                            'quantity' => $item['quantity']
                        ];
                    }
                    
                    $order = Order::create([
                        'order_number' => Order::generateOrderNumber(),
                        'customer_name' => $orderData['customer']['name'],
                        'customer_email' => $orderData['customer']['email'],
                        'customer_phone' => $orderData['customer']['phone'],
                        'shipping_address' => $orderData['customer']['address'],
                        'total_amount' => $orderData['total'],
                        'total_price' => $orderData['total'], // For compatibility with old system
                        'payment_method' => 'cash',
                        'payment_status' => 'pending',
                        'order_status' => 'confirmed',
                    ]);

                    // Create order items and reduce stock
                    foreach ($stockValidation as $validation) {
                        $product = $validation['product'];
                        $quantity = $validation['quantity'];
                        
                        // Find the original item data for order item creation
                        $itemData = collect($orderData['items'])->firstWhere('id', $product->id);
                        
                        // Create order item
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'product_name' => $product->name,
                            'price' => $itemData['price'],
                            'quantity' => $quantity,
                        ]);
                        
                        // Reduce stock
                        if (!$product->decreaseStock($quantity)) {
                            throw new \Exception("Failed to update stock for {$product->name}");
                        }
                        
                        Log::info("Stock reduced for product {$product->name} (ID: {$product->id}): {$quantity} units. New stock: {$product->stock}");
                    }
                    
                    // Commit the transaction
                    DB::commit();

                    $orderData['orderNumber'] = $order->order_number;
                    
                    // Add product numbers to items for email
                    $orderData['items'] = collect($orderData['items'])->map(function($item) {
                        return array_merge($item, [
                            'product_number' => 'PRD-' . str_pad($item['id'], 6, '0', STR_PAD_LEFT)
                        ]);
                    })->toArray();
                    
                } catch (\Exception $e) {
                    // Rollback transaction on error
                    DB::rollback();
                    Log::error('Cash order processing error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'error' => $e->getMessage()
                    ], 400);
                }
            }

            // Send email confirmation to customer and admin
            try {
                // Send confirmation email to customer
                Mail::send('emails.order-confirmation', $orderData, function ($message) use ($orderData) {
                    $message->to($orderData['customer']['email'], $orderData['customer']['name'])
                            ->subject('Order Confirmation - ' . $orderData['orderNumber'])
                            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });

                // Send notification email to admin
                Mail::send('emails.admin-order-notification', $orderData, function ($message) use ($orderData) {
                    $message->to('edingrazhda17@gmail.com', 'Admin')
                            ->subject('New Order Received - ' . $orderData['orderNumber'])
                            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                });
                
                Log::info('Order confirmation emails sent successfully to: ' . $orderData['customer']['email'] . ' and admin for order: ' . $orderData['orderNumber']);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Order confirmation email sent successfully',
                    'orderNumber' => $orderData['orderNumber']
                ]);
                
            } catch (\Exception $e) {
                Log::error('Email sending error for order ' . $orderData['orderNumber'] . ': ' . $e->getMessage());
                Log::error('Email error details: ' . $e->getTraceAsString());
                
                return response()->json([
                    'success' => false,
                    'error' => 'Order placed but failed to send confirmation email. Order number: ' . $orderData['orderNumber'],
                    'orderNumber' => $orderData['orderNumber']
                ], 200); // Use 200 since order was created successfully
            }

        } catch (\Exception $e) {
            Log::error('Email sending error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to send confirmation email'
            ], 500);
        }
    }
}
