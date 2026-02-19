<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['category', 'amount', 'expense_date', 'description', 'receipt_photo', 'recorded_by']; //

    protected function casts(): array
    {
        return [
            'expense_date' => 'date', //
        ];
    }

    public function recordedBy() { return $this->belongsTo(User::class, 'recorded_by'); } //
}
