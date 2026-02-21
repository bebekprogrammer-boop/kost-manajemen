@extends('layouts.admin')
@section('title', 'Manajemen Pengeluaran')
@section('header', 'Pengeluaran Operasional Kost')

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

    .expenses-page { font-family: 'Roboto', sans-serif; }

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
        align-items: flex-end;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-form {
        display: flex;
        align-items: flex-end;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-label {
        font-size: 0.68rem;
        font-weight: 700;
        color: #7a9a7a;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .filter-input {
        padding: 0.62rem 0.9rem;
        font-size: 0.875rem;
        font-family: 'Roboto', sans-serif;
        color: var(--g1);
        background: white;
        border: 1.5px solid rgba(22,163,74,0.2);
        border-radius: 12px;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .filter-input:focus {
        border-color: rgba(22,163,74,0.55);
        box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
    }

    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.65rem 1.25rem;
        background: linear-gradient(135deg, var(--g3), var(--b2));
        color: white;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: opacity 0.2s;
        letter-spacing: 0.03em;
    }

    .btn-filter:hover { opacity: 0.88; }

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

    /* ── Flash ── */
    .flash-success {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.9rem 1.25rem;
        border-radius: 14px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        animation: flashIn 0.4s ease;
        background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        border: 1px solid rgba(22,163,74,0.25);
        color: var(--g2);
    }

    @keyframes flashIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ── Table card ── */
    .table-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .table-wrap {
        overflow-x: auto;
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
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
        opacity: 0;
        animation: rowIn 0.3s ease forwards;
    }

    tbody tr:hover { background: #f8fff8; }

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

    tbody td {
        padding: 1rem 1.5rem;
        font-size: 0.875rem;
        color: var(--g1);
        vertical-align: middle;
        font-family: 'Roboto', sans-serif;
        white-space: nowrap;
    }

    /* Date */
    .date-val {
        font-size: 0.82rem;
        color: #5a7a6a;
        font-weight: 500;
    }

    /* Category pill */
    .category-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.28rem 0.75rem;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
        background: rgba(29,78,216,0.08);
        color: var(--b2);
        letter-spacing: 0.03em;
    }

    /* Description */
    .desc-val {
        font-size: 0.875rem;
        color: #5a7a6a;
        font-weight: 400;
        max-width: 240px;
        white-space: normal;
        line-height: 1.4;
    }

    /* Amount */
    .amount-val {
        font-weight: 700;
        color: var(--red);
        font-size: 0.9rem;
    }

    /* Receipt link */
    .receipt-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--b3);
        text-decoration: none;
        padding: 0.22rem 0.6rem;
        border-radius: 7px;
        background: rgba(29,78,216,0.07);
        transition: all 0.2s;
    }

    .receipt-link:hover {
        background: rgba(29,78,216,0.15);
    }

    .receipt-none {
        font-size: 0.82rem;
        color: #c0c8c0;
    }

    /* Action buttons */
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
        font-family: 'Roboto', sans-serif;
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
        font-family: 'Roboto', sans-serif;
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
    .empty-inner p { font-size: 0.9rem; font-weight: 500; }
    .empty-inner a {
        font-size: 0.82rem;
        color: var(--g4);
        font-weight: 700;
        text-decoration: none;
    }
    .empty-inner a:hover { text-decoration: underline; }

    /* ── Total footer ── */
    tfoot tr {
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        border-top: 2px solid rgba(22,163,74,0.15);
    }

    tfoot td {
        padding: 1rem 1.5rem;
        font-family: 'Roboto', sans-serif;
        white-space: nowrap;
    }

    .tfoot-label {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7a9a7a;
        text-align: right;
    }

    .tfoot-total {
        font-family: 'Roboto Slab', serif;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--red);
    }

    /* Entry animation */
    .anim-in {
        opacity: 0;
        transform: translateY(12px);
        animation: pageIn 0.5s ease forwards;
    }

    @keyframes pageIn { to { opacity: 1; transform: translateY(0); } }

    .anim-in:nth-child(1) { animation-delay: 0.05s; }
    .anim-in:nth-child(2) { animation-delay: 0.12s; }
    .anim-in:nth-child(3) { animation-delay: 0.19s; }

    /* Delete modal */
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.92) translateY(16px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

<div class="expenses-page">

    <div class="section-label">Pengeluaran Operasional</div>

    {{-- ── Top Bar ── --}}
    <div class="top-bar anim-in">
        <form action="{{ route('admin.expenses.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <span class="filter-label">Pilih Bulan</span>
                <input type="month" name="month" value="{{ $month }}" class="filter-input">
            </div>
            <button type="submit" class="btn-filter">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                Tampilkan
            </button>
        </form>

        <a href="{{ route('admin.expenses.create') }}" class="btn-add">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Pengeluaran
        </a>
    </div>

    {{-- ── Flash ── --}}
    @if(session('success'))
    <div class="flash-success anim-in">
        <span>✅</span>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Table Card ── --}}
    <div class="table-card anim-in">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>Jumlah (Rp)</th>
                        <th>Kwitansi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses as $expense)
                    <tr>

                        {{-- Date --}}
                        <td>
                            <span class="date-val">
                                {{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}
                            </span>
                        </td>

                        {{-- Category --}}
                        <td>
                            <span class="category-pill">
                                {{ $expense->category }}
                            </span>
                        </td>

                        {{-- Description --}}
                        <td>
                            <span class="desc-val">{{ $expense->description ?? '—' }}</span>
                        </td>

                        {{-- Amount --}}
                        <td>
                            <span class="amount-val">Rp {{ number_format($expense->amount, 0, ',', '.') }}</span>
                        </td>

                        {{-- Receipt --}}
                        <td>
                            @if($expense->receipt_photo)
                                <a href="{{ asset('storage/' . $expense->receipt_photo) }}" target="_blank" class="receipt-link">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Lihat
                                </a>
                            @else
                                <span class="receipt-none">—</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="actions-cell">
                                <a href="{{ route('admin.expenses.edit', $expense) }}" class="btn-edit">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST"
                                      onsubmit="return confirmDelete(event, '{{ \Carbon\Carbon::parse($expense->expense_date)->format('d M Y') }}', '{{ addslashes($expense->category) }}')">
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
                                <div class="empty-icon">🧾</div>
                                <p>Tidak ada pengeluaran pada bulan ini</p>
                                <a href="{{ route('admin.expenses.create') }}">+ Tambah pengeluaran pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="tfoot-label">Total Pengeluaran Bulan Ini</td>
                        <td class="tfoot-total">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

{{-- ── Delete confirmation modal ── --}}
<div id="deleteModal" style="
    display: none;
    position: fixed; inset: 0; z-index: 999;
    background: rgba(10,46,26,0.6);
    backdrop-filter: blur(6px);
    align-items: center; justify-content: center;
">
    <div style="
        background: white;
        border-radius: 24px;
        padding: 2rem 2.25rem;
        max-width: 380px; width: 90%;
        box-shadow: 0 32px 80px rgba(0,0,0,0.2);
        animation: modalIn 0.25s ease;
        font-family: 'Roboto', sans-serif;
    ">
        <div style="font-size: 2.25rem; text-align: center; margin-bottom: 1rem;">🗑️</div>
        <div style="font-family: 'Roboto Slab', serif; font-size: 1.3rem; text-align: center; color: #0a2e1a; margin-bottom: 0.5rem; letter-spacing: -0.02em;">
            Hapus Pengeluaran?
        </div>
        <p style="text-align: center; font-size: 0.875rem; color: #7a9a7a; margin-bottom: 0.35rem; line-height: 1.6;">
            <strong id="modalCategory" style="color: #0a2e1a;"></strong>
        </p>
        <p style="text-align: center; font-size: 0.8rem; color: #9aaa9a; margin-bottom: 1.75rem;">
            <span id="modalDate"></span> &mdash; Data akan dihapus permanen.
        </p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.625rem;">
            <button onclick="cancelDelete()" style="
                padding: 0.7rem;
                border-radius: 12px;
                border: 1.5px solid rgba(22,163,74,0.25);
                background: white; color: #0a2e1a;
                font-weight: 700; font-size: 0.875rem;
                font-family: 'Roboto', sans-serif; cursor: pointer;
                transition: all 0.2s;
            "
            onmouseover="this.style.background='#0a2e1a';this.style.color='white';"
            onmouseout="this.style.background='white';this.style.color='#0a2e1a';">
                Batal
            </button>
            <button id="confirmDeleteBtn" style="
                padding: 0.7rem;
                border-radius: 12px;
                border: none;
                background: linear-gradient(135deg, #dc2626, #ef4444);
                color: white; font-weight: 700; font-size: 0.875rem;
                font-family: 'Roboto', sans-serif; cursor: pointer;
                box-shadow: 0 4px 14px rgba(220,38,38,0.35);
                transition: all 0.2s;
            "
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 20px rgba(220,38,38,0.45)';"
            onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(220,38,38,0.35)';">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let pendingForm = null;

    function confirmDelete(e, date, category) {
        e.preventDefault();
        pendingForm = e.target;
        document.getElementById('modalDate').textContent = date;
        document.getElementById('modalCategory').textContent = category;
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

    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) cancelDelete();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') cancelDelete();
    });
</script>

@endsection
