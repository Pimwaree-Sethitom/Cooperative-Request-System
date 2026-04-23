<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                // จัดการ Validation Error
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'ข้อมูลที่กรอกไม่ถูกต้อง',
                        'data' => null,
                        'errors' => $e->errors()
                    ], 422);
                }

                // จัดการหาข้อมูลไม่เจอ (404)
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'ไม่พบข้อมูลหรือหน้าที่เรียกหา (Not Found)',
                        'data' => null,
                        'errors' => null
                    ], 404);
                }

                // จัดการเรื่องการ Login (401)
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'กรุณาเข้าสู่ระบบก่อนใช้งาน',
                        'data' => null,
                        'errors' => null
                    ], 401);
                }

                // Error อื่นๆ ทั่วไป
                return response()->json([
                    'status' => 'error',
                    'message' => 'เกิดข้อผิดพลาดภายในระบบ: ' . $e->getMessage(),
                    'data' => null,
                    'errors' => null
                ], 500);
            }
        });
    })->create();
