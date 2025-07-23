<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();
        
        if ($users->isEmpty()) {
            // Create a test user if no users exist
            $user = User::factory()->create([
                'name' => 'Test Customer',
                'email' => 'customer@example.com'
            ]);
            $users = collect([$user]);
        }

        // Create sample orders
        $orders = [
            [
                'user_id' => $users->random()->id,
                'total_price' => 150.00,
                'status' => OrderStatus::COMPLETED,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 89.99,
                'status' => OrderStatus::PENDING,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 320.50,
                'status' => OrderStatus::PROCESSING,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 45.25,
                'status' => OrderStatus::SHIPPED,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 199.99,
                'status' => OrderStatus::COMPLETED,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 75.80,
                'status' => OrderStatus::CANCELLED,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 420.00,
                'status' => OrderStatus::PROCESSING,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 33.50,
                'status' => OrderStatus::PENDING,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 167.25,
                'status' => OrderStatus::SHIPPED,
            ],
            [
                'user_id' => $users->random()->id,
                'total_price' => 299.00,
                'status' => OrderStatus::COMPLETED,
            ],
        ];

        foreach ($orders as $orderData) {
            Order::create($orderData);
        }

        $this->command->info('Orders seeded successfully!');
    }
}
