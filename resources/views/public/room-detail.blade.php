<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar {{ $room->room_number }} – {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}</title>
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
            padding: 5.5rem 1.5rem 2rem;
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
        .header-inner {
            position: relative;
            z-index: 1;
            max-width: 1152px;
            margin: 0 auto;
        }

        .breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            color: #93c5fd;
            margin-bottom: 0.75rem;
            font-weight: 500;
        }
        .breadcrumb a { color: #93c5fd; transition: color 0.2s; }
        .breadcrumb a:hover { color: #fff; }
        .breadcrumb span { color: rgba(255,255,255,0.4); }

        .page-header h1 {
            font-size: clamp(1.6rem, 3vw, 2.4rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .page-header h1 span { color: var(--green-accent); }

        .header-badges {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }
        .type-badge {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
        }
        .type-vvip    { background: #ede9fe; color: #6d28d9; }
        .type-vip     { background: var(--blue-light); color: var(--blue-primary); }
        .type-regular { background: #f1f5f9; color: #475569; }

        .status-available { background: #dcfce7; color: #15803d; font-size: 0.68rem; font-weight: 700; padding: 0.25rem 0.7rem; border-radius: 999px; }
        .status-full      { background: #fee2e2; color: #dc2626; font-size: 0.68rem; font-weight: 700; padding: 0.25rem 0.7rem; border-radius: 999px; }

        .floor-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            background: rgba(255,255,255,0.15);
            color: #e0f2fe;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 0.25rem 0.7rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        /* ─── MAIN CONTENT ─── */
        .content-wrapper {
            max-width: 1152px;
            margin: 0 auto;
            padding: 2rem 1.5rem 3rem;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 1.5rem;
            align-items: start;
        }
        @media (max-width: 860px) {
            .content-wrapper { grid-template-columns: 1fr; }
        }

        /* ─── GALLERY ─── */
        .gallery-wrap {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e0e7ff;
            overflow: hidden;
        }
        .gallery-scroll {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
        }
        .gallery-scroll::-webkit-scrollbar { display: none; }
        .gallery-scroll img {
            flex-shrink: 0;
            width: 100%;
            height: 320px;
            object-fit: cover;
            scroll-snap-align: center;
        }
        .gallery-placeholder {
            width: 100%;
            height: 320px;
            background: linear-gradient(135deg, #e0e7ff, #dbeafe);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.5rem;
            color: #93c5fd;
            font-size: 3rem;
        }
        .gallery-placeholder p { font-size: 0.8rem; font-weight: 500; }

        /* ─── DESCRIPTION ─── */
        .desc-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e0e7ff;
            padding: 1.5rem;
            margin-top: 1rem;
        }
        .card-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--blue-primary);
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .card-title::before {
            content: '';
            display: inline-block;
            width: 3px;
            height: 14px;
            background: var(--blue-primary);
            border-radius: 2px;
        }
        .desc-text {
            font-size: 0.875rem;
            color: #475569;
            line-height: 1.75;
        }

        /* ─── FACILITIES ─── */
        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.5rem;
        }
        .facility-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.82rem;
            color: #334155;
            padding: 0.5rem 0.65rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }
        .facility-check {
            width: 18px; height: 18px;
            background: var(--blue-light);
            color: var(--blue-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            font-weight: 900;
            flex-shrink: 0;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            position: sticky;
            top: 80px;
        }

        .price-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e0e7ff;
            padding: 1.5rem;
        }
        .price-label {
            font-size: 0.72rem;
            color: #94a3b8;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
        }
        .price-value {
            font-size: 2rem;
            font-weight: 900;
            color: var(--blue-primary);
            letter-spacing: -0.03em;
            line-height: 1;
        }
        .price-value span {
            font-size: 0.85rem;
            font-weight: 400;
            color: #94a3b8;
        }
        .price-divider {
            border: none;
            border-top: 1px solid #e0e7ff;
            margin: 1rem 0;
        }

        .btn-wa {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.85rem;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.9rem;
            background: #22c55e;
            color: #fff;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 18px rgba(34,197,94,0.25);
        }
        .btn-wa:hover {
            background: #16a34a;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(34,197,94,0.35);
        }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            width: 100%;
            padding: 0.7rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.82rem;
            border: 1.5px solid #e0e7ff;
            color: #475569;
            transition: border-color 0.2s, color 0.2s, background 0.2s;
        }
        .btn-back:hover {
            border-color: var(--blue-mid);
            color: var(--blue-primary);
            background: var(--blue-light);
        }

        .info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            padding: 0.4rem 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child { border-bottom: none; }
        .info-row .label { color: #94a3b8; font-weight: 500; }
        .info-row .value { color: #1e293b; font-weight: 700; }

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
                            Login Owner
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
        <div class="header-inner">
            <div class="breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('rooms') }}">Kamar</a>
                <span>/</span>
                <span style="color:rgba(255,255,255,0.75);">Kamar {{ $room->room_number }}</span>
            </div>
            <h1>Kamar <span>{{ $room->room_number }}</span></h1>
            <div class="header-badges">
                <span class="type-badge type-{{ $room->type }}">Tipe {{ strtoupper($room->type) }}</span>
                @if($room->status == 'available')
                    <span class="status-available">● Tersedia</span>
                @else
                    <span class="status-full">● Penuh</span>
                @endif
                @if($room->floor)
                    <span class="floor-badge">🏢 Lantai {{ $room->floor }}</span>
                @endif
            </div>
        </div>
    </div>

    <!-- ════ MAIN CONTENT ════ -->
    <div class="content-wrapper">

        <!-- LEFT: Gallery + Desc + Facilities -->
        <div>
            <!-- Gallery -->
            <div class="gallery-wrap">
                <div class="gallery-scroll">
                    @if($room->photos && count($room->photos) > 0)
                        @foreach($room->photos as $photo)
                            <img src="{{ asset('storage/' . $photo) }}" alt="Foto Kamar {{ $room->room_number }}">
                        @endforeach
                    @else
                        <div class="gallery-placeholder">
                            <span>🏠</span>
                            <p>Belum ada foto kamar ini</p>
                        </div>
                    @endif
                </div>
                @if($room->photos && count($room->photos) > 1)
                    <div style="padding:0.6rem 1rem;background:#f8fafc;border-top:1px solid #e0e7ff;font-size:0.72rem;color:#94a3b8;text-align:center;">
                        ← Geser untuk foto selanjutnya ({{ count($room->photos) }} foto) →
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div class="desc-card">
                <p class="card-title">Deskripsi Kamar</p>
                <p class="desc-text">{{ $room->description ?? 'Tidak ada deskripsi spesifik untuk kamar ini.' }}</p>
            </div>

            <!-- Facilities -->
            @if($room->facilities && count($room->facilities) > 0)
            <div class="desc-card">
                <p class="card-title">Fasilitas Lengkap</p>
                <div class="facilities-grid">
                    @foreach($room->facilities as $fasilitas)
                        <div class="facility-item">
                            <span class="facility-check">✓</span>
                            {{ $fasilitas }}
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- RIGHT: Sidebar -->
        <div class="sidebar">

            <!-- Price + CTA -->
            <div class="price-card">
                <p class="price-label">Harga Sewa</p>
                <div class="price-value">
                    Rp {{ number_format($room->price, 0, ',', '.') }}
                    <span>/ bulan</span>
                </div>

                <hr class="price-divider">

                <div style="margin-bottom:1rem;">
                    <div class="info-row">
                        <span class="label">Nomor Kamar</span>
                        <span class="value">{{ $room->room_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Tipe</span>
                        <span class="value">{{ strtoupper($room->type) }}</span>
                    </div>
                    @if($room->floor)
                    <div class="info-row">
                        <span class="label">Lantai</span>
                        <span class="value">{{ $room->floor }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="label">Status</span>
                        <span class="value" style="color: {{ $room->status == 'available' ? '#15803d' : '#dc2626' }}">
                            {{ $room->status == 'available' ? 'Tersedia' : 'Penuh' }}
                        </span>
                    </div>
                </div>

                @php
                    $waUrl = 'https://wa.me/' . env('ADMIN_PHONE') . '?text=' . urlencode('Halo Admin, saya tertarik dengan Kamar ' . $room->room_number . ' (' . strtoupper($room->type) . '). Apakah masih tersedia?');
                @endphp
                <a href="{{ $waUrl }}" target="_blank" class="btn-wa">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Hubungi via WhatsApp
                </a>

                <div style="margin-top:0.5rem;">
                    <a href="{{ route('rooms') }}" class="btn-back">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                        Kembali ke Daftar Kamar
                    </a>
                </div>
            </div>

        </div>
    </div>

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
    </script>
</body>
</html>
