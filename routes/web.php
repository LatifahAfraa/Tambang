<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PointController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $data['title'] = 'Login';
    return view('login',$data);
})->name('login');

Route::post('login','HomeController@auth');

Route::middleware('admin')->prefix('admin')->group(function ()
{
    Route::get('/', 'HomeController@index')->name('admin');
    Route::resource('barang','BarangController');
    Route::resource('satuan','SatuanController');
    Route::resource('member','MemberController');
    Route::resource('setting','SettingController');



    Route::resource('tujuan','TujuanController');

    Route::resource('operator','OperatorController');

    //checkin
    Route::resource('adminAb','AdminAbController');
    Route::get('/member_select', 'AdminAbController@select_member')->name('member.select');
    Route::get('/kendaraan_select', 'AdminAbController@select_kendaraan')->name('kendaraan.select');

    Route::resource('kendaraan','KendaraanController');

    Route::post('member-point/{id}','MemberController@point')->name('member.point');
    Route::get('member-status/{id}/{value}','MemberController@status')->name('member.status');
    Route::get('transaksi-cek/{id}', 'TransaksiController@cek')->name('transaksi.cek');
    Route::put('transaksi-ceks/{id}', 'TransaksiController@ceks')->name('transaksi.ceks');
    Route::get('transaksi-harian', 'TransaksiController@hari')->name('transaksi.hari');
    Route::get('transaksi-bulanan', 'TransaksiController@bulan')->name('transaksi.bulan');
    Route::get('transaksi-tahunan', 'TransaksiController@tahun')->name('transaksi.tahun');

    //laporan
    route::get("laporan-perpelanggan", [LaporanController::class, 'index'])->name("laporan.perpelanggan");
    route::get("cetak-perpelanggan", [LaporanController::class, 'cetak_perpelanggan'])->name("cetak.perpelanggan");
    route::get("excel-perpelanggan", [LaporanController::class, 'excel_perpelanggan'])->name("excel.perpelanggan");
    route::get("laporan-barang-perpelanggan", [LaporanController::class, 'barang_perpelanggan'])->name("laporan.barang.perpelanggan");
    route::get("cetak-barang-perpelanggan", [LaporanController::class, 'cetak_barang_perpelanggan'])->name("cetak.barang.perpelanggan");
    route::get("excel-barang-perpelanggan", [LaporanController::class, 'excel_barang_perpelanggan'])->name("excel.barang.perpelanggan");
    route::get("laporan-perbarang", [LaporanController::class, 'perbarang'])->name("laporan.perbarang");
    route::get("cetak-perbarang", [LaporanController::class, 'cetak_perbarang'])->name("cetak.perbarang");
    route::get("excel-perbarang", [LaporanController::class, 'excel_perbarang'])->name("excel.perbarang");

    //Point Sopir
    route::get('point-sopir', [PointController::class,'index'])->name('point.sopir');


    Route::get('member_tampil', 'MemberController@member')->name('tampil.member');
    Route::get('delete', 'MemberController@destroy_member')->name('hapus.member');
});

Route::middleware('operator')->prefix('operator')->group(function ()
{
    Route::get('/', 'HomeController@indexOperator')->name('home.index');
    Route::resource('transaksi','TransaksiController');
    Route::get('transaksi-complete/{id}', 'TransaksiController@complete')->name('transaksi.complete');
    Route::put('transaksi-completes/{id}', 'TransaksiController@completeTransaksi')->name('transaksi.completes');
    Route::get('transaksi-status/{id}/{value}', 'TransaksiController@status')->name('transaksi.status');

    //checkout
    Route::get('checkout-op', [CheckoutController::class, 'index_op'])->name('checkout.op');
    Route::get('checkout/{id}/{value}',[CheckoutController::class, 'status'])->name('checkout.status');
    Route::get('checkout-ket/{id}',[CheckoutController::class, 'show'])->name('checkout.show');
    Route::put('checkout-kete/{id}',[CheckoutController::class, 'ket'])->name('checkout.ket');



});

Route::middleware('operator2')->prefix('operator2')->group(function ()
{
    Route::get('/', 'HomeController@indexOperator2')->name('home.index2');

    //checkin
    Route::get('adminAb-op2','AdminAbController@index_op2')->name('adminAb.index.op2');
    Route::get('create_op2','AdminAbController@create_op2')->name('adminAb.create.op2');
    Route::post('store_op2','AdminAbController@store_op2')->name('adminAb.store.op2');
    Route::get('/member_select_op2', 'AdminAbController@select_member')->name('member.select.op2');
    Route::get('/kendaraan_select_op2', 'AdminAbController@select_kendaraan')->name('kendaraan.select.op2');


    Route::get('transaksi-op2','TransaksiController@index_op2')->name('transaksi.index.op2');
    Route::get('transaksi-edit-op2','TransaksiController@edit')->name('transaksi.edit.op2');
    Route::put('transaksi-update-op2','TransaksiController@update')->name('transaksi.update.op2');


    Route::get('transaksi-complete_op2/{id}', 'TransaksiController@complete_op2')->name('transaksi.complete.op2');
    Route::put('transaksi-completes_op2  /{id}', 'TransaksiController@completeTransaksi_op2')->name('transaksi.completes.op2');
    Route::get('transaksi-status/{id}/{value}', 'TransaksiController@status')->name('transaksi.status.op2');
});

//grafik
Route::get('grafik', [GrafikController::class, 'index'])->name('grafik');

Route::get('/logout', 'HomeController@logout')->name('logout');

// Urgent
// Route::get('qr', 'HomeController@qr');
