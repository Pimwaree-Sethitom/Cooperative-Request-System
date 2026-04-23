<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // สร้าง Roles
        $publicRole = \App\Models\Role::create([
            'name' => 'public',
            'description' => 'ประชาชน',
        ]);

        $staffRole = \App\Models\Role::create([
            'name' => 'staff',
            'description' => 'เจ้าหน้าที่',
        ]);

        // สร้าง User: Public
        \App\Models\User::create([
            'full_name' => 'Public User',
            'email' => 'public@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('public123'),
            'role_id' => $publicRole->id,
        ]);

        // สร้าง User: Staff
        \App\Models\User::create([
            'full_name' => 'Staff User',
            'email' => 'staff@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('staff123'),
            'role_id' => $staffRole->id,
        ]);
    }
}
