<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.category.index');
    }

    /**
     * Get categories data for AJAX requests
     */
    public function getData()
    {    
        try {
            Log::info('CategoryController getData called');
            
            $categories = Category::withCount('products')
                ->orderBy('name')
                ->get();

            Log::info("Categories count: {$categories->count()}");

            $formattedCategories = $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'slug' => $category->slug,
                    'products_count' => $category->products_count,
                    'created_at' => $category->created_at->format('M d, Y'),
                    'updated_at' => $category->updated_at->format('M d, Y')
                ];
            });

            Log::info('Formatted categories: ' . $formattedCategories->toJson());

            $response = [
                'success' => true,
                'categories' => $formattedCategories
            ];

            Log::info('Final response: ' . json_encode($response));

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('CategoryController getData error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load categories: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:category,name',
                'description' => 'nullable|string|max:1000',
                'slug' => 'required|string|max:255|unique:category,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            ], [
                'name.required' => 'Category name is required.',
                'name.unique' => 'This category name already exists.',
                'name.max' => 'Category name cannot exceed 255 characters.',
                'description.max' => 'Description cannot exceed 1000 characters.',
                'slug.required' => 'Slug is required.',
                'slug.unique' => 'This slug already exists.',
                'slug.regex' => 'Slug must be lowercase letters, numbers, and hyphens only.',
            ]);

            // Auto-generate slug if not provided
            if (empty($validatedData['slug'])) {
                $validatedData['slug'] = Str::slug($validatedData['name']);
            }

            // Ensure slug is unique
            $originalSlug = $validatedData['slug'];
            $counter = 1;
            while (Category::where('slug', $validatedData['slug'])->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }

            $category = Category::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'slug' => $category->slug,
                    'products_count' => 0,
                    'created_at' => $category->created_at->format('M d, Y'),
                    'updated_at' => $category->updated_at->format('M d, Y')
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . collect($e->errors())->flatten()->implode(' ')
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        try {
            $categoryData = [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'slug' => $category->slug,
                'products_count' => $category->products()->count(),
                'created_at' => $category->created_at->format('M d, Y'),
                'updated_at' => $category->updated_at->format('M d, Y')
            ];

            return response()->json($categoryData);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:category,name,' . $category->id,
                'description' => 'nullable|string|max:1000',
                'slug' => 'required|string|max:255|unique:category,slug,' . $category->id . '|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            ], [
                'name.required' => 'Category name is required.',
                'name.unique' => 'This category name already exists.',
                'name.max' => 'Category name cannot exceed 255 characters.',
                'description.max' => 'Description cannot exceed 1000 characters.',
                'slug.required' => 'Slug is required.',
                'slug.unique' => 'This slug already exists.',
                'slug.regex' => 'Slug must be lowercase letters, numbers, and hyphens only.',
            ]);

            // Auto-generate slug if not provided
            if (empty($validatedData['slug'])) {
                $validatedData['slug'] = Str::slug($validatedData['name']);
            }

            // Ensure slug is unique (excluding current category)
            $originalSlug = $validatedData['slug'];
            $counter = 1;
            while (Category::where('slug', $validatedData['slug'])->where('id', '!=', $category->id)->exists()) {
                $validatedData['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }

            $category->update($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'slug' => $category->slug,
                    'products_count' => $category->products()->count(),
                    'created_at' => $category->created_at->format('M d, Y'),
                    'updated_at' => $category->updated_at->format('M d, Y')
                ]
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . collect($e->errors())->flatten()->implode(' ')
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Check if category has products
            $productsCount = $category->products()->count();
            
            if ($productsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete category '{$category->name}' because it has {$productsCount} product(s). Please move or delete all products first."
                ], 400);
            }

            $categoryName = $category->name;
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => "Category '{$categoryName}' deleted successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category: ' . $e->getMessage()
            ], 500);
        }
    }
}
