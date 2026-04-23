<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * ดึงรายชื่อ User ทั้งหมดพร้อมข้อมูล Role
     */
    public function getAllUsersWithRoles(): Collection
    {
        return User::with('role')->get();
    }
}
