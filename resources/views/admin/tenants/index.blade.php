@extends('layouts.admin')
@section('title', 'Manajemen Penghuni')
@section('header', 'Daftar Penghuni')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Roboto+Slab:wght@700&display=swap');

    :root {
        --g1: #0a2e1a;
        --g2: #0d4a2e;
        --g3: #106b3f;
        --g4: #16a34a;
        --g5: #4ade80;
        --b1: #06193a;
        --b2: #0c2e68;
        --b3: #1d4ed8;
        --b4: #3b82f6;
        --b5: #93c5fd;
        --red: #dc2626;
        --yellow: #d97706;
        --card-radius: 20px;
    }

    .tenants-page { font-family: 'Roboto', sans-serif; }

    /* ── Section label ── */
    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--g3);
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 1.25rem;
    }

    .section-label::before {
        content: '';
        display: block;
        width: 20px; height: 2px;
        background: linear-gradient(90deg, var(--g4), var(--b3));
        border-radius: 2px;
    }

    /* ── Top bar ── */
    .top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    /* Search */
    .search-form {
        display: flex;
        align-items: center;
        background: white;
        border: 1px solid rgba(22,163,74,0.2);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-form:focus-within {
        border-color: rgba(22,163,74,0.5);
        box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
    }

    .search-icon {
        padding: 0 0.75rem 0 1rem;
        color: #9aaa9a;
        font-size: 0.95rem;
        pointer-events: none;
    }

    .search-input {
        border: none;
        outline: none;
        padding: 0.65rem 0.5rem;
        font-size: 0.875rem;
        font-family: 'Roboto', sans-serif;
        color: var(--g1);
        background: transparent;
        min-width: 200px;
    }

    .search-input::placeholder { color: #b0c0b0; }

    .filter-select {
        border: none;
        outline: none;
        padding: 0.65rem 0.75rem;
        font-size: 0.875rem;
        font-family: 'Roboto', sans-serif;
        color: var(--g1);
        background: transparent;
        cursor: pointer;
        border-left: 1px solid rgba(22,163,74,0.15);
    }

    .search-btn {
        padding: 0.65rem 1.25rem;
        background: linear-gradient(135deg, var(--g3), var(--b2));
        color: white;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border: none;
        cursor: pointer;
        transition: opacity 0.2s;
        letter-spacing: 0.03em;
        height: 100%;
    }

    .search-btn:hover { opacity: 0.88; }

    /* Add button */
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.65rem 1.4rem;
        background: linear-gradient(135deg, var(--g4), var(--b3));
        color: white;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(22,163,74,0.35);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-add::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.5s ease;
    }

    .btn-add:hover::before { left: 100%; }
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(22,163,74,0.45);
    }

    /* ── Alert banners ── */
    .flash-success, .flash-error {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.9rem 1.25rem;
        border-radius: 14px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        animation: flashIn 0.4s ease;
    }

    @keyframes flashIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .flash-success {
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid rgba(22,163,74,0.25);
        color: var(--g2);
    }

    .flash-error {
        background: linear-gradient(135deg, #fff1f2, #ffe4e6);
        border: 1px solid rgba(220,38,38,0.25);
        color: var(--red);
    }

    /* ── Table card ── */
    .table-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
    }

    thead th {
        padding: 0.9rem 1.5rem;
        text-align: left;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7a9a7a;
        white-space: nowrap;
        font-family: 'Roboto', sans-serif;
    }

    tbody tr {
        border-top: 1px solid rgba(22,163,74,0.07);
        transition: background 0.15s ease;
    }

    tbody tr:hover { background: #f8fff8; }

    tbody td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: var(--g1);
        vertical-align: middle;
        font-family: 'Roboto', sans-serif;
    }

    /* Tenant name */
    .tenant-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tenant-avatar {
        width: 34px; height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(22,163,74,0.1), rgba(29,78,216,0.1));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.82rem;
        flex-shrink: 0;
        font-weight: 900;
        color: var(--g3);
        font-family: 'Roboto', sans-serif;
    }

    .tenant-name {
        font-family: 'Roboto Slab', serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--g1);
        line-height: 1.2;
    }

    .tenant-phone {
        font-size: 0.72rem;
        color: #9aaa9a;
        margin-top: 1px;
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
    }

    /* Room badge */
    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.28rem 0.7rem;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(22,163,74,0.08), rgba(29,78,216,0.08));
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--g2);
    }

    /* Type badge */
    .type-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 99px;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }

    .type-vvip    { background: rgba(139,92,246,0.12); color: #6d28d9; }
    .type-vip     { background: rgba(29,78,216,0.1);   color: var(--b2); }
    .type-reguler { background: rgba(22,163,74,0.1);   color: var(--g3); }

    /* Due date */
    .due-date-val {
        font-size: 0.82rem;
        color: var(--g2);
        font-weight: 500;
    }

    /* Days remaining */
    .days-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.28rem 0.75rem;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .days-pip {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .days-safe   { background: rgba(22,163,74,0.1);   color: var(--g3); }
    .days-warn   { background: rgba(217,119,6,0.1);   color: var(--yellow); }
    .days-danger { background: rgba(220,38,38,0.1);   color: var(--red); }
    .days-alumni { background: rgba(150,150,150,0.1); color: #9aaa9a; }

    /* Status pill */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.28rem 0.75rem;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    .status-pip {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-active { background: rgba(29,78,216,0.1);    color: var(--b2); }
    .status-alumni { background: rgba(150,150,150,0.12); color: #6b7a6b; }

    /* Actions */
    .actions-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.4rem 0.9rem;
        border-radius: 9px;
        border: 1.5px solid rgba(22,163,74,0.25);
        color: var(--g2);
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        font-family: 'Roboto', sans-serif;
        transition: all 0.2s ease;
        background: white;
    }

    .btn-detail:hover {
        background: var(--g2);
        color: white;
        border-color: var(--g2);
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.4rem 0.9rem;
        border-radius: 9px;
        border: 1.5px solid rgba(29,78,216,0.25);
        color: var(--b2);
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        font-family: 'Roboto', sans-serif;
        transition: all 0.2s ease;
        background: white;
    }

    .btn-edit:hover {
        background: var(--b2);
        color: white;
        border-color: var(--b2);
    }

    /* Empty state */
    .empty-row td {
        padding: 3.5rem 1.5rem;
        text-align: center;
    }

    .empty-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: #9aaa9a;
    }

    .empty-inner .empty-icon { font-size: 2.5rem; opacity: 0.5; }

    .empty-inner p {
        font-size: 0.9rem;
        font-weight: 500;
    }

    .empty-inner a {
        font-size: 0.82rem;
        color: var(--g4);
        font-weight: 700;
        text-decoration: none;
    }

    .empty-inner a:hover { text-decoration: underline; }

    /* Pagination wrapper */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(22,163,74,0.08);
        background: linear-gradient(135deg, #f8fff8, #f5f8ff);
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .pagination-wrap nav span[aria-current="page"] > span {
        background: linear-gradient(135deg, var(--g3), var(--b2)) !important;
        color: white !important;
        border-radius: 8px !important;
        border: none !important;
    }

    /* Entry animation */
    .anim-in {
        opacity: 0;
        transform: translateY(12px);
        animation: pageIn 0.5s ease forwards;
    }

    @keyframes pageIn {
        to { opacity: 1; transform: translateY(0); }
    }

    .anim-in:nth-child(1) { animation-delay: 0.05s; }
    .anim-in:nth-child(2) { animation-delay: 0.12s; }
    .anim-in:nth-child(3) { animation-delay: 0.19s; }

    /* Row stagger */
    tbody tr { opacity: 0; animation: rowIn 0.3s ease forwards; }
    @keyframes rowIn { to { opacity: 1; } }
    tbody tr:nth-child(1)  { animation-delay: 0.25s; }
    tbody tr:nth-child(2)  { animation-delay: 0.29s; }
    tbody tr:nth-child(3)  { animation-delay: 0.33s; }
    tbody tr:nth-child(4)  { animation-delay: 0.37s; }
    tbody tr:nth-child(5)  { animation-delay: 0.41s; }
    tbody tr:nth-child(6)  { animation-delay: 0.45s; }
    tbody tr:nth-child(7)  { animation-delay: 0.49s; }
    tbody tr:nth-child(8)  { animation-delay: 0.53s; }
    tbody tr:nth-child(9)  { animation-delay: 0.57s; }
    tbody tr:nth-child(10) { animation-delay: 0.61s; }
</style>

<div class="tenants-page">

    {{-- ── Section Label ── --}}
    <div class="section-label">Manajemen Penghuni</div>

    {{-- ── Top Bar ── --}}
    <div class="top-bar anim-in">
        <form action="{{ route('admin.tenants.index') }}" method="GET" class="search-form">
            <span class="search-icon">🔍</span>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama penghuni..."
                class="search-input"
            >
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="active"  {{ request('status') == 'active'  ? 'selected' : '' }}>Aktif</option>
                <option value="alumni"  {{ request('status') == 'alumni'  ? 'selected' : '' }}>Alumni</option>
            </select>
            <button type="submit" class="search-btn">Filter</button>
        </form>

        <a href="{{ route('admin.tenants.create') }}" class="btn-add">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Penghuni
        </a>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
    <div class="flash-success anim-in">
        <span>✅</span>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="flash-error anim-in">
        <span>⚠️</span>
        {{ session('error') }}
    </div>
    @endif

    {{-- ── Table Card ── --}}
    <div class="table-card anim-in">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kamar</th>
                    <th>Tipe</th>
                    <th>Due Date</th>
                    <th>Sisa Hari</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tenants as $tenant)
                <tr>
                    {{-- Tenant name & phone --}}
                    <td>
                        <div class="tenant-info">
                            <div class="tenant-avatar">
                                {{ strtoupper(substr($tenant->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="tenant-name">{{ $tenant->name }}</div>
                                <div class="tenant-phone">{{ $tenant->phone }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Room number --}}
                    <td>
                        <span class="room-badge">
                            🏠 {{ $tenant->room->room_number }}
                        </span>
                    </td>

                    {{-- Room type --}}
                    <td>
                        <span class="type-pill type-{{ $tenant->room->type }}">
                            {{ strtoupper($tenant->room->type) }}
                        </span>
                    </td>

                    {{-- Due date --}}
                    <td>
                        <span class="due-date-val">
                            {{ \Carbon\Carbon::parse($tenant->due_date)->format('d M Y') }}
                        </span>
                    </td>

                    {{-- Days remaining --}}
                    <td>
                        @php $days = $tenant->days_until_due; @endphp
                        @if($tenant->status == 'alumni')
                            <span class="days-pill days-alumni">
                                <div class="days-pip"></div>
                                Alumni
                            </span>
                        @elseif($days > 7)
                            <span class="days-pill days-safe">
                                <div class="days-pip"></div>
                                {{ $days }} Hari
                            </span>
                        @elseif($days >= 3)
                            <span class="days-pill days-warn">
                                <div class="days-pip"></div>
                                {{ $days }} Hari
                            </span>
                        @else
                            <span class="days-pill days-danger">
                                <div class="days-pip"></div>
                                {{ $days }} Hari
                            </span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="status-pill {{ $tenant->status == 'active' ? 'status-active' : 'status-alumni' }}">
                            <div class="status-pip"></div>
                            {{ $tenant->status == 'active' ? 'Aktif' : 'Alumni' }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('admin.tenants.show', $tenant) }}" class="btn-detail">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                                Detail
                            </a>
                            <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn-edit">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="7">
                        <div class="empty-inner">
                            <div class="empty-icon">👥</div>
                            <p>Belum ada data penghuni</p>
                            <a href="{{ route('admin.tenants.create') }}">+ Tambah penghuni pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($tenants->hasPages())
        <div class="pagination-wrap">
            {{ $tenants->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
