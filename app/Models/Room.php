<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_number', 'type', 'price', 'status', 'floor', 'description', 'facilities', 'photos']; //

    protected function casts(): array
    {
        return [
            'facilities' => 'array', //
            'photos' => 'array', //
            'price' => 'decimal:2', //
        ];
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class); //
    }

    public function activeTenant()
    {
        return $this->hasOne(Tenant::class)->where('status', 'active')->latestOfMany(); //
    }

    public function updateStatus()
    {
        $hasActiveTenant = $this->activeTenant()->exists();
        $this->update(['status' => $hasActiveTenant ? 'occupied' : 'available']); //
    }
}
