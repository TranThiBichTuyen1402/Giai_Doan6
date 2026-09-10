@extends('client.public-wedding-card')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&family=Quicksand:wght@400;500;600;700&family=Pattaya&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
    :root {
        --sweet-pink: #ffb6c1;
        --dark-pink: #ff4d6d;
        --soft-pink: #fff0f3;
        --sweet-white: #ffffff;
    }

    body, html {
        margin: 0; padding: 0;
        height: 100%; width: 100%;
        font-family: 'Quicksand', sans-serif;
        background-color: var(--soft-pink);
        overflow: hidden; /* Khóa cuộn để dùng trình chiếu */
    }

    /* Hiệu ứng bong bóng trái tim bay */
    .heart-bg {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 1; pointer-events: none;
    }

    .mobile-card-wrapper-5 {
        position: relative; z-index: 10;
        width: 100%; max-width: 450px;
        height: 100vh; margin: 0 auto;
        overflow: hidden;
    }

    /* Khung trình chiếu (8 slide = 800%) */
    .slides-container {
        display: flex;
        width: 800%;
        height: 100%;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .slide-page {
        width: 12.5%; /* 100% / 8 slide */
        height: 100%;
        display: flex; flex-direction: column;
        justify-content: center; align-items: center;
        padding: 40px 20px; text-align: center;
        box-sizing: border-box;
        position: relative;
    }

    /* Nội dung Slide */
    .sweet-paper {
        width: 100%;
        max-width: 900px;
        background: transparent;
        border: none;
        border-radius: 0;
        box-shadow: none;
        padding: 20px 15px;
    }

    .hero-names-5 {
        font-family: 'Dancing Script', cursive;
        color: var(--dark-pink); font-size: 3.8rem;
        margin-bottom: 10px; line-height: 1;
    }

    .slide-img-circle {
        width: 180px; height: 180px;
        border-radius: 50%; object-fit: cover;
        border: 6px solid #fff;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        margin: 10px auto;
    }

    /* Nút điều hướng */
    .nav-buttons {
        position: absolute; bottom: 30px;
        left: 0; width: 100%;
        display: flex; justify-content: space-around;
        padding: 0 40px; z-index: 20;
    }

    .btn-nav {
        background: var(--dark-pink);
        color: #fff; border: none;
        border-radius: 50px; padding: 12px 25px;
        font-weight: 700; font-size: 0.9rem;
        box-shadow: 0 8px 20px rgba(255, 77, 109, 0.4);
        cursor: pointer;
    }

    .btn-nav:disabled { background: #ccc; box-shadow: none; cursor: not-allowed; }

    /* Countdown Slide */
    .countdown-sweet { display: flex; justify-content: center; gap: 10px; margin-top: 15px; }
    .cd-item { background: var(--soft-pink); padding: 8px; border-radius: 12px; min-width: 55px; }
    .cd-item span { color: var(--dark-pink); font-weight: 800; font-size: 1.1rem; display: block; }
    .cd-item small { font-size: 0.6rem; text-transform: uppercase; }

    /* STK Card */
    .stk-box { background: var(--soft-pink); padding: 12px; border-radius: 20px; margin-bottom: 12px; border: 1px dashed var(--dark-pink); }
    .stk-box strong { color: var(--dark-pink); font-size: 1rem; }
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
<div class="heart-bg" id="heart-bg"></div>

<div class="mobile-card-wrapper-5">
    
    <div class="slides-container" id="slides-container">
        
        <div class="slide-page">
            <div class="animate__animated animate__zoomIn">
                <span class="badge rounded-pill px-4 py-2 mb-3" style="background: var(--dark-pink);">OUR SWEET STORY</span>
                <h1 class="hero-names-5">
                    <span data-field="groom_name">{{ $card->groom_name ?? 'Bảo Lâm' }}</span> <br>& <span data-field="bride_name">{{ $card->bride_name ?? 'Mẫn Nhi' }}</span>
                </h1>
                <p class="text-muted mt-3 px-3">Chào mừng bạn đến với chuyến tàu hạnh phúc của tụi mình!</p>
                <div class="animate__animated animate__pulse animate__infinite">
                    <i class="bi bi-arrow-right-circle-fill text-danger fs-1"></i>
                </div>
                <p class="small text-muted mt-2">Bấm "Tiếp theo" để xem thiệp nhé</p>
                @if(!empty($card->voice_invite))
                    <button class="btn btn-sm btn-outline-danger rounded-pill mt-3 px-4" onclick="playVoice('{{ asset($card->voice_invite) }}')">
                        <i class="bi bi-volume-up-fill me-1"></i> Phát lời chào
                    </button>
                @endif
            </div>
        </div>

        <div class="slide-page">
            <div class="sweet-paper">
                <h4 class="fw-bold" style="color: var(--dark-pink); font-family: 'Pattaya', sans-serif;">Chú Rể Kẹo Ngọt</h4>
                <div class="row align-items-center">
                    <div class="col-12">
                        <img id="preview_groom_avatar" src="{{ !empty($card->groom_avatar) ? asset($card->groom_avatar) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80' }}" class="slide-img-circle" style="border-color: #bbdefb;">
                        <h6 class="fw-bold mb-1">CHÚ RỂ: <span data-field="groom_name">{{ $card->groom_name ?? 'Bảo Lâm' }}</span></h6>
                        <p class="text-muted small px-3 mb-2" data-field="groom_bio">{{ $card->groom_bio ?? 'Yêu màu hồng, ghét sự giả dối.' }}</p>
                        @if(!empty($card->groom_phone))
                            <a id="groom_phone_link" href="tel:{{ $card->groom_phone }}" class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-telephone me-1"></i> <span data-field="groom_phone">{{ $card->groom_phone }}</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="slide-page">
            <div class="sweet-paper">
                <h4 class="fw-bold" style="color: var(--dark-pink); font-family: 'Pattaya', sans-serif;">Nàng Công Chúa</h4>
                <div class="col-12">
                    <img id="preview_bride_avatar" src="{{ !empty($card->bride_avatar) ? asset($card->bride_avatar) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80' }}" class="slide-img-circle" style="border-color: #f8bbd0;">
                    <h6 class="fw-bold mb-1">CÔ DÂU: <span data-field="bride_name">{{ $card->bride_name ?? 'Mẫn Nhi' }}</span></h6>
                    <p class="text-muted small px-3 mb-2" data-field="bride_bio">{{ $card->bride_bio ?? 'Thích bánh ngọt, yêu anh Lâm.' }}</p>
                    @if(!empty($card->bride_phone))
                        <a id="bride_phone_link" href="tel:{{ $card->bride_phone }}" class="btn btn-sm btn-outline-danger rounded-pill">
                            <i class="bi bi-telephone me-1"></i> <span data-field="bride_phone">{{ $card->bride_phone }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="slide-page">
            <div class="sweet-paper">
                <h4 class="fw-bold mb-3" style="color: var(--dark-pink); font-family: 'Pattaya', sans-serif;">Thông Tin Gia Đình</h4>
                <div class="row text-center small mb-3">
                    <div class="col-6 border-end">
                        <strong class="d-block text-danger mb-1">NHÀ TRAI</strong>
                        <div class="text-muted">Bố: <span class="fw-bold text-dark" data-field="groom_father">{{ $card->groom_father ?? 'Đinh Văn A' }}</span></div>
                        <div class="text-muted">Mẹ: <span class="fw-bold text-dark" data-field="groom_mother">{{ $card->groom_mother ?? 'Nguyễn Thị B' }}</span></div>
                    </div>
                    <div class="col-6">
                        <strong class="d-block text-danger mb-1">NHÀ GÁI</strong>
                        <div class="text-muted">Bố: <span class="fw-bold text-dark" data-field="bride_father">{{ $card->bride_father ?? 'Trần Văn C' }}</span></div>
                        <div class="text-muted">Mẹ: <span class="fw-bold text-dark" data-field="bride_mother">{{ $card->bride_mother ?? 'Lê Thị D' }}</span></div>
                    </div>
                </div>

                <hr class="my-2" style="border-color: var(--sweet-pink);">

                <h5 class="fw-bold text-danger mt-2 mb-2">Lịch Trình Hôn Lễ</h5>
                <div class="d-flex justify-content-around text-center small">
                    <div>
                        <strong class="d-block text-dark" data-field="time_welcome">{{ $card->time_welcome ?? '17:30' }}</strong>
                        <small class="text-muted">Đón Khách</small>
                    </div>
                    <div>
                        <strong class="d-block text-dark" data-field="time_ceremony">{{ $card->time_ceremony ?? '18:30' }}</strong>
                        <small class="text-muted">Làm Lễ</small>
                    </div>
                    <div>
                        <strong class="d-block text-dark" data-field="time_party">{{ $card->time_party ?? '19:00' }}</strong>
                        <small class="text-muted">Khai Tiệc</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="slide-page">
            <div class="sweet-paper">
                <h4 class="fw-bold mb-2" style="color: var(--dark-pink); font-family: 'Pattaya', sans-serif;">Ngày Chung Đôi</h4>
                <img id="preview_cover_img" src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=400&q=80' }}" class="rounded-4 w-100 mb-2 shadow-sm" style="height: 140px; object-fit: cover;">
                
                <div class="fs-5 fw-bold text-dark" data-field="wedding_date">{{ $card->wedding_date ? \Carbon\Carbon::parse($card->wedding_date)->format('d / m / Y') : '14 / 02 / 2026' }}</div>
                <div class="small text-muted mb-1" data-field="lunar_date">{{ $card->lunar_date ?? 'Tức Ngày 27 Tháng 12 Năm Ất Tỵ' }}</div>
                <div class="fw-bold text-danger small" data-field="wedding_time">{{ $card->wedding_time ?? '18:00 PM' }}</div>

                <div class="countdown-sweet">
                    <div class="cd-item"><span id="cd-days">00</span><small>Ngày</small></div>
                    <div class="cd-item"><span id="cd-hours">00</span><small>Giờ</small></div>
                    <div class="cd-item"><span id="cd-mins">00</span><small>Phút</small></div>
                </div>
                
                <p class="small fw-bold mt-2 text-danger mb-1"><i class="bi bi-geo-alt-fill"></i> <span data-field="wedding_location">{{ $card->wedding_location ?? 'White Palace, TP.HCM' }}</span></p>
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
           class="btn btn-sm rounded-pill px-4 py-2 text-white fw-semibold shadow-sm" 
           style="background: var(--accent-rose, #e11d48); font-size: 0.85rem; position: relative; z-index: 9999; pointer-events: auto !important; display: inline-block;">
            <i class="bi bi-map-fill me-1"></i> Xem Chỉ Đường Maps
        </a>
            </div>
        </div>

      <div class="slide-page">
    <div class="sweet-paper">
        <h4 class="fw-bold mb-2" style="color: var(--dark-pink); font-family: 'Pattaya', sans-serif;">Khoảnh Khắc Ngọt Ngào</h4>
        
        @php
            $album = is_string($card->album_imgs ?? null) ? json_decode($card->album_imgs, true) : ($card->album_imgs ?? []);
        @endphp
        <div class="row g-2 mb-2">
            @if(!empty($album) && count($album) > 0)
                @foreach(array_slice($album, 0, 4) as $img)
                    <div class="col-6"><img src="{{ asset($img) }}" class="img-fluid rounded-3" style="height:70px; object-fit:cover; width:100%;"></div>
                @endforeach
            @else
                <div class="col-6"><img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300" class="img-fluid rounded-3" style="height:70px; object-fit:cover; width:100%;"></div>
                <div class="col-6"><img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=300" class="img-fluid rounded-3" style="height:70px; object-fit:cover; width:100%;"></div>
            @endif
        </div> {{-- Đóng row g-2 --}}

        @if(!empty($card->wedding_video))
            <video controls class="w-100 rounded-3 mb-2" style="max-height: 100px;">
                <source src="{{ asset($card->wedding_video) }}" type="video/mp4">
            </video>
        @endif

        {{-- WEDDING MOMENTS --}}
        <div class="white-card">
            <div class="card-header-title">Wedding Moments</div>
            <p class="small text-muted">Chia sẻ khoảnh khắc cùng cô dâu chú rể</p>

            {{-- Form gửi ảnh thật về Server --}}
            <form action="{{ route('guest.upload_photo', $card->id ?? 5) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="photos[]" class="form-control" accept="image/*" multiple required>
                <button type="submit" class="btn btn-danger mt-3">Tải ảnh</button>
            </form>
        </div>
    </div> {{-- Đóng sweet-paper --}}
</div> {{-- Đóng slide-page --}}

{{-- SLIDE: TRA CỨU BÀN TIỆC ANALOG STYLE --}}
@php
    $isEditorMode = request()->boolean('editor');
    $isVipCard = !empty($card->is_vip);
@endphp

@if($isVipCard || $isEditorMode)
<div class="slide-page">
    <div class="sweet-paper">

        @if(!$isVipCard && $isEditorMode)
            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" style="border-color: rgba(0, 0, 0, 0.1) !important;">
                <span class="badge fw-bold px-2 py-1 font-mono" style="background: var(--analog-accent, var(--dark-pink, #e11d48)); color: #fff; font-size: 0.72rem;">
                    👑 TÍNH NĂNG VIP
                </span>
                <small class="fst-italic" style="color: #d97706; font-size: 0.75rem;">
                    *Cần Nâng VIP & Tạo tài khoản để khách dùng được tính năng này
                </small>
            </div>
        @endif

        <div class="font-mono text-uppercase text-muted mb-2">SEATING CHART</div>
        <h4 class="fw-bold mb-3 font-mono text-uppercase" style="color: var(--analog-accent, var(--dark-pink)); font-size: 1.4rem;">
            <i class="bi bi-search me-1"></i> Tra Cứu Bàn Tiệc
        </h4>
        
        <p class="small text-muted mb-3">Nhập tên của bạn để tìm nhanh vị trí chỗ ngồi trong tiệc cưới nhé!</p>

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
                class="btn-outline-analog w-100 fw-bold">
            <i class="bi bi-search me-1"></i> TÌM BÀN TIỆC
        </button>

        <!-- Thẻ hiển thị kết quả chuẩn -->
        <div id="seatResultArea" class="mt-3 fw-bold font-mono" style="color: var(--analog-accent, var(--dark-pink)); font-size: 0.95rem;"></div>
    </div> {{-- Đóng sweet-paper --}}
</div> {{-- Đóng slide-page --}}
@endif
        <div class="slide-page">
            <div class="sweet-paper">
                <h4 class="fw-bold mb-3 d-flex align-items-center justify-content-center gap-2" style="color: var(--dark-pink); font-family: 'Pattaya', sans-serif;">
                    <i class="bi bi-qr-code-scan"></i> Gửi Ngọt Ngào
                </h4>
                
                <div class="stk-box text-start">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="d-block text-muted">Chú rể - <span data-field="groom_bank_name">{{ $card->groom_bank_name ?? 'Vietcombank' }}</span></small>
                            <strong class="d-block" data-field="groom_bank_acc">
                                {{ (!empty($card->groom_bank_acc) && !str_contains($card->groom_bank_acc, 'xxx')) ? $card->groom_bank_acc : '123456789' }}
                            </strong>
                            <small class="text-muted fw-bold" data-field="groom_bank_owner">{{ $card->groom_bank_owner ?? 'BAO LAM' }}</small>
                        </div>
                        @if(!empty($card->groom_bank_qr))
                            <img src="{{ asset($card->groom_bank_qr) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                    </div>
                </div>
                
                <div class="stk-box text-start">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="d-block text-muted">Cô dâu - <span data-field="bride_bank_name">{{ $card->bride_bank_name ?? 'Techcombank' }}</span></small>
                            <strong class="d-block" data-field="bride_bank_acc">
                                {{ (!empty($card->bride_bank_acc) && !str_contains($card->bride_bank_acc, 'xxx')) ? $card->bride_bank_acc : '987654321' }}
                            </strong>
                            <small class="text-muted fw-bold" data-field="bride_bank_owner">{{ $card->bride_bank_owner ?? 'MAN NHI' }}</small>
                        </div>
                        @if(!empty($card->bride_bank_qr))
                            <img src="{{ asset($card->bride_bank_qr) }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                        @endif
                    </div>
                </div>

                @if(!empty($card->voice_thanks))
                    <button class="btn btn-sm btn-outline-danger rounded-pill mb-2 px-3" onclick="playVoice('{{ asset($card->voice_thanks) }}')">
                        <i class="bi bi-volume-up-fill me-1"></i> Nghe lời cảm ơn
                    </button>
                @endif

                <div class="d-flex flex-column gap-2 mt-1">
                    <button class="btn w-100 py-2 text-white fw-bold shadow-sm" style="background: var(--dark-pink); border-radius: 50px;" data-bs-toggle="modal" data-bs-target="#rsvpModal">
                        XÁC NHẬN RSVP
                    </button>
                    <button class="btn btn-outline-danger btn-sm rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#wishModal">
                        GỬI LỜI CHÚC / GHI ÂM
                    </button>
                </div>
                
                <p class="small text-muted mt-2 italic" data-field="thank_msg">"{{ $card->thank_msg ?? 'Tụi mình chờ bạn nhé!' }}"</p>
            </div>
        </div>

    </div>

    <div class="nav-buttons">
        <button class="btn-nav" id="prevBtn" disabled><i class="bi bi-chevron-left"></i></button>
        <button class="btn-nav" id="nextBtn"><i class="bi bi-chevron-right"></i></button>
    </div>

</div>

<div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-5 border-0">
            <div class="modal-body p-4 text-start">
                <h5 class="fw-bold text-center" style="color: var(--dark-pink);">Lời Xác Nhận</h5>
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
        <div class="modal-content rounded-5 border-0">
            <div class="modal-body p-4 text-start">
                <h5 class="fw-bold text-center mb-3" style="color: var(--dark-pink);"><i class="bi bi-chat-heart me-1"></i> Gửi Lời Chúc</h5>
                <div class="mb-2">
                    <input type="text" class="form-control rounded-pill mb-2" placeholder="Tên của bạn...">
                    <textarea class="form-control rounded-4" rows="3" placeholder="Viết lời chúc kẹo ngọt..."></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-danger rounded-pill w-50" onclick="recordVoice()">🎤 Ghi Âm</button>
                    <button type="button" class="btn btn-danger rounded-pill w-50 fw-bold" style="background: var(--dark-pink); border:none;" onclick="sendWish()">Gửi Chúc</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    let currentSlide = 0;
const slides = document.querySelectorAll('.slide-page');
const totalSlides = slides.length;
    function updateSlide() {
        const container = document.getElementById('slides-container');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');

        if (container) {
            // Dịch chuyển chuẩn theo tỉ lệ 8 slide (100% / 8 = 12.5%)
            container.style.transform = `translateX(-${currentSlide * (100 / totalSlides)}%)`;
        }

        if (prevBtn) prevBtn.disabled = (currentSlide === 0);
        if (nextBtn) nextBtn.disabled = (currentSlide === totalSlides - 1);
    }

    function goToNextSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSlide();
        }
    }

    function goToPrevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlide();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Nút điều hướng chính
        document.getElementById('nextBtn')?.addEventListener('click', goToNextSlide);
        document.getElementById('prevBtn')?.addEventListener('click', goToPrevSlide);

        // Nút mũi tên chuyển nhanh ở Slide 1
        document.querySelectorAll('.bi-arrow-right-circle-fill').forEach(icon => {
            const btn = icon.closest('button') || icon.parentElement;
            if (btn) {
                btn.style.cursor = 'pointer';
                btn.addEventListener('click', goToNextSlide);
            }
        });
    });
</script>
@endpush