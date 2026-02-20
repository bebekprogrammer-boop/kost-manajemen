<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\ReminderLog;

class ReminderService
{
    // 4.1.2 - Query penghuni berdasarkan tipe reminder
    public function getDueReminders(string $type)
    {
        // Ambil tenant yang aktif beserta kamar dan payment unpaid-nya
        $query = Tenant::where('status', 'active')
            ->with(['room', 'payments' => function($q) {
                $q->where('status', 'unpaid');
            }]);

        switch ($type) {
            case 'h7':
                $query->whereDate('due_date', now()->addDays(7));
                break;
            case 'h3':
                $query->whereDate('due_date', now()->addDays(3));
                break;
            case 'h0':
                $query->whereDate('due_date', today());
                break;
            case 'overdue':
                // Pastikan due_date lewat HARI INI dan masih memiliki tagihan unpaid
                $query->whereDate('due_date', '<', today())
                      ->whereHas('payments', function($q) {
                          $q->where('status', 'unpaid');
                      });
                break;
        }

        return $query->get();
    }

    // 4.1.5 - Format nomor 08xxx menjadi 628xxx
    public function formatPhone(string $phone): string
    {
        // Hapus semua karakter selain angka
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Ganti angka 0 di depan dengan 62
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        return $phone;
    }

    // 4.1.3 - Template pesan sesuai tipe
    public function buildMessage(Tenant $tenant, string $type): string
    {
        $payment = $tenant->payments->where('status', 'unpaid')->first();
        $amount = $payment ? number_format($payment->amount, 0, ',', '.') : '0';
        $roomName = $tenant->room->room_number;
        $dueDate = \Carbon\Carbon::parse($tenant->due_date)->format('d/m/Y');
        $name = $tenant->name;

        switch ($type) {
            case 'h7':
                return "Halo {$name}, sewa Kamar {$roomName} akan jatuh tempo pada {$dueDate}. Total tagihan: Rp {$amount}. Mohon untuk segera melakukan pembayaran. Terima kasih!";
            case 'h3':
                return "Halo {$name}, ⚠️ sewa Kamar {$roomName} jatuh tempo 3 hari lagi ({$dueDate}). Total: Rp {$amount}. Mohon segera lakukan pembayaran. Terima kasih!";
            case 'h0':
                return "Halo {$name}, 🔴 HARI INI batas pembayaran sewa Kamar {$roomName}. Total tagihan: Rp {$amount}. Segera bayar untuk menghindari denda. Terima kasih!";
            case 'overdue':
                $daysLate = max(0, now()->diffInDays($tenant->due_date, false) * -1);
                $penalty = $daysLate * config('app.penalty_per_day', 5000);
                $totalAmount = $payment ? $payment->amount + $penalty : 0;
                $formattedTotal = number_format($totalAmount, 0, ',', '.');
                return "Halo {$name}, ❗ sewa Kamar {$roomName} sudah melewati jatuh tempo ({$dueDate}). Denda: Rp 5.000/hari. Total saat ini: Rp {$formattedTotal}. Hubungi admin segera. Terima kasih!";
            default:
                return "Halo {$name}, ini adalah pengingat pembayaran untuk Kamar {$roomName}.";
        }
    }

    // 4.1.4 - Build URL WhatsApp redirect
    public function buildWhatsAppUrl(Tenant $tenant, string $type): string
    {
        $formattedPhone = $this->formatPhone($tenant->phone);
        $message = $this->buildMessage($tenant, $type);

        return 'https://wa.me/' . $formattedPhone . '?text=' . urlencode($message);
    }

    // 4.1.6 - Simpan log ke tabel reminder_logs
    public function logReminder(Tenant $tenant, string $type, string $url): ReminderLog
    {
        $payment = $tenant->payments->where('status', 'unpaid')->first();
        $message = $this->buildMessage($tenant, $type);

        return ReminderLog::create([
            'tenant_id' => $tenant->id,
            'payment_id' => $payment ? $payment->id : null,
            'type' => $type,
            'message' => $message,
            'phone' => $this->formatPhone($tenant->phone),
            'wa_url' => $url,
            'status' => 'sent', // Asumsi selalu 'sent' karena WA redirect terbuka
            'sent_at' => now(),
        ]);
    }

    // 4.1.7 - Cek apakah log sudah dibuat hari ini (untuk memunculkan badge)
    public function alreadySentToday(Tenant $tenant, string $type): bool
    {
        return ReminderLog::where('tenant_id', $tenant->id)
            ->where('type', $type)
            ->whereDate('sent_at', today())
            ->exists();
    }
}
