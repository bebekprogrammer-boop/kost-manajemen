@extends('layouts.admin')
@section('title', 'Manajemen Pengeluaran')
@section('header', 'Pengeluaran Operasional Kost')

@section('content')
<div class="flex items-center justify-between p-4 mb-6 bg-white rounded shadow">
    <form action="{{ route('admin.expenses.index') }}" method="GET" class="flex items-end space-x-2">
        <div>
            <label class="block text-sm text-gray-700">Pilih Bulan</label>
            <input type="month" name="month" value="{{ $month }}" class="border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Tampilkan</button>
    </form>
    <a href="{{ route('admin.expenses.create') }}" class="px-4 py-2 text-white bg-green-600 rounded hover:bg-green-700">+ Tambah Pengeluaran</a>
</div>

@if(session('success'))
    <div class="px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">{{ session('success') }}</div>
@endif

<div class="overflow-hidden bg-white rounded shadow">
    <table class="min-w-full">
        <thead class="text-gray-700 border-b bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-left">Kategori</th>
                <th class="px-6 py-3 text-left">Keterangan</th>
                <th class="px-6 py-3 text-right">Jumlah (Rp)</th>
                <th class="px-6 py-3 text-center">Kwitansi</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($expenses as $expense)
            <tr>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}</td>
                <td class="px-6 py-4 font-semibold text-blue-800">{{ $expense->category }}</td>
                <td class="px-6 py-4">{{ $expense->description ?? '-' }}</td>
                <td class="px-6 py-4 font-mono text-right">{{ number_format($expense->amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-center">
                    @if($expense->receipt_photo)
                        <a href="{{ asset('storage/' . $expense->receipt_photo) }}" target="_blank" class="text-sm text-blue-500 hover:underline">Lihat</a>
                    @else
                        <span class="text-sm text-gray-400">-</span>
                    @endif
                </td>
                <td class="flex justify-center px-6 py-4 space-x-2">
                    <a href="{{ route('admin.expenses.edit', $expense) }}" class="text-sm text-yellow-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pengeluaran ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada pengeluaran pada bulan ini.</td></tr>
            @endforelse
        </tbody>
        <tfoot class="font-bold bg-gray-100 border-t-2">
            <tr>
                <td colspan="3" class="px-6 py-4 text-right">TOTAL PENGELUARAN:</td>
                <td class="px-6 py-4 text-lg text-right text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection