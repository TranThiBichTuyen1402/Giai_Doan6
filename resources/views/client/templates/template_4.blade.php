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

    /* KHUNG CHÍNH SLIDER */
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

    /* NỬA TRÁI & PHẢI TRÀN VIỀN */
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

    /* HÌNH ẢNH TRÀN NỀN */
    .img-full { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; }
    .img-overlay-light { position: absolute; inset: 0; background: rgba(255, 255, 255, 0.45); }
    .img-overlay-dark { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.25); }

    /* KHU VỰC CHỮ - BỎ SẠCH KHUNG */
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

    /* COUNTDOWN KHÔNG KHUNG */
    .cd-flex { display: flex; justify-content: center; gap: 20px; margin-top: 20px; }
    .cd-box span { font-size: 1.8rem; font-weight: 800; color: var(--accent-rose); display: block; line-height: 1; }
    .cd-box small { font-size: 0.65rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; }

    /* NÚT ĐIỀU HƯỚNG TỐI GIẢN */
    .controls { position: fixed; bottom: 30px; right: 30px; display: flex; gap: 12px; z-index: 100; }
    .btn-move {
        width: 46px; height: 46px;
        border: 1px solid rgba(225, 29, 72, 0.3);
        background: rgba(255, 255, 255, 0.8);
        color: var(--accent-rose); border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: 0.3s; cursor: pointer; backdrop-filter: blur(4px);
    }
    .btn-move:hover { background: var(--accent-rose); color: #fff; }

    .dots-nav {
        position: fixed; left: 20px; top: 50%; transform: translateY(-50%);
        display: flex; flex-direction: column; gap: 12px; z-index: 100;
    }
    .dot { width: 8px; height: 8px; background: #fca5a5; border-radius: 50%; cursor: pointer; transition: 0.3s; }
    .dot.active { background: var(--accent-rose); transform: scale(1.5); }

    /* MOBILE */
    @media (max-width: 768px) {
        .split-slider { flex-direction: column; }
        .side-left, .side-right { width: 100%; height: 50%; }
        .side-left { transform: translateX(-100%); }
        .side-right { transform: translateX(100%); }
        .slide-item.active .side-left, .slide-item.active .side-right { transform: translateX(0); }
        .font-script { font-size: 3.2rem; }
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
<div class="split-slider">
    
    <div class="slide-item active">
        <div class="side-left">
            <img id="preview_cover_img" src="{{ !empty($card->cover_img) ? asset($card->cover_img) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS_X_cOzEHda1g27y29Gm9JzlzkkOgHJWNkxe_2V3ChWQ&s=10' }}" class="img-full">
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

                @if(!empty($card->voice_invite))
                    <div class="mt-4">
                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="playVoice('{{ asset($card->voice_invite) }}')">
                            <i class="bi bi-volume-up me-1"></i> Nghe Lời Mời
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

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
                @if(!empty($card->map_link))
                    <a href="{{ $card->map_link }}" target="_blank" class="btn btn-danger rounded-pill px-4 py-2 shadow-sm">XEM BẢN ĐỒ</a>
                @endif
            </div>
        </div>
    </div>

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
                <span class="badge-tag">Seating</span>
                <h3 class="font-serif fw-bold mb-3">Tra Cứu Bàn Tiệc</h3>
                <input type="text" id="seatName" class="form-control rounded-pill text-center mb-3" placeholder="Nhập tên của bạn...">
                <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="findSeat()">Tra Cứu</button>
                <div id="seatResult" class="mt-3 fw-bold text-danger"></div>
            </div>
        </div>
    </div>

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
                <input type="file" id="momentImage" class="form-control form-control-sm rounded-pill mb-2" accept="image/*">
                <button class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="uploadMoment()">Tải Ảnh Lên</button>
            </div>
        </div>
    </div>

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

<div class="modal fade" id="rsvpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 p-2">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-serif fw-bold text-danger"><i class="bi bi-envelope-heart me-2"></i>Xác Nhận Tham Dự</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-start">
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
        <div class="modal-content rounded-4 p-2">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title font-serif fw-bold text-danger"><i class="bi bi-chat-heart me-2"></i>Gửi Lời Chúc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-start">
                <div class="mb-2">
                    <input type="text" class="form-control rounded-pill mb-2" placeholder="Tên của bạn...">
                    <textarea class="form-control rounded-3" rows="3" placeholder="Viết lời chúc ý nghĩa..."></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-danger rounded-pill w-50" onclick="recordVoice()">🎤 Ghi Âm</button>
                    <button type="button" class="btn btn-danger rounded-pill w-50" onclick="sendWish()">Gửi Chúc</button>
                </div>
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
