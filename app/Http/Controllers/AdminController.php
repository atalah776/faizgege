<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Spot;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Menampilkan Dashboard Admin (Ringkasan)
    public function index()
    {
        $totalRak = Spot::count();
        $bookingAktif = Booking::whereIn('status_booking', ['menunggu', 'aktif'])->count();
        // Mengambil 5 booking terbaru untuk tabel ringkasan
        $recentBookings = Booking::with(['user', 'spot'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalRak', 'bookingAktif', 'recentBookings'));
    }

    public function showRak($id)
    {
        $spot = Spot::findOrFail($id);
        return view('admin.rak.detail', compact('spot'));
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

    // Export PDF
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
        
        // Atur ukuran kertas ke Landscape
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Transaksi_JemuranKu.pdf');
    }

    // Fungsi CRUD: Mengubah Status Booking
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status_booking' => $request->status
        ]);

        return back()->with('success', 'Status booking berhasil diperbarui!');
    }

    // CRUD DATA MASTER: RAK JEMURAN

    public function indexRak()
    {
        $spots = Spot::latest()->get();
        return view('admin.rak.index', compact('spots'));
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

        // AMAN: Ambil semua data KECUALI file foto. 
        // Kenapa? Agar kalau Admin tidak upload foto, data fotonya tidak berubah jadi kosong (null).
        $data = $request->except(['foto', 'foto_2', 'foto_3']);

        $foto_fields = ['foto', 'foto_2', 'foto_3'];
        foreach ($foto_fields as $field) {
            // Jika ada file foto BARU yang diunggah untuk kolom tersebut:
            if ($request->hasFile($field)) {
                
                // 1. Hapus foto lama di folder (agar storage tidak penuh)
                if ($spot->$field && \Illuminate\Support\Facades\Storage::exists('public/rak/' . $spot->$field)) {
                    \Illuminate\Support\Facades\Storage::delete('public/rak/' . $spot->$field);
                }

                // 2. Simpan foto baru
                $file = $request->file($field);
                $nama_file = time() . '_' . $field . '_' . $file->getClientOriginalName();
                $file->storeAs('rak', $nama_file, 'public');
                
                // 3. Masukkan nama file baru ke dalam array data untuk di-update ke DB
                $data[$field] = $nama_file;
            }
        }

        $spot->update($data);

        return redirect()->route('admin.rak.index')->with('success', 'Data Rak berhasil diperbarui!');
    }

    public function destroyRak($id)
    {
        $spot = Spot::findOrFail($id);
        
        // Opsional: Hapus file foto dari storage saat rak dihapus
        if ($spot->foto && Storage::exists('public/rak/' . $spot->foto)) {
            Storage::delete('public/rak/' . $spot->foto);
        }

        $spot->delete();
        return back()->with('success', 'Rak Jemuran berhasil dihapus!');
    }
}