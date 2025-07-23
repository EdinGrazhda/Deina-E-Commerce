<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics', 
                'slug' => 'electronics',
                'description' => 'Latest electronic devices, gadgets, and tech accessories'
            ],
            [
                'name' => 'Clothing', 
                'slug' => 'clothing',
                'description' => 'Fashion apparel for men, women, and children'
            ],
            [
                'name' => 'Accessories', 
                'slug' => 'accessories',
                'description' => 'Stylish accessories to complement your look'
            ],
            [
                'name' => 'Books', 
                'slug' => 'books',
                'description' => 'Wide collection of books across all genres'
            ],
            [
                'name' => 'Home & Garden', 
                'slug' => 'home-garden',
                'description' => 'Everything for your home and garden needs'
            ],
            [
                'name' => 'Sports', 
                'slug' => 'sports',
                'description' => 'Sports equipment and athletic wear'
            ],
            [
                'name' => 'Beauty', 
                'slug' => 'beauty',
                'description' => 'Beauty products and cosmetics'
            ],
            [
                'name' => 'Toys', 
                'slug' => 'toys',
                'description' => 'Fun and educational toys for all ages'
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
