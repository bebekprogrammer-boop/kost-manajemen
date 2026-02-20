<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $parsedMonth = date('m', strtotime($month));
        $parsedYear = date('Y', strtotime($month));

        // Ambil data pengeluaran di bulan yang dipilih
        $expenses = Expense::whereMonth('expense_date', $parsedMonth)
                           ->whereYear('expense_date', $parsedYear)
                           ->latest('expense_date')
                           ->get();

        $totalExpense = $expenses->sum('amount');

        return view('admin.expenses.index', compact('expenses', 'month', 'totalExpense'));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|in:Listrik,Air,Internet,Kebersihan,Perbaikan,Lainnya',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'receipt_photo' => 'nullable|image|max:5120'
        ]);

        if ($request->hasFile('receipt_photo')) {
            $validated['receipt_photo'] = $request->file('receipt_photo')->store('receipts', 'public');
        }
        
        $validated['recorded_by'] = auth()->id();

        $expense = Expense::create($validated);
        
        activity_log('create_expense', $expense, "Mencatat pengeluaran {$expense->category} sebesar Rp " . number_format($expense->amount, 0, ',', '.'));

        return redirect()->route('admin.expenses.index')->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'category' => 'required|string|in:Listrik,Air,Internet,Kebersihan,Perbaikan,Lainnya',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
            'description' => 'nullable|string',
            'receipt_photo' => 'nullable|image|max:5120'
        ]);

        if ($request->hasFile('receipt_photo')) {
            if ($expense->receipt_photo) {
                Storage::disk('public')->delete($expense->receipt_photo);
            }
            $validated['receipt_photo'] = $request->file('receipt_photo')->store('receipts', 'public');
        }

        $expense->update($validated);
        
        activity_log('update_expense', $expense, "Memperbarui pengeluaran {$expense->category}");

        return redirect()->route('admin.expenses.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->receipt_photo) {
            Storage::disk('public')->delete($expense->receipt_photo);
        }
        
        $category = $expense->category;
        $expense->delete();
        
        activity_log('delete_expense', null, "Menghapus pengeluaran: {$category}");

        return redirect()->route('admin.expenses.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}