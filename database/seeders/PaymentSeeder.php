<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void {
    Payment::create(['tenant_id' => 1, 'room_id' => 1, 'invoice_number' => 'INV-'.now()->format('Ymd').'-0001', 'amount' => 2000000, 'total_amount' => 2000000, 'period_start' => now()->subDays(10), 'period_end' => now()->addDays(20), 'status' => 'paid', 'payment_date' => now()->subDays(9), 'paid_by' => 3]);
    Payment::create(['tenant_id' => 2, 'room_id' => 2, 'invoice_number' => 'INV-'.now()->format('Ymd').'-0002', 'amount' => 1500000, 'total_amount' => 1500000, 'period_start' => now()->subDays(5), 'period_end' => now()->addMonths(3)->subDays(5), 'status' => 'paid', 'payment_date' => now()->subDays(4), 'paid_by' => 3]);
    // Unpaid
    Payment::create(['tenant_id' => 3, 'room_id' => 4, 'invoice_number' => 'INV-'.now()->format('Ymd').'-0003', 'amount' => 1000000, 'total_amount' => 1000000, 'period_start' => now()->subDays(2), 'period_end' => now()->addMonths(6)->subDays(2), 'status' => 'unpaid']);
}
}
