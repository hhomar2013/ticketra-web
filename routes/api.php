<?php

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\V1\TicketsController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return json_decode('{"test": "test"}');
});
Route::post('/v1/assets/collect', [AssetController::class, 'collect']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/user', function () {
    return '{"user": "test"}';
});

Route::middleware('auth:sanctum')->post('/logout', [LoginController::class, 'logout']); //logout route
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tickets', [TicketsController::class, 'show']);   //tickets show route
    Route::post('/tickets', [TicketsController::class, 'store']); //tickets store route
});                                                           //protected routes
