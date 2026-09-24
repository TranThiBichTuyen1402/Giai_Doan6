@extends('client.public-wedding-card')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;1,400&family=Montserrat:wght@300;400;500;600&family=Great+Vibes&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --korean-bg: #fffbf7;
        --korean-pink: #e8a598;
        --korean-soft-pink: #fdf2f0;
        --korean-text: #4a403a;
        --korean-gold: #c5a059;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--korean-bg);
        color: var(--korean-text);
    }

    /* Overlay nền hoa văn pastel nhẹ nhàng */
    .page-bg-overlay-2 {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle, rgba(253,242,240,0.8) 0%, rgba(255,251,247,1) 100%),
                    url('https://www.transparenttextures.com/patterns/cream-paper.png');
        z-index: 0; pointer-events: none;
    }

    .mobile-card-wrapper-2 {
        position: relative; z-index: 3; width: 100%; max-width: 460px;
        margin: 0 auto; padding: 25px 18px 80px 18px; text-align: center;
    }

    /* Khung viền đôi phong cách Thiệp Giấy Tinh Tế */
    .paper-frame {
        background: transparent;
        border: none;
        box-shadow: none;
        border-radius: 0;
        padding: 30px 0;
        margin-bottom: 40px;
    }

    /* Badge Save The Date dạng tối giản */
    .save-date-badge-2 { 
        border-bottom: 2px solid var(--korean-pink);
        color: var(--korean-pink); 
        padding: 4px 16px; 
        font-size: 0.75rem; font-weight: 600; letter-spacing: 4px; 
        display: inline-block; margin-bottom: 15px; text-transform: uppercase;
    }

    .hero-title-2 { 
        font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; 
        color: var(--korean-text); line-height: 1.2; margin-bottom: 10px;
        letter-spacing: 0.5px;
    }

    .names-script-2 { 
        font-family: 'Great Vibes', cursive; 
        color: var(--korean-pink);
        font-size: 3.8rem; 
        margin: 15px 0 20px 0; 
        line-height: 1;
    }

    /* Countdown phong cách ô vuông bo góc tròn thanh lịch */
    .countdown-flex-2 { display: flex; justify-content: center; gap: 12px; margin: 20px 0; }
    .time-box-2 { 
        background: var(--korean-soft-pink); 
        border-radius: 14px; padding: 10px 6px; min-width: 65px; 
        text-align: center;
    }
    .time-box-2 span { font-size: 1.3rem; font-weight: 700; display: block; color: var(--korean-pink); }
    .time-box-2 small { font-size: 0.6rem; color: #8c7a6b; font-weight: 500; text-transform: uppercase; }

    /* Ảnh Bìa dạng khung bo tròn mềm mại */
    .cover-photo-card-2 {
        width: 100%; height: 320px; object-fit: cover; border-radius: 120px 120px 20px 20px;
        margin-bottom: 24px; border: 4px solid #ffffff; 
        box-shadow: 0 12px 25px rgba(0,0,0,0.06);
    }

    .card-header-title-2 {
        font-family: 'Playfair Display', serif; color: var(--korean-pink);
        font-weight: 700; font-size: 1.25rem; letter-spacing: 2px; 
        text-transform: uppercase; margin-bottom: 20px;
    }

    /* Layout Cặp đôi dạng Card xếp dọc bo góc */
    .couple-card-2 {
        background: transparent;
        border: none;
        box-shadow: none;
        border-radius: 0;
        padding: 12px 0;
        margin-bottom: 24px;
        text-align: center;
    }
    .couple-avatar-2 { 
        width: 90px; height: 90px; border-radius: 50%; object-fit: cover; 
        border: 4px solid #ffffff; margin-bottom: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* Album Ảnh dạng Grid dính tròn góc */
    .album-grid-2 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
    .album-grid-2 img { 
        width: 100%; height: 110px; object-fit: cover; border-radius: 14px; 
    }

    /* Nút RSVP Hồng Pastel Nổi Bật */
    .btn-rsvp-korean { 
        background: var(--korean-pink); 
        color: #ffffff; font-weight: 600; font-size: 0.95rem; 
        padding: 15px 28px; border-radius: 50px; border: none; width: 100%; 
        box-shadow: 0 10px 25px rgba(232, 165, 152, 0.4); 
        margin-bottom: 20px; letter-spacing: 1px; transition: all 0.2s;
    }
    .btn-rsvp-korean:hover { background: #d99183; color: #fff; }

    .btn-call-2 {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        border: none;
        box-shadow: none;
        color: var(--korean-pink);
        padding: 0;
        margin-top: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .couple-divider {
        width: 70px;
        margin: 18px auto 28px;
        border: 0;
        border-top: 1px solid rgba(232,165,152,.35);
    }

    /* Style tùy chỉnh cho các form / input chìm pastel */
    .paper-frame .form-control, .paper-frame .form-select {
        background-color: var(--korean-soft-pink);
        border: 1px solid rgba(232, 165, 152, 0.3);
        color: var(--korean-text);
        border-radius: 12px;
    }
    .paper-frame .form-control::placeholder {
        color: #a3958a;
    }
    .paper-frame .form-control:focus, .paper-frame .form-select:focus {
        background-color: #ffffff;
        border-color: var(--korean-pink);
        box-shadow: 0 0 0 0.25rem rgba(232, 165, 152, 0.25);
    }
  /* =========================================================
   EDITOR MODE - CÂY BÚT GIỐNG TEMPLATE 1
   ========================================================= */

.editor-mode [data-field] {
    cursor: text;
    border-radius: 6px;
    transition: all .2s ease;
    position: relative;
}

.editor-mode [data-field]:hover {
    background: rgba(232, 165, 152, 0.12);
    outline: 1px dashed rgba(232, 165, 152, 0.8);
}

.editor-mode [data-field]:focus,
.editor-mode .editor-editing {
    background: #ffffff !important;
    color: #4a403a !important;
    outline: 2px solid var(--korean-pink) !important;
    box-shadow: 0 4px 15px rgba(232, 165, 152, .20);
    padding: 3px 7px;
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
    <div class="page-bg-overlay-2"></div>

    <div class="mobile-card-wrapper-2 {{ !empty($isDemo) ? 'editor-preview' : '' }}">
        
        <div class="paper-frame">
            <div>
                <span class="save-date-badge-2"><i class="bi bi-stars me-1"></i> SAVE THE DATE</span>
            </div>

            <h1 class="hero-title-2">Lễ Thành Hôn</h1>
            <p style="font-size: 0.85rem; color: #7a6e65; line-height: 1.6;" data-field="invitation_msg">
                {{ $card->invitation_msg ?? 'Trân trọng kính mời bạn đến tham dự và chung vui cùng gia đình chúng mình.' }}
            </p>

            <div class="names-script-2">
                <span data-field="groom_name">{{ $card->groom_name ?? 'Trần Đức' }}</span> & <span data-field="bride_name">{{ $card->bride_name ?? 'Thu Thảo' }}</span>
            </div>

            <div class="countdown-flex-2">
                <div class="time-box-2"><span id="cd-days">00</span><small>Ngày</small></div>
                <div class="time-box-2"><span id="cd-hours">00</span><small>Giờ</small></div>
                <div class="time-box-2"><span id="cd-mins">00</span><small>Phút</small></div>
                <div class="time-box-2"><span id="cd-secs">00</span><small>Giây</small></div>
            </div>

          {{-- Dán đoạn này vào Template 2 hệt như Template 1 --}}
@if(!empty($card->voice_invite))
    <div class="mb-4 text-center">
        <button type="button" 
                class="btn rounded-pill px-4 py-2 btn-sm fw-bold shadow-sm text-white" 
                style="background: linear-gradient(135deg, #e17575, #c85a5a); border: 1px solid #f3a6a6;" 
                onclick="playVoice('{{ asset('storage/' . $card->voice_invite) }}')">
            <i class="bi bi-play-circle-fill me-1"></i> Phát Lời Mời Từ Cặp Đôi
        </button>
    </div>
@endif
        </div>

        <img id="preview_cover_img" src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800&q=80' }}" class="cover-photo-card-2">

        <div class="paper-frame">
            <div class="card-header-title-2">THÔNG TIN HAI HỌ</div>
            <div class="row text-center small">
                <div class="col-6 border-end">
                    <strong class="d-block mb-1" style="color: var(--korean-pink);">NHÀ TRAI</strong>
                    <div class="text-muted">Bố: <span class="fw-bold" style="color: var(--korean-text);" data-field="groom_father">{{ $card->groom_father ?? 'Đinh Văn A' }}</span></div>
                    <div class="text-muted">Mẹ: <span class="fw-bold" style="color: var(--korean-text);" data-field="groom_mother">{{ $card->groom_mother ?? 'Nguyễn Thị B' }}</span></div>
                </div>
                <div class="col-6">
                    <strong class="d-block mb-1" style="color: var(--korean-pink);">NHÀ GÁI</strong>
                    <div class="text-muted">Bố: <span class="fw-bold" style="color: var(--korean-text);" data-field="bride_father">{{ $card->bride_father ?? 'Trần Văn C' }}</span></div>
                    <div class="text-muted">Mẹ: <span class="fw-bold" style="color: var(--korean-text);" data-field="bride_mother">{{ $card->bride_mother ?? 'Lê Thị D' }}</span></div>
                </div>
            </div>
        </div>

        <div class="paper-frame">
            <div class="card-header-title-2">THỜI GIAN & ĐỊA ĐIỂM</div>
            
            <div class="fw-bold fs-3 mb-1" style="font-family: 'Playfair Display', serif; color: var(--korean-pink);" data-field="wedding_date">
                {{ $card->wedding_date ?? '20 Tháng 10, 2026' }}
            </div>
            
            <div class="small mb-1" style="color: #8c7a6b; font-weight: 500;" data-field="lunar_date">
                {{ $card->lunar_date ?? 'Tức Ngày 10 Tháng 09 Năm Bính Ngọ' }}
            </div>

            <div class="text-muted small mb-3"><i class="bi bi-clock me-1"></i>Vào lúc <span data-field="wedding_time">{{ $card->wedding_time ?? '08:00 Sáng' }}</span></div>
            
            <p class="small fw-semibold mb-3 px-2" style="line-height: 1.6;">
                <i class="bi bi-geo-alt-fill me-1" style="color: var(--korean-pink);"></i>
                <span data-field="wedding_location">{{ $card->wedding_location ?? 'Sảnh Rose, Trung tâm Hội nghị MerPerle, TP.HCM' }}</span>
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
       class="btn btn-sm rounded-pill px-4 py-2 text-white fw-semibold" 
       style="background: var(--korean-pink); font-size: 0.78rem;">
        <i class="bi bi-map-fill me-1"></i> Xem Chỉ Đường Maps
    </a>
        </div>

        <div class="paper-frame">
            <div class="card-header-title-2">THÔNG TIN CẶP ĐÔI</div>
            
            <div class="couple-card-2">
                <img id="preview_groom_avatar" src="{{ !empty($card->groom_avatar) ? asset($card->groom_avatar) : 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80' }}" class="couple-avatar-2">
                <div class="fw-bold fs-6" style="color: var(--korean-text);">CHÚ RỂ: <span data-field="groom_name">{{ $card->groom_name ?? 'Trần Đức' }}</span></div>
                <p class="small text-muted mb-1" style="font-size: 0.78rem;" data-field="groom_bio">{{ $card->groom_bio ?? 'Chàng trai kiên định, kỷ luật & ấm áp.' }}</p>
                @if(!empty($card->groom_phone))
                    <a href="tel:{{ $card->groom_phone }}" class="btn-call-2"><i class="bi bi-telephone-fill"></i> Gọi Chú Rể</a>
                @endif
            </div>

            <hr class="couple-divider">

            <div class="couple-card-2">
                <img id="preview_bride_avatar" src="{{ !empty($card->bride_avatar) ? asset($card->bride_avatar) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&q=80' }}" class="couple-avatar-2">
                <div class="fw-bold fs-6" style="color: var(--korean-text);">CÔ DÂU: <span data-field="bride_name">{{ $card->bride_name ?? 'Thu Thảo' }}</span></div>
                <p class="small text-muted mb-1" style="font-size: 0.78rem;" data-field="bride_bio">{{ $card->bride_bio ?? 'Cô gái tinh tế, tràn đầy năng lượng & yêu nghệ thuật.' }}</p>
                @if(!empty($card->bride_phone))
                    <a href="tel:{{ $card->bride_phone }}" class="btn-call-2"><i class="bi bi-telephone-fill"></i> Gọi Cô Dâu</a>
                @endif
            </div>
        </div>

        <div class="paper-frame">
            <div class="card-header-title-2"><i class="bi bi-clock-history me-1"></i> LỊCH TRÌNH CƯỚI</div>
            <div class="d-flex justify-content-around text-center">
                <div>
                    <div class="fw-bold fs-5" style="color: var(--korean-pink);" data-field="time_welcome">{{ $card->time_welcome ?? '17:30' }}</div>
                    <small class="text-muted fw-semibold">Đón Khách</small>
                </div>
                <div class="border-start border-end px-3">
                    <div class="fw-bold fs-5" style="color: var(--korean-pink);" data-field="time_ceremony">{{ $card->time_ceremony ?? '18:30' }}</div>
                    <small class="text-muted fw-semibold">Làm Lễ</small>
                </div>
                <div>
                    <div class="fw-bold fs-5" style="color: var(--korean-pink);" data-field="time_party">{{ $card->time_party ?? '19:00' }}</div>
                    <small class="text-muted fw-semibold">Khai Tiệc</small>
                </div>
            </div>
        </div>

        <div class="paper-frame">
            <div class="card-header-title-2"><i class="bi bi-images me-1"></i> ALBUM KỶ NIỆM</div>
            @php
                $album = is_string($card->album_imgs ?? null) ? json_decode($card->album_imgs, true) : ($card->album_imgs ?? []);
            @endphp
            <div class="album-grid-2">
                @if(!empty($album) && count($album) > 0)
                    @foreach(array_slice($album, 0, 3) as $img)
                        <img src="{{ asset($img) }}">
                    @endforeach
                @else
                    <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300&q=80">
                    <img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=300&q=80">
                    <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=300&q=80">
                @endif
            </div>
        </div>

        @if(!empty($card->wedding_video))
            <div class="paper-frame">
                <div class="card-header-title-2"><i class="bi bi-film me-1"></i> VIDEO CƯỚI</div>
                <video controls class="w-100 rounded-4 shadow-sm">
                    <source src="{{ asset($card->wedding_video) }}" type="video/mp4">
                </video>
            </div>
        @endif

       <div class="paper-frame">
    <div class="card-header-title-2"><i class="bi bi-camera me-1"></i> WEDDING MOMENTS</div>
    <p class="small text-muted mb-3">Chia sẻ khoảnh khắc cùng cô dâu chú rể</p>
    
    {{-- Form gửi dữ liệu thật về Backend --}}
    <form action="{{ route('guest.upload_photo', $card->id ?? 2 ) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="photos[]" class="form-control mb-3" accept="image/*" multiple required>
        <button type="submit" class="btn text-white rounded-pill px-4 fw-semibold" style="background: var(--korean-pink);">
            <i class="bi bi-cloud-upload me-1"></i> Tải ảnh
        </button>
    </form>
</div>
{{-- TRA CỨU BÀN TIỆC --}}
@php
    // Kiểm tra xem đang ở giao diện Editor (chỉnh sửa/dùng thử) hay trang xem thiệp thực tế
    $isEditorMode = request()->boolean('editor');
    $isVipCard = !empty($card->is_vip);
@endphp

{{-- Hiển thị nếu: Thiệp đã VIP HOẶC đang mở ở chế độ Editor --}}
@if($isVipCard || $isEditorMode)
<div class="paper-frame">

    {{-- NẾU CHƯA VIP & ĐANG TRONG EDITOR: HIỆN BADGE VIP VÀ THÔNG BÁO NHẮC NHỞ --}}
    @if(!$isVipCard && $isEditorMode)
        <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" style="border-color: rgba(232, 165, 152, 0.3) !important;">
            <span class="badge fw-bold px-2 py-1" style="background: var(--korean-pink); color: #fff; font-size: 0.72rem;">
                👑 TÍNH NĂNG VIP
            </span>
            <small class="fst-italic" style="color: #d97706; font-size: 0.75rem;">
                *Cần Nâng VIP & Tạo tài khoản để khách dùng được tính năng này
            </small>
        </div>
    @endif

    <div class="card-header-title-2">
        <i class="bi bi-search me-1"></i> TRA CỨU BÀN TIỆC
    </div>
    <p class="small text-muted mb-3" style="font-size: 0.82rem;">
        Nhập tên của bạn để xem vị trí chỗ ngồi nhé!
    </p>

    <!-- Thanh tìm kiếm chuẩn Korean Style -->
    <div class="input-group shadow-sm rounded-pill overflow-hidden p-1" style="background: var(--korean-soft-pink); border: 1px solid rgba(232, 165, 152, 0.4);">
        <input id="guestNameInput"
               type="text" 
               class="form-control border-0 bg-transparent text-center px-3" 
               style="font-size: 0.88rem; height: 40px; color: var(--korean-text);"
               placeholder="Hãy nhập tên của bạn...">
               
        <button type="button" 
        id="btnSearchSeat" 
        class="btn btn-warning fw-bold text-dark px-3 text-nowrap" 
        style="font-size: 0.9rem; height: 40px; display: flex; align-items: center;">
    Tra Cứu
</button>
    </div>
    <!-- Kết quả trả về -->
    <div id="seatResultArea" class="mt-3 fw-bold" style="color: var(--korean-pink); font-size: 0.95rem;"></div>
</div>
@endif
        <div class="paper-frame">
    <div class="card-header-title-2"><i class="bi bi-qr-code-scan me-1"></i> HỘP MỪNG CƯỚI</div>
    <div class="row g-2 text-center">
        <div class="col-6 border-end pe-2">
            <div style="background: var(--korean-soft-pink); padding: 12px; border-radius: 14px;">
                <div class="fw-bold small" style="color: var(--korean-pink);">Mừng Cưới Chú Rể</div>
                <div class="text-muted extra-small mt-1" data-field="groom_bank_name">{{ $card->groom_bank_name ?? 'Vietcombank' }}</div>
                
                <div class="fw-bold my-1" style="font-size:0.9rem; color: var(--korean-pink);" data-field="groom_bank_acc">
                    {{ (!empty($card->groom_bank_acc) && !str_contains($card->groom_bank_acc, 'xxx')) ? $card->groom_bank_acc : '107437858458' }}
                </div>
                
                <div class="text-muted extra-small" data-field="groom_bank_owner">{{ $card->groom_bank_owner ?? 'TRAN DUC' }}</div>
                @if(!empty($card->groom_bank_qr))
                    <img src="{{ asset($card->groom_bank_qr) }}" onclick="window.open(this.src)" class="img-fluid rounded-3 mt-2 shadow-sm" style="max-width:130px; cursor:pointer;">
                @endif
            </div>
        </div>

        <div class="col-6 ps-2">
            <div style="background: var(--korean-soft-pink); padding: 12px; border-radius: 14px;">
                <div class="fw-bold small" style="color: var(--korean-pink);">Mừng Cưới Cô Dâu</div>
                <div class="text-muted extra-small mt-1" data-field="bride_bank_name">{{ $card->bride_bank_name ?? 'Techcombank' }}</div>
                
                <div class="fw-bold my-1" style="font-size:0.9rem; color: var(--korean-pink);" data-field="bride_bank_acc">
                    {{ (!empty($card->bride_bank_acc) && !str_contains($card->bride_bank_acc, 'xxx')) ? $card->bride_bank_acc : '190123456789' }}
                </div>
                
                <div class="text-muted extra-small" data-field="bride_bank_owner">{{ $card->bride_bank_owner ?? 'THU THAO' }}</div>
                @if(!empty($card->bride_bank_qr))
                    <img src="{{ asset($card->bride_bank_qr) }}" onclick="window.open(this.src)" class="img-fluid rounded-3 mt-2 shadow-sm" style="max-width:130px; cursor:pointer;">
                @endif
            </div>
        </div>
    </div>
</div>

        @if(!empty($card->voice_thanks))
            <div class="paper-frame">
                <div class="card-header-title-2"><i class="bi bi-mic-fill me-1"></i> LỜI CẢM ƠN</div>
                <p class="small text-muted mb-3">Sau buổi tiệc, cô dâu chú rể gửi lời cảm ơn đến tất cả khách mời.</p>
                <button class="btn rounded-pill px-4 text-white fw-semibold" style="background: var(--korean-pink);" onclick="playVoice('{{ asset($card->voice_thanks) }}')">
                    <i class="bi bi-volume-up-fill me-1"></i> Nghe lời cảm ơn
                </button>
            </div>
        @endif

       {{-- LỜI CHÚC MỪNG --}}
        <div class="paper-frame">
            <div class="card-header-title-2"><i class="bi bi-chat-heart me-1"></i> LỜI CHÚC MỪNG</div>
            <p class="small text-muted mb-3" style="font-size: 0.85rem;">
                Hãy gửi những lời chúc tốt đẹp hoặc lời chúc bằng giọng nói đến cặp đôi nhé!
            </p>

            <button type="button" class="btn btn-outline-danger rounded-pill px-4 py-2 w-100 fw-semibold shadow-sm mb-3" 
                    style="color: var(--korean-pink); border-color: var(--korean-pink);" 
                    data-bs-toggle="modal" data-bs-target="#wishModal">
                <i class="bi bi-mic-fill me-1"></i> GỬI LỜI CHÚC / GHI ÂM
            </button>
        </div>

        <div class="paper-frame pt-0">
            <button class="btn btn-rsvp-korean" data-bs-toggle="modal" data-bs-target="#rsvpModal">
                <i class="bi bi-envelope-check-fill me-1.5"></i> XÁC NHẬN THAM DỰ (RSVP)
            </button>

            <p class="small text-muted italic" style="font-size: 0.82rem; line-height: 1.5; padding: 0 10px;" data-field="thank_msg">
                "{{ $card->thank_msg ?? 'Sự hiện diện của quý vị là niềm vinh hạnh lớn nhất của gia đình chúng tôi!' }}"
            </p>
        </div>
    </div>

{{-- MODAL GỬI LỜI CHÚC & THU ÂM TRỰC TIẾP / UPLOAD FILE --}}
<div class="modal fade" id="wishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow text-dark">
            <div class="modal-body p-4 text-start">
                <h5 class="fw-bold text-center mb-3" style="color: var(--korean-pink);">Gửi Lời Chúc Mừng</h5>
                <form id="wishForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tên của bạn</label>
                        <input type="text" id="wish_name" name="name" class="form-control rounded-pill px-3" required placeholder="Nhập tên của bạn">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lời chúc mừng</label>
                        <textarea id="wish_text" name="message" class="form-control rounded-3 px-3" rows="3" placeholder="Nhập lời chúc tốt đẹp nhất..."></textarea>
                    </div>

                    {{-- TÙY CHỌN 1: UPLOAD FILE GHI ÂM --}}
                    <div class="mb-3">
                        <label class="form-label small fw-bold"><i class="bi bi-file-earmark-music text-danger me-1"></i> Tải file lời chúc âm thanh</label>
                        <input type="file" id="wish_voice_file" accept="audio/*" class="form-control form-control-sm rounded-pill px-3">
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">(Chấp nhận MP3, WAV, M4A... Max 10MB)</small>
                    </div>

                    <div class="text-center text-muted small my-2 fw-bold">Hoặc</div>

                    {{-- TÙY CHỌN 2: THU ÂM TRỰC TIẾP --}}
                    <div class="mb-3 p-3 border rounded-4 bg-light text-center">
                        <label class="form-label small fw-bold d-block mb-2"><i class="bi bi-mic-fill text-danger me-1"></i> Gửi kèm Giọng nói trực tiếp</label>
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <button type="button" id="btnRecord" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold">
                                <i class="bi bi-record-circle me-1"></i> Bấm để ghi âm
                            </button>
                            <span id="recordTimer" class="small text-danger fw-bold d-none">00:00</span>
                        </div>
                        <audio id="audioPreview" controls class="w-100 mt-2 d-none"></audio>
                    </div>

                    <button type="submit" id="btnSubmitWish" class="btn text-white w-100 rounded-pill py-2.5 fw-bold mt-2" style="background: var(--korean-pink);">GỬI LỜI CHÚC</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: var(--korean-pink);"><i class="bi bi-envelope-heart me-2"></i>Xác Nhận Tham Dự</h5>
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
