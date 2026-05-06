<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * ตรวจสอบสิทธิ์การเข้าใช้งานตามชื่อ Role
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        
        if (!$request->user()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized: Please login first',
                'data' => null,
                'errors' => null
            ], 401);
        }

        if ($request->user()->role->name !== $role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Forbidden: You do not have permission to access this resource',
                'data' => null,
                'errors' => null
            ], 403);
        }

        return $next($request);
    }
}
