@extends('layouts.admin')
@section('title', 'Manajemen Penghuni')
@section('header', 'Daftar Penghuni')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <form action="{{ route('admin.tenants.index') }}" method="GET" class="flex space-x-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama..." class="rounded border-gray-300 focus:ring-blue-500 focus:border-blue-500">
        <select name="status" class="rounded border-gray-300">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="alumni" {{ request('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
    </form>
    <a href="{{ route('admin.tenants.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Tambah Penghuni</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full">
        <thead class="bg-gray-50 text-gray-700">
            <tr>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-left">Kamar</th>
                <th class="px-6 py-3 text-left">Tipe</th>
                <th class="px-6 py-3 text-left">Due Date</th>
                <th class="px-6 py-3 text-left">Sisa Hari</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($tenants as $tenant)
            <tr>
                <td class="px-6 py-4 font-semibold">{{ $tenant->name }}<br><span class="text-xs text-gray-500">{{ $tenant->phone }}</span></td>
                <td class="px-6 py-4">{{ $tenant->room->room_number }}</td>
                <td class="px-6 py-4 uppercase text-xs">{{ $tenant->room->type }}</td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d M Y') }}</td>
                <td class="px-6 py-4 font-bold">
                    @php $days = $tenant->days_until_due; @endphp
                    @if($tenant->status == 'alumni')
                        <span class="text-gray-500">-</span>
                    @elseif($days > 7)
                        <span class="text-green-600">{{ $days }} Hari</span>
                    @elseif($days >= 3)
                        <span class="text-yellow-600">{{ $days }} Hari</span>
                    @else
                        <span class="text-red-600">{{ $days }} Hari</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs rounded {{ $tenant->status == 'active' ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                        {{ ucfirst($tenant->status) }}
                    </span>
                </td>
                <td class="px-6 py-4 flex space-x-2">
                    <a href="{{ route('admin.tenants.show', $tenant) }}" class="text-blue-600 hover:underline">Detail</a>
                    <a href="{{ route('admin.tenants.edit', $tenant) }}" class="text-yellow-600 hover:underline">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="px-6 py-4 text-center">Belum ada data penghuni.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $tenants->links() }}</div>
</div>
@endsection
