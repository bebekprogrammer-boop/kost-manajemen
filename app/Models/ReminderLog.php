<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReminderLog extends Model
{
    protected $fillable = ['tenant_id', 'payment_id', 'type', 'message', 'phone', 'wa_url', 'status', 'sent_at']; //

    public $timestamps = false; // Kita atur manual karena migration sebelumnya tidak pakai timestamps lengkap

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime', //
        ];
    }

    public function tenant() { return $this->belongsTo(Tenant::class); } //
    public function payment() { return $this->belongsTo(Payment::class); } //
}
