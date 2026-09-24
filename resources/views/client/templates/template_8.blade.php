@extends('client.public-wedding-card')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-sunny: #fffdf7;
        --accent-orange: #ff8c42;
        --accent-yellow: #f4a261;
        --text-main: #2b2d42;
        --text-sub: #6c757d;
    }

    body, html {
        margin: 0; padding: 0; width: 100%; min-height: 100vh;
        background: linear-gradient(180deg, #fff9e6 0%, #fffdf7 40%, #fff5eb 100%);
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: var(--text-main);
        overflow-x: hidden;
    }

    .card-container {
        max-width: 520px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .section-block {
        margin-bottom: 45px;
        text-align: center;
        position: relative;
    }

    .font-handwriting {
        font-family: 'Dancing Script', cursive;
    }

    .font-serif {
        font-family: 'Playfair Display', serif;
    }

    .title-large {
        font-size: 3rem;
        color: var(--accent-orange);
        line-height: 1.1;
    }

    .countdown { display: flex; justify-content: center; gap: 14px; margin: 25px 0; }
    .countdown .item {
        width: 70px; height: 75px;
        background: #ffffff;
        border-radius: 18px;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        box-shadow: 0 10px 25px rgba(244, 162, 97, 0.15);
    }
    .countdown .item span { font-size: 24px; font-weight: 700; color: var(--accent-orange); }
    .countdown .item small { font-size: 10px; color: var(--text-sub); text-transform: uppercase; letter-spacing: 1px; }

    .gallery-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 15px; }
    .gallery-grid img { width: 100%; height: 180px; object-fit: cover; border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.06); cursor: pointer; }

    .stk-item {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 20px; margin-top: 14px;
        box-shadow: 0 8px 20px rgba(244, 162, 97, 0.08);
    }

    .wish-item {
        background: #ffffff;
        border-radius: 16px; padding: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-bottom: 12px; text-align: left;
    }

    .btn-sunny {
        background: linear-gradient(135deg, #ff8c42, #f4a261);
        color: #fff; font-weight: 700; border: none;
        border-radius: 50px; transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(255, 140, 66, 0.3);
    }
    .btn-sunny:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 12px 25px rgba(255, 140, 66, 0.4); }
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
<div class="card-container">
    
    {{-- HEADER / COVER --}}
    <div class="section-block">
        <span class="badge bg-warning-subtle text-warning-emphasis fw-bold rounded-pill px-3 py-2 text-uppercase mb-3" style="letter-spacing: 2px;">Lễ Thành Hôn</span>
        
        <h1 class="font-handwriting title-large mb-0" data-field="groom_name">{{ $card->groom_name ?? 'Minh Nhật' }}</h1>
        <div class="font-serif italic fs-2 text-warning my-1">&</div>
        <h1 class="font-handwriting title-large mb-3" data-field="bride_name">{{ $card->bride_name ?? 'Tuyết Anh' }}</h1>

        <p class="small text-muted px-3 mb-4" data-field="invitation_msg">Trân trọng kính mời bạn đến chung vui cùng gia đình chúng mình trong ngày trọng đại này!</p>
        
        <div class="position-relative">
            <img id="preview_cover_img" 
                 src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486' }}" 
                 class="img-fluid rounded-5 shadow-lg" alt="Cover Photo">      
            @if(!empty($card->voice_invite))
                <div class="mt-3 text-center">
                    <button type="button" 
                            class="btn btn-light btn-sm rounded-pill px-4 py-2 shadow-sm text-warning-emphasis fw-semibold" 
                            onclick="playVoice('{{ asset(str_starts_with($card->voice_invite, 'storage/') ? $card->voice_invite : 'storage/' . $card->voice_invite) }}')">
                        <i class="bi bi-volume-up-fill me-1"></i> Nghe Lời Mời Từ Cặp Đôi
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- HAI HỌ --}}
    <div class="section-block">
        <h6 class="fw-bold text-uppercase text-warning-emphasis mb-4" style="letter-spacing: 2px;">— THÔNG TIN HAI HỌ —</h6>
        <div class="row g-4 text-start">
            <div class="col-6 border-end pe-3">
                <div class="text-center mb-3">
                    <span class="badge bg-warning text-white fw-bold px-3 py-1 rounded-pill">NHÀ TRAI</span>
                </div>
                <div class="small">Bố: <strong data-field="groom_father">{{ $card->groom_father ?? 'Nguyễn Văn A' }}</strong></div>
                <div class="small mt-2">Mẹ: <strong data-field="groom_mother">{{ $card->groom_mother ?? 'Trần Thị B' }}</strong></div>
            </div>
            <div class="col-6 ps-3">
                <div class="text-center mb-3">
                    <span class="badge bg-warning text-white fw-bold px-3 py-1 rounded-pill">NHÀ GÁI</span>
                </div>
                <div class="small">Bố: <strong data-field="bride_father">{{ $card->bride_father ?? 'Lê Văn C' }}</strong></div>
                <div class="small mt-2">Mẹ: <strong data-field="bride_mother">{{ $card->bride_mother ?? 'Phạm Thị D' }}</strong></div>
            </div>
        </div>
    </div>

    {{-- CÔ DÂU & CHÚ RỂ --}}
    <div class="section-block">
        <div class="row align-items-center g-3 mb-4">
            <div class="col-5">
                <img id="preview_groom_avatar" src="{{ !empty($card->groom_avatar) ? asset($card->groom_avatar) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300' }}" class="rounded-circle img-fluid shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;" alt="Chú Rể">
            </div>
            <div class="col-7 text-start">
                <span class="badge bg-warning-subtle text-warning-emphasis mb-1 px-3 py-1 rounded-pill">Chú rể</span>
                <h4 class="fw-bold mb-1" data-field="groom_name">{{ $card->groom_name ?? 'Minh Nhật' }}</h4>
                <p class="small text-muted mb-2" data-field="groom_bio">{{ $card->groom_bio ?? 'Luôn chân thành và hết lòng vì gia đình.' }}</p>
                
                <a id="groom_phone_link" href="tel:{{ $card->groom_phone ?? '0901234567' }}" class="btn btn-sm btn-outline-warning rounded-pill py-0 px-3 small">
                    <i class="bi bi-telephone-fill me-1"></i> <span data-field="groom_phone">{{ $card->groom_phone ?? '0901 234 567' }}</span>
                </a>
            </div>
        </div>

        <div class="row align-items-center g-3">
            <div class="col-7 text-end">
                <span class="badge bg-warning-subtle text-warning-emphasis mb-1 px-3 py-1 rounded-pill">Cô dâu</span>
                <h4 class="fw-bold mb-1" data-field="bride_name">{{ $card->bride_name ?? 'Tuyết Anh' }}</h4>
                <p class="small text-muted mb-2" data-field="bride_bio">{{ $card->bride_bio ?? 'Yêu đời, thích vẽ và mê đồ ngọt.' }}</p>
                
                <a id="bride_phone_link" href="tel:{{ $card->bride_phone ?? '0909876543' }}" class="btn btn-sm btn-outline-warning rounded-pill py-0 px-3 small">
                    <i class="bi bi-telephone-fill me-1"></i> <span data-field="bride_phone">{{ $card->bride_phone ?? '0909 876 543' }}</span>
                </a>
            </div>
            <div class="col-5">
                <img id="preview_bride_avatar" src="{{ !empty($card->bride_avatar) ? asset($card->bride_avatar) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300' }}" class="rounded-circle img-fluid shadow" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;" alt="Cô Dâu">
            </div>
        </div>
    </div>

    {{-- THỜI GIAN & ĐỊA ĐIỂM --}}
    <div class="section-block">
        <h6 class="fw-bold text-uppercase text-warning-emphasis mb-2" style="letter-spacing: 2px;">— THỜI GIAN & ĐỊA ĐIỂM —</h6>
        <h2 class="display-6 fw-bold my-2 text-warning font-serif" data-field="wedding_date">{{ $card->wedding_date ? \Carbon\Carbon::parse($card->wedding_date)->format('d / m / Y') : '28 / 11 / 2026' }}</h2>
        
        <div class="small text-muted mb-2" data-field="lunar_date">{{ $card->lunar_date ?? 'Tức Ngày 19 Tháng 10 Năm Bính Ngọ' }}</div>
        <div class="fw-bold mb-3">Vào lúc <span data-field="wedding_time">{{ $card->wedding_time ?? '11:30 AM' }}</span></div>

        <div class="countdown">
            <div class="item"><span id="days">00</span><small>Ngày</small></div>
            <div class="item"><span id="hours">00</span><small>Giờ</small></div>
            <div class="item"><span id="minutes">00</span><small>Phút</small></div>
            <div class="item"><span id="seconds">00</span><small>Giây</small></div>
        </div>

        <p class="fw-semibold mb-3 mt-4"><i class="bi bi-geo-alt-fill text-warning me-1"></i> <span data-field="wedding_location">{{ $card->wedding_location ?? 'Trung tâm Tiệc cưới GEM Center, Quận 1, TP.HCM' }}</span></p>

        <div class="d-flex justify-content-center gap-2 mb-4">
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
            
            <button onclick="addToGoogleCalendar()" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                <i class="bi bi-calendar-plus me-1"></i> Thêm vào Lịch
            </button>
        </div>

        <div class="pt-3 border-top">
            <h6 class="fw-bold mb-3 text-uppercase small text-muted">Lịch Trình Tiệc</h6>
            <div class="d-flex justify-content-around text-center small">
                <div><strong class="d-block text-warning fs-6" data-field="time_welcome">{{ $card->time_welcome ?? '11:00' }}</strong><span class="text-muted">Đón khách</span></div>
                <div class="border-end pe-3"></div>
                <div><strong class="d-block text-warning fs-6" data-field="time_ceremony">{{ $card->time_ceremony ?? '11:30' }}</strong><span class="text-muted">Làm lễ</span></div>
                <div class="border-end pe-3"></div>
                <div><strong class="d-block text-warning fs-6" data-field="time_party">{{ $card->time_party ?? '12:00' }}</strong><span class="text-muted">Khai tiệc</span></div>
            </div>
        </div>
    </div>

  {{-- KHỐI TRA CỨU BÀN TIỆC --}}
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
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" style="border-color: rgba(245, 158, 11, 0.3) !important;">
            <span class="badge fw-bold px-2 py-1" style="background: var(--bs-warning, #f59e0b); color: #000; font-size: 0.72rem;">
                👑 TÍNH NĂNG VIP
            </span>
            <small class="fst-italic" style="color: #d97706; font-size: 0.75rem;">
                *Cần Nâng VIP & Tạo tài khoản để khách dùng được tính năng này
            </small>
        </div>
    @endif

    <h6 class="fw-bold text-uppercase text-warning-emphasis mb-2" style="letter-spacing: 2px;">— VỊ TRÍ CHỖ NGỒI —</h6>
    <p class="small text-muted mb-3" data-field="search_table_desc">
        {{ $card->search_table_desc ?? 'Nhập tên hoặc số điện thoại của bạn để tra cứu vị trí bàn tiệc nhé!' }}
    </p>

    <div class="input-group shadow-sm">
         <input id="guestNameInput"
               type="text" 
               class="form-control search-input-sunny rounded-start-pill px-3" 
               style="height: 46px;" 
               placeholder="Nhập tên ví dụ: Tuấn...">
               
        <button type="button" 
                id="btnSearchSeat" 
                class="btn btn-sunny px-4 rounded-end-pill" 
                style="height: 46px;" 
                onclick="findSeat(event)">
            <i class="bi bi-search me-1"></i> Tra Cứu
        </button>
    </div>

    <!-- Khung kết quả tra cứu chuẩn -->
    <div id="seatResultArea" class="mt-3 text-start"></div>
</div>
@endif
    {{-- ALBUM --}}
    <div class="section-block">
        <h6 class="fw-bold text-uppercase text-warning-emphasis mb-3" style="letter-spacing: 2px;">— ALBUM KỶ NIỆM —</h6>
        <div class="gallery-grid">
            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?w=500" alt="Gallery 1" onclick="previewImage(this.src)">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=500" alt="Gallery 2" onclick="previewImage(this.src)">
            <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=500" alt="Gallery 3" onclick="previewImage(this.src)">
            <img src="https://images.unsplash.com/photo-1520854221256-17451cc331bf?w=500" alt="Gallery 4" onclick="previewImage(this.src)">
        </div>
    </div>
 @if(!empty($card->wedding_video))
    <div class="white-card">
        <div class="card-header-title">VIDEO CƯỚI</div>
        <video controls class="w-100 rounded">
            <source src="{{ asset($card->wedding_video) }}" type="video/mp4">
        </video>
    </div>
    @endif

   {{-- WEDDING MOMENTS --}}
<div class="white-card">
    <div class="card-header-title">Wedding Moments</div>
    <p class="small text-muted">Chia sẻ khoảnh khắc cùng cô dâu chú rể</p>

    {{-- Form gửi ảnh thật về Server --}}
            <form action="{{ route('guest.upload_photo', $card->id ?? 8) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photos[]" class="form-control" accept="image/*" multiple required>
        <button type="submit" class="btn btn-danger mt-3">Tải ảnh</button>
    </form>
</div>

   {{-- SỔ LƯU BÚT --}}
    <div class="section-block">
        <h6 class="fw-bold text-uppercase text-warning-emphasis mb-3" style="letter-spacing: 2px;">— SỔ LƯU BÚT —</h6>
        
        {{-- Khung chứa danh sách lời chúc & ảnh sẽ hiện ở đây --}}
        <div id="wishesContainer">
            <div class="wish-item mb-3">
                <strong class="d-block text-dark small">Anh Tuấn & Chị Mai</strong>
                <span class="text-muted small">"Chúc hai em trăm năm hạnh phúc, sớm có quý tử nha!"</span>
            </div>
        </div>

        <button class="btn btn-outline-warning w-100 rounded-pill py-2 small fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#wishModal">
            <i class="bi bi-pencil-square me-1"></i> GỬI LỜI CHÚC MỪNG & ẢNH
        </button>
    </div>

    {{-- MỪNG CƯỚI & RSVP --}}
    <div class="section-block">
        <h6 class="fw-bold text-uppercase text-warning-emphasis mb-3" style="letter-spacing: 2px;">— GỬI NGỌT NGÀO —</h6>
        
        <div class="stk-item text-start">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-uppercase small text-muted">Chú rể</span>
                <span class="badge bg-warning-subtle text-warning-emphasis" data-field="groom_bank_name">{{ $card->groom_bank_name ?? 'Vietcombank' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <strong class="fs-6 text-dark mb-1" id="stk_groom" data-field="groom_bank_acc">{{ $card->groom_bank_acc ?? '123456789' }}</strong>
                <button class="btn btn-sm btn-outline-secondary py-0 px-2 small" onclick="copyToClipboard('stk_groom')"><i class="bi bi-copy"></i> Sao chép</button>
            </div>
            <small class="text-muted fw-bold text-uppercase d-block" data-field="groom_bank_owner">{{ $card->groom_bank_owner ?? 'NGUYEN VAN A' }}</small>
        </div>

        <div class="stk-item text-start">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="fw-bold text-uppercase small text-muted">Cô dâu</span>
                <span class="badge bg-warning-subtle text-warning-emphasis" data-field="bride_bank_name">{{ $card->bride_bank_name ?? 'Techcombank' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <strong class="fs-6 text-dark mb-1" id="stk_bride" data-field="bride_bank_acc">{{ $card->bride_bank_acc ?? '987654321' }}</strong>
                <button class="btn btn-sm btn-outline-secondary py-0 px-2 small" onclick="copyToClipboard('stk_bride')"><i class="bi bi-copy"></i> Sao chép</button>
            </div>
            <small class="text-muted fw-bold text-uppercase d-block" data-field="bride_bank_owner">{{ $card->bride_bank_owner ?? 'PHAM THI D' }}</small>
        </div>

        <button class="btn btn-sunny w-100 py-3 fw-bold mt-4" data-bs-toggle="modal" data-bs-target="#rsvpModal">
            <i class="bi bi-envelope-check me-2"></i>XÁC NHẬN THAM DỰ
        </button>

        <p class="small text-muted font-handwriting fs-4 mt-4 mb-0" data-field="thank_msg">"{{ $card->thank_msg ?? 'Sự hiện diện của bạn là niềm hạnh phúc lớn nhất của chúng mình!' }}"</p>
    </div>

</div>

{{-- MODALS --}}
<div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body p-4 text-start">
                <h5 class="fw-bold text-center text-dark mb-3">Xác Nhận Tham Dự</h5>
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
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-body p-4 text-start">
                <h5 class="fw-bold text-center text-dark mb-3">Gửi Lời Chúc Mừng</h5>
                
                <form id="wishForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tên của bạn</label>
                        <input type="text" id="wish_name" class="form-control rounded-pill px-3" required placeholder="Nhập tên của bạn">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lời chúc mừng</label>
                        <textarea id="wish_text" class="form-control rounded-3 px-3" rows="3" required placeholder="Nhập lời chúc tốt đẹp nhất..."></textarea>
                    </div>

                    {{-- 1. ẢNH KỶ NIỆM --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-warning-emphasis">
                            <i class="bi bi-camera-fill me-1"></i> Gửi ảnh kỷ niệm (không bắt buộc)
                        </label>
                        <input type="file" id="wish_image" accept="image/*" class="form-control rounded-3">
                    </div>

                    {{-- 2. KHỐI GHI ÂM TRỰC TIẾP TỪ TEMPLATE 8 --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-warning-emphasis">
                            <i class="bi bi-mic-fill me-1"></i> Gửi kèm Giọng nói trực tiếp
                        </label>
                        
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" id="btnRecord" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                <i class="bi bi-record-circle me-1"></i> Bấm để ghi âm
                            </button>
                            <span id="recordTimer" class="small text-danger fw-bold d-none">00:00</span>
                        </div>

                        {{-- Khung nghe lại bản vừa ghi âm --}}
                        <div id="audioPreviewWrapper" class="mt-2 d-none">
                            <audio id="audioPreview" controls style="max-width: 100%; height: 36px;"></audio>
                            <button type="button" id="btnDeleteRecord" class="btn btn-sm btn-link text-danger p-0 ms-2 text-decoration-none">
                                <i class="bi bi-trash"></i> Ghi lại
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sunny w-100 rounded-pill py-2 fw-bold">GỬI LỜI CHÚC</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let mediaRecorder = null;
    let audioChunks = [];
    let recordedAudioBlob = null;
    let timerInterval = null;
    let seconds = 0;

    const btnRecord = document.getElementById('btnRecord');
    const recordTimer = document.getElementById('recordTimer');
    const audioPreviewWrapper = document.getElementById('audioPreviewWrapper');
    const audioPreview = document.getElementById('audioPreview');
    const btnDeleteRecord = document.getElementById('btnDeleteRecord');

    // 1. Xử lý Ghi Âm Trực Tiếp
    btnRecord?.addEventListener('click', async function() {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = event => {
                    if (event.data.size > 0) audioChunks.push(event.data);
                };

                mediaRecorder.onstop = () => {
                    recordedAudioBlob = new Blob(audioChunks, { type: 'audio/mp3' });
                    const audioUrl = URL.createObjectURL(recordedAudioBlob);
                    if (audioPreview) audioPreview.src = audioUrl;
                    
                    audioPreviewWrapper?.classList.remove('d-none');
                    btnRecord.innerHTML = '<i class="bi bi-record-circle me-1"></i> Bấm để ghi âm';
                    btnRecord.classList.remove('btn-danger');
                    btnRecord.classList.add('btn-outline-warning');
                    recordTimer?.classList.add('d-none');
                    clearInterval(timerInterval);
                };

                mediaRecorder.start();
                
                // Cập nhật giao diện khi bắt đầu ghi âm
                btnRecord.innerHTML = '<i class="bi bi-stop-circle-fill me-1"></i> Dừng ghi âm';
                btnRecord.classList.remove('btn-outline-warning');
                btnRecord.classList.add('btn-danger');
                recordTimer?.classList.remove('d-none');
                
                // Đồng hồ đếm thời gian
                seconds = 0;
                if (recordTimer) recordTimer.innerText = '00:00';
                timerInterval = setInterval(() => {
                    seconds++;
                    let m = Math.floor(seconds / 60).toString().padStart(2, '0');
                    let s = (seconds % 60).toString().padStart(2, '0');
                    if (recordTimer) recordTimer.innerText = `${m}:${s}`;
                }, 1000);

            } catch (err) {
                alert('Vui lòng cấp quyền truy cập Microphone để ghi âm!');
            }
        } else if (mediaRecorder.state === 'recording') {
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(track => track.stop());
        }
    });

    // 2. Xóa bản ghi âm vừa tạo
    btnDeleteRecord?.addEventListener('click', function() {
        recordedAudioBlob = null;
        if (audioPreview) audioPreview.src = '';
        audioPreviewWrapper?.classList.add('d-none');
    });

    // 3. Xử lý Submit Form Gửi Lời Chúc (Text + Ảnh + Âm thanh)
    const wishForm = document.getElementById('wishForm');
    wishForm?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const nameEl = document.getElementById('wish_name');
        const textEl = document.getElementById('wish_text');
        const imageEl = document.getElementById('wish_image');
        
        if (!textEl || !textEl.value.trim()) return;

        const name = nameEl && nameEl.value.trim() ? nameEl.value : 'Ẩn danh';
        const text = textEl.value;
        const imgFile = imageEl && imageEl.files ? imageEl.files[0] : null;

        // Hàm dựng HTML và hiển thị Lời chúc ra màn hình
        const renderWish = (imgSrc = null, audioSrc = null) => {
            const imgHTML = imgSrc 
                ? `<div class="mt-2"><img src="${imgSrc}" class="img-fluid rounded-3 border border-warning shadow-sm" style="max-height: 200px; width: 100%; object-fit: cover; cursor: pointer;" onclick="window.open('${imgSrc}', '_blank')"></div>` 
                : '';

            const audioHTML = audioSrc 
                ? `<div class="mt-2"><audio controls style="width: 100%; height: 36px;"><source src="${audioSrc}"></audio></div>` 
                : '';

            const wishHTML = `
                <div class="wish-item mb-3">
                    <strong class="d-block text-dark small">${name}</strong>
                    <span class="text-muted small">"${text}"</span>
                    ${imgHTML}
                    ${audioHTML}
                </div>
            `;
            
            document.getElementById('wishesContainer')?.insertAdjacentHTML('beforeend', wishHTML);
            alert('Cảm ơn lời chúc thân thương của bạn nhé! ❤️');
            
            // Reset dữ liệu sau khi gửi thành công
            wishForm.reset();
            recordedAudioBlob = null;
            if (audioPreview) audioPreview.src = '';
            audioPreviewWrapper?.classList.add('d-none');
            
            // Đóng Modal
            const modalEl = document.getElementById('wishModal');
            if (modalEl && window.bootstrap) {
                bootstrap.Modal.getInstance(modalEl)?.hide();
            }
        };

        // Tạo URL âm thanh từ bản ghi âm trực tiếp
        let audioSrc = recordedAudioBlob ? URL.createObjectURL(recordedAudioBlob) : null;

        // Đọc File Ảnh nếu có
        if (imgFile) {
            const reader = new FileReader();
            reader.onload = function(event) {
                renderWish(event.target.result, audioSrc);
            };
            reader.readAsDataURL(imgFile);
        } else {
            renderWish(null, audioSrc);
        }
    });
});
</script>
@endpush