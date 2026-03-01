<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Website routes (public pages)
Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/courses', [WebsiteController::class, 'courses'])->name('courses');
Route::get('/courses/{slug}', [WebsiteController::class, 'courseDetails'])->name('courses.overview');
Route::get('/expert-connection', [WebsiteController::class, 'expertConnection'])->name('expert.connection');
Route::get('/terms', [WebsiteController::class, 'terms'])->name('terms');
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

// Student registration
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

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
    Route::put('/password', [StudentController::class, 'updatePassword'])->name('student.password.update');
    Route::get('/certificate/{courseId}', [CertificateController::class, 'download'])->name('student.certificate.download');
});

// Storage link route (for server setup)
Route::get('/create-storage-link/{key}', function ($key) {
    // Simple key protection - you can change this key
    if ($key !== 'roufai') {
        return response('Invalid key', 403);
    }

    try {
        // Check if link already exists
        if (file_exists(public_path('storage'))) {
            return response('Storage link already exists!', 200);
        }

        // Create the storage link
        Artisan::call('storage:link');
        return response('Storage link created successfully! You can now access this page to delete this route.');
    } catch (\Exception $e) {
        return response('Error creating storage link: ' . $e->getMessage(), 500);
    }
})->name('storage.link');

// Fix permissions route (for server setup - run this if you get 403 after login)
Route::get('/fix-permissions/{key}', function ($key) {
    if ($key !== 'roufai') {
        return response('Invalid key', 403);
    }

    try {
        // Fix storage permissions
        exec('chmod -R 775 storage/');
        exec('chmod -R 775 bootstrap/cache/');

        // Recreate storage link properly
        if (is_link(public_path('storage'))) {
            unlink(public_path('storage'));
        }
        symlink('../storage/app/public', public_path('storage'));

        // Clear all caches
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return response('✅ Permissions fixed! Storage link recreated. <a href="/login">Try logging in now</a>');
    } catch (\Exception $e) {
        return response('❌ Error: ' . $e->getMessage(), 500);
    }
})->name('fix.permissions');

// Debug route to check authentication status
Route::get('/debug-auth', function () {
    $output = [];

    // Check authentication
    $output['Authenticated'] = auth()->check() ? 'Yes' : 'No';

    if (auth()->check()) {
        $user = auth()->user();
        $output['User ID'] = $user->id;
        $output['Email'] = $user->email;
        $output['Role'] = $user->role;
        $output['Name'] = $user->name;
    }

    // Check session
    $output['Session ID'] = session()->getId();
    $output['Session Driver'] = config('session.driver');

    // Check storage link
    $output['Storage Link Exists'] = file_exists(public_path('storage')) ? 'Yes' : 'No';
    if (file_exists(public_path('storage'))) {
        $output['Storage Link Type'] = is_link(public_path('storage')) ? 'Symlink ✅' : 'Not a symlink ❌';
        $output['Storage Link Target'] = readlink(public_path('storage'));
    }

    // Check permissions
    $output['Storage Writable'] = is_writable(storage_path()) ? 'Yes' : 'No';
    $output['Sessions Writable'] = is_writable(storage_path('framework')) ? 'Yes' : 'No';

    // Environment
    $output['APP_ENV'] = config('app.env');
    $output['APP_URL'] = config('app.url');

    return response()->json($output, 200, [], JSON_PRETTY_PRINT);
})->name('debug.auth');

// Test instructor panel access
Route::get('/test-instructor-access', function () {
    if (!auth()->check()) {
        return response('Not authenticated', 401);
    }

    if (auth()->user()->role !== 'instructor') {
        return response('Not an instructor', 403);
    }

    return response('✅ Instructor access OK! You should be able to access /instructor');
})->middleware('auth');