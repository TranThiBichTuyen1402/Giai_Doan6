@extends('client.public-wedding-card')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Cormorant+Garamond:ital,wght@0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --bg-left: #ffffff;
        --bg-right: #fff5f5;
        --accent-rose: #e11d48;
        --accent-gold: #d97706;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --speed: 0.85s;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    body, html {
        height: 100%; width: 100%;
        overflow: hidden;
        background: #fff;
        font-family: 'Montserrat', sans-serif;
        color: var(--text-main);
    }

    .split-slider {
        position: relative;
        height: 100vh; width: 100vw;
        display: flex; overflow: hidden;
    }

    .slide-item {
        position: absolute; top: 0; left: 0;
        width: 100%; height: 100%;
        display: flex; z-index: 1;
        opacity: 0; visibility: hidden; pointer-events: none;
        transition: opacity var(--speed) ease, visibility var(--speed) ease;
    }

    .slide-item.active {
        z-index: 10; opacity: 1; visibility: visible; pointer-events: auto;
    }

    .side-left, .side-right {
        width: 50%; height: 100%;
        display: flex; align-items: center; justify-content: center;
        position: relative; overflow: hidden;
        transition: transform var(--speed) cubic-bezier(0.645, 0.045, 0.355, 1);
    }

    .side-left { transform: translateY(100%); background: var(--bg-left); }
    .side-right { transform: translateY(-100%); background: var(--bg-right); }

    .slide-item.active .side-left,
    .slide-item.active .side-right { transform: translateY(0); }

    .img-full { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; }
    .img-overlay-light { position: absolute; inset: 0; background: rgba(255, 255, 255, 0.45); }
    .img-overlay-dark { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.25); }

    .content-box {
        padding: 20px;
        text-align: center;
        width: 100%; max-width: 450px;
        z-index: 2; position: relative;
        opacity: 0;
        transition: opacity 0.5s ease 0.4s;
    }

    .slide-item.active .content-box { opacity: 1; }

    .font-serif { font-family: 'Cormorant Garamond', serif; }
    .font-script { font-family: 'Alex Brush', cursive; font-size: 4rem; color: var(--accent-gold); }

    .badge-tag {
        color: var(--accent-rose);
        font-size: 0.75rem; font-weight: 700;
        letter-spacing: 4px; display: inline-block; margin-bottom: 15px;
        text-transform: uppercase;
    }

    .cd-flex { display: flex; justify-content: center; gap: 20px; margin-top: 20px; }
    .cd-box span { font-size: 1.8rem; font-weight: 800; color: var(--accent-rose); display: block; line-height: 1; }
    .cd-box small { font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

    .controls { 
        position: fixed; 
        bottom: 30px; 
        left: 30px; /* Chuyển sang góc dưới BÊN TRÁI để không bị trùng tọa độ */
        display: flex; 
        flex-direction: column; 
        gap: 10px; 
        z-index: 999999 !important; 
        pointer-events: auto !important;
    }

    .btn-move {
        width: 46px; 
        height: 46px;
        border: 1px solid rgba(225, 29, 72, 0.3);
        background: rgba(255, 255, 255, 0.9);
        color: var(--accent-rose); 
        border-radius: 50%;
        display: flex; 
        align-items: center; 
        justify-content: center;
        transition: 0.3s; 
        cursor: pointer !important; 
        backdrop-filter: blur(4px);
        pointer-events: auto !important;
    }
    .btn-move:hover { background: var(--accent-rose); color: #fff; }

    .dots-nav {
        position: fixed; 
        left: 20px; 
        top: 50%; 
        transform: translateY(-50%);
        display: flex; 
        flex-direction: column; 
        gap: 12px; 
        z-index: 999999 !important;
        pointer-events: auto !important;
    }
    .dot { width: 8px; height: 8px; background: #fca5a5; border-radius: 50%; cursor: pointer; transition: 0.3s; }
    .dot.active { background: var(--accent-rose); transform: scale(1.5); }

    @media (max-width: 768px) {
        .split-slider { flex-direction: column; }
        .side-left, .side-right { width: 100%; height: 50%; }
        .side-left { transform: translateX(-100%); }
        .side-right { transform: translateX(100%); }
        .slide-item.active .side-left, .slide-item.active .side-right { transform: translateX(0); }
        .font-script { font-size: 3.2rem; }
    }
</style>
@endpush

@section('content')
@php
    $isEditor = request()->boolean('editor');
    $isVipCard = !empty($card->is_vip);
@endphp

@if($isEditor)
<script>
    document.body.classList.add('editor-mode');
</script>
@endif

<div class="split-slider">
    
    <!-- SLIDE 1: INTRO -->
    <div class="slide-item active">
        <div class="side-left">
            <img id="preview_cover_img" src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://images.unsplash.com/photo-1519741497674-611481863552?w=800' }}" class="img-full">
            <div class="img-overlay-dark"></div>
            <div class="content-box text-white">
                <span class="badge-tag text-white-50">Save The Date</span>
                <h1 class="font-serif fw-bold display-4" data-field="invitation_msg">Lễ Thành Hôn</h1>
            </div>
        </div>
        <div class="side-right">
            <div class="content-box">
                <div class="font-script mb-2">
                    <span data-field="groom_name">{{ $card->groom_name ?? 'Đinh Hà' }}</span> <br>&<br> <span data-field="bride_name">{{ $card->bride_name ?? 'Ngọc Bích' }}</span>
                </div>
                <div class="cd-flex">
                    <div class="cd-box"><span id="cd-days">00</span><small>Ngày</small></div>
                    <div class="cd-box"><span id="cd-hours">00</span><small>Giờ</small></div>
                    <div class="cd-box"><span id="cd-mins">00</span><small>Phút</small></div>
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
        </div>
    </div>

    <!-- SLIDE 2: THÔNG TIN HAI HỌ -->
    <div class="slide-item">
        <div class="side-left">
            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=800" class="img-full">
            <div class="img-overlay-light"></div>
            <div class="content-box">
                <span class="badge-tag fw-bold" style="font-size: 0.85rem;">Nhà Trai</span>
                <h3 class="font-serif fw-bold mb-3 text-dark fs-2">Gia Đình Chú Rể</h3>
                <p class="mb-2 fs-5 text-dark fw-bold" style="text-shadow: 0 1px 2px rgba(255,255,255,0.8);">
                    Bố: <strong data-field="groom_father" class="text-danger fw-bolder">{{ $card->groom_father ?? 'Đinh Văn A' }}</strong>
                </p>
                <p class="fs-5 text-dark fw-bold" style="text-shadow: 0 1px 2px rgba(255,255,255,0.8);">
                    Mẹ: <strong data-field="groom_mother" class="text-danger fw-bolder">{{ $card->groom_mother ?? 'Nguyễn Thị B' }}</strong>
                </p>
            </div>
        </div>
        <div class="side-right">
            <img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=800" class="img-full">
            <div class="img-overlay-light"></div>
            <div class="content-box">
                <span class="badge-tag fw-bold" style="font-size: 0.85rem;">Nhà Gái</span>
                <h3 class="font-serif fw-bold mb-3 text-dark fs-2">Gia Đình Cô Dâu</h3>
                <p class="mb-2 fs-5 text-dark fw-bold" style="text-shadow: 0 1px 2px rgba(255,255,255,0.8);">
                    Bố: <strong data-field="bride_father" class="text-danger fw-bolder">{{ $card->bride_father ?? 'Trần Văn C' }}</strong>
                </p>
                <p class="fs-5 text-dark fw-bold" style="text-shadow: 0 1px 2px rgba(255,255,255,0.8);">
                    Mẹ: <strong data-field="bride_mother" class="text-danger fw-bolder">{{ $card->bride_mother ?? 'Lê Thị D' }}</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- SLIDE 3: CHÚ RỂ -->
    <div class="slide-item">
        <div class="side-left">
            <img id="preview_groom_avatar" src="{{ !empty($card->groom_avatar) ? asset($card->groom_avatar) : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800' }}" class="img-full">
        </div>
        <div class="side-right">
            <div class="content-box">
                <span class="badge-tag">The Groom</span>
                <h2 class="font-serif fw-bold text-dark mb-2" data-field="groom_name">{{ $card->groom_name ?? 'Đinh Hà' }}</h2>
                <p class="text-muted mb-4" data-field="groom_bio">{{ $card->groom_bio ?? 'Chàng trai kiên định, kỷ luật & ấm áp.' }}</p>
                @if(!empty($card->groom_phone))
                    <a href="tel:{{ $card->groom_phone }}" class="btn btn-outline-danger rounded-pill px-4 py-2"><i class="bi bi-telephone me-2"></i>Liên hệ Chú Rể</a>
                @endif
            </div>
        </div>
    </div>

    <!-- SLIDE 4: CÔ DÂU -->
    <div class="slide-item">
        <div class="side-left">
            <div class="content-box">
                <span class="badge-tag">The Bride</span>
                <h2 class="font-serif fw-bold text-dark mb-2" data-field="bride_name">{{ $card->bride_name ?? 'Ngọc Bích' }}</h2>
                <p class="text-muted mb-4" data-field="bride_bio">{{ $card->bride_bio ?? 'Cô gái tinh tế, tràn đầy năng lượng.' }}</p>
                @if(!empty($card->bride_phone))
                    <a href="tel:{{ $card->bride_phone }}" class="btn btn-outline-danger rounded-pill px-4 py-2"><i class="bi bi-telephone me-2"></i>Liên hệ Cô Dâu</a>
                @endif
            </div>
        </div>
        <div class="side-right">
            <img id="preview_bride_avatar" src="{{ !empty($card->bride_avatar) ? asset($card->bride_avatar) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=800' }}" class="img-full">
        </div>
    </div>

    <!-- SLIDE 5: THỜI GIAN & ĐỊA ĐIỂM -->
    <div class="slide-item">
        <div class="side-left">
            <div class="content-box">
                <span class="badge-tag">Thời Gian</span>
                <h2 class="font-serif fw-bold text-danger display-6 mb-2" data-field="wedding_date">{{ $card->wedding_date ?? '12 Tháng 12, 2026' }}</h2>
                <div class="text-muted mb-3" data-field="lunar_date">{{ $card->lunar_date ?? 'Tức Ngày 04/11 Bính Ngọ' }}</div>
                <p class="fw-bold fs-5">Vào lúc <span data-field="wedding_time" class="text-danger">{{ $card->wedding_time ?? '08:00 Sáng' }}</span></p>
            </div>
        </div>
        <div class="side-right">
            <div class="content-box">
                <span class="badge-tag">Địa Điểm</span>
                <h3 class="font-serif fw-bold mb-3" data-field="wedding_location">{{ $card->wedding_location ?? 'Sảnh Diamond, Grand Palace, Hà Nội' }}</h3>
                @php
                    $mapUrl = !empty($card->map_link) 
                        ? $card->map_link 
                        : 'https://www.google.com/maps/search/?api=1&query=' . urlencode($card->wedding_location ?? 'Địa điểm tổ chức');
                @endphp
                <a href="javascript:void(0);" id="btn_map_link" data-map-url="{{ $mapUrl }}" onclick="openGoogleMapDirect()" class="btn btn-sm rounded-pill px-4 py-2 text-white fw-semibold shadow-sm" style="background: var(--accent-rose, #e11d48); font-size: 0.85rem; position: relative; z-index: 9999; pointer-events: auto !important; display: inline-block;">
                    <i class="bi bi-map-fill me-1"></i> Xem Chỉ Đường Maps
                </a>
            </div>
        </div>
    </div>

    <!-- SLIDE 6: TIMELINE & TRA CỨU BÀN TIỆC -->
    <div class="slide-item">
        <div class="side-left">
            <div class="content-box">
                <span class="badge-tag">Timeline</span>
                <h2 class="font-serif fw-bold text-dark mb-4">Lịch Trình Hôn Lễ</h2>
                <div class="text-start d-inline-block w-100 px-3">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                        <span class="fw-bold text-danger" data-field="time_welcome">{{ $card->time_welcome ?? '17:30' }}</span>
                        <span>Đón Khách & Chụp Ảnh</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                        <span class="fw-bold text-danger" data-field="time_ceremony">{{ $card->time_ceremony ?? '18:30' }}</span>
                        <span>Hành Lễ Thành Hôn</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2">
                        <span class="fw-bold text-danger" data-field="time_party">{{ $card->time_party ?? '19:00' }}</span>
                        <span>Khai Tiệc Mừng</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="side-right">
            <div class="content-box">
                @if($isVipCard || $isEditor)
                    <span class="badge-tag">Seating Chart</span>
                    <h3 class="font-serif fw-bold text-dark mb-3">Tra Cứu Bàn Tiệc</h3>
                    <div class="input-group mb-2">
                        <input id="guestNameInput" type="text" class="form-control rounded-pill px-3" placeholder="Nhập tên của bạn...">
                    </div>
                    <button type="button" id="btnSearchSeat" onclick="findSeat(event)" class="btn btn-outline-danger btn-sm rounded-pill w-100">Tra Cứu</button>
                    <div id="seatResultArea" class="mt-2 fw-bold text-danger"></div>
                @else
                    <span class="badge-tag">Seating</span>
                    <h3 class="font-serif fw-bold text-dark">Hân Hạnh Đón Tiếp</h3>
                @endif
            </div>
        </div>
    </div>

    <!-- SLIDE 7: ALBUM KỶ NIỆM -->
    <div class="slide-item">
        <div class="side-left">
            <div class="content-box">
                <span class="badge-tag">Gallery</span>
                <h3 class="font-serif fw-bold mb-3">Album Kỷ Niệm</h3>
                @php
                    $album = is_string($card->album_imgs ?? null) ? json_decode($card->album_imgs, true) : ($card->album_imgs ?? []);
                @endphp
                <div class="row g-2">
                    @if(!empty($album) && count($album) > 0)
                        @foreach(array_slice($album, 0, 4) as $img)
                            <div class="col-6"><img src="{{ asset($img) }}" class="img-fluid rounded" style="height:100px; object-fit:cover; width:100%;"></div>
                        @endforeach
                    @else
                        <div class="col-6"><img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?w=300" class="img-fluid rounded" style="height:100px; object-fit:cover; width:100%;"></div>
                        <div class="col-6"><img src="https://images.unsplash.com/photo-1522673607200-164d1b6ce486?w=300" class="img-fluid rounded" style="height:100px; object-fit:cover; width:100%;"></div>
                        <div class="col-6"><img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?w=300" class="img-fluid rounded" style="height:100px; object-fit:cover; width:100%;"></div>
                        <div class="col-6"><img src="https://images.unsplash.com/photo-1583939003579-730e3918a45a?w=300" class="img-fluid rounded" style="height:100px; object-fit:cover; width:100%;"></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="side-right">
            <div class="content-box">
                @if(!empty($card->wedding_video))
                    <span class="badge-tag">Video</span>
                    <h3 class="font-serif fw-bold mb-3">Cinematic</h3>
                    <video controls class="w-100 rounded mb-3">
                        <source src="{{ asset($card->wedding_video) }}" type="video/mp4">
                    </video>
                @endif
                <span class="badge-tag">Moments</span>
                <p class="small text-muted mb-2">Chia sẻ khoảnh khắc đẹp cùng dâu rể</p>

                <form action="{{ route('guest.upload_photo', $card->id ?? 4) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="photos[]" class="form-control form-control-sm rounded-pill mb-2" accept="image/*" multiple required>
                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Tải Ảnh Lên</button>
                </form>
            </div>
        </div>
    </div>

    <!-- SLIDE 8: MỪNG CƯỚI & NÚT BẤM FORM -->
    <div class="slide-item">
        <div class="side-left">
            <div class="content-box">
                <span class="badge-tag">Mừng Cưới</span>
                <div class="mb-3">
                    <small class="text-muted d-block text-uppercase">Chú rể - <span data-field="groom_bank_name">{{ $card->groom_bank_name ?? 'MBBank' }}</span></small>
                    <strong class="fs-5 text-danger d-block" data-field="groom_bank_acc">
                        {{ (!empty($card->groom_bank_acc) && !str_contains($card->groom_bank_acc, 'xxx')) ? $card->groom_bank_acc : '0987654321' }}
                    </strong>
                    <small class="text-muted d-block" data-field="groom_bank_owner">{{ $card->groom_bank_owner ?? '' }}</small>
                    @if(!empty($card->groom_bank_qr))
                        <img src="{{ asset($card->groom_bank_qr) }}" class="img-fluid mt-1 rounded" style="max-width:90px;">
                    @endif
                </div>
                <hr class="my-2 opacity-25">
                <div>
                    <small class="text-muted d-block text-uppercase">Cô dâu - <span data-field="bride_bank_name">{{ $card->bride_bank_name ?? 'Vietcombank' }}</span></small>
                    <strong class="fs-5 text-danger d-block" data-field="bride_bank_acc">
                        {{ (!empty($card->bride_bank_acc) && !str_contains($card->bride_bank_acc, 'xxx')) ? $card->bride_bank_acc : '0123456789' }}
                    </strong>
                    <small class="text-muted d-block" data-field="bride_bank_owner">{{ $card->bride_bank_owner ?? '' }}</small>
                    @if(!empty($card->bride_bank_qr))
                        <img src="{{ asset($card->bride_bank_qr) }}" class="img-fluid mt-1 rounded" style="max-width:90px;">
                    @endif
                </div>
            </div>
        </div>
        <div class="side-right">
            <div class="content-box">
                <div class="font-script text-danger mb-1" style="font-size: 3.5rem;">Thank You</div>
                <p class="text-muted italic small mb-3" data-field="thank_msg">{{ $card->thank_msg ?? 'Sự hiện diện của bạn là món quà ý nghĩa nhất!' }}</p>
                
                @if(!empty($card->voice_thanks))
                    <button class="btn btn-outline-secondary btn-sm rounded-pill mb-3" onclick="playVoice('{{ asset($card->voice_thanks) }}')">
                        <i class="bi bi-volume-up me-1"></i> Lời Cảm Ơn
                    </button>
                @endif

                <div class="d-flex flex-column gap-2">
                    <button class="btn btn-danger rounded-pill px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#rsvpModal">XÁC NHẬN THAM DỰ</button>
                    <button class="btn btn-outline-danger btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#wishModal">GỬI LỜI CHÚC / GHI ÂM</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- MODAL RSVP -->
<div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 p-2">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-serif fw-bold text-danger"><i class="bi bi-envelope-heart me-2"></i>Xác Nhận Tham Dự</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-start">
                <form id="rsvpForm" action="{{ isset($card->slug) ? route('wedding.rsvp', $card->slug) : '#' }}" method="POST">
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
                    <button type="submit" class="btn btn-danger w-100 rounded-pill py-2.5 fw-bold shadow-sm" style="background: var(--accent-rose, #e11d48); border:none;">
                        Gửi Xác Nhận
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL GỬI LỜI CHÚC & GHI ÂM -->
<div class="modal fade" id="wishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 p-2">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-serif fw-bold text-danger"><i class="bi bi-chat-heart me-2"></i>Gửi Lời Chúc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-start">
<form id="wishForm" enctype="multipart/form-data">
                        @csrf
                    <div class="mb-2">
                        <input type="text" name="name" class="form-control rounded-pill mb-2" placeholder="Tên của bạn..." required>
                        <textarea name="content" class="form-control rounded-3 mb-2" rows="3" placeholder="Viết lời chúc ý nghĩa..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Tải file ghi âm sẵn (nếu có):</label>
                        <input type="file" name="audio_file" accept="audio/*" class="form-control form-control-sm rounded-pill">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" id="btnRecord" class="btn btn-outline-danger rounded-pill w-50" onclick="toggleRecord()">🎤 Ghi Âm</button>
                        <button type="submit" class="btn btn-danger rounded-pill w-50">Gửi Chúc</button>
                    </div>
                    <input type="file" name="voice_recorded" id="recordedFileInput" hidden>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="controls">
    <button class="btn-move" id="prevBtn" type="button"><i class="bi bi-chevron-up"></i></button>
    <button class="btn-move" id="nextBtn" type="button"><i class="bi bi-chevron-down"></i></button>
</div>
<div class="dots-nav" id="dotsContainer"></div>
@endsection

@push('scripts')
<script>
// --- QUẢN LÝ PHÁT ÂM THANH (LỜI MỜI & LỜI CẢM ƠN) ---
let currentVoiceAudio = null;

function playVoice(audioUrl) {
    if (currentVoiceAudio) {
        if (!currentVoiceAudio.paused) {
            currentVoiceAudio.pause();
            if (currentVoiceAudio.src.includes(audioUrl)) {
                return; // Nếu bấm lại đúng bài đang phát thì dừng luôn
            }
        }
    }
    
    currentVoiceAudio = new Audio(audioUrl);
    currentVoiceAudio.play().catch(error => {
        console.error("Lỗi phát âm thanh:", error);
        alert("Trình duyệt ngăn tự động phát hoặc file không tồn tại!");
    });
}

// --- TỰ ĐỘNG PHÁT NHẠC NỀN (NẾU CÓ) ---
document.addEventListener('DOMContentLoaded', function() {
    @if(!empty($card->bg_music))
        const bgMusic = new Audio('{{ asset(str_starts_with($card->bg_music, "storage/") ? $card->bg_music : "storage/" . $card->bg_music) }}');
        bgMusic.loop = true;
        
        // Thử tự động phát, nếu trình duyệt chặn sẽ chờ người dùng tương tác
        const playBgMusic = () => {
            bgMusic.play().then(() => {
                document.removeEventListener('click', playBgMusic);
                document.removeEventListener('touchstart', playBgMusic);
            }).catch(() => {});
        };

        document.addEventListener('click', playBgMusic);
        document.addEventListener('touchstart', playBgMusic);
    @endif

    // --- XỬ LÝ SLIDER ---
    const slides = document.querySelectorAll('.slide-item');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('dotsContainer');
    
    if (!slides.length) return;
    
    let currentIndex = 0;
    dotsContainer.innerHTML = '';

    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dots-nav .dot');

    function updateSlider() {
        slides.forEach((slide, index) => {
            if (index === currentIndex) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    function goToSlide(index) {
        currentIndex = index;
        updateSlider();
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        updateSlider();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        updateSlider();
    }

    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowDown' || e.key === 'ArrowRight') nextSlide();
        if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') prevSlide();
    });
});

// --- XỬ LÝ GHI ÂM LỜI CHÚC ---
let mediaRecorder;
let audioChunks = [];

async function toggleRecord() {
    const btn = document.getElementById('btnRecord');

    if (!mediaRecorder || mediaRecorder.state === 'inactive') {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];

            mediaRecorder.ondataavailable = event => audioChunks.push(event.data);

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/mp3' });
                const file = new File([audioBlob], "voice_wish.mp3", { type: "audio/mp3" });
                const container = new DataTransfer();
                container.items.add(file);
                document.getElementById('recordedFileInput').files = container.files;
            };

            mediaRecorder.start();
            btn.innerHTML = '⏹ Dừng Ghi';
            btn.classList.replace('btn-outline-danger', 'btn-dark');
        } catch (err) {
            alert('Không thể truy cập Microphone!');
        }
    } else {
        mediaRecorder.stop();
        btn.innerHTML = '🎤 Ghi Âm Lại';
        btn.classList.replace('btn-dark', 'btn-outline-danger');
    }
}
</script>
@endpush