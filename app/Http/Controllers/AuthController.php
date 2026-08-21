<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WeddingCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function handleAuth(Request $request)
    {
        $mode = $request->input('mode'); 

        if ($mode === 'register') {
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return response()->json(['success' => false, 'message' => 'Email này đã được đăng ký rồi!']);
            }

            $user = User::create([
                'name'     => $request->name ?? 'Thành viên mới', 
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'user',
            ]);

            Auth::login($user); 
            
            // TỰ ĐỘNG GÁN THIỆP VỪA TẠO TRƯỚC ĐÓ VÀO TÀI KHOẢN MỚI
            if ($request->session()->has('pending_card_id')) {
                $pendingCardId = $request->session()->get('pending_card_id');
                WeddingCard::where('id', $pendingCardId)->update(['user_id' => $user->id]);
                $request->session()->forget('pending_card_id');
            }

   $redirect = $user->role === 'admin'
    ? route('home')
    : route('dashboard');

return response()->json([
    'success'  => true,
    'message'  => 'Đăng ký thành công!',
    'redirect' => $redirect
]);
        } else {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $user = Auth::user();

                // TỰ ĐỘNG GÁN THIỆP VỪA TẠO TRƯỚC ĐÓ VÀO TÀI KHOẢN VỪA ĐĂNG NHẬP
                if ($request->session()->has('pending_card_id')) {
                    $pendingCardId = $request->session()->get('pending_card_id');
                    WeddingCard::where('id', $pendingCardId)->update(['user_id' => $user->id]);
                    $request->session()->forget('pending_card_id');
                }

    $redirect = $user->role === 'admin'
    ? route('home')
    : route('dashboard');

return response()->json([
    'success'  => true,
    'message'  => 'Chào mừng bạn trở lại!',
    'redirect' => $redirect
]);
            }

            return response()->json([
                'success' => false, 
                'message' => 'Email hoặc mật khẩu không chính xác!'
            ]);
        }
    }
}