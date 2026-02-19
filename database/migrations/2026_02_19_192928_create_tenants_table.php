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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->restrictOnDelete(); // [cite: 63]
            $table->string('name', 100); // [cite: 64]
            $table->string('phone', 20); // [cite: 65]
            $table->string('email', 150)->nullable(); // [cite: 66]
            $table->string('id_card_number', 50)->nullable(); // [cite: 67]
            $table->string('id_card_photo')->nullable(); // [cite: 68]
            $table->date('check_in_date'); // [cite: 69]
            $table->tinyInteger('rent_duration')->default(1); // [cite: 70]
            $table->date('due_date')->nullable();
            $table->enum('status', ['active', 'alumni'])->default('active'); // [cite: 72]
            $table->text('notes')->nullable(); // [cite: 73]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
