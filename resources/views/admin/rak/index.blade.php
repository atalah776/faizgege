@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-serif text-3xl font-bold text-gray-900 mb-1">Kelola Rak Jemuran</h1>
            <p class="text-[13px] text-gray-500">Manajemen data master fasilitas penjemuran (CRUD).</p>
        </div>
        <a href="{{ route('admin.rak.create') }}" class="btn-primary !w-auto !py-2.5 !text-[13px]">
            + Tambah Rak Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6 text-sm font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Kode Rak</th>
                    <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Kapasitas</th>
                    <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($spots as $spot)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-5 text-[13px] font-bold text-primary">{{ $spot->kode_jemuran }}</td>
                        <td class="py-4 px-5 text-[13px] text-gray-700">{{ $spot->kapasitas }}</td>
                        <td class="py-4 px-5">
                            <span class="badge {{ $spot->status_ketersediaan == 'tersedia' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $spot->status_ketersediaan }}
                            </span>
                        </td>
                        <td class="py-4 px-5 flex justify-center gap-2">
                            <a href="{{ route('admin.rak.edit', $spot->id) }}" class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md text-[11px] font-bold hover:bg-blue-600 hover:text-white transition-colors">Edit</a>
                            
                            <form action="{{ route('admin.rak.destroy', $spot->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rak ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-md text-[11px] font-bold hover:bg-red-600 hover:text-white transition-colors">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection