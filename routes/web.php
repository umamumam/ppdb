<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DokumenSiswaController;
use App\Http\Controllers\TahunPelajaranController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'edit']);
});
Route::resource('alumnis', \App\Http\Controllers\AlumniController::class);
Route::post('/alumnis/export', [AlumniController::class, 'export'])->name('alumnis.export');
Route::post('/alumnis/import', [AlumniController::class, 'import'])->name('alumnis.import');
Route::get('/ujian', [UjianController::class, 'index'])->name('ujian.index');
Route::post('/ujian', [UjianController::class, 'store'])->name('ujian.store');
Route::put('/ujian/{id}', [UjianController::class, 'update'])->name('ujian.update');
Route::delete('/ujian/{id}', [UjianController::class, 'destroy'])->name('ujian.destroy');
Route::resource('tahun', TahunPelajaranController::class);
Route::get('ppdb/search', [PpdbController::class, 'search'])->name('ppdb.search');
Route::get('ppdb/{id}/cetak', [PpdbController::class, 'cetak'])->name('ppdb.cetak');
Route::get('/ppdb/{id}/cetak-surat', [PpdbController::class, 'cetakSurat'])->name('ppdb.cetak-surat');
Route::get('/ppdb/{id}/cetak-bukti', [PpdbController::class, 'cetakBuktiPendaftaran'])->name('ppdb.cetak-bukti');
Route::resource('ppdb', PpdbController::class);
Route::get('/get-alumni-data', [PpdbController::class, 'getAlumniData'])->name('ppdb.getAlumniData');
Route::post('/ppdb/export', [PpdbController::class, 'export'])->name('ppdb.export');
Route::post('/ppdb/import', [PpdbController::class, 'import'])->name('ppdb.import');
Route::get('/ppdb/{ppdb_id}/upload-dokumen', [DokumenSiswaController::class, 'showUploadForm'])->name('ppdb.upload-dokumen');
Route::post('/ppdb/{ppdb_id}/upload-dokumen', [DokumenSiswaController::class, 'upload'])->name('ppdb.upload-dokumen.submit');
Route::get('/ppdb/{ppdb_id}/preview-dokumen', [DokumenSiswaController::class, 'previewDokumen'])->name('ppdb.preview-dokumen');
Route::delete('/ppdb/{ppdb_id}/delete-dokumen/{docType}', [DokumenSiswaController::class, 'deleteDokumen'])->name('ppdb.delete-dokumen');
Route::prefix('ppdb/{ppdb_id}/pembayaran')->group(function() {
    Route::get('/', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/{pembayaran}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    Route::put('/{pembayaran}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::delete('/{pembayaran}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
});
Route::get('/petugas', [PetugasController::class, 'index'])->name('petugas.index');
Route::post('/petugas', [PetugasController::class, 'store'])->name('petugas.store');
Route::put('/petugas/{id}', [PetugasController::class, 'update'])->name('petugas.update');
Route::delete('/petugas/{id}', [PetugasController::class, 'destroy'])->name('petugas.destroy');
require __DIR__.'/auth.php';
