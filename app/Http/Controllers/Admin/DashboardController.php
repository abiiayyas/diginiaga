<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $totalPendingEver = Order::whereIn('order_status', ['pending_payment'])
            ->whereNotIn('payment_status', ['paid'])
            ->count()
            + Order::where('payment_status', 'paid')->where('reminder_count', '>', 0)->count();

        $recoveredOrders = Order::where('payment_status', 'paid')
            ->where('reminder_count', '>', 0)
            ->count();

        $totalVisits = LandingPage::sum('visits');
        $totalOrdersEver = Order::count();
        $conversionRate = $totalVisits > 0 ? round(($totalOrdersEver / $totalVisits) * 100, 2) : 0;

        $stats = [
            'total_orders_today' => Order::whereDate('created_at', $today)->count(),
            'total_revenue_today' => Order::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'pending_orders' => Order::where('order_status', 'pending_payment')->count(),
            'need_processing' => Order::where('order_status', 'paid')->count(),
            'recovery_rate' => $totalPendingEver > 0
                ? round(($recoveredOrders / $totalPendingEver) * 100, 1)
                : 0,
            'conversion_rate' => $conversionRate,
            'total_visits' => $totalVisits,
        ];

        $recentOrders = Order::with(['product', 'landingPage'])
            ->latest()
            ->take(10)
            ->get();

        $charts = [
            'labels' => $this->getLast7DaysLabels(),
            'orders' => $this->getLast7DaysOrders(),
            'revenue' => $this->getLast7DaysRevenue(),
        ];

        return view('admin.dashboard', compact('stats', 'recentOrders', 'charts'));
    }

    public function stats()
    {
        $today = now()->startOfDay();

        return response()->json([
            'total_orders_today' => Order::whereDate('created_at', $today)->count(),
            'total_revenue_today' => Order::whereDate('created_at', $today)
                ->where('payment_status', 'paid')
                ->sum('total_amount'),
            'pending_orders' => Order::where('order_status', 'pending_payment')->count(),
            'need_processing' => Order::where('order_status', 'paid')->count(),
        ]);
    }

    protected function getLast7DaysLabels(): array
    {
        $labels = [];
        for ($i = 6; $i >= 0; $i--) {
            $labels[] = now()->subDays($i)->format('d M');
        }
        return $labels;
    }

    protected function getLast7DaysOrders(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[] = Order::whereDate('created_at', $date)->count();
        }
        return $data;
    }

    protected function getLast7DaysRevenue(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[] = (int) Order::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total_amount');
        }
        return $data;
    }
}
