<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WeddingRsvp;
use App\Models\WeddingTable;
use App\Models\GalleryPhoto;
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $allCards = Auth::user()
            ->weddingCards()
            ->latest()
            ->get();

        $recentCards = $allCards->take(3);

        $selectedCardId = $request->query('card_id', $allCards->first()?->id);
        $selectedCard = $allCards->firstWhere('id', $selectedCardId);

        $rsvps = collect();
        $stats = [
            'total_rsvps' => 0,
            'attending' => 0,
            'total_guests' => 0,
            'declined' => 0,
        ];

        if ($selectedCard) {
            $rsvps = $selectedCard->rsvps()->latest()->get();

            $stats['total_rsvps'] = $rsvps->count();
            $stats['attending'] = $rsvps->where('is_attending', true)->count();
            $stats['total_guests'] = $rsvps->where('is_attending', true)->sum('guest_count');
            $stats['declined'] = $rsvps->where('is_attending', false)->count();
        }

        return view('client.dashboard', compact(
            'allCards',
            'recentCards',
            'selectedCard',
            'rsvps',
            'stats'
        ));
    }

    public function myCards()
    {
        $cards = Auth::user()
            ->weddingCards()
            ->latest()
            ->get();

        return view('client.my-cards', compact('cards'));
    }

   public function rsvpList(Request $request)
    {
        $allCards = Auth::user()->weddingCards()->latest()->get();
        $selectedCardId = $request->query('card_id', $allCards->first()?->id);
        $selectedCard = $allCards->firstWhere('id', $selectedCardId);

        $rsvps = collect();
        $tables = collect();
        $unassignedGuests = collect();
        $wishes = collect();
        $moments = collect();

        $stats = [
            'total_rsvps' => 0, 
            'attending' => 0, 
            'total_guests' => 0, 
            'declined' => 0
        ];

        if ($selectedCard) {
            // 1. Lấy danh sách khách RSVP
            $rsvps = $selectedCard->rsvps()->latest()->get();
            
            // 2. Thống kê số lượng
            $stats['total_rsvps'] = $rsvps->count();
            $stats['attending'] = $rsvps->where('is_attending', true)->count();
            $stats['total_guests'] = $rsvps->where('is_attending', true)->sum('guest_count');
            $stats['declined'] = $rsvps->where('is_attending', false)->count();

            // 3. Lấy danh sách bàn tiệc kèm thông tin khách trong bàn
            $tables = WeddingTable::where('wedding_card_id', $selectedCard->id)
                        ->with('rsvps')
                        ->get();

            // 4. Khách xác nhận ĐI nhưng CHƯA xếp bàn (table_id = null)
            $unassignedGuests = WeddingRsvp::where('wedding_card_id', $selectedCard->id)
                        ->where('is_attending', true)
                        ->whereNull('table_id')
                        ->get();

            // 5. Lấy Lời chúc (Nếu đã có Model Wish, nếu chưa thì để mặc định rỗng)
            if (class_exists('App\Models\Wish')) {
                $wishes = \App\Models\Wish::where('wedding_card_id', $selectedCard->id)->latest()->get();
            }

            // 6. Lấy Kho ảnh (Nếu đã có Model Moment, nếu chưa thì để mặc định rỗng)
$moments = \App\Models\GalleryPhoto::where('wedding_card_id', $selectedCard->id)->latest()->get();        

        }

        return view('client.rsvp-list', compact(
            'selectedCard', 
            'allCards', 
            'rsvps', 
            'tables', 
            'stats', 
            'unassignedGuests',
            'wishes', 
            'moments'
        ));
    }

    public function storeTable(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required',
            'name' => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:1'
        ]);

        WeddingTable::create([
            'wedding_card_id' => $request->wedding_card_id,
            'name' => $request->name,
            'capacity' => $request->capacity ?? 10,
        ]);

        return redirect()->back()->with('success', 'Đã thêm bàn tiệc thành công!');
    }

    public function assignTable(Request $request, $id)
    {
        $rsvp = WeddingRsvp::findOrFail($id);
        $rsvp->table_id = $request->table_id;
        $rsvp->save();

        return redirect()->back()->with('success', 'Đã cập nhật vị trí bàn!');
    }

    // 1. Thêm khách mời thủ công
    public function storeRsvp(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required|exists:wedding_cards,id',
            'guest_name'      => 'required|string|max:255',
            'side'            => 'required|in:groom,bride',
            'is_attending'    => 'required|boolean',
        ]);

        WeddingRsvp::create([
            'wedding_card_id' => $request->wedding_card_id,
            'guest_name'      => $request->guest_name,
            'phone'           => $request->phone,
            'side'            => $request->side,
            'is_attending'    => $request->is_attending,
            'guest_count'     => $request->guest_count ?? 0,
            'message'         => $request->message,
        ]);

        return redirect()->back()->with('success', 'Đã thêm khách mời thủ công thành công!');
    }

    //xoá thiệp 
    // Xóa thiệp cưới và dọn dẹp các dữ liệu liên quan
    public function destroyCard($id)
    {
        $card = \App\Models\WeddingCard::where('id', $id)
                    ->where('user_id', Auth::id()) // Đảm bảo đúng chủ sở hữu
                    ->firstOrFail();

        // 1. Xóa RSVP, Bàn tiệc, Ảnh kỷ niệm, Lời chúc thuộc thiệp này
        WeddingRsvp::where('wedding_card_id', $card->id)->delete();
        WeddingTable::where('wedding_card_id', $card->id)->delete();
        GalleryPhoto::where('wedding_card_id', $card->id)->delete();
        
        if (class_exists('App\Models\Wish')) {
            \App\Models\Wish::where('wedding_card_id', $card->id)->delete();
        }

        // 2. Xóa các file ảnh/QR đại diện (nếu có)
        if ($card->groom_qr_code && file_exists(public_path($card->groom_qr_code))) {
            @unlink(public_path($card->groom_qr_code));
        }
        if ($card->bride_qr_code && file_exists(public_path($card->bride_qr_code))) {
            @unlink(public_path($card->bride_qr_code));
        }

        // 3. Tiến hành xóa thiệp
        $card->delete();

        return redirect()->back()->with('success', 'Đã xóa thiệp cưới thành công!');
    }
    // 2. Xóa khách mời khỏi danh sách
    public function destroyRsvp($id)
    {
        $rsvp = WeddingRsvp::findOrFail($id);
        $rsvp->delete();

        return redirect()->back()->with('success', 'Đã xóa khách mời khỏi danh sách!');
    }

    // Xóa lời chúc
public function destroyWish($id)
{
    $wish = \App\Models\Wish::findOrFail($id);
    $wish->delete();

    return redirect()->back()->with('success', 'Đã xóa lời chúc thành công!');
}

// Thêm ảnh kỷ niệm mới từ Dashboard
   // Thêm ảnh kỷ niệm mới từ Dashboard
  public function storeMoment(Request $request)
{
    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $file) {
            $filename = 'moment_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/moments'))) {
                mkdir(public_path('uploads/moments'), 0777, true);
            }

            $file->move(public_path('uploads/moments'), $filename);

            \App\Models\GalleryPhoto::create([
                'wedding_card_id' => $request->wedding_card_id,
                'photo_url'       => 'uploads/moments/' . $filename,
                'uploaded_by'     => 'Cô dâu & Chú rể',
                'is_approved'     => true,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Đã tải ảnh lên kho thành công!');
}

    // Xóa ảnh kỷ niệm
    public function destroyMoment($id)
{
    $moment = GalleryPhoto::findOrFail($id);

    if (file_exists(public_path($moment->photo_url))) {
        @unlink(public_path($moment->photo_url));
    }

    $moment->delete();

    return redirect()->back()->with('success', 'Đã xóa ảnh thành công!');
}
public function updateBankInfo(Request $request)
{
    $request->validate([
        'wedding_card_id' => 'required|exists:wedding_cards,id',
        'groom_qr'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        'bride_qr'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
    ]);

    $card = \App\Models\WeddingCard::findOrFail($request->wedding_card_id);

    // Cập nhật thông tin Nhà Trai
    $card->groom_bank_name  = $request->groom_bank_name;
    $card->groom_bank_acc   = $request->groom_bank_acc;
    $card->groom_bank_owner = $request->groom_bank_owner;

    // Cập nhật thông tin Nhà Gái
    $card->bride_bank_name  = $request->bride_bank_name;
    $card->bride_bank_acc   = $request->bride_bank_acc;
    $card->bride_bank_owner = $request->bride_bank_owner;

    // Xử lý Upload QR Chú rể
    if ($request->hasFile('groom_qr')) {
        if ($card->groom_qr_code && file_exists(public_path($card->groom_qr_code))) {
            @unlink(public_path($card->groom_qr_code));
        }
        $file = $request->file('groom_qr');
        $filename = 'qr_groom_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/qr'), $filename);
        $card->groom_qr_code = 'uploads/qr/' . $filename;
    }

    // Xử lý Upload QR Cô dâu
    if ($request->hasFile('bride_qr')) {
        if ($card->bride_qr_code && file_exists(public_path($card->bride_qr_code))) {
            @unlink(public_path($card->bride_qr_code));
        }
        $file = $request->file('bride_qr');
        $filename = 'qr_bride_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/qr'), $filename);
        $card->bride_qr_code = 'uploads/qr/' . $filename;
    }

    $card->save();

    return redirect()->back()->with('success', 'Đã lưu thông tin mừng cưới thành công!');
}

}