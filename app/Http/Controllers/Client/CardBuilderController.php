<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Template; // Bật lên nếu bạn đã có Model Template
// use App\Models\UserCard; // Bật lên nếu bạn đã có Model UserCard

class CardBuilderController extends Controller
{
    // Sửa $template_id = null để nếu không truyền tham số qua URL thì cũng KHÔNG BỊ LỖI
    public function index(Request $request, $template_id = null)
    {
        // Ưu tiên lấy template_id từ URL query ?template=1, nếu không có thì lấy từ tham số route, không có nữa thì mặc định = 1
        $templateId = $request->input('template', $template_id ?? 1);

        // Giả lập lấy dữ liệu mẫu thiệp
        $template = (object)[
            'id'   => $templateId,
            'name' => 'Mẫu Thiệp Cưới #' . $templateId
        ];

        return view('client.builder', compact('template'));
    }

    // 2. Xử lý khi khách bấm nút "Lưu thiệp"
  public function save(Request $request)
{
    // 1. Trường hợp GÁN THIỆP Chờ vào User vừa đăng nhập thành công
    if ($request->has('card_id') && Auth::check()) {
        $card = WeddingCard::find($request->card_id);
        if ($card) {
            $card->user_id = Auth::id(); // Gán ID người dùng vào thiệp
            $card->save();
            return response()->json([
                'success' => true, 
                'message' => 'Đã gán thiệp vào tài khoản của bạn!'
            ]);
        }
    }

    // 2. Trường hợp TẠO / LƯU THIỆP MỚI từ Form
    // Nếu đã đăng nhập thì lấy Auth::id(), chưa thì để null
    $userId = Auth::check() ? Auth::id() : null;

    $card = WeddingCard::updateOrCreate(
        ['id' => $request->id],
        [
            'user_id' => $userId,
            'groom_name' => $request->groom_name,
            'bride_name' => $request->bride_name,
            // ... Thêm các trường dữ liệu khác của bạn ở đây ...
        ]
    );

    return response()->json([
        'success' => true,
        'card_id' => $card->id,
        'card_url' => url('/wedding-invitation/' . ($card->slug ?? $card->id)),
        'message' => 'Lưu thiệp thành công!'
    ]);
}
}