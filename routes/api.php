<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TeacherProfileController;
use App\Http\Controllers\Api\StudentProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Sanctum Token Auth (Teacher & Student only)
|--------------------------------------------------------------------------
|
| All routes here are prefixed with /api automatically.
| Protected routes require:  Authorization: Bearer <token>
|
*/

// ── Public: Get a Sanctum Token ───────────────────────────────────────────────
Route::post('/login',  [AuthApiController::class, 'login']);

// ── Protected: Require valid Sanctum token ────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Shared logout (works for both teacher & student)
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // ── Teacher Profile ───────────────────────────────────────────────────────
    Route::prefix('teacher')->group(function () {
        Route::get   ('profile',          [TeacherProfileController::class, 'show']);
        Route::put   ('profile',          [TeacherProfileController::class, 'update']);
        Route::put   ('profile/password', [TeacherProfileController::class, 'changePassword']);
        Route::delete('profile',          [TeacherProfileController::class, 'destroy']);
    });

    // ── Student Profile ───────────────────────────────────────────────────────
    Route::prefix('student')->group(function () {
        Route::get   ('profile',          [StudentProfileController::class, 'show']);
        Route::put   ('profile',          [StudentProfileController::class, 'update']);
        Route::put   ('profile/password', [StudentProfileController::class, 'changePassword']);
        Route::delete('profile',          [StudentProfileController::class, 'destroy']);
    });

});
