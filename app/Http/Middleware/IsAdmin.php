<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Kiểm tra xem người dùng đã đăng nhập chưa
        // 2. Kiểm tra xem cột 'role' của người dùng đó có phải là 'admin' không
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request); // Hợp lệ -> cho phép đi tiếp vào trang Admin
        }

        // Nếu không phải admin, đá về trang chủ kèm thông báo lỗi
        return redirect('/trang-chu')->with('error', 'Bạn không có quyền truy cập khu vực admin!');
    }
}