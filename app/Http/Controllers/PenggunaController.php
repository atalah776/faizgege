<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal dan waktu

class PenggunaController extends Controller
{
    public function index()
    {
        $spots = Spot::all();
        return view('pengguna.dashboard', compact('spots'));
    }

    public function show($id)
    {
        $spot = Spot::findOrFail($id);

        // TARIK DATA JADWAL YANG SUDAH TERBOOKING (Aktif/Menunggu)
        // Format diubah ke bentuk array 'from' & 'to' agar langsung dibaca Flatpickr Kalender
        $bookedDates = Booking::where('spot_id', $id)
            ->whereIn('status_booking', ['menunggu', 'aktif'])
            ->get(['waktu_mulai', 'waktu_selesai'])
            ->map(function ($booking) {
                return [
                    'from' => Carbon::parse($booking->waktu_mulai)->format('Y-m-d'),
                    'to' => Carbon::parse($booking->waktu_selesai)->format('Y-m-d'),
                ];
            });

        return view('pengguna.detail', compact('spot', 'bookedDates'));
    }

    // FUNGSI BOOKING AWAL (Mengunci Jam Server Secara Real-Time)
    public function store(Request $request)
    {
        $request->validate([
            'spot_id' => 'required|exists:spots,id',
            'waktu_mulai' => 'required|date', // Validasi date standar
        ]);

        // 1. Ambil tanggal saja dari inputan Flatpickr (Format: Y-m-d)
        $tanggal_dipilih = \Carbon\Carbon::parse($request->waktu_mulai)->format('Y-m-d');
        
        // 2. GABUNGKAN tanggal tersebut dengan JAM, MENIT, dan DETIK saat ini juga (Real-time Server)
        $waktu_mulai = \Carbon\Carbon::parse($tanggal_dipilih . ' ' . now()->format('H:i:s')); 
        
        // 3. Waktu selesai otomatis bertambah 2 hari persis (mengunci jam yang sama)
        $waktu_selesai = $waktu_mulai->copy()->addDays(2);

        // 4. CEK BENTROK JADWAL (Proteksi Ganda)
        $isConflict = Booking::where('spot_id', $request->spot_id)
            ->whereIn('status_booking', ['menunggu', 'aktif'])
            ->where(function ($query) use ($waktu_mulai, $waktu_selesai) {
                $query->whereBetween('waktu_mulai', [$waktu_mulai, $waktu_selesai])
                      ->orWhereBetween('waktu_selesai', [$waktu_mulai, $waktu_selesai])
                      ->orWhere(function ($q) use ($waktu_mulai, $waktu_selesai) {
                          $q->where('waktu_mulai', '<=', $waktu_mulai)
                            ->where('waktu_selesai', '>=', $waktu_selesai);
                      });
            })->exists();

        if ($isConflict) {
            return back()->withErrors(['waktu_mulai' => 'Maaf, slot waktu pada tanggal tersebut sudah terisi. Silakan pilih tanggal lain!']);
        }

        // 5. Simpan ke Database
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'spot_id' => $request->spot_id,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'status_booking' => 'menunggu', 
        ]);

        return redirect()->route('pengguna.katalog.success', $booking->id);
    }

    // FUNGSI BARU UNTUK UPLOAD BUKTI DARI HALAMAN TRANSAKSI
    public function uploadBukti(Request $request, $id)
    {
        $booking = Booking::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('bukti_pembayaran');
        $nama_file = time() . '_bayar_' . $file->getClientOriginalName();
        $file->storeAs('pembayaran', $nama_file, 'public'); 

        $booking->update([
            'bukti_pembayaran' => $nama_file
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Harap tunggu verifikasi dari Admin.');
    }

    // FUNGSI UNTUK MENAMPILKAN TIKET
    public function success($id)
    {
        // Tarik data booking beserta relasi jemurannya
        $booking = Booking::with('spot')->findOrFail($id);
        
        // Keamanan: Pastikan tiket ini hanya bisa dilihat oleh si pemesan asli
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('pengguna.success', compact('booking'));
    }

    // FUNGSI UNTUK MENAMPILKAN RIWAYAT BOOKING PENGGUNA
    public function history()
    {
        // Tarik data booking yang HANYA milik user yang sedang login
        $riwayat = Booking::with('spot')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();
                    
        return view('pengguna.history', compact('riwayat'));
    }

    // FUNGSI UNTUK MENAMPILKAN HALAMAN PANDUAN
    public function panduan()
    {
        return view('pengguna.panduan');
    }

    public function cancel($id)
    {
        // Cari booking milik user yang sedang login
        $booking = Booking::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        // Keamanan: Hanya izinkan hapus jika statusnya masih 'menunggu'
        // Jika sudah 'aktif' atau 'selesai', tidak boleh dihapus agar tidak merusak laporan finansial/admin
        if ($booking->status_booking !== 'menunggu') {
            return back()->with('error', 'Hanya pesanan dengan status menunggu yang dapat dihapus.');
        }

        // Hapus permanen dari database
        $booking->delete();

        return back()->with('success', 'Pesanan Anda telah berhasil dihapus permanen.');
    }
}