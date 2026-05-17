@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    <div class="flex items-center gap-2 text-[13px] text-gray-500 mb-6">
        <a href="{{ route('admin.rak.index') }}" class="text-primary font-semibold hover:underline">Kelola Rak</a>
        <span class="text-gray-400">›</span>
        <span class="text-gray-900 font-semibold">Detail {{ $spot->kode_jemuran }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_400px] gap-8 items-start">
        
        <div>
            <div class="h-[340px] rounded-2xl overflow-hidden relative shadow-sm border border-gray-100 mb-4 group">
                @if($spot->foto)
                    <img src="{{ asset('storage/rak/' . $spot->foto) }}" alt="Rak {{ $spot->kode_jemuran }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-[#5a8a5a] to-[#2d5a2d] flex flex-col items-center justify-center">
                        <div class="w-24 h-32 border-4 border-white/30 rounded-lg mb-4 flex flex-col justify-evenly p-2">
                            <div class="w-full h-1 bg-white/30 rounded-full"></div>
                            <div class="w-full h-1 bg-white/30 rounded-full"></div>
                            <div class="w-full h-1 bg-white/30 rounded-full"></div>
                        </div>
                        <span class="text-white/60 font-semibold tracking-widest text-sm uppercase">Foto Belum Tersedia</span>
                    </div>
                @endif

                <div class="absolute top-4 right-4">
                    @if ($spot->status_ketersediaan === 'tersedia')
                        <span class="bg-white text-emerald-700 px-4 py-2 rounded-full text-xs font-black shadow-lg uppercase tracking-wider">● TERSEDIA</span>
                    @elseif ($spot->status_ketersediaan === 'maintenance')
                        <span class="bg-white text-yellow-600 px-4 py-2 rounded-full text-xs font-black shadow-lg uppercase tracking-wider">● PERBAIKAN</span>
                    @else
                        <span class="bg-white text-red-600 px-4 py-2 rounded-full text-xs font-black shadow-lg uppercase tracking-wider">● PENUH</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div class="h-24 rounded-xl bg-gray-100 border border-gray-200 overflow-hidden">
                    @if($spot->foto) <img src="{{ asset('storage/rak/' . $spot->foto) }}" class="w-full h-full object-cover opacity-60"> @endif
                </div>
                <div class="h-24 rounded-xl bg-gray-100 border border-gray-200"></div>
                <div class="h-24 rounded-xl bg-gray-50 flex items-center justify-center border-2 border-dashed border-gray-300 text-gray-400">
                    <span class="text-sm font-semibold">+ Foto</span>
                </div>
            </div>
        </div>

        <div>
            <h2 class="font-serif text-3xl text-gray-900 mb-2">{{ $spot->kode_jemuran }}</h2>
            <p class="text-[13px] text-gray-500 leading-relaxed mb-5">
                {{ $spot->deskripsi }}
            </p>

            <div class="grid grid-cols-2 gap-3 mb-6">
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                    <div class="text-xl mb-1">⚖️</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Kapasitas Beban</div>
                    <div class="text-[15px] font-bold text-gray-900">{{ $spot->kapasitas }}</div>
                </div>
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                    <div class="text-xl mb-1">☀️</div>
                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Intensitas Cahaya</div>
                    <div class="text-[15px] font-bold text-gray-900">Optimal</div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4 text-[13px] font-bold text-gray-800 uppercase tracking-wider">
                    <span>⚙️</span> Manajemen Data
                </div>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.rak.edit', $spot->id) }}" class="flex justify-center items-center gap-2 w-full py-3 rounded-lg bg-primary hover:bg-[#094839] text-white font-semibold text-[13px] transition-colors shadow-sm">
                        <span>✏️</span> Edit Data Rak
                    </a>
                    
                    <form action="{{ route('admin.rak.destroy', $spot->id) }}" method="POST" onsubmit="return confirm('Peringatan: Anda yakin ingin menghapus rak ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex justify-center items-center gap-2 w-full py-3 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white font-semibold text-[13px] border border-red-100 hover:border-red-600 transition-colors">
                            <span>🗑️</span> Hapus Rak Jemuran
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection