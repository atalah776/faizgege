@extends('layouts.pengguna')

@section('content')
<div class="flex items-center justify-center min-h-[80vh] py-10">
    <div class="text-center max-w-md w-full animate-[scaleIn_0.3s_ease_both]">
        
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-[13px] font-bold shadow-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="w-14 h-14 bg-primary rounded-full flex items-center justify-center mx-auto mb-5 text-white text-2xl shadow-sm border-[3px] border-primary-light">
            {{ $booking->status_booking === 'aktif' ? '🎟️' : '🧾' }}
        </div>
        
        <h2 class="font-serif text-3xl mb-2 text-gray-900">
            {{ $booking->status_booking === 'aktif' ? 'Tiket Tersedia!' : 'Detail Transaksi' }}
        </h2>
        <p class="text-[13px] text-gray-500 leading-relaxed mb-8">
            {{ $booking->status_booking === 'aktif' 
                ? 'Pembayaran berhasil diverifikasi. Tiket Anda siap digunakan.' 
                : 'Selesaikan pembayaran Anda agar tiket dapat diterbitkan oleh Admin.' }}
        </p>

        <div class="bg-white border-[1.5px] border-gray-200 rounded-2xl overflow-hidden mx-auto text-left shadow-sm hover:shadow-md transition-shadow relative mb-6">
            
            <div class="px-5 py-4 flex items-center justify-between border-b border-dashed border-gray-200 bg-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-primary flex items-center justify-center text-white text-[10px]">🌿</div>
                    <span class="font-bold text-[13px] text-primary">JemuranKu Pass</span>
                </div>
                
                @php
                    $statusColor = match(strtolower($booking->status_booking)) {
                        'menunggu' => 'bg-yellow-100 text-yellow-800',
                        'aktif'    => 'bg-emerald-100 text-emerald-800',
                        'selesai'  => 'bg-blue-100 text-blue-800',
                        'dibatalkan', 'ditolak' => 'bg-red-100 text-red-800',
                        default    => 'bg-gray-100 text-gray-800'
                    };
                @endphp
                <span class="badge {{ $statusColor }} uppercase font-bold text-[10px] px-2.5 py-1 rounded-full shadow-sm">
                    ● {{ $booking->status_booking == 'menunggu' ? 'MENUNGGU ACC' : $booking->status_booking }}
                </span>
            </div>

            <div class="p-5">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400">ID BOOKING</div>
                        <div class="text-[15px] font-bold text-primary mt-0.5 font-mono">#JMR-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400">NAMA PENGGUNA</div>
                        <div class="text-[15px] font-bold text-gray-900 mt-0.5 line-clamp-1">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                <div class="flex gap-2 mb-4">
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex-1 flex flex-col justify-center">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">⊟ NOMOR RAK</div>
                        <div class="text-xl font-bold text-primary font-serif">{{ $booking->spot->kode_jemuran }}</div>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex-[1.5]">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">◔ SLOT WAKTU</div>
                        <div class="text-[12px] font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d M Y, H:i') }} WIB</div>
                        <div class="text-[12px] font-bold text-gray-900 mt-1">{{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('d M Y, H:i') }} WIB</div>
                    </div>
                </div>

                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 flex justify-between items-center">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-800">TOTAL BAYAR (2 Hari)</div>
                    <div class="text-lg font-black text-emerald-700">Rp {{ number_format($booking->spot->harga ?? 0, 0, ',', '.') }}</div>
                </div>

                @if(!$booking->bukti_pembayaran)
                    <div class="mt-6 pt-5 border-t border-gray-200 border-dashed">
                        <div class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-3">Pilih Metode Pembayaran:</div>
                        
                        <div class="grid grid-cols-1 gap-2 mb-4">
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-6 bg-blue-600 rounded text-white text-[10px] font-black flex items-center justify-center italic">BCA</div>
                                    <div class="text-left"><div class="text-[12px] font-bold text-gray-900">8945 0912 33</div><div class="text-[10px] text-gray-500">A.n JemuranKu Official</div></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-6 bg-orange-500 rounded text-white text-[10px] font-black flex items-center justify-center italic">BNI</div>
                                    <div class="text-left"><div class="text-[12px] font-bold text-gray-900">099 123 4455</div><div class="text-[10px] text-gray-500">A.n JemuranKu Official</div></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-6 bg-blue-400 rounded text-white text-[10px] font-black flex items-center justify-center italic">DANA</div>
                                    <div class="text-left"><div class="text-[12px] font-bold text-gray-900">0812 3456 7890</div><div class="text-[10px] text-gray-500">JemuranKu App</div></div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('pengguna.katalog.bayar', $booking->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Upload Bukti Transfer</label>
                            @error('bukti_pembayaran') <span class="text-red-500 text-[10px] block mb-2">{{ $message }}</span> @enderror
                            <input type="file" name="bukti_pembayaran" required class="w-full text-[12px] text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-primary file:text-white hover:file:bg-[#094839] cursor-pointer mb-3 border border-gray-200 rounded-lg">
                            
                            <button type="submit" class="w-full bg-primary text-white font-bold py-3 rounded-lg text-[13px] hover:bg-[#094839] transition-colors">
                                Kirim Bukti Pembayaran
                            </button>
                        </form>
                    </div>

                @elseif($booking->status_booking == 'menunggu')
                    <div class="mt-6 pt-5 border-t border-gray-200 border-dashed text-center">
                        <div class="w-12 h-12 bg-yellow-50 rounded-full flex items-center justify-center text-yellow-600 text-xl mx-auto mb-2 animate-bounce">⏳</div>
                        <h4 class="font-bold text-gray-900 text-[14px]">Sedang Diverifikasi</h4>
                        <p class="text-[12px] text-gray-500 mt-1">Bukti pembayaran Anda telah kami terima dan sedang dicek oleh Admin. Tiket akan muncul di sini setelah di-ACC.</p>
                    </div>

                @elseif($booking->status_booking == 'aktif' || $booking->status_booking == 'selesai')
                    <div class="border-t border-dashed border-gray-200 pt-5 mt-4 text-center relative">
                        <div class="absolute top-0 right-4 text-emerald-500/10 text-6xl font-black font-serif -rotate-12 pointer-events-none border-4 border-emerald-500/10 p-2 rounded z-0">
                            LUNAS
                        </div>
                        <div class="flex items-end justify-center gap-[3px] h-10 mb-1 opacity-80 relative z-10">
                            @for ($i = 0; $i < 24; $i++)
                                <div class="w-[3px] bg-gray-800 rounded-[1px]" style="height: {{ rand(15, 40) }}px;"></div>
                            @endfor
                        </div>
                        <div class="text-[10px] font-mono text-gray-400 tracking-[0.15em] mt-2">JMR{{ date('ymd', strtotime($booking->created_at)) }}{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                @endif
                </div>
        </div>

        <div class="grid grid-cols-2 gap-3 mt-4">
            @if($booking->status_booking == 'aktif' || $booking->status_booking == 'selesai')
                <button onclick="window.print()" class="btn-primary !py-3 !text-[13px] shadow-sm hover:shadow-md transition-shadow">
                    ↓ Cetak / Unduh Tiket
                </button>
            @else
                <button disabled class="bg-gray-100 text-gray-400 font-bold !py-3 !text-[13px] rounded-lg cursor-not-allowed">
                    🔒 Tiket Terkunci
                </button>
            @endif
            
            <a href="{{ url('/pengguna/riwayat') }}" class="btn-outline !py-3 !text-[13px] !text-center transition-colors">
                Kembali ke Riwayat
            </a>
        </div>
    </div>
</div>
@endsection