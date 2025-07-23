<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get all categories
        $categories = Category::all();
        
        // Get featured products with their category relationships
        $products = Product::with('category')
            ->where('stock', '>', 0)
            ->take(12)
            ->get()
            ->map(function ($product) {
                // Ensure we have the correct full URL for images
                $imageUrl = null;
                if ($product->image) {
                    // If the image URL starts with /storage/, prepend the app URL
                    if (str_starts_with($product->image, '/storage/')) {
                        $imageUrl = config('app.url') . $product->image;
                    } else if (str_starts_with($product->image, 'http')) {
                        // Already a full URL
                        $imageUrl = $product->image;
                    } else {
                        // Relative path, make it a storage URL
                        $imageUrl = config('app.url') . '/storage/' . $product->image;
                    }
                }
                
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image_url' => $imageUrl,
                    'category_name' => $product->category->name ?? 'Uncategorized',
                    'category_slug' => $product->category->slug ?? 'uncategorized',
                ];
            });

        return view('welcome', compact('categories', 'products'));
    }
}
