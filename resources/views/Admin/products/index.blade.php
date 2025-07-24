<x-layouts.app :title="__('Products Management')">
    <div x-data="productsCrud()" x-cloak class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-white">
                                <h1 class="text-3xl font-bold flex items-center">
                                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Products Management
                                </h1>
                                <p class="text-blue-100 mt-1">Manage your product inventory with ease</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <button @click="openCreateModal()" 
                                        class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Product
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="products.length">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">In Stock</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="inStockCount">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Low Stock</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="lowStockCount">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Categories</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="categories.length">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" 
                                   x-model="searchTerm"
                                   @input="filterProducts()"
                                   placeholder="Search products..." 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <select x-model="categoryFilter" 
                                @change="filterProducts()"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">All Categories</option>
                            <template x-for="category in categories" :key="category.id">
                                <option :value="category.slug" x-text="category.name"></option>
                            </template>
                        </select>
                        
                        <select x-model="stockFilter" 
                                @change="filterProducts()"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">All Stock Levels</option>
                            <option value="in_stock">In Stock</option>
                            <option value="low_stock">Low Stock</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Products Inventory</h3>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="product in paginatedProducts" :key="product.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <!-- Product Info with Image -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img :src="product.image || 'https://via.placeholder.com/48x48/e5e7eb/6b7280?text=No+Image'" 
                                                     :alt="product.name" 
                                                     class="h-12 w-12 rounded-lg object-cover border border-gray-200 dark:border-gray-600">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white line-clamp-1" x-text="product.name"></div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400 line-clamp-1" x-text="product.description || 'No description'"></div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Category -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300" x-text="product.category || 'Uncategorized'"></span>
                                    </td>
                                    
                                    <!-- Price -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(product.price || 0).toFixed(2)"></div>
                                    </td>
                                    
                                    <!-- Stock -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="product.stock"></div>
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="getStockBadgeClass(product.stock)" 
                                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" 
                                              x-text="getStockStatus(product.stock)"></span>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button @click="openEditModal(product)" 
                                                    class="inline-flex items-center p-2 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200"
                                                    title="Edit Product">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button @click="openDeleteModal(product)" 
                                                    class="inline-flex items-center p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200"
                                                    title="Delete Product">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Card View (visible on mobile only) -->
            <div class="md:hidden grid grid-cols-1 gap-4">
                <template x-for="product in paginatedProducts" :key="product.id">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden h-32">
                            <img :src="product.image || 'https://via.placeholder.com/300x200/e5e7eb/6b7280?text=No+Image'" 
                                 :alt="product.name" 
                                 class="w-full h-full object-cover">
                            <div class="absolute top-2 right-2">
                                <span :class="getStockBadgeClass(product.stock)" 
                                      class="px-2 py-1 text-xs font-semibold rounded-full" 
                                      x-text="getStockStatus(product.stock)"></span>
                            </div>
                        </div>
                        
                        <!-- Product Details -->
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-bold text-base text-gray-900 dark:text-white line-clamp-1" x-text="product.name"></h3>
                                <span class="text-xs px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full ml-2" x-text="product.category || 'Uncategorized'"></span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-1" x-text="product.description || 'No description'"></p>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xl font-bold text-blue-600 dark:text-blue-400" x-text="'$' + parseFloat(product.price || 0).toFixed(2)"></span>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Stock: <span x-text="product.stock" class="font-medium"></span></span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button @click="openEditModal(product)" 
                                        class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 dark:text-blue-400 px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button @click="openDeleteModal(product)" 
                                        class="flex-1 bg-red-50 hover:bg-red-100 text-red-700 dark:bg-red-900/20 dark:hover:bg-red-900/30 dark:text-red-400 px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Pagination -->
            <div x-show="totalPages > 1" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mt-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Pagination Info -->
                    <div class="text-sm text-gray-700 dark:text-gray-300">
                        Showing <span class="font-medium" x-text="startIndex + 1"></span> to <span class="font-medium" x-text="Math.min(endIndex, filteredProducts.length)"></span> of <span class="font-medium" x-text="filteredProducts.length"></span> products
                    </div>
                    
                    <!-- Pagination Controls -->
                    <div class="flex items-center space-x-2">
                        <!-- Previous Button -->
                        <button @click="previousPage()" 
                                :disabled="currentPage === 1"
                                :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous
                        </button>
                        
                        <!-- Page Numbers -->
                        <div class="flex items-center space-x-1">
                            <template x-for="page in visiblePages" :key="page">
                                <button @click="goToPage(page)" 
                                        :class="page === currentPage ? 'bg-blue-600 text-white border-blue-600' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                        class="inline-flex items-center justify-center w-10 h-10 border rounded-lg text-sm font-medium transition-colors"
                                        x-text="page"></button>
                            </template>
                        </div>
                        
                        <!-- Next Button -->
                        <button @click="nextPage()" 
                                :disabled="currentPage === totalPages"
                                :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                                class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 transition-colors">
                            Next
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div x-show="filteredProducts.length === 0" class="text-center py-12">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-12 shadow-lg border border-gray-200 dark:border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No products found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first product or adjust your search filters.</p>
                    <button @click="openCreateModal()" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Product
                    </button>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div x-show="showModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             @keydown.escape.window="closeModal()">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity"
                     @click="closeModal()"></div>

                <!-- Modal -->
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    
                    <form @submit.prevent="submitForm()">
                        <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                            <!-- Modal Header -->
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span x-text="editingProduct ? 'Edit Product' : 'Create New Product'"></span>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Fill in the product details below</p>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Product Name *</label>
                                    <input type="text" 
                                           x-model="form.name"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                           placeholder="Enter product name">
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                    <textarea x-model="form.description"
                                              rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                              placeholder="Enter product description"></textarea>
                                </div>

                                <!-- Price -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Price *</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-gray-500 dark:text-gray-400">$</span>
                                        <input type="number" 
                                               x-model="form.price"
                                               step="0.01"
                                               min="0"
                                               required
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                               placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Stock -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Stock Quantity *</label>
                                    <input type="number" 
                                           x-model="form.stock"
                                           min="0"
                                           required
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                           placeholder="0">
                                </div>

                                <!-- Category -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                                    <select x-model="form.category_id"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        <option value="">Select category</option>
                                        <template x-for="category in categories" :key="category.id">
                                            <option :value="category.id" x-text="category.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Image Upload -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Product Image</label>
                                    <input type="file" 
                                           @change="handleFileUpload"
                                           accept="image/*"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Upload a product image (JPG, PNG, GIF - Max 2MB)</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                            <button type="button" 
                                    @click="closeModal()"
                                    class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-6 py-3 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    :disabled="loading"
                                    class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-transparent bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                                <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-text="loading ? 'Processing...' : (editingProduct ? 'Update Product' : 'Create Product')"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" 
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             @keydown.escape.window="closeDeleteModal()">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div x-show="showDeleteModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm transition-opacity"
                     @click="closeDeleteModal()"></div>

                <!-- Modal -->
                <div x-show="showDeleteModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Delete Product</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete "<span x-text="productToDelete?.name" class="font-semibold"></span>"? This action cannot be undone and will permanently remove the product from your inventory.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3">
                        <button @click="closeDeleteModal()" 
                                class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-6 py-3 text-base font-medium text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                            Cancel
                        </button>
                        <button @click="confirmDelete()" 
                                :disabled="loading"
                                class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-transparent bg-red-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                            <svg x-show="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="loading ? 'Deleting...' : 'Delete Product'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div x-show="showToast" 
             x-cloak
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50 max-w-sm w-full">
            <div :class="toastType === 'success' ? 'bg-green-500' : 'bg-red-500'" 
                 class="rounded-lg shadow-lg p-4 text-white">
                <div class="flex items-center">
                    <svg x-show="toastType === 'success'" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <svg x-show="toastType === 'error'" class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span x-text="toastMessage" class="flex-1"></span>
                    <button @click="showToast = false" class="ml-4 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function productsCrud() {
        return {
            // Data
            products: [],
            categories: @json($categories ?? []),
            filteredProducts: [],
            
            // Pagination
            currentPage: 1,
            itemsPerPage: 8,
            
            // UI State
            showModal: false,
            showDeleteModal: false,
            showToast: false,
            loading: false,
            editingProduct: null,
            productToDelete: null,
            
            // Filters
            searchTerm: '',
            categoryFilter: '',
            stockFilter: '',
            
            // Form
            form: {
                name: '',
                description: '',
                price: '',
                stock: '',
                category_id: '',
                image: null
            },
            
            // Toast
            toastMessage: '',
            toastType: 'success',
            
            // Computed Properties
            get inStockCount() {
                return this.products.filter(p => p.stock > 10).length;
            },
            
            get lowStockCount() {
                return this.products.filter(p => p.stock > 0 && p.stock <= 10).length;
            },
            
            get totalPages() {
                return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
            },
            
            get startIndex() {
                return (this.currentPage - 1) * this.itemsPerPage;
            },
            
            get endIndex() {
                return this.startIndex + this.itemsPerPage;
            },
            
            get paginatedProducts() {
                return this.filteredProducts.slice(this.startIndex, this.endIndex);
            },
            
            get visiblePages() {
                const pages = [];
                const start = Math.max(1, this.currentPage - 2);
                const end = Math.min(this.totalPages, this.currentPage + 2);
                
                for (let i = start; i <= end; i++) {
                    pages.push(i);
                }
                
                return pages;
            },
            
            // Methods
            async init() {
                await this.loadProducts();
            },
            
            async loadProducts() {
                try {
                    this.loading = true;
                    const response = await fetch('{{ route("admin.products.data") }}');
                    const data = await response.json();
                    
                    this.products = data.products || [];
                    this.filteredProducts = [...this.products];
                    this.resetPagination();
                } catch (error) {
                    this.showToastMessage('Failed to load products', 'error');
                    console.error('Error loading products:', error);
                } finally {
                    this.loading = false;
                }
            },
            
            filterProducts() {
                let filtered = [...this.products];
                
                // Search filter
                if (this.searchTerm) {
                    filtered = filtered.filter(product => 
                        product.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        product.description.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }
                
                // Category filter
                if (this.categoryFilter) {
                    filtered = filtered.filter(product => 
                        product.category && product.category.toLowerCase().includes(this.categoryFilter.toLowerCase())
                    );
                }
                
                // Stock filter
                if (this.stockFilter) {
                    switch (this.stockFilter) {
                        case 'in_stock':
                            filtered = filtered.filter(p => p.stock > 10);
                            break;
                        case 'low_stock':
                            filtered = filtered.filter(p => p.stock > 0 && p.stock <= 10);
                            break;
                        case 'out_of_stock':
                            filtered = filtered.filter(p => p.stock === 0);
                            break;
                    }
                }
                
                this.filteredProducts = filtered;
                this.resetPagination();
            },
            
            // Pagination Methods
            resetPagination() {
                this.currentPage = 1;
            },
            
            goToPage(page) {
                if (page >= 1 && page <= this.totalPages) {
                    this.currentPage = page;
                }
            },
            
            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                }
            },
            
            previousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                }
            },
            
            getStockStatus(stock) {
                if (stock <= 0) return 'Out of Stock';
                if (stock <= 10) return 'Low Stock';
                return 'In Stock';
            },
            
            getStockBadgeClass(stock) {
                if (stock <= 0) return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300';
                if (stock <= 10) return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300';
                return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300';
            },
            
            openCreateModal() {
                this.editingProduct = null;
                this.resetForm();
                this.showModal = true;
            },
            
            async openEditModal(product) {
                try {
                    this.loading = true;
                    const response = await fetch(`{{ route("admin.products.show", ["product" => ":id"]) }}`.replace(':id', product.id));
                    const productData = await response.json();
                    
                    this.editingProduct = productData;
                    this.form = {
                        name: productData.name,
                        description: productData.description,
                        price: productData.price,
                        stock: productData.stock,
                        category_id: productData.category_id,
                        image: null
                    };
                    this.showModal = true;
                } catch (error) {
                    this.showToastMessage('Failed to load product details', 'error');
                } finally {
                    this.loading = false;
                }
            },
            
            closeModal() {
                this.showModal = false;
                this.editingProduct = null;
                this.resetForm();
            },
            
            resetForm() {
                this.form = {
                    name: '',
                    description: '',
                    price: '',
                    stock: '',
                    category_id: '',
                    image: null
                };
            },
            
            async submitForm() {
                this.loading = true;
                
                try {
                    const formData = new FormData();
                    formData.append('name', this.form.name);
                    formData.append('description', this.form.description);
                    formData.append('price', this.form.price);
                    formData.append('stock', this.form.stock);
                    formData.append('category_id', this.form.category_id);
                    
                    if (this.form.image) {
                        formData.append('image', this.form.image);
                    }
                    
                    let url, method;
                    if (this.editingProduct) {
                        url = `{{ route("admin.products.update", ["product" => ":id"]) }}`.replace(':id', this.editingProduct.id);
                        method = 'POST';
                        formData.append('_method', 'PUT');
                    } else {
                        url = '{{ route("admin.products.store") }}';
                        method = 'POST';
                    }
                    
                    formData.append('_token', '{{ csrf_token() }}');
                    
                    const response = await fetch(url, {
                        method: method,
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.showToastMessage(result.message, 'success');
                        await this.loadProducts();
                        this.closeModal();
                    } else {
                        this.showToastMessage(result.message || 'Something went wrong!', 'error');
                    }
                } catch (error) {
                    this.showToastMessage('Network error occurred!', 'error');
                    console.error('Submit error:', error);
                } finally {
                    this.loading = false;
                }
            },
            
            openDeleteModal(product) {
                this.productToDelete = product;
                this.showDeleteModal = true;
            },
            
            closeDeleteModal() {
                this.showDeleteModal = false;
                this.productToDelete = null;
            },
            
            async confirmDelete() {
                if (!this.productToDelete) {
                    this.showToastMessage('No product selected for deletion', 'error');
                    return;
                }
                
                this.loading = true;
                
                try {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('_method', 'DELETE');
                    
                    const response = await fetch(`/admin/products/${this.productToDelete.id}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        this.showToastMessage(result.message || 'Product deleted successfully!', 'success');
                        await this.loadProducts();
                        this.closeDeleteModal();
                    } else {
                        this.showToastMessage(result.message || 'Failed to delete product!', 'error');
                    }
                } catch (error) {
                    this.showToastMessage('Network error occurred!', 'error');
                    console.error('Delete error:', error);
                } finally {
                    this.loading = false;
                }
            },
            
            showToastMessage(message, type = 'success') {
                this.toastMessage = message;
                this.toastType = type;
                this.showToast = true;
                setTimeout(() => {
                    this.showToast = false;
                }, 5000);
            },
            
            handleFileUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.form.image = file;
                }
            }
        };
    }
    </script>

    <style>
    [x-cloak] { display: none !important; }
    
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    </style>
</x-layouts.app>
