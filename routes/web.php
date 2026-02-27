<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Website routes (public pages)
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/courses', [WebsiteController::class, 'courses'])->name('courses');
Route::get('/courses/{slug}', [WebsiteController::class, 'courseDetails'])->name('courses.overview');
Route::get('/expert-connection', [WebsiteController::class, 'expertConnection'])->name('expert.connection');
Route::get('/ai-update', [BlogController::class, 'index'])->name('blog.index');
Route::get('/ai-update/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Course enrollment (requires authentication)
Route::get('/courses/{id}/enroll', [WebsiteController::class, 'showEnrollmentPage'])->name('courses.enroll.page');
Route::post('/courses/{id}/enroll', [WebsiteController::class, 'enroll'])->name('courses.enroll');

// Bootcamp enrollment request (guest users can submit)
Route::post('/bootcamp/enroll', [WebsiteController::class, 'submitBootcampEnrollment'])->name('bootcamp.enroll');

// Common login page for all users
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout.get');

// Student routes (protected by auth and role middleware)
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/courses/{id}', [StudentController::class, 'course'])->name('student.course');
    Route::get('/completed-courses', [StudentController::class, 'completedCourses'])->name('student.completed-courses');
    Route::get('/live-classes', [StudentController::class, 'liveClasses'])->name('student.live-classes');
    Route::post('/lessons/complete', [StudentController::class, 'markLessonComplete'])->name('student.lessons.complete');
    Route::post('/courses/{id}/review', [StudentController::class, 'submitReview'])->name('student.courses.review');
    Route::get('/profile', [StudentController::class, 'profile'])->name('student.profile');
    Route::put('/profile', [StudentController::class, 'updateProfile'])->name('student.profile.update');
    Route::get('/certificate/{courseId}', [CertificateController::class, 'download'])->name('student.certificate.download');
});
