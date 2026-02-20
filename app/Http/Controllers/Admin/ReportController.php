<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportPdf(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $parsedMonth = date('m', strtotime($month));
        $parsedYear = date('Y', strtotime($month));

        $payments = Payment::where('status', 'paid')
                    ->whereMonth('payment_date', $parsedMonth)->whereYear('payment_date', $parsedYear)
                    ->with('tenant', 'room')->get();

        $expenses = Expense::whereMonth('expense_date', $parsedMonth)->whereYear('expense_date', $parsedYear)->get();

        $income = $payments->sum('total_amount');
        $expense = $expenses->sum('amount');
        $netProfit = $income - $expense;

        $pdf = Pdf::loadView('admin.reports.pdf', compact('month', 'payments', 'expenses', 'income', 'expense', 'netProfit'));
        return $pdf->download("Laporan_Keuangan_KOST_{$month}.pdf");
    }

    // 2. Fungsi Export CSV (Bisa dibuka di Excel)
    public function exportCsv(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $parsedMonth = date('m', strtotime($month));
        $parsedYear = date('Y', strtotime($month));

        $payments = Payment::where('status', 'paid')
                    ->whereMonth('payment_date', $parsedMonth)->whereYear('payment_date', $parsedYear)->get();
        $expenses = Expense::whereMonth('expense_date', $parsedMonth)->whereYear('expense_date', $parsedYear)->get();

        $fileName = "Laporan_Keuangan_KOST_{$month}.csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($payments, $expenses, $month) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['LAPORAN KEUANGAN BULAN', $month]);
            fputcsv($file, []); // Baris kosong

            // Bagian Pemasukan
            fputcsv($file, ['--- PEMASUKAN ---']);
            fputcsv($file, ['Tanggal Bayar', 'Kamar', 'Nama Penghuni', 'Nominal (Rp)']);
            $totalIncome = 0;
            foreach ($payments as $p) {
                fputcsv($file, [$p->payment_date, $p->room->room_number, $p->tenant->name, $p->total_amount]);
                $totalIncome += $p->total_amount;
            }
            fputcsv($file, ['TOTAL PEMASUKAN', '', '', $totalIncome]);
            fputcsv($file, []);

            // Bagian Pengeluaran
            fputcsv($file, ['--- PENGELUARAN ---']);
            fputcsv($file, ['Tanggal', 'Kategori', 'Keterangan', 'Nominal (Rp)']);
            $totalExpense = 0;
            foreach ($expenses as $e) {
                fputcsv($file, [$e->expense_date, $e->category, $e->description ?? '-', $e->amount]);
                $totalExpense += $e->amount;
            }
            fputcsv($file, ['TOTAL PENGELUARAN', '', '', $totalExpense]);
            fputcsv($file, []);

            // Laba Bersih
            fputcsv($file, ['LABA BERSIH', '', '', $totalIncome - $totalExpense]);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
