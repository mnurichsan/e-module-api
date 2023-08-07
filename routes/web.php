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

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false,'reset' => false]);

Route::middleware(['auth','is.admin','web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //list siswa
    Route::get('siswa',[\App\Http\Controllers\HomeController::class,'siswa'])->name('siswa.index');
    Route::get('siswa/{id}',[\App\Http\Controllers\HomeController::class,'detail_siswa'])->name('siswa.show');
    //list modul
    Route::get('modul',[\App\Http\Controllers\HomeController::class,'modul'])->name('modul.index');
    Route::get('modul/{id}',[\App\Http\Controllers\HomeController::class,'detail_module'])->name('modul.show');

});
