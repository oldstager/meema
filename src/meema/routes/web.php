<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index');
Route::get('/staf', 'StafController@index');

// Admin
//
// Prodi
Route::get('/admin/prodi', 'AdmCrudProdiController@index');
Route::get('/admin/prodi/tambah', 'AdmCrudProdiController@tambah');
Route::post('/admin/prodi/simpan', 'AdmCrudProdiController@simpan');
Route::get('/admin/prodi/edit/{kode_prodi}', 'AdmCrudProdiController@edit');
Route::put('/admin/prodi/update/{kode_prodi}', 'AdmCrudProdiController@update');
Route::get('/admin/prodi/hapus/{kode_prodi}', 'AdmCrudProdiController@hapus');
Route::get('/admin/prodi/showPaginate', 'AdmCrudProdiController@showPaginate');
// Ruangan
Route::get('/admin/ruangan', 'AdmCrudRuanganController@index');
Route::get('/admin/ruangan/tambah', 'AdmCrudRuanganController@tambah');
Route::post('/admin/ruangan/simpan', 'AdmCrudRuanganController@simpan');
Route::get('/admin/ruangan/edit/{kode_ruangan}', 'AdmCrudRuanganController@edit');
Route::put('/admin/ruangan/update/{kode_ruangan}', 'AdmCrudRuanganController@update');
Route::get('/admin/ruangan/hapus/{kode_ruangan}', 'AdmCrudRuanganController@hapus');
Route::get('/admin/ruangan/showPaginate', 'AdmCrudRuanganController@showPaginate');
// Rapat
Route::get('/admin/rapat', 'AdmCrudRapatController@index');
Route::get('/admin/rapat/tambah', 'AdmCrudRapatController@tambah');
Route::post('/admin/rapat/simpan', 'AdmCrudRapatController@simpan');
Route::get('/admin/rapat/edit/{kode_rapat}', 'AdmCrudRapatController@edit');
Route::put('/admin/rapat/update/{kode_rapat}', 'AdmCrudRapatController@update');
Route::get('/admin/rapat/hapus/{kode_rapat}', 'AdmCrudRapatController@hapus');
Route::get('/admin/rapat/showPaginate', 'AdmCrudRapatController@showPaginate');
// Users
Route::get('/admin/user', 'AdmCrudUserController@index');
Route::get('/admin/user/tambah', 'AdmCrudUserController@tambah');
Route::post('/admin/user/simpan', 'AdmCrudUserController@simpan');
Route::get('/admin/user/edit/{nidn}', 'AdmCrudUserController@edit');
Route::put('/admin/user/update/{nidn}', 'AdmCrudUserController@update');
Route::get('/admin/user/hapus/{nidn}', 'AdmCrudUserController@hapus');
Route::get('/admin/user/showPaginate', 'AdmCrudUserController@showPaginate');
// Notulensi
Route::get('/admin/notulensi', 'AdmCrudNotulensiController@index');
Route::get('/admin/notulensi/tambah', 'AdmCrudNotulensiController@tambah');
Route::post('/admin/notulensi/simpan', 'AdmCrudNotulensiController@simpan');
Route::get('/admin/notulensi/hapus/{id_notulensi}', 'AdmCrudNotulensiController@hapus');
