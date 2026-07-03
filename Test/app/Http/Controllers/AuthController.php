<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Hàm 1: Chỉ làm nhiệm vụ hiển thị cái Form Login ra màn hình
    public function showLogin()
    {
        return view('login');
    }

    // Hàm 2: HỨNG dữ liệu user/password và KIỂM TRA
    public function login(Request $request)
    {
        // vào Request lấy ra tài khoản và mật khẩu người dùng gõ
        $username = $request->input('username');
        $password = $request->input('password');

        // Xử lý kiểm tra (Fix cứng tài khoản mẫu)
        if ($username === 'admin' && $password === '123456') {
           //cách 1
            return redirect('/students');
            //cách 2
            // Response kết quả LOGIN SUCCESS
            //return "🎉 Đăng nhập thành công! Chào mừng bạn đến với Website!";
        } else {
            // Response kết quả LOGIN FAIL
            return "❌ Đăng nhập thất bại! Sai tài khoản hoặc mật khẩu.";
        }
    }
}