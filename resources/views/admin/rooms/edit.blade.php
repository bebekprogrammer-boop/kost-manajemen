@extends('layouts.admin')
@section('title', 'Edit Kamar')
@section('header', 'Edit Data Kamar')

@section('content')
<div class="bg-white p-6 rounded shadow max-w-3xl">
    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">No. Kamar</label>
                <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required class="w-full border-gray-300 rounded mt-1">
            </div>
            <div>
                <label class="block text-gray-700">Tipe</label>
                <select name="type" required class="w-full border-gray-300 rounded mt-1">
                    <option value="regular" {{ $room->type == 'regular' ? 'selected' : '' }}>Regular</option>
                    <option value="vip" {{ $room->type == 'vip' ? 'selected' : '' }}>VIP</option>
                    <option value="vvip" {{ $room->type == 'vvip' ? 'selected' : '' }}>VVIP</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', round($room->price)) }}" required min="0" class="w-full border-gray-300 rounded mt-1">
            </div>
            <div>
                <label class="block text-gray-700">Lantai</label>
                <input type="number" name="floor" value="{{ old('floor', $room->floor) }}" required min="1" class="w-full border-gray-300 rounded mt-1">
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Fasilitas</label>
            <div class="mt-2 grid grid-cols-3 gap-2">
                @php $currentFacilities = $room->facilities ?? []; @endphp
                @foreach(['AC', 'Kamar Mandi Dalam', 'WiFi', 'TV', 'Lemari', 'Kasur Springbed', 'Meja Belajar'] as $fasilitas)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="facilities[]" value="{{ $fasilitas }}" {{ in_array($fasilitas, $currentFacilities) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                    <span class="ml-2">{{ $fasilitas }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border-gray-300 rounded mt-1">{{ old('description', $room->description) }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700">Upload Foto Tambahan</label>
            <input type="file" name="photos[]" multiple accept="image/*" class="w-full mt-1">

            @if($room->photos)
            <div class="mt-4 flex gap-2">
                @foreach($room->photos as $photo)
                    <img src="{{ asset('storage/' . $photo) }}" class="w-24 h-24 object-cover rounded border">
                @endforeach
            </div>
            @endif
        </div>

        <div class="flex justify-end space-x-2 pt-4">
            <a href="{{ route('admin.rooms.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Perbarui Kamar</button>
        </div>
    </form>
</div>
@endsection
