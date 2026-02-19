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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 20)->unique(); // [cite: 51]
            $table->enum('type', ['vvip', 'vip', 'regular']); // [cite: 52]
            $table->decimal('price', 12, 2); // [cite: 53]
            $table->enum('status', ['available', 'occupied'])->default('available'); // [cite: 54]
            $table->tinyInteger('floor')->default(1); // [cite: 55]
            $table->text('description')->nullable(); // [cite: 56]
            $table->json('facilities')->nullable(); // [cite: 57]
            $table->json('photos')->nullable(); // [cite: 58]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
