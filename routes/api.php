<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ModuleController;
use App\Http\Controllers\API\ProfileController;
use App\Models\LearningMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    //profile
    Route::prefix('profile')->group(function(){
        Route::get('me',[ProfileController::class,'me']);
        Route::post('update',[ProfileController::class,'updateProfile']);
        Route::post('update-password',[ProfileController::class,'resetPassword']);
    });

     Route::prefix('module')->group(function(){

        //get list module
        Route::get('list',[ModuleController::class,'index']);

        Route::prefix('material')->group(function(){
            Route::get('list/{id}',[ModuleController::class,'listMaterialById']);
            Route::get('/{id}',[ModuleController::class,'showMaterialById']);
        });


        Route::prefix('practice')->group(function(){
            //get list quiz bersarkan id material
            Route::get('list/{id}',[ModuleController::class,'listQuizlById']);

            //post jawaban quiz
            Route::post('answer',[ModuleController::class,'storeAnswer']);
            //get list quiz siswa dan scorenya

            Route::get('progress',[ModuleController::class,'progressStudent']);

        });

    });
});
