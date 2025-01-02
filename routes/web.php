<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\GedungAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\RiwayatAdminController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PenyewaanAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingPage');
})->name('home');

Route::get('/dashboard', [AuthenticatedSessionController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/daftarGedung', [GedungController::class, 'index'])->name('customer.gedung');
Route::get('/daftarGedung/{id}', [GedungController::class, 'show'])->name('customer.show');

Route::get('/gedung', [GedungAdminController::class, 'index'])->name('gedung.index');
Route::get('/gedung/{id}', [GedungAdminController::class, 'show'])->name('gedung.show');

Route::get('/gedung/{id}/edit', [GedungAdminController::class, 'edit'])->name('gedungs.edit');
Route::put('/gedung/{id}', [GedungAdminController::class, 'update'])->name('gedungs.update');
Route::post('/gedung/delete', [GedungAdminController::class, 'destroy'])->name('gedung.delete');

// Route::get('/gedung/created', [GedungController::class, '#'])->name('gedungs.buat');
Route::get('/gedungs/created', [GedungAdminController::class, 'create'])->name('gedungs.create');
// Route::get('/test', [GedungController::class, 'create']);

Route::get('/penyewaan/pending', [PenyewaanAdminController::class, 'pending'])->name('penyewaan.pending');
Route::post('/penyewaan/update-status', [PenyewaanAdminController::class, 'updateStatus'])->name('penyewaan.updateStatus');
Route::get('/gedung/{id}/jadwal-sewa', [PenyewaanController::class, 'showSewa']);
Route::post('/penyewaan/store', [PenyewaanController::class, 'store'])->name('penyewaan.store');
Route::post('/penyewaan/edit', [PenyewaanController::class, 'update'])->name('penyewaan.update');
Route::post('/penyewaan/delete', [PenyewaanController::class, 'batalkan'])->name('penyewaan.destroy');
Route::get('/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.customer');

Route::get('/riwayat-penyewaan', [RiwayatAdminController::class, 'index'])->name('riwayat.admin');
Route::get('/riwayatPenyewaan', [RiwayatController::class, 'index'])->name('riwayat.customer');

Route::post('/gedung', [GedungAdminController::class, 'store'])->name('gedungs.store');
Route::post('logout-admin', [AdminController::class, 'logout'])
    ->name('logout.admin');

require __DIR__ . '/auth.php';
