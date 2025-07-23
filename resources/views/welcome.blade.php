<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Deina') }} - Premium E-Commerce</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .cart-overlay { 
            display: none; 
            position: fixed; 
            inset: 0; 
            background: rgba(0, 0, 0, 0.5); 
            z-index: 40; 
        }
        .cart-sidebar { 
            display: none; 
            position: fixed; 
            top: 0; 
            right: 0; 
            height: 100vh; 
            width: 100%; 
            max-width: 28rem; 
            background: white; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); 
            z-index: 50;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        .cart-sidebar.open { 
            display: flex; 
            transform: translateX(0);
        }
        .cart-overlay.open { 
            display: block; 
        }
        .toast {
            display: none;
            position: fixed;
            top: 1rem;
            right: 1rem;
            max-width: 24rem;
            width: 100%;
            z-index: 50;
            transform: translateY(-1rem);
            opacity: 0;
            transition: all 0.3s ease;
        }
        .toast.show {
            display: block;
            transform: translateY(0);
            opacity: 1;
        }
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
        }
        .category-btn.active {
            background-color: #2563eb;
            color: white;
        }
        .category-btn:not(.active) {
            background-color: #e5e7eb;
            color: #374151;
        }
        .category-btn:hover:not(.active) {
            background-color: #d1d5db;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
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
                                id="searchInput"
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
                            <button id="cartToggle" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5h10.5m-10.5-6.5L5.4 5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                                </svg>
                                <span id="cartCount" class="hidden absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
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
                            id="mobileSearchInput"
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
                    <button onclick="scrollToProducts()" 
                            class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 transform hover:scale-105">
                        Shop Now
                    </button>
                    <button class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all duration-300">
                        Learn More
                    </button>
                </div>
            </div>
        </section>

        <!-- Category Filter -->
        <section class="bg-white dark:bg-gray-800 py-8 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap gap-2 justify-center">
                    <button onclick="filterByCategory('')" 
                            class="category-btn active px-6 py-2 rounded-full font-medium transition-all duration-200"
                            data-category="">
                        All Products
                    </button>
                    @foreach($categories as $category)
                        <button onclick="filterByCategory('{{ $category->slug }}')" 
                                class="category-btn px-6 py-2 rounded-full font-medium transition-all duration-200"
                                data-category="{{ $category->slug }}">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section id="products" class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        Featured Products
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        Discover our handpicked selection of premium products
                    </p>
                </div>

                <!-- Products Count -->
                <div class="mb-6">
                    <p id="productCount" class="text-gray-600 dark:text-gray-400">Showing {{ count($products) }} products</p>
                </div>

                <!-- Products Grid -->
                <div id="productsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="product-card bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group" 
                             data-category="{{ $product['category_slug'] }}" 
                             data-name="{{ strtolower($product['name']) }}" 
                             data-description="{{ strtolower($product['description'] ?? '') }}">
                            <!-- Product Image -->
                            <div class="relative overflow-hidden">
                                <img src="{{ $product['image_url'] ?: 'https://via.placeholder.com/400x300/e5e7eb/9ca3af?text=Product+Image' }}" 
                                     alt="{{ $product['name'] }}"
                                     class="product-image w-full h-64 object-cover"
                                     loading="lazy">
                                <!-- Quick Actions -->
                                <div class="absolute top-4 right-4 space-y-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button onclick="toggleWishlist({{ $product['id'] }})" 
                                            class="p-2 bg-white text-gray-600 hover:text-red-500 rounded-full shadow-lg transition-all duration-200 hover:scale-110">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <button onclick="quickView({{ $product['id'] }})" 
                                            class="p-2 bg-white text-gray-600 hover:text-blue-500 rounded-full shadow-lg transition-all duration-200 hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Stock Badge -->
                                @if($product['stock'] <= 5 && $product['stock'] > 0)
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-orange-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            Only {{ $product['stock'] }} left!
                                        </span>
                                    </div>
                                @elseif($product['stock'] === 0)
                                    <div class="absolute top-4 left-4">
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                            Out of Stock
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="p-6">
                                <!-- Category -->
                                <div class="mb-2">
                                    <span class="text-sm text-blue-600 dark:text-blue-400 font-medium">{{ $product['category_name'] }}</span>
                                </div>
                                
                                <!-- Product Name -->
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $product['name'] }}</h3>
                                
                                <!-- Description -->
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{ $product['description'] ?? 'No description available' }}</p>
                                
                                <!-- Price and Stock -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($product['price'], 2) }}</span>
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        <span>{{ $product['stock'] }} in stock</span>
                                    </div>
                                </div>
                                
                                <!-- Add to Cart Button -->
                                <button onclick="addToCart({{ json_encode($product) }})" 
                                        {{ $product['stock'] === 0 ? 'disabled' : '' }}
                                        class="w-full text-white py-3 rounded-xl font-semibold transition-all duration-200 shadow-lg {{ $product['stock'] === 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 transform hover:scale-105' }}">
                                    {{ $product['stock'] > 0 ? 'Add to Cart' : 'Out of Stock' }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden text-center py-20">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2m16-7h-4m-4 0V9m4 4h-4m0 0h-4m4 0V9m-4 4V9"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No products found</h3>
                    <p class="text-gray-600 dark:text-gray-400">Try adjusting your search or filter criteria</p>
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
                            @foreach($categories->take(4) as $category)
                                <li>
                                    <a href="#" class="hover:text-white transition-colors">{{ $category->name }}</a>
                                </li>
                            @endforeach
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
        <div id="cartSidebar" class="cart-sidebar flex-col">
            <!-- Cart Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Shopping Cart</h2>
                <button id="cartClose" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6">
                <div id="cartEmpty" class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5h10.5"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Your cart is empty</p>
                </div>
                
                <div id="cartItems" class="space-y-4"></div>
            </div>
            
            <!-- Cart Footer -->
            <div id="cartFooter" class="hidden border-t border-gray-200 dark:border-gray-700 p-6">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                    <span id="cartTotal" class="text-lg font-bold text-gray-900 dark:text-white">$0.00</span>
                </div>
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition-colors">
                    Checkout
                </button>
            </div>
        </div>

        <!-- Cart Overlay -->
        <div id="cartOverlay" class="cart-overlay"></div>

        <!-- Toast Notifications -->
        <div id="toast" class="toast">
            <div id="toastContent" class="rounded-lg shadow-lg p-4 text-white">
                <div class="flex items-center">
                    <svg id="toastSuccessIcon" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg id="toastErrorIcon" class="hidden w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span id="toastMessage" class="flex-1"></span>
                    <button onclick="hideToast()" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        let wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
        let allProducts = @json($products);
        let currentFilter = '';
        let currentSearchTerm = '';

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            updateCartUI();
            
            // Setup event listeners
            document.getElementById('cartToggle').addEventListener('click', toggleCart);
            document.getElementById('cartClose').addEventListener('click', closeCart);
            document.getElementById('cartOverlay').addEventListener('click', closeCart);
            
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', handleSearch);
            document.getElementById('mobileSearchInput').addEventListener('input', handleSearch);
        });

        // Search functionality
        function handleSearch(e) {
            currentSearchTerm = e.target.value.toLowerCase();
            filterProducts();
        }

        // Category filtering
        function filterByCategory(category) {
            currentFilter = category;
            
            // Update category buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.category === category) {
                    btn.classList.add('active');
                }
            });
            
            filterProducts();
        }

        // Filter products based on search and category
        function filterProducts() {
            const productCards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            productCards.forEach(card => {
                const categoryMatch = !currentFilter || card.dataset.category === currentFilter;
                const searchMatch = !currentSearchTerm || 
                    card.dataset.name.includes(currentSearchTerm) || 
                    card.dataset.description.includes(currentSearchTerm);

                if (categoryMatch && searchMatch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update product count
            document.getElementById('productCount').textContent = `Showing ${visibleCount} product${visibleCount !== 1 ? 's' : ''}`;
            
            // Show/hide empty state
            const emptyState = document.getElementById('emptyState');
            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // Cart functionality
        function addToCart(product) {
            const existingItem = cart.find(item => item.id === product.id);
            
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    ...product,
                    quantity: 1
                });
            }
            
            saveCart();
            updateCartUI();
            showToast('Product added to cart!', 'success');
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            saveCart();
            updateCartUI();
            showToast('Product removed from cart!', 'success');
        }

        function updateCartQuantity(productId, newQuantity) {
            if (newQuantity <= 0) {
                removeFromCart(productId);
                return;
            }
            
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity = newQuantity;
                saveCart();
                updateCartUI();
            }
        }

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function updateCartUI() {
            const cartCount = document.getElementById('cartCount');
            const cartEmpty = document.getElementById('cartEmpty');
            const cartItems = document.getElementById('cartItems');
            const cartFooter = document.getElementById('cartFooter');
            const cartTotal = document.getElementById('cartTotal');

            // Update cart count
            if (cart.length > 0) {
                cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
                cartCount.classList.remove('hidden');
            } else {
                cartCount.classList.add('hidden');
            }

            // Update cart content
            if (cart.length === 0) {
                cartEmpty.style.display = 'block';
                cartFooter.classList.add('hidden');
                cartItems.innerHTML = '';
            } else {
                cartEmpty.style.display = 'none';
                cartFooter.classList.remove('hidden');
                
                // Render cart items
                cartItems.innerHTML = cart.map(item => `
                    <div class="flex items-center space-x-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <img src="${item.image_url || 'https://via.placeholder.com/64x64/e5e7eb/9ca3af?text=Item'}" 
                             alt="${item.name}" 
                             class="w-16 h-16 object-cover rounded-lg"
                             onerror="this.src='https://via.placeholder.com/64x64/e5e7eb/9ca3af?text=Item'">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900 dark:text-white text-sm">${item.name}</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">$${parseFloat(item.price).toFixed(2)}</p>
                            <div class="flex items-center space-x-2 mt-2">
                                <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">${item.quantity}</span>
                                <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button onclick="removeFromCart(${item.id})" class="text-red-400 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                `).join('');

                // Update total
                const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                cartTotal.textContent = `$${total.toFixed(2)}`;
            }
        }

        // Cart visibility
        function toggleCart() {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }

        function closeCart() {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
        }

        // Wishlist functionality
        function toggleWishlist(productId) {
            const index = wishlist.findIndex(item => item.id === productId);
            
            if (index > -1) {
                wishlist.splice(index, 1);
                showToast('Removed from wishlist!', 'success');
            } else {
                const product = allProducts.find(p => p.id === productId);
                if (product) {
                    wishlist.push(product);
                    showToast('Added to wishlist!', 'success');
                }
            }
            
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
        }

        // Quick view
        function quickView(productId) {
            showToast('Quick view coming soon!', 'success');
        }

        // Scroll to products
        function scrollToProducts() {
            document.getElementById('products').scrollIntoView({ behavior: 'smooth' });
        }

        // Toast notifications
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastContent = document.getElementById('toastContent');
            const toastMessage = document.getElementById('toastMessage');
            const successIcon = document.getElementById('toastSuccessIcon');
            const errorIcon = document.getElementById('toastErrorIcon');

            toastMessage.textContent = message;
            
            if (type === 'success') {
                toastContent.className = 'rounded-lg shadow-lg p-4 text-white bg-green-500';
                successIcon.classList.remove('hidden');
                errorIcon.classList.add('hidden');
            } else {
                toastContent.className = 'rounded-lg shadow-lg p-4 text-white bg-red-500';
                successIcon.classList.add('hidden');
                errorIcon.classList.remove('hidden');
            }

            toast.classList.add('show');
            
            setTimeout(() => {
                hideToast();
            }, 3000);
        }

        function hideToast() {
            document.getElementById('toast').classList.remove('show');
        }
    </script>
</body>
</html>
