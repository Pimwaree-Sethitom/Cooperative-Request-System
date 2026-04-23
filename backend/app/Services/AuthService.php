<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * ลงทะเบียนผู้ใช้ใหม่
     */
    public function register(array $data)
    {
        // กำหนด Role เริ่มต้นเป็น public (ถ้าไม่ได้ระบุมา)
        $publicRole = Role::where('name', 'public')->first();

        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id'] ?? $publicRole->id,
        ]);

        return [
            'user' => $user->load('role'),
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    /**
     * เข้าสู่ระบบ
     */
    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['อีเมลหรือรหัสผ่านไม่ถูกต้อง'],
            ]);
        }

        return [
            'user' => $user->load('role'),
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    /**
     * ออกจากระบบ (ลบ Token)
     */
    public function logout($user)
    {
        return $user->currentAccessToken()->delete();
    }
}
