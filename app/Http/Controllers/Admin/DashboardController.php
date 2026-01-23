<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::query()->count();
        $totalUsers = User::query()->count();

        $totalRevenue = (int) Order::query()
            ->where('status', 'paid')
            ->sum('total_amount');

        $totalSalesQty = (int) OrderItem::query()
            ->whereHas('order', fn ($q) => $q->where('status', 'paid'))
            ->sum('qty');

        $recentOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        $recentUsers = User::query()
            ->latest()
            ->take(6)
            ->get();

        $end = now()->endOfDay();
        $start = now()->subDays(29)->startOfDay();

        $rows = Order::query()
            ->selectRaw('DATE(paid_at) as day, SUM(total_amount) as revenue, COUNT(*) as orders')
            ->where('status', 'paid')
            ->whereNotNull('paid_at')
            ->whereBetween('paid_at', [$start, $end])
            ->groupBy(DB::raw('DATE(paid_at)'))
            ->get();

        $byDay = $rows->keyBy(fn ($r) => (string) $r->day);

        $salesPerformance = [];
        $maxRevenue = 0;

        for ($i = 0; $i < 30; $i++) {
            $date = now()->subDays(29 - $i)->startOfDay();
            $key = $date->toDateString();
            $revenue = (int) ($byDay[$key]->revenue ?? 0);
            $orders = (int) ($byDay[$key]->orders ?? 0);

            $maxRevenue = max($maxRevenue, $revenue);

            $salesPerformance[] = [
                'label' => $date->format('d'),
                'labelLong' => $date->isoFormat('D MMM'),
                'date' => $key,
                'revenue' => $revenue,
                'orders' => $orders,
            ];
        }

        return view('admin.dashboard', [
            'totalSalesQty' => $totalSalesQty,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalUsers' => $totalUsers,
            'recentOrders' => $recentOrders,
            'recentUsers' => $recentUsers,
            'salesPerformance' => $salesPerformance,
            'maxRevenue' => max(1, $maxRevenue),
        ]);
    }
}
