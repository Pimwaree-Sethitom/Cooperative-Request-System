<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

// Routes สำหรับ Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes ที่ต้องล็อกอินก่อนถึงจะเข้าได้
Route::middleware('auth:sanctum')->group(function () {
    
    // 1. ดูโปรไฟล์ตัวเอง และ Logout (ทำได้ทุก Role)
    Route::get('/profile', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // 2. กลุ่มเส้นทางสำหรับ "เจ้าหน้าที่" (Staff) เท่านั้น
    Route::middleware('role:staff')->group(function () {
        Route::get('/staff/dashboard', function () {
            return response()->json(['message' => 'ยินดีต้อนรับเจ้าหน้าที่']);
        });
        
        // ดูคำขอทั้งหมด และทำการ Review
        Route::get('/staff/cooperatives', [\App\Http\Controllers\Api\CooperativeController::class, 'indexAll']);
        Route::put('/staff/cooperatives/{id}/review', [\App\Http\Controllers\Api\CooperativeController::class, 'review']);

        Route::get('/users', [UserController::class, 'index']);
    });

    // 3. กลุ่มเส้นทางสำหรับ "ประชาชน" (Public) เท่านั้น
    Route::middleware('role:public')->group(function () {
        Route::get('/public/dashboard', function () {
            return response()->json(['message' => 'ยินดีต้อนรับประชาชนทั่วไป']);
        });

        // ยื่นคำขอและดูรายการของตัวเอง
        Route::post('/cooperatives', [\App\Http\Controllers\Api\CooperativeController::class, 'store']);
        Route::get('/cooperatives', [\App\Http\Controllers\Api\CooperativeController::class, 'index']);
    });
});


