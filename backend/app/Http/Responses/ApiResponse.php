<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * ส่งข้อมูลกลับกรณีสำเร็จ (Success Response)
     */
    /**
     * 200 OK - ส่งข้อมูลกลับกรณีสำเร็จทั่วไป
     */
    protected function success($data = null, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
            'errors' => null
        ], $code);
    }

    /**
     * 201 Created - ใช้เมื่อสร้างข้อมูลใหม่สำเร็จ
     */
    protected function created($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * 204 No Content - ใช้เมื่อดำเนินการสำเร็จแต่ไม่มีข้อมูลส่งกลับ (เช่น ลบข้อมูล)
     */
    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * 400 Bad Request - คำขอผิดพลาดทั่วไป
     */
    protected function error(string $message = 'Error occurred', int $code = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
            'errors' => $errors
        ], $code);
    }

    /**
     * 401 Unauthorized - ไม่ได้เข้าสู่ระบบ
     */
    protected function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->error($message, 401);
    }

    /**
     * 403 Forbidden - ไม่มีสิทธิ์เข้าถึงข้อมูลนี้
     */
    protected function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->error($message, 403);
    }

    /**
     * 404 Not Found - ไม่พบข้อมูลที่เรียกหา
     */
    protected function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return $this->error($message, 404);
    }

    /**
     * 422 Unprocessable Content - ข้อมูลไม่ผ่านการตรวจสอบ (Validation Failed)
     */
    protected function validationError($errors = null, string $message = 'Validation failed'): JsonResponse
    {
        return $this->error($message, 422, $errors);
    }
}
