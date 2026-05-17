@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">
    
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-serif text-3xl font-bold text-gray-900 mb-1">Manajemen Booking</h1>
            <p class="text-[13px] text-gray-500">Kelola reservasi, verifikasi pembayaran, dan cetak laporan.</p>
        </div>
        <a href="{{ route('admin.booking.pdf', request()->query()) }}" class="btn-primary !w-auto !py-2.5 !text-[13px] bg-red-600 hover:bg-red-700">
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
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Bukti Bayar</th>
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
                            
                            <td class="py-4 px-5 text-center">
                                @if($booking->bukti_pembayaran)
                                    <a href="{{ asset('storage/pembayaran/' . $booking->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center justify-center gap-1 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-md text-[11px] font-bold hover:bg-blue-600 hover:text-white transition-colors border border-blue-100 hover:border-blue-600 shadow-sm">
                                        <span>👁️</span> Lihat Foto
                                    </a>
                                @else
                                    <span class="inline-block bg-gray-100 text-gray-400 text-[10px] font-bold px-2 py-1 rounded">Belum Upload</span>
                                @endif
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
                                    @csrf
                                    @method('PATCH')
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
@endsection