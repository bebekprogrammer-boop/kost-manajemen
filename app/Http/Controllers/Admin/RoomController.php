<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query();
        if ($request->has('search')) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }
        $rooms = $query->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(StoreRoomRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('rooms', 'public');
            }
            $data['photos'] = $photos;
        }

        $room = Room::create($data);
        activity_log('create_room', $room, 'Menambahkan kamar baru: ' . $room->room_number);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(StoreRoomRequest $request, Room $room)
    {
        $data = $request->validated();

        if ($request->hasFile('photos')) {
            $photos = $room->photos ?? []; // Ambil foto lama
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('rooms', 'public'); // Append foto baru
            }
            $data['photos'] = $photos;
        }

        $room->update($data);
        activity_log('update_room', $room, 'Memperbarui data kamar: ' . $room->room_number);

        return redirect()->route('admin.rooms.index')->with('success', 'Data kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        // 1. Cek penghuni aktif
        if ($room->activeTenant()->exists()) {
            return redirect()->route('admin.rooms.index')->with('error', 'Kamar tidak dapat dihapus karena masih ada penghuni aktif!');
        }

        // 2. CEK RIWAYAT DATA (Penghuni lama / Pembayaran)
        $hasHistory = \App\Models\Tenant::where('room_id', $room->id)->exists() ||
                      \App\Models\Payment::where('room_id', $room->id)->exists();

        if ($hasHistory) {
            return redirect()->route('admin.rooms.index')->with('error', 'Kamar gagal dihapus! Kamar ini sudah memiliki riwayat penghuni atau pembayaran. Biarkan data ini demi menjaga integritas Laporan Keuangan.');
        }

        // Hapus foto dari storage
        if ($room->photos) {
            foreach ($room->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $roomNumber = $room->room_number;
        $room->delete();
        activity_log('delete_room', null, 'Menghapus kamar: ' . $roomNumber);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
