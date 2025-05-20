<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware(['checkRole:admin'])->group(function () {
    Route::resource('/users', App\Http\Controllers\UsersController::class);    
    Route::resource('/pelanggans', App\Http\Controllers\PelanggansController::class);
});

Route::middleware(['checkRole:karyawan'])->group(function () {
});

Route::middleware(['checkRole:apoteker'])->group(function () {
    Route::resource('/pembelian', App\Http\Controllers\PembelianController::class);
    Route::resource('/distributor', App\Http\Controllers\DistributorController::class);
    Route::post('/obat/update-margin', [App\Http\Controllers\ObatController::class, 'updateMargin'])->name('obat.updateMargin');
    Route::resource('/jenis', App\Http\Controllers\JenisObatController::class);
     Route::get('/obat/create', [App\Http\Controllers\ObatController::class, 'create'])->name('obat.create');
    Route::post('/obat', [App\Http\Controllers\ObatController::class, 'store'])->name('obat.store');
    Route::delete('/obat/{obat}', [App\Http\Controllers\ObatController::class, 'destroy'])->name('obat.destroy');

});

Route::middleware(['checkRole:kasir'])->group(function () {
    
});

Route::middleware(['checkRole:pemilik'])->group(function () {
    Route::get('/export/penjualan/excel', [App\Http\Controllers\PenjualanController::class, 'exportExcel'])->name('penjualan.export.excel');
    Route::get('/export/penjualan/pdf', [App\Http\Controllers\PenjualanController::class, 'exportPdf'])->name('penjualan.export.pdf');
    Route::get('/laporan/penjualan', [App\Http\Controllers\PenjualanController::class, 'laporanIndex'])->name('laporan.penjualan.index');

    Route::get('/laporan/pembelian', [App\Http\Controllers\PembelianController::class, 'LaporanIndex'])->name('laporan.pembelian.index');
    Route::get('/laporan/pembelian/excel', action: [App\Http\Controllers\PembelianController::class, 'exportExcel'])->name('pembelian.export.excel');
    Route::get('/laporan/pembelian/pdf', [App\Http\Controllers\PembelianController::class, 'exportPdf'])->name('pembelian.export.pdf');

    Route::get('/laporan/pelanggan', [App\Http\Controllers\PelanggansController::class, 'LaporanIndex'])->name('laporan.pelanggan.index');
    Route::get('/laporan/pelanggan/excel', [App\Http\Controllers\PelanggansController::class, 'exportExcel'])->name('pelanggan.export.excel');  
    Route::get('/laporan/pelanggan/pdf', [App\Http\Controllers\PelanggansController::class, 'exportPdf'])->name('pelanggan.export.pdf');
});

Route::middleware(['checkRole:kurir'])->group(function () {
    Route::resource('jenis-kirim', App\Http\Controllers\JenisPengirimanController::class);
    Route::get('pengiriman',[App\Http\Controllers\PengirimanController::class, 'index'])->name('pengiriman.index');
    Route::post('/pengiriman/ubah-status', [App\Http\Controllers\PengirimanController::class, 'ubahStatus'])->name('pengiriman.ubahStatus');
    Route::post('/pengiriman', [App\Http\Controllers\PengirimanController::class, 'store'])->name('pengiriman.store');



});

Route::middleware(['checkRole:karyawan,apoteker,kasir'])->group(function () {
     Route::get('/obat', [App\Http\Controllers\ObatController::class, 'index'])->name('obat.index');
    Route::get('/obat/{obat}', [App\Http\Controllers\ObatController::class, 'show'])->name('obat.show');
    Route::get('/obat/{obat}/edit', [App\Http\Controllers\ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/{obat}', [App\Http\Controllers\ObatController::class, 'update'])->name('obat.update');
});

Route::middleware(['checkRole:kasir,karyawan'])->group(function () {
    Route::get('/penjualan', [App\Http\Controllers\PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/{id}', [App\Http\Controllers\PenjualanController::class, 'show']);
    Route::put('/penjualan/update-status/{id}', [App\Http\Controllers\PenjualanController::class, 'updateStatus'])->name('penjualan.updateStatus');
});

Route::middleware(['checkAuth'])->group(function () {
    Route::resource('/dashboard', App\Http\Controllers\DashboardController::class);
});

Route::get('/auth-management', [App\Http\Controllers\AuthManagementController::class, 'index'])->name('auth-management.index');
Route::post('/register-management', [App\Http\Controllers\AuthManagementController::class, 'register'])->name('auth-management.register');
Route::post('/login-management', [App\Http\Controllers\AuthManagementController::class, 'login'])->name('auth-management.login');
Route::post('/logout-management', [App\Http\Controllers\AuthManagementController::class, 'logout'])->name('auth-management.logout');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::resource('/about', App\Http\Controllers\AboutController::class);
Route::resource('/contact', App\Http\Controllers\ContactController::class);
Route::get('/login', [App\Http\Controllers\AuthPelangganController::class, 'getLogin'])->name('getLogin.pelanggan');
Route::get('/register', [App\Http\Controllers\AuthPelangganController::class, 'getRegister'])->name('getRegister.pelanggan');

Route::post('/register', [App\Http\Controllers\AuthPelangganController::class, 'postRegister'])->name('postRegister.pelanggan');
Route::post('/login', [App\Http\Controllers\AuthPelangganController::class, 'postLogin'])->name('postLogin.pelanggan');
Route::post('/logout-pelanggan', [App\Http\Controllers\AuthPelangganController::class, 'logout'])->name('logout.pelanggan');

Route::get('/produk', [App\Http\Controllers\ProductController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('produk.show');

Route::middleware(['checkAuthPelanggan'])->group(function () {
    Route::resource('/profile', App\Http\Controllers\ProfilePelangganController::class);
    Route::get('/keranjang', [App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [App\Http\Controllers\KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/update', [App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
    Route::post('/keranjang/update-item', [App\Http\Controllers\KeranjangController::class, 'updateItem'])->name('keranjang.updateItem');

    Route::get('/keranjang/hapus/{id}', [App\Http\Controllers\KeranjangController::class, 'hapus'])->name('keranjang.hapus');

    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout.post');
    Route::get('/checkout/sukses/{id}', [App\Http\Controllers\CheckoutController::class, 'sukses'])->name('checkout.sukses');
    Route::get('/checkout/pending/{id}', [App\Http\Controllers\CheckoutController::class, 'pending'])->name('checkout.pending');

    Route::get('/pesanan', [App\Http\Controllers\PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/update-status/{id}', [App\Http\Controllers\PesananController::class, 'updateStatus'])->name('pesanan.update-status');
    Route::get('/pesanan/finish', [App\Http\Controllers\PesananController::class, 'finish'])->name('pesanan.finish');
    Route::delete('/pesanan/{id}/batal', [App\Http\Controllers\PesananController::class, 'batalkanPesanan'])->name('pesanan.batalkan');
    Route::post('/pesanan/bermasalah/{id}', [App\Http\Controllers\PesananController::class, 'bermasalah'])->name('pesanan.bermasalah');
    Route::patch('/pesanan/{id}/selesai', [App\Http\Controllers\PesananController::class, 'selesaikan'])->name('pesanan.selesai');
});
