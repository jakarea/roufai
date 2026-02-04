<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Common login page for all users
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Student routes (protected by auth and role middleware)
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/courses/{id}', [StudentController::class, 'course'])->name('student.course');
    Route::post('/lessons/complete', [StudentController::class, 'markLessonComplete'])->name('student.lessons.complete');
    Route::post('/courses/{id}/review', [StudentController::class, 'submitReview'])->name('student.courses.review');
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
});

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
})->name('home');
