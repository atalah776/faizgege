<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Spot;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal dan waktu

class AdminController extends Controller
{
    // ==========================================
    // DASHBOARD & MANAJEMEN BOOKING
    // ==========================================

    // Menampilkan Dashboard Admin (Ringkasan)
    public function index()
    {
        $totalRak = Spot::count();
        $bookingAktif = Booking::whereIn('status_booking', ['menunggu', 'aktif'])->count();
        // Mengambil 5 booking terbaru untuk tabel ringkasan
        $recentBookings = Booking::with(['user', 'spot'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalRak', 'bookingAktif', 'recentBookings'));
    }

    // Menampilkan Halaman Manajemen Booking Lengkap + Filter
    public function bookingManagement(Request $request)
    {
        $query = Booking::with(['user', 'spot'])->latest();

        // Logika Filter Status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_booking', $request->status);
        }

        // Logika Filter Tanggal
        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('waktu_mulai', [$request->tgl_mulai, $request->tgl_selesai . ' 23:59:59']);
        }

        // Menambahkan parameter request ke pagination agar filter tidak hilang saat pindah halaman
        $bookings = $query->paginate(10)->appends($request->all());

        return view('admin.booking', compact('bookings'));
    }

    // Export PDF untuk Manajemen Booking (Data Sederhana)
    public function exportPdf(Request $request)
    {
        $query = Booking::with(['user', 'spot'])->latest();

        // Terapkan filter yang sama agar PDF sesuai dengan tabel yang sedang dilihat
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_booking', $request->status);
        }
        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('waktu_mulai', [$request->tgl_mulai, $request->tgl_selesai . ' 23:59:59']);
        }

        $bookings = $query->get(); // Ambil semua data tanpa pagination untuk PDF

        // Load view khusus PDF
        $pdf = Pdf::loadView('admin.pdf.booking', compact('bookings'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Data_Booking_JemuranKu.pdf');
    }

    // Fungsi CRUD: Mengubah Status Booking & Verifikasi Pembayaran
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status_booking' => $request->status
        ]);

        return back()->with('success', 'Status booking berhasil diperbarui!');
    }

    // FUNGSI UNTUK CETAK NOTA / INVOICE SATUAN
    public function cetakNota($id)
    {
        $booking = Booking::with(['user', 'spot'])->findOrFail($id);
        return view('cetak-nota', compact('booking'));
    }


    // ==========================================
    // CRUD DATA MASTER: RAK JEMURAN
    // ==========================================

    public function indexRak()
    {
        $spots = Spot::latest()->get();
        return view('admin.rak.index', compact('spots'));
    }

    public function showRak($id)
    {
        $spot = Spot::findOrFail($id);
        return view('admin.rak.detail', compact('spot'));
    }

    public function createRak()
    {
        return view('admin.rak.form');
    }

    public function storeRak(Request $request)
    {
        $request->validate([
            'harga' => 'required|numeric',
            'kode_jemuran' => 'required|unique:spots',
            'kapasitas' => 'required',
            'status_ketersediaan' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        // Loop untuk memproses 3 foto sekaligus
        $foto_fields = ['foto', 'foto_2', 'foto_3'];
        foreach ($foto_fields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $nama_file = time() . '_' . $field . '_' . $file->getClientOriginalName();
                $file->storeAs('rak', $nama_file, 'public');
                $data[$field] = $nama_file;
            }
        }

        Spot::create($data);
        return redirect()->route('admin.rak.index')->with('success', 'Rak Jemuran berhasil ditambahkan!');
    }

    public function editRak($id)
    {
        $spot = Spot::findOrFail($id);
        return view('admin.rak.form', compact('spot'));
    }

    public function updateRak(Request $request, $id)
    {
        $spot = Spot::findOrFail($id);

        $request->validate([
            'harga' => 'required|numeric',
            'kode_jemuran' => 'required|unique:spots,kode_jemuran,' . $spot->id,
            'kapasitas' => 'required',
            'status_ketersediaan' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except(['foto', 'foto_2', 'foto_3']);

        $foto_fields = ['foto', 'foto_2', 'foto_3'];
        foreach ($foto_fields as $field) {
            if ($request->hasFile($field)) {

                // Hapus foto lama
                if ($spot->$field && Storage::exists('public/rak/' . $spot->$field)) {
                    Storage::delete('public/rak/' . $spot->$field);
                }

                $file = $request->file($field);
                $nama_file = time() . '_' . $field . '_' . $file->getClientOriginalName();
                $file->storeAs('rak', $nama_file, 'public');
                $data[$field] = $nama_file;
            }
        }

        $spot->update($data);

        return redirect()->route('admin.rak.index')->with('success', 'Data Rak berhasil diperbarui!');
    }

    public function destroyRak($id)
    {
        $spot = Spot::findOrFail($id);

        // Hapus file foto dari storage saat rak dihapus
        if ($spot->foto && Storage::exists('public/rak/' . $spot->foto)) {
            Storage::delete('public/rak/' . $spot->foto);
        }

        $spot->delete();
        return back()->with('success', 'Rak Jemuran berhasil dihapus!');
    }


    // ==========================================
    // SISTEM LAPORAN ENTERPRISE (FINANSIAL & TRX)
    // ==========================================

    // FUNGSI ASISTEN: LOGIKA FILTER CERDAS
    private function applyLaporanFilters($query, $request)
    {
        if ($request->filled('status') && $request->status != 'semua') {
            $query->where('status_booking', $request->status);
        }

        $filter_waktu = $request->input('filter_waktu', 'semua');

        if ($filter_waktu == 'hari_ini') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter_waktu == 'minggu_ini') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter_waktu == 'bulan_ini') {
            $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter_waktu == 'tahun_ini') {
            $query->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter_waktu == 'custom' && $request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('created_at', [$request->tgl_mulai . ' 00:00:00', $request->tgl_selesai . ' 23:59:59']);
        }

        return $query;
    }

    // 1. TAMPILAN HALAMAN UTAMA LAPORAN
    public function laporanIndex(Request $request)
    {
        $query = Booking::with(['user', 'spot']);

        // Terapkan Filter
        $query = $this->applyLaporanFilters($query, $request);

        // Ambil data terbaru
        $laporan = $query->latest()->get();

        // Kalkulasi Statistik
        $total_pendapatan = $laporan->whereIn('status_booking', ['aktif', 'selesai'])->sum(function($b) { return $b->spot->harga ?? 0; });
        $total_transaksi = $laporan->count();
        $transaksi_sukses = $laporan->whereIn('status_booking', ['aktif', 'selesai'])->count();

        return view('admin.laporan.index', compact('laporan', 'total_pendapatan', 'total_transaksi', 'transaksi_sukses'));
    }

    // 2. EXPORT: CETAK PRINTER
    public function laporanCetak(Request $request)
    {
        $query = Booking::with(['user', 'spot']);
        $query = $this->applyLaporanFilters($query, $request);

        $laporan = $query->orderBy('created_at', 'asc')->get();
        $total_pendapatan = $laporan->whereIn('status_booking', ['aktif', 'selesai'])->sum(function($b) { return $b->spot->harga ?? 0; });

        return view('admin.laporan.cetak', compact('laporan', 'total_pendapatan'));
    }

    // 3. EXPORT: DOWNLOAD PDF (Menggunakan library DomPDF)
    public function laporanPdf(Request $request)
    {
        $query = Booking::with(['user', 'spot']);
        $query = $this->applyLaporanFilters($query, $request);

        $laporan = $query->orderBy('created_at', 'asc')->get();
        $total_pendapatan = $laporan->whereIn('status_booking', ['aktif', 'selesai'])->sum(function($b) { return $b->spot->harga ?? 0; });

        $pdf = Pdf::loadView('admin.laporan.cetak', compact('laporan', 'total_pendapatan'))
                   ->setPaper('a4', 'landscape');

        return $pdf->download('Laporan_JemuranKu_' . date('Y-m-d') . '.pdf');
    }

    // 4. EXPORT: DOWNLOAD EXCEL (NATIVE CSV)
    public function laporanExcel(Request $request)
    {
        $query = Booking::with(['user', 'spot']);
        $query = $this->applyLaporanFilters($query, $request);

        $laporan = $query->orderBy('created_at', 'asc')->get();

        $fileName = 'Laporan_Keuangan_JemuranKu_' . date('Ymd_His') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID Transaksi', 'Tgl Dibuat', 'Nama Pelanggan', 'Rak Disewa', 'Jadwal Mulai', 'Jadwal Selesai', 'Status', 'Nominal Tagihan (Rp)'];

        $callback = function() use($laporan, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns); // Tulis Header

            foreach ($laporan as $item) {
                $row['ID Transaksi'] = 'JMR-' . str_pad($item->id, 4, '0', STR_PAD_LEFT);
                $row['Tgl Dibuat']   = Carbon::parse($item->created_at)->format('Y-m-d H:i');
                $row['Nama Pelanggan'] = $item->user->name;
                $row['Rak Disewa']   = $item->spot->kode_jemuran;
                $row['Jadwal Mulai'] = Carbon::parse($item->waktu_mulai)->format('Y-m-d H:i');
                $row['Jadwal Selesai'] = Carbon::parse($item->waktu_selesai)->format('Y-m-d H:i');
                $row['Status']       = strtoupper($item->status_booking);
                $row['Nominal Tagihan (Rp)'] = in_array($item->status_booking, ['aktif', 'selesai']) ? ($item->spot->harga ?? 0) : 0;

                fputcsv($file, array($row['ID Transaksi'], $row['Tgl Dibuat'], $row['Nama Pelanggan'], $row['Rak Disewa'], $row['Jadwal Mulai'], $row['Jadwal Selesai'], $row['Status'], $row['Nominal Tagihan (Rp)']));
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
