<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    /**
     * สร้าง Instance ใหม่พร้อมฉีด (Inject) UserService เข้ามา
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * ดึงรายชื่อ User ทั้งหมดพร้อมข้อมูล Role
     */
    public function index(): JsonResponse
    {
        // เรียกใช้ Logic จาก Service
        $users = $this->userService->getAllUsersWithRoles();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }
}
