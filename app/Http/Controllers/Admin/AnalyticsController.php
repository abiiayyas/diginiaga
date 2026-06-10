<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Order;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $dateFrom = $request->date_from ?: now()->subDays(30)->format('Y-m-d');
        $dateTo = $request->date_to ?: now()->format('Y-m-d');

        $landingPages = LandingPage::with(['product'])
            ->withCount(['orders as total_orders' => function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59']);
            }])
            ->withCount(['orders as paid_orders' => function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                  ->where('payment_status', 'paid');
            }])
            ->withSum(['orders as total_revenue' => function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
                  ->where('payment_status', 'paid');
            }], 'total_amount')
            ->orderByDesc('total_orders')
            ->get();

        $overallStats = [
            'total_visits' => $landingPages->sum('visits'),
            'total_orders' => $landingPages->sum('total_orders'),
            'total_paid_orders' => $landingPages->sum('paid_orders'),
            'total_revenue' => $landingPages->sum('total_revenue'),
            'conversion_rate' => $landingPages->sum('visits') > 0
                ? round(($landingPages->sum('total_orders') / $landingPages->sum('visits')) * 100, 1)
                : 0,
        ];

        $topLp = $landingPages->sortByDesc('total_orders')->first();
        $topRevenue = $landingPages->sortByDesc('total_revenue')->first();

        $dailyOrders = $this->getDailyOrders($dateFrom, $dateTo);
        $dailyRevenue = $this->getDailyRevenue($dateFrom, $dateTo);

        return view('admin.analytics.index', compact(
            'landingPages', 'overallStats', 'topLp', 'topRevenue',
            'dateFrom', 'dateTo', 'dailyOrders', 'dailyRevenue'
        ));
    }

    public function lpDetail(LandingPage $landingPage, Request $request)
    {
        $dateFrom = $request->date_from ?: now()->subDays(30)->format('Y-m-d');
        $dateTo = $request->date_to ?: now()->format('Y-m-d');

        $orders = $landingPage->orders()
            ->with(['shipment'])
            ->whereBetween('created_at', [$dateFrom, $dateTo . ' 23:59:59'])
            ->latest()
            ->get();

        $stats = [
            'visits' => $landingPage->visits,
            'total_orders' => $orders->count(),
            'paid_orders' => $orders->where('payment_status', 'paid')->count(),
            'total_revenue' => $orders->where('payment_status', 'paid')->sum('total_amount'),
            'conversion_rate' => $landingPage->visits > 0
                ? round(($orders->count() / $landingPage->visits) * 100, 1)
                : 0,
            'avg_order_value' => $orders->where('payment_status', 'paid')->count() > 0
                ? round($orders->where('payment_status', 'paid')->avg('total_amount'))
                : 0,
        ];

        $dailyOrders = $this->getLpDailyOrders($landingPage->id, $dateFrom, $dateTo);

        return view('admin.analytics.lp-detail', compact('landingPage', 'orders', 'stats', 'dateFrom', 'dateTo', 'dailyOrders'));
    }

    protected function getDailyOrders(string $from, string $to): array
    {
        $data = [];
        $start = \Carbon\Carbon::parse($from);
        $end = \Carbon\Carbon::parse($to);
        $current = $start->copy();

        while ($current <= $end) {
            $date = $current->format('Y-m-d');
            $data['labels'][] = $current->format('d M');
            $data['orders'][] = Order::whereDate('created_at', $date)->count();
            $current->addDay();
        }

        return $data;
    }

    protected function getDailyRevenue(string $from, string $to): array
    {
        $data = [];
        $start = \Carbon\Carbon::parse($from);
        $end = \Carbon\Carbon::parse($to);
        $current = $start->copy();

        while ($current <= $end) {
            $date = $current->format('Y-m-d');
            $data[] = (int) Order::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total_amount');
            $current->addDay();
        }

        return $data;
    }

    protected function getLpDailyOrders(int $lpId, string $from, string $to): array
    {
        $data = [];
        $start = \Carbon\Carbon::parse($from);
        $end = \Carbon\Carbon::parse($to);
        $current = $start->copy();

        while ($current <= $end) {
            $date = $current->format('Y-m-d');
            $data['labels'][] = $current->format('d M');
            $data['orders'][] = Order::where('landing_page_id', $lpId)
                ->whereDate('created_at', $date)
                ->count();
            $current->addDay();
        }

        return $data;
    }
}
