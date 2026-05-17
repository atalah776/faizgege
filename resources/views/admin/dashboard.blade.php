@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.4s_ease_both] pb-10">

    <div class="bg-gradient-to-r from-[#0d5c4a] via-[#107c65] to-[#126b54] rounded-2xl p-8 mb-8 relative overflow-hidden shadow-lg border border-[#0d5c4a]/20">
        <div class="absolute -right-10 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-32 -bottom-20 w-40 h-40 bg-[#4ade80]/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-20 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-white text-[10px] font-bold uppercase tracking-widest mb-4 border border-white/20 backdrop-blur-sm shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399] animate-pulse"></span>
                    Sistem Manajemen Aktif
                </div>
                <h1 class="font-serif text-3xl md:text-4xl font-bold text-white mb-2 tracking-wide" id="greetingText">Selamat Datang, Admin</h1>
                <p class="text-[14px] text-emerald-50 max-w-xl leading-relaxed">
                    Pantau seluruh aktivitas reservasi, kapasitas rak jemuran, dan operasional fasilitas secara <span class="font-semibold text-white">real-time</span>.
                </p>
            </div>
            <div class="flex flex-col items-start md:items-end text-white">
                <div class="text-[12px] font-bold text-emerald-100 uppercase tracking-widest mb-1">Waktu Server (WIB)</div>
                <div id="realtimeClock" class="font-mono text-3xl md:text-4xl font-black tracking-tight drop-shadow-md">00:00:00</div>
                <div id="realtimeDate" class="text-[13px] font-medium text-emerald-100 mt-1">Senin, 1 Januari 2024</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        <div class="bg-white border border-gray-100 rounded-xl p-6 flex flex-col gap-3 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded border border-emerald-100">+100% Active</span>
            </div>
            <div>
                <div class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-1">Total Rak Terdaftar</div>
                <div class="text-3xl font-black text-gray-800 mt-1">{{ $totalRak }} <span class="text-sm font-semibold text-gray-400">Unit</span></div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-6 flex flex-col gap-3 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded border border-amber-100">Need Action</span>
            </div>
            <div>
                <div class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-1">Pesanan (Menunggu/Aktif)</div>
                <div class="text-3xl font-black text-gray-800 mt-1">{{ $bookingAktif }} <span class="text-sm font-semibold text-gray-400">Trx</span></div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-6 flex flex-col gap-3 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-sky-50 text-sky-500 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-sky-600 bg-sky-50 px-2 py-1 rounded border border-sky-100">Rata-rata</span>
            </div>
            <div>
                <div class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mt-1">Siklus Penjemuran</div>
                <div class="text-3xl font-black text-gray-800 mt-1">2 <span class="text-sm font-semibold text-gray-400">Hari / Rak</span></div>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-xl p-6 flex flex-col gap-3 shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded border border-gray-200">Estimasi Beban</span>
            </div>
            <div class="w-full mt-1">
                <div class="flex justify-between items-end mb-2">
                    <div class="text-[11px] text-gray-400 font-bold uppercase tracking-widest">Kapasitas Rak</div>
                    <div class="text-xl font-black text-gray-800">82%</div>
                </div>
                <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-rose-400 to-rose-500 rounded-full relative" style="width: 82%">
                        <div class="absolute inset-0 bg-white/20 w-full animate-[shimmer_2s_infinite]"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 flex flex-col gap-6">
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm flex-1">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-[16px] font-bold text-gray-900">Reservasi Terbaru Masuk</h3>
                        <p class="text-[11px] text-gray-400 font-medium mt-0.5">5 antrian pemesanan terakhir dari pelanggan.</p>
                    </div>
                    <a href="{{ route('admin.booking') }}" class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-[11px] font-bold rounded-lg transition-colors border border-gray-200">
                        Lihat Semua →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100">
                                <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 uppercase tracking-wider">ID & Waktu</th>
                                <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                                <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Fasilitas Rak</th>
                                <th class="py-3.5 px-6 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentBookings as $booking)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="py-4 px-6">
                                        <div class="text-[13px] font-mono font-bold text-[#0d5c4a]">#JMR-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        <div class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ \Carbon\Carbon::parse($booking->created_at)->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-100 to-emerald-200 text-emerald-700 flex items-center justify-center text-[12px] font-black border border-emerald-300 shadow-sm">
                                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-[13px] font-bold text-gray-800 group-hover:text-primary transition-colors">{{ $booking->user->name }}</div>
                                                <div class="text-[10px] text-gray-400 font-medium">Member Aktif</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-gray-100 border border-gray-200 rounded text-[12px] font-bold text-gray-700">
                                            <span>🧺</span> {{ $booking->spot->kode_jemuran }}
                                        </div>
                                        <div class="text-[10px] text-gray-400 mt-1.5">
                                            <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d M') }}</span> - <span class="font-semibold">{{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('d M') }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($booking->status_booking === 'menunggu')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Menunggu
                                            </span>
                                        @elseif($booking->status_booking === 'aktif')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                            </span>
                                        @elseif($booking->status_booking === 'selesai')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-full text-[10px] font-bold uppercase tracking-wider">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Batal
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">📭</div>
                                        <p class="text-[13px] text-gray-500 font-medium">Belum ada reservasi terbaru yang masuk.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 flex flex-col gap-6">

            <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                <h3 class="text-[13px] font-bold text-gray-400 uppercase tracking-widest mb-4">Akses Cepat</h3>
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.booking') }}" class="w-full flex items-center justify-between p-3.5 border border-gray-200 rounded-xl hover:border-primary hover:bg-emerald-50 group transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <span class="text-[13px] font-bold text-gray-800 group-hover:text-primary">Input Reservasi Baru</span>
                        </div>
                        <span class="text-gray-300 group-hover:text-primary">→</span>
                    </a>

                    <a href="{{ route('admin.rak.index') }}" class="w-full flex items-center justify-between p-3.5 border border-gray-200 rounded-xl hover:border-primary hover:bg-emerald-50 group transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"></path></svg>
                            </div>
                            <span class="text-[13px] font-bold text-gray-800 group-hover:text-primary">Kelola Master Rak</span>
                        </div>
                        <span class="text-gray-300 group-hover:text-primary">→</span>
                    </a>

                    <a href="{{ route('admin.laporan') }}" class="w-full flex items-center justify-between p-3.5 border border-gray-200 rounded-xl hover:border-primary hover:bg-emerald-50 group transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <span class="text-[13px] font-bold text-gray-800 group-hover:text-primary">Download Laporan Excel</span>
                        </div>
                        <span class="text-gray-300 group-hover:text-primary">→</span>
                    </a>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 text-8xl opacity-5">⚙️</div>
                <h3 class="text-[13px] font-bold text-gray-400 uppercase tracking-widest mb-4">Status Server</h3>
                <div class="space-y-4 relative z-10">
                    <div>
                        <div class="flex justify-between text-[11px] mb-1">
                            <span class="text-gray-400">Database Storage</span>
                            <span class="font-bold text-emerald-400">12%</span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 12%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-[11px] mb-1">
                            <span class="text-gray-400">Traffic Load</span>
                            <span class="font-bold text-sky-400">Optimal</span>
                        </div>
                        <div class="h-1.5 w-full bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full bg-sky-500 rounded-full w-1/3 animate-pulse"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 pt-4 border-t border-gray-800 text-[10px] text-gray-500 font-mono">
                    System Version v2.1.0 • Running smoothly.
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
</style>
<script>
    function updateClock() {
        const now = new Date();

        // Update Waktu
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('realtimeClock').innerText = `${hours}:${minutes}:${seconds}`;

        // Update Tanggal, Bulan, Tahun
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        document.getElementById('realtimeDate').innerText = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

        // Update Sambutan berdasarkan waktu
        const greeting = document.getElementById('greetingText');
        const h = now.getHours();
        if (h >= 5 && h < 11) greeting.innerText = 'Selamat Pagi, Admin';
        else if (h >= 11 && h < 15) greeting.innerText = 'Selamat Siang, Admin';
        else if (h >= 15 && h < 18) greeting.innerText = 'Selamat Sore, Admin';
        else greeting.innerText = 'Selamat Malam, Admin';
    }

    setInterval(updateClock, 1000);
    updateClock(); // Initialize immediately
</script>
@endsection
