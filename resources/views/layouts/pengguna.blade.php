<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JemuranKu - Layanan Exclusive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-56 bg-primary-light border-r border-gray-200 flex flex-col py-6 shrink-0 h-screen sticky top-0">
        <!-- Brand -->
        <div class="px-6 pb-6 mb-6 border-b border-gray-300/80">
            <div class="flex items-center gap-2.5 mb-1.5">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white text-sm shadow-sm">🌿</div>
                <span class="font-serif text-xl font-bold text-primary tracking-tight">JemuranKu</span>
            </div>
            <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest pl-10">Layanan Exclusive</div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-3 flex flex-col gap-1">
            <a href="{{ url('/pengguna/dashboard') }}" class="{{ request()->is('pengguna/dashboard*') || request()->is('pengguna/katalog*') ? 'bg-primary-light text-primary font-semibold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-colors">
                <span>🧺</span> Katalog Jemuran
            </a>
            <a href="{{ route('pengguna.riwayat') }}" class="{{ request()->routeIs('pengguna.riwayat') ? 'bg-primary-light text-primary font-semibold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-colors">
                <span>🗂️</span> Riwayat Booking
            </a>
            <a href="{{ route('pengguna.panduan') }}" class="{{ request()->routeIs('pengguna.panduan') ? 'bg-primary-light text-primary font-semibold' : 'text-gray-500 font-medium hover:bg-gray-50 hover:text-gray-900' }} flex items-center gap-3 px-3 py-2.5 rounded-lg text-[13px] transition-colors">
                <span>📚</span> Panduan Reservasi
            </a>
        </nav>

        <!-- Footer / Logout -->
        <div class="mt-auto px-6 pt-5 border-t border-gray-300/80">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2.5 text-gray-500 font-medium hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors text-[13px] w-full">
                    <span>🚪</span> Keluar Akun
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 md:p-10 overflow-y-auto">
        @yield('content')
    </main>

</body>
</html>