@extends('layouts.pengguna')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    <div class="bg-gradient-to-br from-[#094839] to-[#126b54] rounded-2xl p-7 mb-8 relative overflow-hidden shadow-md">
        
        <div class="absolute -left-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-xl pointer-events-none"></div>
        <div class="absolute right-10 -bottom-12 w-48 h-48 bg-[#4ade80]/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute inset-0 opacity-20 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 16px 16px;"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 rounded-full text-white text-[10px] font-bold uppercase tracking-widest mb-3 border border-white/20">
                    <span class="text-white/80 text-xs">🕒</span>
                    Aktivitas Reservasi
                </div>
                
                <h1 class="font-serif text-[28px] font-bold text-white mb-2 leading-tight">Riwayat Booking</h1>
                <p class="text-[13px] text-white/80 leading-relaxed max-w-2xl">
                    Pantau status reservasi rak jemuran Anda. Kelola jadwal aktif, lihat detail tiket untuk penggunaan fasilitas, dan tinjau riwayat penyewaan sebelumnya.
                </p>
            </div>
            
            <div class="hidden md:flex shrink-0 w-16 h-16 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl items-center justify-center text-3xl text-white shadow-lg transform -rotate-3 hover:rotate-0 transition-transform duration-300">
                📋
            </div>
        </div>
    </div>
    
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">ID Booking</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nomor Rak</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Slot Waktu</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total Bayar</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-5 text-[12px] text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                            <td class="py-4 px-5 text-[12px] font-mono font-bold text-primary">#JMR-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-5 text-[13px] font-semibold">{{ $item->spot->kode_jemuran }}</td>
                            <td class="py-4 px-5">
                                <div class="text-[12px] font-semibold text-gray-900">{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('d M, H:i') }}</div>
                                <div class="text-[12px] font-semibold text-gray-900 mt-0.5">- {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('d M, H:i') }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="text-[12px] font-bold text-emerald-700">Rp {{ number_format($item->spot->harga ?? 0, 0, ',', '.') }}</div>
                                @if($item->bukti_pembayaran)
                                    <div class="text-[10px] text-gray-400 mt-1 flex items-center gap-1"><span>👁️</span> Bukti Terkirim</div>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                @if($item->status_booking === 'menunggu')
                                    <span class="badge bg-yellow-100 text-yellow-800">Menunggu ACC</span>
                                @elseif($item->status_booking === 'aktif')
                                    <span class="badge bg-emerald-100 text-emerald-800">Aktif</span>
                                @elseif($item->status_booking === 'selesai')
                                    <span class="badge bg-blue-100 text-blue-800">Selesai</span>
                                @else
                                    <span class="badge bg-red-100 text-red-800">Ditolak/Batal</span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('pengguna.katalog.success', $item->id) }}" class="btn-outline !py-1.5 !px-3 !w-auto text-[11px] !border-gray-200">
                                        <span>▦</span> Tiket
                                    </a>

                                    @if($item->status_booking === 'menunggu')
                                        <form action="{{ route('pengguna.riwayat.cancel', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-50 text-red-600 px-3 py-1.5 rounded-md text-[11px] font-bold hover:bg-red-600 hover:text-white transition-colors">
                                                Hapus Pesanan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-[13px] text-gray-500">Anda belum memiliki riwayat reservasi. Yuk, pesan jemuran sekarang!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection