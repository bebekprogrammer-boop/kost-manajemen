@extends('layouts.admin')
@section('title', 'Tambah Pengeluaran')
@section('header', 'Catat Pengeluaran Baru')

@section('content')
<div class="max-w-2xl p-6 bg-white rounded shadow">
    <form action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Tanggal Pengeluaran</label>
                <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required class="w-full mt-1 border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700">Kategori</label>
                <select name="category" required class="w-full mt-1 border-gray-300 rounded">
                    <option value="Listrik">Listrik</option>
                    <option value="Air">Air</option>
                    <option value="Internet">Internet</option>
                    <option value="Kebersihan">Kebersihan</option>
                    <option value="Perbaikan">Perbaikan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-gray-700">Jumlah (Rp)</label>
            <input type="number" name="amount" value="{{ old('amount') }}" required min="0" placeholder="Contoh: 150000" class="w-full mt-1 font-mono border-gray-300 rounded">
        </div>

        <div>
            <label class="block text-gray-700">Keterangan / Rincian</label>
            <textarea name="description" rows="3" class="w-full mt-1 border-gray-300 rounded" placeholder="Misal: Beli token listrik bulan ini...">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700">Foto Kwitansi / Struk (Opsional)</label>
            <input type="file" name="receipt_photo" accept="image/*" class="w-full mt-1">
            <p class="mt-1 text-sm text-gray-500">Maksimal ukuran file: 5MB.</p>
        </div>

        <div class="flex justify-end pt-4 space-x-2">
            <a href="{{ route('admin.expenses.index') }}" class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">Batal</a>
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Simpan Data</button>
        </div>
    </form>
</div>
@endsection