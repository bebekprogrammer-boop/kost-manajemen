<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Payment;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');

        // 1. Statistik Kamar & Penghuni
        $total_rooms = Room::count();
        $occupied_rooms = Room::where('status', 'occupied')->count();
        $available_rooms = Room::where('status', 'available')->count();
        $active_tenants = Tenant::where('status', 'active')->count();

        // 2. Keuangan Bulan Ini
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthly_income = Payment::where('status', 'paid')
            ->whereMonth('payment_date', $currentMonth)
            ->whereYear('payment_date', $currentYear)
            ->sum('total_amount');

        $monthly_expense = Expense::whereMonth('expense_date', $currentMonth)
            ->whereYear('expense_date', $currentYear)
            ->sum('amount');

        $net_profit = $monthly_income - $monthly_expense;

        // 3. Data Grafik (Trend 6 Bulan Terakhir)
        $chartData = [
            'labels' => [],
            'income' => [],
            'expense' => []
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $m = $date->month;
            $y = $date->year;

            $chartData['labels'][] = $date->translatedFormat('M Y');

            $chartData['income'][] = Payment::where('status', 'paid')
                ->whereMonth('payment_date', $m)
                ->whereYear('payment_date', $y)
                ->sum('total_amount');

            $chartData['expense'][] = Expense::whereMonth('expense_date', $m)
                ->whereYear('expense_date', $y)
                ->sum('amount');
        }

        // 4. Tabel Jatuh Tempo Terdekat (H-0 s/d H-7)
        $upcoming_due = Tenant::where('status', 'active')
            ->whereBetween('due_date', [today(), today()->addDays(7)])
            ->with('room')
            ->orderBy('due_date')
            ->take(7)
            ->get();

        // 5. Tabel Penghuni Overdue
        $overdue_tenants = Tenant::where('status', 'active')
            ->whereDate('due_date', '<', today())
            ->with('room')
            ->get();

        return view('admin.dashboard', compact(
            'total_rooms', 'occupied_rooms', 'available_rooms', 'active_tenants',
            'monthly_income', 'monthly_expense', 'net_profit',
            'chartData', 'upcoming_due', 'overdue_tenants'
        ));
    }
}
