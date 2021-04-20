<?php

Route::get('/', function () {
return redirect('login');
});


Route::get('chart', function () {
return view('test.chart');
});

Route::get('izinakses', function () {
return view('izinakses');
})->name('izinakses');

Route::namespace('Auth')->group(function() {
Route::get('/login', 'NativeLoginController@loginform')->name('login');
Route::post('/loginpost', 'NativeLoginController@login')->name('loginpost');
Route::post('/logout', 'NativeLoginController@logout')->name('logout');
});
  Route::middleware(['auth:login'])->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    //coba
    Route::get('/detail', 'HomeController@total_ram_cpu_usage')->name('home');

    Route::get('/simulasi', 'HomeController@simulasi')->name('simulasi');
    Route::post('/simulasi', 'HomeController@simulasipost')->name('simulasipost');
  
      Route::middleware(['admin'])->group(function() {
        Route::resource('pengguna', 'UserController');
        Route::resource('kota', 'KotaController');
        Route::resource('kelurahan', 'KelurahanController');
        Route::resource('kecamatan', 'KecamatanController');
        Route::resource('hab', 'HABController');
        Route::resource('sda', 'SDAController');
        Route::resource('peruntukan', 'PeruntukanController');
      });

   
   // Route::resource('jenis', 'JenisController');
    Route::resource('wajibpajak', 'WajibPajakController');
    Route::get('resetpassword/{wajibpajak}','WajibPajakController@resetpassword')->name('wajibpajak.resetpassword');
    Route::resource('objekpajak', 'ObjekPajakController');
    //Route::resource('surveyor', 'SurveyorController');
    Route::get('detailop/{objekpajak}/detail', 'ObjekPajakController@detail')->name('objekpajak.detail');

    Route::get('/laporan', 'LaporanController@index')->name('laporan.index');
    Route::get('/cetaklaporan', 'LaporanController@index')->name('cetak.laporan');
    Route::get('/tolak/{id}', 'LaporanController@tolak')->name('laporan.tolak');
    Route::post('/terima', 'LaporanController@terima')->name('laporan.terima');
    Route::get('/hitung/{id}', 'LaporanController@hitung')->name('laporan.hitung');
    Route::get('/cetak/laporan', 'CetakController@index')->name('cetak.laporan');
    Route::post('/cetak/laporan', 'CetakController@cetak')->name('cetak.laporan');

    Route::get('/belumlapor', 'LaporanController@belumlapor')->name('laporan.belumlapor');

    // Tanpa Meteran
    Route::get('/generate/{id}', 'LaporanController@hitungtanpameter')->name('laporan.generate');
    Route::get('/nonmeter', 'LaporanController@nonmeter')->name('laporan.nonmeter');
    Route::get('/nmtagihan/{id}/{total}/{pajak}/{volume}', 'LaporanController@nmtagihan')->name('laporan.nmtagihan');
    // Dengan Meteran

    Route::get('/tagihan', 'TagihanController@index')->name('tagihan.index');
    Route::get('/tagihanlunas/{pg_id}', 'TagihanController@lunas')->name('tagihan.lunas');

    Route::get('/hitungtagihan/{id}', 'TagihanController@hitung')->name('hitungtagihan');
    Route::get('/addtagihan/{id}/{total}/{pajak}/{volume}/{wp_id}/{pg_id}', 'TagihanController@addtagihan')->name('tagihan.addtagihan');
    Route::get('/detail/{id}/{pg_id}', 'TagihanController@detail')->name('laporan.detail');

    Route::get('/kirimpesan', 'PesanController@form')->name('kirimpesan');
    Route::post('/kirimpesan', 'PesanController@kirimpesan')->name('kirimpesan');
    Route::get('/inbox', 'PesanController@inbox')->name('inbox');
    Route::get('/outbox', 'PesanController@outbox')->name('outbox');
    Route::get('/trash', 'PesanController@trash')->name('trash');
    Route::get('/delete/{id}', 'PesanController@delete')->name('delete');
    Route::get('/everdelete/{id}', 'PesanController@everdelete')->name('everdelete');


});