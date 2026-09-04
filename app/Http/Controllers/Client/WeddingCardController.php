<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\WeddingCard;
use App\Models\WeddingTable;
use App\Models\WeddingGuest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
use App\Models\WeddingRsvp;

class WeddingCardController extends Controller
{
    private function getSampleCardsData()
    {
        return [
            1 => [
                'id'               => 1,
                'template_id'      => 1,
                'is_vip'           => false,
                'groom_name'       => 'Đinh Hà',
                'bride_name'       => 'Ngọc Bích',
                'wedding_date'     => '2026-12-12',
                'wedding_time'     => '08:00 Sáng',
                'lunar_date'       => 'Tức Ngày 04 Tháng 11 Năm Bính Ngọ',
                'wedding_location' => 'Sảnh Diamond, Grand Palace, Hà Nội',
                'invitation_msg'   => 'Trân trọng kính mời bạn đến tham dự và chung vui cùng gia đình chúng mình.',
                'groom_father'     => 'Đinh Văn A',
                'groom_mother'     => 'Nguyễn Thị B',
                'bride_father'     => 'Trần Văn C',
                'bride_mother'     => 'Lê Thị D',
                'groom_bio'        => 'Chàng trai kiên định, kỷ luật & ấm áp.',
                'bride_bio'        => 'Cô gái tinh tế, tràn đầy năng lượng & yêu nghệ thuật.',
                'groom_phone'      => '0987654321',
                'bride_phone'      => '0123456789',
                'cover_img'        => null,
                'groom_avatar'     => null,
                'bride_avatar'     => null,
                'album_imgs'       => [],
                'voice_invite'     => null,
                'map_link'         => 'https://maps.google.com',
                'time_welcome'     => '11:00',
                'time_ceremony'    => '11:30',
                'time_party'       => '12:00',
                'groom_bank_name'  => 'MBBank',
                'groom_bank_acc'   => '0987654321',
                'groom_bank_owner' => 'DINH HA',
                'bride_bank_name'  => 'Vietcombank',
                'bride_bank_acc'   => '0123456789',
                'bride_bank_owner' => 'NGOC BICH',
                'thank_msg'        => 'Sự hiện diện của quý vị là niềm vinh hạnh lớn nhất của gia đình chúng tôi!'
            ],
            2 => [
                'id'               => 2,
                'template_id'      => 2,
                'is_vip'           => false,
                'groom_name'       => 'Trần Đức',
                'bride_name'       => 'Thu Thảo',
                'wedding_date'     => '2026-10-20',
                'wedding_time'     => '18:00 Chiều',
                'lunar_date'       => 'Tức Ngày 10 Tháng 09 Năm Bính Ngọ',
                'wedding_location' => 'Sảnh Rose, Trung tâm Hội nghị MerPerle, TP.HCM',
                'invitation_msg'   => 'Cùng chúng tôi chia sẻ khoảnh khắc hạnh phúc nhất trong chuyến hành trình tình yêu.',
                'groom_father'     => 'Trần Văn Hoàng',
                'groom_mother'     => 'Nguyễn Thị Hương',
                'bride_father'     => 'Phạm Văn Hiếu',
                'bride_mother'     => 'Lê Thị Mai',
                'groom_bio'        => 'Chàng kỹ sư mộng mơ, yêu văn học.',
                'bride_bio'        => 'Cô giáo nhỏ nhẹ nhàng, thích nấu ăn.',
                'groom_phone'      => '0901234567',
                'bride_phone'      => '0907654321',
                'cover_img'        => null,
                'groom_avatar'     => null,
                'bride_avatar'     => null,
                'album_imgs'       => [],
                'voice_invite'     => null,
                'map_link'         => 'https://maps.google.com',
                'time_welcome'     => '17:30',
                'time_ceremony'    => '18:30',
                'time_party'       => '19:00',
                'groom_bank_name'  => 'Vietcombank',
                'groom_bank_acc'   => '101xxxxxx',
                'groom_bank_owner' => 'TRAN DUC',
                'bride_bank_name'  => 'Techcombank',
                'bride_bank_acc'   => '190xxxxxx',
                'bride_bank_owner' => 'THU THAO',
                'thank_msg'        => 'Trân trọng cảm ơn sự hiện diện và những lời chúc phúc tốt đẹp nhất của quý vị!'
            ]
        ];
    }

    public function index(Request $request, $template_id = null)
    {
        if ($request->filled('card_id')) {
            $card = WeddingCard::with(['tables.guests'])
                ->where('id', $request->card_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $templateId = $card->template_id;
            return view('client.builder', compact('card', 'templateId'));
        }

        $templateId = $template_id ?? $request->query('template', 1);
        $sampleCards = $this->getSampleCardsData();
        $data = $sampleCards[$templateId] ?? $sampleCards[1];

        $card = new WeddingCard();
        $card->fill($data);
        $card->id = null;
        $card->slug = null;
        $card->user_id = Auth::id();

        return view('client.builder', compact('card', 'templateId'));
    }

    public function demo($id)
    {
        $sampleCards = $this->getSampleCardsData();
        $data = $sampleCards[$id] ?? $sampleCards[1];
        
        $card = (object) $data;
        $viewPath = 'client.templates.template_' . $id;
        if (!view()->exists($viewPath)) {
            $viewPath = 'client.templates.template_1';
        }

        return view($viewPath, compact('card'));
    }

   public function showPublicCard($slug)
{
    // Eager load tables VÀ rsvps của bàn đó
    $card = WeddingCard::with(['tables.rsvps'])
        ->where('slug', $slug)
        ->firstOrFail();

    $templateName = $card->template_id ? 'template_' . $card->template_id : 'template_1';

    return view("client.templates.{$templateName}", compact('card'));
}
    public function store(Request $request)
    {
        $request->validate([
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
        ]);

        try {
            $card = null;

            if ($request->filled('card_id')) {
                $card = WeddingCard::where('id', $request->card_id)
                    ->where('user_id', Auth::id())
                    ->firstOrFail();
            } else {
                $card = new WeddingCard();
                $card->slug = Str::slug($request->groom_name . '-' . $request->bride_name) . '-' . rand(1000, 9999);
                $card->is_vip = false;
                $card->first_published_at = now();

                if (Auth::check()) {
                    $card->user_id = Auth::id();
                }
            }

            if (Auth::check()) {
                $card->user_id = Auth::id();
            }

            if (!$card->is_vip && $card->first_published_at) {
                $hoursPassed = Carbon::parse($card->first_published_at)->diffInHours(now());
                if ($hoursPassed >= 24) {
                    return response()->json([
                        'success' => false,
                        'is_locked' => true,
                        'message' => 'Thiệp đã hết thời gian 24h chỉnh sửa miễn phí. Vui lòng Nâng Cấp VIP để tiếp tục!'
                    ], 403);
                }
            }

            $card->template_id      = $request->input('template_id', $card->template_id ?? 1);
            $card->groom_name        = $request->groom_name;
            $card->groom_phone       = $request->groom_phone;
            $card->groom_father      = $request->groom_father;
            $card->groom_mother      = $request->groom_mother;
            $card->groom_bio         = $request->groom_bio;

            $card->bride_name        = $request->bride_name;
            $card->bride_phone       = $request->bride_phone;
            $card->bride_father      = $request->bride_father;
            $card->bride_mother      = $request->bride_mother;
            $card->bride_bio         = $request->bride_bio;

            $card->lunar_date        = $request->lunar_date;
            $card->wedding_time      = $request->wedding_time ?? '08:00';
            $card->wedding_location  = $request->wedding_location;
            $card->map_link          = $request->map_link;

            $card->time_welcome      = $request->time_welcome;
            $card->time_ceremony     = $request->time_ceremony;
            $card->time_party        = $request->time_party;

            $card->invitation_msg    = $request->invitation_msg;
            $card->thank_msg         = $request->thank_msg;
            $card->wedding_video     = $request->wedding_video;

            $card->groom_bank_name   = $request->groom_bank_name;
            $card->groom_bank_acc    = $request->groom_bank_acc;
            $card->groom_bank_owner  = $request->groom_bank_owner;
            $card->bride_bank_name   = $request->bride_bank_name;
            $card->bride_bank_acc    = $request->bride_bank_acc;
            $card->bride_bank_owner  = $request->bride_bank_owner;

            if ($request->filled('wedding_date')) {
                try {
                    $card->wedding_date = Carbon::parse($request->wedding_date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $card->wedding_date = now()->format('Y-m-d');
                }
            } else {
                $card->wedding_date = now()->format('Y-m-d');
            }

            if ($request->hasFile('cover_img')) {
                $card->cover_img = $request->file('cover_img')->store('wedding_covers', 'public');
            }
            if ($request->hasFile('groom_avatar')) {
                $card->groom_avatar = $request->file('groom_avatar')->store('wedding_avatars', 'public');
            }
            if ($request->hasFile('bride_avatar')) {
                $card->bride_avatar = $request->file('bride_avatar')->store('wedding_avatars', 'public');
            }

            if ($card->is_vip) {
                if ($request->hasFile('voice_invite')) {
                    $card->voice_invite = $request->file('voice_invite')->store('wedding_audio', 'public');
                }
                if ($request->hasFile('voice_thanks')) {
                    $card->voice_thanks = $request->file('voice_thanks')->store('wedding_audio', 'public');
                }
                if ($request->hasFile('bg_music')) {
                    $card->bg_music = $request->file('bg_music')->store('wedding_audio', 'public');
                }
            }

            if ($request->hasFile('album_imgs')) {
                $albumFiles = $request->file('album_imgs');
                if (!$card->is_vip) {
                    $albumFiles = array_slice($albumFiles, 0, 3);
                }
                $albumPaths = is_array($card->album_imgs) ? $card->album_imgs : [];
                foreach ($albumFiles as $file) {
                    $albumPaths[] = $file->store('wedding_albums', 'public');
                }
                $card->album_imgs = $albumPaths;
            }

            $card->save();

            if (!Auth::check()) {
                session(['pending_card_id' => $card->id]);
            }

            $publicUrl = route('wedding.show', ['slug' => $card->slug]);

            return response()->json([
                'success'      => true,
                'message'      => 'Thiệp cưới đã được lưu thành công!',
                'card_id'      => $card->id,
                'is_vip'       => $card->is_vip,
                'slug'         => $card->slug,
                'card_url'     => $publicUrl,
                'redirect_url' => $publicUrl
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lưu thiệp: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API Tra cứu vị trí Bàn tiệc thông minh
     */
  public function searchTable(Request $request)
{
    $keyword = trim($request->get('keyword') ?? $request->get('seatNameInput') ?? '');

    if (!$keyword) {
        return response()->json(['success' => false, 'message' => 'Vui lòng nhập tên!']);
    }

    // Lấy khách từ bảng wedding_guests (bảng bạn vừa thêm SQL)
    $guests = \App\Models\WeddingGuest::where('name', 'LIKE', "%{$keyword}%")
        ->with('table')
        ->get();

    if ($guests->count() > 0) {
        $results = [];
        foreach ($guests as $guest) {
            $results[] = [
                'guest_name' => $guest->name,
                'table_name' => $guest->table ? $guest->table->name : 'Chưa xếp bàn',
                'plus_ones'  => $guest->plus_ones ?? 0,
                'note'       => $guest->note
            ];
        }
        return response()->json(['success' => true, 'guests' => $results]);
    }

    return response()->json([
        'success' => false,
        'message' => "Không tìm thấy thông tin bàn tiệc cho \"{$keyword}\""
    ]);
}
    /**
     * Thêm nhanh 1 khách mời từ Builder
     */
    public function addGuest(Request $request)
    {
        $request->validate([
            'wedding_card_id' => 'required|exists:wedding_cards,id',
            'name'            => 'required|string|max:255',
            'table_name'      => 'required|string|max:255',
        ]);

        // 1. Tự động tìm hoặc tạo Bàn tiệc
        $table = WeddingTable::firstOrCreate(
            [
                'wedding_card_id' => $request->wedding_card_id,
                'name'            => trim($request->table_name)
            ],
            [
                'group_name'    => $request->group_name ?? 'Khách Mời',
                'capacity'      => 10,
                'soft_capacity' => 8
            ]
        );

        // 2. Thêm khách vào Bàn đó
        $guest = WeddingGuest::create([
            'wedding_card_id'  => $request->wedding_card_id,
            'wedding_table_id' => $table->id,
            'name'             => trim($request->name),
            'plus_ones'        => $request->plus_ones ?? 0,
            'note'             => $request->note ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm khách thành công!',
            'guest'   => $guest,
            'table'   => $table
        ]);
    }

    public function upgradeToVip(Request $request)
    {
        $request->validate(['card_id' => 'required|exists:wedding_cards,id']);
        $card = WeddingCard::findOrFail($request->card_id);
        $card->is_vip = true;
        $card->vip_expires_at = now()->addYears(2);
        $card->save();

        return response()->json(['success' => true, 'message' => 'Đã nâng cấp thiệp thành VIP thành công!']);
    }

    public function showSampleCard(Request $request)
    {
        $templateId = $request->query('template', 1);
        $sampleCards = $this->getSampleCardsData();
        $data = $sampleCards[$templateId] ?? $sampleCards[1];
        $card = new WeddingCard($data);
        $viewPath = "client.templates.template_{$templateId}";
        if (!view()->exists($viewPath)) {
            $viewPath = 'client.templates.template_1';
        }

        return view($viewPath, compact('card'));
    }

    public function handlePaymentWebhook(Request $request)
    {
        $content = $request->input('content') ?? $request->input('description') ?? '';

        if (preg_match('/VIP\s*(\d+)/i', $content, $matches)) {
            $cardId = $matches[1];
            $card = WeddingCard::find($cardId);

            if ($card) {
                $card->is_vip = true;
                $card->vip_expires_at = now()->addYears(2);
                $card->save();

                return response()->json([
                    'success' => true,
                    'message' => "Đã kích hoạt VIP thành công cho thiệp ID: {$cardId}"
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy ID thiệp hợp lệ trong nội dung chuyển khoản.'
        ], 400);
    }

    public function chooseTemplate()
    {
        $templates = \App\Models\Template::where('is_active', 1)->get();
        return view('client.choose-template', compact('templates'));
    }
}