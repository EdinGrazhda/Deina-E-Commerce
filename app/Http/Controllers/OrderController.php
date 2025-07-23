<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Admin.order.index');
    }

    /**
     * Get orders data for AJAX requests
     */
    public function getData()
    {
        try {
            Log::info('OrderController getData called');
            
            $orders = Order::with(['orderItems.product'])
                ->withCount('orderItems')
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info("Orders count: {$orders->count()}");

            $formattedOrders = $orders->map(function ($order) {
                // Calculate total items and total amount from order items
                $totalAmount = 0;
                $totalItems = 0;
                $itemsPreview = [];
                
                if ($order->orderItems && $order->orderItems->count() > 0) {
                    foreach ($order->orderItems as $item) {
                        $totalAmount += ($item->price * $item->quantity);
                        $totalItems += $item->quantity;
                        if ($item->product) {
                            $itemsPreview[] = $item->product->name;
                        }
                    }
                } else {
                    // Fallback to order total if no items
                    $totalAmount = $order->total_amount ?? $order->total_price ?? 0;
                }
                
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number ?? 'ORD-' . str_pad($order->id, 8, '0', STR_PAD_LEFT),
                    'customer_name' => $order->customer_name ?? $order->name ?? 'Guest Customer',
                    'customer_email' => $order->customer_email ?? $order->email ?? 'N/A',
                    'customer_phone' => $order->customer_phone ?? $order->phone ?? 'N/A',
                    'customer_address' => $order->customer_address ?? $order->address ?? 'N/A',
                    'shipping_address' => $order->shipping_address ?? $order->address ?? 'N/A',
                    'total' => $totalAmount,
                    'total_amount' => $totalAmount,
                    'total_items' => $totalItems,
                    'payment_method' => $order->payment_method ?? 'cash',
                    'payment_status' => $order->payment_status ?? 'pending',
                    'status' => $order->order_status ?? $order->status?->value ?? 'pending',
                    'order_status' => $order->order_status ?? $order->status?->value ?? 'pending',
                    'order_items' => $order->orderItems->map(function($item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,
                            'product_name' => $item->product ? $item->product->name : 'Unknown Product',
                            'product_number' => $item->product ? $item->product->product_number : 'N/A',
                            'quantity' => $item->quantity,
                            'price' => $item->price,
                            'total' => $item->price * $item->quantity,
                            'product' => $item->product ? [
                                'id' => $item->product->id,
                                'name' => $item->product->name,
                                'product_number' => $item->product->product_number
                            ] : null
                        ];
                    }),
                    'order_items_count' => $totalItems,
                    'items_preview' => implode(', ', array_slice($itemsPreview, 0, 2)) . (count($itemsPreview) > 2 ? ' +' . (count($itemsPreview) - 2) . ' more' : ''),
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $order->updated_at->format('Y-m-d H:i:s'),
                    'formatted_date' => $order->created_at->format('M d, Y H:i')
                ];
            });

            Log::info('Formatted orders: ' . $formattedOrders->toJson());

            $response = [
                'success' => true,
                'orders' => $formattedOrders,
                'total' => $orders->count()
            ];

            Log::info('Response: ' . json_encode($response));

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error in OrderController getData: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to load orders: ' . $e->getMessage(),
                'orders' => [],
                'total' => 0
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
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|numeric|min:0|max:999999.99',
                'status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))],
            ], [
                'user_id.required' => 'User is required.',
                'user_id.exists' => 'Selected user does not exist.',
                'total_price.required' => 'Total price is required.',
                'total_price.numeric' => 'Total price must be a number.',
                'total_price.min' => 'Total price cannot be negative.',
                'total_price.max' => 'Total price cannot exceed $999,999.99.',
                'status.required' => 'Status is required.',
                'status.in' => 'Invalid status selected.',
            ]);

            $order = Order::create([
                'user_id' => $validatedData['user_id'],
                'total_price' => $validatedData['total_price'],
                'status' => OrderStatus::from($validatedData['status']),
            ]);

            $order->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully!',
                'order' => [
                    'id' => $order->id,
                    'user_id' => $order->user_id,
                    'user_name' => $order->user ? $order->user->name : 'Guest',
                    'user_email' => $order->user ? $order->user->email : 'N/A',
                    'total_price' => $order->total_price,
                    'status' => $order->status->value,
                    'status_label' => $order->status->label(),
                    'order_items_count' => 0,
                    'created_at' => $order->created_at->format('M d, Y H:i'),
                    'updated_at' => $order->updated_at->format('M d, Y H:i')
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
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try {
            $order->load(['user', 'orderItems.product']);
            
            $orderData = [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'user_name' => $order->user ? $order->user->name : 'Guest',
                'user_email' => $order->user ? $order->user->email : 'N/A',
                'total_price' => $order->total_price,
                'status' => $order->status->value,
                'status_label' => $order->status->label(),
                'order_items_count' => $order->orderItems->count(),
                'created_at' => $order->created_at->format('M d, Y H:i'),
                'updated_at' => $order->updated_at->format('M d, Y H:i')
            ];

            return response()->json($orderData);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'total_price' => 'required|numeric|min:0|max:999999.99',
                'status' => ['required', Rule::in(array_column(OrderStatus::cases(), 'value'))],
            ], [
                'user_id.required' => 'User is required.',
                'user_id.exists' => 'Selected user does not exist.',
                'total_price.required' => 'Total price is required.',
                'total_price.numeric' => 'Total price must be a number.',
                'total_price.min' => 'Total price cannot be negative.',
                'total_price.max' => 'Total price cannot exceed $999,999.99.',
                'status.required' => 'Status is required.',
                'status.in' => 'Invalid status selected.',
            ]);

            $order->update([
                'user_id' => $validatedData['user_id'],
                'total_price' => $validatedData['total_price'],
                'status' => OrderStatus::from($validatedData['status']),
            ]);

            $order->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully!',
                'order' => [
                    'id' => $order->id,
                    'user_id' => $order->user_id,
                    'user_name' => $order->user ? $order->user->name : 'Guest',
                    'user_email' => $order->user ? $order->user->email : 'N/A',
                    'total_price' => $order->total_price,
                    'status' => $order->status->value,
                    'status_label' => $order->status->label(),
                    'order_items_count' => $order->orderItems()->count(),
                    'created_at' => $order->created_at->format('M d, Y H:i'),
                    'updated_at' => $order->updated_at->format('M d, Y H:i')
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
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            // Check if order has items
            $itemsCount = $order->orderItems()->count();
            
            if ($itemsCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete order #{$order->id} because it has {$itemsCount} item(s). Please remove all items first."
                ], 400);
            }

            $orderId = $order->id;
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => "Order #{$orderId} deleted successfully!"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get users for dropdown
     */
    public function getUsers()
    {
        try {
            $users = User::select('id', 'name', 'email')->orderBy('name')->get();
            
            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load users: ' . $e->getMessage(),
                'users' => []
            ], 500);
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|string|in:pending,confirmed,processing,shipped,completed,cancelled'
            ]);

            $order = Order::findOrFail($id);
            $oldStatus = $order->order_status ?? $order->status?->value ?? 'pending';
            $newStatus = $request->status;

            // Update both status fields for compatibility
            $order->order_status = $newStatus;
            
            // Also update the enum status field if it exists
            try {
                $order->status = OrderStatus::from($newStatus);
            } catch (\ValueError $e) {
                // If enum value doesn't exist, just update order_status
            }

            $order->save();

            // Send status update email to customer
            $this->sendStatusUpdateEmail($order, $oldStatus, $newStatus);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'order' => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'status' => $newStatus,
                    'updated_at' => $order->updated_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send status update email notification
     */
    private function sendStatusUpdateEmail($order, $oldStatus, $newStatus)
    {
        try {
            if (!$order->customer_email || $order->customer_email === 'N/A') {
                Log::info("No email available for order {$order->order_number}");
                return;
            }

            $statusLabels = [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled'
            ];

            $emailData = [
                'customer_name' => $order->customer_name ?? 'Valued Customer',
                'order_number' => $order->order_number,
                'old_status' => $statusLabels[$oldStatus] ?? $oldStatus,
                'new_status' => $statusLabels[$newStatus] ?? $newStatus,
                'order_date' => $order->created_at->format('M d, Y'),
                'tracking_number' => $order->tracking_number
            ];

            // Send email to customer
            Mail::send('emails.status-update', $emailData, function ($message) use ($order) {
                $message->to($order->customer_email, $order->customer_name)
                        ->subject('Order Status Update - ' . $order->order_number)
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            // Send notification to admin
            Mail::send('emails.admin-status-update', $emailData, function ($message) use ($order) {
                $message->to('edingrazhda17@gmail.com', 'Admin')
                        ->subject('Order Status Updated - ' . $order->order_number)
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            Log::info("Status update emails sent for order {$order->order_number}: {$oldStatus} -> {$newStatus}");

        } catch (\Exception $e) {
            Log::error("Failed to send status update email for order {$order->order_number}: " . $e->getMessage());
        }
    }

    /**
     * Send general status notification email to customer
     */
    private function sendGeneralStatusEmail($order)
    {
        try {
            Log::info('sendGeneralStatusEmail started', ['order_id' => $order->id]);
            
            if (!$order->customer_email || $order->customer_email === 'N/A') {
                Log::info("No email available for order {$order->order_number}");
                return;
            }

            $statusLabels = [
                'pending' => 'Pending',
                'confirmed' => 'Confirmed',
                'processing' => 'Processing',
                'shipped' => 'Shipped',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled'
            ];

            // Get the status value properly (handle both enum and string)
            $statusValue = $order->status;
            if (is_object($statusValue)) {
                $statusValue = $statusValue->value;
            }

            $emailData = [
                'customer_name' => $order->customer_name ?? 'Valued Customer',
                'order_number' => $order->order_number ?? 'N/A',
                'current_status' => $statusLabels[$statusValue] ?? $statusValue,
                'order_date' => $order->created_at ? $order->created_at->format('M d, Y') : 'N/A',
                'total_amount' => $order->total_price ?? 0,
                'tracking_number' => $order->tracking_number ?? null
            ];

            Log::info('Email data prepared', ['email_data' => $emailData]);

            // Send email to customer
            Mail::send('emails.order-status-notification', $emailData, function ($message) use ($order) {
                $message->to($order->customer_email, $order->customer_name)
                        ->subject('Order Status Notification - ' . ($order->order_number ?? 'Your Order'))
                        ->from(env('MAIL_FROM_ADDRESS', 'noreply@deina.com'), env('MAIL_FROM_NAME', 'Deina'));
            });

            Log::info("Status notification email sent for order {$order->order_number} with status: {$statusValue}");

        } catch (\Exception $e) {
            Log::error("Failed to send status notification email for order {$order->order_number}: " . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Get order statuses for dropdown
     */
    public function getStatuses()
    {
        try {
            $statuses = collect(OrderStatus::cases())->map(function ($status) {
                return [
                    'value' => $status->value,
                    'label' => $status->label()
                ];
            });
            
            return response()->json([
                'success' => true,
                'statuses' => $statuses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load statuses: ' . $e->getMessage(),
                'statuses' => []
            ], 500);
        }
    }

    /**
     * Bulk update order status
     */
    public function bulkUpdateStatus(Request $request)
    {
        try {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:order,id',
            'status' => 'required|string|in:pending,confirmed,processing,shipped,delivered,completed,cancelled',
        ]);            $orderIds = $request->input('order_ids');
            $newStatus = $request->input('status');

            // Get orders with their customers
            $orders = Order::whereIn('id', $orderIds)
                ->where(function($query) {
                    $query->where('status', 'pending')
                          ->orWhere('status', 'confirmed');
                })
                ->get();

            $updatedCount = 0;

            foreach ($orders as $order) {
                // Store old status
                $oldStatus = $order->status;
                
                // Update the order status
                $order->status = $newStatus;
                $order->save();

                // Send email notification
                try {
                    $this->sendStatusUpdateEmail($order, $oldStatus, $newStatus);
                } catch (\Exception $e) {
                    Log::error("Failed to send email for order {$order->id}: " . $e->getMessage());
                }

                $updatedCount++;
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} orders to {$newStatus} status.",
                'updated_count' => $updatedCount
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Bulk update status error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update orders: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk send emails
     */
    public function bulkSendEmails(Request $request)
    {
        try {
            Log::info('Bulk send emails started', ['request' => $request->all()]);
            
            $request->validate([
                'order_ids' => 'required|array',
                'order_ids.*' => 'exists:order,id',
            ]);

            $orderIds = $request->input('order_ids');
            Log::info('Order IDs validated', ['order_ids' => $orderIds]);

            // Get orders with valid email addresses
            $orders = Order::whereIn('id', $orderIds)
                ->whereNotNull('customer_email')
                ->where('customer_email', '!=', '')
                ->where('customer_email', '!=', 'N/A')
                ->get();

            Log::info('Orders found', ['count' => $orders->count()]);

            $sentCount = 0;

            foreach ($orders as $order) {
                try {
                    Log::info('Sending email for order', ['order_id' => $order->id, 'email' => $order->customer_email]);
                    $this->sendGeneralStatusEmail($order);
                    $sentCount++;
                    Log::info('Email sent successfully', ['order_id' => $order->id]);
                } catch (\Exception $e) {
                    Log::error("Failed to send email for order {$order->id}: " . $e->getMessage());
                }
            }

            Log::info('Bulk email send completed', ['sent_count' => $sentCount]);

            return response()->json([
                'success' => true,
                'message' => "Successfully sent emails to {$sentCount} customers.",
                'sent_count' => $sentCount
            ]);

        } catch (ValidationException $e) {
            Log::error('Bulk email validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Bulk send emails error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send emails: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate and download orders report
     */
    public function generateReport(Request $request)
    {
        try {
            $request->validate([
                'format' => 'in:csv,pdf',
                'filters' => 'array',
            ]);

            $format = $request->input('format', 'csv');
            $filters = $request->input('filters', []);

            // Build query with filters
            $query = Order::with(['orderItems.product']);

            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }

            if (!empty($filters['payment_method'])) {
                $query->where('payment_method', $filters['payment_method']);
            }

            if (!empty($filters['search'])) {
                $search = $filters['search'];
                $query->where(function($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_email', 'like', "%{$search}%");
                });
            }

            $orders = $query->orderBy('created_at', 'desc')->get();

            if ($format === 'csv') {
                return $this->generateCSVReport($orders);
            }

            return response()->json([
                'success' => false,
                'message' => 'Unsupported format'
            ], 400);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Generate report error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate report: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate CSV report
     */
    private function generateCSVReport($orders)
    {
        $filename = 'orders-report-' . date('Y-m-d') . '.csv';
        
        $handle = fopen('php://output', 'w');
        
        // Set headers for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Add CSV headers
        fputcsv($handle, [
            'Order ID',
            'Order Number',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Status',
            'Payment Method',
            'Payment Status',
            'Total Amount',
            'Total Items',
            'Items',
            'Shipping Address',
            'Order Date',
            'Last Updated',
            'Payment ID'
        ]);

        // Add order data
        foreach ($orders as $order) {
            // Handle status properly (could be enum or string)
            $statusValue = $order->status;
            if (is_object($statusValue)) {
                $statusValue = $statusValue->value;
            }

            // Calculate totals
            $totalAmount = floatval($order->total_price ?? 0);
            $totalItems = 0;
            $itemsText = [];

            if ($order->orderItems && $order->orderItems->count() > 0) {
                foreach ($order->orderItems as $item) {
                    $totalItems += $item->quantity;
                    $productName = $item->product ? $item->product->name : 'Unknown Product';
                    $itemsText[] = "{$productName} (Qty: {$item->quantity}, Price: $" . number_format($item->price, 2) . ")";
                }
            }

            fputcsv($handle, [
                $order->id,
                $order->order_number ?? "#" . $order->id,
                $order->customer_name ?? 'N/A',
                $order->customer_email ?? 'N/A',
                $order->customer_phone ?? 'N/A',
                ucfirst($statusValue ?? 'Unknown'),
                $this->getPaymentMethodText($order->payment_method),
                ucfirst($order->payment_status ?? 'N/A'),
                '$' . number_format($totalAmount, 2),
                $totalItems,
                implode('; ', $itemsText),
                $order->shipping_address ?? 'N/A',
                $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : 'N/A',
                $order->updated_at ? $order->updated_at->format('Y-m-d H:i:s') : 'N/A',
                $order->stripe_payment_intent_id ?? 'N/A'
            ]);
        }

        fclose($handle);
        exit; // Important: exit after sending the file
    }

    /**
     * Get payment method text for display
     */
    private function getPaymentMethodText($method)
    {
        $texts = [
            'cash' => 'Cash on Delivery',
            'stripe' => 'Credit/Debit Card',
            'credit_card' => 'Credit Card'
        ];
        
        return $texts[$method] ?? 'Unknown';
    }
}
