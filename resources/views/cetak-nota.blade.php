<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Resmi - #JMR-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap');

        /* Setelan Utama Layar (Pratinjau di dalam Iframe Modal) */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Warna latar luar kertas */
            margin: 0;
            padding: 2rem 1rem; /* Memberi jarak agar kertas tidak menempel ujung layar */
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .font-serif { font-family: 'Playfair Display', serif; }

        /* Desain Kertas Nota */
        .nota-kertas {
            background-color: #ffffff;
            width: 100%;
            max-width: 750px; /* Lebar maksimal yang pas dan proporsional */
            padding: 45px 50px;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }

        /* Pita Gradasi Estetik di Atas Nota */
        .pita-atas {
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 8px;
            background: linear-gradient(90deg, #0d5c4a 0%, #10b981 100%);
        }

        /* ---------------------------------------------------- */
        /* PENGATURAN KHUSUS SAAT TOMBOL PRINT DITEKAN          */
        /* ---------------------------------------------------- */
        @media print {
            @page { margin: 0.5cm; size: A4 portrait; }
            body {
                background-color: transparent;
                padding: 0;
                display: block;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .nota-kertas {
                box-shadow: none !important;
                border-radius: 0 !important;
                padding: 20px 30px !important;
                max-width: 100% !important;
                margin: 0 !important;
                border: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="nota-kertas">
        <div class="pita-atas"></div>

        @if($booking->status_booking === 'aktif' || $booking->status_booking === 'selesai')
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-emerald-500/10 text-[110px] font-black font-serif -rotate-45 pointer-events-none select-none z-0 tracking-widest uppercase border-[6px] border-emerald-500/10 p-6 rounded-3xl">
                LUNAS
            </div>
        @else
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-red-500/10 text-[85px] font-black font-serif -rotate-45 pointer-events-none select-none z-0 tracking-widest uppercase text-center leading-tight border-[6px] border-red-500/10 p-6 rounded-3xl">
                BELUM<br>LUNAS
            </div>
        @endif

        <div class="relative z-10">
            <div class="flex justify-between items-start mb-10">
                <div>
                    <div class="flex items-center gap-2.5 mb-1.5">
                        <div class="w-9 h-9 rounded bg-gradient-to-br from-[#0d5c4a] to-[#126b54] flex items-center justify-center text-white text-[16px] shadow-sm">🌿</div>
                        <h1 class="font-serif text-3xl font-bold text-[#0d5c4a] tracking-wide">JemuranKu</h1>
                    </div>
                    <p class="text-[11px] text-gray-500 tracking-wide font-medium">Layanan Reservasi Fasilitas Penjemuran Premium</p>
                </div>
                <div class="text-right">
                    <h2 class="text-3xl font-black text-gray-200 tracking-widest uppercase mb-1">INVOICE</h2>
                    <p class="text-[13px] font-bold text-gray-800">#JMR-{{ date('ymd', strtotime($booking->created_at)) }}-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Diterbitkan: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB</p>
                </div>
            </div>

            <div class="w-full h-px bg-gray-200 mb-8"></div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tagihan Kepada:</h3>
                    <p class="text-[16px] font-bold text-gray-900">{{ $booking->user->name }}</p>
                    <p class="text-[12px] text-gray-500 mt-1">ID Pelanggan: <span class="font-mono text-gray-700">USR-{{ str_pad($booking->user->id, 4, '0', STR_PAD_LEFT) }}</span></p>
                </div>
                <div class="text-right">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Status Pembayaran:</h3>
                    @if($booking->status_booking === 'aktif' || $booking->status_booking === 'selesai')
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[11px] font-bold uppercase tracking-wider shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Telah Diverifikasi (Lunas)
                        </div>
                    @else
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 border border-red-200 rounded text-[11px] font-bold uppercase tracking-wider shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Menunggu Pembayaran
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 overflow-hidden mb-8">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Deskripsi Layanan & Jadwal</th>
                            <th class="py-3 px-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Durasi</th>
                            <th class="py-3 px-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-right">Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        <tr>
                            <td class="py-5 px-4">
                                <p class="text-[14px] font-bold text-gray-900 mb-1.5">Sewa Rak Fasilitas - <span class="text-primary">{{ $booking->spot->kode_jemuran }}</span></p>
                                <div class="text-[11px] text-gray-500 space-y-1">
                                    <p class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> <strong class="text-gray-600">Check-in:</strong> {{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d F Y - H:i') }} WIB</p>
                                    <p class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span> <strong class="text-gray-600">Batas Waktu:</strong> {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('d F Y - H:i') }} WIB</p>
                                </div>
                            </td>
                            <td class="py-5 px-4 text-center align-middle">
                                <span class="text-[12px] font-bold text-gray-700 bg-gray-100 px-2.5 py-1 rounded-md">2 Hari</span>
                            </td>
                            <td class="py-5 px-4 text-right align-middle">
                                <span class="text-[14px] font-bold text-gray-700">Rp {{ number_format($booking->spot->harga ?? 0, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot class="bg-gray-50/80 border-t border-gray-200">
                        <tr>
                            <td colspan="2" class="py-4 px-4 text-right text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                                Total Tagihan:
                            </td>
                            <td class="py-4 px-4 text-right">
                                <span class="text-[18px] font-black text-[#0d5c4a]">Rp {{ number_format($booking->spot->harga ?? 0, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex justify-between items-end mt-12">
                <div>
                    <div class="flex items-end gap-[2px] h-10 mb-1">
                        @for ($i = 0; $i < 32; $i++)
                            <div class="w-[2.5px] bg-gray-900 rounded-sm" style="height: {{ rand(15, 38) }}px;"></div>
                        @endfor
                    </div>
                    <p class="text-[9px] font-mono text-gray-500 tracking-[0.2em] text-center mt-2">{{ $booking->id }}*{{ $booking->spot_id }}*{{ strtotime($booking->created_at) }}</p>
                </div>

                <div class="text-center">
                    <p class="text-[10px] font-semibold text-gray-400 mb-6 uppercase tracking-wider">Disahkan Oleh Sistem</p>
                    <div class="font-serif text-2xl font-bold text-[#0d5c4a] italic border-b-2 border-gray-200 pb-1.5 inline-block px-6">JemuranKu</div>
                    <p class="text-[9px] font-bold text-gray-500 mt-2 uppercase tracking-widest">Admin Official</p>
                </div>
            </div>

            <div class="mt-12 text-center text-[10px] text-gray-400 border-t border-dashed border-gray-200 pt-4 leading-relaxed">
                <p>Nota ini merupakan dokumen resmi yang sah dan dicetak secara otomatis oleh sistem <strong class="text-gray-500">JemuranKu App</strong>.</p>
                <p>Harap simpan dan tunjukkan nota ini (baik dalam bentuk digital maupun cetak) kepada petugas kami jika diperlukan.</p>
            </div>
        </div>
    </div>

</body>
</html>
