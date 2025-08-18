<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Dishcontroller;
use App\Http\Controllers\Api\V1\Usercontroller;
use App\Http\Controllers\Api\V1\AuthController;

//Rota públicas
Route::post('/login',[AuthController::class,'login'])->name('login');

// Rotas protegidas
Route::middleware(['auth:sanctum'])->group(function () {

    // Users
    Route::get('/users',[Usercontroller::class,'index'])->name('users.index')->middleware('ability:user-get');
    Route::post('/users',[Usercontroller::class,'store'])->name('users.store');
    Route::get('/users/{user}',[Usercontroller::class,'show'])->name('users.show')->middleware('ability:user-get');
    Route::put('/users/{user}',[Usercontroller::class,'update'])->name('users.update');
    Route::delete('/users/{user}',[Usercontroller::class,'destroy'])->name('users.destroy');

    // Dishes
    Route::get('/dishes',[Dishcontroller::class,'index'])->name('dishes.index');
    Route::post('/dishes',[Dishcontroller::class,'store'])->name('dishes.store');
    Route::get('/dishes/{dish}',[Dishcontroller::class,'show'])->name('dishes.show');
    Route::put('/dishes/{dish}',[Dishcontroller::class,'update'])->name('dishes.update');
    Route::delete('/dishes/{dish}',[Dishcontroller::class,'destroy'])->name('dishes.destroy');
});

//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});
