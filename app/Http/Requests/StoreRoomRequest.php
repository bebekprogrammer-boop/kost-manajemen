<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan semua karena proteksi sudah ada di Middleware
    }

    public function rules(): array
    {
        // Ambil ID kamar jika sedang proses edit, agar validasi unique diabaikan untuk ID ini
        $roomId = $this->route('room') ? $this->route('room')->id : null;

        return [
            'room_number' => 'required|max:20|unique:rooms,room_number,' . $roomId,
            'type' => 'required|in:vvip,vip,regular',
            'price' => 'required|numeric|min:0',
            'floor' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'facilities' => 'nullable|array',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:5120', // Maksimal 5MB per foto
        ];
    }
}
