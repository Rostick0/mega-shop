<?php

use App\Modules\Auth\Presentation\Http\Controllers\AuthController;
use App\Modules\Product\Presentation\Http\Controllers\ProductController;
// use App\Modules\Auth\Presentation\Http\Controllers\AuthController;
use App\Modules\User\Presentation\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.')
    ->middleware('api')
    ->group(function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/login', [AuthController::class, 'login'])
            // ->middleware('throttle:5,1')
            ;
            Route::post('/register', [AuthController::class, 'register']);
            // Route::post('/login-from-admin', [AuthController::class, 'loginFromAdmin']);

            // 'middleware' => 'jwt'
            // 'middleware' => 'auth:api'
            Route::group([], function () {
                Route::post('/logout', [AuthController::class, 'logout']);
                Route::post('/refresh', [AuthController::class, 'refresh']);
                Route::get('/me', [AuthController::class, 'me']);
            });
        });

        Route::apiResource('users', UserController::class)->except('store');
        Route::apiResource('products', ProductController::class)->only('index', 'show');
    });
