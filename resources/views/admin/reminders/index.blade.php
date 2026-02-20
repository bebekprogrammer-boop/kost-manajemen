@extends('layouts.admin')
@section('title', 'Reminder WhatsApp')
@section('header', 'Pengingat Jatuh Tempo (WhatsApp)')

@section('content')
<div class="mb-4">
    <p class="text-gray-600">Sistem ini menggunakan link redirect <code class="px-1 bg-gray-200 rounded">wa.me</code> gratis. Klik tombol kirim untuk membuka chat WhatsApp dengan pesan otomatis.</p>
</div>

<div class="space-y-8">
    @php
        $sections = [
            ['key' => 'h7', 'title' => 'H-7 (Kurang 7 Hari)', 'color' => 'blue'],
            ['key' => 'h3', 'title' => 'H-3 (Kurang 3 Hari)', 'color' => 'yellow'],
            ['key' => 'h0', 'title' => 'H-0 (Jatuh Tempo Hari Ini)', 'color' => 'orange'],
            ['key' => 'overdue', 'title' => 'Overdue (Sudah Lewat Jatuh Tempo)', 'color' => 'red'],
        ];
    @endphp

    @foreach($sections as $section)
        @php
            $data = $reminders[$section['key']];
            $color = $section['color'];
            $borderColor = "border-{$color}-500";
            $bgColor = "bg-{$color}-100";
            $textColor = "text-{$color}-800";
            $btnColor = "bg-{$color}-600 hover:bg-{$color}-700";

            // Fix Tailwind dynamic classes issue by explicitly mapping
            if($color == 'orange') {
                $borderColor = "border-orange-500"; $bgColor = "bg-orange-100"; $textColor = "text-orange-800"; $btnColor = "bg-orange-600 hover:bg-orange-700";
            } elseif ($color == 'blue') {
                $borderColor = "border-blue-500"; $bgColor = "bg-blue-100"; $textColor = "text-blue-800"; $btnColor = "bg-blue-600 hover:bg-blue-700";
            } elseif ($color == 'yellow') {
                $borderColor = "border-yellow-500"; $bgColor = "bg-yellow-100"; $textColor = "text-yellow-800"; $btnColor = "bg-yellow-600 hover:bg-yellow-700";
            } elseif ($color == 'red') {
                $borderColor = "border-red-500"; $bgColor = "bg-red-100"; $textColor = "text-red-800"; $btnColor = "bg-red-600 hover:bg-red-700";
            }
        @endphp

        <div class="bg-white rounded shadow border-t-4 {{ $borderColor }}">
            <div class="p-4 border-b flex justify-between items-center {{ $bgColor }}">
                <h3 class="text-lg font-bold {{ $textColor }}">{{ $section['title'] }}</h3>
                <span class="px-3 py-1 text-sm font-bold bg-white border rounded-full">{{ $data->count() }} Orang</span>
            </div>

            <div class="p-6">
                @if($data->count() > 0)
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($data as $tenant)
                            @php
                                $alreadySent = $reminderService->alreadySentToday($tenant, $section['key']);
                                $waUrl = $reminderService->buildWhatsAppUrl($tenant, $section['key']);
                                $payment = $tenant->payments->where('status', 'unpaid')->first();
                                $amount = $payment ? $payment->amount : 0;

                                if($section['key'] == 'overdue') {
                                    $daysLate = max(0, now()->diffInDays($tenant->due_date, false) * -1);
                                    $penalty = $daysLate * config('app.penalty_per_day', 5000);
                                    $amount += $penalty;
                                }
                            @endphp

                            <div class="relative p-4 border rounded">
                                @if($alreadySent)
                                    <span class="absolute px-2 py-1 text-xs text-green-700 bg-green-100 border border-green-300 rounded top-2 right-2">✓ Sudah Dikirim Hari Ini</span>
                                @endif

                                <h4 class="text-lg font-bold">{{ $tenant->name }}</h4>
                                <p class="mb-2 text-sm text-gray-600">Kamar: {{ $tenant->room->room_number }}</p>
                                <p class="text-sm">Due Date: <span class="font-semibold">{{ \Carbon\Carbon::parse($tenant->due_date)->format('d M Y') }}</span></p>
                                <p class="mb-4 text-sm">Tagihan: <span class="font-bold text-red-600">Rp {{ number_format($amount, 0, ',', '.') }}</span></p>

                                <button type="button"
                                        onclick="sendReminder({{ $tenant->id }}, '{{ $section['key'] }}', '{{ $waUrl }}', this)"
                                        class="w-full text-white px-4 py-2 rounded text-sm transition font-semibold {{ $alreadySent ? 'bg-gray-400 cursor-not-allowed' : $btnColor }}"
                                        {{ $alreadySent ? 'disabled' : '' }}>
                                    {{ $alreadySent ? 'Terkirim' : 'Kirim via WhatsApp' }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="py-4 text-center text-gray-500">Tidak ada penghuni dalam kategori ini.</p>
                @endif
            </div>
        </div>
    @endforeach
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    function sendReminder(tenantId, type, waUrl, btnElement) {
        // 1. Buka tab WA
        window.open(waUrl, '_blank');

        // 2. Ubah UI tombol menjadi loading/terkirim
        btnElement.disabled = true;
        btnElement.innerText = 'Mencatat Log...';
        btnElement.classList.remove('bg-blue-600', 'bg-yellow-600', 'bg-orange-600', 'bg-red-600', 'hover:bg-blue-700', 'hover:bg-yellow-700', 'hover:bg-orange-700', 'hover:bg-red-700');
        btnElement.classList.add('bg-gray-400');

        // 3. Kirim AJAX ke server untuk mencatat log
        fetch('{{ route('admin.reminders.log') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                tenant_id: tenantId,
                type: type
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                btnElement.innerText = 'Terkirim';
                // Opsional: Reload halaman setelah beberapa detik untuk memunculkan badge hijau
                setTimeout(() => window.location.reload(), 1500);
            }
        })
        .catch(error => {
            console.error('Error logging reminder:', error);
            btnElement.innerText = 'Gagal Mencatat Log';
        });
    }
</script>
@endsection
