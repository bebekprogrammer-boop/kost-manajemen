@extends('layouts.admin')
@section('title', 'Edit Penghuni')
@section('header', 'Edit Data Penghuni')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-3xl">
    <form action="{{ route('admin.tenants.update', $tenant) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Kamar (Tidak bisa diubah)</label>
                <input type="text" value="{{ $tenant->room->room_number }} - {{ strtoupper($tenant->room->type) }}" disabled class="w-full border-gray-300 bg-gray-100 rounded mt-1">
                <input type="hidden" name="room_id" value="{{ $tenant->room_id }}">
            </div>
            <div>
                <label class="block text-gray-700">Durasi Sewa Perpanjangan</label>
                <select name="rent_duration" required class="w-full border-gray-300 rounded mt-1">
                    <option value="1" {{ old('rent_duration', $tenant->rent_duration) == 1 ? 'selected' : '' }}>1 Bulan</option>
                    <option value="3" {{ old('rent_duration', $tenant->rent_duration) == 3 ? 'selected' : '' }}>3 Bulan</option>
                    <option value="6" {{ old('rent_duration', $tenant->rent_duration) == 6 ? 'selected' : '' }}>6 Bulan</option>
                    <option value="12" {{ old('rent_duration', $tenant->rent_duration) == 12 ? 'selected' : '' }}>12 Bulan</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $tenant->name) }}" required class="w-full border-gray-300 rounded mt-1">
            </div>
            <div>
                <label class="block text-gray-700">No. HP / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $tenant->phone) }}" required class="w-full border-gray-300 rounded mt-1">
            </div>
            <div>
                <label class="block text-gray-700">Tanggal Masuk (Check In)</label>
                <input type="date" name="check_in_date" value="{{ old('check_in_date', $tenant->check_in_date->format('Y-m-d')) }}" required class="w-full border-gray-300 rounded mt-1">
            </div>
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $tenant->email) }}" class="w-full border-gray-300 rounded mt-1">
            </div>
            <div>
                <label class="block text-gray-700">NIK (Nomor KTP)</label>
                <input type="text" name="id_card_number" value="{{ old('id_card_number', $tenant->id_card_number) }}" class="w-full border-gray-300 rounded mt-1">
            </div>
            <div>
                <label class="block text-gray-700">Foto KTP Baru (Abaikan jika tidak ingin mengubah)</label>
                <input type="file" name="id_card_photo" accept="image/*" class="w-full mt-1">
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Catatan Internal</label>
            <textarea name="notes" rows="3" class="w-full border-gray-300 rounded mt-1">{{ old('notes', $tenant->notes) }}</textarea>
        </div>

        <div class="flex justify-end space-x-2 pt-4">
            <a href="{{ route('admin.tenants.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui Penghuni</button>
        </div>
    </form>
</div>
@endsection
