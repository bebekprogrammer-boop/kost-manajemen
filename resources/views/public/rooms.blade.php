<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar – {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue-primary:   #1d4ed8;
            --blue-dark:      #1e3a8a;
            --blue-deeper:    #172554;
            --blue-light:     #dbeafe;
            --blue-mid:       #93c5fd;
            --green-accent:   #fbff00;
            --green-light:    #dcfce7;
            --green-mid:      #86efac;
            --green-dark:     #798015;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Roboto', sans-serif;
            background: #f5f7ff;
            color: #1e293b;
        }

        /* ─── NAVBAR ─── */
        .navbar-wrapper {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 10px 16px;
            background: transparent;
            pointer-events: none;
        }
        .navbar {
            pointer-events: all;
            max-width: 1152px;
            margin: 0 auto;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(16px);
            border: 1px solid #e0e7ff;
            border-radius: 14px;
            transition: box-shadow 0.3s;
            box-shadow: 0 4px 24px rgba(29,78,216,0.10);
        }
        .navbar.scrolled { box-shadow: 0 8px 32px rgba(29,78,216,0.15); }
        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.6rem 1.5rem;
        }
        .nav-link {
            position: relative;
            font-weight: 500;
            font-size: 0.875rem;
            color: #475569;
            transition: color 0.2s;
            padding-bottom: 2px;
            white-space: nowrap;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px; left: 0;
            width: 0; height: 2px;
            background: var(--green-accent);
            transition: width 0.25s ease;
            border-radius: 2px;
        }
        .nav-link:hover { color: var(--blue-primary); }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active { color: var(--blue-primary); }
        .nav-link.active::after { width: 100%; }
        .btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--blue-primary);
            color: #fff;
            font-weight: 700;
            font-size: 0.82rem;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 2px 12px rgba(29,78,216,0.25);
            white-space: nowrap;
        }
        .btn-nav:hover {
            background: #1e40af;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(29,78,216,0.35);
        }
        .mobile-menu-inner {
            padding: 0.75rem 1.5rem 1rem;
            border-top: 1px solid #e0e7ff;
        }

        /* ─── PAGE HEADER ─── */
        .page-header {
            background: linear-gradient(135deg, var(--blue-deeper) 0%, var(--blue-dark) 45%, #1d4ed8 100%);
            padding: 5.5rem 1.5rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 90% 10%, rgba(34,197,94,0.12) 0%, transparent 55%),
                radial-gradient(ellipse 50% 70% at 5% 90%, rgba(29,78,216,0.3) 0%, transparent 50%);
        }
        .page-header-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 56px 56px;
        }
        .header-content {
            position: relative;
            z-index: 1;
            padding-bottom: 1.5rem;
        }
        .section-pill {
            display: inline-flex;
            align-items: center;
            background: rgba(255,255,255,0.15);
            color: #e0f2fe;
            font-size: 0.68rem;
            font-weight: 700;
            padding: 0.22rem 0.75rem;
            border-radius: 999px;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            border: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 0.4rem;
        }
        .page-header h1 {
            font-size: clamp(1.5rem, 3vw, 2.2rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.02em;
        }
        .page-header h1 span { color: var(--green-accent); }
        .page-header p {
            color: #bfdbfe;
            font-size: 0.82rem;
            margin-top: 0.3rem;
        }

        /* ─── FILTER BAR — menyatu dengan header ─── */
        .filter-bar {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            padding: 0.9rem 1.5rem 0;
      
        }
        .filter-btn {
            padding: 0.38rem 1.1rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            border: 1.5px solid transparent;
            white-space: nowrap;
        }
        .filter-btn.active {
            background: var(--blue-primary);
            color: #fff;
            box-shadow: 0 4px 14px rgba(29,78,216,0.3);
        }
        .filter-btn:not(.active) {
            background: #fff;
            color: #475569;
            border-color: #e0e7ff;
        }
        .filter-btn:not(.active):hover {
            border-color: var(--blue-mid);
            color: var(--blue-primary);
        }

        /* ─── COMPACT ROOM CARDS ─── */
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.85rem;
        }
        @media (max-width: 900px) { .rooms-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 580px) { .rooms-grid { grid-template-columns: 1fr; } }

        .room-card {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e0e7ff;
            display: flex;
            flex-direction: column;
            transition: transform 0.22s, box-shadow 0.22s;
        }
        .room-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 36px rgba(29,78,216,0.11);
        }

        .room-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }
        .room-img-placeholder {
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, #e0e7ff, #dbeafe);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: #93c5fd;
        }

        .room-body {
            padding: 0.75rem 0.875rem 0.875rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
        }

        .room-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .room-number {
            font-size: 0.88rem;
            font-weight: 900;
            color: #0f172a;
        }
        .type-badge {
            font-size: 0.6rem;
            font-weight: 800;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            padding: 0.16rem 0.5rem;
            border-radius: 999px;
        }
        .type-vvip    { background: #ede9fe; color: #6d28d9; }
        .type-vip     { background: var(--blue-light); color: var(--blue-primary); }
        .type-regular { background: #f1f5f9; color: #475569; }

        .room-mid {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .room-price {
            font-size: 0.95rem;
            font-weight: 900;
            color: var(--blue-primary);
            letter-spacing: -0.02em;
            line-height: 1;
        }
        .room-price span { font-size: 0.65rem; font-weight: 400; color: #94a3b8; }

        .status-available { background: #dcfce7; color: #15803d; font-size: 0.62rem; font-weight: 700; padding: 0.16rem 0.5rem; border-radius: 999px; }
        .status-full      { background: #fee2e2; color: #dc2626; font-size: 0.62rem; font-weight: 700; padding: 0.16rem 0.5rem; border-radius: 999px; }

        .room-facilities {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 0.2rem;
        }
        .room-facilities li {
            font-size: 0.62rem;
            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 0.12rem 0.45rem;
            border-radius: 999px;
        }

        .room-actions {
            display: flex;
            gap: 0.35rem;
            margin-top: auto;
            padding-top: 0.5rem;
            border-top: 1px solid #f1f5f9;
        }
        .btn-detail {
            flex: 1;
            text-align: center;
            padding: 0.4rem 0.4rem;
            border-radius: 7px;
            font-weight: 700;
            font-size: 0.68rem;
            border: 1.5px solid var(--blue-primary);
            color: var(--blue-primary);
            transition: background 0.2s;
        }
        .btn-detail:hover { background: var(--blue-light); }
        .btn-wa {
            flex: 1;
            text-align: center;
            padding: 0.4rem 0.4rem;
            border-radius: 7px;
            font-weight: 700;
            font-size: 0.68rem;
            background: #22c55e;
            color: #fff;
            transition: background 0.2s;
        }
        .btn-wa:hover { background: #16a34a; }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: #94a3b8;
            grid-column: 1 / -1;
        }
        .empty-state .emoji { font-size: 2.5rem; margin-bottom: 0.75rem; }

        /* ─── FOOTER ─── */
        footer { background: #0f172a; }
        .footer-link { font-size: 0.875rem; color: #64748b; transition: color 0.2s; }
        .footer-link:hover { color: var(--green-accent); }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #eff6ff; }
        ::-webkit-scrollbar-thumb { background: var(--blue-mid); border-radius: 999px; }
    </style>
</head>
<body>

    <!-- ════ NAVBAR FLOATING ════ -->
    <div class="navbar-wrapper" id="navbar-wrapper">
        <nav class="navbar" id="navbar">
            <div class="navbar-inner">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div style="width:32px;height:32px;background:var(--blue-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 10px rgba(29,78,216,0.3);">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <span style="font-weight:900;font-size:1.05rem;color:var(--blue-dark);letter-spacing:-0.01em;">
                        {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}
                    </span>
                </a>
                <div class="items-center hidden gap-7 md:flex">
                    <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                    <a href="{{ route('rooms') }}" class="nav-link active">Kamar</a>
                    <a href="{{ route('home') }}#fasilitas" class="nav-link">Fasilitas</a>
                    <a href="{{ route('home') }}#tentang" class="nav-link">Tentang</a>
                </div>
                <div class="hidden md:block">
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="btn-nav">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                            Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-nav">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                            Login Admin
                        </a>
                    @endauth
                </div>
                <button id="hamburger" class="p-1.5 transition rounded-lg md:hidden hover:bg-blue-50">
                    <svg id="icon-open" class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="icon-close" class="hidden w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="mobile-menu" class="hidden mobile-menu-inner md:hidden">
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="flex py-2.5 px-3 rounded-lg text-gray-600 hover:bg-gray-50 font-medium text-sm transition">Beranda</a>
                    <a href="{{ route('rooms') }}" class="flex py-2.5 px-3 rounded-lg text-blue-700 font-semibold bg-blue-50 text-sm">Kamar</a>
                    <a href="{{ route('home') }}#fasilitas" class="flex py-2.5 px-3 rounded-lg text-gray-600 hover:bg-gray-50 font-medium text-sm transition">Fasilitas</a>
                    <a href="{{ route('home') }}#tentang" class="flex py-2.5 px-3 rounded-lg text-gray-600 hover:bg-gray-50 font-medium text-sm transition">Tentang</a>
                    <div class="pt-2">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="flex justify-center w-full btn-nav">Dashboard Admin</a>
                        @else
                            <a href="{{ route('login') }}" class="flex justify-center w-full btn-nav">Login Admin</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- ════ PAGE HEADER ════ -->
    <div class="page-header">
        <div class="page-header-grid"></div>
        <div class="header-content">
            <span class="section-pill">Pilihan Kamar</span>
            <h1>Kamar <span>Tersedia</span></h1>
            <p>Pilih tipe kamar yang sesuai kebutuhan dan anggaranmu</p>
        </div>
    </div>

    <!-- Filter Bar — tepat di bawah header, transisi warna mulus -->
    <div class="filter-bar">
        <button class="filter-btn active" data-filter="all">Semua</button>
        <button class="filter-btn" data-filter="vvip">VVIP</button>
        <button class="filter-btn" data-filter="vip">VIP</button>
        <button class="filter-btn" data-filter="regular">Reguler</button>
    </div>

    <!-- ════ DAFTAR KAMAR ════ -->
    <section class="px-6 py-5">
        <div class="max-w-6xl mx-auto">
            <div class="rooms-grid" id="rooms-grid">
                @forelse($rooms as $room)
                <div class="room-card" data-type="{{ $room->type }}">
                    @if($room->photos && count($room->photos) > 0)
                        <img src="{{ asset('storage/' . $room->photos[0]) }}"
                             alt="Kamar {{ $room->room_number }}" class="room-img">
                    @else
                        <div class="room-img-placeholder">🏠</div>
                    @endif

                    <div class="room-body">
                        <div class="room-top">
                            <span class="room-number">Kamar {{ $room->room_number }}</span>
                            <span class="type-badge type-{{ $room->type }}">{{ strtoupper($room->type) }}</span>
                        </div>

                        <div class="room-mid">
                            <div class="room-price">
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                                <span>/ bln</span>
                            </div>
                            @if($room->status == 'available')
                                <span class="status-available">● Tersedia</span>
                            @else
                                <span class="status-full">● Penuh</span>
                            @endif
                        </div>

                        @if($room->facilities && count($room->facilities) > 0)
                        <ul class="room-facilities">
                            @foreach(array_slice($room->facilities, 0, 3) as $f)
                                <li>{{ $f }}</li>
                            @endforeach
                            @if(count($room->facilities) > 3)
                                <li style="background:#eff6ff;color:#60a5fa;border-color:#bfdbfe;">+{{ count($room->facilities) - 3 }}</li>
                            @endif
                        </ul>
                        @endif

                        <div class="room-actions">
                            <a href="{{ route('room.detail', $room) }}" class="btn-detail">Detail</a>
                            @php
                                $waUrl = 'https://wa.me/' . env('ADMIN_PHONE') . '?text=' . urlencode('Halo Admin, saya tertarik dengan Kamar ' . $room->room_number . ' (' . strtoupper($room->type) . '). Apakah masih tersedia?');
                            @endphp
                            <a href="{{ $waUrl }}" target="_blank" class="btn-wa">💬 WhatsApp</a>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="empty-state">
                        <div class="emoji">🏠</div>
                        <p>Belum ada kamar tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ════ FOOTER ════ -->
    <footer class="px-6 py-12">
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col items-start justify-between gap-6 pb-8 md:flex-row md:items-center" style="border-bottom:1px solid #1e293b;">
                <div>
                    <div class="flex items-center gap-2.5 mb-2">
                        <div style="width:30px;height:30px;background:var(--blue-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <span style="font-weight:900;font-size:1.05rem;color:#fff;letter-spacing:-0.01em;">
                            {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}
                        </span>
                    </div>
                    <p style="font-size:0.78rem;color:#475569;max-width:280px;line-height:1.6;">
                        {{ env('KOST_ADDRESS', '') }}
                    </p>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('rooms') }}" class="footer-link">Kamar</a>
                    <a href="{{ route('home') }}#fasilitas" class="footer-link">Fasilitas</a>
                    <a href="{{ route('home') }}#tentang" class="footer-link">Tentang</a>
                </div>
            </div>
            <div class="flex flex-col items-center justify-between gap-3 pt-6 md:flex-row">
                <p style="font-size:0.78rem;color:#475569;">&copy; {{ date('Y') }} {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}. All rights reserved.</p>
                <p style="font-size:0.78rem;color:#334155;">Dibuat dengan <span style="color:var(--green-accent);">♥</span> untuk penghuni terbaik</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar shadow on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        });

        // Hamburger
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen   = document.getElementById('icon-open');
        const iconClose  = document.getElementById('icon-close');
        hamburger.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');
        });

        // Filter
        const filterBtns = document.querySelectorAll('.filter-btn');
        const roomCards  = document.querySelectorAll('.room-card');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.getAttribute('data-filter');
                roomCards.forEach(card => {
                    card.style.display = (filter === 'all' || card.getAttribute('data-type') === filter) ? 'flex' : 'none';
                });
            });
        });

        // Fade-up on scroll
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });

        roomCards.forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(12px)';
            el.style.transition = `opacity 0.4s ease ${i * 0.04}s, transform 0.4s ease ${i * 0.04}s`;
            io.observe(el);
        });
    </script>
</body>
</html>
