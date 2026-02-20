@extends('layouts.admin')
@section('title', 'Dashboard')
@section('header', 'Overview Sistem KOST-MANAJEMEN')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded shadow p-5 border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase mb-1">Total Kamar</h3>
        <p class="text-3xl font-bold text-blue-700">{{ $total_rooms }}</p>
    </div>
    <div class="bg-white rounded shadow p-5 border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase mb-1">Kamar Terisi</h3>
        <p class="text-3xl font-bold text-green-700">{{ $occupied_rooms }}</p>
    </div>
    <div class="bg-white rounded shadow p-5 border-l-4 border-gray-400">
        <h3 class="text-gray-500 text-sm font-bold uppercase mb-1">Kamar Kosong</h3>
        <p class="text-3xl font-bold text-gray-700">{{ $available_rooms }}</p>
    </div>
    <div class="bg-white rounded shadow p-5 border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-bold uppercase mb-1">Penghuni Aktif</h3>
        <p class="text-3xl font-bold text-purple-700">{{ $active_tenants }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-green-50 rounded shadow p-5 border border-green-200">
        <h3 class="text-green-800 text-sm font-bold uppercase mb-1">Pemasukan Bulan Ini</h3>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($monthly_income, 0, ',', '.') }}</p>
    </div>
    <div class="bg-red-50 rounded shadow p-5 border border-red-200">
        <h3 class="text-red-800 text-sm font-bold uppercase mb-1">Pengeluaran Bulan Ini</h3>
        <p class="text-2xl font-bold text-red-600">Rp {{ number_format($monthly_expense, 0, ',', '.') }}</p>
    </div>
    <div class="bg-blue-50 rounded shadow p-5 border border-blue-200">
        <h3 class="text-blue-800 text-sm font-bold uppercase mb-1">Laba Bersih Bulan Ini</h3>
        <p class="text-2xl font-bold {{ $net_profit >= 0 ? 'text-blue-600' : 'text-yellow-600' }}">
            Rp {{ number_format($net_profit, 0, ',', '.') }}
        </p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="lg:col-span-2 bg-white rounded shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Grafik Pemasukan vs Pengeluaran (6 Bulan)</h3>
        <div class="relative h-72 w-full">
            <canvas id="dashboardChart"></canvas>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded shadow p-5 border-t-4 border-red-500">
            <h3 class="text-md font-bold text-red-700 border-b pb-2 mb-3 flex justify-between">
                <span>⚠️ Overdue!</span>
                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">{{ $overdue_tenants->count() }}</span>
            </h3>
            @if($overdue_tenants->count() > 0)
                <ul class="divide-y text-sm">
                    @foreach($overdue_tenants as $tenant)
                    <li class="py-2 flex justify-between items-center">
                        <div>
                            <p class="font-bold">{{ $tenant->name }}</p>
                            <p class="text-xs text-gray-500">Kamar {{ $tenant->room->room_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-red-600 font-bold">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d/m') }}</p>
                            <p class="text-xs bg-red-100 text-red-700 px-1 rounded">-{{ $tenant->days_until_due * -1 }} hari</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500 text-center py-2">Tidak ada yang overdue.</p>
            @endif
        </div>

        <div class="bg-white rounded shadow p-5 border-t-4 border-yellow-500">
            <h3 class="text-md font-bold text-yellow-700 border-b pb-2 mb-3">Jatuh Tempo (7 Hari Kedepan)</h3>
            @if($upcoming_due->count() > 0)
                <ul class="divide-y text-sm">
                    @foreach($upcoming_due as $tenant)
                    <li class="py-2 flex justify-between items-center">
                        <div>
                            <p class="font-bold">{{ $tenant->name }}</p>
                            <p class="text-xs text-gray-500">Kamar {{ $tenant->room->room_number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-800 font-bold">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d/m') }}</p>
                            <p class="text-xs {{ $tenant->days_until_due <= 3 ? 'text-red-500 font-bold' : 'text-yellow-600' }}">Sisa {{ $tenant->days_until_due }} hari</p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500 text-center py-2">Tidak ada tagihan terdekat.</p>
            @endif
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
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        borderRadius: 4
                    },
                    {
                        label: 'Pengeluaran',
                        data: chartData.expense,
                        backgroundColor: 'rgba(239, 68, 68, 0.8)',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value/1000) + 'k';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
