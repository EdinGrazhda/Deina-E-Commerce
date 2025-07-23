<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get current period statistics
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();
        $thisYear = Carbon::now()->startOfYear();

        // Basic statistics
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'completed')->sum('total_amount');
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Today's statistics
        $todayOrders = Order::whereDate('created_at', $today)->count();
        $todayRevenue = Order::whereDate('created_at', $today)
                           ->where('payment_status', 'completed')
                           ->sum('total_amount');

        // This week's statistics
        $weekOrders = Order::where('created_at', '>=', $thisWeek)->count();
        $weekRevenue = Order::where('created_at', '>=', $thisWeek)
                          ->where('payment_status', 'completed')
                          ->sum('total_amount');

        // This month's statistics
        $monthOrders = Order::where('created_at', '>=', $thisMonth)->count();
        $monthRevenue = Order::where('created_at', '>=', $thisMonth)
                           ->where('payment_status', 'completed')
                           ->sum('total_amount');

        // This year's statistics
        $yearOrders = Order::where('created_at', '>=', $thisYear)->count();
        $yearRevenue = Order::where('created_at', '>=', $thisYear)
                          ->where('payment_status', 'completed')
                          ->sum('total_amount');

        // Daily sales for the last 30 days
        $dailySales = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(CASE WHEN payment_status = "completed" THEN total_amount ELSE 0 END) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly sales for the last 12 months
        $monthlySales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(CASE WHEN payment_status = "completed" THEN total_amount ELSE 0 END) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Top selling products
        $topProducts = OrderItem::select(
                'product_id',
                'product_name',
                DB::raw('SUM(quantity) as total_sold'),
                DB::raw('SUM(price * quantity) as total_revenue')
            )
            ->groupBy('product_id', 'product_name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Sales by category
        $salesByCategory = DB::table('order_items')
            ->join('product', 'order_items.product_id', '=', 'product.id')
            ->join('category', 'product.category_id', '=', 'category.id')
            ->select(
                'category.name as category_name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
            )
            ->groupBy('category.id', 'category.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Recent orders
        $recentOrders = Order::with(['orderItems'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->limit(10)
            ->get();

        // Order status distribution
        $orderStatusDistribution = Order::select('order_status', DB::raw('COUNT(*) as count'))
            ->groupBy('order_status')
            ->get();

        // Payment method distribution
        $paymentMethodDistribution = Order::select('payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();

        return view('dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'totalCategories',
            'todayOrders',
            'todayRevenue',
            'weekOrders',
            'weekRevenue',
            'monthOrders',
            'monthRevenue',
            'yearOrders',
            'yearRevenue',
            'dailySales',
            'monthlySales',
            'topProducts',
            'salesByCategory',
            'recentOrders',
            'lowStockProducts',
            'orderStatusDistribution',
            'paymentMethodDistribution'
        ));
    }

    public function getAnalyticsData(Request $request)
    {
        $period = $request->get('period', 'daily');
        $days = $request->get('days', 30);

        switch ($period) {
            case 'daily':
                return $this->getDailySales($days);
            case 'weekly':
                return $this->getWeeklySales();
            case 'monthly':
                return $this->getMonthlySales();
            case 'yearly':
                return $this->getYearlySales();
            default:
                return $this->getDailySales($days);
        }
    }

    private function getDailySales($days = 30)
    {
        $sales = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(CASE WHEN payment_status = "completed" THEN total_amount ELSE 0 END) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'labels' => $sales->pluck('date'),
            'orders' => $sales->pluck('orders'),
            'revenue' => $sales->pluck('revenue')
        ]);
    }

    private function getWeeklySales()
    {
        $sales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('WEEK(created_at) as week'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(CASE WHEN payment_status = "completed" THEN total_amount ELSE 0 END) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subWeeks(12))
            ->groupBy('year', 'week')
            ->orderBy('year')
            ->orderBy('week')
            ->get();

        return response()->json([
            'labels' => $sales->map(function($item) {
                return "Week {$item->week}, {$item->year}";
            }),
            'orders' => $sales->pluck('orders'),
            'revenue' => $sales->pluck('revenue')
        ]);
    }

    private function getMonthlySales()
    {
        $sales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(CASE WHEN payment_status = "completed" THEN total_amount ELSE 0 END) as revenue')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return response()->json([
            'labels' => $sales->map(function($item) {
                return Carbon::create($item->year, $item->month)->format('M Y');
            }),
            'orders' => $sales->pluck('orders'),
            'revenue' => $sales->pluck('revenue')
        ]);
    }

    private function getYearlySales()
    {
        $sales = Order::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(CASE WHEN payment_status = "completed" THEN total_amount ELSE 0 END) as revenue')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return response()->json([
            'labels' => $sales->pluck('year'),
            'orders' => $sales->pluck('orders'),
            'revenue' => $sales->pluck('revenue')
        ]);
    }
}
