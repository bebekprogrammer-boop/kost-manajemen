@extends('layouts.admin')
@section('title', 'Manajemen Pembayaran')
@section('header', 'Daftar Tagihan & Pembayaran')

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

    .payments-page { font-family: 'Roboto', sans-serif; }

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

    /* ── Filter bar ── */
    .filter-bar {
        display: flex;
        align-items: flex-end;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
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

    .filter-input,
    .filter-select {
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

    .filter-input:focus,
    .filter-select:focus {
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

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.65rem 1rem;
        border-radius: 12px;
        border: 1.5px solid rgba(22,163,74,0.2);
        background: white;
        color: #7a9a7a;
        font-size: 0.82rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-reset:hover { border-color: var(--g3); color: var(--g2); }

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
        min-width: 900px;
    }

    thead {
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
    }

    thead th {
        padding: 0.9rem 1rem;
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
    tbody tr.row-overdue { background: rgba(220,38,38,0.03); }
    tbody tr.row-overdue:hover { background: rgba(220,38,38,0.06); }

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
        padding: 0.9rem 1rem;
        font-size: 0.875rem;
        color: var(--g1);
        vertical-align: middle;
        font-family: 'Roboto', sans-serif;
        white-space: nowrap;
    }

    /* Invoice */
    .invoice-num {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--b2);
        background: rgba(29,78,216,0.07);
        padding: 0.22rem 0.55rem;
        border-radius: 6px;
        letter-spacing: 0.02em;
        display: inline-block;
    }

    /* Tenant */
    .tenant-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tenant-avatar {
        width: 28px; height: 28px;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(22,163,74,0.1), rgba(29,78,216,0.1));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem;
        font-weight: 900;
        color: var(--g3);
        flex-shrink: 0;
    }

    .tenant-name {
        font-family: 'Roboto Slab', serif;
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--g1);
    }

    /* Room badge */
    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.22rem 0.55rem;
        border-radius: 7px;
        background: linear-gradient(135deg, rgba(22,163,74,0.08), rgba(29,78,216,0.08));
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--g2);
    }

    /* Due date */
    .due-normal  { font-size: 0.82rem; color: #5a7a6a; font-weight: 500; }
    .due-overdue { font-size: 0.82rem; font-weight: 700; color: var(--red); }

    /* Amounts */
    .amount-base    { font-weight: 500; color: #5a7a6a; }
    .amount-penalty { font-weight: 600; color: var(--red); }
    .amount-penalty-zero { font-weight: 400; color: #c0c8c0; }
    .amount-total   { font-weight: 700; color: var(--g1); }

    /* Pay date */
    .pay-date       { font-size: 0.82rem; color: #5a7a6a; font-weight: 500; }
    .pay-date-empty { font-size: 0.82rem; color: #c0c8c0; }

    /* Status pill */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.25rem 0.7rem;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-pip {
        width: 5px; height: 5px;
        border-radius: 50%;
        background: currentColor;
        flex-shrink: 0;
    }

    .status-paid    { background: rgba(22,163,74,0.1);  color: var(--g3); }
    .status-unpaid  { background: rgba(217,119,6,0.1);  color: var(--yellow); }
    .status-overdue { background: rgba(220,38,38,0.1);  color: var(--red); }

    /* Detail button */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.38rem 0.85rem;
        border-radius: 9px;
        border: 1.5px solid rgba(22,163,74,0.25);
        color: var(--g2);
        font-size: 0.75rem;
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

    /* Pagination */
    .pagination-wrap {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(22,163,74,0.08);
        background: linear-gradient(135deg, #f8fff8, #f5f8ff);
        display: flex;
        align-items: center;
        justify-content: flex-end;
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
</style>

<div class="payments-page">

    <div class="section-label">Tagihan & Pembayaran</div>

    {{-- ── Filter Bar ── --}}
    <form action="{{ route('admin.payments.index') }}" method="GET" class="filter-bar anim-in">
        <div class="filter-group">
            <span class="filter-label">Filter Bulan</span>
            <input type="month" name="month" value="{{ request('month') }}" class="filter-input">
        </div>
        <div class="filter-group">
            <span class="filter-label">Status</span>
            <select name="status" class="filter-select">
                <option value="">Semua Status</option>
                <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="paid"   {{ request('status') == 'paid'   ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
        <button type="submit" class="btn-filter">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            Filter
        </button>
        <a href="{{ route('admin.payments.index') }}" class="btn-reset">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
            Reset
        </a>
    </form>

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
                        <th>No. Invoice</th>
                        <th>Penghuni</th>
                        <th>Kamar</th>
                        <th>Jatuh Tempo</th>
                        <th>Tagihan Pokok</th>
                        <th>Denda</th>
                        <th>Total</th>
                        <th>Tgl Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    @php
                        $isOverdue = $payment->status === 'unpaid' && \Carbon\Carbon::parse($payment->period_end)->isPast();
                    @endphp
                    <tr class="{{ $isOverdue ? 'row-overdue' : '' }}">

                        {{-- Invoice --}}
                        <td>
                            <span class="invoice-num">{{ $payment->invoice_number }}</span>
                        </td>

                        {{-- Tenant --}}
                        <td>
                            <div class="tenant-info">
                                <div class="tenant-avatar">{{ strtoupper(substr($payment->tenant->name, 0, 1)) }}</div>
                                <span class="tenant-name">{{ $payment->tenant->name }}</span>
                            </div>
                        </td>

                        {{-- Room --}}
                        <td>
                            <span class="room-badge">🏠 {{ $payment->room->room_number }}</span>
                        </td>

                        {{-- Due date --}}
                        <td>
                            <span class="{{ $isOverdue ? 'due-overdue' : 'due-normal' }}">
                                {{ \Carbon\Carbon::parse($payment->period_end)->format('d/m/Y') }}
                            </span>
                        </td>

                        {{-- Base amount --}}
                        <td>
                            <span class="amount-base">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                        </td>

                        {{-- Penalty --}}
                        <td>
                            <span class="{{ $payment->penalty > 0 ? 'amount-penalty' : 'amount-penalty-zero' }}">
                                Rp {{ number_format($payment->penalty, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Total --}}
                        <td>
                            <span class="amount-total">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span>
                        </td>

                        {{-- Payment date --}}
                        <td>
                            @if($payment->payment_date)
                                <span class="pay-date">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</span>
                            @else
                                <span class="pay-date-empty">—</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            @if($payment->status == 'paid')
                                <span class="status-pill status-paid">
                                    <div class="status-pip"></div>Lunas
                                </span>
                            @elseif($isOverdue)
                                <span class="status-pill status-overdue">
                                    <div class="status-pip"></div>Terlambat
                                </span>
                            @else
                                <span class="status-pill status-unpaid">
                                    <div class="status-pip"></div>Belum Bayar
                                </span>
                            @endif
                        </td>

                        {{-- Action --}}
                        <td>
                            <a href="{{ route('admin.payments.show', $payment) }}" class="btn-detail">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                                Detail
                            </a>
                        </td>

                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="10">
                            <div class="empty-inner">
                                <div class="empty-icon">💳</div>
                                <p>Tidak ada data pembayaran</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($payments->hasPages())
        <div class="pagination-wrap">
            {{ $payments->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
