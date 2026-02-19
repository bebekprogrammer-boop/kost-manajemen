<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'subject_type', 'subject_id', 'description', 'ip_address']; //

    public const UPDATED_AT = null; // Karena timestamps only created_at

    public function user() { return $this->belongsTo(User::class); } //
}
