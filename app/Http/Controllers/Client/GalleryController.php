<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // Upload từ trang Admin/Dashboard
    public function store(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required|exists:wedding_cards,id',
            'photos'          => 'required|array',
            'photos.*'        => 'image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = 'admin_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/gallery'), $filename);

                GalleryPhoto::create([
                    'wedding_card_id' => $request->wedding_card_id,
                    'photo_url'       => 'uploads/gallery/' . $filename,
                    'uploaded_by'     => auth()->user()->name ?? 'Chủ thiệp',
                    'is_approved'     => true,
                ]);
            }
        }

        return back()->with('success', 'Tải ảnh lên thành công!');
    }

    // Khách mời tải ảnh chụp tại tiệc lên (giữ nguyên)
    public function guestUpload(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required|exists:wedding_cards,id',
            'guest_name'      => 'required|string|max:100',
            'photo'           => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'guest_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/gallery'), $filename);

            GalleryPhoto::create([
                'wedding_card_id' => $request->wedding_card_id,
                'photo_url'       => 'uploads/gallery/' . $filename,
                'caption'         => $request->caption ?? null,
                'uploaded_by'     => $request->guest_name,
                'is_approved'     => true,
            ]);
        }

        return back()->with('success', 'Cảm ơn bạn đã chia sẻ khoảnh khắc đẹp!');
    }

    // Xóa ảnh
    public function destroy($id)
    {
        $photo = GalleryPhoto::findOrFail($id);
        
        // Xóa file thực tế trong ổ cứng nếu tồn tại
        if (file_exists(public_path($photo->photo_url))) {
            @unlink(public_path($photo->photo_url));
        }

        $photo->delete();

        return back()->with('success', 'Đã xóa ảnh thành công!');
    }
}