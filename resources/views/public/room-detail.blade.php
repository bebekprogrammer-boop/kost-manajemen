<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar {{ $room->room_number }} - {{ env('KOST_NAME', 'KOST') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 bg-gray-50">

    <nav class="flex items-center justify-between px-6 py-4 bg-white shadow">
        <a href="{{ route('home') }}" class="font-bold text-blue-600 hover:underline">← Kembali ke Beranda</a>
    </nav>

    <div class="max-w-4xl px-4 py-10 mx-auto">
        <div class="overflow-hidden bg-white rounded shadow">
            <div class="flex overflow-x-auto snap-x">
                @if($room->photos && count($room->photos) > 0)
                    @foreach($room->photos as $photo)
                        <img src="{{ asset('storage/' . $photo) }}" class="flex-shrink-0 object-cover w-full h-96 snap-center">
                    @endforeach
                @else
                    <div class="flex items-center justify-center w-full text-gray-500 bg-gray-300 h-96">Belum ada foto kamar ini.</div>
                @endif
            </div>

            <div class="p-8">
                <div class="flex items-start justify-between pb-6 mb-6 border-b">
                    <div>
                        <h2 class="mb-2 text-3xl font-bold">Kamar {{ $room->room_number }}</h2>
                        <span class="px-3 py-1 text-sm rounded uppercase font-bold {{ $room->type == 'vvip' ? 'bg-purple-100 text-purple-800' : ($room->type == 'vip' ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800') }}">Tipe {{ $room->type }}</span>
                        <span class="ml-2 px-3 py-1 text-sm font-bold rounded {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $room->status == 'available' ? 'Tersedia' : 'Penuh' }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($room->price, 0, ',', '.') }}</p>
                        <p class="text-gray-500">per bulan</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="mb-3 text-xl font-bold">Deskripsi</h3>
                    <p class="leading-relaxed text-gray-700">{{ $room->description ?? 'Tidak ada deskripsi spesifik untuk kamar ini.' }}</p>
                    <p class="mt-2 font-semibold text-gray-600">Berada di Lantai: {{ $room->floor }}</p>
                </div>

                <div class="mb-8">
                    <h3 class="mb-3 text-xl font-bold">Fasilitas Lengkap</h3>
                    <div class="grid grid-cols-2 gap-3 text-gray-700">
                        @if($room->facilities)
                            @foreach($room->facilities as $fasilitas)
                                <div class="flex items-center"><span class="mr-2 text-green-500">✓</span> {{ $fasilitas }}</div>
                            @endforeach
                        @else
                            <p>Belum ada data fasilitas.</p>
                        @endif
                    </div>
                </div>

                @php
                    $waUrl = 'https://wa.me/' . env('ADMIN_PHONE') . '?text=' . urlencode('Halo Admin, saya tertarik dengan Kamar ' . $room->room_number . ' (' . strtoupper($room->type) . '). Apakah masih tersedia?'); // [cite: 218]
                @endphp
                <div class="mt-10 text-center">
                    <a href="{{ $waUrl }}" target="_blank" class="inline-block px-10 py-4 text-xl font-bold text-white transition transform bg-green-500 rounded-full shadow-lg hover:bg-green-600 hover:shadow-xl hover:-translate-y-1">
                        Hubungi Admin via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>