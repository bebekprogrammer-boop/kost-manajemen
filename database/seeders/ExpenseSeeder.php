<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;

class ExpenseSeeder extends Seeder
{
   public function run(): void {
    Expense::create(['category' => 'Listrik', 'amount' => 500000, 'expense_date' => now()->subDays(1)]);
    Expense::create(['category' => 'Air', 'amount' => 200000, 'expense_date' => now()->subDays(2)]);
    Expense::create(['category' => 'Internet', 'amount' => 300000, 'expense_date' => now()->subDays(3)]);
}
}
