<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CooperativeService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CooperativeController extends Controller
{
    protected CooperativeService $cooperativeService;

    public function __construct(CooperativeService $cooperativeService)
    {
        $this->cooperativeService = $cooperativeService;
    }

    /**
     * ยื่นคำขอจัดตั้งสหกรณ์ พร้อมรายชื่อสมาชิกอย่างน้อย 10 คน
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cooperatives,name',
            'description' => 'nullable|string',
            'members' => 'required|array|min:10', // ต้องมีสมาชิกอย่างน้อย 10 รายการ
            'members.*.full_name' => 'required|string|max:255', // ทุกคนในรายการต้องมีชื่อจริง
            'members.*.national_id' => 'nullable|string|max:20',
            'members.*.phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'กรุณาระบุชื่อสหกรณ์',
            'name.unique' => 'ชื่อสหกรณ์นี้ถูกใช้ไปแล้ว หรือกำลังอยู่ในการตรวจสอบ',
            'members.required' => 'กรุณาระบุรายชื่อสมาชิกเริ่มต้น',
            'members.array' => 'ข้อมูลสมาชิกต้องอยู่ในรูปแบบรายการ (Array)',
            'members.min' => 'จำนวนสมาชิกเริ่มต้นต้องไม่น้อยกว่า 10 คน',
            'members.*.full_name.required' => 'สมาชิกทุกคนต้องระบุชื่อ-นามสกุล',
        ]);

        $cooperative = $this->cooperativeService->createRequest($validated);

        return $this->created($cooperative, 'ยื่นคำขอจัดตั้งสหกรณ์สำเร็จแล้ว พร้อมรายชื่อสมาชิก ' . count($validated['members']) . ' ท่าน');
    }

    /**
     * ดูรายการคำขอของตัวเอง
     */
    public function index(): JsonResponse
    {
        $requests = $this->cooperativeService->getMyRequests();
        return $this->success($requests, 'ดึงรายการคำขอสำเร็จ');
    }
}
