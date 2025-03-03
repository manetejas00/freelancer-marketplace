<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Dashboard API
    Route::get('/dashboard', function (Request $request) {
        return response()->json([
            'message' => 'Welcome, ' . $request->user()->name . '!',
            'user' => $request->user()
        ]);
    });

    // Profile API
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);

    // Jobs API
    Route::post('/jobs/create', [JobController::class, 'createJob']);
    Route::get('/jobs', [JobController::class, 'getJobs']);
});
