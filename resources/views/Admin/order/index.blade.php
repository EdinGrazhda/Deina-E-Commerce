<x-layouts.app :title="__('Orders Management')">
    <div x-data="orderCrud()" x-cloak class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-slate-900">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-white">
                                <h1 class="text-3xl font-bold flex items-center">
                                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Orders Management
                                </h1>
                                <p class="text-blue-100 mt-1">Manage customer orders and transactions</p>
                            </div>
                            <div class="mt-4 sm:mt-0">
                                <button @click="openCreateModal()" 
                                        class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Create Order
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="orders.length">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="'$' + totalRevenue.toFixed(2)">$0.00</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Orders</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="pendingOrders">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Avg Order Value</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white" x-text="'$' + averageOrderValue.toFixed(2)">$0.00</p>
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
                                   @input="filterOrders()"
                                   placeholder="Search orders by ID, customer..." 
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                            <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <select x-model="statusFilter" 
                                @change="filterOrders()"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        
                        <select x-model="sortBy" 
                                @change="filterOrders()"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="created_at">Sort by Date</option>
                            <option value="total_price">Sort by Total</option>
                            <option value="user_name">Sort by Customer</option>
                            <option value="status">Sort by Status</option>
                        </select>
                        
                        <select x-model="sortOrder" 
                                @change="filterOrders()"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="desc">Newest First</option>
                            <option value="asc">Oldest First</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="hidden md:block bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Orders Overview</h3>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="order in paginatedOrders" :key="order.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <!-- Order Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="'#' + order.id"></div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400" x-text="order.created_at"></div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Customer -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="order.user_name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="order.user_email"></div>
                                    </td>
                                    
                                    <!-- Total -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white" x-text="'$' + parseFloat(order.total_price).toFixed(2)"></div>
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="getStatusClass(order.status)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" x-text="order.status_label"></span>
                                    </td>
                                    
                                    <!-- Items -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white" x-text="order.order_items_count + ' item(s)'"></div>
                                    </td>
                                    
                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="order.created_at"></div>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button @click="openEditModal(order)" 
                                                    class="inline-flex items-center p-2 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200"
                                                    title="Edit Order">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button @click="openDeleteModal(order)" 
                                                    class="inline-flex items-center p-2 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200"
                                                    title="Delete Order">
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
                <template x-for="order in paginatedOrders" :key="order.id">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-lg bg-white/20 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="font-bold text-lg text-white" x-text="'Order #' + order.id"></h3>
                                        <p class="text-blue-100 text-sm" x-text="'$' + parseFloat(order.total_price).toFixed(2)"></p>
                                    </div>
                                </div>
                                <span :class="getStatusClass(order.status)" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" x-text="order.status_label"></span>
                            </div>
                        </div>
                        
                        <!-- Order Details -->
                        <div class="p-4">
                            <div class="mb-3">
                                <p class="font-medium text-gray-900 dark:text-white" x-text="order.user_name"></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400" x-text="order.user_email"></p>
                            </div>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400" x-text="order.order_items_count + ' items'"></span>
                                <span class="text-sm text-gray-500 dark:text-gray-400" x-text="order.created_at"></span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button @click="openEditModal(order)" 
                                        class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 dark:text-blue-400 px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button @click="openDeleteModal(order)" 
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
                        Showing <span class="font-medium" x-text="startIndex + 1"></span> to <span class="font-medium" x-text="Math.min(endIndex, filteredOrders.length)"></span> of <span class="font-medium" x-text="filteredOrders.length"></span> orders
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
            <div x-show="filteredOrders.length === 0" class="text-center py-12">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-12 shadow-lg border border-gray-200 dark:border-gray-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No orders found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by creating your first order or check your search filters.</p>
                    <button @click="openCreateModal()" 
                            class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create Order
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
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    
                    <form @submit.prevent="submitForm()">
                        <div class="bg-white dark:bg-gray-800 px-6 pt-6 pb-4">
                            <!-- Modal Header -->
                            <div class="mb-6">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span x-text="editingOrder ? 'Edit Order' : 'Create New Order'"></span>
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">Fill in the order details below</p>
                            </div>
                            
                            <div class="space-y-6">
                                <!-- Customer -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Customer *</label>
                                    <select x-model="form.user_id"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        <option value="">Select a customer</option>
                                        <template x-for="user in users" :key="user.id">
                                            <option :value="user.id" x-text="user.name + ' (' + user.email + ')'"></option>
                                        </template>
                                    </select>
                                </div>

                                <!-- Total Price -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Total Price *</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-3 text-gray-500">$</span>
                                        <input type="number" 
                                               x-model="form.total_price"
                                               step="0.01"
                                               min="0"
                                               max="999999.99"
                                               required
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                                               placeholder="0.00">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Status *</label>
                                    <select x-model="form.status"
                                            required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                                        <option value="">Select status</option>
                                        <template x-for="status in statuses" :key="status.value">
                                            <option :value="status.value" x-text="status.label"></option>
                                        </template>
                                    </select>
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
                                <span x-text="loading ? 'Processing...' : (editingOrder ? 'Update Order' : 'Create Order')"></span>
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
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Delete Order</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete Order <span x-text="'#' + (orderToDelete?.id || '')" class="font-semibold"></span>? This action cannot be undone and will permanently remove the order from the system.
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
                            <span x-text="loading ? 'Deleting...' : 'Delete Order'"></span>
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
    function orderCrud() {
        return {
            // Data
            orders: [],
            filteredOrders: [],
            users: [],
            statuses: [],
            
            // Pagination
            currentPage: 1,
            itemsPerPage: 8,
            
            // UI State
            showModal: false,
            showDeleteModal: false,
            showToast: false,
            loading: false,
            editingOrder: null,
            orderToDelete: null,
            
            // Filters
            searchTerm: '',
            statusFilter: '',
            sortBy: 'created_at',
            sortOrder: 'desc',
            
            // Form
            form: {
                user_id: '',
                total_price: '',
                status: ''
            },
            
            // Toast
            toastMessage: '',
            toastType: 'success',
            
            // Computed Properties
            get totalRevenue() {
                return this.orders.reduce((sum, order) => sum + parseFloat(order.total_price || 0), 0);
            },
            
            get pendingOrders() {
                return this.orders.filter(order => order.status === 'pending').length;
            },
            
            get averageOrderValue() {
                if (this.orders.length === 0) return 0;
                return this.totalRevenue / this.orders.length;
            },
            
            get totalPages() {
                return Math.ceil(this.filteredOrders.length / this.itemsPerPage);
            },
            
            get startIndex() {
                return (this.currentPage - 1) * this.itemsPerPage;
            },
            
            get endIndex() {
                return this.startIndex + this.itemsPerPage;
            },
            
            get paginatedOrders() {
                return this.filteredOrders.slice(this.startIndex, this.endIndex);
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
                await Promise.all([
                    this.loadOrders(),
                    this.loadUsers(),
                    this.loadStatuses()
                ]);
            },
            
            async loadOrders() {
                try {
                    this.loading = true;
                    console.log('Loading orders...');
                    const response = await fetch('/admin/orders/data');
                    console.log('Response status:', response.status);
                    const data = await response.json();
                    console.log('Response data:', data);
                    
                    this.orders = data.orders || [];
                    this.filteredOrders = [...this.orders];
                    this.resetPagination();
                    console.log('Orders loaded:', this.orders.length);
                } catch (error) {
                    this.showToastMessage('Failed to load orders', 'error');
                    console.error('Error loading orders:', error);
                } finally {
                    this.loading = false;
                }
            },
            
            async loadUsers() {
                try {
                    const response = await fetch('/admin/orders/users');
                    const data = await response.json();
                    this.users = data.users || [];
                } catch (error) {
                    console.error('Error loading users:', error);
                }
            },
            
            async loadStatuses() {
                try {
                    const response = await fetch('/admin/orders/statuses');
                    const data = await response.json();
                    this.statuses = data.statuses || [];
                } catch (error) {
                    console.error('Error loading statuses:', error);
                }
            },
            
            filterOrders() {
                let filtered = [...this.orders];
                
                // Search filter
                if (this.searchTerm) {
                    filtered = filtered.filter(order => 
                        order.id.toString().includes(this.searchTerm) ||
                        order.user_name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        order.user_email.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }
                
                // Status filter
                if (this.statusFilter) {
                    filtered = filtered.filter(order => order.status === this.statusFilter);
                }
                
                // Sort
                filtered.sort((a, b) => {
                    let aVal = a[this.sortBy];
                    let bVal = b[this.sortBy];
                    
                    if (this.sortBy === 'total_price') {
                        aVal = parseFloat(aVal || 0);
                        bVal = parseFloat(bVal || 0);
                    } else if (this.sortBy === 'created_at') {
                        aVal = new Date(aVal);
                        bVal = new Date(bVal);
                    } else {
                        aVal = (aVal || '').toString().toLowerCase();
                        bVal = (bVal || '').toString().toLowerCase();
                    }
                    
                    if (this.sortOrder === 'desc') {
                        return bVal > aVal ? 1 : -1;
                    } else {
                        return aVal > bVal ? 1 : -1;
                    }
                });
                
                this.filteredOrders = filtered;
                this.resetPagination();
            },
            
            getStatusClass(status) {
                const classes = {
                    'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300',
                    'processing': 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300',
                    'shipped': 'bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300',
                    'completed': 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300',
                    'cancelled': 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300'
                };
                return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300';
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
            
            openCreateModal() {
                this.editingOrder = null;
                this.resetForm();
                this.showModal = true;
            },
            
            async openEditModal(order) {
                try {
                    this.loading = true;
                    const response = await fetch(`/admin/orders/${order.id}`);
                    const orderData = await response.json();
                    
                    this.editingOrder = orderData;
                    this.form = {
                        user_id: orderData.user_id,
                        total_price: orderData.total_price,
                        status: orderData.status
                    };
                    this.showModal = true;
                } catch (error) {
                    this.showToastMessage('Failed to load order details', 'error');
                } finally {
                    this.loading = false;
                }
            },
            
            closeModal() {
                this.showModal = false;
                this.editingOrder = null;
                this.resetForm();
            },
            
            resetForm() {
                this.form = {
                    user_id: '',
                    total_price: '',
                    status: ''
                };
            },
            
            async submitForm() {
                this.loading = true;
                
                try {
                    const formData = new FormData();
                    formData.append('user_id', this.form.user_id);
                    formData.append('total_price', this.form.total_price);
                    formData.append('status', this.form.status);
                    
                    let url, method;
                    if (this.editingOrder) {
                        url = `/admin/orders/${this.editingOrder.id}`;
                        method = 'POST';
                        formData.append('_method', 'PUT');
                    } else {
                        url = '/admin/orders';
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
                        await this.loadOrders();
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
            
            openDeleteModal(order) {
                this.orderToDelete = order;
                this.showDeleteModal = true;
            },
            
            closeDeleteModal() {
                this.showDeleteModal = false;
                this.orderToDelete = null;
            },
            
            async confirmDelete() {
                if (!this.orderToDelete) {
                    this.showToastMessage('No order selected for deletion', 'error');
                    return;
                }
                
                this.loading = true;
                
                try {
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('_method', 'DELETE');
                    
                    const response = await fetch(`/admin/orders/${this.orderToDelete.id}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        this.showToastMessage(result.message || 'Order deleted successfully!', 'success');
                        await this.loadOrders();
                        this.closeDeleteModal();
                    } else {
                        this.showToastMessage(result.message || 'Failed to delete order!', 'error');
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
            }
        };
    }
    </script>

    <style>
    [x-cloak] { display: none !important; }
    </style>
</x-layouts.app>
