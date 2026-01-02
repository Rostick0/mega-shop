<?php

use App\Modules\Product\Presentation\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.')
    ->middleware('api')
    ->group(function () {
        Route::apiResource('products', ProductController::class)->only('index', 'show');
    });
