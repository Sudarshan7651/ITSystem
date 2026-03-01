<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\Auth\StudentAuthController;
use App\Http\Controllers\TeacherProfileController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\SubjectController;
use Illuminate\Support\Facades\Route;

// ─── Home
Route::get('/', function () {
    return view('welcome');
});

// ─── Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest-only (not logged in)
    Route::middleware('guest')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });

    // Authenticated admin only
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // ── CRUD Resources ──
        Route::resource('colleges',    CollegeController::class)->except(['show']);
        Route::resource('departments', DepartmentController::class)->except(['show']);
        Route::resource('teachers',    TeacherController::class)->except(['show']);
        Route::resource('courses',     CourseController::class)->except(['show']);
        Route::resource('subjects',    SubjectController::class)->except(['show']);
    });

});



// ─── Teacher Routes
Route::prefix('teacher')->name('teacher.')->group(function () {

    // Guest-only (not logged in)
    Route::middleware('guest')->group(function () {
        Route::get('login',    [TeacherAuthController::class, 'showLogin'])->name('login');
        Route::post('login',   [TeacherAuthController::class, 'login']);
    });
    // Authenticated teacher only
    Route::middleware(['auth', 'teacher'])->group(function () {
        Route::get  ('dashboard',        [TeacherAuthController::class,   'dashboard'])->name('dashboard');
        Route::post ('logout',           [TeacherAuthController::class,   'logout'])->name('logout');
        // Profile
        Route::get  ('profile',          [TeacherProfileController::class, 'show'])->name('profile');
        Route::patch('profile',          [TeacherProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/password', [TeacherProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('profile',         [TeacherProfileController::class, 'destroy'])->name('profile.destroy');
    });

});


// ─── Student Routes
Route::prefix('student')->name('student.')->group(function () {

    // Guest-only (not logged in)
    Route::middleware('guest')->group(function () {
        Route::get('login',    [StudentAuthController::class, 'showLogin'])->name('login');
        Route::post('login',   [StudentAuthController::class, 'login']);
        Route::get('register', [StudentAuthController::class, 'showRegister'])->name('register');
        Route::post('register',[StudentAuthController::class, 'register']);
    });
    // Authenticated + approved student only
    Route::middleware(['auth', 'student'])->group(function () {
        Route::get  ('dashboard',        [StudentAuthController::class,   'dashboard'])->name('dashboard');
        Route::post ('logout',           [StudentAuthController::class,   'logout'])->name('logout');
        // Profile
        Route::get  ('profile',          [StudentProfileController::class, 'show'])->name('profile');
        Route::patch('profile',          [StudentProfileController::class, 'update'])->name('profile.update');
        Route::patch('profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.password');
        Route::delete('profile',         [StudentProfileController::class, 'destroy'])->name('profile.destroy');
    });

});
