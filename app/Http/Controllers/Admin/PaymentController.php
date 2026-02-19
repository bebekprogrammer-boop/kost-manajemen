<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['tenant', 'room'])->latest(); // [cite: 189]

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan bulan (berdasarkan created_at untuk unpaid, payment_date untuk paid)
        if ($request->filled('month')) {
            $month = date('m', strtotime($request->month));
            $year = date('Y', strtotime($request->month));
            $query->where(function($q) use ($month, $year) {
                $q->whereMonth('payment_date', $month)->whereYear('payment_date', $year)
                  ->orWhere(function($sub) use ($month, $year) {
                      $sub->whereNull('payment_date')
                          ->whereMonth('created_at', $month)
                          ->whereYear('created_at', $year);
                  });
            });
        }

        $payments = $query->paginate(15); // [cite: 189]
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['tenant', 'room', 'paidBy']); // [cite: 191]

        // Kalkulasi denda berjalan (simulasi hari ini) jika belum dibayar
        $currentPenalty = 0;
        if ($payment->status === 'unpaid') {
            $daysLate = max(0, now()->diffInDays($payment->tenant->due_date, false) * -1);
            $currentPenalty = $daysLate * config('app.penalty_per_day', 5000);
        }

        return view('admin.payments.show', compact('payment', 'currentPenalty')); // [cite: 192]
    }

    public function store(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id', //
            'notes' => 'nullable|string'
        ]);

        try {
            $payment = $paymentService->recordPayment($request->tenant_id, auth()->id(), $request->notes); //

            activity_log('confirm_payment', $payment, 'Mengonfirmasi pembayaran: ' . $payment->invoice_number); //

            return redirect()->route('admin.payments.show', $payment->id)
                             ->with('success', 'Pembayaran berhasil dikonfirmasi. Anda dapat mengunduh Invoice sekarang.'); //
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function generateInvoice(Payment $payment)
    {
        if ($payment->status !== 'paid') {
            return back()->with('error', 'Invoice hanya tersedia untuk tagihan yang sudah lunas.');
        }

        $payment->load(['tenant.room', 'paidBy']);

        $pdf = Pdf::loadView('admin.payments.invoice', compact('payment')); //
        return $pdf->download('Invoice-' . $payment->invoice_number . '.pdf'); //
    }
}
