<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-blue-900 text-white flex flex-col justify-between">
        <div>
            <div class="p-4 text-2xl font-bold border-b border-blue-800">
                KOST-MANAJEMEN
            </div>
            <nav class="mt-4 flex flex-col space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : '' }}">Dashboard</a>
                <a href="{{ route('admin.rooms.index') }}"
                    class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.rooms.*') ? 'bg-blue-700' : '' }}">
                        Kamar
                </a>

                <a href="{{ route('admin.tenants.index') }}" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.tenants.*') ? 'bg-blue-700' : '' }}">Penghuni</a>
                <a href="{{ route('admin.payments.index') }}" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.payments.*') ? 'bg-blue-700' : '' }}">Pembayaran</a>
                <a href="#" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.expenses.*') ? 'bg-blue-700' : '' }}">Pengeluaran</a>
                <a href="#" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.reminders.*') ? 'bg-blue-700' : '' }}">Reminder WA</a>
                <a href="#" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.reports.*') ? 'bg-blue-700' : '' }}">Laporan</a>

                @if(auth()->user()->role === 'super_admin')
                <a href="#" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-blue-700' : '' }}">Log Aktivitas</a>
                @endif

                <a href="#" class="px-4 py-3 hover:bg-blue-800 {{ request()->routeIs('admin.settings.*') ? 'bg-blue-700' : '' }}">Pengaturan</a>
            </nav>
        </div>

        <div class="p-4 border-t border-blue-800">
            <div class="mb-2">
                <p class="font-semibold truncate">{{ auth()->user()->name }}</p>
                <span class="text-xs bg-blue-700 px-2 py-1 rounded">{{ strtoupper(auth()->user()->role) }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left text-sm text-red-300 hover:text-red-100">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">@yield('header')</h2>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
