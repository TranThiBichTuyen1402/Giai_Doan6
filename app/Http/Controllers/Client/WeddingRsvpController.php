<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingCard;
use App\Models\WeddingRsvp;
use Illuminate\Http\Request;

class WeddingRsvpController extends Controller
{
    /**
     * Khách mời gửi xác nhận tham dự
     */
    public function store(Request $request, string $slug)
    {
        // Tìm đúng tấm thiệp
        $card = WeddingCard::where('slug', $slug)->firstOrFail();

        // Kiểm tra dữ liệu
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'side' => 'required|in:groom,bride',
            'status' => 'required|in:yes,no',
            'guests' => 'required|integer|min:1|max:20',
            'phone' => 'nullable|string|max:20',
            'note' => 'nullable|string|max:1000',
        ]);

        // Lưu RSVP
        WeddingRsvp::create([
            'wedding_card_id' => $card->id,
            'guest_name'     => $validated['name'],
            'side'           => $validated['side'],
            'guest_count'    => $validated['guests'],
            'phone'          => $validated['phone'] ?? null,
            'message'        => $validated['note'] ?? null,
            'is_attending'   => $validated['status'] === 'yes',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn đã xác nhận tham dự! ❤️',
        ]);
    }
}