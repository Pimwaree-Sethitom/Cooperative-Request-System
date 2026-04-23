<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

// Routes สำหรับ Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes ที่ต้องล็อกอินก่อนถึงจะเข้าได้
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'me']);

    // ดึงข้อมูล User ทั้งหมด (ทดสอบผ่าน Postman)
    Route::get('/users', [UserController::class, 'index']);

});


