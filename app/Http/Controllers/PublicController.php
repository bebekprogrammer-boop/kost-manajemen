<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Preview: ambil 1 kamar per tipe yang tersedia (untuk beranda)
        $previewRooms = collect();

        foreach (['vvip', 'vip', 'regular'] as $type) {
            $room = Room::where('type', $type)->orderBy('room_number')->first();
            if ($room) $previewRooms->push($room);
        }

        return view('public.index', compact('previewRooms'));
    }

    public function rooms()
    {
        $rooms = Room::orderBy('type')->orderBy('room_number')->get();
        return view('public.rooms', compact('rooms'));
    }

    public function showRoom(Room $room)
    {
        return view('public.room-detail', compact('room'));
    }
}
