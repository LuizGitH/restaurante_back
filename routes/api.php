<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DishController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AuthController;

Route::post('login', [AuthController::class, 'login']);

// Rotas protegidas
Route::middleware(['auth:sanctum'])->group(function () {

    // Users
    Route::apiResource('user', UserController::class);

    // Dishes
    Route::apiResource('dish',DishController::class);
});
