<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Common login page for all users
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
})->name('home');
