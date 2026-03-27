<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TicketsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {
    Route::post('login',[AuthController::class, 'login']);
    Route::post('register',[AuthController::class, 'register']);

    Route::middleware(['auth:api'])->group(function () {
        Route::apiResource('ticket',TicketsController::class);
        Route::apiResource('categories',CategoriesController::class);
    });
});
