<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - JemuranKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen bg-[#f8fafa]">

    <aside class="w-56 bg-primary-light border-r border-gray-200 flex flex-col py-6 shrink-0 h-screen sticky top-0">
        <div class="px-6 pb-6 mb-6 border-b border-gray-300/80">
            <div class="flex items-center gap-2.5 mb-1.5">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white text-sm shadow-sm">🌿</div>
                <span class="font-serif text-xl font-bold text-primary tracking-tight">JemuranKu</span>
            </div>
            <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest pl-10">Admin Panel</div>
        </div>

        <nav class="flex-1 px-3 flex flex-col gap-1">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-500 font-medium hover:bg-white hover:text-gray-900' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-colors">
                <span>🏠</span> Dashboard
            </a>

            <a href="{{ route('admin.booking') }}" class="{{ request()->routeIs('admin.booking') ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-500 font-medium hover:bg-white hover:text-gray-900' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-colors">
                <span>📅</span> Manajemen Booking
            </a>

            <a href="{{ route('admin.rak.index') }}" class="{{ request()->routeIs('admin.rak.*') ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-500 font-medium hover:bg-white hover:text-gray-900' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-colors">
                <span>🧺</span> Kelola Rak Jemuran
            </a>

            <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan*') ? 'bg-primary text-white font-semibold shadow-sm' : 'text-gray-500 font-medium hover:bg-white hover:text-gray-900' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-colors">
                <span>📊</span> Laporan Transaksi
            </a>
        </nav>

        <div class="mt-auto px-6 pt-5 border-t border-gray-300/80">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 text-gray-500 font-medium hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors text-[13px] w-full">
                    <span>🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-8 md:p-10 overflow-y-auto">
        @yield('content')
    </main>

</body>
</html>
