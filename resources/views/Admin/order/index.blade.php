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

                <!-- Table Container -->
                <div class="overflow-x-auto">
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
                                        <div class="text-xs text-gray-400 dark:text-gray-500" x-text="'📍 ' + (order.city || 'N/A')"></div>
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
            <div class="md:hidden grid grid-cols-1 gap-4">
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
                                    <p><strong>City:</strong> <span x-text="order.city || 'N/A'"></span></p>
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

        <!-- Status Update Modal -->
        <div x-show="showStatusModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
             @click.self="cancelStatusUpdate()">
            
            <div x-show="showStatusModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
                
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Update Order Status</h3>
                        <button @click="cancelStatusUpdate()" 
                                class="text-white hover:text-gray-200 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div x-show="selectedOrder" class="space-y-4">
                        <!-- Order Info -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Order Information</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                <span class="font-medium">Order #:</span> 
                                <span x-text="selectedOrder?.order_number"></span>
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                <span class="font-medium">Customer:</span> 
                                <span x-text="selectedOrder?.customer_name"></span>
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                <span class="font-medium">Current Status:</span> 
                                <span :class="getStatusBadgeClass(selectedOrder?.status)" 
                                      class="inline-block px-2 py-1 text-xs font-medium rounded-full ml-2">
                                    <span x-text="getStatusText(selectedOrder?.status)"></span>
                                </span>
                            </p>
                        </div>

                        <!-- Status Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                New Status
                            </label>
                            <select x-model="newStatus" 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <template x-for="status in availableStatuses" :key="status.value">
                                    <option :value="status.value" x-text="status.label"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Email Notification Info -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-blue-800 dark:text-blue-200">
                                        <strong>Email Notifications:</strong> Both the customer and admin will receive an email notification about this status change.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-end space-x-3">
                    <button @click="cancelStatusUpdate()" 
                            :disabled="updatingStatus"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        Cancel
                    </button>
                    <button @click="saveStatusUpdate()" 
                            :disabled="updatingStatus || newStatus === selectedOrder?.status"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center">
                        <svg x-show="updatingStatus" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="updatingStatus ? 'Updating...' : 'Update Status'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Order Details Modal -->
        <div x-show="showOrderModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
             @click.self="closeOrderModal()">
            
            <div x-show="showOrderModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4 sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-2 bg-white/20 rounded-lg mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Order Details</h3>
                                <p class="text-blue-100 text-sm" x-text="orderDetails?.order_number || '#' + orderDetails?.id"></p>
                            </div>
                        </div>
                        <button @click="closeOrderModal()" 
                                class="text-white hover:text-gray-200 transition-colors p-2 hover:bg-white/10 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div x-show="orderDetails" class="p-6">
                    <!-- Order Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Order Status Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 border border-blue-200 dark:border-blue-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-blue-600 dark:text-blue-400">Status</p>
                                    <div class="mt-1">
                                        <span :class="getStatusBadgeClass(orderDetails?.status)" 
                                              class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                            <span x-text="getStatusText(orderDetails?.status)"></span>
                                        </span>
                                    </div>
                                </div>
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Total Amount Card -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-4 border border-green-200 dark:border-green-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-600 dark:text-green-400">Total Amount</p>
                                    <p class="text-2xl font-bold text-green-800 dark:text-green-200">
                                        $<span x-text="parseFloat(orderDetails?.total || 0).toFixed(2)"></span>
                                    </p>
                                </div>
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Payment Method Card -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-4 border border-purple-200 dark:border-purple-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-purple-600 dark:text-purple-400">Payment Method</p>
                                    <div class="mt-1">
                                        <span :class="getPaymentBadgeClass(orderDetails?.payment_method)" 
                                              class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium">
                                            <span x-text="getPaymentMethodText(orderDetails?.payment_method)"></span>
                                        </span>
                                    </div>
                                </div>
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Customer & Order Information -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <!-- Customer Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/50 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Customer Information</h4>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</label>
                                    <p class="text-gray-900 dark:text-white font-medium" x-text="orderDetails?.customer_name || orderDetails?.name || 'N/A'"></p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                    <p class="text-gray-900 dark:text-white" x-text="orderDetails?.customer_email || orderDetails?.email || 'N/A'"></p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                                    <p class="text-gray-900 dark:text-white" x-text="orderDetails?.customer_phone || orderDetails?.phone || 'N/A'"></p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">City</label>
                                    <p class="text-gray-900 dark:text-white flex items-center">
                                        <span class="mr-2">📍</span>
                                        <span x-text="orderDetails?.city || 'N/A'"></span>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Shipping Address</label>
                                    <p class="text-gray-900 dark:text-white whitespace-pre-wrap" x-text="orderDetails?.shipping_address || 'N/A'"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                            <div class="flex items-center mb-4">
                                <div class="p-2 bg-green-100 dark:bg-green-900/50 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Order Information</h4>
                            </div>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Order Number</label>
                                    <p class="text-gray-900 dark:text-white font-medium" x-text="orderDetails?.order_number || '#' + orderDetails?.id"></p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Order Date</label>
                                    <p class="text-gray-900 dark:text-white" x-text="formatDate(orderDetails?.created_at)"></p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</label>
                                    <p class="text-gray-900 dark:text-white" x-text="formatDate(orderDetails?.updated_at)"></p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Status</label>
                                    <p class="text-gray-900 dark:text-white capitalize" x-text="orderDetails?.payment_status || 'N/A'"></p>
                                </div>
                                <div x-show="orderDetails?.stripe_payment_intent_id">
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment ID</label>
                                    <p class="text-gray-900 dark:text-white text-xs font-mono bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded" x-text="orderDetails?.stripe_payment_intent_id"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
                            <div class="flex items-center">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg mr-3">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Order Items</h4>
                                <span class="ml-auto bg-indigo-100 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-200 px-3 py-1 rounded-full text-sm font-medium" 
                                      x-text="(orderDetails?.order_items?.length || 0) + ' item(s)'"></span>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <template x-if="orderDetails?.order_items && orderDetails.order_items.length > 0">
                                <div class="space-y-4">
                                    <template x-for="(item, index) in orderDetails.order_items" :key="index">
                                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600">
                                            <div class="flex items-center flex-1">
                                                <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-600 rounded-lg flex items-center justify-center mr-4">
                                                    <span class="text-white font-bold text-lg" x-text="item.product?.name?.charAt(0) || 'P'"></span>
                                                </div>
                                                <div class="flex-1">
                                                    <h5 class="font-semibold text-gray-900 dark:text-white" x-text="item.product?.name || item.product_name || 'Unknown Product'"></h5>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="'Product #: ' + (item.product?.product_number || item.product_number || 'N/A')"></p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                                        <span x-text="'Qty: ' + item.quantity"></span> × 
                                                        <span x-text="'$' + parseFloat(item.price || 0).toFixed(2)"></span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">
                                                    $<span x-text="(parseFloat(item.price || 0) * parseInt(item.quantity || 0)).toFixed(2)"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            
                            <template x-if="!orderDetails?.order_items || orderDetails.order_items.length === 0">
                                <div class="text-center py-8">
                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-2.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 009.586 13H7"></path>
                                    </svg>
                                    <p class="text-gray-500 dark:text-gray-400">No items found for this order</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center border-t border-gray-200 dark:border-gray-600">
                    <div class="flex items-center space-x-4">
                        <button @click="updateOrderStatus(orderDetails)" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Update Status
                        </button>
                        <button @click="printInvoice(orderDetails)" 
                                class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                            </svg>
                            Print Invoice
                        </button>
                    </div>
                    <button @click="closeOrderModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-500 transition-colors">
                        Close
                    </button>
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
                
                // Status update modal
                showStatusModal: false,
                selectedOrder: null,
                newStatus: '',
                availableStatuses: [
                    { value: 'pending', label: 'Pending' },
                    { value: 'confirmed', label: 'Confirmed' },
                    { value: 'processing', label: 'Processing' },
                    { value: 'shipped', label: 'Shipped' },
                    { value: 'completed', label: 'Completed' },
                    { value: 'cancelled', label: 'Cancelled' }
                ],
                updatingStatus: false,
                
                // Order details modal
                showOrderModal: false,
                orderDetails: null,
                
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
                        'confirmed': 'bg-blue-100 text-blue-800',
                        'processing': 'bg-indigo-100 text-indigo-800',
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
                        'confirmed': 'Confirmed',
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
                        const itemName = firstItem.product ? firstItem.product.name : 'Unknown Product';
                        const more = order.order_items.length > 1 ? ` +${order.order_items.length - 1} more` : '';
                        return itemName + more;
                    }
                    return 'No items';
                },

                viewOrder(order) {
                    this.orderDetails = order;
                    this.showOrderModal = true;
                },

                closeOrderModal() {
                    this.showOrderModal = false;
                    this.orderDetails = null;
                },

                updateOrderStatus(order) {
                    this.selectedOrder = order;
                    this.newStatus = order.status;
                    this.showOrderModal = false; // Close order modal if open
                    this.showStatusModal = true;
                },

                async saveStatusUpdate() {
                    if (!this.selectedOrder || !this.newStatus || this.updatingStatus) {
                        return;
                    }

                    this.updatingStatus = true;

                    try {
                        // Get CSRF token safely
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                        
                        const response = await fetch(`/admin/orders/${this.selectedOrder.id}/status`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                status: this.newStatus
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Update the order in the local array
                            const orderIndex = this.orders.findIndex(o => o.id === this.selectedOrder.id);
                            if (orderIndex !== -1) {
                                this.orders[orderIndex].status = this.newStatus;
                                this.orders[orderIndex].order_status = this.newStatus;
                                this.orders[orderIndex].updated_at = result.order.updated_at;
                            }

                            // Re-filter the orders
                            this.filterOrders();

                            // Close modal and show success message
                            this.showStatusModal = false;
                            this.selectedOrder = null;
                            this.newStatus = '';

                            // Show success notification
                            this.showNotification('Order status updated successfully! Email notifications have been sent.', 'success');
                        } else {
                            throw new Error(result.message || 'Failed to update order status');
                        }
                    } catch (error) {
                        console.error('Error updating order status:', error);
                        this.showNotification('Error updating order status: ' + error.message, 'error');
                    } finally {
                        this.updatingStatus = false;
                    }
                },

                cancelStatusUpdate() {
                    this.showStatusModal = false;
                    this.selectedOrder = null;
                    this.newStatus = '';
                },

                showNotification(message, type = 'info') {
                    // Simple notification implementation
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transition-all duration-300 ${
                        type === 'success' ? 'bg-green-500 text-white' : 
                        type === 'error' ? 'bg-red-500 text-white' : 
                        'bg-blue-500 text-white'
                    }`;
                    notification.textContent = message;
                    
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.remove();
                    }, 5000);
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

                async markAllAsProcessed() {
                    // Get orders that can be marked as processed (pending or confirmed)
                    const eligibleOrders = this.orders.filter(order => 
                        order.status === 'pending' || order.status === 'confirmed'
                    );

                    if (eligibleOrders.length === 0) {
                        this.showNotification('No orders eligible for processing. Only pending and confirmed orders can be marked as processed.', 'info');
                        return;
                    }

                    // Show confirmation dialog
                    const confirmed = confirm(`Are you sure you want to mark ${eligibleOrders.length} order(s) as processed? This will send email notifications to all customers.`);
                    if (!confirmed) {
                        return;
                    }

                    // Show loading state
                    const loadingNotification = this.showLoadingNotification(`Processing ${eligibleOrders.length} orders...`);

                    try {
                        // Get CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                        
                        // Prepare order IDs for bulk update
                        const orderIds = eligibleOrders.map(order => order.id);

                        const response = await fetch('/admin/orders/bulk-update-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                order_ids: orderIds,
                                status: 'processing'
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Update local orders array
                            orderIds.forEach(orderId => {
                                const orderIndex = this.orders.findIndex(o => o.id === orderId);
                                if (orderIndex !== -1) {
                                    this.orders[orderIndex].status = 'processing';
                                    this.orders[orderIndex].order_status = 'processing';
                                    this.orders[orderIndex].updated_at = new Date().toISOString();
                                }
                            });

                            // Re-filter orders to update display
                            this.filterOrders();

                            // Remove loading notification and show success
                            document.body.removeChild(loadingNotification);
                            this.showNotification(`Successfully updated ${result.updated_count || eligibleOrders.length} orders to processing status. Email notifications have been sent.`, 'success');
                        } else {
                            throw new Error(result.message || 'Failed to update orders');
                        }
                    } catch (error) {
                        // Remove loading notification and show error
                        if (document.body.contains(loadingNotification)) {
                            document.body.removeChild(loadingNotification);
                        }
                        console.error('Error updating orders:', error);
                        this.showNotification('Error updating orders: ' + error.message, 'error');
                    }
                },

                async sendBulkEmails() {
                    // Get all orders with valid email addresses
                    const ordersWithEmails = this.orders.filter(order => 
                        order.customer_email && 
                        order.customer_email.includes('@') && 
                        order.customer_email !== 'N/A'
                    );

                    if (ordersWithEmails.length === 0) {
                        this.showNotification('No orders found with valid email addresses.', 'info');
                        return;
                    }

                    // Show confirmation dialog
                    const confirmed = confirm(`Are you sure you want to send status update emails to ${ordersWithEmails.length} customer(s)?`);
                    if (!confirmed) {
                        return;
                    }

                    // Show loading state
                    const loadingNotification = this.showLoadingNotification(`Sending emails to ${ordersWithEmails.length} customers...`);

                    try {
                        // Get CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                        
                        // Prepare order IDs for bulk email
                        const orderIds = ordersWithEmails.map(order => order.id);

                        const response = await fetch('/admin/orders/bulk-send-emails', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                order_ids: orderIds
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Remove loading notification and show success
                            document.body.removeChild(loadingNotification);
                            this.showNotification(`Successfully sent emails to ${result.sent_count || ordersWithEmails.length} customers.`, 'success');
                        } else {
                            throw new Error(result.message || 'Failed to send emails');
                        }
                    } catch (error) {
                        // Remove loading notification and show error
                        if (document.body.contains(loadingNotification)) {
                            document.body.removeChild(loadingNotification);
                        }
                        console.error('Error sending emails:', error);
                        this.showNotification('Error sending emails: ' + error.message, 'error');
                    }
                },

                async generateReport() {
                    // Show loading state
                    const loadingNotification = this.showLoadingNotification('Generating orders report...');

                    try {
                        // Get CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                        
                        const response = await fetch('/admin/orders/generate-report', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                format: 'csv', // You can add a dropdown to select format later
                                filters: {
                                    status: this.statusFilter,
                                    payment_method: this.paymentFilter,
                                    search: this.searchTerm
                                }
                            })
                        });

                        if (response.ok) {
                            // Get the blob data
                            const blob = await response.blob();
                            
                            // Create download link
                            const url = window.URL.createObjectURL(blob);
                            const link = document.createElement('a');
                            link.href = url;
                            link.download = `orders-report-${new Date().toISOString().split('T')[0]}.csv`;
                            
                            // Trigger download
                            document.body.appendChild(link);
                            link.click();
                            
                            // Cleanup
                            document.body.removeChild(link);
                            window.URL.revokeObjectURL(url);

                            // Remove loading notification and show success
                            document.body.removeChild(loadingNotification);
                            this.showNotification('Orders report generated and downloaded successfully!', 'success');
                        } else {
                            const result = await response.json();
                            throw new Error(result.message || 'Failed to generate report');
                        }
                    } catch (error) {
                        // Remove loading notification and show error
                        if (document.body.contains(loadingNotification)) {
                            document.body.removeChild(loadingNotification);
                        }
                        console.error('Error generating report:', error);
                        this.showNotification('Error generating report: ' + error.message, 'error');
                    }
                },

                showLoadingNotification(message) {
                    // Create loading notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 bg-blue-500 text-white flex items-center';
                    notification.innerHTML = `
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-3"></div>
                        <span>${message}</span>
                    `;
                    
                    document.body.appendChild(notification);
                    return notification;
                }
            }
        }
    </script>
</x-layouts.app>
