<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing = Category::where('slug', 'clothing')->first();
        $accessories = Category::where('slug', 'accessories')->first();
        $books = Category::where('slug', 'books')->first();

        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Latest iPhone with titanium design and A17 Pro chip for outstanding performance',
                'price' => 999.99,
                'stock' => 25,
                'category_id' => $electronics->id,
                'image' => 'https://images.unsplash.com/photo-1592179900824-3e640e1d8645?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'MacBook Air M3',
                'description' => 'Powerful and lightweight laptop with M3 chip and all-day battery life',
                'price' => 1299.99,
                'stock' => 15,
                'category_id' => $electronics->id,
                'image' => 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Nike Air Max 270',
                'description' => 'Comfortable running shoes with Air Max technology for maximum comfort',
                'price' => 149.99,
                'stock' => 50,
                'category_id' => $clothing->id,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Designer Backpack',
                'description' => 'Premium leather backpack perfect for work and travel with multiple compartments',
                'price' => 89.99,
                'stock' => 8,
                'category_id' => $accessories->id,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Wireless Earbuds',
                'description' => 'True wireless earbuds with active noise cancellation and long battery life',
                'price' => 199.99,
                'stock' => 3,
                'category_id' => $electronics->id,
                'image' => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'JavaScript Programming Guide',
                'description' => 'Comprehensive guide to learn advanced JavaScript techniques and best practices',
                'price' => 39.99,
                'stock' => 20,
                'category_id' => $books->id,
                'image' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Smart Watch Series 9',
                'description' => 'Feature-rich smartwatch with health tracking, GPS, and water resistance',
                'price' => 299.99,
                'stock' => 0,
                'category_id' => $electronics->id,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&h=300&fit=crop'
            ],
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'Comfortable 100% organic cotton t-shirt available in various colors and sizes',
                'price' => 24.99,
                'stock' => 100,
                'category_id' => $clothing->id,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400&h=300&fit=crop'
            ]
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
