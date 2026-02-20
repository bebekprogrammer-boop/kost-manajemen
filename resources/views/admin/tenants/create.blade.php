@extends('layouts.admin')
@section('title', 'Tambah Penghuni')
@section('header', 'Tambah Penghuni Baru')

@section('content')
<div class="max-w-3xl p-6 bg-white rounded shadow">
    <form action="{{ route('admin.tenants.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Pilih Kamar (Tersedia)</label>
                <select name="room_id" required class="w-full mt-1 border-gray-300 rounded">
                    <option value="">-- Pilih Kamar --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->room_number }} - {{ strtoupper($room->type) }} (Rp {{ number_format($room->price, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
                @error('room_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700">Durasi Sewa Awal</label>
               <select name="rent_duration" required class="w-full mt-1 border-gray-300 rounded">
                    <option value="1" {{ old('rent_duration') == 1 ? 'selected' : '' }}>1 Hari (Testing H-0)</option>
                    <option value="2" {{ old('rent_duration') == 2 ? 'selected' : '' }}>2 Hari</option>
                    <option value="3" {{ old('rent_duration') == 3 ? 'selected' : '' }}>3 Hari (Testing H-3)</option>
                    <option value="7" {{ old('rent_duration') == 7 ? 'selected' : '' }}>7 Hari (Testing H-7)</option>
                    <option value="30" {{ old('rent_duration') == 30 ? 'selected' : '' }}>1 Bulan (30 Hari)</option>
                    <option value="90" {{ old('rent_duration') == 90 ? 'selected' : '' }}>3 Bulan (90 Hari)</option>
                    <option value="180" {{ old('rent_duration') == 180 ? 'selected' : '' }}>6 Bulan (180 Hari)</option>
                    <option value="365" {{ old('rent_duration') == 365 ? 'selected' : '' }}>1 Tahun (365 Hari)</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full mt-1 border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700">No. HP / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="Contoh: 628123456789" class="w-full mt-1 border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700">Tanggal Masuk (Check In)</label>
                <input type="date" name="check_in_date" value="{{ old('check_in_date', date('Y-m-d')) }}" required class="w-full mt-1 border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700">Email (Opsional)</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700">NIK (Nomor KTP)</label>
                <input type="text" name="id_card_number" value="{{ old('id_card_number') }}" class="w-full mt-1 border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700">Foto KTP (Opsional)</label>
                <input type="file" name="id_card_photo" accept="image/*" class="w-full mt-1">
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Catatan Internal</label>
            <textarea name="notes" rows="3" class="w-full mt-1 border-gray-300 rounded">{{ old('notes') }}</textarea>
        </div>

        <div class="flex justify-end pt-4 space-x-2">
            <a href="{{ route('admin.tenants.index') }}" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan Penghuni</button>
        </div>
    </form>
</div>
@endsection
