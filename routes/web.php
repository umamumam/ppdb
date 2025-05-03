<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\ProfileController;
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
require __DIR__.'/auth.php';
