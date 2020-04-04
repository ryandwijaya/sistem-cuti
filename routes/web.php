<?php

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

Route::get('/','backend\PegawaiController@index');


//Route::get('/kepala/cuti/pengajuan','backend\PegawaiController@index');


Route::post('/cuti/ajukan','backend\CutiController@ajukan');





Route::group(['prefix'=>'backend'],function(){
    Route::resource('pegawai','backend\PegawaiController');
    Route::get('/cuti/pengajuan','backend\CutiController@pengajuan');
    Route::get('/cuti/riwayat','backend\CutiController@riwayat');
    Route::get('/cuti/detail','backend\CutiController@detail');
    Route::get('/cuti/cancel/{id}','backend\CutiController@cancel');
    Route::get('/cuti/selesai/{id}','backend\CutiController@selesai');
    Route::get('/cuti/aksi/{id}/{param}','backend\CutiController@aksi');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
