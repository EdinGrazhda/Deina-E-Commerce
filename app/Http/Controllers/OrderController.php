<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            
            $orders = Order::with(['user', 'orderItems'])
                ->withCount('orderItems')
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info("Orders count: {$orders->count()}");

            $formattedOrders = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'user_id' => $order->user_id,
                    'user_name' => $order->user ? $order->user->name : 'Guest',
                    'user_email' => $order->user ? $order->user->email : 'N/A',
                    'total_price' => $order->total_price,
                    'status' => $order->status->value,
                    'status_label' => $order->status->label(),
                    'order_items_count' => $order->order_items_count,
                    'created_at' => $order->created_at->format('M d, Y H:i'),
                    'updated_at' => $order->updated_at->format('M d, Y H:i')
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
}
