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

// --- Public Routes (ไม่ต้องล็อกอิน) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Protected Routes (ต้องล็อกอินผ่าน Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // User Profile & Logout
    Route::get('/profile', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // [เจ้าหน้าที่] Staff Routes
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/dashboard', fn() => response()->json(['message' => 'Staff Dashboard']));
        Route::get('/users', [UserController::class, 'index']);
        
        // การจัดการคำขอสหกรณ์สำหรับ Staff
        Route::prefix('cooperatives')->group(function () {
            Route::get('/', [CooperativeController::class, 'indexAll']);
            Route::put('/{id}/review', [CooperativeController::class, 'review']);
        });
    });

    // [ประชาชน] Public Routes
    Route::middleware('role:public')->group(function () {
        Route::get('/public/dashboard', fn() => response()->json(['message' => 'Public Dashboard']));
        
        // การยื่นคำขอสหกรณ์สำหรับประชาชน
        Route::prefix('cooperatives')->group(function () {
            Route::get('/', [CooperativeController::class, 'index']);
            Route::post('/', [CooperativeController::class, 'store']);
        });
    });
});
