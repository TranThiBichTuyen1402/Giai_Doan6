<?php

namespace App\Http\Controllers\Client;

use App\Models\Wish;
use App\Http\Controllers\Controller;
use App\Models\WeddingCard;
use App\Models\WeddingRsvp;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class WeddingRsvpController extends Controller
{
    /**
     * Khách mời gửi xác nhận tham dự từ giao diện Thiệp Cưới Public
     */
    public function store(Request $request, string $slug)
    {
        // 1. Tìm đúng tấm thiệp dựa vào slug
        $card = WeddingCard::where('slug', $slug)->firstOrFail();

        // 2. Validate dữ liệu
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'side'   => 'required|in:groom,bride',
            'status' => 'required|in:yes,no',
            'guests' => 'required|integer|min:1|max:20',
            'phone'  => 'nullable|string|max:20',
            'note'   => 'nullable|string|max:1000',
            'audio'  => 'nullable|file|mimes:audio/mpeg,mp3,wav,webm,m4a|max:10240',
        ]);

        // 3. FIX LỖI UNDEFINED VARIABLE $isAttending TẠI ĐÂY
        $isAttending = ($request->status === 'yes') ? 1 : 0;

        // 4. Xử lý lưu file voice nếu có
        $audioPath = null;
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('voice_wishes', 'public');
        }

        // 5. Tìm khách cũ theo (wedding_card_id + guest_name) để Cập nhật, nếu không có mới Tạo mới
        WeddingRsvp::updateOrCreate(
            [
                'wedding_card_id' => $card->id,
                'guest_name'      => trim($request->name),
            ],
            [
                'side'         => $request->side,
                'is_attending' => $isAttending, // Đã có biến $isAttending chuẩn
                'guest_count'  => $request->guests,
                'message'      => $request->note,
                'phone'        => $request->phone ?? null,
                'voice_file'   => $audioPath,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Cảm ơn bạn đã xác nhận tham dự! ❤️',
        ]);
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required|exists:wedding_cards,id',
            'guest_names'     => 'required|string',
            'side'            => 'required|in:groom,bride',
        ]);

        $names = array_filter(explode("\n", str_replace("\r", "", $request->guest_names)));

        $count = 0;
        foreach ($names as $name) {
            $trimmedName = trim($name);
            if (!empty($trimmedName)) {
                WeddingRsvp::create([
                    'wedding_card_id' => $request->wedding_card_id,
                    'guest_name'      => $trimmedName,
                    'side'            => $request->side,
                    'is_attending'    => null,
                    'guest_count'     => 1,
                    'phone'           => $request->phone ?? null,
                    'message'         => $request->message ?? null,
                ]);
                $count++;
            }
        }

        return redirect()->back()->with('success', "Đã thêm thành công {$count} khách mời!");
    }

    public function downloadSampleExcel()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Mau_Danh_Sach_Khach_Moi.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            
            fputcsv($file, ['Tên khách mời', 'Số điện thoại', 'Khách nhà']);
            fputcsv($file, ['Anh Nguyễn Văn A', '0901234567', 'Nhà trai']);
            fputcsv($file, ['Chị Trần Thị B', '0987654321', 'Nhà gái']);
            fputcsv($file, ['Chú Lê Văn C', '', 'Nhà trai']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required|exists:wedding_cards,id',
            'excel_file'      => 'required|file|max:5120',
        ]);

        $file = $request->file('excel_file');
        
        if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
            fgetcsv($handle, 1000, ",");

            $importedCount = 0;
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $guestName = trim($row[0] ?? '');
                
                if (empty($guestName)) {
                    continue;
                }

                $phone = trim($row[1] ?? '');
                $rawSide = mb_strtolower(trim($row[2] ?? ''), 'UTF-8');

                if (in_array($rawSide, ['nhà gái', 'gái', 'bride', 'nha gai', 'gai'])) {
                    $side = 'bride';
                } else {
                    $side = 'groom';
                }

                WeddingRsvp::create([
                    'wedding_card_id' => $request->wedding_card_id,
                    'guest_name'      => $guestName,
                    'phone'           => $phone ?: null,
                    'side'            => $side,
                    'is_attending'    => null,
                    'guest_count'     => 1,
                    'message'         => null,
                ]);

                $importedCount++;
            }
            
            fclose($handle);
            return redirect()->back()->with('success', "Đã thêm thành công {$importedCount} khách mời vào danh sách!");
        }

        return redirect()->back()->with('error', 'Không thể đọc dữ liệu từ file!');
    }

    public function update(Request $request, $id)
    {
        $rsvp = WeddingRsvp::findOrFail($id);

        $validated = $request->validate([
            'guest_name'   => 'required|string|max:255',
            'phone'        => 'nullable|string|max:20',
            'side'         => 'required|in:groom,bride',
            'is_attending' => 'nullable|boolean',
            'guest_count'  => 'required|integer|min:0',
            'message'      => 'nullable|string',
        ]);

        $rsvp->update($validated);

        return redirect()->back()->with('success', 'Đã cập nhật thông tin khách mời!');
    }

    /**
     * Khách mời gửi lời chúc bằng Giọng Nói từ giao diện Thiệp Cưới Public
     */
    public function storeVoiceWish(Request $request, string $slug)
    {
        $card = WeddingCard::where('slug', $slug)->firstOrFail();

        $guestName = trim($request->input('name', 'Khách ẩn danh'));
        $note = $request->input('content') ?? $request->input('note') ?? '[Lời chúc bằng giọng nói]';

        $audioPath = null;
        $file = $request->file('audio_file') ?? $request->file('audio');

        if ($file && $file->isValid()) {
            $audioPath = $file->store('voice_wishes', 'public');
        }

        $existingRsvp = WeddingRsvp::where('wedding_card_id', $card->id)
            ->where('guest_name', $guestName)
            ->first();

        if ($existingRsvp) {
            $updateData = ['message' => $note];
            if ($audioPath) {
                $updateData['voice_file'] = $audioPath;
            }
            $existingRsvp->update($updateData);
        } else {
            WeddingRsvp::create([
                'wedding_card_id' => $card->id,
                'guest_name'      => $guestName,
                'side'            => 'groom',
                'is_attending'    => null,
                'guest_count'     => 1,
                'message'         => $note,
                'voice_file'      => $audioPath,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đã gửi lời chúc thành công! ❤️'
        ]);
    }
}