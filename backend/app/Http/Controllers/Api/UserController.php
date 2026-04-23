<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * ดึงรายชื่อ User ทั้งหมดพร้อมข้อมูล Role
     */
    public function index(): JsonResponse
    {
        // ดึง User ทั้งหมดพร้อมดึงข้อมูล Role ที่เชื่อมกันอยู่ (Eager Loading)
        $users = User::with('role')->get();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }
}
