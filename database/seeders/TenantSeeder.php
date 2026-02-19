<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;

class TenantSeeder extends Seeder
{


public function run(): void {
    // Data dummy ini akan otomatis men-trigger booted event untuk hitung due_date dan update status kamar
    Tenant::create(['room_id' => 1, 'name' => 'Budi', 'phone' => '6281111111', 'check_in_date' => now()->subDays(10), 'rent_duration' => 1]);
    Tenant::create(['room_id' => 2, 'name' => 'Siti', 'phone' => '6282222222', 'check_in_date' => now()->subDays(5), 'rent_duration' => 3]);
    Tenant::create(['room_id' => 4, 'name' => 'Andi', 'phone' => '6283333333', 'check_in_date' => now()->subDays(2), 'rent_duration' => 6]);
    // Alumni
    Tenant::create(['room_id' => 5, 'name' => 'Joko', 'phone' => '6284444444', 'check_in_date' => now()->subMonths(2), 'rent_duration' => 1, 'status' => 'alumni']);
}
}
