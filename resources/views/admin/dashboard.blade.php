@extends('layouts.admin')
@section('title', 'Dashboard')
@section('header', 'Overview Sistem KOST-MANAJEMEN')

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
        --red: #dc2626;
        --amber: #d97706;
        --card-radius: 20px;
    }

    .dash { font-family: 'Roboto', sans-serif; }

    /* ── Section label ── */
    .dash-section-label {
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

    .dash-section-label::before {
        content: '';
        display: block;
        width: 20px; height: 2px;
        background: linear-gradient(90deg, var(--g4), var(--b3));
        border-radius: 2px;
    }

    /* ── Stat cards ── */
    .stat-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 1024px) { .stat-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px)  { .stat-row { grid-template-columns: 1fr; } }

    .stat-card {
        background: white;
        border-radius: var(--card-radius);
        padding: 1.4rem 1.6rem;
        border: 1px solid rgba(22,163,74,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }

    .stat-card-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .icon-blue  { background: rgba(59,130,246,0.1); }
    .icon-green { background: rgba(22,163,74,0.1); }
    .icon-slate { background: rgba(100,116,139,0.1); }
    .icon-teal  { background: rgba(20,184,166,0.1); }

    .stat-card-label {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7a9a7a;
        margin-bottom: 0.35rem;
    }

    .stat-card-value {
        font-family: 'Roboto Slab', serif;
        font-size: 2.2rem;
        font-weight: 700;
        line-height: 1;
        color: var(--g1);
        margin-bottom: 0.3rem;
    }

    .stat-card-sub {
        font-size: 0.75rem;
        color: #9aaa9a;
        font-weight: 400;
    }

    /* ── Finance cards ── */
    .finance-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) { .finance-row { grid-template-columns: 1fr; } }

    .finance-card {
        background: white;
        border-radius: var(--card-radius);
        padding: 1.4rem 1.6rem;
        border: 1px solid rgba(22,163,74,0.1);
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease;
    }

    .finance-card:hover { transform: translateY(-2px); }

    .finance-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
    }

    .finance-income::before  { background: var(--g4); }
    .finance-expense::before { background: var(--red); }
    .finance-profit::before  { background: var(--b3); }
    .finance-loss::before    { background: var(--amber); }

    .finance-card-tag {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 0.6rem;
        color: #7a9a7a;
    }

    .finance-value {
        font-family: 'Roboto Slab', serif;
        font-size: 1.55rem;
        font-weight: 700;
        line-height: 1.1;
        color: var(--g1);
        margin-bottom: 0.3rem;
    }

    .finance-income  .finance-value { color: var(--g3); }
    .finance-expense .finance-value { color: var(--red); }
    .finance-profit  .finance-value { color: var(--b2); }
    .finance-loss    .finance-value { color: var(--amber); }

    .finance-label {
        font-size: 0.78rem;
        color: #9aaa9a;
        font-weight: 400;
    }

    /* ── Main grid ── */
    .main-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 1.25rem;
        align-items: start;
    }

    @media (max-width: 1100px) { .main-grid { grid-template-columns: 1fr; } }

    /* ── Chart card ── */
    .chart-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .chart-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(22,163,74,0.08);
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .chart-title {
        font-family: 'Roboto', sans-serif;
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7a9a7a;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .chart-title::before {
        content: '';
        display: block;
        width: 20px; height: 2px;
        background: linear-gradient(90deg, var(--g4), var(--b3));
        border-radius: 2px;
    }

    .chart-legend {
        display: flex;
        gap: 1rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #7a9a7a;
    }

    .legend-dot {
        width: 8px; height: 8px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    .chart-body {
        padding: 1.25rem 1.5rem 1.5rem;
        height: 280px;
        position: relative;
    }

    /* ── Side panel ── */
    .side-panel {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .alert-card, .upcoming-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    }

    .alert-card-header, .upcoming-card-header {
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid rgba(22,163,74,0.08);
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
    }

    .alert-card-title, .upcoming-card-title {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #7a9a7a;
    }

    .alert-pulse {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--red);
        animation: alertPulse 1.6s ease-in-out infinite;
        flex-shrink: 0;
    }

    @keyframes alertPulse {
        0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(220,38,38,0.3); }
        50%       { opacity: 0.7; box-shadow: 0 0 0 5px rgba(220,38,38,0); }
    }

    .badge {
        font-size: 0.68rem;
        font-weight: 700;
        padding: 0.18rem 0.5rem;
        border-radius: 99px;
        min-width: 22px;
        text-align: center;
    }

    .badge-red    { background: rgba(220,38,38,0.1); color: var(--red); }
    .badge-green  { background: rgba(22,163,74,0.1); color: var(--g3); }
    .badge-amber  { background: rgba(217,119,6,0.1); color: var(--amber); }

    .alert-card-body, .upcoming-card-body { padding: 0.4rem 0; }

    .tenant-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.65rem 1.25rem;
        transition: background 0.15s ease;
    }

    .tenant-row:hover { background: #f8fff8; }

    .tenant-info { display: flex; align-items: center; gap: 8px; }

    .tenant-avatar {
        width: 30px; height: 30px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.7rem;
        font-weight: 900;
        flex-shrink: 0;
    }

    .avatar-red   { background: rgba(220,38,38,0.1); color: var(--red); }
    .avatar-amber { background: rgba(217,119,6,0.1); color: var(--amber); }

    .tenant-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--g1);
        line-height: 1.2;
    }

    .tenant-room {
        font-size: 0.72rem;
        color: #9aaa9a;
        font-weight: 400;
    }

    .tenant-due { text-align: right; }

    .due-date {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--g1);
    }

    .due-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.12rem 0.45rem;
        border-radius: 99px;
        margin-top: 2px;
    }

    .due-overdue { background: rgba(220,38,38,0.1); color: var(--red); }
    .due-urgent  { background: rgba(217,119,6,0.1); color: var(--amber); }
    .due-normal  { background: rgba(22,163,74,0.1); color: var(--g3); }

    .empty-state {
        padding: 1.5rem;
        text-align: center;
        color: #9aaa9a;
        font-size: 0.85rem;
    }

    .empty-icon { font-size: 1.5rem; margin-bottom: 0.35rem; opacity: 0.4; }

    /* ── Animations ── */
    .anim-in {
        opacity: 0;
        transform: translateY(12px);
        animation: dashIn 0.5s ease forwards;
    }

    @keyframes dashIn { to { opacity: 1; transform: translateY(0); } }

    .anim-in:nth-child(1) { animation-delay: 0.05s; }
    .anim-in:nth-child(2) { animation-delay: 0.12s; }
    .anim-in:nth-child(3) { animation-delay: 0.19s; }
    .anim-in:nth-child(4) { animation-delay: 0.26s; }
</style>

<div class="dash">

    {{-- ── Stats ── --}}
    <div class="dash-section-label">Ringkasan Kamar</div>

    <div class="stat-row">
        <div class="stat-card anim-in">
            <div class="stat-card-icon icon-blue">🏠</div>
            <div class="stat-card-label">Total Kamar</div>
            <div class="stat-card-value">{{ $total_rooms }}</div>
            <div class="stat-card-sub">Seluruh unit</div>
        </div>
        <div class="stat-card anim-in">
            <div class="stat-card-icon icon-green">✅</div>
            <div class="stat-card-label">Kamar Terisi</div>
            <div class="stat-card-value">{{ $occupied_rooms }}</div>
            <div class="stat-card-sub">Sedang dihuni</div>
        </div>
        <div class="stat-card anim-in">
            <div class="stat-card-icon icon-slate">🔑</div>
            <div class="stat-card-label">Kamar Kosong</div>
            <div class="stat-card-value">{{ $available_rooms }}</div>
            <div class="stat-card-sub">Siap disewakan</div>
        </div>
        <div class="stat-card anim-in">
            <div class="stat-card-icon icon-teal">👥</div>
            <div class="stat-card-label">Penghuni Aktif</div>
            <div class="stat-card-value">{{ $active_tenants }}</div>
            <div class="stat-card-sub">Kontrak berjalan</div>
        </div>
    </div>

    {{-- ── Finance ── --}}
    <div class="dash-section-label" style="margin-top: 0.5rem;">Keuangan Bulan Ini</div>

    <div class="finance-row">
        <div class="finance-card finance-income anim-in">
            <div class="finance-card-tag">Pemasukan</div>
            <div class="finance-value">Rp {{ number_format($monthly_income, 0, ',', '.') }}</div>
            <div class="finance-label">Total diterima bulan ini</div>
        </div>
        <div class="finance-card finance-expense anim-in">
            <div class="finance-card-tag">Pengeluaran</div>
            <div class="finance-value">Rp {{ number_format($monthly_expense, 0, ',', '.') }}</div>
            <div class="finance-label">Total dikeluarkan bulan ini</div>
        </div>
        <div class="finance-card {{ $net_profit >= 0 ? 'finance-profit' : 'finance-loss' }} anim-in">
            <div class="finance-card-tag">Laba Bersih</div>
            <div class="finance-value">Rp {{ number_format($net_profit, 0, ',', '.') }}</div>
            <div class="finance-label">{{ $net_profit >= 0 ? 'Surplus bulan ini' : 'Defisit bulan ini' }}</div>
        </div>
    </div>

    {{-- ── Chart + Alerts ── --}}
    <div class="dash-section-label" style="margin-top: 0.5rem;">Analitik & Notifikasi</div>

    <div class="main-grid">

        <div class="chart-card anim-in">
            <div class="chart-card-header">
                <span class="chart-title">Tren Keuangan 6 Bulan Terakhir</span>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-dot" style="background: rgba(22,163,74,0.7);"></div>
                        Pemasukan
                    </div>
                    <div class="legend-item">
                        <div class="legend-dot" style="background: rgba(220,38,38,0.7);"></div>
                        Pengeluaran
                    </div>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="dashboardChart"></canvas>
            </div>
        </div>

        <div class="side-panel">

            <div class="alert-card anim-in">
                <div class="alert-card-header">
                    <div class="alert-card-title">
                        @if($overdue_tenants->count() > 0)
                            <div class="alert-pulse"></div>
                        @endif
                        Jatuh Tempo Lewat
                    </div>
                    <span class="badge {{ $overdue_tenants->count() == 0 ? 'badge-green' : 'badge-red' }}">
                        {{ $overdue_tenants->count() }}
                    </span>
                </div>
                <div class="alert-card-body">
                    @if($overdue_tenants->count() > 0)
                        @foreach($overdue_tenants as $tenant)
                        <div class="tenant-row">
                            <div class="tenant-info">
                                <div class="tenant-avatar avatar-red">{{ strtoupper(substr($tenant->name, 0, 2)) }}</div>
                                <div>
                                    <div class="tenant-name">{{ $tenant->name }}</div>
                                    <div class="tenant-room">Kamar {{ $tenant->room->room_number }}</div>
                                </div>
                            </div>
                            <div class="tenant-due">
                                <div class="due-date">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d/m') }}</div>
                                <div class="due-badge due-overdue">{{ abs($tenant->days_until_due) }} hari lalu</div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">🎉</div>
                            Tidak ada yang overdue
                        </div>
                    @endif
                </div>
            </div>

            <div class="upcoming-card anim-in">
                <div class="upcoming-card-header">
                    <div class="upcoming-card-title">
                        Jatuh Tempo 7 Hari Ke Depan
                    </div>
                    <span class="badge badge-amber">{{ $upcoming_due->count() }}</span>
                </div>
                <div class="upcoming-card-body">
                    @if($upcoming_due->count() > 0)
                        @foreach($upcoming_due as $tenant)
                        <div class="tenant-row">
                            <div class="tenant-info">
                                <div class="tenant-avatar avatar-amber">{{ strtoupper(substr($tenant->name, 0, 2)) }}</div>
                                <div>
                                    <div class="tenant-name">{{ $tenant->name }}</div>
                                    <div class="tenant-room">Kamar {{ $tenant->room->room_number }}</div>
                                </div>
                            </div>
                            <div class="tenant-due">
                                <div class="due-date">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d/m') }}</div>
                                <div class="due-badge {{ $tenant->days_until_due <= 3 ? 'due-urgent' : 'due-normal' }}">
                                    Sisa {{ $tenant->days_until_due }} hari
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">✨</div>
                            Tidak ada tagihan terdekat
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('dashboardChart').getContext('2d');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: chartData.income,
                    backgroundColor: 'rgba(22,163,74,0.15)',
                    borderColor: 'rgba(22,163,74,0.75)',
                    borderWidth: 2,
                    borderRadius: 7,
                    borderSkipped: false,
                    barPercentage: 0.55,
                    categoryPercentage: 0.75,
                },
                {
                    label: 'Pengeluaran',
                    data: chartData.expense,
                    backgroundColor: 'rgba(220,38,38,0.1)',
                    borderColor: 'rgba(220,38,38,0.65)',
                    borderWidth: 2,
                    borderRadius: 7,
                    borderSkipped: false,
                    barPercentage: 0.55,
                    categoryPercentage: 0.75,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(10,46,26,0.92)',
                    titleFont: { family: 'Roboto', size: 12, weight: '700' },
                    bodyFont: { family: 'Roboto', size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function(c) {
                            return ' Rp ' + c.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        color: '#9aaa9a',
                        font: { family: 'Roboto', size: 11, weight: '600' }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(22,163,74,0.07)' },
                    border: { display: false },
                    ticks: {
                        color: '#9aaa9a',
                        font: { family: 'Roboto', size: 10 },
                        callback: function(val) {
                            if (val >= 1000000) return 'Rp ' + (val/1000000).toFixed(1) + 'jt';
                            if (val >= 1000) return 'Rp ' + (val/1000) + 'k';
                            return 'Rp ' + val;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
