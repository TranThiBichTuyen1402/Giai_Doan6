<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WeddingCard;

class DashboardController extends Controller
{
    public function index()
    {
        // Tổng khách hàng
        $totalUsers = User::where('role', 'user')->count();

        // Tổng số thiệp
        $totalCards = WeddingCard::count();

        // Tổng khách VIP
        $totalVipUsers = User::where('role', 'user')
            ->where('membership', 'vip')
            ->count();

        // Tổng khách FREE
        $totalFreeUsers = User::where('role', 'user')
            ->where('membership', 'free')
            ->count();

        // Tổng thiệp đã thanh toán
        $paidCards = WeddingCard::where('is_paid', true)->count();

        // Thống kê thiệp VIP
        $vipCards = WeddingCard::where('is_vip', true)->count();

        // Thống kê thiệp FREE
        $freeCards = WeddingCard::where('is_vip', false)->count();

        // 5 thiệp mới nhất
        $recentCards = WeddingCard::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalCards',
            'totalVipUsers',
            'totalFreeUsers',
            'paidCards',
            'vipCards',
            'freeCards',
            'recentCards'
        ));
    }
}