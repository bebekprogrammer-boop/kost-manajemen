@extends('layouts.admin')
@section('title', 'Detail Pembayaran')
@section('header', 'Rincian Tagihan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h3 class="text-xl font-bold font-mono">{{ $payment->invoice_number }}</h3>
            <span class="px-3 py-1 text-sm rounded font-bold {{ $payment->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ strtoupper($payment->status) }}
            </span>
        </div>

        <div class="space-y-3">
            <p><span class="text-gray-500 w-1/3 inline-block">Penghuni</span> <span class="font-semibold">{{ $payment->tenant->name }}</span></p>
            <p><span class="text-gray-500 w-1/3 inline-block">Kamar</span> <span class="font-semibold">{{ $payment->room->room_number }} ({{ strtoupper($payment->room->type) }})</span></p>
            <p><span class="text-gray-500 w-1/3 inline-block">Periode Sewa</span> {{ \Carbon\Carbon::parse($payment->period_start)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($payment->period_end)->format('d M Y') }}</p>
            <p><span class="text-gray-500 w-1/3 inline-block">Jatuh Tempo</span> <span class="text-red-600 font-bold">{{ \Carbon\Carbon::parse($payment->period_end)->format('d M Y') }}</span></p>

            <div class="border-t pt-3 mt-3">
                <p class="flex justify-between"><span class="text-gray-600">Tagihan Pokok</span> <span>Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></p>

                @if($payment->status === 'unpaid')
                    <p class="flex justify-between text-red-500"><span class="font-semibold">Denda (Hingga Hari Ini)</span> <span>Rp {{ number_format($currentPenalty, 0, ',', '.') }}</span></p>
                    <p class="flex justify-between text-xl font-bold mt-2 pt-2 border-t"><span>Total Bayar</span> <span>Rp {{ number_format($payment->amount + $currentPenalty, 0, ',', '.') }}</span></p>
                @else
                    <p class="flex justify-between text-red-500"><span class="font-semibold">Denda</span> <span>Rp {{ number_format($payment->penalty, 0, ',', '.') }}</span></p>
                    <p class="flex justify-between text-xl font-bold mt-2 pt-2 border-t"><span>Total Dibayar</span> <span>Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span></p>
                    <p class="mt-4"><span class="text-gray-500 w-1/3 inline-block">Tgl Pembayaran</span> <span class="font-semibold">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</span></p>
                    <p><span class="text-gray-500 w-1/3 inline-block">Dikonfirmasi Oleh</span> <span class="font-semibold">{{ $payment->paidBy->name ?? '-' }}</span></p>
                    @if($payment->notes)
                        <p class="mt-2 text-sm text-gray-600 bg-gray-50 p-2 border rounded">Catatan: {{ $payment->notes }}</p>
                    @endif
                @endif
            </div>
        </div>

        @if($payment->status === 'paid')
            <div class="mt-6">
                <a href="{{ route('admin.payments.invoice', $payment) }}" class="block text-center bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">
                    ⬇️ Download Invoice PDF
                </a>
            </div>
        @endif
    </div>

    @if($payment->status === 'unpaid')
    <div class="bg-white p-6 rounded shadow border-l-4 border-blue-500">
        <h3 class="text-lg font-bold border-b pb-2 mb-4">Konfirmasi Pembayaran</h3>
        <p class="text-sm text-gray-600 mb-4">Pastikan Anda telah menerima dana sebesar <strong class="text-lg">Rp {{ number_format($payment->amount + $currentPenalty, 0, ',', '.') }}</strong> sebelum melakukan konfirmasi. Aksi ini tidak dapat dibatalkan.</p>

        <form action="{{ route('admin.payments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="tenant_id" value="{{ $payment->tenant_id }}">

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Catatan (Opsional)</label>
                <textarea name="notes" rows="3" class="w-full border-gray-300 rounded" placeholder="Misal: Ditransfer via BCA a.n Budi..."></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold px-4 py-3 rounded hover:bg-blue-700 transition" onsubmit="return confirm('Konfirmasi pembayaran ini?');">
                Konfirmasi Pembayaran Sekarang
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
