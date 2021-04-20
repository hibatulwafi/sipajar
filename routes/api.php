<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Buat Wajib Pajak
Route::post('/login', 'ApiServiceController@login');
Route::post('/editprofile', 'ApiServiceController@editprofile');
Route::post('/cekpassword', 'ApiServiceController@cekpassword');
Route::post('/objekpajak','ApiServiceController@objekpajak');

Route::get('/tagihan/{id}','ApiServiceController@tagihan');
Route::post('/caritagihan','ApiServiceController@caritagihan');
Route::get('/tagihanop/{op}/{wp}','ApiServiceController@tagihanop');

Route::post('/uploadimage', 'ApiServiceController@uploadImage');
Route::post('/uploadImageDet', 'ApiServiceController@uploadImageDet');

//Route::get('/statuslaporan/{id}', 'ApiServiceController@statuslaporan');
Route::post('/statuslaporan', 'ApiServiceController@statuslaporan');
Route::post('/caristatuslaporan', 'ApiServiceController@caristatuslaporan');

Route::post('/kirimpesan', 'ApiServiceController@kirimpesan');
Route::post('/kirimpesankeluar', 'ApiServiceController@kirimpesankeluar');
Route::get('/pesanmasuk/{id}', 'ApiServiceController@pesanmasuk');
Route::get('/pesankeluar/{id}', 'ApiServiceController@pesankeluar');
Route::post('/caripesan', 'ApiServiceController@caripesan');
Route::post('/caripesankeluar', 'ApiServiceController@caripesankeluar');

// Surveyor

Route::get('/s-ceklaporan','ApiServiceControllerSurveyor@ceklaporan');
Route::get('/s-riwayatsurvey/{id}','ApiServiceControllerSurveyor@riwayatsurvey');
Route::get('/s-statuslaporan/{id}','ApiServiceControllerSurveyor@detailstatuslaporan');

Route::get('/s-wajibpajak','ApiServiceControllerSurveyor@wajibpajak');
Route::get('/s-cariwajibpajak/{qry}','ApiServiceControllerSurveyor@cariwajibpajak');
Route::get('/s-wajibpajak/{id}','ApiServiceControllerSurveyor@detailwajibpajak');

Route::get('/s-objekpajak','ApiServiceControllerSurveyor@objekpajak');
Route::get('/s-cariobjekpajak/{id}','ApiServiceControllerSurveyor@cariobjekpajak');
Route::get('/s-objekpajak/{id}','ApiServiceControllerSurveyor@detailobjekpajak');

Route::post('/s-cekpassword', 'ApiServiceControllerSurveyor@cekpassword');
Route::post('/s-login', 'ApiServiceControllerSurveyor@login');
Route::post('/s-editprofile', 'ApiServiceControllerSurveyor@editprofile');
Route::post('/s-validasi', 'ApiServiceControllerSurveyor@validasilaporan');
Route::post('/s-upload', 'ApiServiceControllerSurveyor@uploadImage');
Route::get('/s-log/{id}', 'ApiServiceControllerSurveyor@log');

/*
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=sipajar
DB_USERNAME=postgres
DB_PASSWORD=123456

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pajakair
DB_USERNAME=root
DB_PASSWORD=
*/
