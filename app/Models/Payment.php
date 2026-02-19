<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['tenant_id', 'room_id', 'invoice_number', 'amount', 'penalty', 'total_amount', 'payment_date', 'period_start', 'period_end', 'status', 'paid_by', 'notes']; //

    protected function casts(): array
    {
        return [
            'payment_date' => 'date', //
            'period_start' => 'date', //
            'period_end' => 'date', //
        ];
    }

    public function tenant() { return $this->belongsTo(Tenant::class); } //
    public function room() { return $this->belongsTo(Room::class); } //
    public function paidBy() { return $this->belongsTo(User::class, 'paid_by'); } //
}
