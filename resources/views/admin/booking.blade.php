@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-serif text-3xl font-bold text-gray-900 mb-1">Manajemen Booking</h1>
            <p class="text-[13px] text-gray-500">Kelola reservasi, verifikasi pembayaran, dan cetak laporan.</p>
        </div>
        <a href="{{ route('admin.booking.pdf', request()->query()) }}" class="btn-primary !w-auto !py-2.5 !text-[13px] bg-red-600 hover:bg-red-700 shadow-sm">
            <span>↓</span> Export PDF
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6 text-sm font-semibold shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm">
        <form action="{{ route('admin.booking') }}" method="GET" class="flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Status</label>
                <select name="status" class="border-gray-200 rounded-lg text-[13px] py-2 focus:border-primary focus:ring-0 w-40">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif (ACC)</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="border-gray-200 rounded-lg text-[13px] py-2 focus:border-primary focus:ring-0">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-gray-400 uppercase mb-1">Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="border-gray-200 rounded-lg text-[13px] py-2 focus:border-primary focus:ring-0">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-primary hover:bg-[#094839] text-white px-4 py-2 rounded-lg text-[13px] font-bold transition-colors">Terapkan Filter</button>
                <a href="{{ route('admin.booking') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-[13px] font-bold transition-colors">Reset</a>
            </div>
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">ID Booking</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nomor Rak</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Jadwal Jemur</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Lampiran</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Aksi (Verifikasi)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-5 text-[12px] font-mono font-bold text-primary">#JMR-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-primary-light text-primary flex items-center justify-center text-xs font-bold">{{ substr($booking->user->name, 0, 1) }}</div>
                                    <span class="text-[13px] font-semibold text-gray-900">{{ $booking->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5 text-[13px] font-semibold text-gray-800">{{ $booking->spot->kode_jemuran }}</td>
                            <td class="py-4 px-5">
                                <div class="text-[12px] font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->waktu_mulai)->format('d M Y, H:i') }}
                                </div>
                                <div class="text-[10px] font-bold text-primary opacity-50 my-0.5">s/d</div>
                                <div class="text-[12px] font-semibold text-gray-900">
                                    {{ \Carbon\Carbon::parse($booking->waktu_selesai)->format('d M Y, H:i') }}
                                </div>
                            </td>

                            <td class="py-4 px-5">
                                <div class="flex flex-col items-center gap-2">
                                    @if($booking->bukti_pembayaran)
                                        <button type="button" onclick="openModal('{{ asset('storage/pembayaran/' . $booking->bukti_pembayaran) }}')" class="w-full inline-flex items-center justify-center gap-1.5 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md text-[11px] font-bold hover:bg-blue-600 hover:text-white transition-colors border border-blue-100 hover:border-blue-600 shadow-sm">
                                            <span>👁️</span> Cek Bukti
                                        </button>
                                    @else
                                        <span class="inline-block w-full text-center bg-gray-100 text-gray-400 text-[10px] font-bold px-2 py-1.5 rounded">Belum Ada Bukti</span>
                                    @endif

                                    @if($booking->status_booking === 'aktif' || $booking->status_booking === 'selesai')
                                        <button type="button" onclick="openNotaModal('{{ route('admin.booking.cetak', $booking->id) }}')" class="w-full inline-flex items-center justify-center gap-1.5 bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-md text-[11px] font-bold hover:bg-emerald-600 hover:text-white transition-colors border border-emerald-200 hover:border-emerald-600 shadow-sm">
                                            <span>🧾</span> Lihat Nota
                                        </button>
                                    @endif
                                </div>
                            </td>

                            <td class="py-4 px-5">
                                <span class="badge
                                    {{ $booking->status_booking == 'aktif' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $booking->status_booking == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $booking->status_booking == 'selesai' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $booking->status_booking == 'batal' || $booking->status_booking == 'dibatalkan' ? 'bg-red-100 text-red-800' : '' }}
                                ">{{ ucfirst($booking->status_booking) }}</span>
                            </td>
                            <td class="py-4 px-5">
                                <form action="{{ route('admin.booking.status', $booking->id) }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf @method('PATCH')
                                    <select name="status" class="border border-gray-200 rounded-lg text-[12px] font-sans py-1.5 pl-2 pr-8 focus:border-primary focus:ring-0">
                                        <option value="menunggu" {{ $booking->status_booking == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="aktif" {{ $booking->status_booking == 'aktif' ? 'selected' : '' }}>Aktif (ACC)</option>
                                        <option value="selesai" {{ $booking->status_booking == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $booking->status_booking == 'batal' || $booking->status_booking == 'dibatalkan' ? 'selected' : '' }}>Tolak/Batal</option>
                                    </select>
                                    <button type="submit" class="bg-gray-100 hover:bg-primary hover:text-white text-gray-600 px-3 py-1.5 rounded-md text-[11px] font-bold transition-colors">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-8 text-center text-[13px] text-gray-500">Tidak ada data pesanan ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">{{ $bookings->links() }}</div>
    </div>
</div>
<div id="imageModal" class="fixed inset-0 z-[110] hidden bg-black/80 backdrop-blur-sm items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="relative max-w-2xl w-full flex flex-col items-center transform scale-95 transition-transform duration-300" id="modalContent">
        <button onclick="closeModal()" class="absolute -top-10 right-0 text-white hover:text-red-400 text-3xl font-black transition-colors focus:outline-none">&times;</button>

        <div class="bg-white p-2 rounded-xl shadow-2xl w-full">
            <div class="border border-dashed border-gray-200 rounded-lg overflow-hidden bg-gray-50 flex items-center justify-center min-h-[300px]">
                <img id="modalImage" src="" alt="Bukti Pembayaran" class="max-h-[80vh] w-auto object-contain">
            </div>
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
    // ==========================================
    // FUNGSI UNTUK MODAL BUKTI (YANG DIPERBAIKI)
    // ==========================================
    function openModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalContent = document.getElementById('modalContent');

        modalImg.src = imageSrc;

        // Kunci Perbaikan: Hapus hidden, lalu tambah flex manual via JS
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 20);
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        const modalContent = document.getElementById('modalContent');

        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.getElementById('modalImage').src = '';
        }, 300);
    }

    // ==========================================
    // SCRIPT NOTA MILIKMU (TIDAK DIGANGGU)
    // ==========================================
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

    // Bisa ditutup pakai tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            // Tutup modal apapun yang sedang terbuka
            closeModal();
            closeNotaModal();
        }
    });
</script>
@endsection
