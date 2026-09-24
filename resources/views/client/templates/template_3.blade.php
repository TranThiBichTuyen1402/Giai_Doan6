@extends('client.public-wedding-card')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=Alex+Brush&family=Azeret+Mono:wght@300;400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --analog-bg: #fff3dd;
        --analog-text: #3c4043;
        --analog-accent: #d97706;
        --analog-line: #3c4043;
        --analog-secondary: #8c7a6b;
    }

    body {
        background-color: var(--analog-bg);
        color: var(--analog-text);
        font-family: 'Arimo', sans-serif;
        margin: 0; padding: 0;
        overflow-x: hidden;
    }

    .mobile-card-wrapper-3 {
        position: relative; z-index: 3; width: 100%; max-width: 480px;
        margin: 0 auto; padding: 30px 18px 100px 18px; text-align: center;
    }

    /* Typography */
    .font-script { font-family: 'Alex Brush', cursive; font-size: 3.5rem; color: var(--analog-accent); line-height: 1.2; }
    .font-serif { font-family: 'Cormorant Garamond', serif; }
    .font-mono { font-family: 'Azeret Mono', monospace; font-size: 0.75rem; letter-spacing: 1px; }

    .section-block {
        padding: 30px 10px;
        margin-bottom: 20px;
    }

    .hero-title-3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.3rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: -1px;
        margin: 15px 0;
    }

    /* Countdown thanh mảnh */
    .countdown-analog {
        display: flex; justify-content: center; gap: 20px;
        margin: 25px 0;
        border-top: 1px solid var(--analog-line);
        border-bottom: 1px solid var(--analog-line);
        padding: 15px 0;
    }
    .cd-item-3 span { font-size: 1.5rem; font-weight: 700; color: var(--analog-text); display: block; }
    .cd-item-3 small { font-family: 'Azeret Mono', monospace; font-size: 0.6rem; color: var(--analog-secondary); text-transform: uppercase; }

    /* Ảnh bìa */
    .cover-img-3 {
        width: 100%; height: 360px; object-fit: cover;
        margin: 20px 0;
    }

    /* Schedule dạng list analog */
    .schedule-analog { text-align: left; padding: 0 10px; }
    .schedule-row {
        display: flex; align-items: baseline; gap: 15px;
        margin-bottom: 15px; border-bottom: 1px dashed #d1cfc1; padding-bottom: 8px;
    }
    .schedule-time { font-family: 'Azeret Mono', monospace; font-weight: 700; color: var(--analog-accent); min-width: 60px; }

    /* Album & Video */
    .album-grid-3 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
    .album-grid-3 img { width: 100%; height: 160px; object-fit: cover; }

    /* Bank info */
    .bank-box-3 {
        background: rgba(255, 255, 255, 0.4);
        padding: 20px;
        margin-bottom: 15px;
        border-top: 1px solid var(--analog-line);
        border-bottom: 1px solid var(--analog-line);
    }

    /* Nút bấm thủ công */
    .btn-analog {
        background-color: var(--analog-text);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 15px 30px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        width: 100%;
        transition: all 0.3s;
    }
    .btn-analog:hover { background-color: var(--analog-accent); color: #fff; }

    .btn-outline-analog {
        border: 1px solid var(--analog-line);
        background: transparent;
        color: var(--analog-text);
        border-radius: 50px;
        padding: 8px 20px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .form-control-3 {
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--analog-line);
        border-radius: 0;
        padding: 10px 5px;
        margin-bottom: 20px;
        color: var(--analog-text);
    }
    .form-control-3:focus { background: transparent; border-bottom: 2px solid var(--analog-accent); box-shadow: none; }
 /* ================================
       EDITOR MODE - NÚT BÚT CHỈNH SỬA
       ================================ */
    .editor-mode [data-field] {
        cursor: default;
    }

    /* Mỗi vùng có dữ liệu sẽ có một cây bút nhỏ bên phải */
    .editor-field-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: 100%;
    }

    .editor-field-wrap.block-field {
        display: flex;
        width: 100%;
    }

    .editor-field-wrap > [data-field] {
        outline: none !important;
        cursor: default !important;
    }

    .editor-pencil {
        flex: 0 0 auto;
        width: 30px;
        height: 30px;
        border: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(245, 158, 11, .95);
        color: #0f172a;
        font-size: 13px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,.25);
        transition: all .18s ease;
        z-index: 20;
    }

    .editor-pencil:hover {
        transform: scale(1.12);
        background: #fbbf24;
        box-shadow: 0 6px 16px rgba(245,158,11,.35);
    }

    .editor-pencil:active {
        transform: scale(.96);
    }

    .editor-pencil i {
        pointer-events: none;
    }

    /* Hiệu ứng nhẹ khi người dùng rê vào vùng có thể chỉnh sửa */
    .editor-mode .editor-field-wrap:hover > [data-field] {
        background: rgba(245, 158, 11, .08);
        border-radius: 5px;
    }

    .editor-edit-toast {
        position: fixed;
        left: 50%;
        bottom: 24px;
        transform: translateX(-50%) translateY(20px);
        z-index: 999999;
        background: rgba(15,23,42,.95);
        color: #fff;
        padding: 9px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 8px 25px rgba(0,0,0,.3);
        opacity: 0;
        pointer-events: none;
        transition: all .25s ease;
    }

    .editor-edit-toast.show {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
</style>
@endpush

@section('content')
<!-- thêm đoạn này thì cây bút sẽ hiện ra -->
@php
    $isEditor = request()->boolean('editor');
@endphp

@if($isEditor)
<script>
    document.body.classList.add('editor-mode');
</script>
@endif
<div class="mobile-card-wrapper-3">
    
    <div class="section-block">
        <div class="font-mono text-uppercase mb-2">The Wedding Ceremony</div>
        <h1 class="hero-title-3">Lễ Thành Hôn</h1>
        <p class="font-serif fs-5 mb-4" data-field="invitation_msg">
            {{ $card->invitation_msg ?? 'Trân trọng kính mời bạn đến tham dự và chung vui cùng gia đình chúng mình.' }}
        </p>
        
        <div class="font-script">
            <span data-field="groom_name">{{ $card->groom_name ?? 'Hữu Phước' }}</span> <br> & <br> <span data-field="bride_name">{{ $card->bride_name ?? 'Minh Thư' }}</span>
        </div>

        <div class="countdown-analog">
            <div class="cd-item-3"><span id="cd-days">00</span><small>Days</small></div>
            <div class="cd-item-3"><span id="cd-hours">00</span><small>Hours</small></div>
            <div class="cd-item-3"><span id="cd-mins">00</span><small>Mins</small></div>
            <div class="cd-item-3"><span id="cd-secs">00</span><small>Secs</small></div>
        </div>
<!--loi moi tu cap doi -->
      @if(!empty($card->voice_invite))
    <div class="mb-4 text-center">
        <button type="button" 
                class="btn rounded-pill px-4 py-2 btn-sm fw-bold shadow-sm" 
                style="background: #fef3c7; color: #92400e; border: 1px solid #f59e0b;" 
                onclick="playVoice('{{ asset('storage/' . $card->voice_invite) }}')">
            <i class="bi bi-play-circle-fill me-1" style="color: #d97706;"></i> Phát Lời Mời Từ Cặp Đôi
        </button>
    </div>
@endif
    </div>

    <img id="preview_cover_img" src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800' }}" class="cover-img-3">

    <div class="section-block">
        <div class="font-mono text-uppercase text-muted mb-2">FAMILY</div>
        <div class="hero-title-3" style="font-size: 1.5rem;">Thông Tin Hai Họ</div>
        <div class="row text-center small mt-4">
            <div class="col-6 border-end" style="border-color: var(--analog-line) !important;">
                <div class="font-mono fw-bold mb-2" style="color: var(--analog-accent);">NHÀ TRAI</div>
                <div class="mb-1">Bố: <strong data-field="groom_father">{{ $card->groom_father ?? 'Nguyễn Văn A' }}</strong></div>
                <div>Mẹ: <strong data-field="groom_mother">{{ $card->groom_mother ?? 'Trần Thị B' }}</strong></div>
            </div>
            <div class="col-6">
                <div class="font-mono fw-bold mb-2" style="color: var(--analog-accent);">NHÀ GÁI</div>
                <div class="mb-1">Bố: <strong data-field="bride_father">{{ $card->bride_father ?? 'Lê Văn C' }}</strong></div>
                <div>Mẹ: <strong data-field="bride_mother">{{ $card->bride_mother ?? 'Phạm Thị D' }}</strong></div>
            </div>
        </div>
    </div>

    <hr style="border-color: var(--analog-line);">

    <div class="section-block">
        <div class="font-mono text-uppercase text-muted mb-2">TIME & LOCATION</div>
        <div class="hero-title-3" style="font-size: 1.5rem;" data-field="wedding_date">
            {{ $card->wedding_date ?? '20 Tháng 10, 2026' }}
        </div>
        <div class="font-serif italic mb-2" data-field="lunar_date">
            {{ $card->lunar_date ?? 'Tức Ngày 10 Tháng 09 Năm Bính Ngọ' }}
        </div>
        <div class="font-mono small mb-4"><i class="bi bi-clock me-1"></i><span data-field="wedding_time">{{ $card->wedding_time ?? '08:00 Sáng' }}</span></div>

        <p class="small fw-bold mb-3 px-2" data-field="wedding_location">
            {{ $card->wedding_location ?? 'Sảnh Rose, Trung tâm Hội nghị MerPerle, TP.HCM' }}
        </p>

        @php
        $mapUrl = !empty($card->map_link) 
            ? $card->map_link 
            : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($card->wedding_location ?? 'Địa điểm tổ chức');
    @endphp

    <!-- GẮN TRỰC TIẾP $mapUrl VÀO DATA ATTRIBUTE ĐỂ JS BẮT ĐƯỢC -->
    <a href="javascript:void(0);" 
       id="btn_map_link" 
       data-map-url="{{ $mapUrl }}"
       onclick="openGoogleMapDirect()" 
       class="btn btn-sm rounded-pill px-4 py-2 text-white fw-bold shadow" 
   style="background-color: var(--dark-pink, #ff4d6d) !important; font-size: 0.9rem; position: relative; z-index: 999; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
    <i class="bi bi-geo-alt-fill fs-6"></i> Xem Chỉ Đường Maps
    </a>
    </div>

    <hr style="border-color: var(--analog-line);">

    <div class="section-block">
        <div class="font-mono text-uppercase text-muted mb-4">THE COUPLE</div>
        
        <div class="row align-items-center mb-4 text-start">
            <div class="col-4">
                <img id="preview_groom_avatar" src="{{ !empty($card->groom_avatar) ? asset($card->groom_avatar) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200' }}" class="img-fluid rounded-circle border border-dark">
            </div>
            <div class="col-8">
                <div class="font-mono text-uppercase text-muted extra-small">Chú Rể</div>
                <h5 class="fw-bold mb-1" data-field="groom_name">{{ $card->groom_name ?? 'Hữu Phước' }}</h5>
                <p class="small text-muted mb-1" data-field="groom_bio">{{ $card->groom_bio ?? 'Chàng trai điềm tĩnh và kỷ luật.' }}</p>
                @if(!empty($card->groom_phone))
                    <a href="tel:{{ $card->groom_phone }}" class="text-dark text-decoration-none small fw-bold"><i class="bi bi-telephone-fill me-1"></i> Gọi Chú Rể</a>
                @endif
            </div>
        </div>

        <div class="row align-items-center mt-4 text-end">
            <div class="col-8">
                <div class="font-mono text-uppercase text-muted extra-small">Cô Dâu</div>
                <h5 class="fw-bold mb-1" data-field="bride_name">{{ $card->bride_name ?? 'Minh Thư' }}</h5>
                <p class="small text-muted mb-1" data-field="bride_bio">{{ $card->bride_bio ?? 'Cô gái nhẹ nhàng, yêu nghệ thuật.' }}</p>
                @if(!empty($card->bride_phone))
                    <a href="tel:{{ $card->bride_phone }}" class="text-dark text-decoration-none small fw-bold">Gọi Cô Dâu <i class="bi bi-telephone-fill ms-1"></i></a>
                @endif
            </div>
            <div class="col-4">
                <img id="preview_bride_avatar" src="{{ !empty($card->bride_avatar) ? asset($card->bride_avatar) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200' }}" class="img-fluid rounded-circle border border-dark">
            </div>
        </div>
    </div>

    <hr style="border-color: var(--analog-line);">

    <div class="section-block">
        <div class="font-mono text-uppercase text-muted mb-2">TIMELINE</div>
        <div class="hero-title-3 mb-4" style="font-size: 1.5rem;">Lịch Trình</div>

        <div class="schedule-analog">
            <div class="schedule-row">
                <div class="schedule-time" data-field="time_welcome">{{ $card->time_welcome ?? '17:30' }}</div>
                <div>Đón Khách & Chụp Ảnh</div>
            </div>
            <div class="schedule-row">
                <div class="schedule-time" data-field="time_ceremony">{{ $card->time_ceremony ?? '18:30' }}</div>
                <div>Hành Lễ Thành Hôn</div>
            </div>
            <div class="schedule-row">
                <div class="schedule-time" data-field="time_party">{{ $card->time_party ?? '19:00' }}</div>
                <div>Khai Tiệc Mừng</div>
            </div>
        </div>
    </div>

    <div class="section-block">
        <div class="font-mono text-uppercase text-muted mb-2">GALLERY</div>
        <div class="hero-title-3 mb-4" style="font-size: 1.5rem;">Album Kỷ Niệm</div>

        @php
            $album = is_string($card->album_imgs ?? null) ? json_decode($card->album_imgs, true) : ($card->album_imgs ?? []);
        @endphp
        <div class="album-grid-3">
            @if(!empty($album) && count($album) > 0)
                @foreach(array_slice($album, 0, 4) as $img)
                    <img src="{{ asset($img) }}">
                @endforeach
            @else
                <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300&q=80">
                <img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=300&q=80">
                <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=300&q=80">
                <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=300&q=80">
            @endif
        </div>
    </div>

    @if(!empty($card->wedding_video))
        <div class="section-block">
            <div class="font-mono text-uppercase text-muted mb-2">CINEMATIC</div>
            <div class="hero-title-3 mb-4" style="font-size: 1.5rem;">Video Cưới</div>
            <video controls class="w-100 border border-dark">
                <source src="{{ asset($card->wedding_video) }}" type="video/mp4">
            </video>
        </div>
    @endif

    <div class="section-block">
    <div class="font-mono text-uppercase text-muted mb-2">SHARING</div>
    <div class="hero-title-3 mb-2" style="font-size: 1.5rem;">Wedding Moments</div>
    <p class="small text-muted mb-3">Tải ảnh kỉ niệm cùng dâu rể</p>

    {{-- Form gửi dữ liệu thật về Backend --}}
    <form action="{{ route('guest.upload_photo', $card->id ?? 3) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photos[]" class="form-control-3 w-100" accept="image/*" multiple required>
        <button type="submit" class="btn-outline-analog mt-2">
            <i class="bi bi-cloud-upload me-1"></i> TẢI ẢNH LÊN
        </button>
    </form>
</div>

   {{-- KHỐI TÌM BÀN TIỆC ANALOG STYLE --}}
@php
    // Kiểm tra xem đang ở giao diện Editor (chỉnh sửa/dùng thử) hay trang xem thiệp thực tế
    $isEditorMode = request()->boolean('editor');
    $isVipCard = !empty($card->is_vip);
@endphp

{{-- Hiển thị nếu: Thiệp đã VIP HOẶC đang mở ở chế độ Editor --}}
@if($isVipCard || $isEditorMode)
<div class="section-block">

    {{-- NẾU CHƯA VIP & ĐANG TRONG EDITOR: HIỆN BADGE VIP VÀ THÔNG BÁO NHẮC NHỞ --}}
    @if(!$isVipCard && $isEditorMode)
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" style="border-color: rgba(0, 0, 0, 0.1) !important;">
            <span class="badge fw-bold px-2 py-1 font-mono" style="background: var(--analog-accent, #8b5cf6); color: #fff; font-size: 0.72rem;">
                👑 TÍNH NĂNG VIP
            </span>
            <small class="fst-italic" style="color: #d97706; font-size: 0.75rem;">
                *Cần Nâng VIP & Tạo tài khoản để khách dùng được tính năng này
            </small>
        </div>
    @endif

    <div class="font-mono text-uppercase text-muted mb-2">SEATING CHART</div>
    <div class="hero-title-3 mb-3" style="font-size: 1.5rem;">Tìm Bàn Tiệc</div>
    
    <p class="small text-muted mb-3">Nhập tên của bạn để xem vị trí chỗ ngồi nhé!</p>

    <!-- Form tìm kiếm Analog -->
    <div class="mb-3">
         <input id="guestNameInput"
               type="text" 
               class="form-control-3 w-100 text-center mb-0" 
               placeholder="Hãy nhập tên của bạn...">
    </div>

    <button type="button" 
            id="btnSearchSeat" 
            onclick="findSeat(event)" 
            class="btn-outline-analog w-100">
        <i class="bi bi-search me-1"></i> TRA CỨU BÀN TIỆC
    </button>

    <!-- Kết quả hiển thị chuẩn -->
    <div id="seatResultArea" class="mt-3 fw-bold font-mono" style="color: var(--analog-accent, #8b5cf6); font-size: 0.95rem;"></div>
</div>
@endif

    <div class="section-block">
        <div class="font-mono text-uppercase text-muted mb-2">GIFT BOX</div>
        <div class="hero-title-3 mb-4" style="font-size: 1.5rem;">Hộp Mừng Cưới</div>

        <div class="bank-box-3">
            <div class="font-mono fw-bold text-uppercase mb-1" style="color: var(--analog-accent);">Chú Rể</div>
            <div class="small text-muted" data-field="groom_bank_name">{{ $card->groom_bank_name ?? 'Vietcombank' }}</div>
            <div class="fw-bold my-1 fs-6" data-field="groom_bank_acc">
                {{ (!empty($card->groom_bank_acc) && !str_contains($card->groom_bank_acc, 'xxx')) ? $card->groom_bank_acc : '107437858458' }}
            </div>
            <div class="extra-small text-muted" data-field="groom_bank_owner">{{ $card->groom_bank_owner ?? 'TRAN DUC' }}</div>
            @if(!empty($card->groom_bank_qr))
                <img src="{{ asset($card->groom_bank_qr) }}" onclick="window.open(this.src)" class="img-fluid rounded-3 mt-3 border border-dark" style="max-width:130px; cursor:pointer;">
            @endif
        </div>

        <div class="bank-box-3">
            <div class="font-mono fw-bold text-uppercase mb-1" style="color: var(--analog-accent);">Cô Dâu</div>
            <div class="small text-muted" data-field="bride_bank_name">{{ $card->bride_bank_name ?? 'Techcombank' }}</div>
            <div class="fw-bold my-1 fs-6" data-field="bride_bank_acc">
                {{ (!empty($card->bride_bank_acc) && !str_contains($card->bride_bank_acc, 'xxx')) ? $card->bride_bank_acc : '190123456789' }}
            </div>
            <div class="extra-small text-muted" data-field="bride_bank_owner">{{ $card->bride_bank_owner ?? 'THU THAO' }}</div>
            @if(!empty($card->bride_bank_qr))
                <img src="{{ asset($card->bride_bank_qr) }}" onclick="window.open(this.src)" class="img-fluid rounded-3 mt-3 border border-dark" style="max-width:130px; cursor:pointer;">
            @endif
        </div>
    </div>

    @if(!empty($card->voice_thanks))
        <div class="section-block">
            <div class="font-mono text-uppercase text-muted mb-2">THANK YOU</div>
            <div class="hero-title-3 mb-2" style="font-size: 1.5rem;">Lời Cảm Ơn</div>
            <p class="small text-muted mb-3">Lắng nghe chia sẻ từ dâu rể</p>
            <button class="btn-outline-analog" onclick="playVoice('{{ asset($card->voice_thanks) }}')">
                <i class="bi bi-volume-up me-1"></i> NGHE LỜI CẢM ƠN
            </button>
        </div>
    @endif

   <div class="section-block">
        <div class="font-mono text-uppercase text-muted mb-2">WISHES</div>
        <div class="hero-title-3 mb-4" style="font-size: 1.5rem;">Gửi Lời Chúc</div>
        

              <form id="wishForm" 
    @csrf
    {{-- Nhập tên khách --}}
    <input type="text" id="wish_name" name="name" class="form-control-3 w-100" placeholder="Tên của bạn..." required>
    
    {{-- Lời chúc văn bản --}}
    <textarea id="wish_text" name="content" class="form-control-3 w-100" rows="3" placeholder="Lời chúc của bạn..."></textarea>
    
    {{-- 1. TẢI FILE GHI ÂM CÓ SẴN --}}
    <div class="text-start mb-3">
        <label class="form-label font-mono small text-muted mb-1"><i class="bi bi-paperclip me-1"></i> Tải file âm thanh chúc mừng:</label>
        <input type="file" id="wish_voice_file" name="audio_file" accept="audio/*" class="form-control-3 w-100">
    </div>

    {{-- 2. GHI ÂM TRỰC TIẾP --}}
    <div class="p-3 mb-3 text-center border rounded-3" style="border-color: var(--analog-line) !important; background: rgba(255,255,255,0.3);">
        <div class="font-mono small text-muted mb-2">Hoặc ghi âm trực tiếp tại đây:</div>
        <div class="d-flex justify-content-center gap-2 align-items-center mb-2">
            <button type="button" id="btnRecord" class="btn-outline-analog">
                <i class="bi bi-mic-fill me-1"></i> Bắt đầu ghi âm
            </button>
            <span id="recordTimer" class="font-mono text-danger fw-bold d-none">00:00</span>
        </div>
        <audio id="audioPreview" controls class="w-100 mt-2 d-none"></audio>
    </div>
    
    <button type="submit" id="btnSubmitWish" class="btn-analog mt-2">
        GỬI LỜI CHÚC
    </button>
</form>
    </div>

    <div class="section-block pt-0">
        <button class="btn-analog mb-3" data-bs-toggle="modal" data-bs-target="#rsvpModal">
            XÁC NHẬN THAM DỰ (RSVP)
        </button>
        <p class="font-serif italic small text-muted" data-field="thank_msg">
            "{{ $card->thank_msg ?? 'Sự hiện diện của quý vị là niềm vinh hạnh lớn nhất của chúng tôi!' }}"
        </p>
    </div>

</div>

<div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-dark p-2" style="background-color: var(--analog-bg);">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-mono fw-bold text-uppercase"><i class="bi bi-envelope-heart me-2"></i>Xác Nhận Tham Dự</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-start">
                  <form id="rsvpForm"
      action="{{ isset($card->slug) ? route('wedding.rsvp', $card->slug) : '#' }}"
      method="POST">

    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Họ và tên của bạn</label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="Nhập tên của bạn">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Bạn là khách nhà ai?</label>
                        <select name="side" class="form-select rounded-3">
                            <option value="groom">Khách nhà Chú Rể</option>
                            <option value="bride">Khách nhà Cô Dâu</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Bạn có tham dự không?</label>
                        <select name="status" class="form-select rounded-3">
                            <option value="yes">Có tham dự</option>
                            <option value="no">Không tham dự</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Số người tham dự</label>
                        <input type="number" name="guests" class="form-control rounded-3" value="1" min="1">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Ghi chú</label>
                        <textarea name="note" class="form-control rounded-3" rows="3" placeholder="Ví dụ: Đi trễ 30 phút..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 rounded-pill py-2.5 fw-bold shadow-sm" style="background: var(--primary-rose, #e11d48); border:none;">
                        Gửi Xác Nhận
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


