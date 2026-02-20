<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('KOST_NAME', 'KOST-MANAJEMEN') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans text-gray-800 bg-gray-50">

    <nav class="sticky top-0 z-50 flex items-center justify-between px-6 py-4 bg-white shadow">
        <h1 class="text-2xl font-bold text-blue-900">{{ env('KOST_NAME', 'KOST-MANAJEMEN') }}</h1>
        @auth
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">Dashboard Admin</a>
        @else
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:underline">Login Admin</a>
        @endauth
    </nav>

    <header class="px-4 py-20 text-center text-white bg-blue-900">
        <h2 class="mb-4 text-4xl font-bold md:text-5xl">Temukan Kenyamanan Seperti di Rumah Sendiri</h2>
        <p class="mb-8 text-lg text-blue-200 md:text-xl">{{ env('KOST_ADDRESS', 'Lokasi Strategis & Fasilitas Lengkap') }}</p>
        <a href="#daftar-kamar" class="px-8 py-3 font-bold text-blue-900 transition bg-yellow-500 rounded-full hover:bg-yellow-400">Lihat Kamar</a>
    </header>

    <section class="max-w-6xl px-6 py-16 mx-auto text-center">
        <h3 class="mb-10 text-2xl font-bold">Fasilitas Umum Kami</h3>
        <div class="grid grid-cols-2 gap-6 text-gray-600 md:grid-cols-4">
            <div class="p-6 bg-white rounded shadow"><div class="mb-2 text-4xl">📶</div><p class="font-semibold">WiFi Cepat</p></div>
            <div class="p-6 bg-white rounded shadow"><div class="mb-2 text-4xl">📹</div><p class="font-semibold">CCTV 24 Jam</p></div>
            <div class="p-6 bg-white rounded shadow"><div class="mb-2 text-4xl">🅿️</div><p class="font-semibold">Parkir Luas</p></div>
            <div class="p-6 bg-white rounded shadow"><div class="mb-2 text-4xl">🧹</div><p class="font-semibold">Pembersihan Rutin</p></div>
        </div>
    </section>

    <section id="daftar-kamar" class="px-6 py-16 bg-gray-100">
        <div class="max-w-6xl mx-auto">
            <h3 class="mb-6 text-2xl font-bold text-center">Pilihan Kamar</h3>
            
            <div class="flex justify-center pb-2 mb-10 space-x-2 overflow-x-auto">
                <button class="px-4 py-2 text-white bg-blue-600 rounded filter-btn" data-filter="all">Semua Kamar</button>
                <button class="px-4 py-2 text-gray-700 bg-white border rounded filter-btn hover:bg-gray-50" data-filter="vvip">VVIP</button>
                <button class="px-4 py-2 text-gray-700 bg-white border rounded filter-btn hover:bg-gray-50" data-filter="vip">VIP</button>
                <button class="px-4 py-2 text-gray-700 bg-white border rounded filter-btn hover:bg-gray-50" data-filter="regular">Reguler</button>
            </div>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($rooms as $room)
                <div class="flex flex-col overflow-hidden bg-white rounded-lg shadow room-card" data-type="{{ $room->type }}">
                    @if($room->photos && count($room->photos) > 0)
                        <img src="{{ asset('storage/' . $room->photos[0]) }}" alt="Foto Kamar" class="object-cover w-full h-48">
                    @else
                        <div class="flex items-center justify-center w-full h-48 text-gray-500 bg-gray-300">Tanpa Foto</div>
                    @endif
                    
                    <div class="flex flex-col flex-1 p-6">
                        <div class="flex items-start justify-between mb-2">
                            <h4 class="text-xl font-bold">Kamar {{ $room->room_number }}</h4>
                            <span class="px-2 py-1 text-xs rounded uppercase font-bold {{ $room->type == 'vvip' ? 'bg-purple-100 text-purple-800' : ($room->type == 'vip' ? 'bg-blue-100 text-blue-800' : 'bg-gray-200 text-gray-800') }}">
                                {{ $room->type }}
                            </span>
                        </div>
                        
                        <div class="mb-4">
                            @if($room->status == 'available')
                                <span class="px-2 py-1 text-sm font-bold text-green-600 bg-green-100 rounded">Tersedia</span>
                            @else
                                <span class="px-2 py-1 text-sm font-bold text-red-600 bg-red-100 rounded">Penuh</span>
                            @endif
                        </div>
                        
                        <p class="pb-4 mb-4 text-2xl font-bold text-blue-600 border-b">Rp {{ number_format($room->price, 0, ',', '.') }}<span class="text-sm font-normal text-gray-500"> / bulan</span></p>
                        
                        <ul class="flex-1 mb-6 space-y-1 text-sm text-gray-600">
                            @if($room->facilities)
                                @foreach(array_slice($room->facilities, 0, 3) as $fasilitas)
                                    <li>✓ {{ $fasilitas }}</li>
                                @endforeach
                                @if(count($room->facilities) > 3)
                                    <li class="italic text-gray-400">+ {{ count($room->facilities) - 3 }} fasilitas lainnya</li>
                                @endif
                            @endif
                        </ul>
                        
                        <div class="mt-auto space-y-2">
                            <a href="{{ route('room.detail', $room) }}" class="block w-full py-2 font-semibold text-center text-blue-600 transition border border-blue-600 rounded hover:bg-blue-50">Detail Kamar</a>
                            
                            @php
                                $waUrl = 'https://wa.me/' . env('ADMIN_PHONE') . '?text=' . urlencode('Halo Admin, saya tertarik dengan Kamar ' . $room->room_number . ' (' . strtoupper($room->type) . '). Apakah masih tersedia?'); // [cite: 218]
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="block w-full py-2 font-bold text-center text-white transition bg-green-500 rounded hover:bg-green-600">
                                Tanya via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer class="py-6 text-center text-white bg-gray-800">
        <p>&copy; {{ date('Y') }} {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}. All rights reserved.</p>
    </footer>

    <script>
        const buttons = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.room-card');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                // Reset styling
                buttons.forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-white', 'text-gray-700');
                });
                // Set active styling
                button.classList.remove('bg-white', 'text-gray-700');
                button.classList.add('bg-blue-600', 'text-white');

                const filter = button.getAttribute('data-filter');

                cards.forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-type') === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>