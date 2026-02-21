<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('KOST_NAME', 'KOST-MANAJEMEN') }}</title>
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
            padding: 0.6rem 1.25rem;
            gap: 0.75rem;
        }
        .nav-links {
            display: none;
            align-items: center;
            gap: 1.75rem;
        }
        @media (min-width: 768px) {
            .nav-links { display: flex; }
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

        .nav-cta-wrapper { display: none; }
        @media (min-width: 768px) { .nav-cta-wrapper { display: block; } }

        .btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--blue-primary);
            color: #fff;
            font-weight: 700;
            font-size: 0.82rem;
            padding: 0.5rem 1.1rem;
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

        .hamburger {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.4rem;
            border-radius: 8px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
            flex-shrink: 0;
        }
        .hamburger:hover { background: #eff6ff; }
        @media (min-width: 768px) { .hamburger { display: none; } }

        .mobile-menu {
            display: none;
            padding: 0.75rem 1.25rem 1rem;
            border-top: 1px solid #e0e7ff;
        }
        .mobile-menu.open { display: block; }
        .mobile-menu-link {
            display: flex;
            align-items: center;
            padding: 0.65rem 0.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #475569;
            transition: background 0.15s, color 0.15s;
            text-decoration: none;
        }
        .mobile-menu-link:hover { background: #f0f4ff; color: var(--blue-primary); }
        .mobile-menu-link.active { background: #eff6ff; color: var(--blue-primary); font-weight: 600; }

        /* ─── HERO ─── */
        .hero {
            background: linear-gradient(135deg, var(--blue-deeper) 0%, var(--blue-dark) 45%, #1d4ed8 100%);
            position: relative;
            overflow: hidden;
            padding-top: 80px;
        }
        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 90% 10%, rgba(34,197,94,0.12) 0%, transparent 55%),
                radial-gradient(ellipse 50% 70% at 5% 90%, rgba(29,78,216,0.3) 0%, transparent 50%);
        }
        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 56px 56px;
        }
        .hero-circle {
            position: absolute;
            right: -120px;
            top: 50%;
            transform: translateY(-50%);
            width: 520px;
            height: 520px;
            border-radius: 50%;
            border: 1.5px solid rgba(251,255,0,0.12);
            pointer-events: none;
        }
        @media (max-width: 640px) {
            .hero-circle {
                width: 260px;
                height: 260px;
                right: -80px;
                top: 30%;
            }
        }
        .hero-circle::before {
            content: '';
            position: absolute;
            inset: 48px;
            border-radius: 50%;
            border: 1.5px solid rgba(251,255,0,0.08);
        }
        .hero-circle::after {
            content: '';
            position: absolute;
            inset: 96px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(251,255,0,0.06) 0%, transparent 70%);
        }

        .hero-content {
            position: relative;
            z-index: 10;
            max-width: 1152px;
            margin: 0 auto;
            padding: 2.5rem 1.25rem 4rem;
        }
        @media (min-width: 640px) {
            .hero-content { padding: 3rem 1.5rem 5rem; }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(251,255,0,0.10);
            border: 1px solid rgba(251,255,0,0.25);
            color: #e2e600;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.32rem 1rem;
            border-radius: 999px;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            margin-bottom: 1.25rem;
        }
        .hero-badge-dot {
            width: 7px; height: 7px;
            background: var(--green-accent);
            border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(251,255,0,0.2);
            animation: pulse-dot 2s ease infinite;
            flex-shrink: 0;
        }
        @keyframes pulse-dot {
            0%,100% { box-shadow: 0 0 0 3px rgba(251,255,0,0.2); }
            50%      { box-shadow: 0 0 0 6px rgba(251,255,0,0.08); }
        }

        .hero-title {
            font-size: clamp(2rem, 7vw, 4rem);
            font-weight: 900;
            color: #fff;
            line-height: 1.08;
            letter-spacing: -0.025em;
            margin-bottom: 1.25rem;
        }
        .hero-title .accent { color: var(--green-accent); }

        .hero-sub {
            color: #bfdbfe;
            font-size: clamp(0.875rem, 2vw, 1rem);
            font-weight: 400;
            line-height: 1.75;
            max-width: 480px;
            margin-bottom: 2.25rem;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .btn-hero-green {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--green-accent);
            color: #1a1a00;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 20px rgba(251,255,0,0.3);
            white-space: nowrap;
        }
        .btn-hero-green:hover {
            background: #f0f500;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(251,255,0,0.4);
        }
        .btn-hero-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            border: 1.5px solid rgba(255,255,255,0.35);
            transition: background 0.2s, border-color 0.2s, transform 0.15s;
            white-space: nowrap;
        }
        .btn-hero-outline:hover {
            background: rgba(255,255,255,0.07);
            border-color: rgba(255,255,255,0.65);
            transform: translateY(-2px);
        }

        /* ─── STATS ─── */
        .hero-stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 16px;
            backdrop-filter: blur(8px);
            overflow: hidden;
            margin-top: 3rem;
        }
        @media (min-width: 640px) {
            .hero-stats { grid-template-columns: repeat(4, 1fr); }
        }
        .hero-stat {
            padding: 1.25rem 1rem;
            text-align: center;
            border-right: 1px solid rgba(255,255,255,0.08);
            transition: background 0.2s;
        }
        .hero-stat:nth-child(2) { border-right: none; }
        @media (min-width: 640px) {
            .hero-stat:nth-child(2) { border-right: 1px solid rgba(255,255,255,0.08); }
            .hero-stat:last-child { border-right: none; }
        }
        .hero-stat:nth-child(3),
        .hero-stat:nth-child(4) {
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        @media (min-width: 640px) {
            .hero-stat:nth-child(3),
            .hero-stat:nth-child(4) { border-top: none; }
        }
        .hero-stat:hover { background: rgba(255,255,255,0.05); }
        .hero-stat-number {
            font-size: clamp(1.4rem, 4vw, 1.8rem);
            font-weight: 900;
            color: var(--green-accent);
            line-height: 1;
            letter-spacing: -0.02em;
        }
        .hero-stat-label {
            font-size: 0.7rem;
            color: #93c5fd;
            margin-top: 0.3rem;
            font-weight: 500;
        }

        /* ─── SECTION SHARED ─── */
        .section-pill {
            display: inline-flex;
            align-items: center;
            background: var(--blue-light);
            color: var(--blue-primary);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.28rem 0.85rem;
            border-radius: 999px;
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }
        .section-title {
            font-size: clamp(1.5rem, 4vw, 2.2rem);
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.02em;
            line-height: 1.15;
        }

        /* ─── FACILITIES ─── */
        .facilities-section {
            max-width: 1152px;
            margin: 0 auto;
            padding: 4rem 1.25rem;
        }
        @media (min-width: 640px) {
            .facilities-section { padding: 5rem 1.5rem; }
        }
        .facilities-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        @media (min-width: 768px) {
            .facilities-grid { grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
        }

        .facility-card {
            background: #fff;
            border: 1px solid #e0e7ff;
            border-radius: 16px;
            padding: 1.25rem;
            transition: transform 0.22s, box-shadow 0.22s, border-color 0.22s;
            display: flex;
            flex-direction: column;
            gap: 0.65rem;
        }
        @media (min-width: 640px) { .facility-card { padding: 1.75rem 1.5rem; } }
        .facility-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 16px 40px rgba(29,78,216,0.1);
            border-color: var(--blue-mid);
        }
        .facility-icon {
            width: 46px; height: 46px;
            background: var(--blue-light);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .facility-name { font-weight: 700; font-size: 0.9rem; color: #1e293b; }
        .facility-desc { font-size: 0.78rem; color: #64748b; line-height: 1.6; }

        /* ─── ROOMS ─── */
        .rooms-bg { background: linear-gradient(180deg, #eff6ff 0%, #f5f7ff 100%); }
        .rooms-section {
            padding: 4rem 1.25rem;
        }
        @media (min-width: 640px) { .rooms-section { padding: 5rem 1.5rem; } }
        .rooms-inner { max-width: 1152px; margin: 0 auto; }

        .rooms-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        @media (min-width: 640px) {
            .rooms-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .rooms-grid { grid-template-columns: repeat(3, 1fr); }
        }

        .room-card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #e0e7ff;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s, box-shadow 0.25s;
        }
        .room-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 56px rgba(29,78,216,0.12);
        }
        .room-card.featured {
            border: 2px solid var(--green-accent);
            box-shadow: 0 8px 32px rgba(251,255,0,0.15);
        }
        /* On mobile, stack featured last so it doesn't break 2-col at 640px */
        @media (min-width: 640px) and (max-width: 1023px) {
            .room-card:nth-child(3) {
                grid-column: 1 / -1;
                max-width: 420px;
                margin: 0 auto;
                width: 100%;
            }
        }

        .rh-vvip    { background: linear-gradient(135deg, #1e3a8a, #1d4ed8); }
        .rh-vip     { background: linear-gradient(135deg, #1d4ed8, #3b82f6); }
        .rh-regular { background: linear-gradient(135deg, #334155, #475569); }

        .room-header {
            padding: 1.75rem 1.5rem;
            text-align: center;
            position: relative;
        }
        .room-type-tag {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.85);
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0.2rem 0.7rem;
            border-radius: 999px;
            margin-bottom: 0.6rem;
        }
        .room-name {
            font-size: clamp(1.8rem, 5vw, 2.4rem);
            font-weight: 900;
            color: #fff;
            letter-spacing: -0.03em;
            line-height: 1;
        }
        .room-tagline { font-size: 0.82rem; color: rgba(255,255,255,0.65); margin-top: 0.4rem; }
        .popular-tag {
            position: absolute;
            top: 1rem; right: 1rem;
            background: var(--green-accent);
            color: #1a1a00;
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.22rem 0.65rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .room-body { padding: 1.5rem; flex: 1; display: flex; flex-direction: column; }
        .room-features {
            list-style: none;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .room-features li {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.875rem;
            color: #334155;
        }
        .check-icon {
            width: 18px; height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            font-weight: 900;
            flex-shrink: 0;
        }
        .check-blue  { background: var(--blue-light); color: var(--blue-primary); }
        .check-green { background: var(--green-light); color: var(--green-dark); }
        .check-gray  { background: #f1f5f9; color: #64748b; }

        .room-cta {
            display: block;
            width: 100%;
            text-align: center;
            font-weight: 700;
            font-size: 0.875rem;
            padding: 0.75rem;
            border-radius: 10px;
            transition: opacity 0.2s, transform 0.15s;
            text-decoration: none;
        }
        .room-cta:hover { transform: translateY(-1px); opacity: 0.9; }
        .cta-blue-dark { background: #1e3a8a; color: #fff; }
        .cta-blue      { background: var(--blue-primary); color: #fff; }
        .cta-slate     { background: #334155; color: #fff; }

        /* ─── ABOUT ─── */
        .about-section {
            max-width: 1152px;
            margin: 0 auto;
            padding: 4rem 1.25rem;
        }
        @media (min-width: 640px) { .about-section { padding: 5rem 1.5rem; } }
        .about-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            align-items: center;
        }
        @media (min-width: 768px) {
            .about-grid { grid-template-columns: 1fr 1fr; gap: 3.5rem; }
        }
        .about-stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        .about-stat-card {
            padding: 1.25rem;
            border-radius: 14px;
            background: var(--blue-light);
            border: 1px solid #bfdbfe;
        }
        .about-stat-num {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 900;
            color: var(--blue-primary);
            letter-spacing: -0.02em;
            line-height: 1;
        }
        .about-stat-label { font-size: 0.75rem; color: #64748b; margin-top: 0.3rem; font-weight: 500; }

        .info-cards-stack { display: flex; flex-direction: column; gap: 0.75rem; }
        .info-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            background: #fff;
            border: 1px solid #e0e7ff;
            border-radius: 14px;
            padding: 1.1rem 1.25rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            text-decoration: none;
        }
        .info-card:hover {
            border-color: var(--green-mid);
            box-shadow: 0 4px 18px rgba(29,78,216,0.07);
        }
        .info-icon {
            width: 42px; height: 42px;
            background: var(--blue-light);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            flex-shrink: 0;
        }
        .info-title { font-weight: 700; font-size: 0.875rem; color: #1e293b; margin-bottom: 0.2rem; }
        .info-text  { font-size: 0.78rem; color: #64748b; line-height: 1.5; }

        /* ─── FOOTER ─── */
        footer { background: #0f172a; }
        .footer-inner {
            max-width: 1152px;
            margin: 0 auto;
            padding: 3rem 1.25rem;
        }
        @media (min-width: 640px) { .footer-inner { padding: 3rem 1.5rem; } }
        .footer-top {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #1e293b;
        }
        @media (min-width: 640px) {
            .footer-top {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }
        }
        .footer-links {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-link { font-size: 0.875rem; color: #64748b; transition: color 0.2s; text-decoration: none; }
        .footer-link:hover { color: var(--green-accent); }
        .footer-bottom {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding-top: 1.5rem;
            align-items: flex-start;
        }
        @media (min-width: 640px) {
            .footer-bottom {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 0;
            }
        }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.6s ease both; }
        .d1 { animation-delay: 0.08s; }
        .d2 { animation-delay: 0.16s; }
        .d3 { animation-delay: 0.24s; }
        .d4 { animation-delay: 0.32s; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #eff6ff; }
        ::-webkit-scrollbar-thumb { background: var(--blue-mid); border-radius: 999px; }

        /* ─── SECTION HEADING UTIL ─── */
        .section-heading {
            text-align: center;
            margin-bottom: 3rem;
        }
        .section-heading p {
            max-width: 340px;
            margin: 0.6rem auto 0;
            font-size: 0.875rem;
            color: #64748b;
        }
    </style>
</head>
<body>

    <!-- ════ NAVBAR ════ -->
    <div class="navbar-wrapper">
        <nav class="navbar" id="navbar">
            <div class="navbar-inner">

                <!-- Brand -->
                <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:0.6rem;text-decoration:none;flex-shrink:0;">
                    <div style="width:32px;height:32px;background:var(--blue-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 10px rgba(29,78,216,0.3);">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </div>
                    <span style="font-weight:900;font-size:1rem;color:var(--blue-dark);letter-spacing:-0.01em;line-height:1.2;">
                        {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}
                    </span>
                </a>

                <!-- Desktop Nav Links -->
                <div class="nav-links">
                    <a href="{{ route('home') }}" class="nav-link active">Beranda</a>
                    <a href="{{ route('rooms') }}" class="nav-link">Kamar</a>
                    <a href="#fasilitas" class="nav-link">Fasilitas</a>
                    <a href="#tentang" class="nav-link">Tentang</a>
                </div>

                <!-- Desktop CTA -->
                <div class="nav-cta-wrapper">
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

                <!-- Hamburger -->
                <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                    <svg id="icon-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                    <svg id="icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu" id="mobile-menu">
                <div style="display:flex;flex-direction:column;gap:0.2rem;">
                    <a href="{{ route('home') }}" class="mobile-menu-link active">🏠 Beranda</a>
                    <a href="{{ route('rooms') }}" class="mobile-menu-link">🛏 Kamar</a>
                    <a href="#fasilitas" class="mobile-menu-link">✨ Fasilitas</a>
                    <a href="#tentang" class="mobile-menu-link">ℹ️ Tentang</a>
                    <div style="padding-top:0.75rem;">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="btn-nav" style="display:flex;justify-content:center;width:100%;">Dashboard Admin</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-nav" style="display:flex;justify-content:center;width:100%;">Login Admin</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- END NAVBAR -->

    <!-- ════ HERO ════ -->
    <div class="hero" id="hero-section">
        <div class="hero-grid"></div>
        <div class="hero-circle"></div>

        <div class="hero-content">
            <div class="fade-up" style="max-width:600px;">
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Hunian Terpercaya &amp; Nyaman
                </div>
                <h1 class="hero-title">
                    Temukan Rumah<br>
                    <span class="accent">Kedua</span> Kamu<br>
                    di Sini
                </h1>
                <p class="hero-sub">
                    {{ env('KOST_ADDRESS', 'Lokasi strategis, fasilitas lengkap') }} —
                    pilihan hunian ideal untuk mahasiswa dan pekerja modern.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('rooms') }}" class="btn-hero-green">
                        Lihat Semua Kamar
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    <a href="#tentang" class="btn-hero-outline">Tentang Kami</a>
                </div>
            </div>

            <!-- Stats -->
            <div class="hero-stats fade-up d3">
                <div class="hero-stat">
                    <div class="hero-stat-number">{{ $previewRooms->count() }}+</div>
                    <div class="hero-stat-label">Tipe Kamar</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">100%</div>
                    <div class="hero-stat-label">Kepuasan</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">24/7</div>
                    <div class="hero-stat-label">Keamanan CCTV</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-number">3+</div>
                    <div class="hero-stat-label">Tahun Pengalaman</div>
                </div>
            </div>
        </div>
    </div>
    <!-- END HERO -->

    <!-- ════ FASILITAS ════ -->
    <section id="fasilitas">
        <div class="facilities-section">
            <div class="section-heading">
                <span class="section-pill">Fasilitas</span>
                <h2 class="section-title" style="margin-top:0.75rem;margin-bottom:0.5rem;">Semua yang Kamu Butuhkan</h2>
                <p>Fasilitas lengkap agar kamu bisa fokus tanpa khawatir soal kebutuhan sehari-hari.</p>
            </div>
            <div class="facilities-grid">
                <div class="facility-card">
                    <div class="facility-icon">📶</div>
                    <p class="facility-name">WiFi Cepat</p>
                    <p class="facility-desc">Koneksi stabil untuk kerja dan belajar tanpa gangguan.</p>
                </div>
                <div class="facility-card">
                    <div class="facility-icon">📹</div>
                    <p class="facility-name">CCTV 24 Jam</p>
                    <p class="facility-desc">Pengawasan penuh demi keamanan seluruh penghuni.</p>
                </div>
                <div class="facility-card">
                    <div class="facility-icon">🅿️</div>
                    <p class="facility-name">Parkir Luas</p>
                    <p class="facility-desc">Area parkir aman untuk motor dan mobil penghuni.</p>
                </div>
                <div class="facility-card">
                    <div class="facility-icon">🧹</div>
                    <p class="facility-name">Pembersihan Rutin</p>
                    <p class="facility-desc">Lingkungan bersih terjaga dengan jadwal berkala.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ════ TIPE KAMAR ════ -->
    <section class="rooms-bg">
        <div class="rooms-section">
            <div class="rooms-inner">
                <div class="section-heading">
                    <span class="section-pill">Pilihan Kamar</span>
                    <h2 class="section-title" style="margin-top:0.75rem;margin-bottom:0.5rem;">Tersedia Berbagai Tipe</h2>
                    <p>Pilih kamar yang paling sesuai dengan kebutuhan dan anggaranmu.</p>
                </div>

                <div class="rooms-grid">
                    <!-- VVIP -->
                    <div class="room-card">
                        <div class="room-header rh-vvip">
                            <span class="room-type-tag">Tipe</span>
                            <div class="room-name">VVIP</div>
                            <p class="room-tagline">Pengalaman premium terbaik</p>
                        </div>
                        <div class="room-body">
                            <ul class="room-features">
                                <li><span class="check-icon check-blue">✓</span> AC &amp; Kipas Angin</li>
                                <li><span class="check-icon check-blue">✓</span> Kamar Mandi Dalam</li>
                                <li><span class="check-icon check-blue">✓</span> Kasur Spring Bed</li>
                                <li><span class="check-icon check-blue">✓</span> Lemari Pakaian</li>
                                <li><span class="check-icon check-green">✓</span> WiFi Dedicated</li>
                                <li><span class="check-icon check-green">✓</span> TV &amp; Kulkas</li>
                            </ul>
                            <a href="{{ route('rooms') }}?type=vvip" class="room-cta cta-blue-dark">
                                Jelajahi Kamar VVIP →
                            </a>
                        </div>
                    </div>

                    <!-- VIP (featured) -->
                    <div class="room-card featured">
                        <div class="room-header rh-vip">
                            <span class="popular-tag">⭐ Populer</span>
                            <span class="room-type-tag">Tipe</span>
                            <div class="room-name">VIP</div>
                            <p class="room-tagline">Nyaman dengan fasilitas lengkap</p>
                        </div>
                        <div class="room-body">
                            <ul class="room-features">
                                <li><span class="check-icon check-blue">✓</span> AC</li>
                                <li><span class="check-icon check-blue">✓</span> Kamar Mandi Dalam</li>
                                <li><span class="check-icon check-blue">✓</span> Kasur Spring Bed</li>
                                <li><span class="check-icon check-blue">✓</span> Lemari Pakaian</li>
                                <li><span class="check-icon check-green">✓</span> WiFi Cepat</li>
                                <li><span class="check-icon check-green">✓</span> Meja Belajar</li>
                            </ul>
                            <a href="{{ route('rooms') }}?type=vip" class="room-cta cta-blue">
                                Jelajahi Kamar VIP →
                            </a>
                        </div>
                    </div>

                    <!-- Reguler -->
                    <div class="room-card">
                        <div class="room-header rh-regular">
                            <span class="room-type-tag">Tipe</span>
                            <div class="room-name">Reguler</div>
                            <p class="room-tagline">Hemat &amp; tetap nyaman</p>
                        </div>
                        <div class="room-body">
                            <ul class="room-features">
                                <li><span class="check-icon check-gray">✓</span> Kipas Angin</li>
                                <li><span class="check-icon check-gray">✓</span> Kamar Mandi Luar</li>
                                <li><span class="check-icon check-gray">✓</span> Kasur Busa</li>
                                <li><span class="check-icon check-gray">✓</span> Lemari Pakaian</li>
                                <li><span class="check-icon check-gray">✓</span> WiFi Bersama</li>
                                <li><span class="check-icon check-gray">✓</span> Meja Belajar</li>
                            </ul>
                            <a href="{{ route('rooms') }}?type=regular" class="room-cta cta-slate">
                                Jelajahi Kamar Reguler →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════ TENTANG KAMI ════ -->
    <section id="tentang">
        <div class="about-section">
            <div class="about-grid">
                <div>
                    <span class="section-pill">Tentang Kami</span>
                    <h2 class="section-title" style="margin-top:0.75rem;margin-bottom:1.25rem;">{{ env('KOST_NAME', 'Kost Kami') }}</h2>
                    <p style="margin-bottom:1rem;font-size:0.875rem;line-height:1.75;color:#64748b;">
                        Kami menyediakan hunian nyaman dengan fasilitas lengkap di lokasi yang strategis.
                        Cocok untuk mahasiswa maupun pekerja yang menginginkan tempat tinggal yang bersih,
                        aman, dan terjangkau.
                    </p>
                    <p style="margin-bottom:2rem;font-size:0.875rem;line-height:1.75;color:#64748b;">
                        Dengan pengalaman bertahun-tahun, kami berkomitmen memberikan pelayanan terbaik
                        dan lingkungan yang kondusif bagi seluruh penghuni.
                    </p>
                    <div class="about-stats-grid">
                        <div class="about-stat-card">
                            <div class="about-stat-num">{{ $previewRooms->count() }}+</div>
                            <div class="about-stat-label">Tipe Kamar Tersedia</div>
                        </div>
                        <div class="about-stat-card">
                            <div class="about-stat-num">100%</div>
                            <div class="about-stat-label">Kepuasan Penghuni</div>
                        </div>
                    </div>
                </div>

                <div class="info-cards-stack">
                    <div class="info-card">
                        <div class="info-icon">📍</div>
                        <div>
                            <p class="info-title">Lokasi Strategis</p>
                            <p class="info-text">{{ env('KOST_ADDRESS', 'Alamat belum diatur') }}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">📞</div>
                        <div>
                            <p class="info-title">Hubungi Kami</p>
                            <p class="info-text">+{{ env('ADMIN_PHONE', 'Nomor belum diatur') }}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">🕐</div>
                        <div>
                            <p class="info-title">Jam Operasional</p>
                            <p class="info-text">Senin – Minggu, 08.00 – 21.00 WIB</p>
                        </div>
                    </div>
                    <div class="info-card" style="border-color:#bbf7d0;background:#f0fdf4;">
                        <div class="info-icon" style="background:var(--green-light);">✉️</div>
                        <div>
                            <p class="info-title">Tertarik Bergabung?</p>
                            <a href="{{ route('rooms') }}" style="color:var(--green-dark);font-size:0.8rem;font-weight:700;display:inline-flex;align-items:center;gap:4px;margin-top:2px;text-decoration:none;">
                                Lihat kamar tersedia →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════ FOOTER ════ -->
    <footer>
        <div class="footer-inner">
            <div class="footer-top">
                <div>
                    <div style="display:flex;align-items:center;gap:0.6rem;margin-bottom:0.5rem;">
                        <div style="width:30px;height:30px;background:var(--blue-primary);border-radius:8px;display:flex;align-items:center;justify-content:center;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        </div>
                        <span style="font-weight:900;font-size:1rem;color:#fff;letter-spacing:-0.01em;">
                            {{ env('KOST_NAME', 'KOST-MANAJEMEN') }}
                        </span>
                    </div>
                    <p style="font-size:0.78rem;color:#475569;max-width:280px;line-height:1.6;">
                        {{ env('KOST_ADDRESS', '') }}
                    </p>
                </div>
                <div class="footer-links">
                    <a href="{{ route('home') }}" class="footer-link">Beranda</a>
                    <a href="{{ route('rooms') }}" class="footer-link">Kamar</a>
                    <a href="#fasilitas" class="footer-link">Fasilitas</a>
                    <a href="#tentang" class="footer-link">Tentang</a>
                </div>
            </div>
            <div class="footer-bottom">
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

        // Hamburger toggle
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobile-menu');
        const iconOpen   = document.getElementById('icon-open');
        const iconClose  = document.getElementById('icon-close');

        hamburger.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.toggle('open');
            iconOpen.style.display  = isOpen ? 'none'  : 'block';
            iconClose.style.display = isOpen ? 'block' : 'none';
        });

        // Close mobile menu on link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('open');
                iconOpen.style.display  = 'block';
                iconClose.style.display = 'none';
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    const offset = 84;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });

        // Scroll-triggered fade-up for cards
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });

        document.querySelectorAll('.facility-card, .room-card, .info-card, .about-stat-card').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(18px)';
            el.style.transition = `opacity 0.5s ease ${i * 0.06}s, transform 0.5s ease ${i * 0.06}s`;
            io.observe(el);
        });
    </script>
</body>
</html>
