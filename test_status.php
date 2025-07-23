<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Enums\OrderStatus;

echo "Testing enum values:\n";
foreach (OrderStatus::cases() as $status) {
    echo "- {$status->value} -> {$status->label()} ({$status->color()})\n";
}

echo "\nTesting order with confirmed status:\n";
$order = Order::find(11);
if ($order) {
    echo "Order {$order->id} status: {$order->order_status}\n";
    echo "Should show as: Confirmed\n";
}
