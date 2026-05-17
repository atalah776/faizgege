@extends('layouts.pengguna')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    <h1 class="font-serif text-3xl font-bold text-gray-900 mb-1">Panduan Booking</h1>
    <p class="text-[13px] text-gray-500 leading-relaxed mb-8 max-w-2xl">
        Ikuti langkah-langkah mudah berikut untuk memastikan pakaian Anda kering sempurna. Fasilitas premium kami dirancang untuk kenyamanan dan efisiensi waktu Anda.
    </p>

    <!-- Hero Banner (Aksen Visual) -->
    <div class="bg-gradient-to-br from-[#094839] to-[#1a7a62] rounded-2xl p-8 mb-8 relative overflow-hidden shadow-md">
        <div class="absolute inset-0 opacity-10">
            <svg width="100%" height="100%" viewBox="0 0 800 200">
                <circle cx="100" cy="100" r="80" fill="none" stroke="white" stroke-width="2"/>
                <circle cx="200" cy="100" r="100" fill="none" stroke="white" stroke-width="2"/>
                <circle cx="300" cy="100" r="120" fill="none" stroke="white" stroke-width="2"/>
            </svg>
        </div>
        <div class="relative z-10">
            <div class="text-[10px] font-bold tracking-[0.15em] text-white/60 mb-2 uppercase">Premium Service</div>
            <div class="font-serif text-3xl text-white mb-2">Mudah, Cepat, Bersih.</div>
            <div class="text-[13px] text-white/80">Layanan reservasi jemuran eksklusif dalam 4 langkah terstruktur.</div>
        </div>
    </div>

    <!-- Grid Panduan 4 Langkah -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- Langkah 1 -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary-light text-primary rounded-xl flex items-center justify-center text-xl shrink-0 font-bold">⊟</div>
                <div>
                    <div class="text-[10px] font-bold tracking-widest text-primary uppercase mb-1">Langkah 1</div>
                    <div class="font-serif text-xl font-bold text-gray-900 leading-none">Pilih Rak</div>
                </div>
            </div>
            <p class="text-[13px] text-gray-500 leading-relaxed">Cari dan telusuri katalog kami untuk menemukan rak jemuran terbaik yang sesuai dengan kebutuhan kapasitas dan jenis pakaian Anda.</p>
        </div>

        <!-- Langkah 2 -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary-light text-primary rounded-xl flex items-center justify-center text-xl shrink-0 font-bold">◔</div>
                <div>
                    <div class="text-[10px] font-bold tracking-widest text-primary uppercase mb-1">Langkah 2</div>
                    <div class="font-serif text-xl font-bold text-gray-900 leading-none">Tentukan Waktu</div>
                </div>
            </div>
            <p class="text-[13px] text-gray-500 leading-relaxed">Pilih slot jadwal jemur yang tersedia. Sistem kami memastikan tidak ada tumpang tindih jadwal untuk privasi maksimal.</p>
        </div>

        <!-- Langkah 3 -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary-light text-primary rounded-xl flex items-center justify-center text-xl shrink-0 font-bold">⊞</div>
                <div>
                    <div class="text-[10px] font-bold tracking-widest text-primary uppercase mb-1">Langkah 3</div>
                    <div class="font-serif text-xl font-bold text-gray-900 leading-none">Konfirmasi</div>
                </div>
            </div>
            <p class="text-[13px] text-gray-500 leading-relaxed">Tinjau kembali rincian pesanan Anda dan selesaikan pembayaran melalui metode yang aman untuk mengonfirmasi reservasi.</p>
        </div>

        <!-- Langkah 4 -->
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-primary-light text-primary rounded-xl flex items-center justify-center text-xl shrink-0 font-bold">◫</div>
                <div>
                    <div class="text-[10px] font-bold tracking-widest text-primary uppercase mb-1">Langkah 4</div>
                    <div class="font-serif text-xl font-bold text-gray-900 leading-none">Mulai Menjemur</div>
                </div>
            </div>
            <p class="text-[13px] text-gray-500 leading-relaxed">Kunjungi lokasi pada waktu yang ditentukan, scan QR code pada rak jemuran Anda, dan gunakan fasilitas dengan nyaman.</p>
        </div>

    </div>

    <!-- Tombol Mulai -->
    <div class="mt-10 text-center">
        <a href="{{ url('/pengguna/dashboard') }}" class="btn-primary !w-auto !inline-flex !py-3 !px-8 shadow-sm">
            Mulai Booking Sekarang →
        </a>
    </div>

</div>
@endsection