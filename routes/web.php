<?php

use App\Livewire\TransaksiFilter;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\ExportPdfController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/laporan/export-pdf/{tahun}/{bulan?}', [ExportPdfController::class, 'export'])
    ->middleware('auth')
    ->name('laporan.export.pdf');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('manajemen_transaksi', 'transaksi')
    ->middleware(['auth', 'verified'])
    ->name('transaksi');

Route::view('goals', 'goal')
    ->middleware(['auth', 'verified'])
    ->name('goal');

Route::get('transaksi/{filter?}', TransaksiFilter::class)
    ->middleware(['auth', 'verified'])
    ->name('transaksi-filter');

Route::view('category_manager', 'category')
    ->middleware(['auth', 'verified'])
    ->name('category');

Route::view('laporan_keuangan', 'laporan')
    ->middleware(['auth', 'verified'])
    ->name('laporan');

Route::view('konvert_money', 'konversi')
    ->middleware(['auth', 'verified'])
    ->name('konversi');

Route::view('admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
