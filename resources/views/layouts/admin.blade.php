<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --g1: #0a2e1a;
            --g2: #0d4a2e;
            --g3: #106b3f;
            --g4: #16a34a;
            --g5: #4ade80;
            --g6: #bbf7d0;
            --b1: #06193a;
            --b2: #0c2e68;
            --b3: #1d4ed8;
            --b4: #3b82f6;
            --b5: #93c5fd;
            --cream: #f7fdf9;
            --sidebar-w: 260px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Roboto', sans-serif;
            background: var(--cream);
            color: #0f1a12;
            display: flex;
            height: 100vh;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: var(--sidebar-w);
            height: 100vh;
            background: linear-gradient(180deg, var(--g1) 0%, #0a2540 100%);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: relative;
            overflow: hidden;
        }

        /* Background texture on sidebar */
        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        /* Green orb bottom */
        .sidebar::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -60px;
            width: 260px;
            height: 260px;
            background: radial-gradient(circle, rgba(22,163,74,0.18), transparent 70%);
            pointer-events: none;
        }

        /* Blue orb top */
        .sb-orb-top {
            position: absolute;
            top: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(29,78,216,0.18), transparent 70%);
            pointer-events: none;
        }

        /* ─── Logo ─── */
        .sb-logo {
            padding: 1.5rem 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-mark {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--g3), var(--b3));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            color: white;
            font-style: italic;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(22,163,74,0.4);
        }

        .logo-info {}

        .logo-name {
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            color: white;
            line-height: 1.1;
            letter-spacing: -0.01em;
        }

        .logo-sub {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.35);
            font-weight: 500;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* ─── Nav ─── */
        .sb-nav {
            flex: 1;
            padding: 1rem 0.75rem;
            overflow-y: auto;
            position: relative;
        }

        .sb-nav::-webkit-scrollbar { width: 3px; }
        .sb-nav::-webkit-scrollbar-track { background: transparent; }
        .sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 3px; }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 0.5rem 0.625rem 0.375rem;
            margin-top: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.6rem 0.875rem;
            border-radius: 11px;
            color: rgba(255,255,255,0.55);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
            margin-bottom: 2px;
        }

        .nav-link:hover {
            background: rgba(255,255,255,0.07);
            color: rgba(255,255,255,0.9);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(22,163,74,0.25), rgba(29,78,216,0.18));
            color: white;
            border: 1px solid rgba(22,163,74,0.2);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 18px;
            background: linear-gradient(180deg, var(--g4), var(--b3));
            border-radius: 0 3px 3px 0;
        }

        .nav-icon {
            width: 18px; height: 18px;
            opacity: 0.7;
            flex-shrink: 0;
            transition: opacity 0.2s;
        }

        .nav-link.active .nav-icon,
        .nav-link:hover .nav-icon {
            opacity: 1;
        }

        .nav-link.active .nav-icon path,
        .nav-link.active .nav-icon rect,
        .nav-link.active .nav-icon circle,
        .nav-link.active .nav-icon polyline,
        .nav-link.active .nav-icon line {
            stroke: var(--g5);
        }

        /* ─── Sidebar Footer ─── */
        .sb-footer {
            padding: 1rem 0.75rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            position: relative;
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.625rem 0.75rem;
            border-radius: 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 0.625rem;
        }

        .sb-avatar {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--g3), var(--b3));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
            font-family: 'Roboto', sans-serif;
        }

        .sb-user-info { flex: 1; min-width: 0; }

        .sb-user-name {
            font-size: 0.82rem;
            font-weight: 600;
            color: rgba(255,255,255,0.9);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .sb-user-role {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--g5);
            margin-top: 2px;
        }

        .role-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--g5);
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }

        .sb-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 0.55rem;
            border-radius: 10px;
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            color: rgba(252,165,165,0.8);
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Roboto', sans-serif;
            transition: all 0.2s ease;
        }

        .sb-logout:hover {
            background: rgba(239,68,68,0.18);
            border-color: rgba(239,68,68,0.35);
            color: #fca5a5;
        }

        /* ─── MAIN AREA ─── */
        .main-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ─── TOP HEADER ─── */
        .topbar {
            height: 64px;
            background: white;
            border-bottom: 1px solid rgba(22,163,74,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            flex-shrink: 0;
            box-shadow: 0 1px 12px rgba(0,0,0,0.04);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: #8a9e8a;
            font-weight: 500;
        }

        .topbar-breadcrumb span { color: #c8d8c8; }

        .topbar-title {
            font-family: 'Roboto', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--g1);
            letter-spacing: -0.02em;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        /* Notification bell */
        .topbar-icon-btn {
            width: 38px; height: 38px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: var(--cream);
            border: 1px solid rgba(22,163,74,0.12);
            cursor: pointer;
            transition: all 0.2s ease;
            color: #4a7060;
            position: relative;
        }

        .topbar-icon-btn:hover {
            background: #f0fdf4;
            border-color: rgba(22,163,74,0.3);
            color: var(--g3);
        }

        .notif-badge {
            position: absolute;
            top: 6px; right: 6px;
            width: 7px; height: 7px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid white;
        }

        /* Date pill */
        .topbar-date {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.4rem 0.875rem;
            background: #f0fdf4;
            border: 1px solid rgba(22,163,74,0.15);
            border-radius: 10px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--g3);
        }

        /* ─── CONTENT AREA ─── */
        .content-area {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 2rem;
            background: var(--cream);
        }

        .content-area::-webkit-scrollbar { width: 5px; }
        .content-area::-webkit-scrollbar-track { background: transparent; }
        .content-area::-webkit-scrollbar-thumb {
            background: rgba(22,163,74,0.2);
            border-radius: 4px;
        }

        /* Flash messages */
        .flash {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 0.875rem 1.125rem;
            border-radius: 14px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            animation: slideIn 0.4s ease;
        }

        .flash-success {
            background: #f0fdf4;
            border: 1px solid rgba(22,163,74,0.2);
            color: var(--g2);
        }

        .flash-error {
            background: #fef2f2;
            border: 1px solid rgba(239,68,68,0.2);
            color: #991b1b;
        }

        .flash-warning {
            background: #fffbeb;
            border: 1px solid rgba(245,158,11,0.2);
            color: #92400e;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ─── Shared Card Style (for child views) ─── */
        .card {
            background: white;
            border-radius: 20px;
            border: 1px solid rgba(22,163,74,0.1);
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s ease;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(22,163,74,0.08);
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(22,163,74,0.08);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .card-title {
            font-family: 'Roboto', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--g1);
            letter-spacing: -0.02em;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Section tag (same as landing) */
        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--g3);
            margin-bottom: 0.5rem;
        }

        .section-tag::before {
            content: '';
            display: block;
            width: 16px; height: 2px;
            background: linear-gradient(90deg, var(--g4), var(--b3));
            border-radius: 2px;
        }

        /* Stat cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid rgba(22,163,74,0.1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(22,163,74,0.1);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 120px; height: 120px;
            border-radius: 50%;
            opacity: 0.06;
            transform: translate(30px, -30px);
        }

        .stat-card.green::before { background: var(--g4); }
        .stat-card.blue::before  { background: var(--b3); }

        .stat-icon-wrap {
            width: 40px; height: 40px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1rem;
        }

        .stat-icon-wrap.green { background: rgba(22,163,74,0.1); color: var(--g3); }
        .stat-icon-wrap.blue  { background: rgba(29,78,216,0.1); color: var(--b3); }
        .stat-icon-wrap.amber { background: rgba(245,158,11,0.1); color: #d97706; }
        .stat-icon-wrap.red   { background: rgba(239,68,68,0.1); color: #dc2626; }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #8a9e8a;
            margin-bottom: 0.375rem;
        }

        .stat-value {
            font-family: 'Roboto', sans-serif;
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--g1);
            line-height: 1;
            letter-spacing: -0.03em;
        }

        .stat-sub {
            font-size: 0.75rem;
            color: #a0b5a0;
            margin-top: 0.375rem;
            font-weight: 500;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 0.55rem 1.125rem;
            border-radius: 10px;
            font-size: 0.845rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-family: 'Roboto', sans-serif;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--g3), var(--b2));
            color: white;
            box-shadow: 0 3px 12px rgba(16,107,63,0.35);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(16,107,63,0.45);
        }

        .btn-secondary {
            background: white;
            color: var(--g2);
            border: 1.5px solid rgba(22,163,74,0.2);
        }

        .btn-secondary:hover {
            border-color: rgba(22,163,74,0.45);
            background: #f0fdf4;
        }

        .btn-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1.5px solid rgba(239,68,68,0.2);
        }

        .btn-danger:hover {
            background: #fee2e2;
            border-color: rgba(239,68,68,0.4);
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.78rem;
        }

        /* Table */
        .table-wrap {
            overflow-x: auto;
            border-radius: 16px;
            border: 1px solid rgba(22,163,74,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead {
            background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        }

        thead th {
            padding: 0.875rem 1.125rem;
            text-align: left;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b8e6b;
            white-space: nowrap;
            border-bottom: 1px solid rgba(22,163,74,0.1);
        }

        tbody tr {
            border-bottom: 1px solid rgba(22,163,74,0.06);
            transition: background 0.15s ease;
        }

        tbody tr:last-child { border-bottom: none; }

        tbody tr:hover { background: #f7fdf9; }

        tbody td {
            padding: 0.875rem 1.125rem;
            color: #1a2e1a;
            vertical-align: middle;
        }

        /* Form inputs */
        .form-group { margin-bottom: 1.25rem; }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--g1);
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border-radius: 10px;
            border: 1.5px solid rgba(22,163,74,0.18);
            background: white;
            font-size: 0.875rem;
            font-family: 'Roboto', sans-serif;
            color: var(--g1);
            outline: none;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--g4);
            box-shadow: 0 0 0 3px rgba(22,163,74,0.12);
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 7L11 1' stroke='%23106b3f' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 2rem;
        }

        /* Status/type badges (shared) */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.2rem 0.625rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .badge-green   { background: #dcfce7; color: #15803d; }
        .badge-blue    { background: #dbeafe; color: #1d4ed8; }
        .badge-red     { background: #fee2e2; color: #dc2626; }
        .badge-amber   { background: #fef3c7; color: #d97706; }
        .badge-purple  { background: #f3e8ff; color: #7c3aed; }
        .badge-gray    { background: #f1f5f9; color: #64748b; }

        /* Pagination */
        .pagination {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            justify-content: center;
            padding: 1rem;
        }

        .page-btn {
            width: 34px; height: 34px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid rgba(22,163,74,0.15);
            color: var(--g2);
            background: white;
            transition: all 0.2s;
        }

        .page-btn:hover { border-color: var(--g4); color: var(--g3); }
        .page-btn.active {
            background: linear-gradient(135deg, var(--g3), var(--b2));
            color: white;
            border-color: transparent;
            box-shadow: 0 2px 8px rgba(16,107,63,0.3);
        }

        /* Page load animation */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .content-area > * {
            animation: fadeUp 0.4s ease both;
        }
    </style>
</head>

<body>

    <!-- ─── SIDEBAR ─── -->
    <aside class="sidebar">
        <div class="sb-orb-top"></div>

        <!-- Logo -->
        <a href="{{ route('admin.dashboard') }}" class="sb-logo">
            <div class="logo-mark">K</div>
            <div class="logo-info">
                <div class="logo-name">{{ config('app.name', 'KostKu') }}</div>
                <div class="logo-sub">Management System</div>
            </div>
        </a>

        <!-- Nav -->
        <nav class="sb-nav">
            <div class="nav-section-label">Menu Utama</div>

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.rooms.index') }}"
               class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Kamar
            </a>

            <a href="{{ route('admin.tenants.index') }}"
               class="nav-link {{ request()->routeIs('admin.tenants.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
                Penghuni
            </a>

            <a href="{{ route('admin.payments.index') }}"
               class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>
                </svg>
                Pembayaran
            </a>

            <a href="{{ route('admin.expenses.index') }}"
               class="nav-link {{ request()->routeIs('admin.expenses.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
                Pengeluaran
            </a>

            <div class="nav-section-label">Komunikasi</div>

            <a href="{{ route('admin.reminders.index') }}"
               class="nav-link {{ request()->routeIs('admin.reminders.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.09 9.27a19.79 19.79 0 01-3.07-8.67A2 2 0 012 .5h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>
                </svg>
                Reminder WA
            </a>

            <div class="nav-section-label">Laporan</div>

            <a href="{{ route('admin.reports.index') }}"
               class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                </svg>
                Laporan
            </a>

            @if(auth()->user()->role === 'super_admin')
            <a href="{{ route('admin.activity-logs.index') }}"
               class="nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                </svg>
                Log Aktivitas
            </a>
            @endif

            <div class="nav-section-label">Sistem</div>

            <a href="{{ route('admin.settings.index') }}"
               class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/>
                </svg>
                Pengaturan
            </a>
        </nav>

        <!-- User footer -->
        <div class="sb-footer">
            <div class="sb-user">
                <div class="sb-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="sb-user-info">
                    <div class="sb-user-name">{{ auth()->user()->name }}</div>
                    <div class="sb-user-role">
                        <div class="role-dot"></div>
                        {{ strtoupper(auth()->user()->role) }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sb-logout">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    <!-- ─── MAIN ─── -->
    <div class="main-wrap">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <div>
                    <div class="topbar-breadcrumb">
                        Admin <span>›</span> @yield('title', 'Dashboard')
                    </div>
                    <div class="topbar-title">@yield('header', 'Dashboard')</div>
                </div>
            </div>

            <div class="topbar-right">
                <div class="topbar-date">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    {{ now()->translatedFormat('d M Y') }}
                </div>
                
            </div>
        </header>

        <!-- Content -->
        <main class="content-area">
            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="flash flash-success">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="flash flash-error">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            @if(session('warning'))
            <div class="flash flash-warning">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px">
                    <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                {{ session('warning') }}
            </div>
            @endif

            @yield('content')
        </main>

    </div>

</body>
</html>
