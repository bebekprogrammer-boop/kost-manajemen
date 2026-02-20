<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan - {{ $month }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #000; padding: 5px; text-align: left; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .bg-gray { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ env('KOST_NAME', 'Sistem Manajemen Kost') }}</h2>
        <h3>Laporan Keuangan: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</h3>
    </div>

    <h4 style="color: green;">Rincian Pemasukan (Sewa & Denda)</h4>
    <table class="table">
        <tr class="bg-gray">
            <th>Tanggal</th>
            <th>Kamar</th>
            <th>Penghuni</th>
            <th class="text-right">Nominal</th>
        </tr>
        @forelse($payments as $p)
        <tr>
            <td>{{ \Carbon\Carbon::parse($p->payment_date)->format('d/m/Y') }}</td>
            <td>{{ $p->room->room_number }}</td>
            <td>{{ $p->tenant->name }}</td>
            <td class="text-right">Rp {{ number_format($p->total_amount, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align: center;">Tidak ada pemasukan.</td></tr>
        @endforelse
        <tr>
            <td colspan="3" class="text-right bold">TOTAL PEMASUKAN</td>
            <td class="text-right bold">Rp {{ number_format($income, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h4 style="color: red;">Rincian Pengeluaran (Operasional)</h4>
    <table class="table">
        <tr class="bg-gray">
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Keterangan</th>
            <th class="text-right">Nominal</th>
        </tr>
        @forelse($expenses as $e)
        <tr>
            <td>{{ \Carbon\Carbon::parse($e->expense_date)->format('d/m/Y') }}</td>
            <td>{{ $e->category }}</td>
            <td>{{ $e->description ?? '-' }}</td>
            <td class="text-right">Rp {{ number_format($e->amount, 0, ',', '.') }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align: center;">Tidak ada pengeluaran.</td></tr>
        @endforelse
        <tr>
            <td colspan="3" class="text-right bold">TOTAL PENGELUARAN</td>
            <td class="text-right bold">Rp {{ number_format($expense, 0, ',', '.') }}</td>
        </tr>
    </table>

    <h3 class="text-right">Laba Bersih: <span style="color: {{ $netProfit >= 0 ? 'blue' : 'red' }}">Rp {{ number_format($netProfit, 0, ',', '.') }}</span></h3>
</body>
</html>
