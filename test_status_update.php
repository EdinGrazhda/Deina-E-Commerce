<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;

echo "Testing status update functionality:\n";

// Find an order to test with
$order = Order::find(11);
if ($order) {
    echo "Before: Order {$order->id} status = {$order->order_status}\n";
    
    // Create a mock request
    $request = new Request();
    $request->merge(['status' => 'processing']);
    
    // Create controller instance
    $controller = new OrderController();
    
    try {
        $response = $controller->updateStatus($request, $order->id);
        $responseData = json_decode($response->getContent(), true);
        
        if ($responseData['success']) {
            echo "Status update successful!\n";
            echo "Response: " . $response->getContent() . "\n";
        } else {
            echo "Status update failed: " . $responseData['message'] . "\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    
    // Check the updated order
    $order->refresh();
    echo "After: Order {$order->id} status = {$order->order_status}\n";
} else {
    echo "No test order found (order ID 11)\n";
}
