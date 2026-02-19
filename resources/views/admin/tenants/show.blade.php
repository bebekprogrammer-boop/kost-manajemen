@extends('layouts.admin')
@section('title', 'Detail Penghuni')
@section('header', 'Detail Data Penghuni')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="col-span-1 bg-white p-6 rounded shadow">
        <h3 class="text-lg font-bold border-b pb-2 mb-4">Profil Penghuni</h3>

        <div class="space-y-3 text-sm">
            <p><span class="text-gray-500 block">Nama Lengkap</span> <span class="font-semibold text-lg">{{ $tenant->name }}</span></p>
            <p><span class="text-gray-500 block">Status</span>
                <span class="px-2 py-1 text-xs rounded {{ $tenant->status == 'active' ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800' }}">
                    {{ ucfirst($tenant->status) }}
                </span>
            </p>
            <p><span class="text-gray-500 block">Kamar</span> <span class="font-semibold">{{ $tenant->room->room_number }} (Tipe: {{ strtoupper($tenant->room->type) }})</span></p>
            <p><span class="text-gray-500 block">No. HP/WA</span> {{ $tenant->phone }}</p>
            <p><span class="text-gray-500 block">Email</span> {{ $tenant->email ?? '-' }}</p>
            <p><span class="text-gray-500 block">Check In Date</span> {{ \Carbon\Carbon::parse($tenant->check_in_date)->format('d M Y') }}</p>
            <p><span class="text-gray-500 block">Jatuh Tempo (Due Date)</span> <span class="font-bold text-red-600">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d M Y') }}</span></p>

            @if($tenant->id_card_photo)
                <p><span class="text-gray-500 block mb-1">Foto KTP</span>
                   <img src="{{ asset('storage/' . $tenant->id_card_photo) }}" class="w-full h-32 object-cover rounded border">
                </p>
            @endif
        </div>

        @if($tenant->status == 'active')
        <div class="mt-6 pt-4 border-t">
            <form action="{{ route('admin.tenants.alumni', $tenant) }}" method="POST" onsubmit="return confirm('Yakin ingin menjadikan penghuni ini Alumni? Kamar akan otomatis berstatus Tersedia.');">
                @csrf @method('PATCH')
                <button type="submit" class="w-full bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Jadikan Alumni</button>
            </form>
        </div>
        @endif
    </div>

    <div class="col-span-2 bg-white p-6 rounded shadow">
        <h3 class="text-lg font-bold border-b pb-2 mb-4">Histori Pembayaran</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Invoice</th>
                        <th class="px-4 py-2 text-left">Periode</th>
                        <th class="px-4 py-2 text-left">Total (Rp)</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($tenant->payments as $payment)
                    <tr>
                        <td class="px-4 py-2 font-mono">{{ $payment->invoice_number }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($payment->period_start)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($payment->period_end)->format('d/m/y') }}</td>
                        <td class="px-4 py-2">{{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded {{ $payment->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ strtoupper($payment->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat pembayaran. (Atau tunggu HARI 3 untuk fitur ini)</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
