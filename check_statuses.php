<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;

echo "Checking order statuses:\n";
$orders = Order::all();
foreach ($orders as $order) {
    echo "Order ID: {$order->id}\n";
    echo "  Status value: '{$order->status->value}' - Label: '{$order->status->label()}'\n";
    echo "  Order Status: '{$order->order_status}'\n";
    echo "  Raw status: " . var_export($order->getRawOriginal('status'), true) . "\n";
    echo "  Raw order_status: " . var_export($order->getRawOriginal('order_status'), true) . "\n";
    echo "  ----\n";
}
