@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    <div class="mb-8">
        <a href="{{ route('admin.rak.index') }}" class="text-[13px] text-gray-500 hover:text-primary mb-2 inline-block">← Kembali ke daftar</a>
        <h1 class="font-serif text-3xl font-bold text-gray-900">{{ isset($spot) ? 'Edit & Detail Rak Jemuran' : 'Tambah Rak Baru' }}</h1>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm max-w-2xl">
       <form action="{{ isset($spot) ? route('admin.rak.update', $spot->id) : route('admin.rak.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
            @csrf
            @if(isset($spot)) @method('PUT') @endif

            @if(isset($spot))
                <div class="mb-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase mb-3 tracking-wider text-center">Pratinjau Foto Saat Ini</label>
                    <div class="grid grid-cols-3 gap-3">
                        
                        <div class="flex flex-col items-center gap-2">
                            <div class="w-full h-24 rounded-lg overflow-hidden bg-white border border-gray-200 shadow-sm">
                                @if($spot->foto) <img src="{{ asset('storage/rak/' . $spot->foto) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase">Kosong</div> @endif
                            </div>
                            <span class="text-[10px] font-bold text-primary">Foto Utama</span>
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-full h-24 rounded-lg overflow-hidden bg-white border border-gray-200 shadow-sm">
                                @if($spot->foto_2) <img src="{{ asset('storage/rak/' . $spot->foto_2) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase">Kosong</div> @endif
                            </div>
                            <span class="text-[10px] font-bold text-gray-500">Foto 2</span>
                        </div>

                        <div class="flex flex-col items-center gap-2">
                            <div class="w-full h-24 rounded-lg overflow-hidden bg-white border border-gray-200 shadow-sm">
                                @if($spot->foto_3) <img src="{{ asset('storage/rak/' . $spot->foto_3) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase">Kosong</div> @endif
                            </div>
                            <span class="text-[10px] font-bold text-gray-500">Foto 3</span>
                        </div>

                    </div>
                </div>
            @endif

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Kode Jemuran / Rak</label>
                <input type="text" name="kode_jemuran" value="{{ old('kode_jemuran', $spot->kode_jemuran ?? '') }}" placeholder="Misal: RAK-A01" required class="w-full border-gray-200 rounded-lg text-[13px] focus:border-primary focus:ring-0">
                @error('kode_jemuran') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Kapasitas Maksimal</label>
                <input type="text" name="kapasitas" value="{{ old('kapasitas', $spot->kapasitas ?? '') }}" placeholder="Misal: 15 Kg" required class="w-full border-gray-200 rounded-lg text-[13px] focus:border-primary focus:ring-0">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Harga Sewa (Paket 2 Hari)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-[13px] text-gray-500 font-bold">Rp</span>
                    <input type="number" name="harga" value="{{ old('harga', $spot->harga ?? '') }}" placeholder="Misal: 15000" required class="w-full border-gray-200 rounded-lg text-[13px] pl-10 focus:border-primary focus:ring-0 font-mono">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Status Ketersediaan</label>
                <select name="status_ketersediaan" required class="w-full border-gray-200 rounded-lg text-[13px] focus:border-primary focus:ring-0">
                    <option value="tersedia" {{ (old('status_ketersediaan', $spot->status_ketersediaan ?? '') == 'tersedia') ? 'selected' : '' }}>Tersedia</option>
                    <option value="maintenance" {{ (old('status_ketersediaan', $spot->status_ketersediaan ?? '') == 'maintenance') ? 'selected' : '' }}>Maintenance / Perbaikan</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3" required class="w-full border-gray-200 rounded-lg text-[13px] focus:border-primary focus:ring-0">{{ old('deskripsi', $spot->deskripsi ?? '') }}</textarea>
            </div>

            <div class="mt-4 border border-dashed border-gray-300 rounded-xl p-5 bg-gray-50/50">
                <div class="mb-4 text-center">
                    <span class="text-[13px] font-bold text-gray-800">Ubah Foto Fasilitas</span>
                    <p class="text-[11px] text-gray-500 mt-1">Biarkan kosong jika Anda tidak ingin mengubah foto yang sudah ada.</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Foto Utama (Katalog)</label>
                        <input type="file" name="foto" class="w-full border-gray-200 bg-white rounded-lg text-[13px] focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Foto Detail 2</label>
                        <input type="file" name="foto_2" class="w-full border-gray-200 bg-white rounded-lg text-[13px] focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-gray-100 hover:file:bg-gray-200 cursor-pointer">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Foto Detail 3</label>
                        <input type="file" name="foto_3" class="w-full border-gray-200 bg-white rounded-lg text-[13px] focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-gray-100 hover:file:bg-gray-200 cursor-pointer">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-primary mt-4 py-3.5 text-[13px] font-bold uppercase tracking-wider">
                {{ isset($spot) ? 'Simpan Perubahan Data' : 'Simpan Rak Baru' }}
            </button>
        </form>
    </div>
</div>
@endsection