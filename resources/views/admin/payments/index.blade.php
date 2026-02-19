@extends('layouts.admin')
@section('title', 'Manajemen Pembayaran')
@section('header', 'Daftar Tagihan & Pembayaran')

@section('content')
<div class="mb-6 bg-white p-4 rounded shadow">
    <form action="{{ route('admin.payments.index') }}" method="GET" class="flex items-end space-x-4">
        <div>
            <label class="block text-sm text-gray-700">Filter Bulan</label>
            <input type="month" name="month" value="{{ request('month') }}" class="rounded border-gray-300">
        </div>
        <div>
            <label class="block text-sm text-gray-700">Status</label>
            <select name="status" class="rounded border-gray-300">
                <option value="">Semua Status</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar (Unpaid)</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas (Paid)</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
        <a href="{{ route('admin.payments.index') }}" class="text-gray-500 hover:underline ml-2 pb-2">Reset</a>
    </form>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-gray-50 text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left">No. Invoice</th>
                <th class="px-4 py-3 text-left">Penghuni</th>
                <th class="px-4 py-3 text-left">Kamar</th>
                <th class="px-4 py-3 text-left">Jatuh Tempo</th>
                <th class="px-4 py-3 text-right">Tagihan Pokok</th>
                <th class="px-4 py-3 text-right">Denda</th>
                <th class="px-4 py-3 text-right">Total</th>
                <th class="px-4 py-3 text-left">Tgl Bayar</th>
                <th class="px-4 py-3 text-center">Status</th>
                <th class="px-4 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($payments as $payment)
            @php
                $isOverdue = $payment->status === 'unpaid' && \Carbon\Carbon::parse($payment->period_end)->isPast();
            @endphp
            <tr class="{{ $isOverdue ? 'bg-red-50' : '' }}">
                <td class="px-4 py-3 font-mono">{{ $payment->invoice_number }}</td>
                <td class="px-4 py-3 font-semibold">{{ $payment->tenant->name }}</td>
                <td class="px-4 py-3">{{ $payment->room->room_number }}</td>
                <td class="px-4 py-3 {{ $isOverdue ? 'text-red-600 font-bold' : '' }}">
                    {{ \Carbon\Carbon::parse($payment->period_end)->format('d/m/Y') }}
                </td>
                <td class="px-4 py-3 text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-right text-red-500">Rp {{ number_format($payment->penalty, 0, ',', '.') }}</td>
                <td class="px-4 py-3 text-right font-bold">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
                <td class="px-4 py-3">
                    {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') : '-' }}
                </td>
                <td class="px-4 py-3 text-center">
                    <span class="px-2 py-1 text-xs rounded {{ $payment->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ strtoupper($payment->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('admin.payments.show', $payment) }}" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200 text-xs">Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="10" class="px-4 py-4 text-center">Tidak ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $payments->links() }}</div>
</div>
@endsection
