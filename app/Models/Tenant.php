<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tenant extends Model
{
    protected $fillable = ['room_id', 'name', 'phone', 'email', 'id_card_number', 'id_card_photo', 'check_in_date', 'rent_duration', 'due_date', 'status', 'notes']; //

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date', //
            'due_date' => 'date', //
        ];
    }

    protected static function booted()
    {
        // Hitung due_date otomatis saat dibuat
        static::creating(function ($tenant) { // [cite: 101]
            $tenant->due_date = Carbon::parse($tenant->check_in_date)->addMonths($tenant->rent_duration); // [cite: 101]
        });

        // Update status kamar otomatis setelah tenant disimpan/diubah statusnya
        static::saved(function ($tenant) { // [cite: 102]
            $tenant->room->updateStatus(); // [cite: 102]
        });
    }

    // Accessor untuk sisa hari
    public function getDaysUntilDueAttribute()
    {
        return now()->diffInDays($this->due_date, false); // [cite: 107]
    }

    public function room()
    {
        return $this->belongsTo(Room::class); //
    }

    public function payments()
    {
        return $this->hasMany(Payment::class); //
    }

    public function reminderLogs()
    {
        return $this->hasMany(ReminderLog::class); //
    }
}
