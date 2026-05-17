@extends('layouts.admin')

@section('content')
<div class="animate-[fadeIn_0.35s_ease_both]">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-serif text-3xl font-bold text-gray-900 mb-1">Laporan Finansial</h1>
            <p class="text-[13px] text-gray-500">Pantau dan ekspor data transaksi reservasi JemuranKu.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.laporan.cetak', request()->query()) }}" target="_blank" class="px-4 py-2.5 bg-gray-800 text-white rounded-lg text-[13px] font-bold hover:bg-black transition-colors shadow-sm flex items-center gap-2">
                🖨️ Print
            </a>
            <a href="{{ route('admin.laporan.pdf', request()->query()) }}" class="px-4 py-2.5 bg-red-600 text-white rounded-lg text-[13px] font-bold hover:bg-red-700 transition-colors shadow-sm flex items-center gap-2">
                📄 Download PDF
            </a>
            <a href="{{ route('admin.laporan.excel', request()->query()) }}" class="px-4 py-2.5 bg-emerald-600 text-white rounded-lg text-[13px] font-bold hover:bg-emerald-700 transition-colors shadow-sm flex items-center gap-2">
                📊 Export Excel
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-gradient-to-br from-[#0d5c4a] to-[#126b54] rounded-xl p-5 text-white shadow-md relative overflow-hidden">
            <div class="absolute -right-4 -top-4 text-6xl opacity-10">💰</div>
            <div class="text-[11px] font-bold uppercase tracking-widest opacity-80 mb-1">Total Pendapatan (Lunas)</div>
            <div class="text-3xl font-black font-serif tracking-wide">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
            <div class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">Transaksi Sukses (ACC)</div>
            <div class="text-3xl font-black text-gray-800">{{ $transaksi_sukses }} <span class="text-sm font-normal text-gray-400">pesanan</span></div>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative overflow-hidden">
            <div class="text-[11px] font-bold uppercase tracking-widest text-gray-400 mb-1">Total Semua Data</div>
            <div class="text-3xl font-black text-gray-800">{{ $total_transaksi }} <span class="text-sm font-normal text-gray-400">pesanan</span></div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm">
        <form action="{{ route('admin.laporan') }}" method="GET" class="flex flex-wrap items-end gap-4">

            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase mb-1.5">Filter Waktu</label>
                <select name="filter_waktu" id="filter_waktu" class="border-gray-200 rounded-lg text-[13px] py-2.5 focus:border-primary focus:ring-0 w-44 font-semibold text-gray-700">
                    <option value="semua" {{ request('filter_waktu') == 'semua' ? 'selected' : '' }}>Semua Waktu</option>
                    <option value="hari_ini" {{ request('filter_waktu') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="minggu_ini" {{ request('filter_waktu') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="bulan_ini" {{ request('filter_waktu') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="tahun_ini" {{ request('filter_waktu') == 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
                    <option value="custom" {{ request('filter_waktu') == 'custom' ? 'selected' : '' }}>Pilih Manual (Custom)</option>
                </select>
            </div>

            <div id="custom_date_wrapper" class="flex gap-4 {{ request('filter_waktu') == 'custom' ? '' : 'hidden' }}">
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase mb-1.5">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="border-gray-200 rounded-lg text-[13px] py-2.5 focus:border-primary focus:ring-0">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="border-gray-200 rounded-lg text-[13px] py-2.5 focus:border-primary focus:ring-0">
                </div>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase mb-1.5">Status Booking</label>
                <select name="status" class="border-gray-200 rounded-lg text-[13px] py-2.5 focus:border-primary focus:ring-0 w-40 font-semibold text-gray-700">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif (ACC)</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai Lunas</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Bayar</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="flex gap-2 ml-auto">
                <button type="submit" class="bg-primary hover:bg-[#094839] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold transition-colors shadow-sm">Terapkan Filter</button>
                <a href="{{ route('admin.laporan') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2.5 rounded-lg text-[13px] font-bold transition-colors border border-gray-200">Reset Semua</a>
            </div>
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Transaksi / Rak</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nominal Bayar</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporan as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-5">
                                <div class="text-[12px] font-bold text-gray-900">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                                <div class="text-[10px] text-gray-500">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB</div>
                            </td>
                            <td class="py-4 px-5">
                                <div class="text-[12px] font-mono font-bold text-primary">#JMR-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[11px] font-semibold text-gray-500 mt-0.5">Rak: {{ $item->spot->kode_jemuran }}</div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="text-[13px] font-semibold text-gray-800">{{ $item->user->name }}</span>
                            </td>
                            <td class="py-4 px-5">
                                @if(in_array($item->status_booking, ['aktif', 'selesai']))
                                    <span class="text-[13px] font-black text-emerald-600">Rp {{ number_format($item->spot->harga ?? 0, 0, ',', '.') }}</span>
                                @else
                                    <span class="text-[12px] font-bold text-gray-400 line-through">Rp {{ number_format($item->spot->harga ?? 0, 0, ',', '.') }}</span>
                                @endif
                            </td>
                            <td class="py-4 px-5">
                                <span class="badge
                                    {{ $item->status_booking == 'aktif' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $item->status_booking == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $item->status_booking == 'selesai' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ in_array($item->status_booking, ['batal', 'dibatalkan']) ? 'bg-red-100 text-red-800' : '' }}
                                ">{{ strtoupper($item->status_booking) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-12 text-center text-[13px] text-gray-500">Tidak ada data transaksi pada filter yang dipilih.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.getElementById('filter_waktu').addEventListener('change', function() {
        const wrapper = document.getElementById('custom_date_wrapper');
        if (this.value === 'custom') {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    });
</script>
@endsection
