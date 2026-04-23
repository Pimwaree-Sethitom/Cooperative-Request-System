<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CooperativeService;
use App\Models\Cooperative;
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
     * ยื่นคำขอจัดตั้งสหกรณ์ พร้อมรายชื่อสมาชิกอย่างน้อย 10 คน (ประชาชน)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:cooperatives,name',
            'description' => 'nullable|string',
            'members' => 'required|array|min:10',
            'members.*.full_name' => 'required|string|max:255',
            'members.*.national_id' => 'nullable|string|max:20',
            'members.*.phone' => 'nullable|string|max:20',
        ], [
            'name.required' => 'กรุณาระบุชื่อสหกรณ์',
            'name.unique' => 'ชื่อสหกรณ์นี้ถูกใช้ไปแล้ว หรือกำลังอยู่ในการตรวจสอบ',
            'members.min' => 'จำนวนสมาชิกเริ่มต้นต้องไม่น้อยกว่า 10 คน',
        ]);

        $cooperative = $this->cooperativeService->createRequest($validated);

        return $this->created($cooperative, 'ยื่นคำขอจัดตั้งสหกรณ์สำเร็จแล้ว');
    }

    /**
     * ดูรายการคำขอของตัวเอง (ประชาชน)
     */
    public function index(): JsonResponse
    {
        $requests = $this->cooperativeService->getMyRequests();
        return $this->success($requests, 'ดึงรายการคำขอของคุณสำเร็จ');
    }

    /**
     * ดูรายการคำขอทั้งหมดในระบบ (เจ้าหน้าที่)
     */
    public function indexAll(Request $request): JsonResponse
    {
        $status = $request->query('status');
        $requests = $this->cooperativeService->getAllRequests($status);
        
        return $this->success($requests, 'ดึงรายการคำขอทั้งหมดสำเร็จ');
    }

    /**
     * ตรวจสอบ/อนุมัติ/ปฏิเสธคำขอ (เจ้าหน้าที่)
     */
    public function review(Request $request, $id): JsonResponse
    {
        $cooperative = Cooperative::findOrFail($id);

        if ($cooperative->status !== 'pending') {
            return $this->error('ไม่สามารถแก้ไขสถานะได้ เนื่องจากคำขอนี้ถูกตรวจสอบไปแล้ว', 422);
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'staff_note' => 'nullable|string|max:500',
        ]);

        $result = $this->cooperativeService->reviewRequest($cooperative, $validated);

        return $this->success($result, 'ดำเนินการตรวจสอบคำขอเรียบร้อยแล้ว');
    }
}
