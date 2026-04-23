<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ดึงข้อมูล User ทั้งหมด (ทดสอบผ่าน Postman)
Route::get('/users', [\App\Http\Controllers\Api\UserController::class, 'index']);
