<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Set lokalisasi waktu ke bahasa Indonesia untuk nama bulan
        Carbon::setLocale('id');

        $month = $request->input('month', now()->format('Y-m'));
        $parsedMonth = date('m', strtotime($month));
        $parsedYear = date('Y', strtotime($month));

        // 1. Kalkulasi Bulan Ini / Bulan Terpilih
        $income = Payment::where('status', 'paid')
                    ->whereMonth('payment_date', $parsedMonth)
                    ->whereYear('payment_date', $parsedYear)
                    ->sum('total_amount');

        $expense = Expense::whereMonth('expense_date', $parsedMonth)
                    ->whereYear('expense_date', $parsedYear)
                    ->sum('amount');

        $netProfit = $income - $expense;

        // 2. Siapkan Data untuk Chart.js (Trend 6 Bulan Terakhir)
        $chartData = [
            'labels' => [],
            'income' => [],
            'expense' => []
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $m = $date->month;
            $y = $date->year;

            $inc = Payment::where('status', 'paid')
                    ->whereMonth('payment_date', $m)
                    ->whereYear('payment_date', $y)
                    ->sum('total_amount');

            $exp = Expense::whereMonth('expense_date', $m)
                    ->whereYear('expense_date', $y)
                    ->sum('amount');

            $chartData['labels'][] = $date->translatedFormat('F Y');
            $chartData['income'][] = $inc;
            $chartData['expense'][] = $exp;
        }

        return view('admin.reports.index', compact('month', 'income', 'expense', 'netProfit', 'chartData'));
    }
}
