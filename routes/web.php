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

        Route::prefix('{id}/material')->group(function () {
            Route::get('create',[\App\Http\Controllers\HomeController::class,'tambah_material'])->name('material.create');
            Route::post('post',[\App\Http\Controllers\HomeController::class,'store_material'])->name('material.post');
            Route::get('show/{id_material}',[\App\Http\Controllers\HomeController::class,'edit_material'])->name('material.show');
            Route::post('update/{id_material}',[\App\Http\Controllers\HomeController::class,'update_material'])->name('material.update');
            Route::get('delete/{id_material}',[\App\Http\Controllers\HomeController::class,'delete_material'])->name('material.delete');

            Route::prefix('{id_material}/practice')->group(function () {
                Route::get('create',[\App\Http\Controllers\HomeController::class,'tambah_practice'])->name('practice.create');
                Route::post('post',[\App\Http\Controllers\HomeController::class,'store_practice'])->name('practice.store');
                Route::get('delete/{id_practice}',[\App\Http\Controllers\HomeController::class,'delete_practice'])->name('practice.delete');
            });
        });
    });


});
