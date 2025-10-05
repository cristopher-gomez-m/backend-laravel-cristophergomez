<?php

use App\Http\Middleware\JwtMiddlware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\AtencionController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'store']);

    /*
    Route::group(['middleware' => ['jwt.verify']],function(){
        Route::get('clientes',[ClienteController::class,'index']);
    });
    */
    Route::middleware([JwtMiddlware::class])->group(function () {
        Route::get('/clientes', [ClienteController::class, 'index']);
        Route::get('/clientes/{id}', [ClienteController::class, 'getById']);
        Route::post('/clientes', [ClienteController::class, 'store']);
        Route::put('/clientes/{id}', [ClienteController::class, 'update']);
        Route::delete('/clientes/{id}', [ClienteController::class, 'destroy']);

        Route::get('/citas', [CitaController::class, 'index']);
        Route::get('/citas/{id}', [CitaController::class, 'getById']);
        Route::post('/citas', [CitaController::class, 'store']);
        Route::put('/citas/{id}', [CitaController::class, 'update']);
        Route::delete('/citas/{id}', [CitaController::class, 'destroy']);

        Route::get('/atenciones', [AtencionController::class, 'index']);
        Route::get('/atenciones/{id}', [AtencionController::class, 'getById']);
        Route::post('/atenciones', [AtencionController::class, 'store']);
        Route::put('/atenciones/{id}', [AtencionController::class, 'update']);
        Route::delete('/atenciones/{id}', [AtencionController::class, 'destroy']);
    });
});
