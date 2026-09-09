<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\LemariController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\BagianController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AuthController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Routes untuk login/logout tanpa middleware auth
Route::get('/login', [AuthController::class, 'index'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Group route yang harus login (auth middleware)
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/chart', [ChartController::class, 'index'])->name('chart.index');

    // Barang CRUD
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    // Category CRUD
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Ruang CRUD
    Route::get('/ruang', [RuangController::class, 'index'])->name('ruang.index');
    Route::get('/ruang/create', [RuangController::class, 'create'])->name('ruang.create');
    Route::post('/ruang', [RuangController::class, 'store'])->name('ruang.store');
    Route::get('/ruang/{ruang}', [RuangController::class, 'show'])->name('ruang.show');
    Route::get('/ruang/{ruang}/edit', [RuangController::class, 'edit'])->name('ruang.edit');
    Route::put('/ruang/{ruang}', [RuangController::class, 'update'])->name('ruang.update');
    Route::delete('/ruang/{ruang}', [RuangController::class, 'destroy'])->name('ruang.destroy');

    // Lemari CRUD
    Route::get('/lemari', [LemariController::class, 'index'])->name('lemari.index');
    Route::get('/lemari/create', [LemariController::class, 'create'])->name('lemari.create');
    Route::post('/lemari', [LemariController::class, 'store'])->name('lemari.store');
    Route::get('/lemari/{id}', [LemariController::class, 'show'])->name('lemari.show');
    Route::get('/lemari/{id}/edit', [LemariController::class, 'edit'])->name('lemari.edit');
    Route::put('/lemari/{id}', [LemariController::class, 'update'])->name('lemari.update');
    Route::delete('/lemari/{id}', [LemariController::class, 'destroy'])->name('lemari.destroy');

    // Rak CRUD
    Route::get('/rak', [RakController::class, 'index'])->name('rak.index');
    Route::get('/rak/create', [RakController::class, 'create'])->name('rak.create');
    Route::post('/rak', [RakController::class, 'store'])->name('rak.store');
    Route::get('/rak/{id}', [RakController::class, 'show'])->name('rak.show');
    Route::get('/rak/{id}/edit', [RakController::class, 'edit'])->name('rak.edit');
    Route::put('/rak/{id}', [RakController::class, 'update'])->name('rak.update');
    Route::delete('/rak/{id}', [RakController::class, 'destroy'])->name('rak.destroy');

    // Bagian CRUD
    Route::get('/bagian', [BagianController::class, 'index'])->name('bagian.index');
    Route::get('/bagian/create', [BagianController::class, 'create'])->name('bagian.create');
    Route::post('/bagian', [BagianController::class, 'store'])->name('bagian.store');
    Route::get('/bagian/{id}/edit', [BagianController::class, 'edit'])->name('bagian.edit');
    Route::put('/bagian/{id}', [BagianController::class, 'update'])->name('bagian.update');
    Route::delete('/bagian/{id}', [BagianController::class, 'destroy'])->name('bagian.destroy');

    // Barang Keluar (Pengeluaran Barang)
    Route::get('/barangkeluar', [BarangKeluarController::class, 'index'])->name('barangkeluar.index');
    Route::get('/barangkeluar/create', [BarangKeluarController::class, 'create'])->name('barangkeluar.create');
    Route::post('/barangkeluar/store', [BarangKeluarController::class, 'store'])->name('barangkeluar.store');
    Route::delete('/barangkeluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barangkeluar.destroy');

    // Download Barcode
    Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
    Route::get('/download/barcode/{id}', [DownloadController::class, 'download'])->name('download.barcode');

    // Report
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/filter', [ReportController::class, 'filter'])->name('report.filter');
    Route::get('/report/print/{start_date}/{end_date}', [ReportController::class, 'print'])->name('report.print');

    // Scan (bisa diakses admin dan guest, tapi kamu group di auth)
    Route::get('/scan', [ScanController::class, 'index'])->name('scan.index');
    Route::post('/scan/search', [ScanController::class, 'search'])->name('scan.search');

    // AJAX/get dynamic dropdown
    Route::get('/get-lemari', [LemariController::class, 'getByRuang']);
    Route::get('/get-rak', [RakController::class, 'getByLemari']);
    Route::get('/rak/getByRuangDanLemari', [RakController::class, 'getRakByRuangDanLemari'])->name('rak.getByRuangLemari');

    // Peminjaman Barang
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

    // Pengembalian Peminjaman
    Route::get('/peminjaman/pengembalian', [PeminjamanController::class, 'pengembalianForm'])->name('peminjaman.pengembalian.form');
    Route::post('/peminjaman/pengembalian', [PeminjamanController::class, 'pengembalianSubmit'])->name('peminjaman.pengembalian.submit');
    Route::get('/peminjaman/pengembalian/scan', [PeminjamanController::class, 'scanPengembalianForm'])->name('peminjaman.pengembalian.scan');
    Route::post('/peminjaman/pengembalian/scan', [PeminjamanController::class, 'scanPengembalianSubmit'])->name('peminjaman.pengembalian.scan.submit');

    // Backup database
    Route::get('/backup-database', [BackupController::class, 'backup'])->name('backup.database');
});
