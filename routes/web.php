<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('auth.login');
});

// --- BAGIAN YANG DIMODIFIKASI (Pengatur Lalu Lintas) ---
Route::get('/dashboard', function () {
    $role = request()->user()->role;

    if ($role === 'admin') {
        return redirect('/admin/dashboard');
    } else {
        return redirect('/pengguna/dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// --- BAGIAN YANG DITAMBAHKAN (Rute Masing-masing Dashboard) ---
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/booking/cetak/{id}', [App\Http\Controllers\AdminController::class, 'cetakNota'])->name('admin.booking.cetak');
    Route::get('/booking', [AdminController::class, 'bookingManagement'])->name('admin.booking');
    Route::get('/booking/export-pdf', [AdminController::class, 'exportPdf'])->name('admin.booking.pdf');
    Route::patch('/booking/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.booking.status');
    Route::get('/rak', [AdminController::class, 'indexRak'])->name('admin.rak.index');
    Route::get('/rak/tambah', [AdminController::class, 'createRak'])->name('admin.rak.create');
    Route::post('/rak', [AdminController::class, 'storeRak'])->name('admin.rak.store');
    Route::get('/admin/rak/{id}/detail', [AdminController::class, 'showRak'])->name('admin.rak.show');
    Route::get('/rak/{id}/edit', [AdminController::class, 'editRak'])->name('admin.rak.edit');
    Route::put('/rak/{id}', [AdminController::class, 'updateRak'])->name('admin.rak.update');
    Route::delete('/rak/{id}', [AdminController::class, 'destroyRak'])->name('admin.rak.destroy');

   // RUTE MENU LAPORAN ADMIN
Route::get('/admin/laporan', [App\Http\Controllers\AdminController::class, 'laporanIndex'])->name('admin.laporan');
Route::get('/admin/laporan/cetak', [App\Http\Controllers\AdminController::class, 'laporanCetak'])->name('admin.laporan.cetak');
Route::get('/admin/laporan/pdf', [App\Http\Controllers\AdminController::class, 'laporanPdf'])->name('admin.laporan.pdf');
Route::get('/admin/laporan/excel', [App\Http\Controllers\AdminController::class, 'laporanExcel'])->name('admin.laporan.excel');

});

Route::get('/pengguna/dashboard', [PenggunaController::class, 'index'])->middleware(['auth']);
Route::get('/pengguna/katalog/{id}', [PenggunaController::class, 'show'])->middleware(['auth'])->name('pengguna.katalog.detail');
Route::get('/pengguna/katalog/cetak/{id}', [App\Http\Controllers\PenggunaController::class, 'cetakNota'])->name('pengguna.katalog.cetak');
Route::post('/pengguna/katalog/pesan', [PenggunaController::class, 'store'])->middleware(['auth'])->name('pengguna.katalog.store');
Route::post('/pengguna/katalog/bayar/{id}', [App\Http\Controllers\PenggunaController::class, 'uploadBukti'])->name('pengguna.katalog.bayar');
Route::get('/pengguna/katalog/tiket/{id}', [PenggunaController::class, 'success'])->middleware(['auth'])->name('pengguna.katalog.success');
Route::get('/pengguna/riwayat', [PenggunaController::class, 'history'])->middleware(['auth'])->name('pengguna.riwayat');
Route::get('/pengguna/panduan', [PenggunaController::class, 'panduan'])->middleware(['auth'])->name('pengguna.panduan');
Route::delete('/pengguna/riwayat/{id}/cancel', [PenggunaController::class, 'cancel'])->name('pengguna.riwayat.cancel');

// --- BAGIAN YANG DIPERTAHANKAN (Bawaan Breeze) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
