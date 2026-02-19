<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
   public function run(): void {
    User::create(['name' => 'Super Admin', 'email' => 'super_admin@kost.com', 'password' => Hash::make('password'), 'role' => 'super_admin']);
    User::create(['name' => 'Owner', 'email' => 'owner@kost.com', 'password' => Hash::make('password'), 'role' => 'owner']);
    User::create(['name' => 'Admin', 'email' => 'admin@kost.com', 'password' => Hash::make('password'), 'role' => 'admin']);
}
}
