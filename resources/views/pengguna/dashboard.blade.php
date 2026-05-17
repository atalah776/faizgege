@extends('layouts.pengguna')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    <div class="bg-gradient-to-br from-[#0d5c4a] to-[#063d30] rounded-2xl p-7 mb-8 relative overflow-hidden shadow-md">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-32 -bottom-10 w-32 h-32 bg-[#4ade80]/20 rounded-full blur-xl pointer-events-none"></div>
        <div class="absolute left-0 top-0 w-full h-full bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-30 pointer-events-none"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-white text-[10px] font-bold uppercase tracking-widest mb-3 border border-white/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 shadow-[0_0_8px_#4ade80] animate-pulse"></span>
                    Sirkulasi Udara Alami
                </div>
                
                <h1 class="font-serif text-[28px] font-bold text-white mb-2 leading-tight">Katalog Jemuran Premium</h1>
                <p class="text-[13px] text-white/80 leading-relaxed max-w-2xl">
                    Temukan dan reservasi area penjemuran yang dikelola dengan standar kebersihan tertinggi. Mengutamakan pencahayaan matahari optimal untuk pakaian Anda.
                </p>
            </div>
            
            <div class="hidden md:flex shrink-0 w-16 h-16 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl items-center justify-center text-3xl text-white shadow-lg transform rotate-3">
                🌿
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mb-8">
        <div class="flex items-center gap-2 bg-white border-[1.5px] border-gray-200 rounded-lg px-4 py-2.5 flex-1 max-w-md">
            <span class="text-gray-400">🔍</span>
            <input type="text" placeholder="Cari berdasarkan lokasi atau fasilitas…" class="border-none outline-none text-[13px] font-sans text-gray-900 bg-transparent w-full focus:ring-0 p-0">
        </div>
        <button class="btn-outline !w-auto !py-2.5 !px-4">
            <span class="text-[13px]">⊟</span> Filter
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach ($spots as $spot)
            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden transition-all duration-200 hover:shadow-[0_6px_24px_rgba(0,0,0,0.1)] hover:-translate-y-1 cursor-pointer flex flex-col">
                
                <div class="h-36 relative overflow-hidden group rounded-t-xl shrink-0">
                    @if ($spot->foto)
                        <img src="{{ asset('storage/rak/' . $spot->foto) }}" alt="Rak {{ $spot->kode_jemuran }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black/15"></div>
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-[#7b9a6d] to-[#4a6741]"></div>
                    @endif

                    <div class="absolute top-3 left-3 z-10">
                        @if ($spot->status_ketersediaan === 'tersedia')
                            <span class="badge bg-emerald-100 text-emerald-800">● TERSEDIA</span>
                        @elseif ($spot->status_ketersediaan === 'maintenance')
                            <span class="badge bg-yellow-100 text-yellow-800">● PERBAIKAN</span>
                        @else
                            <span class="badge bg-red-100 text-red-800">● PENUH</span>
                        @endif
                    </div>

                    <div class="absolute bottom-3 right-3 flex gap-1 z-10 text-white drop-shadow-md">
                        <span class="text-sm opacity-90">☀</span>
                        <span class="text-sm opacity-90">🌬</span>
                    </div>
                </div>

                <div class="p-4 flex flex-col flex-1">
                    <div class="font-bold text-sm mb-1">{{ $spot->kode_jemuran }}</div>
                    <div class="text-xs text-gray-500 flex items-center gap-1 mb-3 line-clamp-1">
                        <span>◉</span> Kapasitas: {{ $spot->kapasitas }}
                    </div>
                    
                    <div class="mt-auto">
                        <div class="mb-3 text-[14px] font-black text-emerald-700">
                            Rp {{ number_format($spot->harga ?? 0, 0, ',', '.') }} <span class="text-[10px] font-normal text-gray-400">/ 2 Hari</span>
                        </div>
                        
                        <a href="{{ $spot->status_ketersediaan === 'tersedia' ? route('pengguna.katalog.detail', $spot->id) : '#' }}" 
                            class="{{ $spot->status_ketersediaan === 'tersedia' ? 'btn-primary' : 'btn-outline border-gray-300 text-gray-400 cursor-not-allowed hover:bg-transparent hover:border-gray-300' }} !py-2 !w-full text-center block">
                            {{ $spot->status_ketersediaan === 'tersedia' ? 'Pesan Sekarang' : 'Tutup Sementara' }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection