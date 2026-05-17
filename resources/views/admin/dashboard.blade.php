@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    
    <!-- Bagian Atas / Sambutan -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="font-serif text-3xl font-bold text-gray-900 mb-1">Selamat Datang, Admin</h1>
            <p class="text-[13px] text-gray-500">Berikut adalah ringkasan aktivitas JemuranKu hari ini.</p>
        </div>
        <a href="{{ route('admin.booking') }}" class="btn-primary !w-auto !py-2.5 !text-[13px]">
            <span class="text-lg leading-none">+</span> Input Reservasi Manual
        </a>
    </div>

    <!-- 4 Kartu Ringkasan (Stat Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        
        <!-- Kartu 1 -->
        <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col gap-2 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center text-xl shadow-[inset_0_0_0_1px_rgba(79,70,229,0.2)]">⊟</div>
            <div class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mt-2">Total Rak Terdaftar</div>
            <div class="text-2xl font-bold font-serif text-gray-900">{{ $totalRak }} Unit</div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col gap-2 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center text-xl shadow-[inset_0_0_0_1px_rgba(217,119,6,0.2)]">📅</div>
            <div class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mt-2">Booking Menunggu</div>
            <div class="text-2xl font-bold font-serif text-gray-900">{{ $bookingAktif }} Reservasi</div>
        </div>
        
        <div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col gap-2 shadow-sm hover:shadow-md transition-shadow">
            <div class="w-10 h-10 bg-sky-50 text-sky-600 rounded-lg flex items-center justify-center text-xl shadow-[inset_0_0_0_1px_rgba(2,132,199,0.2)]">◔</div>
            <div class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mt-2">Rata-rata Waktu Jemur</div>
            <div class="text-2xl font-bold font-serif text-gray-900">45 Menit</div>
        </div>
        
        <!-- Kartu 4 (Gaya Gelap / Dark Mode) -->
        <div class="bg-primary border border-primary rounded-xl p-5 flex flex-col gap-2 text-white shadow-sm relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-dark to-transparent opacity-50"></div>
            <div class="relative z-10">
                <div class="w-10 h-10 bg-white/15 rounded-lg flex items-center justify-center text-xl mb-2">⊕</div>
                <div class="text-[11px] text-white/70 font-bold uppercase tracking-wider mt-2">Persentase Kapasitas</div>
                <div class="text-2xl font-bold font-serif text-white">82%</div>
                <!-- Progress Bar -->
                <div class="h-1.5 w-full bg-white/20 rounded-full mt-2 overflow-hidden">
                    <div class="h-full bg-accent rounded-full transition-all duration-1000" style="width: 82%"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Tabel Ringkasan (5 Transaksi Terbaru) -->
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
            <h3 class="text-[15px] font-bold text-gray-900">Reservasi Terbaru</h3>
            <a href="{{ route('admin.booking') }}" class="text-[12px] font-bold text-primary hover:underline">Lihat Semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-3 px-5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">ID Booking</th>
                        <th class="py-3 px-5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Pelanggan</th>
                        <th class="py-3 px-5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Waktu</th>
                        <th class="py-3 px-5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nomor Rak</th>
                        <th class="py-3 px-5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3.5 px-5 text-[12px] font-mono font-bold text-primary">#JMR-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 h-6 rounded-full bg-primary-light text-primary flex items-center justify-center text-[10px] font-bold">{{ substr($booking->user->name, 0, 1) }}</div>
                                    <span class="text-[13px] font-semibold text-gray-900">{{ $booking->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="text-[12px] font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d M, H:i') }}
                                </div>
                                <div class="text-[10px] text-gray-400 font-medium">
                                    s/d {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('d M, H:i') }}
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-[13px] font-semibold text-gray-800">{{ $booking->spot->kode_jemuran }}</td>
                            <td class="py-3.5 px-5">
                                @if($booking->status_booking === 'menunggu')
                                    <span class="badge bg-yellow-100 text-yellow-800">Menunggu</span>
                                @elseif($booking->status_booking === 'aktif')
                                    <span class="badge bg-emerald-100 text-emerald-800">Aktif</span>
                                @elseif($booking->status_booking === 'selesai')
                                    <span class="badge bg-blue-100 text-blue-800">Selesai</span>
                                @else
                                    <span class="badge bg-red-100 text-red-800">Batal</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-[13px] text-gray-500">Belum ada reservasi terbaru yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection