<x-layouts.app :title="__('Orders Management')">
    <div x-data="ordersCrud()" x-cloak class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-slate-900">
        <div class="container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div class="text-white">
                                <h1 class="text-3xl font-bold flex items-center">
                                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Orders Management
                                </h1>
                                <p class="text-blue-100 mt-1">Manage customer orders and track business performance</p>
                            </div>
                            <div class="mt-4 sm:mt-0 flex gap-3">
                                <button @click="refreshOrders()" 
                                        class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Refresh Orders
                                </button>
                                <button @click="exportOrders()" 
                                        class="bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Export Data
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
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
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">$<span x-text="totalRevenue.toFixed(2)">0.00</span></p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed Orders</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="completedOrders">0</p>
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
                                   placeholder="Search orders, customers, email..." 
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
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        
                        <select x-model="paymentFilter" 
                                @change="filterOrders()"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">All Payment Methods</option>
                            <option value="cash">Cash on Delivery</option>
                            <option value="stripe">Credit/Debit Card</option>
                        </select>
                        
                        <select x-model="sortBy" 
                                @change="filterOrders()"
                                class="px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="created_at">Sort by Date</option>
                            <option value="total">Sort by Total Amount</option>
                            <option value="customer_name">Sort by Customer</option>
                            <option value="order_number">Sort by Order Number</option>
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

                <!-- Empty State -->
                <div x-show="paginatedOrders.length === 0" class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No orders found</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Get started by receiving your first customer order!</p>
                    <div class="mt-6">
                        <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            View Store Front
                        </a>
                    </div>
                </div>

                <!-- Table Container -->
                <div x-show="paginatedOrders.length > 0" class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Order Details</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <template x-for="order in paginatedOrders" :key="order.id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                    <!-- Order Details -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="order.order_number || '#' + order.id"></div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400" x-text="formatDate(order.created_at)"></div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Customer -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="order.customer_name || order.name"></div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400" x-text="order.customer_email || order.email"></div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500" x-text="order.customer_phone || order.phone"></div>
                                    </td>
                                    
                                    <!-- Items -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            <span x-text="order.total_items || (order.order_items ? order.order_items.length : 'N/A')"></span> item(s)
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400" x-text="getItemPreview(order)"></div>
                                    </td>
                                    
                                    <!-- Payment -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="getPaymentBadgeClass(order.payment_method)" 
                                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            <span x-text="getPaymentMethodText(order.payment_method)"></span>
                                        </span>
                                    </td>
                                    
                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="getStatusBadgeClass(order.status)" 
                                              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                            <span x-text="getStatusText(order.status)"></span>
                                        </span>
                                    </td>
                                    
                                    <!-- Total -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-lg font-bold text-gray-900 dark:text-white">$<span x-text="parseFloat(order.total || 0).toFixed(2)"></span></div>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <button @click="viewOrder(order)" 
                                                    class="inline-flex items-center p-2 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-all duration-200"
                                                    title="View Order Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </button>
                                            <button @click="updateOrderStatus(order)" 
                                                    class="inline-flex items-center p-2 text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-all duration-200"
                                                    title="Update Status">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            <button @click="printInvoice(order)" 
                                                    class="inline-flex items-center p-2 text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-all duration-200"
                                                    title="Print Invoice">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
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
            <div class="md:hidden">
                <!-- Empty State for Mobile -->
                <div x-show="paginatedOrders.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No orders yet</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Your first customer order will appear here.</p>
                </div>
                
                <!-- Orders Grid -->
                <div x-show="paginatedOrders.length > 0" class="grid grid-cols-1 gap-4">
                <template x-for="order in paginatedOrders" :key="order.id">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-200 dark:border-gray-700">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-lg bg-white/20 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="font-bold text-lg text-white" x-text="order.order_number || '#' + order.id"></h3>
                                        <p class="text-blue-100 text-sm" x-text="formatDate(order.created_at)"></p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-white">$<span x-text="parseFloat(order.total || 0).toFixed(2)"></span></div>
                                    <span :class="getStatusBadgeClass(order.status)" 
                                          class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium">
                                        <span x-text="getStatusText(order.status)"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Details -->
                        <div class="p-4">
                            <!-- Customer Info -->
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Customer Information</h4>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p><strong>Name:</strong> <span x-text="order.customer_name || order.name"></span></p>
                                    <p><strong>Email:</strong> <span x-text="order.customer_email || order.email"></span></p>
                                    <p><strong>Phone:</strong> <span x-text="order.customer_phone || order.phone"></span></p>
                                </div>
                            </div>
                            
                            <!-- Order Items -->
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Order Items</h4>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <span x-text="order.total_items || (order.order_items ? order.order_items.length : 'N/A')"></span> item(s) - 
                                    <span x-text="getItemPreview(order)"></span>
                                </div>
                            </div>
                            
                            <!-- Payment Method -->
                            <div class="mb-4">
                                <span :class="getPaymentBadgeClass(order.payment_method)" 
                                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                    <span x-text="getPaymentMethodText(order.payment_method)"></span>
                                </span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button @click="viewOrder(order)" 
                                        class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-700 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 dark:text-blue-400 px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </button>
                                <button @click="updateOrderStatus(order)" 
                                        class="flex-1 bg-green-50 hover:bg-green-100 text-green-700 dark:bg-green-900/20 dark:hover:bg-green-900/30 dark:text-green-400 px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Update
                                </button>
                                <button @click="printInvoice(order)" 
                                        class="flex-1 bg-purple-50 hover:bg-purple-100 text-purple-700 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 dark:text-purple-400 px-3 py-2 rounded-lg font-medium transition-all duration-200 text-sm">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Print
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

            <!-- Quick Actions Footer -->
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Manage your orders efficiently</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button @click="markAllAsProcessed()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Mark All as Processed
                        </button>
                        <button @click="sendBulkEmails()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Send Bulk Emails
                        </button>
                        <button @click="generateReport()" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Script -->
    <script>
        function ordersCrud() {
            return {
                orders: [],
                filteredOrders: [],
                paginatedOrders: [],
                searchTerm: '',
                statusFilter: '',
                paymentFilter: '',
                sortBy: 'created_at',
                sortOrder: 'desc',
                currentPage: 1,
                itemsPerPage: 10,
                totalPages: 1,
                startIndex: 0,
                endIndex: 0,
                loading: false,
                
                // Computed properties
                get totalRevenue() {
                    return this.orders.reduce((sum, order) => sum + parseFloat(order.total || 0), 0);
                },
                
                get pendingOrders() {
                    return this.orders.filter(order => order.status === 'pending').length;
                },
                
                get completedOrders() {
                    return this.orders.filter(order => order.status === 'delivered' || order.status === 'completed').length;
                },
                
                get visiblePages() {
                    const pages = [];
                    const maxVisible = 5;
                    let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
                    let end = Math.min(this.totalPages, start + maxVisible - 1);
                    
                    if (end - start + 1 < maxVisible) {
                        start = Math.max(1, end - maxVisible + 1);
                    }
                    
                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }
                    return pages;
                },

                init() {
                    this.loadOrders();
                },

                async loadOrders() {
                    this.loading = true;
                    try {
                        const response = await fetch('/admin/orders/data');
                        if (response.ok) {
                            const data = await response.json();
                            this.orders = data.orders || [];
                            this.filterOrders();
                        } else {
                            console.error('Failed to load orders');
                        }
                    } catch (error) {
                        console.error('Error loading orders:', error);
                    } finally {
                        this.loading = false;
                    }
                },

                filterOrders() {
                    let filtered = [...this.orders];
                    
                    // Search filter
                    if (this.searchTerm) {
                        const term = this.searchTerm.toLowerCase();
                        filtered = filtered.filter(order => 
                            (order.order_number && order.order_number.toLowerCase().includes(term)) ||
                            (order.customer_name && order.customer_name.toLowerCase().includes(term)) ||
                            (order.customer_email && order.customer_email.toLowerCase().includes(term)) ||
                            (order.name && order.name.toLowerCase().includes(term)) ||
                            (order.email && order.email.toLowerCase().includes(term)) ||
                            order.id.toString().includes(term)
                        );
                    }
                    
                    // Status filter
                    if (this.statusFilter) {
                        filtered = filtered.filter(order => order.status === this.statusFilter);
                    }
                    
                    // Payment filter
                    if (this.paymentFilter) {
                        filtered = filtered.filter(order => order.payment_method === this.paymentFilter);
                    }
                    
                    // Sort
                    filtered.sort((a, b) => {
                        let aVal = a[this.sortBy] || '';
                        let bVal = b[this.sortBy] || '';
                        
                        if (this.sortBy === 'total') {
                            aVal = parseFloat(aVal) || 0;
                            bVal = parseFloat(bVal) || 0;
                        }
                        
                        if (this.sortOrder === 'asc') {
                            return aVal > bVal ? 1 : -1;
                        } else {
                            return aVal < bVal ? 1 : -1;
                        }
                    });
                    
                    this.filteredOrders = filtered;
                    this.totalPages = Math.ceil(filtered.length / this.itemsPerPage);
                    this.currentPage = 1;
                    this.updatePagination();
                },

                updatePagination() {
                    this.startIndex = (this.currentPage - 1) * this.itemsPerPage;
                    this.endIndex = this.startIndex + this.itemsPerPage;
                    this.paginatedOrders = this.filteredOrders.slice(this.startIndex, this.endIndex);
                },

                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.updatePagination();
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                        this.updatePagination();
                    }
                },

                goToPage(page) {
                    this.currentPage = page;
                    this.updatePagination();
                },

                formatDate(dateString) {
                    if (!dateString) return 'N/A';
                    const date = new Date(dateString);
                    return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                },

                getStatusBadgeClass(status) {
                    const classes = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'processing': 'bg-blue-100 text-blue-800',
                        'shipped': 'bg-purple-100 text-purple-800',
                        'delivered': 'bg-green-100 text-green-800',
                        'completed': 'bg-green-100 text-green-800',
                        'cancelled': 'bg-red-100 text-red-800'
                    };
                    return classes[status] || 'bg-gray-100 text-gray-800';
                },

                getStatusText(status) {
                    const texts = {
                        'pending': 'Pending',
                        'processing': 'Processing',
                        'shipped': 'Shipped',
                        'delivered': 'Delivered',
                        'completed': 'Completed',
                        'cancelled': 'Cancelled'
                    };
                    return texts[status] || 'Unknown';
                },

                getPaymentBadgeClass(method) {
                    const classes = {
                        'cash': 'bg-green-100 text-green-800',
                        'stripe': 'bg-blue-100 text-blue-800',
                        'credit_card': 'bg-blue-100 text-blue-800'
                    };
                    return classes[method] || 'bg-gray-100 text-gray-800';
                },

                getPaymentMethodText(method) {
                    const texts = {
                        'cash': 'Cash on Delivery',
                        'stripe': 'Credit/Debit Card',
                        'credit_card': 'Credit Card'
                    };
                    return texts[method] || 'Unknown';
                },

                getItemPreview(order) {
                    if (order.order_items && order.order_items.length > 0) {
                        const firstItem = order.order_items[0];
                        const itemName = firstItem.product_name || (firstItem.product ? firstItem.product.name : 'Unknown Product');
                        const more = order.order_items.length > 1 ? ` +${order.order_items.length - 1} more` : '';
                        return itemName + more;
                    }
                    if (order.items_preview && order.items_preview !== '') {
                        return order.items_preview;
                    }
                    return 'No items';
                },

                viewOrder(order) {
                    window.location.href = `/admin/orders/${order.id}`;
                },

                updateOrderStatus(order) {
                    // Implementation for status update modal
                    alert('Status update functionality to be implemented');
                },

                printInvoice(order) {
                    // Implementation for invoice printing
                    window.print();
                },

                refreshOrders() {
                    this.loadOrders();
                },

                exportOrders() {
                    // Implementation for data export
                    alert('Export functionality to be implemented');
                },

                markAllAsProcessed() {
                    // Implementation for bulk status update
                    alert('Bulk processing functionality to be implemented');
                },

                sendBulkEmails() {
                    // Implementation for bulk email sending
                    alert('Bulk email functionality to be implemented');
                },

                generateReport() {
                    // Implementation for report generation
                    alert('Report generation functionality to be implemented');
                }
            }
        }
    </script>
</x-layouts.app>
