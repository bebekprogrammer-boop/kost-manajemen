<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $payment->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; color: #1e3a8a; }
        .header p { margin: 5px 0; font-size: 14px; color: #555; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table th, .details-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .details-table th { background-color: #f3f4f6; font-weight: bold; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; font-size: 16px; background-color: #e5e7eb; }
        .signature-container { width: 100%; margin-top: 40px; }
        .signature { float: right; width: 200px; text-align: center; }
        .signature-line { border-top: 1px solid #333; margin-top: 60px; padding-top: 5px; font-weight: bold; }
        .clearfix::after { content: ""; clear: both; display: table; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ env('KOST_NAME', config('app.name')) }}</h1>
        <p>{{ env('KOST_ADDRESS', 'Alamat Kost Belum Diatur') }} | WA: {{ env('ADMIN_PHONE', '-') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="50%">
                <strong>DITAGIHKAN KEPADA:</strong><br>
                Nama: {{ $payment->tenant->name }}<br>
                Kamar: {{ $payment->room->room_number }} ({{ strtoupper($payment->room->type) }})<br>
                No. HP: {{ $payment->tenant->phone }}
            </td>
            <td width="50%" class="text-right">
                <strong>INFORMASI INVOICE:</strong><br>
                No. Invoice: <strong>{{ $payment->invoice_number }}</strong><br>
                Tgl Cetak: {{ now()->format('d M Y') }}<br>
                Tgl Bayar: {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') : '-' }}<br>
                Status: <span style="color: green; font-weight:bold;">LUNAS</span>
            </td>
        </tr>
    </table>

    <table class="details-table">
        <thead>
            <tr>
                <th>Deskripsi Tagihan</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Sewa Kamar <br>
                    <span style="font-size: 12px; color: #666;">Periode: {{ \Carbon\Carbon::parse($payment->period_start)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($payment->period_end)->format('d/m/Y') }}</span>
                </td>
                <td class="text-right">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
            @if($payment->penalty > 0)
            <tr>
                <td style="color: red;">Denda Keterlambatan</td>
                <td class="text-right" style="color: red;">Rp {{ number_format($payment->penalty, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td class="text-right">TOTAL DIBAYAR</td>
                <td class="text-right">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="clearfix signature-container">
        <div class="signature">
            <p>Pengelola / Admin,</p>
            <div class="signature-line">
                {{ $payment->paidBy->name ?? 'Admin' }}
            </div>
        </div>
    </div>

    <div class="footer">
        Terima kasih atas pembayaran Anda. Harap simpan invoice ini sebagai bukti pembayaran yang sah.
    </div>

</body>
</html>
