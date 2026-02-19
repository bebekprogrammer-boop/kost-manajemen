<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete(); // [cite: 78]
            $table->foreignId('room_id')->constrained()->restrictOnDelete(); // [cite: 79]
            $table->string('invoice_number', 30)->unique(); // [cite: 80]
            $table->decimal('amount', 12, 2); // [cite: 81]
            $table->decimal('penalty', 12, 2)->default(0); // [cite: 82]
            $table->decimal('total_amount', 12, 2); // [cite: 83]
            $table->date('payment_date')->nullable(); // [cite: 84]
            $table->date('period_start'); // [cite: 85]
            $table->date('period_end'); // [cite: 86]
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid'); // [cite: 87]
            $table->foreignId('paid_by')->nullable()->constrained('users')->nullOnDelete(); // [cite: 88]
            $table->text('notes')->nullable(); // [cite: 89]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
