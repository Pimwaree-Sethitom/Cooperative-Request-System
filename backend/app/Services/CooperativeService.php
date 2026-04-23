<?php

namespace App\Services;

use App\Models\Cooperative;
use App\Models\CooperativeMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CooperativeService
{
    /**
     * สร้างคำขอจัดตั้งสหกรณ์ใหม่ พร้อมรายชื่อสมาชิก
     */
    public function createRequest(array $data)
    {
        // ใช้ Transaction เพื่อป้องกันข้อมูลบันทึกไม่ครบ (ถ้าพังต้องพังทั้งหมด)
        return DB::transaction(function () use ($data) {
            
            // 1. สร้างข้อมูลสหกรณ์
            $cooperative = Cooperative::create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'initial_member_count' => count($data['members']), // เก็บจำนวนสมาชิกจากที่ส่งมาจริง
                'status' => 'pending',
                'created_by' => Auth::id(),
            ]);

            // 2. บันทึกรายชื่อสมาชิกทั้งหมด
            foreach ($data['members'] as $memberData) {
                CooperativeMember::create([
                    'cooperative_id' => $cooperative->id,
                    'full_name' => $memberData['full_name'],
                    'national_id' => $memberData['national_id'] ?? null,
                    'phone' => $memberData['phone'] ?? null,
                ]);
            }

            return $cooperative->load('creator');
        });
    }

    /**
     * ดึงข้อมูลคำขอที่ตัวเองเป็นคนยื่น พร้อมรายชื่อสมาชิก
     */
    public function getMyRequests()
    {
        // ดึงสหกรณ์ของตัวเอง พร้อมโหลดรายชื่อสมาชิกออกมาด้วย (Eager Loading)
        return Cooperative::with('creator')
            ->where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
