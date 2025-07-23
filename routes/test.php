<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;

Route::get('/test-email', function () {
    try {
        $order = Order::first();
        
        if (!$order) {
            return response()->json(['error' => 'No orders found']);
        }
        
        $emailData = [
            'customer_name' => $order->customer_name ?? 'Test Customer',
            'order_number' => $order->order_number ?? 'TEST-001',
            'current_status' => 'Processing',
            'order_date' => now()->format('M d, Y'),
            'total_amount' => 100.00,
            'tracking_number' => null
        ];

        Mail::send('emails.order-status-notification', $emailData, function ($message) use ($order) {
            $message->to('test@example.com', 'Test Customer')
                    ->subject('Test Email')
                    ->from(env('MAIL_FROM_ADDRESS', 'test@deina.com'), env('MAIL_FROM_NAME', 'Deina'));
        });

        return response()->json(['success' => 'Email sent successfully']);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
});
