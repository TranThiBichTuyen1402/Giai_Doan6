@extends('client.public-wedding-card')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Monsieur+La+Douise&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-midnight: #0a1128;
        --paper-midnight: #101f42;
        --accent-rosegold: #e8b4b8;
        --accent-gold-glow: #f3d19e;
        --text-light: #f4f6f9;
        --text-sub: #a1b0cb;
    }

    body, html {
        margin: 0; padding: 0;
        width: 100%; height: 100%;
        background-color: var(--bg-midnight);
        background-image: radial-gradient(circle at 50% 30%, #1c2d5a 0%, #050a1a 100%);
        font-family: 'Montserrat', sans-serif;
        overflow-x: hidden;
        color: var(--text-light);
    }

    /* ENVELOPE STYLING */
    .envelope-wrapper {
        position: fixed;
        top: 0; left: 0; width: 100vw; height: 100vh;
        display: flex; justify-content: center; align-items: center;
        z-index: 999;
        background: rgba(10, 17, 40, 0.96);
        backdrop-filter: blur(8px);
        transition: all 0.9s cubic-bezier(0.77, 0, 0.175, 1);
    }

    .envelope-box {
        position: relative; width: 360px; height: 250px;
        background: var(--paper-midnight);
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.6);
        cursor: pointer;
        border: 1px solid var(--accent-rosegold);
    }

    .envelope-flap {
        position: absolute; top: 0; left: 0;
        width: 0; height: 0;
        border-left: 180px solid transparent;
        border-right: 180px solid transparent;
        border-top: 135px solid #0a1633;
        transform-origin: top;
        transition: transform 0.6s ease;
        z-index: 5;
    }

    .wax-seal {
        position: absolute; top: 105px; left: 50%;
        transform: translateX(-50%);
        width: 58px; height: 58px;
        background: linear-gradient(135deg, #e8b4b8, #b87380);
        border-radius: 50%;
        display: flex; justify-content: center; align-items: center;
        color: var(--bg-midnight); font-size: 1.5rem;
        box-shadow: 0 6px 18px rgba(232, 180, 184, 0.4);
        z-index: 6;
        transition: all 0.3s ease;
    }

    .envelope-box:hover .wax-seal { transform: translateX(-50%) scale(1.1); }

    .click-hint {
        position: absolute; bottom: -45px; left: 0; width: 100%;
        text-align: center; font-size: 0.85rem; font-weight: 600;
        color: var(--accent-rosegold); letter-spacing: 1.5px;
        animation: pulse 1.8s infinite;
    }

    .envelope-wrapper.open .envelope-flap { transform: rotateX(180deg); z-index: 1; }
    .envelope-wrapper.open .wax-seal, .envelope-wrapper.open .click-hint { opacity: 0; pointer-events: none; }
    .envelope-wrapper.open { opacity: 0; pointer-events: none; transition-delay: 0.6s; }

    /* CONTAINER */
    .card-container {
        max-width: 520px; margin: 0 auto;
        padding: 30px 15px; opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s ease 0.4s;
    }
    .card-container.show { opacity: 1; transform: translateY(0); }

    /* PAPER CARD STYLE */
    .paper-card {
        background: rgba(16, 31, 66, 0.85) !important;
        border: 1px solid rgba(232, 180, 184, 0.3) !important;
        border-radius: 16px !important;
        padding: 28px 20px !important;
        margin-bottom: 25px;
        position: relative;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .font-script {
        font-family: 'Monsieur La Douise', cursive;
        font-size: 4.2rem;
        color: var(--accent-rosegold);
        line-height: 1;
    }

    .font-serif { font-family: 'Cormorant Garamond', serif; }

    .countdown { display: flex; justify-content: center; gap: 12px; margin: 25px 0 15px; }
    .countdown .item {
        width: 72px; height: 75px;
        background: rgba(10, 17, 40, 0.9);
        border-radius: 12px;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        border: 1px solid var(--accent-rosegold);
    }
    .countdown .item span { font-size: 24px; font-weight: 700; color: var(--accent-rosegold); }
    .countdown .item small { font-size: 10px; color: var(--text-sub); text-transform: uppercase; }

    .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 15px; }
    .gallery-grid img { width: 100%; height: 160px; object-fit: cover; border-radius: 10px; border: 1px solid rgba(232, 180, 184, 0.3); cursor: pointer; }

    .stk-card {
        background: rgba(10, 17, 40, 0.7) !important;
        border: 1px solid rgba(232, 180, 184, 0.3) !important;
        border-radius: 12px !important;
        padding: 15px !important; margin-top: 15px;
    }

    .wish-box {
        background: rgba(10, 17, 40, 0.8);
        border-radius: 12px; padding: 12px 15px;
        border-left: 4px solid var(--accent-rosegold);
        margin-bottom: 10px; text-align: left;
    }

    .btn-rosegold {
        background: linear-gradient(135deg, #e8b4b8, #b87380);
        color: var(--bg-midnight); font-weight: 700; border: none;
        border-radius: 50px; transition: all 0.3s ease;
    }
    .btn-rosegold:hover { background: linear-gradient(135deg, #f3d19e, #e8b4b8); color: var(--bg-midnight); }

    @keyframes pulse {
        0%, 100% { opacity: 0.7; transform: translateY(0); }
        50% { opacity: 1; transform: translateY(-6px); }
    }
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
    /* KHUNG TRA CỨU BÀN TIỆC CHUẨN ĐỒNG BỘ */
    .search-box-wrap {
        height: 42px;
        display: flex;
        align-items: stretch;
        overflow: hidden;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }
    .search-box-wrap input {
        height: 100% !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        font-size: 0.9rem;
    }
    .search-box-wrap button {
        height: 100% !important;
        border: none !important;
        border-radius: 0 !important;
        padding: 0 18px !important;
        margin: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1 !important;
        font-size: 0.9rem;
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
<div class="envelope-wrapper" id="envelopeWrapper">
    <div class="envelope-box" onclick="openEnvelope()">
        <div class="envelope-flap"></div>
        <div class="wax-seal"><i class="bi bi-heart-fill"></i></div>
        <div class="click-hint"><i class="bi bi-hand-index-thumb me-1"></i> BẤM VÀO ĐỂ MỞ THIỆP</div>
    </div>
</div>

<div class="card-container" id="cardContainer">
    
    {{-- COVER --}}
    <div class="paper-card">
        <span class="font-serif text-uppercase fw-bold small" style="letter-spacing: 3px; color: var(--accent-rosegold);">— Royal Wedding —</span>
        
        <h1 class="font-script my-3">
            <span data-field="groom_name">{{ $card->groom_name ?? 'Minh Nhật' }}</span> 
            <span style="font-size: 2.5rem; color: var(--accent-rosegold); display: block; margin: -15px 0;">&</span> 
            <span data-field="bride_name">{{ $card->bride_name ?? 'Tuyết Anh' }}</span>
        </h1>

        <p class="font-serif fs-6 text-sub px-2" data-field="invitation_msg">Trân trọng kính mời bạn đến dự buổi tiệc chung vui cùng gia đình chúng mình!</p>
        
        <div class="position-relative d-inline-block w-100 my-2">
            <img id="preview_cover_img" 
                 src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486' }}" 
                 class="img-fluid rounded-4 shadow-sm" style="border: 2px solid var(--accent-rosegold);" alt="Cover Photo">      
            @if(!empty($card->voice_invite))
                <div class="mt-3">
                    <button class="btn btn-outline-light btn-sm rounded-pill px-4 py-2" onclick="playVoice('{{ asset($card->voice_invite) }}')">
                        <i class="bi bi-volume-up-fill me-1"></i> Nghe lời mời
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- HAI HỌ --}}
    <div class="paper-card">
        <h4 class="font-serif fw-bold mb-4" style="color: var(--accent-rosegold);">THÔNG TIN HAI HỌ</h4>
        <div class="row g-3 text-start">
            <div class="col-6 border-end border-secondary pe-3">
                <div class="text-center">
                    <span class="badge bg-dark text-white fw-bold text-uppercase border border-secondary mb-2 px-3 py-1">Nhà Trai</span>
                </div>
                <div class="small mt-2">Bố: <strong data-field="groom_father" class="text-light">{{ $card->groom_father ?? 'Nguyễn Văn A' }}</strong></div>
                <div class="small mt-1">Mẹ: <strong data-field="groom_mother" class="text-light">{{ $card->groom_mother ?? 'Trần Thị B' }}</strong></div>
            </div>
            <div class="col-6 ps-3">
                <div class="text-center">
                    <span class="badge bg-dark text-white fw-bold text-uppercase border border-secondary mb-2 px-3 py-1">Nhà Gái</span>
                </div>
                <div class="small mt-2">Bố: <strong data-field="bride_father" class="text-light">{{ $card->bride_father ?? 'Lê Văn C' }}</strong></div>
                <div class="small mt-1">Mẹ: <strong data-field="bride_mother" class="text-light">{{ $card->bride_mother ?? 'Phạm Thị D' }}</strong></div>
            </div>
        </div>
    </div>

    {{-- CÔ DÂU & CHÚ RỂ --}}
    <div class="paper-card">
        <div class="row align-items-center g-3 mb-3">
            <div class="col-5">
                <img id="preview_groom_avatar" src="{{ !empty($card->groom_avatar) ? asset($card->groom_avatar) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300' }}" class="rounded-circle img-fluid shadow" style="width: 110px; height: 110px; object-fit: cover; border: 3px solid var(--accent-rosegold);" alt="Chú Rể">
            </div>
            <div class="col-7 text-start">
                <span class="badge bg-secondary text-white mb-2 px-3 py-1">Chú rể</span>
                <h5 class="font-serif fw-bold mb-1 text-light" data-field="groom_name">{{ $card->groom_name ?? 'Minh Nhật' }}</h5>
                <p class="small text-sub mb-2" data-field="groom_bio">{{ $card->groom_bio ?? 'Luôn chân thành và hết lòng vì gia đình.' }}</p>
                
                <a id="groom_phone_link" href="tel:{{ $card->groom_phone ?? '0901234567' }}" class="btn btn-sm btn-outline-light rounded-pill py-0 px-2 small">
                    <i class="bi bi-telephone-fill me-1"></i> <span data-field="groom_phone">{{ $card->groom_phone ?? '0901 234 567' }}</span>
                </a>
            </div>
        </div>

        <hr style="border-color: rgba(232, 180, 184, 0.2); margin: 20px 0;">

        <div class="row align-items-center g-3">
            <div class="col-7 text-end">
                <span class="badge bg-secondary text-white mb-2 px-3 py-1">Cô dâu</span>
                <h5 class="font-serif fw-bold mb-1 text-light" data-field="bride_name">{{ $card->bride_name ?? 'Tuyết Anh' }}</h5>
                <p class="small text-sub mb-2" data-field="bride_bio">{{ $card->bride_bio ?? 'Yêu đời, thích vẽ và mê đồ ngọt.' }}</p>
                
                <a id="bride_phone_link" href="tel:{{ $card->bride_phone ?? '0909876543' }}" class="btn btn-sm btn-outline-light rounded-pill py-0 px-2 small">
                    <i class="bi bi-telephone-fill me-1"></i> <span data-field="bride_phone">{{ $card->bride_phone ?? '0909 876 543' }}</span>
                </a>
            </div>
            <div class="col-5">
                <img id="preview_bride_avatar" src="{{ !empty($card->bride_avatar) ? asset($card->bride_avatar) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300' }}" class="rounded-circle img-fluid shadow" style="width: 110px; height: 110px; object-fit: cover; border: 3px solid var(--accent-rosegold);" alt="Cô Dâu">
            </div>
        </div>
    </div>

    {{-- THỜI GIAN & ĐỊA ĐIỂM --}}
    <div class="paper-card">
        <h4 class="font-serif fw-bold mb-2" style="color: var(--accent-rosegold);">THỜI GIAN & ĐỊA ĐIỂM</h4>
        <h2 class="font-serif fw-bold my-2" style="color: var(--accent-gold-glow);" data-field="wedding_date">{{ $card->wedding_date ? \Carbon\Carbon::parse($card->wedding_date)->format('d / m / Y') : '28 / 11 / 2026' }}</h2>
        
        <div class="small text-sub mb-2" data-field="lunar_date">{{ $card->lunar_date ?? 'Tức Ngày 19 Tháng 10 Năm Bính Ngọ' }}</div>
        <div class="fw-bold mb-3" style="color: var(--accent-gold-glow);">Vào lúc <span data-field="wedding_time">{{ $card->wedding_time ?? '11:30 AM' }}</span></div>

        <div class="countdown">
            <div class="item"><span id="days">00</span><small>Ngày</small></div>
            <div class="item"><span id="hours">00</span><small>Giờ</small></div>
            <div class="item"><span id="minutes">00</span><small>Phút</small></div>
            <div class="item"><span id="seconds">00</span><small>Giây</small></div>
        </div>

        <p class="fw-bold mb-3 mt-4 text-light"><i class="bi bi-geo-alt-fill text-warning me-1"></i> <span data-field="wedding_location">{{ $card->wedding_location ?? 'Trung tâm Tiệc cưới GEM Center, Quận 1, TP.HCM' }}</span></p>

        <div class="d-flex justify-content-center gap-2 mb-3">
             @php
        $mapUrl = !empty($card->map_link) 
            ? $card->map_link 
            : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($card->wedding_location ?? 'Địa điểm tổ chức');
    @endphp

        <!-- ĐÃ ĐƯỢC NÂNG Z-INDEX VÀ ÉP POINTER-EVENTS -->
         <a href="javascript:void(0);" 
       id="btn_map_link" 
       data-map-url="{{ $mapUrl }}"
       onclick="openGoogleMapDirect()" 
           class="btn btn-sm rounded-pill px-3 py-1.5 text-white fw-bold shadow-sm d-inline-flex align-items-center gap-1"
       style="background-color: var(--dark-pink, #ff4d6d); border: none; font-size: 0.82rem;">
        <i class="bi bi-geo-alt-fill"></i> Xem Bản Đồ
        </a>
        
            <button onclick="addToGoogleCalendar()" class="btn btn-outline-secondary btn-sm rounded-pill px-3 text-white">
                <i class="bi bi-calendar-plus me-1"></i> Thêm vào Lịch
            </button>
        </div>

        <div class="border-top pt-3 mt-3" style="border-color: rgba(232, 180, 184, 0.2);">
            <h6 class="fw-bold mb-3 text-uppercase small text-sub">Lịch Trình Tiệc</h6>
            <div class="d-flex justify-content-around text-center small">
                <div><strong class="d-block fs-6" style="color: var(--accent-rosegold);" data-field="time_welcome">{{ $card->time_welcome ?? '11:00' }}</strong><span class="text-sub">Đón khách</span></div>
                <div class="border-end border-secondary pe-3"></div>
                <div><strong class="d-block fs-6" style="color: var(--accent-rosegold);" data-field="time_ceremony">{{ $card->time_ceremony ?? '11:30' }}</strong><span class="text-sub">Làm lễ</span></div>
                <div class="border-end border-secondary pe-3"></div>
                <div><strong class="d-block fs-6" style="color: var(--accent-rosegold);" data-field="time_party">{{ $card->time_party ?? '12:00' }}</strong><span class="text-sub">Khai tiệc</span></div>
            </div>
        </div>
    </div>

    {{-- TRA CỨU BÀN TIỆC --}}
    <div class="paper-card">
        <h3 class="text-white text-uppercase fs-6 fw-bold mb-1" style="font-size: 0.95rem !important;">
            <i class="bi bi-search text-warning me-1"></i> TRA CỨU BÀN TIỆC
        </h3>
        <p class="small text-white-50 mb-3" style="font-size: 0.85rem;">Nhập tên của bạn để xem vị trí chỗ ngồi nhé!</p>

        <div class="search-box-wrap shadow-sm">
            <input id="guestSearchInput" 
                   type="text" 
                   class="form-control bg-dark text-white" 
                   data-card-id="{{ $card->id ?? '' }}" 
                   data-search-url="{{ route('rsvp.searchTable') }}" 
                   placeholder="Hãy nhập tên của bạn...">
                   
            <button type="button" 
                    id="btnDoSearch" 
                    class="btn btn-warning fw-bold text-dark text-nowrap">
                Tra Cứu
            </button>
        </div>

        <div id="guestSearchResultArea" class="mt-3"></div>
    </div>

    {{-- ALBUM --}}
    <div class="paper-card">
        <h4 class="font-serif fw-bold mb-3" style="color: var(--accent-rosegold);"><i class="bi bi-images me-2"></i>ALBUM KỶ NIỆM</h4>
        <div class="gallery-grid">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=500" alt="Gallery 1" onclick="previewImage(this.src)">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=500" alt="Gallery 2" onclick="previewImage(this.src)">
            <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=500" alt="Gallery 3" onclick="previewImage(this.src)">
            <img src="https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=500" alt="Gallery 4" onclick="previewImage(this.src)">
        </div>
    </div>

    {{-- GUESTBOOK --}}
    <div class="paper-card">
        <h4 class="font-serif fw-bold mb-3" style="color: var(--accent-rosegold);"><i class="bi bi-chat-heart me-2"></i>SỔ LƯU BÚT</h4>
        <div id="wishesContainer">
            <div class="wish-box">
                <strong class="d-block small" style="color: var(--accent-gold-glow);">Anh Tuấn & Chị Mai</strong>
                <span class="text-sub small">"Chúc hai em trăm năm hạnh phúc, sớm có quý tử nha!"</span>
            </div>
        </div>
        <button class="btn btn-outline-light w-100 rounded-pill py-2 small fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#wishModal">
            <i class="bi bi-pencil-square me-1"></i> GỬI LỜI CHÚC MỪNG
        </button>
    </div>
    {{-- MỪNG CƯỚI & RSVP --}}
    <div class="paper-card">
        <h4 class="font-serif fw-bold mb-3" style="color: var(--accent-rosegold);"><i class="bi bi-gift me-2"></i>GỬI NGỌT NGÀO</h4>
        
        <div class="stk-card text-start">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-uppercase small text-sub">Chú rể</span>
                <span class="badge bg-dark text-light border border-secondary" data-field="groom_bank_name">{{ $card->groom_bank_name ?? 'Vietcombank' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <strong class="fs-6 mb-1" style="color: var(--accent-gold-glow);" id="stk_groom" data-field="groom_bank_acc">{{ $card->groom_bank_acc ?? '123456789' }}</strong>
                <button class="btn btn-sm btn-outline-light py-0 px-2 small" onclick="copyToClipboard('stk_groom')"><i class="bi bi-copy"></i> Sao chép</button>
            </div>
            <small class="text-sub fw-bold text-uppercase d-block" data-field="groom_bank_owner">{{ $card->groom_bank_owner ?? 'NGUYEN VAN A' }}</small>
        </div>

        <div class="stk-card text-start">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-uppercase small text-sub">Cô dâu</span>
                <span class="badge bg-dark text-light border border-secondary" data-field="bride_bank_name">{{ $card->bride_bank_name ?? 'Techcombank' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <strong class="fs-6 mb-1" style="color: var(--accent-gold-glow);" id="stk_bride" data-field="bride_bank_acc">{{ $card->bride_bank_acc ?? '987654321' }}</strong>
                <button class="btn btn-sm btn-outline-light py-0 px-2 small" onclick="copyToClipboard('stk_bride')"><i class="bi bi-copy"></i> Sao chép</button>
            </div>
            <small class="text-sub fw-bold text-uppercase d-block" data-field="bride_bank_owner">{{ $card->bride_bank_owner ?? 'PHAM THI D' }}</small>
        </div>

        <button class="btn btn-rosegold w-100 rounded-pill py-3 fw-bold mt-4 shadow" data-bs-toggle="modal" data-bs-target="#rsvpModal">
            <i class="bi bi-envelope-check me-2"></i>XÁC NHẬN THAM DỰ
        </button>

        <p class="font-serif italic small text-sub mt-3 mb-0" data-field="thank_msg">"{{ $card->thank_msg ?? 'Sự hiện diện của bạn là niềm hạnh phúc lớn nhất của chúng mình!' }}"</p>
    </div>

</div>

{{-- MODALS --}}
<div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border border-secondary bg-dark text-light shadow">
            <div class="modal-body p-4 text-start">
                <h5 class="font-serif fw-bold text-center mb-3" style="color: var(--accent-rosegold);">Xác Nhận Tham Dự</h5>
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
        <div class="modal-content rounded-4 border border-secondary bg-dark text-light shadow">
            <div class="modal-body p-4 text-start">
                <h5 class="font-serif fw-bold text-center mb-3" style="color: var(--accent-rosegold);">Gửi Lời Chúc Mừng</h5>
                <form id="wishForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tên của bạn</label>
                        <input type="text" id="wish_name" class="form-control bg-secondary text-light border-0 rounded-pill px-3" required placeholder="Nhập tên của bạn">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lời chúc mừng</label>
                        <textarea id="wish_text" class="form-control bg-secondary text-light border-0 rounded-3 px-3" rows="3" required placeholder="Nhập lời chúc tốt đẹp nhất..."></textarea>
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

    <!-- Khung nghe lại bản vừa ghi âm -->
    <div id="audioPreviewWrapper" class="mt-2 d-none">
        <audio id="audioPreview" controls style="max-width: 100%; height: 36px;"></audio>
        <button type="button" id="btnDeleteRecord" class="btn btn-sm btn-link text-danger p-0 ms-2 text-decoration-none">
            <i class="bi bi-trash"></i> Ghi lại
        </button>
    </div>
</div>
                    <button type="submit" class="btn btn-rosegold w-100 rounded-pill py-2 fw-bold">GỬI LỜI CHÚC</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    // 1. Mở bao thư thiệp
    function openEnvelope() {
        const wrapper = document.getElementById('envelopeWrapper');
        const container = document.getElementById('cardContainer');
        if (wrapper) wrapper.classList.add('open');
        if (container) container.classList.add('show');
    }

    // 2. Sao chép số tài khoản
    function copyToClipboard(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const text = el.innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert('Đã sao chép số tài khoản: ' + text);
        });
    }

    // 3. Thêm lịch Google Calendar
    function addToGoogleCalendar() {
        const title = encodeURIComponent("Đám cưới {{ $card->groom_name ?? 'Minh Nhật' }} & {{ $card->bride_name ?? 'Tuyết Anh' }}");
        const details = encodeURIComponent("Trân trọng kính mời bạn đến tham dự lễ cưới!");
        const location = encodeURIComponent("{{ $card->wedding_location ?? 'GEM Center' }}");
        const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&details=${details}&location=${location}`;
        window.open(url, '_blank');
    }

    // 4. Xem ảnh full size
    function previewImage(src) {
        if (src) window.open(src, '_blank');
    }

    // 5. Xử lý Form gửi lời chúc
    document.getElementById('wishForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const nameEl = document.getElementById('wish_name');
        const textEl = document.getElementById('wish_text');
        
        if (!textEl || !textEl.value.trim()) return;

        const wishHTML = `
            <div class="wish-box mb-2 p-2 bg-light rounded">
                <strong class="d-block text-dark small">${nameEl ? nameEl.value : 'Ẩn danh'}</strong>
                <span class="text-muted small">"${textEl.value}"</span>
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