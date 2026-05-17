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
            {{ $booking->status_booking === 'aktif' ? 'Tiket / Nota Tersedia!' : 'Detail Transaksi' }}
        </h2>
        <p class="text-[13px] text-gray-500 leading-relaxed mb-8">
            {{ $booking->status_booking === 'aktif'
                ? 'Pembayaran berhasil diverifikasi. Nota resmi Anda telah diterbitkan dan siap dicetak.'
                : 'Silakan transfer sesuai tagihan di bawah ini dan unggah buktinya agar diverifikasi oleh Admin.' }}
        </p>

        <div class="bg-white border-[1.5px] border-gray-200 rounded-2xl overflow-hidden mx-auto text-left shadow-sm hover:shadow-md transition-shadow relative">

            @if($booking->status_booking === 'aktif' || $booking->status_booking === 'selesai')
                <div class="absolute top-24 right-8 text-emerald-500/15 text-6xl font-black font-serif -rotate-12 pointer-events-none border-4 border-emerald-500/15 p-2 rounded z-0 tracking-widest">
                    LUNAS
                </div>
            @endif

            <div class="px-5 py-4 flex items-center justify-between border-b border-dashed border-gray-200 bg-gray-50 relative z-10">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-primary flex items-center justify-center text-white text-[10px]">🌿</div>
                    <span class="font-bold text-[13px] text-primary">JemuranKu Pass</span>
                </div>

                @php
                    $statusColor = match(strtolower($booking->status_booking)) {
                        'menunggu' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'aktif'    => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                        'selesai'  => 'bg-blue-100 text-blue-800 border-blue-200',
                        default    => 'bg-red-100 text-red-800 border-red-200'
                    };
                @endphp
                <span class="badge {{ $statusColor }} uppercase font-bold text-[10px] px-2.5 py-1 rounded-full shadow-sm border">
                    ● {{ $booking->status_booking == 'menunggu' ? 'MENUNGGU ACC' : $booking->status_booking }}
                </span>
            </div>

            <div class="p-5 relative z-10">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400">ID BOOKING</div>
                        <div class="text-[14px] font-bold text-primary mt-0.5 font-mono">#JMR-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400">NAMA PENGGUNA</div>
                        <div class="text-[14px] font-bold text-gray-900 mt-0.5 line-clamp-1">{{ auth()->user()->name }}</div>
                    </div>
                </div>

                <div class="flex gap-2 mb-4">
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex-1 flex flex-col justify-center">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">⊟ NOMOR RAK</div>
                        <div class="text-2xl font-bold text-primary font-serif">{{ $booking->spot->kode_jemuran }}</div>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3 flex-[1.5]">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">◔ JADWAL PENJEMURAN</div>
                        <div class="text-[11px] font-bold text-gray-900 mt-1">▶ {{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d M Y, H:i') }} WIB</div>
                        <div class="text-[11px] font-bold text-gray-900 mt-1">■ {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('d M Y, H:i') }} WIB</div>
                    </div>
                </div>

                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-3 flex justify-between items-center mb-2">
                    <div class="text-[10px] font-bold uppercase tracking-wider text-emerald-800">TOTAL TAGIHAN (2 Hari)</div>
                    <div class="text-lg font-black text-emerald-700">Rp {{ number_format($booking->spot->harga ?? 0, 0, ',', '.') }}</div>
                </div>

                @if(!$booking->bukti_pembayaran)
                    <div class="mt-5 pt-4 border-t border-gray-200 border-dashed">
                        <div class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-2.5">Pilihan Metode Pembayaran:</div>

                        <div class="space-y-2 mb-4 text-[12px]">
                            <div class="flex items-center justify-between p-2.5 border border-gray-100 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-6 bg-blue-600 rounded text-white text-[9px] font-black flex items-center justify-center italic shadow-sm">BANK BCA</div>
                                    <div class="text-left font-bold text-gray-800">8945-0912-33 <span class="block text-[10px] font-normal text-gray-400">A.n JemuranKu Official</span></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-2.5 border border-gray-100 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-6 bg-blue-400 rounded text-white text-[9px] font-black flex items-center justify-center italic shadow-sm">E-DANA</div>
                                    <div class="text-left font-bold text-gray-800">0812-3456-7890 <span class="block text-[10px] font-normal text-gray-400">JemuranKu App</span></div>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('pengguna.katalog.bayar', $booking->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1.5">Unggah Bukti Transfer Asli</label>
                            <input type="file" name="bukti_pembayaran" required class="w-full text-[12px] text-gray-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-[11px] file:font-bold file:bg-primary file:text-white hover:file:bg-[#094839] cursor-pointer mb-3 border border-gray-200 rounded-lg bg-white">
                            <button type="submit" class="w-full bg-primary text-white font-bold py-2.5 rounded-lg text-[13px] hover:bg-[#094839] transition-colors shadow-sm">
                                Kirim Bukti Pembayaran
                            </button>
                        </form>
                    </div>

                @elseif($booking->status_booking == 'menunggu')
                    <div class="mt-5 pt-5 border-t border-gray-200 border-dashed text-center">
                        <div class="w-10 h-10 bg-yellow-50 rounded-full flex items-center justify-center text-yellow-600 text-lg mx-auto mb-2 animate-pulse">⏳</div>
                        <h4 class="font-bold text-gray-900 text-[13px]">Pembayaran Sedang Diverifikasi</h4>
                        <p class="text-[11px] text-gray-400 mt-1 leading-relaxed">Bukti transfer sudah terkirim ke Admin. Pengunduhan nota resmi dan tiket barcode akan dibuka otomatis setelah Admin memberikan konfirmasi ACC.</p>
                    </div>

                @else
                    <div class="border-t border-dashed border-gray-200 pt-5 mt-4 text-center">
                        <div class="flex items-end justify-center gap-[3px] h-10 mb-1 opacity-90">
                            @for ($i = 0; $i < 26; $i++)
                                <div class="w-[3px] bg-gray-900 rounded-[1px]" style="height: {{ rand(18, 42) }}px;"></div>
                            @endfor
                        </div>
                        <div class="text-[10px] font-mono text-gray-400 tracking-[0.15em] mt-2">JMR{{ date('ymd', strtotime($booking->created_at)) }}{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</div>
                    </div>
                @endif

            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 mt-5">
            @if($booking->status_booking === 'aktif' || $booking->status_booking === 'selesai')
                <button type="button" onclick="openNotaModal('{{ route('pengguna.katalog.cetak', $booking->id) }}')" class="btn-primary !py-3 !text-[13px] shadow-sm hover:shadow-md transition-all">
                    🖨️ Cetak / Unduh Nota
                </button>
            @else
                <button disabled class="bg-gray-100 text-gray-400 border border-gray-200 font-bold !py-3 !text-[13px] rounded-lg cursor-not-allowed flex items-center justify-center gap-1.5 shadow-inner">
                    <span>🔒</span> Nota Belum Siap
                </button>
            @endif

            <a href="{{ url('/pengguna/riwayat') }}" class="btn-outline !py-3 !text-[13px] !text-center transition-colors">
                Kembali ke Riwayat
            </a>
        </div>
    </div>
</div>

<div id="notaModal" class="fixed inset-0 z-[100] hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="relative max-w-3xl w-full bg-gray-100 rounded-xl shadow-2xl flex flex-col transform scale-95 transition-transform duration-300 overflow-hidden" id="notaModalContent" style="height: 90vh;">

        <div class="px-6 py-3.5 bg-white border-b border-gray-200 flex justify-between items-center z-10 shadow-sm shrink-0">
            <h3 class="font-bold text-gray-800 text-[15px]">Pratinjau Nota Resmi</h3>
            <div class="flex gap-2">
                <button onclick="printNota()" class="px-4 py-2 bg-primary text-white rounded-lg text-[12px] font-bold hover:bg-[#094839] transition-colors shadow-sm flex items-center gap-2">
                    🖨️ Cetak PDF
                </button>
                <button onclick="closeNotaModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-[12px] font-bold hover:bg-gray-200 transition-colors">
                    Tutup
                </button>
            </div>
        </div>

        <div class="w-full flex-1 bg-gray-100 p-0 overflow-hidden rounded-b-xl">
            <iframe id="notaIframe" src="" class="w-full h-full bg-transparent border-0"></iframe>
        </div>
    </div>
</div>

<script>
    // Pastikan fungsi ini ada di dalam tag <script> yang sudah ada di halamanmu
    function openNotaModal(url) {
        const modal = document.getElementById('notaModal');
        const iframe = document.getElementById('notaIframe');
        const modalContent = document.getElementById('notaModalContent');

        iframe.src = url;
        modal.classList.remove('hidden');

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 20);
    }

    function closeNotaModal() {
        const modal = document.getElementById('notaModal');
        const modalContent = document.getElementById('notaModalContent');

        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('notaIframe').src = '';
        }, 300);
    }

    function printNota() {
        const iframe = document.getElementById('notaIframe');
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
    }
</script>
@endsection
