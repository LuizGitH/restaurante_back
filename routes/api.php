<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\NewPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Dishcontroller;
use App\Http\Controllers\Api\V1\Usercontroller;
use App\Http\Controllers\Api\V1\AuthController;

//rotas que estão no auth.php
Route::middleware('guest')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('/forgot-password',[PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
//Rota públicas -> Cria um Token
//Route::post('/login',[AuthController::class,'login'])->name('login');

// Rotas protegidas
Route::middleware(['auth:sanctum'])->group(function () {

    // Users
    Route::get('/users',[Usercontroller::class,'index'])->name('users.index');
    Route::post('/users',[Usercontroller::class,'store'])->name('users.store');
    Route::get('/users/{user}',[Usercontroller::class,'show'])->name('users.show');
    Route::put('/users/{user}',[Usercontroller::class,'update'])->name('users.update');
    Route::delete('/users/{user}',[Usercontroller::class,'destroy'])->name('users.destroy');

    // Dishes
    Route::get('/dishes',[Dishcontroller::class,'index'])->name('dishes.index');
    Route::post('/dishes',[Dishcontroller::class,'store'])->name('dishes.store');
    Route::get('/dishes/{dish}',[Dishcontroller::class,'show'])->name('dishes.show');
    Route::put('/dishes/{dish}',[Dishcontroller::class,'update'])->name('dishes.update');
    Route::delete('/dishes/{dish}',[Dishcontroller::class,'destroy'])->name('dishes.destroy');
});
