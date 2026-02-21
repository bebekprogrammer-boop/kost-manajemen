@extends('layouts.admin')
@section('title', 'Laporan Keuangan')
@section('header', 'Laporan Keuangan Kost')

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

    .reports-page { font-family: 'Roboto', sans-serif; }

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

    /* ── Export buttons ── */
    .export-group {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-left: auto;
    }

    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 0.62rem 1rem;
        font-size: 0.78rem;
        font-weight: 700;
        font-family: 'Roboto', sans-serif;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: opacity 0.2s, transform 0.15s;
        letter-spacing: 0.03em;
    }

    .btn-export:hover { opacity: 0.88; transform: translateY(-1px); }

    .btn-csv   { background: linear-gradient(135deg, var(--g3), var(--g4)); color: white; }
    .btn-pdf   { background: linear-gradient(135deg, var(--red), #b91c1c); color: white; }
    .btn-print { background: linear-gradient(135deg, #374151, #1f2937); color: white; }

    /* ── Summary cards ── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .summary-grid { grid-template-columns: 1fr; }
        .export-group { margin-left: 0; width: 100%; flex-wrap: wrap; }
        .filter-bar { flex-direction: column; align-items: stretch; }
    }

    .summary-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        padding: 1.5rem 1.75rem;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 4px; height: 100%;
        border-radius: 4px 0 0 4px;
    }

    .summary-card.income::before  { background: linear-gradient(180deg, var(--g4), var(--g3)); }
    .summary-card.expense::before { background: linear-gradient(180deg, var(--red), #b91c1c); }
    .summary-card.profit::before  { background: linear-gradient(180deg, var(--b3), var(--b2)); }
    .summary-card.loss::before    { background: linear-gradient(180deg, var(--yellow), #b45309); }

    .summary-card .card-icon {
        width: 40px; height: 40px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .summary-card.income  .card-icon { background: rgba(22,163,74,0.1); }
    .summary-card.expense .card-icon { background: rgba(220,38,38,0.1); }
    .summary-card.profit  .card-icon { background: rgba(29,78,216,0.1); }
    .summary-card.loss    .card-icon { background: rgba(217,119,6,0.1); }

    .summary-card .card-label {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7a9a7a;
        margin-bottom: 0.4rem;
    }

    .summary-card .card-value {
        font-family: 'Roboto Slab', serif;
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 0.5rem;
    }

    .summary-card.income  .card-value { color: var(--g3); }
    .summary-card.expense .card-value { color: var(--red); }
    .summary-card.profit  .card-value { color: var(--b2); }
    .summary-card.loss    .card-value { color: var(--yellow); }

    .summary-card .card-sub {
        font-size: 0.75rem;
        color: #9aaa9a;
        font-weight: 400;
    }

    /* ── Chart card ── */
    .chart-card {
        background: white;
        border-radius: var(--card-radius);
        border: 1px solid rgba(22,163,74,0.1);
        box-shadow: 0 2px 12px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .chart-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(22,163,74,0.08);
        background: linear-gradient(135deg, #f0fdf4, #eff6ff);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-header-title {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #7a9a7a;
    }

    .chart-header-title::before {
        content: '';
        display: inline-block;
        width: 20px; height: 2px;
        background: linear-gradient(90deg, var(--g4), var(--b3));
        border-radius: 2px;
        vertical-align: middle;
        margin-right: 6px;
    }

    .chart-body {
        padding: 1.5rem;
    }

    .chart-wrap {
        position: relative;
        width: 100%;
        height: 320px;
    }

    /* ── Entry animation ── */
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

    /* ── Print ── */
    @media print {
        aside, header, .print-hidden { display: none !important; }
        main { padding: 0 !important; background: white !important; }
        .chart-card { display: none !important; }
        .summary-card { box-shadow: none !important; border: 1px solid #ddd; }
    }
</style>

<div class="reports-page">

    <div class="section-label">Laporan Keuangan</div>

    {{-- ── Filter + Export Bar ── --}}
    <form action="{{ route('admin.reports.index') }}" method="GET" class="filter-bar anim-in print-hidden">
        <div class="filter-group">
            <span class="filter-label">Pilih Bulan Laporan</span>
            <input type="month" name="month" value="{{ $month }}" class="filter-input">
        </div>
        <button type="submit" class="btn-filter">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Tampilkan
        </button>

        <div class="export-group">
            <a href="{{ route('admin.reports.csv', ['month' => $month]) }}" class="btn-export btn-csv">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                CSV
            </a>
            <a href="{{ route('admin.reports.pdf', ['month' => $month]) }}" class="btn-export btn-pdf">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                PDF
            </a>
            <button type="button" onclick="window.print()" class="btn-export btn-print">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak
            </button>
        </div>
    </form>

    {{-- ── Summary Cards ── --}}
    <div class="summary-grid anim-in">

        {{-- Income --}}
        <div class="summary-card income">
            <div class="card-icon">💰</div>
            <div class="card-label">Total Pendapatan</div>
            <div class="card-value">Rp {{ number_format($income, 0, ',', '.') }}</div>
            <div class="card-sub">Dari tagihan sewa lunas &amp; denda</div>
        </div>

        {{-- Expense --}}
        <div class="summary-card expense">
            <div class="card-icon">💸</div>
            <div class="card-label">Total Pengeluaran</div>
            <div class="card-value">Rp {{ number_format($expense, 0, ',', '.') }}</div>
            <div class="card-sub">Operasional bulanan</div>
        </div>

        {{-- Net profit --}}
        <div class="summary-card {{ $netProfit >= 0 ? 'profit' : 'loss' }}">
            <div class="card-icon">{{ $netProfit >= 0 ? '📈' : '📉' }}</div>
            <div class="card-label">Laba Bersih</div>
            <div class="card-value">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
            <div class="card-sub">Pendapatan dikurangi pengeluaran</div>
        </div>

    </div>

    {{-- ── Chart ── --}}
    <div class="chart-card anim-in print-hidden">
        <div class="chart-header">
            <span class="chart-header-title">Grafik Tren Keuangan (6 Bulan Terakhir)</span>
        </div>
        <div class="chart-body">
            <div class="chart-wrap">
                <canvas id="financeChart"></canvas>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('financeChart').getContext('2d');
        const chartData = @json($chartData);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        data: chartData.income,
                        backgroundColor: 'rgba(22,163,74,0.15)',
                        borderColor: 'rgba(22,163,74,0.8)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    },
                    {
                        label: 'Pengeluaran (Rp)',
                        data: chartData.expense,
                        backgroundColor: 'rgba(220,38,38,0.12)',
                        borderColor: 'rgba(220,38,38,0.7)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            font: { family: 'Roboto', size: 12, weight: '600' },
                            color: '#0a2e1a',
                            usePointStyle: true,
                            pointStyleWidth: 8,
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(10,46,26,0.92)',
                        titleFont: { family: 'Roboto', size: 12, weight: '700' },
                        bodyFont: { family: 'Roboto', size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function (context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null)
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Roboto', size: 11, weight: '600' },
                            color: '#7a9a7a',
                        },
                        border: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(22,163,74,0.07)',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: 'Roboto', size: 11 },
                            color: '#7a9a7a',
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>

@endsection
