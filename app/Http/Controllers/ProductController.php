<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();
        
        return view('Admin.products.index', compact('products', 'categories'));
    }

    /**
     * Get products data for AJAX requests
     */
    public function getData(Request $request): JsonResponse
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Stock filter
        if ($request->has('stock_filter') && $request->stock_filter) {
            switch ($request->stock_filter) {
                case 'in_stock':
                    $query->where('stock', '>', 10);
                    break;
                case 'low_stock':
                    $query->where('stock', '<=', 10)
                          ->where('stock', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
        }

        $products = $query->latest()->get();

        return response()->json([
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => (float) $product->price,
                    'stock' => $product->stock,
                    'category' => $product->category->name ?? 'Uncategorized',
                    'image' => $product->image ?? 'https://via.placeholder.com/300x200/e5e7eb/6b7280?text=No+Image',
                    'created_at' => $product->created_at->format('M d, Y'),
                ];
            }),
            'stats' => [
                'totalProducts' => Product::count(),
                'inStock' => Product::where('stock', '>', 10)->count(),
                'lowStock' => Product::where('stock', '<=', 10)
                                   ->where('stock', '>', 0)->count(),
                'categories' => Category::count(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:category,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $validated['image'] = Storage::url($imagePath);
            }

            $product = Product::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => (float) $product->price,
                    'stock' => $product->stock,
                    'category' => $product->category->name,
                    'image' => $product->image ?? 'https://via.placeholder.com/300x200/e5e7eb/6b7280?text=No+Image',
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        $product->load('category');
        
        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => (float) $product->price,
            'stock' => $product->stock,
            'category_id' => $product->category_id,
            'category' => $product->category->name ?? 'Uncategorized',
            'image' => $product->image ?? 'https://via.placeholder.com/300x200/e5e7eb/6b7280?text=No+Image',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:category,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image) {
                    $oldImagePath = str_replace('/storage/', '', $product->image);
                    Storage::disk('public')->delete($oldImagePath);
                }

                $image = $request->file('image');
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $validated['image'] = Storage::url($imagePath);
            }

            $product->update($validated);
            $product->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => (float) $product->price,
                    'stock' => $product->stock,
                    'category' => $product->category->name,
                    'image' => $product->image ?? 'https://via.placeholder.com/300x200/e5e7eb/6b7280?text=No+Image',
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        try {
            Log::info('Delete request received for product:', [
                'id' => $product->id, 
                'name' => $product->name,
                'request_method' => request()->method(),
                'request_headers' => request()->headers->all()
            ]);
            
            // Delete image if exists
            if ($product->image && !str_contains($product->image, 'placeholder')) {
                $imagePath = str_replace('/storage/', '', $product->image);
                Storage::disk('public')->delete($imagePath);
                Log::info('Image deleted:', ['path' => $imagePath]);
            }

            $productName = $product->name;
            $productId = $product->id;
            
            $product->delete();
            
            Log::info('Product deleted successfully:', ['id' => $productId, 'name' => $productName]);

            return response()->json([
                'success' => true,
                'message' => "Product '{$productName}' has been deleted successfully!"
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete product:', [
                'product_id' => $product->id ?? 'unknown',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
