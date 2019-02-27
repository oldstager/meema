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
