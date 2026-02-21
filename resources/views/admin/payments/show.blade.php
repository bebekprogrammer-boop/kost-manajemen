@extends('layouts.admin')
@section('title', 'Detail Pembayaran')
@section('header', 'Rincian Tagihan')

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

    .payment-detail-page { font-family: 'Roboto', sans-serif; }

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

    /* ── Layout ── */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        align-items: start;
    }

    @media (max-width: 860px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    /* ── Card ── */
    .card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .card-header {
        padding: 1.1rem 1.5rem 1rem;
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        border-bottom: 1px solid rgba(22,163,74,0.08);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .card-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        background: linear-gradient(135deg, rgba(22,163,74,0.15), rgba(29,78,216,0.12));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .card-title {
        font-family: 'Roboto Slab', serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--g1);
    }

    /* Invoice number in header */
    .invoice-chip {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--b2);
        background: rgba(29,78,216,0.08);
        padding: 0.25rem 0.65rem;
        border-radius: 7px;
        letter-spacing: 0.02em;
        font-family: 'Roboto', sans-serif;
    }

    /* Status pill */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.28rem 0.75rem;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .status-pip {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-paid    { background: rgba(22,163,74,0.1);  color: var(--g3); }
    .status-unpaid  { background: rgba(217,119,6,0.1);  color: var(--yellow); }
    .status-overdue { background: rgba(220,38,38,0.1);  color: var(--red); }

    .card-body { padding: 1.5rem; }

    /* ── Info rows ── */
    .info-list { display: flex; flex-direction: column; gap: 0.85rem; }

    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .info-label {
        font-size: 0.72rem;
        font-weight: 500;
        color: #9aaa9a;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .info-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--g1);
        text-align: right;
    }

    .info-value.bold { font-weight: 700; }

    /* Tenant display */
    .tenant-info {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .tenant-avatar {
        width: 24px; height: 24px;
        border-radius: 7px;
        background: linear-gradient(135deg, rgba(22,163,74,0.1), rgba(29,78,216,0.1));
        display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem;
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
        padding: 0.2rem 0.55rem;
        border-radius: 7px;
        background: linear-gradient(135deg, rgba(22,163,74,0.08), rgba(29,78,216,0.08));
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--g2);
    }

    /* Type pill */
    .type-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.18rem 0.55rem;
        border-radius: 99px;
        font-size: 0.63rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        margin-left: 4px;
    }

    .type-vvip    { background: rgba(139,92,246,0.12); color: #6d28d9; }
    .type-vip     { background: rgba(29,78,216,0.1);   color: var(--b2); }
    .type-reguler { background: rgba(22,163,74,0.1);   color: var(--g3); }

    /* Due date */
    .due-val { font-weight: 700; color: var(--red); }

    /* ── Amount breakdown ── */
    .amount-section {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(22,163,74,0.08);
        display: flex;
        flex-direction: column;
        gap: 0.65rem;
    }

    .amount-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .amount-label {
        font-size: 0.82rem;
        color: #7a9a7a;
        font-weight: 500;
    }

    .amount-val { font-size: 0.875rem; font-weight: 600; color: var(--g2); }
    .amount-val-penalty { font-size: 0.875rem; font-weight: 600; color: var(--red); }
    .amount-val-zero { font-size: 0.875rem; font-weight: 400; color: #c0c8c0; }

    .amount-total-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 0.4rem;
        padding-top: 0.85rem;
        border-top: 1px solid rgba(22,163,74,0.1);
    }

    .amount-total-label {
        font-family: 'Roboto Slab', serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--g1);
    }

    .amount-total-val {
        font-family: 'Roboto Slab', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--g1);
    }

    /* ── Paid meta ── */
    .paid-meta {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(22,163,74,0.08);
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    /* Notes box */
    .notes-box {
        margin-top: 0.5rem;
        padding: 0.75rem 1rem;
        background: linear-gradient(135deg, #f8fff8, #f5f8ff);
        border: 1px solid rgba(22,163,74,0.1);
        border-radius: 12px;
        font-size: 0.82rem;
        color: #5a7a6a;
        line-height: 1.5;
    }

    /* Download invoice button */
    .btn-download {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(22,163,74,0.08);
    }

    .btn-download a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        justify-content: center;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, var(--g1), var(--b1));
        color: white;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border-radius: 14px;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(10,46,26,0.25);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-download a::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .btn-download a:hover::before { left: 100%; }
    .btn-download a:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(10,46,26,0.35);
    }

    /* ── Confirm payment card ── */
    .confirm-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(29,78,216,0.15);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .confirm-card .card-header {
        background: linear-gradient(135deg, #eff6ff, #f0fdf4);
        border-bottom: 1px solid rgba(29,78,216,0.08);
    }

    /* Amount highlight box */
    .amount-highlight {
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        border: 1px solid rgba(22,163,74,0.15);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .amount-highlight-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #7a9a7a;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .amount-highlight-val {
        font-family: 'Roboto Slab', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--g1);
    }

    .amount-highlight-sub {
        font-size: 0.72rem;
        color: #9aaa9a;
        margin-top: 2px;
    }

    /* Warning notice */
    .notice-box {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 0.85rem 1rem;
        background: rgba(217,119,6,0.06);
        border: 1px solid rgba(217,119,6,0.2);
        border-radius: 12px;
        margin-bottom: 1.25rem;
        font-size: 0.82rem;
        color: #92400e;
        line-height: 1.5;
    }

    .notice-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

    /* Form elements */
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 1.25rem; }

    .form-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #5a7a6a;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-family: 'Roboto', sans-serif;
    }

    .form-label .label-optional {
        font-size: 0.65rem;
        font-weight: 400;
        color: #9aaa9a;
        text-transform: none;
        letter-spacing: 0;
        margin-left: 4px;
    }

    .form-textarea {
        width: 100%;
        padding: 0.65rem 0.9rem;
        font-size: 0.875rem;
        font-family: 'Roboto', sans-serif;
        color: var(--g1);
        background: white;
        border: 1.5px solid rgba(22,163,74,0.2);
        border-radius: 12px;
        outline: none;
        resize: vertical;
        min-height: 85px;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .form-textarea:focus {
        border-color: rgba(22,163,74,0.55);
        box-shadow: 0 0 0 3px rgba(22,163,74,0.1);
    }

    .form-textarea::placeholder { color: #b0c0b0; }

    /* Confirm button */
    .btn-confirm {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0.8rem 1.25rem;
        background: linear-gradient(135deg, var(--g4), var(--b3));
        color: white;
        font-size: 0.9rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(22,163,74,0.35);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-confirm::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.5s ease;
    }

    .btn-confirm:hover::before { left: 100%; }
    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(22,163,74,0.45);
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

    /* Modal */
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.92) translateY(16px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

<div class="payment-detail-page">

    <div class="section-label">Rincian Tagihan</div>

    <div class="detail-grid">

        {{-- ── Left: Invoice Detail Card ── --}}
        <div class="card anim-in">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-header-icon">🧾</div>
                    <div class="card-title">Detail Invoice</div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <span class="invoice-chip">{{ $payment->invoice_number }}</span>
                    @php
                        $isOverdue = $payment->status === 'unpaid' && \Carbon\Carbon::parse($payment->period_end)->isPast();
                    @endphp
                    @if($payment->status == 'paid')
                        <span class="status-pill status-paid"><div class="status-pip"></div>Lunas</span>
                    @elseif($isOverdue)
                        <span class="status-pill status-overdue"><div class="status-pip"></div>Terlambat</span>
                    @else
                        <span class="status-pill status-unpaid"><div class="status-pip"></div>Belum Bayar</span>
                    @endif
                </div>
            </div>

            <div class="card-body">

                {{-- Info rows --}}
                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Penghuni</span>
                        <span class="info-value">
                            <div class="tenant-info">
                                <div class="tenant-avatar">{{ strtoupper(substr($payment->tenant->name, 0, 1)) }}</div>
                                <span class="tenant-name">{{ $payment->tenant->name }}</span>
                            </div>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Kamar</span>
                        <span class="info-value">
                            <span class="room-badge">🏠 {{ $payment->room->room_number }}</span>
                            <span class="type-pill type-{{ $payment->room->type }}">{{ strtoupper($payment->room->type) }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Periode Sewa</span>
                        <span class="info-value">
                            {{ \Carbon\Carbon::parse($payment->period_start)->format('d M Y') }}
                            &ndash;
                            {{ \Carbon\Carbon::parse($payment->period_end)->format('d M Y') }}
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jatuh Tempo</span>
                        <span class="info-value due-val">
                            {{ \Carbon\Carbon::parse($payment->period_end)->format('d M Y') }}
                        </span>
                    </div>
                </div>

                {{-- Amount breakdown --}}
                <div class="amount-section">
                    <div class="amount-row">
                        <span class="amount-label">Tagihan Pokok</span>
                        <span class="amount-val">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                    </div>

                    @if($payment->status === 'unpaid')
                        <div class="amount-row">
                            <span class="amount-label">Denda (hingga hari ini)</span>
                            <span class="{{ $currentPenalty > 0 ? 'amount-val-penalty' : 'amount-val-zero' }}">
                                Rp {{ number_format($currentPenalty, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="amount-total-row">
                            <span class="amount-total-label">Total Tagihan</span>
                            <span class="amount-total-val">Rp {{ number_format($payment->amount + $currentPenalty, 0, ',', '.') }}</span>
                        </div>
                    @else
                        <div class="amount-row">
                            <span class="amount-label">Denda</span>
                            <span class="{{ $payment->penalty > 0 ? 'amount-val-penalty' : 'amount-val-zero' }}">
                                Rp {{ number_format($payment->penalty, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="amount-total-row">
                            <span class="amount-total-label">Total Dibayar</span>
                            <span class="amount-total-val">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                </div>

                {{-- Paid meta --}}
                @if($payment->status === 'paid')
                <div class="paid-meta">
                    <div class="info-row">
                        <span class="info-label">Tgl Pembayaran</span>
                        <span class="info-value bold">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Dikonfirmasi Oleh</span>
                        <span class="info-value bold">{{ $payment->paidBy->name ?? '-' }}</span>
                    </div>
                    @if($payment->notes)
                    <div class="notes-box">
                        💬 {{ $payment->notes }}
                    </div>
                    @endif
                </div>

                <div class="btn-download">
                    <a href="{{ route('admin.payments.invoice', $payment) }}">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Download Invoice PDF
                    </a>
                </div>
                @endif

            </div>
        </div>

        {{-- ── Right: Confirm Payment Card ── --}}
        @if($payment->status === 'unpaid')
        <div class="confirm-card anim-in">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-header-icon">✅</div>
                    <div class="card-title">Konfirmasi Pembayaran</div>
                </div>
            </div>

            <div class="card-body">

                {{-- Amount to receive --}}
                <div class="amount-highlight">
                    <div>
                        <div class="amount-highlight-label">Jumlah yang Diterima</div>
                        <div class="amount-highlight-sub">Tagihan pokok + denda hari ini</div>
                    </div>
                    <div class="amount-highlight-val">
                        Rp {{ number_format($payment->amount + $currentPenalty, 0, ',', '.') }}
                    </div>
                </div>

                {{-- Warning --}}
                <div class="notice-box">
                    <span class="notice-icon">⚠️</span>
                    <span>Pastikan dana telah diterima sebelum konfirmasi. <strong>Aksi ini tidak dapat dibatalkan.</strong></span>
                </div>

                {{-- Form --}}
                <form id="confirmForm" action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tenant_id" value="{{ $payment->tenant_id }}">

                    <div class="form-group">
                        <label class="form-label">
                            Catatan <span class="label-optional">(opsional)</span>
                        </label>
                        <textarea
                            name="notes"
                            class="form-textarea"
                            placeholder="Misal: Ditransfer via BCA a.n Budi..."
                        ></textarea>
                    </div>

                    <button type="button" class="btn-confirm" onclick="openConfirmModal()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Konfirmasi Pembayaran Sekarang
                    </button>
                </form>

            </div>
        </div>
        @endif

    </div>
</div>

{{-- ── Confirm Payment Modal ── --}}
@if($payment->status === 'unpaid')
<div id="confirmModal" style="
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
        <div style="font-size: 2.25rem; text-align: center; margin-bottom: 1rem;">💳</div>
        <div style="font-family: 'Roboto Slab', serif; font-size: 1.3rem; text-align: center; color: #0a2e1a; margin-bottom: 0.5rem; letter-spacing: -0.02em;">
            Konfirmasi Pembayaran?
        </div>
        <p style="text-align: center; font-size: 0.875rem; color: #7a9a7a; margin-bottom: 0.5rem; line-height: 1.6;">
            Atas nama <strong style="color: #0a2e1a;">{{ $payment->tenant->name }}</strong>
        </p>
        <p style="text-align: center; font-family: 'Roboto Slab', serif; font-size: 1.1rem; font-weight: 700; color: #0a2e1a; margin-bottom: 1.75rem;">
            Rp {{ number_format($payment->amount + $currentPenalty, 0, ',', '.') }}
        </p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.625rem;">
            <button onclick="closeConfirmModal()" style="
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
            <button onclick="document.getElementById('confirmForm').submit()" style="
                padding: 0.7rem;
                border-radius: 12px;
                border: none;
                background: linear-gradient(135deg, #16a34a, #1d4ed8);
                color: white; font-weight: 700; font-size: 0.875rem;
                font-family: 'Roboto', sans-serif; cursor: pointer;
                box-shadow: 0 4px 14px rgba(22,163,74,0.35);
                transition: all 0.2s;
            "
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 20px rgba(22,163,74,0.45)';"
            onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(22,163,74,0.35)';">
                Ya, Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
    function openConfirmModal() {
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirmModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeConfirmModal();
    });
</script>
@endif

@endsection
