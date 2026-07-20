<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ExpenseRecord;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Klien/Customer diarahkan ke katalog / myorder
        if ($user->role === 'Customer') {
            return redirect()->route('katalog.index');
        }

        // METRIK BISNIS UTAMA (KPI)
        $revenue = Order::where('status', 'Paid')->sum('total_amount');
        $expense = ExpenseRecord::sum('amount');
        $profit = $revenue - $expense;
        
        $activeOrdersCount = Order::whereIn('status', ['Pending', 'Confirmed'])->count();
        $totalOrdersCount = Order::count();
        $avgRating = Testimonial::avg('rating') ?? 0;

        // DATA TABEL: 5 Pesanan Terbaru
        $recentOrders = Order::with(['customer', 'event'])->latest()->take(5)->get();

        // DATA GRAFIK (Simulasi per bulan untuk Chart)
        // Berhubung data seeder umumnya dibuat di sekitar bulan ini, 
        // kita generate data dinamis 6 bulan terakhir.
        $months = [];
        $revenueData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            
            $months[] = $monthStart->format('M Y');
            
            $revenueData[] = Order::where('status', 'Paid')
                ->whereBetween('order_date', [$monthStart, $monthEnd])
                ->sum('total_amount');
                
            $expenseData[] = ExpenseRecord::whereBetween('expense_date', [$monthStart, $monthEnd])
                ->sum('amount');
        }

        return view('dashboard.index', [
            'title' => 'Dashboard Bisnis',
            'revenue' => $revenue,
            'expense' => $expense,
            'profit' => $profit,
            'activeOrdersCount' => $activeOrdersCount,
            'totalOrdersCount' => $totalOrdersCount,
            'avgRating' => round($avgRating, 1),
            'recentOrders' => $recentOrders,
            'chartMonths' => json_encode($months),
            'chartRevenue' => json_encode($revenueData),
            'chartExpense' => json_encode($expenseData),
        ]);
    }
}
