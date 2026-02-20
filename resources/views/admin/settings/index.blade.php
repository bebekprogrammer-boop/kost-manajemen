@extends('layouts.admin')
@section('title', 'Pengaturan Sistem')
@section('header', 'Pengaturan Profil Kost & Sistem')

@section('content')
<div class="max-w-3xl p-6 bg-white rounded shadow">

    @if(session('success'))
        <div class="px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded">{{ session('success') }}</div>
    @endif

    <div class="pb-4 mb-6 border-b">
        <h3 class="text-lg font-bold text-gray-800">Informasi Dasar</h3>
        <p class="text-sm text-gray-500">Data ini akan ditampilkan di halaman Landing Page dan kop surat Invoice (Kwitansi).</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="block mb-2 font-semibold text-gray-700">Nama Kost</label>
                <input type="text" name="kost_name" value="{{ env('KOST_NAME', config('app.name')) }}" required class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Contoh: Kost Sejahtera Makmur</p>
            </div>

            <div>
                <label class="block mb-2 font-semibold text-gray-700">Nomor WhatsApp Admin</label>
                <input type="text" name="admin_phone" value="{{ env('ADMIN_PHONE') }}" required placeholder="Contoh: 628123456789" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Gunakan format 628... (tanpa tanda + atau spasi)</p>
            </div>
        </div>

        <div>
            <label class="block mb-2 font-semibold text-gray-700">Alamat Lengkap Kost</label>
            <textarea name="kost_address" rows="3" required class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">{{ env('KOST_ADDRESS') }}</textarea>
        </div>

        <div class="pt-6 mt-6 border-t">
            <h3 class="mb-2 text-lg font-bold text-gray-800">Pengaturan Keuangan</h3>
            <p class="mb-4 text-sm text-gray-500">Sistem akan mengkalkulasi denda secara otomatis setiap harinya kepada penghuni yang menunggak (Overdue).</p>

            <div class="w-full md:w-1/2">
                <label class="block mb-2 font-semibold text-gray-700">Denda Keterlambatan Per Hari (Rp)</label>
                <input type="number" name="penalty_per_day" value="{{ env('PENALTY_PER_DAY', 5000) }}" required min="0" class="w-full font-mono border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-xs text-gray-500">Isi 0 jika tidak ingin memberlakukan denda.</p>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-6 py-3 font-bold text-white transition bg-blue-600 rounded shadow-lg hover:bg-blue-700 hover:shadow-xl">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
