<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * ลงทะเบียน
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $result = $this->authService->register($validated);

        return $this->created($result, 'ลงทะเบียนสำเร็จ');
    }

    /**
     * เข้าสู่ระบบ
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $result = $this->authService->login($validated);

        return $this->success($result, 'เข้าสู่ระบบสำเร็จ');
    }

    /**
     * ออกจากระบบ
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->success(null, 'ออกจากระบบสำเร็จ');
    }

    /**
     * ดูข้อมูลส่วนตัว (Profile)
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('role');

        return $this->success($user, 'ดึงข้อมูลส่วนตัวสำเร็จ');
    }
}
