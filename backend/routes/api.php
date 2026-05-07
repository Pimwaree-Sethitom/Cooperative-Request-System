<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CooperativeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Public Routes ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Protected Routes ---
Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);

    // Staff Routes
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        
        // การจัดการคำขอสหกรณ์สำหรับ Staff
        Route::prefix('cooperatives')->group(function () {
            Route::get('/', [CooperativeController::class, 'indexAll']);
            Route::put('/{id}/review', [CooperativeController::class, 'review']);
        });
    });

    // Public Routes
    Route::middleware('role:public')->group(function () {
        
        // การยื่นคำขอสหกรณ์สำหรับประชาชน
        Route::prefix('cooperatives')->group(function () {
            Route::get('/', [CooperativeController::class, 'index']);
            Route::post('/', [CooperativeController::class, 'store']);
        });
    });
});
