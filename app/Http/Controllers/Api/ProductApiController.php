<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductApiController extends Controller
{
    /**
     * Get all products with filtering options
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category');

        // Filter by category if specified
        if ($request->has('category') && $request->category !== '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by stock status
        if ($request->boolean('in_stock_only', true)) {
            $query->where('stock', '>', 0);
        }

        $products = $query->take(12)->get()->map(function ($product) {
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

        return response()->json([
            'success' => true,
            'data' => $products,
            'count' => $products->count()
        ]);
    }
}
