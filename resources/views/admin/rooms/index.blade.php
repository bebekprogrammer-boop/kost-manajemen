@extends('layouts.admin')
@section('title', 'Manajemen Kamar')
@section('header', 'Daftar Kamar')

@section('content')
<style>
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
        --card-radius: 20px;
    }

    .rooms-page { font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif; }

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
        font-family: inherit;
        color: var(--g1);
        background: transparent;
        min-width: 220px;
    }

    .search-input::placeholder { color: #b0c0b0; }

    .search-btn {
        padding: 0.65rem 1.25rem;
        background: linear-gradient(135deg, var(--g3), var(--b2));
        color: white;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: inherit;
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
        font-family: inherit;
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
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7a9a7a;
        white-space: nowrap;
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
    }

    /* Room number */
    .room-num {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .room-num-icon {
        width: 34px; height: 34px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(22,163,74,0.1), rgba(29,78,216,0.1));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .room-num-val {
        font-family: 'Instrument Serif', 'DM Serif Display', serif;
        font-size: 1.05rem;
        color: var(--g1);
        letter-spacing: -0.02em;
    }

    /* Type badge */
    .type-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 99px;
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }

    .type-vvip    { background: rgba(139,92,246,0.12); color: #6d28d9; }
    .type-vip     { background: rgba(29,78,216,0.1); color: var(--b2); }
    .type-reguler { background: rgba(22,163,74,0.1); color: var(--g3); }

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

    .status-available {
        background: rgba(22,163,74,0.1);
        color: var(--g3);
    }

    .status-occupied {
        background: rgba(220,38,38,0.1);
        color: var(--red);
    }

    /* Price */
    .price-val {
        font-weight: 700;
        color: var(--g2);
    }

    /* Floor */
    .floor-val {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px; height: 28px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(22,163,74,0.08), rgba(29,78,216,0.08));
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--g2);
    }

    /* Actions */
    .actions-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
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
        font-family: inherit;
        transition: all 0.2s ease;
        background: white;
    }

    .btn-edit:hover {
        background: var(--b2);
        color: white;
        border-color: var(--b2);
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.4rem 0.9rem;
        border-radius: 9px;
        border: 1.5px solid rgba(220,38,38,0.2);
        color: var(--red);
        font-size: 0.78rem;
        font-weight: 700;
        background: white;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.2s ease;
    }

    .btn-delete:hover {
        background: var(--red);
        color: white;
        border-color: var(--red);
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

    /* Override default Laravel pagination with our style */
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

<div class="rooms-page">

    {{-- ── Top Bar ── --}}
    <div class="section-label">Manajemen Kamar</div>

    <div class="top-bar anim-in">
        <form action="{{ route('admin.rooms.index') }}" method="GET" class="search-form">
            <span class="search-icon">🔍</span>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nomor kamar..."
                class="search-input"
            >
            <button type="submit" class="search-btn">Cari</button>
        </form>

        <a href="{{ route('admin.rooms.create') }}" class="btn-add">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Kamar
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
                    <th>No. Kamar</th>
                    <th>Tipe</th>
                    <th>Harga / Bulan</th>
                    <th>Lantai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    {{-- Room number --}}
                    <td>
                        <div class="room-num">
                            <div class="room-num-icon">🏠</div>
                            <div class="room-num-val">{{ $room->room_number }}</div>
                        </div>
                    </td>

                    {{-- Type --}}
                    <td>
                        <span class="type-pill type-{{ $room->type }}">
                            {{ strtoupper($room->type) }}
                        </span>
                    </td>

                    {{-- Price --}}
                    <td>
                        <span class="price-val">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                    </td>

                    {{-- Floor --}}
                    <td>
                        <span class="floor-val">{{ $room->floor }}</span>
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="status-pill {{ $room->status == 'available' ? 'status-available' : 'status-occupied' }}">
                            <div class="status-pip"></div>
                            {{ $room->status == 'available' ? 'Tersedia' : 'Terisi' }}
                        </span>
                    </td>

                    {{-- Actions --}}
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-edit">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                Edit
                            </a>
                            <form
                                action="{{ route('admin.rooms.destroy', $room) }}"
                                method="POST"
                                onsubmit="return confirmDelete(event, '{{ $room->room_number }}')"
                            >
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="6">
                        <div class="empty-inner">
                            <div class="empty-icon">🏠</div>
                            <p>Belum ada data kamar</p>
                            <a href="{{ route('admin.rooms.create') }}">+ Tambah kamar pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($rooms->hasPages())
        <div class="pagination-wrap">
            {{ $rooms->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Delete confirmation modal --}}
<div id="deleteModal" style="
    display:none;
    position:fixed; inset:0; z-index:999;
    background:rgba(10,46,26,0.6);
    backdrop-filter:blur(6px);
    align-items:center; justify-content:center;
">
    <div style="
        background:white;
        border-radius:24px;
        padding:2rem 2.25rem;
        max-width:380px; width:90%;
        box-shadow:0 32px 80px rgba(0,0,0,0.2);
        animation:modalIn 0.25s ease;
        font-family:'Outfit','Plus Jakarta Sans',sans-serif;
    ">
        <div style="font-size:2.25rem; text-align:center; margin-bottom:1rem;">🗑️</div>
        <div style="font-family:'Instrument Serif','DM Serif Display',serif; font-size:1.3rem; text-align:center; color:#0a2e1a; margin-bottom:0.5rem; letter-spacing:-0.02em;">
            Hapus Kamar?
        </div>
        <p style="text-align:center; font-size:0.875rem; color:#7a9a7a; margin-bottom:1.75rem; line-height:1.6;">
            Kamar <strong id="modalRoomNum" style="color:#0a2e1a;"></strong> akan dihapus permanen dan tidak bisa dipulihkan.
        </p>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.625rem;">
            <button onclick="cancelDelete()" style="
                padding:0.7rem;
                border-radius:12px;
                border:1.5px solid rgba(22,163,74,0.25);
                background:white; color:#0a2e1a;
                font-weight:700; font-size:0.875rem;
                font-family:inherit; cursor:pointer;
                transition:all 0.2s;
            " onmouseover="this.style.background='#0a2e1a';this.style.color='white';"
               onmouseout="this.style.background='white';this.style.color='#0a2e1a';">
                Batal
            </button>
            <button id="confirmDeleteBtn" style="
                padding:0.7rem;
                border-radius:12px;
                border:none;
                background:linear-gradient(135deg,#dc2626,#ef4444);
                color:white; font-weight:700; font-size:0.875rem;
                font-family:inherit; cursor:pointer;
                box-shadow:0 4px 14px rgba(220,38,38,0.35);
                transition:all 0.2s;
            " onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 20px rgba(220,38,38,0.45)';"
               onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(220,38,38,0.35)';">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<style>
@keyframes modalIn {
    from { opacity:0; transform:scale(0.92) translateY(16px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
</style>

<script>
    let pendingForm = null;

    function confirmDelete(e, roomNum) {
        e.preventDefault();
        pendingForm = e.target;
        document.getElementById('modalRoomNum').textContent = roomNum;
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'flex';

        document.getElementById('confirmDeleteBtn').onclick = function() {
            pendingForm.submit();
        };
        return false;
    }

    function cancelDelete() {
        document.getElementById('deleteModal').style.display = 'none';
        pendingForm = null;
    }

    // Close on backdrop click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) cancelDelete();
    });

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') cancelDelete();
    });
</script>

@endsection
