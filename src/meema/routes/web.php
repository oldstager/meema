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
