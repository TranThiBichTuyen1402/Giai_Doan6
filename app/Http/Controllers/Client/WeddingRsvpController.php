<?php

namespace App\Http\Controllers\Client;

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

    // 2. Validate dữ liệu gửi từ Form RSVP
    $validated = $request->validate([
        'name'   => 'required|string|max:255',
        'side'   => 'required|in:groom,bride',
        'status' => 'required|in:yes,no',
        'guests' => 'required|integer|min:1|max:20',
        'phone'  => 'nullable|string|max:20',
        'note'   => 'nullable|string|max:1000',
    ]);

    // 3. Chuyển đổi trạng thái status (yes/no) sang boolean (1/0)
    $isAttending = ($request->status === 'yes') ? 1 : 0;

    // 4. Tìm khách cũ theo (wedding_card_id + guest_name) để Cập nhật, nếu không có mới Tạo mới
    WeddingRsvp::updateOrCreate(
        [
            'wedding_card_id' => $card->id, // Lấy ID trực tiếp từ thiệp đã tìm thấy
            'guest_name'      => trim($request->name), // Khớp với name="name" trong form
        ],
        [
            'side'         => $request->side,
            'is_attending' => $isAttending,
            'guest_count'  => $request->guests, // Khớp với name="guests" trong form
            'message'      => $request->note,   // Khớp với name="note" trong form
            'phone'        => $request->phone ?? null,
        ]
    );

    return response()->json([
        'success' => true,
        'message' => 'Cảm ơn bạn đã xác nhận tham dự! ❤️',
    ]);
}
public function storeAdmin(Request $request)
{
    // 1. Chỉ validate các trường Form gửi lên
    $request->validate([
        'wedding_card_id' => 'required|exists:wedding_cards,id',
        'guest_names'     => 'required|string',
        'side'            => 'required|in:groom,bride',
    ]);

    // 2. Tách tên theo từng dòng
    $names = array_filter(explode("\n", str_replace("\r", "", $request->guest_names)));

    $count = 0;
    foreach ($names as $name) {
        $trimmedName = trim($name);
        if (!empty($trimmedName)) {
            WeddingRsvp::create([
                'wedding_card_id' => $request->wedding_card_id,
                'guest_name'      => $trimmedName,
                'side'            => $request->side,
                'is_attending'    => null, // Mặc định chưa phản hồi
                'guest_count'     => 1,
                'phone'           => $request->phone ?? null,
                'message'         => $request->message ?? null,
            ]);
            $count++;
        }
    }

    return redirect()->back()->with('success', "Đã thêm thành công {$count} khách mời!");
}
// 1. HÀM TẢI FILE MẪU CHUẨN DÀNH CHO CÔ DÂU CHÚ RỂ
public function downloadSampleExcel()
{
    $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Disposition' => 'attachment; filename="Mau_Danh_Sach_Khach_Moi.csv"',
    ];

    $callback = function() {
        $file = fopen('php://output', 'w');
        fputs($file, "\xEF\xBB\xBF"); // BOM tiếng Việt
        
        // Tiêu đề cột
        fputcsv($file, ['Tên khách mời', 'Số điện thoại', 'Khách nhà']);
        
        // Dữ liệu mẫu cực kỳ thân thiện
        fputcsv($file, ['Anh Nguyễn Văn A', '0901234567', 'Nhà trai']);
        fputcsv($file, ['Chị Trần Thị B', '0987654321', 'Nhà gái']);
        fputcsv($file, ['Chú Lê Văn C', '', 'Nhà trai']);
        
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

// 2. HÀM IMPORT DỮ LIỆU VÀO DATABASE
// HÀM IMPORT DỮ LIỆU ĐÃ TỐI ƯU (KHÔNG CẦN PHPSPREADSHEET)
public function importExcel(Request $request)
{
    $request->validate([
        'wedding_card_id' => 'required|exists:wedding_cards,id',
        'excel_file' => 'required|file|max:5120',
    ]);

    $file = $request->file('excel_file');
    
    // Mở file và đọc dữ liệu thuần qua stream
    if (($handle = fopen($file->getRealPath(), 'r')) !== FALSE) {
        
        // Bỏ qua dòng tiêu đề đầu tiên (dòng 1)
        fgetcsv($handle, 1000, ",");

        $importedCount = 0;
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            $guestName = trim($row[0] ?? '');
            
            if (empty($guestName)) {
                continue;
            }

            $phone = trim($row[1] ?? '');
            
            // Chuẩn hóa văn bản về chữ thường
            $rawSide = mb_strtolower(trim($row[2] ?? ''), 'UTF-8');

            // Tự động nhận diện Nhà gái / Nhà trai
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
                'is_attending'    => null, // Mới import thì để NULL (Chưa phản hồi)
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

// sửa khách mời 
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
}