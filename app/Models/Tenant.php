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
        static::creating(function ($tenant) {
            if ($tenant->check_in_date && $tenant->rent_duration) {
                $tenant->due_date = \Carbon\Carbon::parse($tenant->check_in_date)->addDays((int) $tenant->rent_duration);
            }
        });

        // Trigger saat tenant baru dibuat atau diedit
        static::saved(function ($tenant) {
            // Update status kamar yang sekarang
            if ($tenant->room) {
                $tenant->room->updateStatus();
            }

            // Jika tenant dipindah ke kamar lain (edit room_id), update juga kamar lamanya
            if ($tenant->isDirty('room_id') && $tenant->getOriginal('room_id')) {
                $oldRoom = \App\Models\Room::find($tenant->getOriginal('room_id'));
                if ($oldRoom) {
                    $oldRoom->updateStatus();
                }
            }
        });

        // Trigger saat data tenant dihapus dari sistem
        static::deleted(function ($tenant) {
            if ($tenant->room) {
                $tenant->room->updateStatus();
            }
        });
    }

    // Accessor untuk sisa hari
    public function getDaysUntilDueAttribute()
    {
        if (!$this->due_date) return 0;

        // Gunakan today() agar jam dikunci di 00:00:00
        $sekarang = \Carbon\Carbon::today();
        $jatuhTempo = \Carbon\Carbon::parse($this->due_date)->startOfDay();

        // Paksa hasil perhitungan menjadi tipe data Integer (bilangan bulat)
        $selisihHari = $sekarang->diffInDays($jatuhTempo, false);

        return (int) round($selisihHari);
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
