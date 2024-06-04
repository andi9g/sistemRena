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

Route::get("/", "HomeController@umum");
Route::get("login", "Auth\LoginController@showLoginForm");
Route::post("login", "Auth\LoginController@login")->name("login");

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'HomeController@index');

    Route::middleware(['gerbangAdmin'])->group(function () {

        Route::resource('ketuart', "ketuartC");
        Route::post("resetpassword/{iduser}/ketuart", "ketuartC@resetpassword")->name("resetpassword.ketuart");

        //logout
        Route::post("logout", "Auth\LoginController@logout")->name("logout");
        //profil
        Route::get('profil', "profilC@index");
        Route::post('profil/ubahnama', "profilC@ubahnama")->name("ubah.nama");
        Route::post('profil/ubahpassword', "profilC@ubahpassword")->name("ubah.password");
        Route::post('profil/ubahgambar', "profilC@ubahgambar")->name("ubah.gambar");


        Route::resource("warga", "wargaC");
        Route::resource("pemasukan", "pemasukanC");
        Route::resource("kas", "kasC");
        Route::resource("tambahan", "tambahanC");
        Route::resource("pengeluaran", "pengeluaranC");
    });

    Route::middleware(['gerbangKetuaRT'])->group(function () {
        Route::get("laporan", "laporanC@index");
        Route::get("cetak/laporan", "laporanC@cetak")->name("cetak.laporan");
    });


});




// Route::get('pdf', 'startController@pdf');

// Route::get('siswa/export/', 'startController@export');



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
