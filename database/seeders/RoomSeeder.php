<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void {
    Room::create(['room_number' => 'A-01', 'type' => 'vvip', 'price' => 2000000, 'floor' => 1]);
    Room::create(['room_number' => 'B-01', 'type' => 'vip', 'price' => 1500000, 'floor' => 1]);
    Room::create(['room_number' => 'B-02', 'type' => 'vip', 'price' => 1500000, 'floor' => 2]);
    Room::create(['room_number' => 'C-01', 'type' => 'regular', 'price' => 1000000, 'floor' => 2]);
    Room::create(['room_number' => 'C-02', 'type' => 'regular', 'price' => 1000000, 'floor' => 2]);
}
}
