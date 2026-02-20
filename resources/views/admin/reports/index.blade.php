@extends('layouts.admin')
@section('title', 'Laporan Keuangan')
@section('header', 'Laporan Keuangan Kost')

@section('content')
<div class="flex items-center justify-between p-4 mb-6 bg-white rounded shadow">
    <form action="{{ route('admin.reports.index') }}" method="GET" class="flex items-end space-x-2">
        <div>
            <label class="block mb-1 text-sm font-semibold text-gray-700">Pilih Bulan Laporan</label>
            <input type="month" name="month" value="{{ $month }}" class="border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="submit" class="px-4 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-700">Tampilkan</button>
    </form>
    <button type="submit" class="px-4 py-2 text-white transition bg-blue-600 rounded hover:bg-blue-700">Tampilkan</button>
    </form>

    <div class="flex space-x-2">
        <a href="{{ route('admin.reports.csv', ['month' => $month]) }}" class="px-4 py-2 text-white transition bg-green-600 rounded hover:bg-green-700">📊 Download CSV</a>
        <a href="{{ route('admin.reports.pdf', ['month' => $month]) }}" class="px-4 py-2 text-white transition bg-red-600 rounded hover:bg-red-700">📄 Download PDF</a>
        <button onclick="window.print()" class="px-4 py-2 text-white transition bg-gray-800 rounded hover:bg-gray-900 print:hidden">🖨️ Cetak</button>
    </div>

</div>

<div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
    <div class="p-6 bg-white border-l-4 border-green-500 rounded shadow">
        <h3 class="mb-1 text-sm font-bold text-gray-500 uppercase">Total Pendapatan</h3>
        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($income, 0, ',', '.') }}</p>
        <p class="mt-2 text-xs text-gray-400">Dari tagihan sewa lunas & denda</p>
    </div>

    <div class="p-6 bg-white border-l-4 border-red-500 rounded shadow">
        <h3 class="mb-1 text-sm font-bold text-gray-500 uppercase">Total Pengeluaran</h3>
        <p class="text-3xl font-bold text-red-600">Rp {{ number_format($expense, 0, ',', '.') }}</p>
        <p class="mt-2 text-xs text-gray-400">Operasional bulanan</p>
    </div>

    <div class="bg-white rounded shadow p-6 border-l-4 {{ $netProfit >= 0 ? 'border-blue-500' : 'border-yellow-500' }}">
        <h3 class="mb-1 text-sm font-bold text-gray-500 uppercase">Laba Bersih</h3>
        <p class="text-3xl font-bold {{ $netProfit >= 0 ? 'text-blue-600' : 'text-yellow-600' }}">
            Rp {{ number_format($netProfit, 0, ',', '.') }}
        </p>
        <p class="mt-2 text-xs text-gray-400">Pendapatan dikurangi pengeluaran</p>
    </div>
</div>

<div class="p-6 bg-white rounded shadow print:hidden">
    <h3 class="pb-2 mb-4 text-lg font-bold text-gray-800 border-b">Grafik Tren Keuangan (6 Bulan Terakhir)</h3>
    <div class="relative w-full h-80">
        <canvas id="financeChart"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                        backgroundColor: 'rgba(34, 197, 94, 0.7)', // Green
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1
                    },
                    {
                        label: 'Pengeluaran (Rp)',
                        data: chartData.expense,
                        backgroundColor: 'rgba(239, 68, 68, 0.7)', // Red
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    /* Menyembunyikan elemen tertentu saat mode print (Ctrl+P) */
    @media print {
        aside, header, form, .print\:hidden { display: none !important; }
        main { padding: 0 !important; background: white !important; }
        .shadow { box-shadow: none !important; border: 1px solid #ddd; }
    }
</style>
@endsection
