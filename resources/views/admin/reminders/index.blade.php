@extends('layouts.admin')
@section('title', 'Reminder WhatsApp')
@section('header', 'Pengingat Jatuh Tempo (WhatsApp)')

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
        --orange: #ea580c;
        --card-radius: 20px;
    }

    .reminders-page { font-family: 'Roboto', sans-serif; }

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

    /* ── Info notice ── */
    .info-notice {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0.85rem 1.25rem;
        background: linear-gradient(135deg, #eff6ff, #f0fdf4);
        border: 1px solid rgba(29,78,216,0.15);
        border-radius: 14px;
        font-size: 0.82rem;
        color: var(--b2);
        margin-bottom: 1.75rem;
        font-weight: 500;
    }

    .info-notice code {
        background: rgba(29,78,216,0.1);
        padding: 0.1rem 0.4rem;
        border-radius: 5px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    /* ── Reminder section block ── */
    .reminder-section {
        margin-bottom: 1.5rem;
    }

    /* Section card */
    .section-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    /* Section header variants */
    .section-header {
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }

    .section-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-header-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .section-header-title {
        font-family: 'Roboto Slab', serif;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .section-count {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.28rem 0.75rem;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
    }

    /* Color variants — h7: blue */
    .variant-h7 .section-header       { background: linear-gradient(135deg, #eff6ff, #f0fdf4); }
    .variant-h7 .section-header-icon  { background: rgba(29,78,216,0.1); }
    .variant-h7 .section-header-title { color: var(--b2); }
    .variant-h7 .section-count        { background: rgba(29,78,216,0.1); color: var(--b2); }
    .variant-h7 .tenant-card          { border-color: rgba(29,78,216,0.15); }
    .variant-h7 .btn-wa               { background: linear-gradient(135deg, var(--b3), var(--b2)); box-shadow: 0 4px 12px rgba(29,78,216,0.3); }
    .variant-h7 .btn-wa:hover         { box-shadow: 0 6px 18px rgba(29,78,216,0.4); }

    /* h3: yellow/amber */
    .variant-h3 .section-header       { background: linear-gradient(135deg, #fffbeb, #f0fdf4); }
    .variant-h3 .section-header-icon  { background: rgba(217,119,6,0.1); }
    .variant-h3 .section-header-title { color: #92400e; }
    .variant-h3 .section-count        { background: rgba(217,119,6,0.1); color: var(--yellow); }
    .variant-h3 .tenant-card          { border-color: rgba(217,119,6,0.2); }
    .variant-h3 .btn-wa               { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 12px rgba(217,119,6,0.3); }
    .variant-h3 .btn-wa:hover         { box-shadow: 0 6px 18px rgba(217,119,6,0.4); }

    /* h0: orange */
    .variant-h0 .section-header       { background: linear-gradient(135deg, #fff7ed, #f0fdf4); }
    .variant-h0 .section-header-icon  { background: rgba(234,88,12,0.1); }
    .variant-h0 .section-header-title { color: #9a3412; }
    .variant-h0 .section-count        { background: rgba(234,88,12,0.1); color: var(--orange); }
    .variant-h0 .tenant-card          { border-color: rgba(234,88,12,0.2); }
    .variant-h0 .btn-wa               { background: linear-gradient(135deg, #f97316, #ea580c); box-shadow: 0 4px 12px rgba(234,88,12,0.3); }
    .variant-h0 .btn-wa:hover         { box-shadow: 0 6px 18px rgba(234,88,12,0.4); }

    /* overdue: red */
    .variant-overdue .section-header       { background: linear-gradient(135deg, #fff1f2, #f0fdf4); }
    .variant-overdue .section-header-icon  { background: rgba(220,38,38,0.1); }
    .variant-overdue .section-header-title { color: #991b1b; }
    .variant-overdue .section-count        { background: rgba(220,38,38,0.1); color: var(--red); }
    .variant-overdue .tenant-card          { border-color: rgba(220,38,38,0.2); }
    .variant-overdue .btn-wa               { background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 12px rgba(220,38,38,0.3); }
    .variant-overdue .btn-wa:hover         { box-shadow: 0 6px 18px rgba(220,38,38,0.4); }

    /* ── Section body ── */
    .section-body { padding: 1.25rem 1.5rem; }

    /* ── Tenant grid ── */
    .tenant-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1rem;
    }

    /* ── Tenant card ── */
    .tenant-card {
        background: white;
        border: 1.5px solid rgba(22,163,74,0.12);
        border-radius: 16px;
        padding: 1.1rem 1.1rem 1rem;
        position: relative;
        transition: box-shadow 0.2s;
    }

    .tenant-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.07); }

    /* Sent badge */
    .sent-badge {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.2rem 0.55rem;
        border-radius: 99px;
        font-size: 0.65rem;
        font-weight: 700;
        background: rgba(22,163,74,0.1);
        color: var(--g3);
        border: 1px solid rgba(22,163,74,0.2);
    }

    /* Tenant name */
    .tenant-name {
        font-family: 'Roboto Slab', serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--g1);
        margin-bottom: 3px;
        padding-right: 90px;
        line-height: 1.2;
    }

    /* Room badge */
    .room-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 0.18rem 0.5rem;
        border-radius: 7px;
        background: linear-gradient(135deg, rgba(22,163,74,0.08), rgba(29,78,216,0.08));
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--g2);
        margin-bottom: 0.6rem;
    }

    /* Info rows inside card */
    .card-info { display: flex; flex-direction: column; gap: 4px; margin-bottom: 0.85rem; }

    .card-info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
    }

    .card-info-label {
        font-size: 0.7rem;
        color: #9aaa9a;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .card-info-val {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--g1);
    }

    .card-info-amount {
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--red);
    }

    /* WA Button */
    .btn-wa {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0.6rem 1rem;
        color: white;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border: none;
        border-radius: 11px;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-wa::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
        transition: left 0.4s ease;
    }

    .btn-wa:hover::before { left: 100%; }
    .btn-wa:hover { transform: translateY(-1px); }
    .btn-wa:disabled { cursor: not-allowed; transform: none !important; }

    .btn-wa-sent {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 0.6rem 1rem;
        background: rgba(22,163,74,0.08);
        color: var(--g3);
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border: 1.5px solid rgba(22,163,74,0.2);
        border-radius: 11px;
        cursor: not-allowed;
    }

    .btn-wa-loading {
        background: rgba(150,150,150,0.15) !important;
        color: #7a9a7a !important;
        box-shadow: none !important;
    }

    /* Empty state */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
        padding: 2.5rem 1.5rem;
        color: #9aaa9a;
        text-align: center;
    }

    .empty-state .empty-icon { font-size: 2rem; opacity: 0.4; }
    .empty-state p { font-size: 0.875rem; font-weight: 500; }

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
    .anim-in:nth-child(4) { animation-delay: 0.26s; }
    .anim-in:nth-child(5) { animation-delay: 0.33s; }
</style>

<div class="reminders-page">

    <div class="section-label">Pengingat Jatuh Tempo</div>


    @php
        $sections = [
            ['key' => 'h7',      'title' => 'H-7 — Kurang 7 Hari',          'icon' => '🔔', 'variant' => 'h7'],
            ['key' => 'h3',      'title' => 'H-3 — Kurang 3 Hari',          'icon' => '⚠️',  'variant' => 'h3'],
            ['key' => 'h0',      'title' => 'H-0 — Jatuh Tempo Hari Ini',   'icon' => '🔴',  'variant' => 'h0'],
            ['key' => 'overdue', 'title' => 'Overdue — Sudah Lewat Jatuh Tempo', 'icon' => '💥', 'variant' => 'overdue'],
        ];
    @endphp

    @foreach($sections as $i => $section)
        @php $data = $reminders[$section['key']]; @endphp

        <div class="reminder-section anim-in">
            <div class="section-card variant-{{ $section['variant'] }}">

                {{-- Header --}}
                <div class="section-header">
                    <div class="section-header-left">
                        <div class="section-header-icon">{{ $section['icon'] }}</div>
                        <div class="section-header-title">{{ $section['title'] }}</div>
                    </div>
                    <span class="section-count">
                        {{ $data->count() }} Penghuni
                    </span>
                </div>

                {{-- Body --}}
                <div class="section-body">
                    @if($data->count() > 0)
                        <div class="tenant-grid">
                            @foreach($data as $tenant)
                                @php
                                    $alreadySent = $reminderService->alreadySentToday($tenant, $section['key']);
                                    $waUrl       = $reminderService->buildWhatsAppUrl($tenant, $section['key']);
                                    $payment     = $tenant->payments->where('status', 'unpaid')->first();
                                    $amount      = $payment ? $payment->amount : 0;

                                    if ($section['key'] == 'overdue') {
                                        $daysLate = max(0, now()->diffInDays($tenant->due_date, false) * -1);
                                        $penalty  = $daysLate * config('app.penalty_per_day', 5000);
                                        $amount  += $penalty;
                                    }
                                @endphp

                                <div class="tenant-card" id="card-{{ $tenant->id }}-{{ $section['key'] }}">

                                    {{-- Sent badge --}}
                                    @if($alreadySent)
                                        <span class="sent-badge">✓ Terkirim Hari Ini</span>
                                    @endif

                                    {{-- Name --}}
                                    <div class="tenant-name">{{ $tenant->name }}</div>

                                    {{-- Room --}}
                                    <div>
                                        <span class="room-badge">🏠 {{ $tenant->room->room_number }}</span>
                                    </div>

                                    {{-- Info --}}
                                    <div class="card-info">
                                        <div class="card-info-row">
                                            <span class="card-info-label">Due Date</span>
                                            <span class="card-info-val">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d M Y') }}</span>
                                        </div>
                                        <div class="card-info-row">
                                            <span class="card-info-label">Tagihan</span>
                                            <span class="card-info-amount">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    {{-- Button --}}
                                    @if($alreadySent)
                                        <div class="btn-wa-sent">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                            Sudah Dikirim
                                        </div>
                                    @else
                                        <button
                                            type="button"
                                            id="btn-{{ $tenant->id }}-{{ $section['key'] }}"
                                            onclick="sendReminder({{ $tenant->id }}, '{{ $section['key'] }}', '{{ $waUrl }}', this)"
                                            class="btn-wa">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                                            Kirim via WhatsApp
                                        </button>
                                    @endif

                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">✅</div>
                            <p>Tidak ada penghuni dalam kategori ini</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    @endforeach

</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    function sendReminder(tenantId, type, waUrl, btnElement) {
        window.open(waUrl, '_blank');

        btnElement.disabled = true;
        btnElement.classList.add('btn-wa-loading');
        btnElement.innerHTML = `
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Mencatat...
        `;

        fetch('{{ route('admin.reminders.log') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ tenant_id: tenantId, type: type })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // Replace button with sent state
                btnElement.outerHTML = `
                    <div class="btn-wa-sent">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Sudah Dikirim
                    </div>
                `;
                // Add sent badge to card
                const card = document.getElementById('card-' + tenantId + '-' + type);
                if (card && !card.querySelector('.sent-badge')) {
                    const badge = document.createElement('span');
                    badge.className = 'sent-badge';
                    badge.innerHTML = '✓ Terkirim Hari Ini';
                    card.prepend(badge);
                }
            }
        })
        .catch(() => {
            btnElement.classList.remove('btn-wa-loading');
            btnElement.disabled = false;
            btnElement.innerHTML = `
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
                Kirim via WhatsApp
            `;
        });
    }
</script>

@endsection
