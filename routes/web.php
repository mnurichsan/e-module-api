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
    Route::get('siswa/show/{id}',[\App\Http\Controllers\HomeController::class,'detail_siswa'])->name('siswa.show');
    //list modul
    Route::prefix('modul')->group(function () {
        Route::get('',[\App\Http\Controllers\HomeController::class,'modul'])->name('modul.index');
        Route::get('create',[\App\Http\Controllers\HomeController::class,'tambah_module'])->name('modul.create');
        Route::post('/store',[\App\Http\Controllers\HomeController::class,'store_module'])->name('module.store');
        Route::get('show/{id}',[\App\Http\Controllers\HomeController::class,'detail_module'])->name('modul.show');
        Route::get('edit/{id}',[\App\Http\Controllers\HomeController::class,'edit_module'])->name('modul.edit');
        Route::post('update/{id}',[\App\Http\Controllers\HomeController::class,'update_module'])->name('modul.update');

        Route::get('/detele/{id}',[\App\Http\Controllers\HomeController::class,'delete_module'])->name('modul.delete');

        Route::prefix('material')->group(function () {
            //
        });
    });


});
