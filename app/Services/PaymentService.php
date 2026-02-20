<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Tenant;
use Carbon\Carbon;

class PaymentService
{
    // 3.1.2 - Generate Invoice Number format INV-{Ymd}-{XXXX}
    public function generateInvoiceNumber(): string
    {
        $datePrefix = now()->format('Ymd');
        $countToday = Payment::whereDate('created_at', today())->count() + 1;
        return 'INV-' . $datePrefix . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
    }

    // 3.1.3 - Buat tagihan pertama saat tenant baru masuk
    public function createInitialPayment(Tenant $tenant): Payment
    {
        return Payment::create([
            'tenant_id' => $tenant->id,
            'room_id' => $tenant->room_id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'amount' => $tenant->room->price,
            'penalty' => 0,
            'total_amount' => $tenant->room->price,
            'period_start' => $tenant->check_in_date,
            'period_end' => $tenant->due_date,
            'status' => 'unpaid'
        ]);
    }

    // 3.1.4 - Konfirmasi pembayaran, hitung denda, dan perpanjang sewa
    public function recordPayment(int $tenantId, int $paidBy, ?string $notes = null): Payment
    {
        $tenant = Tenant::findOrFail($tenantId);

        // Ambil payment unpaid terbaru tenant
        $payment = $tenant->payments()->where('status', 'unpaid')->latest()->first();

        if (!$payment) {
            throw new \Exception('Tidak ada tagihan yang belum dibayar.');
        }

        // Hitung hari terlambat: bernilai positif jika due_date sudah lewat
        $daysLate = max(0, now()->diffInDays($tenant->due_date, false) * -1);

        // Hitung denda (Default 5000/hari jika tidak ada di config)
        $penaltyPerDay = config('app.penalty_per_day', 5000);
        $penaltyAmount = $daysLate * $penaltyPerDay;

        // Update payment saat ini menjadi PAID
        $payment->update([
            'penalty' => $penaltyAmount,
            'total_amount' => $payment->amount + $penaltyAmount,
            'payment_date' => today(),
            'status' => 'paid',
            'paid_by' => $paidBy,
            'notes' => $notes
        ]);

       // Perpanjang due_date tenant (Ubah menjadi addDays)
        $oldDueDate = $tenant->due_date;
        $newDueDate = Carbon::parse($oldDueDate)->addDays($tenant->rent_duration);
        // Disable event sementara agar status kamar tidak tereksekusi ulang tanpa perlu
        Tenant::withoutEvents(function () use ($tenant, $newDueDate) {
            $tenant->update(['due_date' => $newDueDate]);
        });

        // Buat payment/tagihan untuk periode berikutnya secara otomatis
        Payment::create([
            'tenant_id' => $tenant->id,
            'room_id' => $tenant->room_id,
            'invoice_number' => $this->generateInvoiceNumber(),
            'amount' => $tenant->room->price,
            'penalty' => 0,
            'total_amount' => $tenant->room->price,
            'period_start' => $oldDueDate,
            'period_end' => $newDueDate,
            'status' => 'unpaid'
        ]);

        return $payment;
    }
}
