@extends('layouts.admin')
@section('title', 'Detail Penghuni')
@section('header', 'Detail Data Penghuni')

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

    .detail-page { font-family: 'Roboto', sans-serif; }

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

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 1.25rem;
        align-items: start;
    }

    @media (max-width: 900px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

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
        letter-spacing: -0.01em;
    }

    .card-body { padding: 1.5rem; }

    .profile-hero {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1.25rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid rgba(22,163,74,0.08);
    }

    .profile-avatar {
        width: 52px; height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(22,163,74,0.12), rgba(29,78,216,0.12));
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        font-weight: 900;
        color: var(--g3);
        font-family: 'Roboto', sans-serif;
        flex-shrink: 0;
    }

    .profile-name {
        font-family: 'Roboto Slab', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--g1);
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .info-list { display: flex; flex-direction: column; gap: 0.85rem; }

    .info-row {
        display: flex;
        align-items: flex-start;
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
        padding-top: 1px;
    }

    .info-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--g1);
        text-align: right;
    }

    .info-value.bold { font-weight: 700; }

    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.22rem 0.6rem;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(22,163,74,0.08), rgba(29,78,216,0.08));
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--g2);
    }

    .type-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.22rem 0.65rem;
        border-radius: 99px;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
    }

    .type-vvip    { background: rgba(139,92,246,0.12); color: #6d28d9; }
    .type-vip     { background: rgba(29,78,216,0.1);   color: var(--b2); }
    .type-reguler { background: rgba(22,163,74,0.1);   color: var(--g3); }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.25rem 0.7rem;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
    }

    .status-pip {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-active { background: rgba(29,78,216,0.1);    color: var(--b2); }
    .status-alumni { background: rgba(150,150,150,0.12); color: #6b7a6b; }

    .due-highlight { font-weight: 700; color: var(--red); }

    .ktp-wrap {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(22,163,74,0.08);
    }

    .ktp-label {
        font-size: 0.72rem;
        font-weight: 500;
        color: #9aaa9a;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 0.6rem;
    }

    .ktp-img {
        width: 100%;
        height: 110px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid rgba(22,163,74,0.12);
    }

    .btn-alumni-wrap {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(22,163,74,0.08);
    }

    .btn-alumni {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, #d97706, #b45309);
        color: white;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(217,119,6,0.3);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-alumni::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.5s ease;
    }

    .btn-alumni:hover::before { left: 100%; }
    .btn-alumni:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(217,119,6,0.4);
    }

    table { width: 100%; border-collapse: collapse; }

    thead { background: linear-gradient(135deg, #f0fdf4, #eff6ff); }

    thead th {
        padding: 0.85rem 1.5rem;
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
        padding: 0.9rem 1.5rem;
        font-size: 0.875rem;
        color: var(--g1);
        vertical-align: middle;
        font-family: 'Roboto', sans-serif;
    }

    .invoice-num {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--b2);
        background: rgba(29,78,216,0.07);
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
        letter-spacing: 0.02em;
    }

    .period-val { font-size: 0.82rem; color: #5a7a6a; font-weight: 500; }
    .amount-val { font-weight: 700; color: var(--g2); }

    .pay-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.25rem 0.7rem;
        border-radius: 99px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .pay-pip { width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
    .pay-paid   { background: rgba(22,163,74,0.1); color: var(--g3); }
    .pay-unpaid { background: rgba(220,38,38,0.1); color: var(--red); }

    .empty-cell { padding: 2.5rem 1.5rem !important; text-align: center; }

    .empty-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
        color: #9aaa9a;
    }

    .empty-inner .empty-icon { font-size: 2rem; opacity: 0.45; }
    .empty-inner p { font-size: 0.85rem; font-weight: 500; }

    .anim-in {
        opacity: 0;
        transform: translateY(12px);
        animation: pageIn 0.5s ease forwards;
    }

    @keyframes pageIn { to { opacity: 1; transform: translateY(0); } }

    .anim-in:nth-child(1) { animation-delay: 0.05s; }
    .anim-in:nth-child(2) { animation-delay: 0.12s; }

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

    /* ── Alumni modal ── */
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.92) translateY(16px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
</style>

<div class="detail-page">

    <div class="section-label">Detail Penghuni</div>

    <div class="detail-grid">

        {{-- ── Left: Profile Card ── --}}
        <div class="card anim-in">
            <div class="card-header">
                <div class="card-header-icon">👤</div>
                <div class="card-title">Profil Penghuni</div>
            </div>
            <div class="card-body">

                <div class="profile-hero">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($tenant->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="profile-name">{{ $tenant->name }}</div>
                        <span class="status-pill {{ $tenant->status == 'active' ? 'status-active' : 'status-alumni' }}">
                            <div class="status-pip"></div>
                            {{ $tenant->status == 'active' ? 'Aktif' : 'Alumni' }}
                        </span>
                    </div>
                </div>

                <div class="info-list">
                    <div class="info-row">
                        <span class="info-label">Kamar</span>
                        <span class="info-value">
                            <span class="room-badge">🏠 {{ $tenant->room->room_number }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Tipe</span>
                        <span class="info-value">
                            <span class="type-pill type-{{ $tenant->room->type }}">
                                {{ strtoupper($tenant->room->type) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">No. HP / WA</span>
                        <span class="info-value bold">{{ $tenant->phone }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $tenant->email ?? '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Check In</span>
                        <span class="info-value">{{ \Carbon\Carbon::parse($tenant->check_in_date)->format('d M Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jatuh Tempo</span>
                        <span class="info-value due-highlight">
                            {{ \Carbon\Carbon::parse($tenant->due_date)->format('d M Y') }}
                        </span>
                    </div>
                </div>

                @if($tenant->id_card_photo)
                <div class="ktp-wrap">
                    <div class="ktp-label">Foto KTP</div>
                    <img src="{{ asset('storage/' . $tenant->id_card_photo) }}" class="ktp-img" alt="KTP {{ $tenant->name }}">
                </div>
                @endif

                @if($tenant->status == 'active')
                <div class="btn-alumni-wrap">
                    <form id="alumniForm" action="{{ route('admin.tenants.alumni', $tenant) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="button" class="btn-alumni" onclick="openAlumniModal('{{ $tenant->name }}')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Jadikan Alumni
                        </button>
                    </form>
                </div>
                @endif

            </div>
        </div>

        {{-- ── Right: Payment History Card ── --}}
        <div class="card anim-in">
            <div class="card-header">
                <div class="card-header-icon">💳</div>
                <div class="card-title">Histori Pembayaran</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Periode</th>
                        <th>Total (Rp)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenant->payments as $payment)
                    <tr>
                        <td><span class="invoice-num">{{ $payment->invoice_number }}</span></td>
                        <td>
                            <span class="period-val">
                                {{ \Carbon\Carbon::parse($payment->period_start)->format('d/m/y') }}
                                &ndash;
                                {{ \Carbon\Carbon::parse($payment->period_end)->format('d/m/y') }}
                            </span>
                        </td>
                        <td><span class="amount-val">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</span></td>
                        <td>
                            <span class="pay-pill {{ $payment->status == 'paid' ? 'pay-paid' : 'pay-unpaid' }}">
                                <div class="pay-pip"></div>
                                {{ strtoupper($payment->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-cell">
                            <div class="empty-inner">
                                <div class="empty-icon">💳</div>
                                <p>Belum ada riwayat pembayaran</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- ── Alumni Confirmation Modal ── --}}
<div id="alumniModal" style="
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
        <div style="font-size: 2.25rem; text-align: center; margin-bottom: 1rem;">🎓</div>
        <div style="font-family: 'Roboto Slab', serif; font-size: 1.3rem; text-align: center; color: #0a2e1a; margin-bottom: 0.5rem; letter-spacing: -0.02em;">
            Jadikan Alumni?
        </div>
        <p style="text-align: center; font-size: 0.875rem; color: #7a9a7a; margin-bottom: 1.75rem; line-height: 1.6;">
            <strong id="modalTenantName" style="color: #0a2e1a;"></strong> akan dipindahkan ke status Alumni dan kamarnya otomatis menjadi <strong style="color: #0a2e1a;">Tersedia</strong>.
        </p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.625rem;">
            <button onclick="closeAlumniModal()" style="
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
            <button onclick="document.getElementById('alumniForm').submit()" style="
                padding: 0.7rem;
                border-radius: 12px;
                border: none;
                background: linear-gradient(135deg, #d97706, #b45309);
                color: white; font-weight: 700; font-size: 0.875rem;
                font-family: 'Roboto', sans-serif; cursor: pointer;
                box-shadow: 0 4px 14px rgba(217,119,6,0.35);
                transition: all 0.2s;
            "
            onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 20px rgba(217,119,6,0.45)';"
            onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(217,119,6,0.35)';">
                Ya, Jadikan Alumni
            </button>
        </div>
    </div>
</div>

<script>
    function openAlumniModal(name) {
        document.getElementById('modalTenantName').textContent = name;
        const modal = document.getElementById('alumniModal');
        modal.style.display = 'flex';
    }

    function closeAlumniModal() {
        document.getElementById('alumniModal').style.display = 'none';
    }

    // Close on backdrop click
    document.getElementById('alumniModal').addEventListener('click', function(e) {
        if (e.target === this) closeAlumniModal();
    });

    // Close on Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeAlumniModal();
    });
</script>

@endsection
