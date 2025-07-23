<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Deina') }} - Premium E-Commerce</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-card {
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-0.5rem);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        .product-image {
            transition: transform 0.5s ease;
        }
        .product-card:hover .product-image {
            transform: scale(1.1);
        }
        .category-btn {
            transition: all 0.2s ease;
            @apply bg-gray-100 text-gray-700 hover:bg-blue-100 hover:text-blue-700;
        }
        .category-btn.active {
            @apply bg-blue-600 text-white;
        }
        .dark .category-btn {
            @apply bg-gray-700 text-gray-300 hover:bg-gray-600 hover:text-white;
        }
        .dark .category-btn.active {
            @apply bg-blue-600 text-white;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900" x-data="ecommerceApp()">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-lg sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Deina</h1>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">E-Commerce</span>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-lg mx-8">
                        <div class="relative w-full">
                            <input 
                                type="text" 
                                x-model="searchTerm"
                                @input="handleSearch"
                                placeholder="Search products..." 
                                class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-0 rounded-full focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-gray-600 transition-all duration-200">
                            <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button @click="toggleCart" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5h10.5m-10.5-6.5L5.4 5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                                </svg>
                                <span x-show="cart.length > 0" x-text="cartCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"></span>
                            </button>
                        </div>
                        
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
                
                <!-- Mobile Search -->
                <div class="md:hidden pb-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            x-model="searchTerm"
                            @input="handleSearch"
                            placeholder="Search products..." 
                            class="w-full px-4 py-2 pl-10 pr-4 text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-300 border-0 rounded-full focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-gray-600 transition-all duration-200">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Welcome to <span class="text-yellow-300">Deina</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Discover amazing products at unbeatable prices
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button @click="scrollToProducts()" 
                            class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                        Shop Now
                    </button>
                    <button class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                        Learn More
                    </button>
                </div>
            </div>
        </section>

        <!-- Main Content with Sidebar -->
        <section id="products" class="py-8 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <!-- Categories Sidebar -->
                    <div class="lg:w-1/4">
                        <!-- Mobile Categories Toggle -->
                        <div class="lg:hidden mb-4">
                            <button @click="showMobileCategories = !showMobileCategories" 
                                    class="w-full flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                <span class="font-medium text-gray-900 dark:text-white">Categories</span>
                                <svg class="w-5 h-5 transform transition-transform" 
                                     :class="showMobileCategories ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Categories List -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6"
                             :class="{'hidden lg:block': !showMobileCategories, 'block': showMobileCategories}">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Categories</h3>
                            
                            <!-- All Products Option -->
                            <button @click="filterByCategory(''); showMobileCategories = false" 
                                    :class="selectedCategory === '' ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800' : 'border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                    class="w-full text-left px-4 py-3 rounded-lg border transition-all duration-200 mb-2 flex items-center justify-between">
                                <span class="font-medium">All Products</span>
                                <span class="text-sm" x-text="`${products.length}`"></span>
                            </button>

                            <!-- Category List -->
                            <div class="space-y-2">
                                <template x-for="category in categories" :key="category.id">
                                    <button @click="filterByCategory(category.slug); showMobileCategories = false" 
                                            :class="selectedCategory === category.slug ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border-blue-200 dark:border-blue-800' : 'border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'"
                                            class="w-full text-left px-4 py-3 rounded-lg border transition-all duration-200 flex items-center justify-between">
                                        <span x-text="category.name"></span>
                                        <span class="text-sm" x-text="getProductCountByCategory(category.slug)"></span>
                                    </button>
                                </template>
                            </div>

                            <!-- Price Filter -->
                            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-4">Price Range</h4>
                                <div class="space-y-3">
                                    <button @click="filterByPriceRange('all')"
                                            :class="selectedPriceRange === 'all' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                            class="block text-sm hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        All Prices
                                    </button>
                                    <button @click="filterByPriceRange('0-25')"
                                            :class="selectedPriceRange === '0-25' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                            class="block text-sm hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        Under $25
                                    </button>
                                    <button @click="filterByPriceRange('25-50')"
                                            :class="selectedPriceRange === '25-50' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                            class="block text-sm hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        $25 - $50
                                    </button>
                                    <button @click="filterByPriceRange('50-100')"
                                            :class="selectedPriceRange === '50-100' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                            class="block text-sm hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        $50 - $100
                                    </button>
                                    <button @click="filterByPriceRange('100+')"
                                            :class="selectedPriceRange === '100+' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400'"
                                            class="block text-sm hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                        Over $100
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Content -->
                    <div class="lg:w-3/4">
                        <!-- Section Header -->
                        <div class="mb-8">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                <span x-show="selectedCategory === ''">All Products</span>
                                <template x-for="category in categories" :key="category.id">
                                    <span x-show="selectedCategory === category.slug" x-text="category.name"></span>
                                </template>
                            </h2>
                            <p class="text-gray-600 dark:text-gray-400">
                                Discover our handpicked selection of premium products
                            </p>
                        </div>

                        <!-- Products Count -->
                        <div class="mb-6">
                            <p class="text-gray-600 dark:text-gray-400" x-text="`Showing ${filteredProducts.length} product${filteredProducts.length !== 1 ? 's' : ''}`"></p>
                        </div>

                        <!-- Loading State -->
                        <div x-show="loading" class="text-center py-20">
                            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                            <p class="mt-4 text-gray-600 dark:text-gray-400">Loading products...</p>
                        </div>

                        <!-- Products Grid -->
                        <div x-show="!loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <template x-for="product in filteredProducts" :key="product.id">
                                <div class="product-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group">
                                    <!-- Product Image -->
                                    <div class="relative overflow-hidden">
                                        <img :src="product.image_url || 'https://via.placeholder.com/400x300/e5e7eb/9ca3af?text=Product+Image'" 
                                             :alt="product.name"
                                             class="product-image w-full h-64 object-cover"
                                             loading="lazy"
                                             onerror="this.src='https://via.placeholder.com/400x300/e5e7eb/9ca3af?text=Product+Image'">
                                      
                                        
                                        <!-- Quick Actions -->
                                        <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <button @click="toggleWishlist(product.id)" 
                                                    class="p-2 bg-white text-gray-600 hover:text-red-500 rounded-full shadow-lg transition-all duration-200 hover:scale-110">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                            <button @click="quickView(product.id)" 
                                                    class="p-2 bg-white text-gray-600 hover:text-blue-500 rounded-full shadow-lg transition-all duration-200 hover:scale-110">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Stock Badge -->
                                        <template x-if="product.stock <= 5 && product.stock > 0">
                                            <div class="absolute top-4 left-4">
                                                <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-semibold" x-text="`Only ${product.stock} left!`"></span>
                                            </div>
                                        </template>
                                        <template x-if="product.stock === 0">
                                            <div class="absolute top-4 left-4">
                                                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">Out of Stock</span>
                                            </div>
                                        </template>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-6">
                                        <!-- Category -->
                                        <div class="mb-2">
                                            <span class="text-sm text-blue-600 dark:text-blue-400 font-medium" x-text="product.category_name"></span>
                                        </div>
                                        
                                        <!-- Product Name -->
                                        <h3 @click="quickView(product.id)" 
                                            class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 cursor-pointer hover:text-blue-600 dark:hover:text-blue-400 transition-colors" 
                                            x-text="product.name"></h3>
                                        
                                        <!-- Description -->
                                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2" x-text="product.description || 'No description available'"></p>
                                        
                                        <!-- Price and Stock -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-2xl font-bold text-gray-900 dark:text-white" x-text="`$${parseFloat(product.price).toFixed(2)}`"></span>
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <span x-text="`${product.stock} in stock`"></span>
                                            </div>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex space-x-2">
                                            <button @click="addToCart(product)" 
                                                    :disabled="product.stock === 0"
                                                    :class="product.stock === 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 transform hover:scale-105'"
                                                    class="flex-1 text-white py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg text-sm"
                                                    x-text="product.stock > 0 ? 'Add to Cart' : 'Out of Stock'">
                                            </button>
                                            <button @click="quickView(product.id)"
                                                    class="px-4 py-3 border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl font-semibold transition-all duration-200 text-sm">
                                                Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Empty State -->
                        <div x-show="!loading && filteredProducts.length === 0" class="text-center py-20">
                            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2m16-7h-4m-4 0V9m4 4h-4m0 0h-4m4 0V9m-4 4V9"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No products found</h3>
                            <p class="text-gray-600 dark:text-gray-400">Try adjusting your search or filter criteria</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Deina</h3>
                        <p class="text-gray-400 mb-4">Your trusted e-commerce partner for quality products and exceptional service.</p>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                            <li><a href="#" class="hover:text-white transition-colors">Support</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Categories</h4>
                        <ul class="space-y-2 text-gray-400">
                            <template x-for="category in categories.slice(0, 4)" :key="category.id">
                                <li>
                                    <a href="#" class="hover:text-white transition-colors" x-text="category.name"></a>
                                </li>
                            </template>
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-4">Follow Us</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.097.118.112.222.085.343-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2025 Deina E-Commerce. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <!-- Cart Sidebar -->
        <div x-show="isCartOpen" 
             @click.away="isCartOpen = false"
             x-transition:enter="transform transition ease-in-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 z-50 w-full max-w-md bg-white dark:bg-gray-800 shadow-xl">
            
            <div class="flex flex-col h-full">
                <!-- Cart Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Shopping Cart</h2>
                    <button @click="toggleCart" 
                            class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto p-6">
                    <template x-if="cart.length === 0">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Your cart is empty</p>
                        </div>
                    </template>

                    <div class="space-y-4">
                        <template x-for="item in cart" :key="item.id">
                            <div class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <img :src="item.image_url || 'https://via.placeholder.com/100x100/e5e7eb/9ca3af?text=Product'" 
                                     :alt="item.name"
                                     class="w-16 h-16 object-cover rounded-lg">
                                
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate" x-text="item.name"></h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="`$${parseFloat(item.price).toFixed(2)}`"></p>
                                    
                                    <div class="flex items-center mt-2 space-x-2">
                                        <button @click="updateCartItemQuantity(item.id, item.quantity - 1)"
                                                class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <span class="px-2 py-1 text-sm font-medium text-gray-900 dark:text-white" x-text="item.quantity"></span>
                                        <button @click="updateCartItemQuantity(item.id, item.quantity + 1)"
                                                class="p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        </button>
                                        <button @click="removeFromCart(item.id)"
                                                class="ml-4 p-1 text-red-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Cart Footer -->
                <div x-show="cart.length > 0" class="border-t border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400" x-text="`$${cartTotal.toFixed(2)}`"></span>
                    </div>
                    <button @click="openCheckout()" class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                        Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>

        <!-- Cart Backdrop -->
        <div x-show="isCartOpen" 
             @click="toggleCart"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-40"></div>

        <!-- Checkout Modal -->
        <div x-show="isCheckoutOpen" 
             @click.away="closeCheckout"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                
                <!-- Modal panel -->
                <div x-show="isCheckoutOpen"
                     x-transition:enter="transform transition ease-out duration-300"
                     x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                     x-transition:leave="transform transition ease-in duration-200"
                     x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                     x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Checkout</h3>
                        <button @click="closeCheckout" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Checkout Steps -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                <div :class="checkoutStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'" 
                                     class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium">1</div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Information</span>
                            </div>
                            <div class="flex-1 h-px bg-gray-200 mx-4"></div>
                            <div class="flex items-center space-x-2">
                                <div :class="checkoutStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'" 
                                     class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium">2</div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment</span>
                            </div>
                            <div class="flex-1 h-px bg-gray-200 mx-4"></div>
                            <div class="flex items-center space-x-2">
                                <div :class="checkoutStep >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'" 
                                     class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium">3</div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Confirm</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Customer Information -->
                    <div x-show="checkoutStep === 1" x-transition>
                        <form @submit.prevent="proceedToPayment">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name</label>
                                    <input x-model="customerInfo.name" type="text" required 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                                    <input x-model="customerInfo.email" type="email" required 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                                    <input x-model="customerInfo.phone" type="tel" required 
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Shipping Address</label>
                                    <textarea x-model="customerInfo.address" required rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-between">
                                <button type="button" @click="closeCheckout" 
                                        class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Continue to Payment
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Step 2: Payment Method -->
                    <div x-show="checkoutStep === 2" x-transition class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Choose Payment Method</h4>
                        
                        <!-- Payment Method Selection -->
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700" 
                                   :class="paymentMethod === 'cash' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-600'">
                                <input x-model="paymentMethod" type="radio" value="cash" class="text-blue-600">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Cash on Delivery</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Pay when you receive your order</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700" 
                                   :class="paymentMethod === 'stripe' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-600'">
                                <input x-model="paymentMethod" type="radio" value="stripe" class="text-blue-600">
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Credit/Debit Card</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Secure payment with Stripe</div>
                                </div>
                            </label>
                        </div>

                        <!-- Stripe Card Element (shown when Stripe is selected) -->
                        <div x-show="paymentMethod === 'stripe'" x-transition class="mt-4">
                            <div id="stripe-card-element" class="p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                                <!-- Stripe Elements will be mounted here -->
                            </div>
                            <div id="stripe-card-errors" class="text-red-600 text-sm mt-2"></div>
                        </div>

                        <div class="mt-6 flex justify-between">
                            <button @click="checkoutStep = 1" 
                                    class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                Back
                            </button>
                            <button @click="proceedToConfirm" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Continue to Review
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Order Confirmation -->
                    <div x-show="checkoutStep === 3" x-transition>
                        <div class="space-y-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Order Summary</h4>
                            
                            <!-- Customer Information -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h5 class="font-medium text-gray-900 dark:text-white mb-2">Shipping Information</h5>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p x-text="customerInfo.name"></p>
                                    <p x-text="customerInfo.email"></p>
                                    <p x-text="customerInfo.phone"></p>
                                    <p x-text="customerInfo.address"></p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h5 class="font-medium text-gray-900 dark:text-white mb-2">Order Items</h5>
                                <div class="space-y-2">
                                    <template x-for="item in cart" :key="item.id">
                                        <div class="flex justify-between text-sm">
                                            <span x-text="`${item.name} x${item.quantity}`" class="text-gray-600 dark:text-gray-400"></span>
                                            <span x-text="`$${(item.price * item.quantity).toFixed(2)}`" class="text-gray-900 dark:text-white"></span>
                                        </div>
                                    </template>
                                    <div class="border-t pt-2 mt-2">
                                        <div class="flex justify-between font-medium">
                                            <span class="text-gray-900 dark:text-white">Total:</span>
                                            <span x-text="`$${cartTotal.toFixed(2)}`" class="text-blue-600 dark:text-blue-400"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <h5 class="font-medium text-gray-900 dark:text-white mb-2">Payment Method</h5>
                                <p class="text-sm text-gray-600 dark:text-gray-400" 
                                   x-text="paymentMethod === 'cash' ? 'Cash on Delivery' : 'Credit/Debit Card'"></p>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button @click="checkoutStep = 2" 
                                        class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                                    Back
                                </button>
                                <button @click="placeOrder" :disabled="processingOrder"
                                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-show="!processingOrder">Place Order</span>
                                    <span x-show="processingOrder" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Success Modal -->
        <div x-show="orderSuccess" 
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full sm:p-6">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Order Placed Successfully!</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Thank you for your order. You will receive an email confirmation with tracking details shortly.
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6" x-show="orderNumber">
                            Order Number: <span class="font-medium" x-text="orderNumber"></span>
                        </p>
                        <button @click="closeOrderSuccess" 
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors">
                            Continue Shopping
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Modal -->
        <div x-show="isProductDetailsOpen" 
             @click.away="closeProductDetails"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto">
            
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                
                <!-- Modal panel -->
                <div x-show="isProductDetailsOpen"
                     x-transition:enter="transform transition ease-out duration-300"
                     x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                     x-transition:leave="transform transition ease-in duration-200"
                     x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                     x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    
                    <template x-if="selectedProduct">
                        <div class="bg-white dark:bg-gray-800">
                            <!-- Header -->
                            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Product Details</h3>
                                <button @click="closeProductDetails" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Product Image -->
                                    <div class="space-y-4">
                                        <div class="aspect-w-1 aspect-h-1 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                                            <img :src="selectedProduct.image_url || 'https://via.placeholder.com/600x600/e5e7eb/9ca3af?text=Product+Image'" 
                                                 :alt="selectedProduct.name"
                                                 class="w-full h-96 object-cover"
                                                 onerror="this.src='https://via.placeholder.com/600x600/e5e7eb/9ca3af?text=Product+Image'">
                                        </div>
                                        
                                        <!-- Thumbnail images (if you have multiple images in the future) -->
                                        <div class="flex space-x-2">
                                            <img :src="selectedProduct.image_url || 'https://via.placeholder.com/100x100/e5e7eb/9ca3af?text=Product'" 
                                                 :alt="selectedProduct.name"
                                                 class="w-16 h-16 object-cover rounded-lg border-2 border-blue-500 cursor-pointer">
                                        </div>
                                    </div>

                                    <!-- Product Information -->
                                    <div class="space-y-6">
                                        <!-- Category -->
                                        <div>
                                            <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm font-medium px-3 py-1 rounded-full" 
                                                  x-text="selectedProduct.category_name"></span>
                                        </div>

                                        <!-- Product Name -->
                                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white" x-text="selectedProduct.name"></h1>

                                        <!-- Price -->
                                        <div class="flex items-baseline space-x-2">
                                            <span class="text-3xl font-bold text-gray-900 dark:text-white" 
                                                  x-text="`$${parseFloat(selectedProduct.price).toFixed(2)}`"></span>
                                        </div>

                                        <!-- Stock Status -->
                                        <div class="flex items-center space-x-2">
                                            <template x-if="selectedProduct.stock > 0">
                                                <span class="flex items-center text-green-600 dark:text-green-400">
                                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    In Stock
                                                </span>
                                            </template>
                                            <template x-if="selectedProduct.stock <= 0">
                                                <span class="flex items-center text-red-600 dark:text-red-400">
                                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Out of Stock
                                                </span>
                                            </template>
                                            <span class="text-gray-600 dark:text-gray-400 text-sm" 
                                                  x-text="`${selectedProduct.stock} units available`"></span>
                                        </div>

                                        <!-- Description -->
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Description</h3>
                                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed" 
                                               x-text="selectedProduct.description || 'No description available for this product.'"></p>
                                        </div>

                                        <!-- Quantity Selector -->
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    Quantity
                                                </label>
                                                <div class="flex items-center space-x-3">
                                                    <button @click="productQuantity = Math.max(1, productQuantity - 1)"
                                                            class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <span class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg min-w-16 text-center font-medium text-gray-900 dark:text-white" 
                                                          x-text="productQuantity"></span>
                                                    <button @click="productQuantity = Math.min(selectedProduct.stock, productQuantity + 1)"
                                                            :disabled="productQuantity >= selectedProduct.stock"
                                                            class="p-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Total Price for Selected Quantity -->
                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-lg font-medium text-gray-900 dark:text-white">Total:</span>
                                                    <span class="text-2xl font-bold text-blue-600 dark:text-blue-400" 
                                                          x-text="`$${(parseFloat(selectedProduct.price) * productQuantity).toFixed(2)}`"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex space-x-4">
                                            <button @click="addProductToCart()"
                                                    :disabled="selectedProduct.stock <= 0"
                                                    :class="selectedProduct.stock <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700'"
                                                    class="flex-1 text-white py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5h10.5M13 13l4-8H9l-1 2"></path>
                                                </svg>
                                                <span x-text="selectedProduct.stock > 0 ? 'Add to Cart' : 'Out of Stock'"></span>
                                            </button>
                                            
                                            <button @click="toggleProductWishlist()"
                                                    class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors flex items-center justify-center">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Product Details -->
                                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Product Details</h3>
                                            <dl class="space-y-3">
                                                <div class="flex justify-between">
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">SKU</dt>
                                                    <dd class="text-sm text-gray-900 dark:text-white" x-text="selectedProduct.sku || selectedProduct.id"></dd>
                                                </div>
                                                <div class="flex justify-between">
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Category</dt>
                                                    <dd class="text-sm text-gray-900 dark:text-white" x-text="selectedProduct.category_name"></dd>
                                                </div>
                                                <div class="flex justify-between">
                                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Availability</dt>
                                                    <dd class="text-sm text-gray-900 dark:text-white" 
                                                        x-text="selectedProduct.stock > 0 ? 'In Stock' : 'Out of Stock'"></dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Initialize Stripe
        const stripe = Stripe('{{ env('STRIPE_PUBLISHABLE_KEY', 'pk_test_YOUR_STRIPE_PUBLISHABLE_KEY_HERE') }}');
        let stripeElements = null;
        let stripeCardElement = null;

        function ecommerceApp() {
            return {
                // State
                products: [],
                categories: [],
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                wishlist: JSON.parse(localStorage.getItem('wishlist') || '[]'),
                searchTerm: '',
                selectedCategory: '',
                selectedPriceRange: 'all',
                isCartOpen: false,
                loading: true,
                showMobileCategories: false,

                // Checkout State
                isCheckoutOpen: false,
                checkoutStep: 1,
                paymentMethod: 'cash',
                processingOrder: false,
                orderSuccess: false,
                orderNumber: '',
                customerInfo: {
                    name: '',
                    email: '',
                    phone: '',
                    address: ''
                },

                // Product Details Modal State
                isProductDetailsOpen: false,
                selectedProduct: null,
                productQuantity: 1,

                // Computed properties
                get cartCount() {
                    return this.cart.reduce((total, item) => total + item.quantity, 0);
                },

                get cartTotal() {
                    return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                },

                get filteredProducts() {
                    let filtered = this.products;

                    // Filter by category
                    if (this.selectedCategory) {
                        filtered = filtered.filter(product => 
                            product.category_slug === this.selectedCategory
                        );
                    }

                    // Filter by search term
                    if (this.searchTerm) {
                        const searchLower = this.searchTerm.toLowerCase();
                        filtered = filtered.filter(product => 
                            product.name.toLowerCase().includes(searchLower) ||
                            (product.description && product.description.toLowerCase().includes(searchLower))
                        );
                    }

                    // Filter by price range
                    if (this.selectedPriceRange !== 'all') {
                        filtered = filtered.filter(product => {
                            const price = parseFloat(product.price);
                            switch (this.selectedPriceRange) {
                                case '0-25':
                                    return price < 25;
                                case '25-50':
                                    return price >= 25 && price <= 50;
                                case '50-100':
                                    return price >= 50 && price <= 100;
                                case '100+':
                                    return price > 100;
                                default:
                                    return true;
                            }
                        });
                    }

                    return filtered;
                },

                // Initialization
                async init() {
                    await this.loadCategories();
                    await this.loadProducts();
                    this.loading = false;
                },

                // API calls
                async loadProducts() {
                    try {
                        const response = await fetch('/api/products');
                        const data = await response.json();
                        this.products = data.data || data;
                    } catch (error) {
                        console.error('Error loading products:', error);
                        this.showToast('Error loading products', 'error');
                    }
                },

                async loadCategories() {
                    try {
                        const response = await fetch('/api/categories');
                        const data = await response.json();
                        this.categories = data.data || data;
                    } catch (error) {
                        console.error('Error loading categories:', error);
                        this.showToast('Error loading categories', 'error');
                    }
                },

                // Helper functions
                getProductCountByCategory(categorySlug) {
                    return this.products.filter(product => product.category_slug === categorySlug).length;
                },

                // Search and filtering
                handleSearch() {
                    // Search is reactive through x-model
                },

                filterByCategory(categorySlug) {
                    this.selectedCategory = categorySlug;
                },

                filterByPriceRange(range) {
                    this.selectedPriceRange = range;
                },

                // Cart functionality
                addToCart(product) {
                    if (product.stock <= 0) {
                        this.showToast('Product is out of stock', 'error');
                        return;
                    }

                    const existingItem = this.cart.find(item => item.id === product.id);
                    
                    if (existingItem) {
                        if (existingItem.quantity < product.stock) {
                            existingItem.quantity++;
                            this.showToast('Product quantity updated in cart', 'success');
                        } else {
                            this.showToast('Cannot add more than available stock', 'error');
                            return;
                        }
                    } else {
                        this.cart.push({
                            ...product,
                            quantity: 1
                        });
                        this.showToast('Product added to cart!', 'success');
                    }
                    
                    this.saveCart();
                },

                removeFromCart(productId) {
                    this.cart = this.cart.filter(item => item.id !== productId);
                    this.saveCart();
                    this.showToast('Product removed from cart', 'success');
                },

                updateCartItemQuantity(productId, newQuantity) {
                    if (newQuantity <= 0) {
                        this.removeFromCart(productId);
                        return;
                    }
                    
                    const item = this.cart.find(item => item.id === productId);
                    const product = this.products.find(p => p.id === productId);
                    
                    if (item && product) {
                        if (newQuantity <= product.stock) {
                            item.quantity = newQuantity;
                            this.saveCart();
                        } else {
                            this.showToast('Cannot add more than available stock', 'error');
                        }
                    }
                },

                toggleCart() {
                    this.isCartOpen = !this.isCartOpen;
                },

                saveCart() {
                    localStorage.setItem('cart', JSON.stringify(this.cart));
                },

                // Checkout functionality
                openCheckout() {
                    this.isCheckoutOpen = true;
                    this.isCartOpen = false;
                    this.checkoutStep = 1;
                },

                closeCheckout() {
                    this.isCheckoutOpen = false;
                    this.checkoutStep = 1;
                    this.paymentMethod = 'cash';
                    this.customerInfo = {
                        name: '',
                        email: '',
                        phone: '',
                        address: ''
                    };
                    if (stripeCardElement) {
                        stripeCardElement.clear();
                    }
                },

                proceedToPayment() {
                    this.checkoutStep = 2;
                    this.$nextTick(() => {
                        this.initializeStripe();
                    });
                },

                proceedToConfirm() {
                    this.checkoutStep = 3;
                },

                initializeStripe() {
                    if (stripeElements) {
                        stripeElements.clear();
                    }
                    
                    stripeElements = stripe.elements();
                    stripeCardElement = stripeElements.create('card', {
                        style: {
                            base: {
                                fontSize: '16px',
                                color: '#424770',
                                '::placeholder': {
                                    color: '#aab7c4',
                                },
                            },
                        },
                    });
                    
                    const cardElementContainer = document.getElementById('stripe-card-element');
                    if (cardElementContainer) {
                        stripeCardElement.mount('#stripe-card-element');
                        
                        stripeCardElement.on('change', (event) => {
                            const displayError = document.getElementById('stripe-card-errors');
                            if (event.error) {
                                displayError.textContent = event.error.message;
                            } else {
                                displayError.textContent = '';
                            }
                        });
                    }
                },

                async placeOrder() {
                    this.processingOrder = true;
                    
                    try {
                        if (this.paymentMethod === 'stripe') {
                            await this.processStripePayment();
                        } else {
                            await this.processCashOrder();
                        }
                    } catch (error) {
                        console.error('Order processing error:', error);
                        this.showToast('Failed to process order. Please try again.', 'error');
                        this.processingOrder = false;
                    }
                },

                async processCashOrder() {
                    try {
                        // Generate order number
                        this.orderNumber = 'ORD-' + Date.now();
                        
                        const orderData = {
                            customer: this.customerInfo,
                            items: this.cart,
                            total: this.cartTotal,
                            paymentMethod: 'cash',
                            orderNumber: this.orderNumber,
                            orderDate: new Date().toISOString()
                        };

                        // Send email confirmation through API
                        const response = await fetch('/api/send-order-confirmation', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(orderData)
                        });

                        const result = await response.json();
                        
                        if (result.success) {
                            // Clear cart and show success
                            this.cart = [];
                            this.saveCart();
                            this.processingOrder = false;
                            this.isCheckoutOpen = false;
                            this.orderSuccess = true;
                            
                            // Reload products to reflect updated stock
                            await this.loadProducts();
                            
                            this.showToast('Order placed successfully! Confirmation email sent.', 'success');
                        } else {
                            throw new Error(result.error || result.message || 'Failed to process order');
                        }
                    } catch (error) {
                        console.error('Cash order error:', error);
                        const errorMessage = error.message || 'Failed to process order. Please try again.';
                        this.showToast(errorMessage, 'error');
                        this.processingOrder = false;
                    }
                },

                async processStripePayment() {
                    if (!stripeCardElement) {
                        throw new Error('Stripe not initialized');
                    }

                    // Create payment method
                    const {paymentMethod, error} = await stripe.createPaymentMethod({
                        type: 'card',
                        card: stripeCardElement,
                        billing_details: {
                            name: this.customerInfo.name,
                            email: this.customerInfo.email,
                            phone: this.customerInfo.phone,
                            address: {
                                line1: this.customerInfo.address,
                            },
                        },
                    });

                    if (error) {
                        throw error;
                    }

                    // Process payment with your backend
                    const response = await fetch('/api/process-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            paymentMethodId: paymentMethod.id,
                            amount: Math.round(this.cartTotal * 100), // Convert to cents
                            customer: this.customerInfo,
                            items: this.cart
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        this.orderNumber = result.orderNumber;
                        
                        // Clear cart and show success
                        this.cart = [];
                        this.saveCart();
                        this.processingOrder = false;
                        this.isCheckoutOpen = false;
                        this.orderSuccess = true;
                        
                        // Reload products to reflect updated stock
                        await this.loadProducts();
                        
                        this.showToast('Payment successful! Confirmation email sent.', 'success');
                    } else {
                        throw new Error(result.error || 'Payment failed');
                    }
                },

                async sendEmailConfirmation(orderData) {
                    try {
                        const response = await fetch('/api/send-order-confirmation', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(orderData)
                        });

                        if (!response.ok) {
                            console.error('Failed to send email confirmation');
                        }
                    } catch (error) {
                        console.error('Email confirmation error:', error);
                    }
                },

                closeOrderSuccess() {
                    this.orderSuccess = false;
                    this.orderNumber = '';
                    this.customerInfo = {
                        name: '',
                        email: '',
                        phone: '',
                        address: ''
                    };
                    this.checkoutStep = 1;
                    this.paymentMethod = 'cash';
                },

                // Wishlist functionality
                toggleWishlist(productId) {
                    const index = this.wishlist.findIndex(item => item.id === productId);
                    
                    if (index > -1) {
                        this.wishlist.splice(index, 1);
                        this.showToast('Removed from wishlist!', 'success');
                    } else {
                        const product = this.products.find(p => p.id === productId);
                        if (product) {
                            this.wishlist.push(product);
                            this.showToast('Added to wishlist!', 'success');
                        }
                    }
                    
                    localStorage.setItem('wishlist', JSON.stringify(this.wishlist));
                },

                // Quick view
                quickView(productId) {
                    const product = this.products.find(p => p.id === productId);
                    if (product) {
                        this.selectedProduct = product;
                        this.productQuantity = 1;
                        this.isProductDetailsOpen = true;
                    }
                },

                // Close product details modal
                closeProductDetails() {
                    this.isProductDetailsOpen = false;
                    this.selectedProduct = null;
                    this.productQuantity = 1;
                },

                // Add product to cart from details modal
                addProductToCart() {
                    if (this.selectedProduct && this.selectedProduct.stock > 0) {
                        // Check if product already exists in cart
                        const existingItem = this.cart.find(item => item.id === this.selectedProduct.id);
                        
                        if (existingItem) {
                            // Update quantity of existing item
                            existingItem.quantity += this.productQuantity;
                        } else {
                            // Add new item to cart with specified quantity
                            this.cart.push({
                                ...this.selectedProduct,
                                quantity: this.productQuantity
                            });
                        }
                        
                        this.saveCart();
                        this.closeProductDetails();
                        this.showToast(`Added ${this.productQuantity} ${this.selectedProduct.name}(s) to cart!`, 'success');
                    }
                },

                // Toggle wishlist for selected product
                toggleProductWishlist() {
                    if (this.selectedProduct) {
                        this.toggleWishlist(this.selectedProduct.id);
                    }
                },

                // Scroll to products
                scrollToProducts() {
                    document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
                },

                // Toast notifications
                showToast(message, type = 'success') {
                    // Create toast element
                    const toast = document.createElement('div');
                    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 ease-in-out ${
                        type === 'success' ? 'bg-green-500 text-white' : 
                        type === 'error' ? 'bg-red-500 text-white' : 
                        'bg-blue-500 text-white'
                    }`;
                    
                    toast.innerHTML = `
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                ${type === 'success' ? 
                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>' :
                                    type === 'error' ?
                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>' :
                                    '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
                                }
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">${message}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <button class="inline-flex text-white hover:text-gray-200 focus:outline-none" onclick="this.parentElement.parentElement.parentElement.remove()">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    `;
                    
                    // Add to page
                    document.body.appendChild(toast);
                    
                    // Animate in
                    setTimeout(() => {
                        toast.style.transform = 'translateX(0)';
                    }, 100);
                    
                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        toast.style.transform = 'translateX(100%)';
                        setTimeout(() => {
                            if (toast.parentElement) {
                                toast.remove();
                            }
                        }, 300);
                    }, 5000);
                    
                    // Also log to console for debugging
                    console.log(`${type.toUpperCase()}: ${message}`);
                }
            }
        }
    </script>
</body>
</html>
