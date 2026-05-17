<?php

namespace App\Http\Controllers;

use App\Models\Spot;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal dan waktu

class PenggunaController extends Controller
{
    // MENAMPILKAN DASHBOARD UTAMA KATALOG
    public function index()
    {
        $spots = Spot::all();
        return view('pengguna.dashboard', compact('spots'));
    }

    // MENAMPILKAN DETAIL RAK & KALENDER PINTAR
    public function show($id)
    {
        $spot = Spot::findOrFail($id);

        // MEKANISME BARU: Hanya booking dengan status 'aktif' (Sudah di-ACC Admin)
        // yang akan memblokir tanggal di kalender pelanggan lain.
        $bookedDates = Booking::where('spot_id', $id)
            ->where('status_booking', 'aktif')
            ->get(['waktu_mulai', 'waktu_selesai'])
            ->map(function ($booking) {
                return [
                    'from' => Carbon::parse($booking->waktu_mulai)->format('Y-m-d'),
                    'to' => Carbon::parse($booking->waktu_selesai)->format('Y-m-d'),
                ];
            });

        return view('pengguna.detail', compact('spot', 'bookedDates'));
    }

    // MEMPROSES RESERVASI AWAL (Mengunci Jam Server Secara Real-Time WIB)
    public function store(Request $request)
    {
        $request->validate([
            'spot_id' => 'required|exists:spots,id',
            'waktu_mulai' => 'required', // Menerima input tanggal bersih dari Flatpickr
        ]);

        // 1. Ambil tanggal saja dari inputan form (Format: Y-m-d)
        $tanggal_dipilih = Carbon::parse($request->waktu_mulai)->format('Y-m-d');

        // 2. GABUNGKAN tanggal tersebut dengan JAM, MENIT, dan DETIK saat ini (Real-time Server WIB)
        $waktu_mulai = Carbon::parse($tanggal_dipilih . ' ' . now()->format('H:i:s'));

        // 3. Waktu selesai otomatis bertambah 2 hari persis di jam yang sama
        $waktu_selesai = $waktu_mulai->copy()->addDays(2);

        // 4. CEK BENTROK JADWAL (Hanya divalidasi silang dengan pesanan yang berstatus 'aktif')
        $isConflict = Booking::where('spot_id', $request->spot_id)
            ->where('status_booking', 'aktif')
            ->where(function ($query) use ($waktu_mulai, $waktu_selesai) {
                $query->whereBetween('waktu_mulai', [$waktu_mulai, $waktu_selesai])
                      ->orWhereBetween('waktu_selesai', [$waktu_mulai, $waktu_selesai])
                      ->orWhere(function ($q) use ($waktu_mulai, $waktu_selesai) {
                          $q->where('waktu_mulai', '<=', $waktu_mulai)
                            ->where('waktu_selesai', '>=', $waktu_selesai);
                      });
            })->exists();

        if ($isConflict) {
            return back()->withErrors(['waktu_mulai' => 'Maaf, slot waktu pada tanggal tersebut baru saja di-ACC untuk pelanggan lain. Silakan pilih tanggal senggang lainnya!']);
        }

        // 5. Simpan data reservasi dengan status default 'menunggu'
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'spot_id' => $request->spot_id,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'status_booking' => 'menunggu',
        ]);

        return redirect()->route('pengguna.katalog.success', $booking->id);
    }

    // PROSES UNTUK UPLOAD BUKTI TRANSFER DARI HALAMAN NOTA TRANSAKSI
    public function uploadBukti(Request $request, $id)
    {
        $booking = Booking::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('bukti_pembayaran');

        // 1. Ambil nama asli file
        $nama_asli = $file->getClientOriginalName();
        // 2. BERSIHKAN SPASI: Ubah semua spasi di nama file menjadi garis bawah (_)
        $nama_bersih = str_replace(' ', '_', $nama_asli);
        // 3. Gabungkan dengan waktu agar unik
        $nama_file = time() . '_bayar_' . $nama_bersih;

        $file->storeAs('pembayaran', $nama_file, 'public');

        $booking->update([
            'bukti_pembayaran' => $nama_file
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Harap tunggu verifikasi dan ACC dari Admin.');
    }

    // MENAMPILKAN HALAMAN NOTA DETAIL TRANSAKSI / TIKET RESMI
    public function success($id)
    {
        $booking = Booking::with('spot')->findOrFail($id);

        // Proteksi Keamanan: Pastikan nota ini hanya bisa dilihat oleh si pemilik pesanan
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('pengguna.success', compact('booking'));
    }

    // MENAMPILKAN TABEL RIWAYAT RESERVASI MILIK PENGGUNA YANG LOGIN
    public function history()
    {
        $riwayat = Booking::with('spot')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

        return view('pengguna.history', compact('riwayat'));
    }

    // MENAMPILKAN HALAMAN PANDUAN PENGGUNAAN SISTEM
    public function panduan()
    {
        return view('pengguna.panduan');
    }

    // MEMBATALKAN / MENGHAPUS PESANAN YANG BELUM DI-ACC ADMIN
    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->firstOrFail();

        // Keamanan ketat: Hanya pesanan berstatus 'menunggu' yang boleh dibatalkan mandiri
        if ($booking->status_booking !== 'menunggu') {
            return back()->with('error', 'Hanya pesanan dengan status menunggu yang dapat dihapus.');
        }

        $booking->delete();

        return back()->with('success', 'Pesanan Anda telah berhasil dihapus permanen.');
    }



    public function cetakNota($id)
    {
        $booking = Booking::with('spot')->where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Proteksi: Hanya boleh cetak jika sudah di-ACC
        if ($booking->status_booking !== 'aktif' && $booking->status_booking !== 'selesai') {
            abort(403, 'Nota belum tersedia. Menunggu verifikasi Admin.');
        }

        return view('cetak-nota', compact('booking'));
    }
}
