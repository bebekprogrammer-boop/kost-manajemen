@extends('layouts.admin')
@section('title', 'Log Aktivitas')
@section('header', 'Riwayat Aktivitas Sistem')

@section('content')
<div class="p-4 mb-6 bg-white rounded shadow">
    <form action="{{ route('admin.activity-logs.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700">Filter User</label>
            <select name="user_id" class="border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ strtoupper($user->role) }})
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700">Filter Aksi</label>
            <input type="text" name="action" value="{{ request('action') }}" placeholder="Cari aksi..." class="border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700">Filter Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="px-4 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-700">Filter</button>
        <a href="{{ route('admin.activity-logs.index') }}" class="pb-2 text-gray-500 hover:underline">Reset</a>
    </form>
</div>

<div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full text-sm">
        <thead class="text-gray-700 bg-gray-50">
            <tr>
                <th class="w-1/4 px-6 py-3 text-left">User</th>
                <th class="w-1/6 px-6 py-3 text-left">Aksi (Kode)</th>
                <th class="w-1/3 px-6 py-3 text-left">Detail Deskripsi</th>
                <th class="w-1/6 px-6 py-3 text-left">IP Address</th>
                <th class="w-1/6 px-6 py-3 text-left">Waktu</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($logs as $log)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    @if($log->user)
                        <span class="block font-bold">{{ $log->user->name }}</span>
                        <span class="px-2 py-0.5 text-xs rounded {{ $log->user->role == 'super_admin' ? 'bg-purple-100 text-purple-800' : ($log->user->role == 'owner' ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800') }}">
                            {{ strtoupper($log->user->role) }}
                        </span>
                    @else
                        <span class="italic text-gray-500">Sistem / User Terhapus</span>
                    @endif
                </td>
                <td class="px-6 py-4 font-mono text-xs font-semibold text-blue-600">
                    {{ $log->action }}
                </td>
                <td class="px-6 py-4 text-gray-700">
                    {{ $log->description ?? '-' }}
                </td>
                <td class="px-6 py-4 font-mono text-xs text-gray-500">
                    {{ $log->ip_address ?? '-' }}
                </td>
                <td class="px-6 py-4 text-gray-500">
                    {{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada catatan aktivitas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $logs->links() }}
    </div>
</div>
@endsection
