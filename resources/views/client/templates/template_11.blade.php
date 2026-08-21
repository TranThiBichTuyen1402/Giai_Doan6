@extends('client.public-wedding-card')

@push('styles')
{{-- Font chữ lạ mắt & cao cấp: Syne (Phá cách modern) + Playfair Display (Tạp chí Ý) --}}
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,800;1,400&family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-bright: #faf7f2;
        --card-glass: rgba(255, 255, 255, 0.92);
        --text-dark: #1c1c1e;
        --text-sub: #6e6e73;
        --rose-gold: linear-gradient(135deg, #e0a96d 0%, #f4cb8d 50%, #c88a4b 100%);
        --shadow-soft: 0 15px 35px rgba(218, 197, 178, 0.3);
    }

    body, html {
        margin: 0; padding: 0; width: 100%;
        background-color: var(--bg-bright);
        background-image: 
            radial-gradient(circle at 10% 20%, rgba(254, 243, 199, 0.5) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(253, 230, 138, 0.35) 0%, transparent 50%);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-dark);
        overflow-x: hidden;
    }

    .card-container {
        max-width: 480px; margin: 0 auto; padding: 25px 16px 60px;
        position: relative; z-index: 2;
    }

    /* KHUNG THẺ KÍNH TRONG SÁNG */
    .paper-card {
        background: var(--card-glass) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1.5px solid rgba(255, 255, 255, 1) !important;
        border-radius: 28px !important;
        padding: 32px 20px !important;
        margin-bottom: 25px;
        position: relative;
        text-align: center;
        box-shadow: var(--shadow-soft);
        overflow: hidden;
    }

    /* ==========================================================
       🔥 CÁC HIỆU ỨNG CHUYỂN SCROLL ĐA DẠNG
       ========================================================== */
    .scroll-reveal {
        opacity: 0;
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.8s ease;
        will-change: transform, opacity;
    }

    .scroll-fade-up { transform: translateY(50px); }
    .scroll-zoom-in { transform: scale(0.85); }
    .scroll-slide-left { transform: translateX(-60px); }
    .scroll-slide-right { transform: translateX(60px); }
    .scroll-flip-3d { transform: rotateX(30deg) translateY(40px); perspective: 1000px; }

    /* Khi cuộn tới */
    .scroll-reveal.active {
        opacity: 1 !important;
        transform: translateY(0) translateX(0) scale(1) rotateX(0deg) !important;
    }

    /* FONT & STYLES */
    .font-syne { font-family: 'Syne', sans-serif; letter-spacing: -0.5px; }
    .font-playfair { font-family: 'Playfair Display', serif; }

    .text-rose-gold {
        background: var(--rose-gold);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    /* Đĩa nhạc xoay */
    .floating-vinyl-player {
        position: fixed; bottom: 20px; right: 20px; z-index: 999;
        background: rgba(255, 255, 255, 0.95); border: 1px solid rgba(224, 169, 109, 0.4);
        border-radius: 50px; padding: 6px 14px 6px 6px;
        display: flex; align-items: center; gap: 8px;
        box-shadow: 0 10px 25px rgba(180, 150, 120, 0.25); cursor: pointer;
    }

    .vinyl-disc {
        width: 32px; height: 32px; border-radius: 50%;
        background: radial-gradient(circle, #f4cb8d 20%, #2c2c2e 80%);
        border: 2px solid #fff;
        animation: spin 4s linear infinite; animation-play-state: paused;
    }
    .vinyl-disc.playing { animation-play-state: running; }

    /* Đếm ngược */
    .countdown { display: flex; justify-content: center; gap: 8px; margin: 20px 0; }
    .countdown .item {
        width: 65px; height: 70px; background: #ffffff;
        border-radius: 18px; border: 1px solid #f3e8de;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .countdown .item span { font-size: 20px; font-weight: 800; color: #b47b43; }
    .countdown .item small { font-size: 9px; color: var(--text-sub); text-transform: uppercase; font-weight: 600; }

    /* Nút bấm */
    .btn-rose-gold {
        background: var(--rose-gold); color: #ffffff; font-weight: 700; border: none;
        border-radius: 50px; letter-spacing: 1px; text-transform: uppercase;
        box-shadow: 0 8px 20px rgba(220, 160, 100, 0.35);
        transition: all 0.3s ease;
    }
    .btn-rose-gold:hover { transform: translateY(-2px); color: #fff; }

    /* Album ảnh */
    .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: 12px; }
    .gallery-grid img { width: 100%; height: 160px; object-fit: cover; border-radius: 18px; cursor: pointer; transition: transform 0.3s; }
    .gallery-grid img:hover { transform: scale(1.03); }

    /* Thẻ mừng cưới STK */
    .stk-card {
        background: #ffffff !important; border-radius: 18px !important; padding: 16px !important; margin-top: 12px;
        border: 1px solid #f1e5d9; box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    /* Sổ lưu bút */
    .wish-box {
        background: #ffffff; border-radius: 16px; padding: 12px 15px;
        border-left: 4px solid #e0a96d; margin-bottom: 10px; text-align: left;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    @keyframes spin { 100% { transform: rotate(360deg); } }
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
{{-- ĐĨA NHẠC --}}
@if(!empty($card->voice_invite))
<div class="floating-vinyl-player" onclick="toggleAudio('wedding-audio')">
    <div class="vinyl-disc" id="vinyl-icon"></div>
    <span class="small fw-bold text-dark pe-1" style="font-size: 12px;">Phát Nhạc</span>
    <audio id="wedding-audio" src="{{ asset($card->voice_invite) }}" loop></audio>
</div>
@endif

<div class="card-container">
    
    {{-- 1. COVER HERO (Hiệu ứng Zoom In) --}}
    <div class="paper-card scroll-reveal scroll-zoom-in">
        <span class="font-syne text-uppercase small text-rose-gold fw-bold" style="letter-spacing: 2px;">WEDDING INVITATION</span>
        <div class="my-3">
            <h1 class="font-syne fw-extrabold display-5 text-dark mb-0 text-uppercase" data-field="groom_name">{{ $card->groom_name ?? 'MINH NHẬT' }}</h1>
            <div class="font-playfair italic fs-2 my-0 text-rose-gold">&</div>
            <h1 class="font-syne fw-extrabold display-5 text-dark text-uppercase" data-field="bride_name">{{ $card->bride_name ?? 'TUYẾT ANH' }}</h1>
        </div>
        <p class="font-playfair fs-5 text-sub italic mb-4" data-field="invitation_msg">{{ $card->invitation_msg ?? 'Trân trọng kính mời bạn đến chung vui cùng tụi mình!' }}</p>
        <img id="preview_cover_img" src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800' }}" class="img-fluid rounded-4 shadow-sm" style="border: 3px solid #fff;" alt="Cover Photo">      
    </div>

    {{-- 2. THÔNG TIN HAI HỌ (Hiệu ứng Lật 3D) --}}
    <div class="paper-card scroll-reveal scroll-flip-3d">
        <h6 class="font-syne text-dark fw-bold mb-4" style="letter-spacing: 1px;">THÔNG TIN HAI HỌ</h6>
        <div class="row g-3 text-start">
            <div class="col-6 border-end border-light-subtle pe-3">
                <div class="text-center mb-3">
                    <span class="badge text-white fw-bold text-uppercase px-3 py-1 rounded-pill" style="background: var(--rose-gold);">Nhà Trai</span>
                </div>
                <div class="small text-sub">Bố: <strong data-field="groom_father" class="text-dark">{{ $card->groom_father ?? 'Nguyễn Văn A' }}</strong></div>
                <div class="small text-sub mt-2">Mẹ: <strong data-field="groom_mother" class="text-dark">{{ $card->groom_mother ?? 'Trần Thị B' }}</strong></div>
            </div>
            <div class="col-6 ps-3">
                <div class="text-center mb-3">
                    <span class="badge text-white fw-bold text-uppercase px-3 py-1 rounded-pill" style="background: var(--rose-gold);">Nhà Gái</span>
                </div>
                <div class="small text-sub">Bố: <strong data-field="bride_father" class="text-dark">{{ $card->bride_father ?? 'Lê Văn C' }}</strong></div>
                <div class="small text-sub mt-2">Mẹ: <strong data-field="bride_mother" class="text-dark">{{ $card->bride_mother ?? 'Phạm Thị D' }}</strong></div>
            </div>
        </div>
    </div>

    {{-- 3. CÔ DÂU & CHÚ RỂ (Hiệu ứng Trượt từ trái sang) --}}
    <div class="paper-card scroll-reveal scroll-slide-left">
        <div class="row align-items-center g-3 mb-3">
            <div class="col-5">
                <img id="preview_groom_avatar" src="{{ !empty($card->groom_avatar) ? asset($card->groom_avatar) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300' }}" class="rounded-circle img-fluid shadow-sm" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #fff;" alt="Chú Rể">
            </div>
            <div class="col-7 text-start">
                <span class="badge bg-light text-dark border mb-2 px-3 py-1 rounded-pill">Chú rể</span>
                <h5 class="font-syne fw-bold mb-1 text-dark" data-field="groom_name">{{ $card->groom_name ?? 'Minh Nhật' }}</h5>
                <p class="small text-sub mb-2" data-field="groom_bio">{{ $card->groom_bio ?? 'Luôn chân thành và hết lòng vì gia đình.' }}</p>
                <a id="groom_phone_link" href="tel:{{ $card->groom_phone ?? '0901234567' }}" class="btn btn-sm btn-outline-dark rounded-pill py-0 px-2 small" style="font-size: 11px;">
                    <i class="bi bi-telephone-fill me-1"></i> <span data-field="groom_phone">{{ $card->groom_phone ?? '0901 234 567' }}</span>
                </a>
            </div>
        </div>

        <hr style="border-color: #f1e5d9; margin: 18px 0;">

        <div class="row align-items-center g-3">
            <div class="col-7 text-end">
                <span class="badge bg-light text-dark border mb-2 px-3 py-1 rounded-pill">Cô dâu</span>
                <h5 class="font-syne fw-bold mb-1 text-dark" data-field="bride_name">{{ $card->bride_name ?? 'Tuyết Anh' }}</h5>
                <p class="small text-sub mb-2" data-field="bride_bio">{{ $card->bride_bio ?? 'Yêu đời, thích vẽ và mê đồ ngọt.' }}</p>
                <a id="bride_phone_link" href="tel:{{ $card->bride_phone ?? '0909876543' }}" class="btn btn-sm btn-outline-dark rounded-pill py-0 px-2 small" style="font-size: 11px;">
                    <i class="bi bi-telephone-fill me-1"></i> <span data-field="bride_phone">{{ $card->bride_phone ?? '0909 876 543' }}</span>
                </a>
            </div>
            <div class="col-5">
                <img id="preview_bride_avatar" src="{{ !empty($card->bride_avatar) ? asset($card->bride_avatar) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300' }}" class="rounded-circle img-fluid shadow-sm" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #fff;" alt="Cô Dâu">
            </div>
        </div>
    </div>

    {{-- 4. THỜI GIAN & ĐỊA ĐIỂM + ĐẾM NGƯỢC (Hiệu ứng Trượt từ phải sang) --}}
    <div class="paper-card scroll-reveal scroll-slide-right">
        <h6 class="font-syne text-dark fw-bold mb-2">THỜI GIAN & ĐỊA ĐIỂM</h6>
        <h2 class="font-playfair fw-extrabold my-1 text-rose-gold display-5" data-field="wedding_date">{{ $card->wedding_date ? \Carbon\Carbon::parse($card->wedding_date)->format('d / m / Y') : '28 / 11 / 2026' }}</h2>
        
        <div class="small text-sub mb-1" data-field="lunar_date">{{ $card->lunar_date ?? 'Tức Ngày 19 Tháng 10 Năm Bính Ngọ' }}</div>
        <div class="fw-bold mb-3 text-dark">Vào lúc <span data-field="wedding_time">{{ $card->wedding_time ?? '11:30 AM' }}</span></div>

        {{-- Đếm ngược --}}
        <div class="countdown">
            <div class="item"><span id="days">00</span><small>Ngày</small></div>
            <div class="item"><span id="hours">00</span><small>Giờ</small></div>
            <div class="item"><span id="minutes">00</span><small>Phút</small></div>
            <div class="item"><span id="seconds">00</span><small>Giây</small></div>
        </div>

        <p class="fw-bold mb-3 mt-4 text-dark"><i class="bi bi-geo-alt-fill text-danger me-1"></i> <span data-field="wedding_location">{{ $card->wedding_location ?? 'GEM Center, Quận 1, TP.HCM' }}</span></p>

        <div class="d-flex justify-content-center gap-2 mb-3">
            @if(!empty($card->map_link))
            <a id="map_link_btn" href="{{ $card->map_link }}" target="_blank" class="btn btn-dark btn-sm rounded-pill px-3">
                <i class="bi bi-map me-1"></i> Xem Bản Đồ
            </a>
            @endif
            <button onclick="addToGoogleCalendar()" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                <i class="bi bi-calendar-plus me-1"></i> Thêm vào Lịch
            </button>
        </div>

        {{-- Lịch trình tiệc --}}
        <div class="border-top pt-3 mt-3" style="border-color: #f1e5d9;">
            <h6 class="fw-bold mb-3 text-uppercase small text-sub">Lịch Trình Tiệc</h6>
            <div class="d-flex justify-content-around text-center small">
                <div><strong class="d-block fs-6 text-dark" data-field="time_welcome">{{ $card->time_welcome ?? '11:00' }}</strong><span class="text-sub">Đón khách</span></div>
                <div class="border-end border-light-subtle pe-3"></div>
                <div><strong class="d-block fs-6 text-dark" data-field="time_ceremony">{{ $card->time_ceremony ?? '11:30' }}</strong><span class="text-sub">Làm lễ</span></div>
                <div class="border-end border-light-subtle pe-3"></div>
                <div><strong class="d-block fs-6 text-dark" data-field="time_party">{{ $card->time_party ?? '12:00' }}</strong><span class="text-sub">Khai tiệc</span></div>
            </div>
        </div>
    </div>

    {{-- 5. ALBUM KỶ NIỆM (Hiệu ứng Zoom-In) --}}
    <div class="paper-card scroll-reveal scroll-zoom-in">
        <h6 class="font-syne text-dark fw-bold mb-3"><i class="bi bi-images me-2"></i>ALBUM KỶ NIỆM</h6>
        <div class="gallery-grid">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=500" alt="Gallery 1" onclick="window.open(this.src)">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=500" alt="Gallery 2" onclick="window.open(this.src)">
            <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=500" alt="Gallery 3" onclick="window.open(this.src)">
            <img src="https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=500" alt="Gallery 4" onclick="window.open(this.src)">
        </div>
    </div>

    {{-- 6. SỔ LƯU BÚT (Hiệu ứng Fade Up) --}}
    <div class="paper-card scroll-reveal scroll-fade-up">
        <h6 class="font-syne text-dark fw-bold mb-3"><i class="bi bi-chat-heart me-2"></i>SỔ LƯU BÚT</h6>
        <div id="wishesContainer">
            <div class="wish-box">
                <strong class="d-block text-dark small">Anh Tuấn & Chị Mai</strong>
                <span class="text-sub small">"Chúc hai em trăm năm hạnh phúc, sớm có quý tử nha!"</span>
            </div>
        </div>
        <button class="btn btn-outline-dark w-100 rounded-pill py-2 small fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#wishModal">
            <i class="bi bi-pencil-square me-1"></i> GỬI LỜI CHÚC MỪNG
        </button>
    </div>

    {{-- 7. MỪNG CƯỚI & RSVP (Hiệu ứng Zoom-In) --}}
    <div class="paper-card scroll-reveal scroll-zoom-in">
        <h6 class="font-syne text-dark fw-bold mb-3"><i class="bi bi-gift me-2"></i>GỬI NGỌT NGÀO</h6>
        
        {{-- Chú rể STK --}}
        <div class="stk-card text-start">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-uppercase small text-sub">Chú rể</span>
                <span class="badge bg-light text-dark border" data-field="groom_bank_name">{{ $card->groom_bank_name ?? 'Vietcombank' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <strong class="fs-6 mb-1 text-dark" id="stk_groom" data-field="groom_bank_acc">{{ $card->groom_bank_acc ?? '123456789' }}</strong>
                <button class="btn btn-sm btn-outline-dark py-0 px-2 small" onclick="copyToClipboard('stk_groom')"><i class="bi bi-copy"></i> Sao chép</button>
            </div>
            <small class="text-sub fw-bold text-uppercase d-block" data-field="groom_bank_owner">{{ $card->groom_bank_owner ?? 'NGUYEN VAN A' }}</small>
        </div>

        {{-- Cô dâu STK --}}
        <div class="stk-card text-start">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-uppercase small text-sub">Cô dâu</span>
                <span class="badge bg-light text-dark border" data-field="bride_bank_name">{{ $card->bride_bank_name ?? 'Techcombank' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <strong class="fs-6 mb-1 text-dark" id="stk_bride" data-field="bride_bank_acc">{{ $card->bride_bank_acc ?? '987654321' }}</strong>
                <button class="btn btn-sm btn-outline-dark py-0 px-2 small" onclick="copyToClipboard('stk_bride')"><i class="bi bi-copy"></i> Sao chép</button>
            </div>
            <small class="text-sub fw-bold text-uppercase d-block" data-field="bride_bank_owner">{{ $card->bride_bank_owner ?? 'PHAM THI D' }}</small>
        </div>

        {{-- Nút RSVP --}}
        <button class="btn btn-rose-gold w-100 py-3 fw-bold mt-4" data-bs-toggle="modal" data-bs-target="#rsvpModal">
            <i class="bi bi-envelope-check me-2"></i>XÁC NHẬN THAM DỰ
        </button>

        <p class="font-playfair italic fs-5 text-dark mt-3 mb-0" data-field="thank_msg">"{{ $card->thank_msg ?? 'Sự hiện diện của bạn là niềm hạnh phúc lớn nhất của chúng mình!' }}"</p>
    </div>

</div>

{{-- MODALS --}}
<div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 bg-white text-dark shadow-lg">
            <div class="modal-body p-4 text-start">
                <h5 class="font-syne text-dark fw-bold text-center mb-3">Xác Nhận Tham Dự</h5>
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

<div class="modal fade" id="wishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 bg-white text-dark shadow-lg">
            <div class="modal-body p-4 text-start">
                <h5 class="font-syne text-dark fw-bold text-center mb-3">Gửi Lời Chúc Mừng</h5>
                <form id="wishForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tên của bạn</label>
                        <input type="text" id="wish_name" class="form-control bg-light border-0 rounded-pill px-3" required placeholder="Nhập tên của bạn">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lời chúc mừng</label>
                        <textarea id="wish_text" class="form-control bg-light border-0 rounded-3 px-3" rows="3" required placeholder="Nhập lời chúc tốt đẹp nhất..."></textarea>
                    </div>
                     <div class="mb-3">
<label class="form-label small fw-bold"><i class="bi bi-mic-fill text-warning me-1"></i> Gửi kèm Giọng nói / Lời chúc âm thanh</label>
 <input type="file" id="wish_voice" accept="audio/*" class="form-control bg-secondary text-light border-0 rounded-pill px-3">
 <small class="text-sub d-block mt-1" style="font-size: 0.75rem;">(Chấp nhận file ghi âm MP3, WAV, M4A...)</small>
</div>
<!-- 💥 THAY THẾ Ô CHỌN FILE CŨ BẰNG KHỐI GHI ÂM NÀY -->
<div class="mb-3">
    <label class="form-label small fw-bold"><i class="bi bi-mic-fill text-warning me-1"></i> Gửi kèm Giọng nói trực tiếp</label>
    
    <div class="d-flex align-items-center gap-2">
        <button type="button" id="btnRecord" class="btn btn-outline-warning btn-sm rounded-pill px-3">
            <i class="bi bi-record-circle me-1"></i> Bấm để ghi âm
        </button>
        <span id="recordTimer" class="small text-danger fw-bold d-none">00:00</span>
    </div>
                    <button type="submit" class="btn btn-rose-gold w-100 rounded-pill py-2 fw-bold">GỬI LỜI CHÚC</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    // 1. Hiệu ứng cuộn trang Scroll Reveal (Dành riêng cho template này)
    function handleScrollAnimation() {
        const reveals = document.querySelectorAll('.scroll-reveal');
        const triggerBottom = window.innerHeight * 0.9;

        reveals.forEach(reveal => {
            const revealTop = reveal.getBoundingClientRect().top;
            if (revealTop < triggerBottom) {
                reveal.classList.add('active');
            }
        });
    }

    window.addEventListener('scroll', handleScrollAnimation);
    window.addEventListener('resize', handleScrollAnimation);
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(handleScrollAnimation, 100);
    });

    // 2. Bật/Tắt đĩa nhạc Vinyl
    function toggleAudio(id) {
        const audio = document.getElementById(id);
        const vinyl = document.getElementById('vinyl-icon');
        if (!audio) return;
        
        if (audio.paused) { 
            audio.play(); 
            if (vinyl) vinyl.classList.add('playing'); 
        } else { 
            audio.pause(); 
            if (vinyl) vinyl.classList.remove('playing'); 
        }
    }

    // 3. Sao chép số tài khoản
    function copyToClipboard(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const text = el.innerText;
        navigator.clipboard.writeText(text).then(() => alert('Đã sao chép số tài khoản: ' + text));
    }

    // 4. Thêm lịch Google Calendar
    function addToGoogleCalendar() {
        const title = encodeURIComponent("Đám cưới {{ $card->groom_name ?? 'Minh Nhật' }} & {{ $card->bride_name ?? 'Tuyết Anh' }}");
        const details = encodeURIComponent("Trân trọng kính mời bạn đến tham dự lễ cưới!");
        const location = encodeURIComponent("{{ $card->wedding_location ?? 'GEM Center' }}");
        window.open(`https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&details=${details}&location=${location}`, '_blank');
    }

    // 5. Xử lý Form Lời Chúc
    document.getElementById('wishForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const nameEl = document.getElementById('wish_name');
        const textEl = document.getElementById('wish_text');
        
        if (!textEl || !textEl.value.trim()) return;

        const wishHTML = `
            <div class="wish-box mb-2 p-2 bg-light rounded">
                <strong class="d-block text-dark small">${nameEl ? nameEl.value : 'Ẩn danh'}</strong>
                <span class="text-sub small">"${textEl.value}"</span>
            </div>
        `;
        document.getElementById('wishesContainer')?.insertAdjacentHTML('beforeend', wishHTML);
        
        alert('Cảm ơn lời chúc thân thương của bạn nhé! ❤️');
        this.reset();
        
        const modalEl = document.getElementById('wishModal');
        if (modalEl && window.bootstrap) {
            bootstrap.Modal.getInstance(modalEl)?.hide();
        }
    });
</script>
@endpush