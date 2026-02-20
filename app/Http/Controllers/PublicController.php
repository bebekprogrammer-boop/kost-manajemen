<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Mengambil semua kamar, diurutkan berdasarkan tipe lalu nomor kamar
        $rooms = Room::orderBy('type')->orderBy('room_number')->get(); // [cite: 209]
        return view('public.index', compact('rooms')); // [cite: 209]
    }

    public function showRoom(Room $room)
    {
        return view('public.room-detail', compact('room')); // [cite: 210]
    }
}