@extends('layouts.admin')
@section('title', 'Manajemen Kamar')
@section('header', 'Daftar Kamar')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <form action="{{ route('admin.rooms.index') }}" method="GET" class="flex">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Kamar..." class="rounded-l border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700">Cari</button>
    </form>
    <a href="{{ route('admin.rooms.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Tambah Kamar</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
@endif

<div class="bg-white rounded shadow overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-50 text-gray-700">
            <tr>
                <th class="px-6 py-3 text-left">No. Kamar</th>
                <th class="px-6 py-3 text-left">Tipe</th>
                <th class="px-6 py-3 text-left">Harga</th>
                <th class="px-6 py-3 text-left">Lantai</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($rooms as $room)
            <tr>
                <td class="px-6 py-4 font-semibold">{{ $room->room_number }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded bg-{{ $room->type == 'vvip' ? 'purple' : ($room->type == 'vip' ? 'blue' : 'gray') }}-200 text-{{ $room->type == 'vvip' ? 'purple' : ($room->type == 'vip' ? 'blue' : 'gray') }}-800 uppercase">{{ $room->type }}</span>
                </td>
                <td class="px-6 py-4">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">{{ $room->floor }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $room->status == 'available' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $room->status == 'available' ? 'Tersedia' : 'Terisi' }}
                    </span>
                </td>
                <td class="px-6 py-4 flex space-x-2">
                    <a href="{{ route('admin.rooms.edit', $room) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kamar ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center">Belum ada data kamar.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $rooms->links() }}</div>
</div>
@endsection
