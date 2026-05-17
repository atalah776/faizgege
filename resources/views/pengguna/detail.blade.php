@extends('layouts.pengguna')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

<div class="animate-[fadeIn_0.35s_ease_both]">
    <div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
        <a href="/pengguna/dashboard" class="text-primary font-semibold hover:underline transition-colors">Katalog</a>
        <span class="text-gray-400">›</span>
        <span class="text-gray-900 font-semibold">{{ $spot->kode_jemuran }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-10 items-start">

        <div class="sticky top-6">
            <div class="h-[380px] rounded-2xl overflow-hidden relative shadow-sm border border-gray-100 mb-4 group bg-gray-50">
                @if($spot->foto)
                    <img id="mainImage" src="{{ asset('storage/rak/' . $spot->foto) }}" alt="Rak {{ $spot->kode_jemuran }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-[#5a8a5a] to-[#2d5a2d] flex flex-col items-center justify-center">
                        <span class="text-white/60 font-semibold tracking-widest text-sm uppercase">Foto Belum Tersedia</span>
                    </div>
                @endif

                <div class="absolute top-4 right-4 z-10">
                    @php
                        $badgeColor = match($spot->status_ketersediaan) {
                            'tersedia' => 'bg-white text-emerald-700',
                            'maintenance' => 'bg-white text-yellow-600',
                            default => 'bg-white text-red-600'
                        };
                    @endphp
                    <span class="{{ $badgeColor }} px-4 py-2 rounded-full text-xs font-black shadow-lg uppercase tracking-wider">
                        ● {{ $spot->status_ketersediaan }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="h-28 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                    @if($spot->foto) <img src="{{ asset('storage/rak/' . $spot->foto) }}" onclick="document.getElementById('mainImage').src=this.src" class="w-full h-full object-cover opacity-60 hover:opacity-100 transition-opacity cursor-pointer"> @endif
                </div>
                <div class="h-28 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                    @if($spot->foto_2) <img src="{{ asset('storage/rak/' . $spot->foto_2) }}" onclick="document.getElementById('mainImage').src=this.src" class="w-full h-full object-cover opacity-60 hover:opacity-100 transition-opacity cursor-pointer"> @endif
                </div>
                <div class="h-28 rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                    @if($spot->foto_3) <img src="{{ asset('storage/rak/' . $spot->foto_3) }}" onclick="document.getElementById('mainImage').src=this.src" class="w-full h-full object-cover opacity-60 hover:opacity-100 transition-opacity cursor-pointer"> @endif
                </div>
            </div>
        </div>

        <div>
            <div class="mb-8">
                <h2 class="font-serif text-4xl text-gray-900 mb-3">{{ $spot->kode_jemuran }}</h2>
                <p class="text-[14px] text-gray-500 leading-relaxed">{{ $spot->deskripsi }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-5 hover:border-primary transition-colors">
                    <div class="text-2xl mb-2">⚖️</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kapasitas Beban</div>
                    <div class="text-lg font-bold text-gray-900">{{ $spot->kapasitas }}</div>
                </div>
                <div class="bg-white shadow-sm border border-gray-100 rounded-2xl p-5 hover:border-primary transition-colors">
                    <div class="text-2xl mb-2">⏱️</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Durasi Jemur</div>
                    <div class="text-lg font-bold text-gray-900">2 Hari (Max)</div>
                </div>
            </div>

            @if($spot->status_ketersediaan === 'tersedia')
                <div class="bg-[#f8fbf9] border border-[#d1e5dc] rounded-2xl p-6 relative overflow-hidden">
                    <div class="absolute -right-6 -top-6 text-9xl opacity-5">🌿</div>

                    <div class="flex items-center gap-2 mb-6 text-[14px] font-bold text-primary relative z-10">
                        <span>📅</span> Form Reservasi Fasilitas
                    </div>

                    @if ($errors->any())
                        <div class="mb-5 p-4 bg-red-50 border border-red-200 text-red-600 rounded-xl text-[12px] font-semibold relative z-10">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pengguna.katalog.store') }}" method="POST" class="relative z-10">
                        @csrf
                        <input type="hidden" name="spot_id" value="{{ $spot->id }}">

                        <div class="mb-5 bg-emerald-50/50 border border-emerald-100 rounded-xl p-4 flex justify-between items-center">
                            <span class="text-[12px] font-bold text-emerald-800">Total Harga (Paket 2 Hari)</span>
                            <span class="text-lg font-black text-emerald-700">Rp {{ number_format($spot->harga ?? 0, 0, ',', '.') }}</span>
                        </div>

                        <div class="space-y-5 mb-8">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Tanggal Mulai</label>
                                <input type="text" id="waktu_mulai" name="waktu_mulai" required placeholder="Klik untuk melihat tanggal tersedia..." class="w-full border-gray-300 rounded-xl py-3 px-4 text-[13px] font-bold text-gray-700 focus:border-primary focus:ring-primary cursor-pointer bg-white shadow-sm transition-all hover:border-primary">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Jadwal Angkat (Otomatis + Jam Realtime)</label>
                                <div class="relative">
                                    <input type="text" id="waktu_selesai" name="waktu_selesai" readonly placeholder="Akan terisi otomatis setelah pilih tanggal..." class="w-full border-gray-200 rounded-xl py-3 px-4 text-[13px] font-bold bg-gray-100 text-gray-400 cursor-not-allowed select-none">
                                    <div class="absolute right-4 top-3 text-gray-400">🔒</div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary hover:bg-[#094839] text-white font-bold py-4 rounded-xl shadow-md hover:shadow-lg transition-all text-[14px] tracking-wide flex justify-center items-center gap-2">
                            Lanjutkan ke Pembayaran <span>→</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-red-50 border border-red-100 rounded-2xl p-8 text-center shadow-sm">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-2xl">
                        {{ $spot->status_ketersediaan === 'maintenance' ? '🛠️' : '⛔' }}
                    </div>
                    <h3 class="font-serif text-2xl text-gray-900 mb-2">Fasilitas Ditutup</h3>
                    <p class="text-[13px] text-gray-500 leading-relaxed mb-0">
                        Mohon maaf, rak jemuran ini sedang dalam status <strong class="uppercase text-red-600">{{ $spot->status_ketersediaan }}</strong>. Anda tidak dapat melakukan reservasi hingga Admin membuka kembali fasilitas ini.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookedDates = @json($bookedDates ?? []);
        const dateInput = document.getElementById("waktu_mulai");

        if (dateInput) {
            flatpickr(dateInput, {
                minDate: "today",
                disable: bookedDates,
                dateFormat: "Y-m-d", // Menginput tanggal bersih
                onChange: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        // Ambil jam & menit waktu nyata (real-time WIB) saat ini
                        let now = new Date();
                        let hours = String(now.getHours()).padStart(2, '0');
                        let minutes = String(now.getMinutes()).padStart(2, '0');

                        // Pasang teks jam real-time ke input mulai secara paksa agar terbaca user
                        instance.input.value = `${dateStr} ${hours}:${minutes}`;

                        // Hitung tanggal selesai (+2 hari)
                        let endDate = new Date(selectedDates[0]);
                        endDate.setDate(endDate.getDate() + 2);

                        let endYear = endDate.getFullYear();
                        let endMonth = String(endDate.getMonth() + 1).padStart(2, '0');
                        let endDay = String(endDate.getDate()).padStart(2, '0');

                        // Cetak tanggal selesai lengkap dengan jam otomatisnya
                        document.getElementById('waktu_selesai').value = `${endYear}-${endMonth}-${endDay} ${hours}:${minutes} WIB`;
                    } else {
                        document.getElementById('waktu_selesai').value = '';
                    }
                }
            });
        }
    });
</script>
@endsection
