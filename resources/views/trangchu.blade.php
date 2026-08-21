@extends('layouts.app')
@section('title', 'Biihappy Premium Wedding - Nền Tảng Tạo Website Đám Cưới 3D')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
    <section class="position-relative w-100 vh-100 overflow-hidden view-3d-space d-flex align-items-center justify-content-center gradient-bg-hero">
        <div id="card-wrapper" class="position-relative w-100 h-100 d-flex align-items-center justify-content-center">
            <div id="bg-photo" class="layer-bg-photo position-absolute top-0 start-0 end-0 bottom-0 transition-all"></div>

            <div class="position-absolute top-0 start-0 end-0 bottom-0" style="background:linear-gradient(135deg, rgba(249,168,212,.1), transparent);"></div>
            <div class="position-absolute top-0 start-0 end-0 bottom-0" style="background:linear-gradient(0deg, rgba(255,240,242,.05), transparent);"></div>

            <button onclick="nextWeddingImage(event)" class="position-absolute top-50 end-0 translate-middle-y me-4 d-flex align-items-center justify-content-center bg-white bg-opacity-75 text-wed-pink rounded-circle shadow hover-scale-sm active-scale transition-all border-0" style="width:48px; height:48px; z-index:1000;" aria-label="Hình tiếp theo">
                <i class="fa-solid fa-chevron-right fs-5"></i>
            </button>

            <div id="particle-container" class="position-absolute top-0 start-0 end-0 bottom-0" style="z-index:10;"></div>

            <div class="position-relative text-center px-3" style="z-index:20; max-width:900px; margin-top:3rem;">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-white border border-wed-pink mb-4 shadow-sm">
                    <span class="rounded-circle badge-pulse" style="width:8px; height:8px; background:var(--wed-pink-500); display:inline-block;"></span>
                    <span class="text-wed-pink fw-bold text-uppercase" style="font-size:.7rem; letter-spacing:.15em;">Xu Hướng Thiệp Cưới Công Nghệ 2026</span>
                </div>

                <h1 class="font-cursive gradient-hero-text fw-bold py-2" style="font-size: clamp(2.8rem, 8vw, 6rem);">
                    Gia Huy &amp; Minh Anh
                </h1>

                <p class="text-white fw-bold mt-3" style="font-size: clamp(1rem, 2vw, 1.25rem); letter-spacing:.2em;">
                    SAVE THE DATE — 25 . 12 . 2026
                </p>

                <div class="mx-auto my-4" style="width:6rem; height:2px; background:linear-gradient(90deg, transparent, var(--wed-pink-400), transparent);"></div>

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="#templates" class="btn gradient-btn rounded-pill px-4 py-3 fw-bold shadow hover-scale active-scale transition-all text-decoration-none">
                        <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Bắt đầu thiết kế ngay
                    </a>
                    <a href="#features" class="btn btn-pink-outline rounded-pill px-4 py-3 fw-bold shadow-sm hover-scale active-scale transition-all text-decoration-none">
                        Xem các tính năng thông minh <i class="fa-solid fa-arrow-down ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="gradient-bg-section py-5 px-3 position-relative" style="z-index:30; padding-top:6rem !important; padding-bottom:6rem !important;">
        <div class="container text-center">
            <span class="badge rounded-pill gradient-btn-simple text-uppercase fw-bold px-3 py-2" style="letter-spacing:.15em;">
                Hệ sinh thái thông minh
            </span>

            <h2 class="fw-bold mt-4 mb-5" style="font-size:2.2rem;">
                Website Đám Cưới Của Bạn Có Gì?
            </h2>

            <div class="row g-4 text-start">

                <div class="col-12 col-md-4">
                    <div class="card-feature bg-white border border-2 border-wed-pink rounded-4xl shadow p-4 h-100">
                        <div class="icon-box d-flex align-items-center justify-content-center rounded-4 text-wed-pink bg-wed-pink-100 shadow-sm mb-4" style="width:64px; height:64px; font-size:1.6rem;">
                            <i class="fa-solid fa-microphone-lines"></i>
                        </div>
                        <h3 class="fw-bold mb-3 fs-4 transition-all">Lời mời &amp; Lưu bút bằng Voice</h3>
                        <p class="text-wed-stone small mb-0">
                            Tích hợp AI cá nhân hóa gọi tên khách mời, cho phép ghi âm lời chúc trực tiếp gửi tới cặp đôi.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card-feature bg-white border border-2 border-wed-pink rounded-4xl shadow p-4 h-100">
                        <div class="icon-box d-flex align-items-center justify-content-center rounded-4 text-wed-pink bg-wed-pink-100 shadow-sm mb-4" style="width:64px; height:64px; font-size:1.6rem;">
                            <i class="fa-solid fa-chair"></i>
                        </div>
                        <h3 class="fw-bold mb-3 fs-4 transition-all">Sơ đồ vị trí ngồi thông minh</h3>
                        <p class="text-wed-stone small mb-0">
                            Khách mời chỉ cần nhập tên để biết chính xác số bàn, vị trí khu vực sảnh tiệc mà không cần hỏi lễ tân.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card-feature bg-white border border-2 border-wed-pink rounded-4xl shadow p-4 h-100">
                        <div class="icon-box d-flex align-items-center justify-content-center rounded-4 text-wed-pink bg-wed-pink-100 shadow-sm mb-4" style="width:64px; height:64px; font-size:1.6rem;">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <h3 class="fw-bold mb-3 fs-4 transition-all">Hệ thống quản trị RSVP</h3>
                        <p class="text-wed-stone small mb-0">
                            Theo dõi thời gian thực ai tham gia, ai vắng mặt, số lượng người đi kèm để quản lý cỗ cưới chính xác.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="templates" class="bg-wed-pink-50 py-5 px-3 border-top" style="border-color: rgba(255,209,215,.5) !important;">
        <div class="container text-center">

            <span class="badge rounded-pill bg-wed-pink-100 text-wed-pink text-uppercase fw-bold px-3 py-2" style="letter-spacing:.15em;">Bộ sưu tập 2026</span>
            <h2 class="fw-bold mt-3 mb-5" style="font-size:2.2rem;">Mẫu Thiệp Nổi Bật</h2>

            <div class="row g-4 text-start mb-4">

                <div class="col-12 col-md-4">
                    <div class="card-template bg-white rounded-4xl border shadow-sm h-100 d-flex flex-column overflow-hidden">
                        <div class="position-relative overflow-hidden bg-light" style="aspect-ratio:4/3;">
                            <img src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1200" alt="Mẫu thiệp Pure Luxury Gold" class="w-100 h-100 object-fit-cover">
                            <span class="position-absolute top-0 start-0 mt-3 ms-3 badge rounded-pill text-uppercase fw-bold badge-pulse" style="background:#f43f5e; color:#fff; font-size:10px;">Hot nhất</span>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold fs-6 mb-1">Pure Luxury Gold</h3>
                            <p class="text-secondary small mb-4">Phong cách hoàng gia, hiệu ứng nhũ vàng 3D sang trọng.</p>
                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ route('card.demo', 1) }}" target="_blank" class="btn btn-sm w-100 bg-light fw-bold text-dark rounded-4 py-2 text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('card.builder', 1) }}" class="btn btn-sm w-100 gradient-btn-simple fw-bold rounded-4 py-2 shadow-sm text-white text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Dùng thiệp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card-template bg-white rounded-4xl border shadow-sm h-100 d-flex flex-column overflow-hidden">
                        <div class="position-relative overflow-hidden bg-light" style="aspect-ratio:4/3;">
                            <img src="https://soheewedding.com/wp-content/uploads/2024/12/463455446_122166676946254080_5205101096808860370_n.jpg" alt="Mẫu thiệp Modern Minimalist" class="w-100 h-100 object-fit-cover">
                            <span class="position-absolute top-0 start-0 mt-3 ms-3 badge rounded-pill text-uppercase fw-bold" style="background:var(--wed-amber-500); color:#fff; font-size:10px;">Mới tinh</span>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold fs-6 mb-1">Modern Minimalist</h3>
                            <p class="text-secondary small mb-4">Tối giản hiện đại, tập trung vào font chữ và không gian ảnh nghệ thuật.</p>
                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ route('card.demo', 2) }}" target="_blank" class="btn btn-sm w-100 bg-light fw-bold text-dark rounded-4 py-2 text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('card.builder', 2) }}" class="btn btn-sm w-100 gradient-btn-simple fw-bold rounded-4 py-2 shadow-sm text-white text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Dùng thiệp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card-template bg-white rounded-4xl border shadow-sm h-100 d-flex flex-column overflow-hidden">
                        <div class="position-relative overflow-hidden bg-light" style="aspect-ratio:4/3;">
                            <img src="https://soheewedding.com/wp-content/uploads/2024/12/459827011_122160725804254080_5217683565945391522_n.jpg" alt="Mẫu thiệp Rustic Garden" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold fs-6 mb-1">Rustic Garden</h3>
                            <p class="text-secondary small mb-4">Mộc mạc, gần gũi thiên nhiên với họa tiết lá cây tươi mát.</p>
                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ route('card.demo', 3) }}" target="_blank" class="btn btn-sm w-100 bg-light fw-bold text-dark rounded-4 py-2 text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('card.builder', 3) }}" class="btn btn-sm w-100 gradient-btn-simple fw-bold rounded-4 py-2 shadow-sm text-white text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Dùng thiệp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card-template bg-white rounded-4xl border shadow-sm h-100 d-flex flex-column overflow-hidden">
                        <div class="position-relative overflow-hidden bg-light" style="aspect-ratio:4/3;">
                            <img src="https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=1200" alt="Mẫu thiệp Pure Minimal" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold fs-6 mb-1">Pure Minimal</h3>
                            <p class="text-secondary small mb-4">Tối giản và tinh tế, phù hợp cho những đám cưới phong cách Châu Âu.</p>
                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ route('card.demo', 4) }}" target="_blank" class="btn btn-sm w-100 bg-light fw-bold text-dark rounded-4 py-2 text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('card.builder', 4) }}" class="btn btn-sm w-100 gradient-btn-simple fw-bold rounded-4 py-2 shadow-sm text-white text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Dùng thiệp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card-template bg-white rounded-4xl border shadow-sm h-100 d-flex flex-column overflow-hidden">
                        <div class="position-relative overflow-hidden bg-light" style="aspect-ratio:4/3;">
                            <img src="https://soheewedding.com/wp-content/uploads/2026/02/617079680_122263702874254080_8199095612543446340_n.jpg" alt="Mẫu thiệp Sweet Pink Pastel" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold fs-6 mb-1">Sweet Pink Pastel</h3>
                            <p class="text-secondary small mb-4">Tone hồng phấn mộng mơ ngọt ngào dành cho các cặp đôi kẹo ngọt.</p>
                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ route('card.demo', 5) }}" target="_blank" class="btn btn-sm w-100 bg-light fw-bold text-dark rounded-4 py-2 text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('card.builder', 5) }}" class="btn btn-sm w-100 gradient-btn-simple fw-bold rounded-4 py-2 shadow-sm text-white text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Dùng thiệp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card-template bg-white rounded-4xl border shadow-sm h-100 d-flex flex-column overflow-hidden">
                        <div class="position-relative overflow-hidden bg-light" style="aspect-ratio:4/3;">
                            <img src="https://soheewedding.com/wp-content/uploads/2026/02/621235377_122263703114254080_5645807030548148954_n-1800x1195.jpg" alt="Mẫu thiệp Modern Chic" class="w-100 h-100 object-fit-cover">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <h3 class="fw-bold fs-6 mb-1">Modern Chic</h3>
                            <p class="text-secondary small mb-4">Sang trọng, thời thượng với điểm nhấn không gian 3D chuyển cảnh ấn tượng.</p>
                            <div class="row g-2 mt-auto">
                                <div class="col-6">
                                    <a href="{{ route('card.demo', 6) }}" target="_blank" class="btn btn-sm w-100 bg-light fw-bold text-dark rounded-4 py-2 text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-eye me-1"></i> Xem chi tiết
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('card.builder', 6) }}" class="btn btn-sm w-100 gradient-btn-simple fw-bold rounded-4 py-2 shadow-sm text-white text-decoration-none d-inline-block text-center" style="font-size:.7rem;">
                                        <i class="fa-solid fa-wand-magic-sparkles me-1"></i> Dùng thiệp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="d-flex justify-content-center mt-4">
    <a href="{{ route('card.choose') }}" class="btn btn-pink-outline rounded-pill px-4 py-3 fw-bold shadow-sm hover-scale active-scale transition-all text-decoration-none" style="border-width:2px;">
        Xem tất cả mẫu thiệp <i class="fa-solid fa-arrow-right ms-2"></i>
    </a>
</div>

        </div>
    </section>
<!-- Quy trình tạo và quản lý thiệp -->
   <section class="wedding-process-section py-5">
    <div class="container px-3" style="max-width:1200px;">

        {{-- HEADER --}}
        <div class="text-center process-heading mb-5">

            <span class="process-badge">
                Hành trình trải nghiệm
            </span>

            <h2 class="fw-bold mt-3 mb-3">
                Tạo Thiệp Cưới Thật Dễ Dàng
            </h2>

            <p>
                Từ lúc chọn mẫu đến khi gửi thiệp đến những người thân yêu,
                mọi thứ đều được thực hiện thật đơn giản.
            </p>

        </div>


        {{-- TIMELINE --}}
        <div class="process-timeline">

            {{-- BƯỚC 1 --}}
            <div class="process-item">
                <div class="process-line"></div>

                <div class="process-number">
                    1
                </div>

                <div class="process-card">

                    <div class="process-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                    <div class="process-step">
                        BƯỚC 01
                    </div>

                    <h4>
                        Chọn Mẫu Thiệp
                    </h4>

                    <p>
                        Khám phá những mẫu thiệp đẹp và chọn phong cách
                        phù hợp với câu chuyện tình yêu của bạn.
                    </p>

                </div>
            </div>


            {{-- BƯỚC 2 --}}
            <div class="process-item">
                <div class="process-line"></div>

                <div class="process-number">
                    2
                </div>

                <div class="process-card">

                    <div class="process-icon">
                        <i class="bi bi-person-heart"></i>
                    </div>

                    <div class="process-step">
                        BƯỚC 02
                    </div>

                    <h4>
                        Đăng Nhập / Tạo Tài Khoản
                    </h4>

                    <p>
                        Đăng nhập hoặc tạo tài khoản để lưu lại
                        tấm thiệp và tiếp tục chỉnh sửa bất cứ lúc nào.
                    </p>

                </div>
            </div>


            {{-- BƯỚC 3 --}}
            <div class="process-item">
                <div class="process-line"></div>

                <div class="process-number">
                    3
                </div>

                <div class="process-card">

                    <div class="process-icon">
                        <i class="bi bi-magic"></i>
                    </div>

                    <div class="process-step">
                        BƯỚC 03
                    </div>

                    <h4>
                        Thiết Kế Thiệp
                    </h4>

                    <p>
                        Thêm thông tin cô dâu, chú rể, hình ảnh,
                        ngày cưới, địa điểm, âm nhạc và những khoảnh khắc đáng nhớ.
                    </p>

                </div>
            </div>


            {{-- BƯỚC 4 --}}
            <div class="process-item">
                <div class="process-line"></div>

                <div class="process-number">
                    4
                </div>

                <div class="process-card">

                    <div class="process-icon">
                        <i class="bi bi-phone"></i>
                    </div>

                    <div class="process-step">
                        BƯỚC 04
                    </div>

                    <h4>
                        Xem Trước &amp; Lưu Thiệp
                    </h4>

                    <p>
                        Kiểm tra lại tấm thiệp trên giao diện thực tế,
                        chỉnh sửa nếu cần và lưu lại khi đã ưng ý.
                    </p>

                </div>
            </div>


            {{-- BƯỚC 5 --}}
            <div class="process-item process-final">

                <div class="process-number">
                    <i class="bi bi-check-lg"></i>
                </div>

                <div class="process-card">

                    <div class="process-icon">
                        <i class="bi bi-send-heart-fill"></i>
                    </div>

                    <div class="process-step">
                        HOÀN TẤT
                    </div>

                    <h4>
                        Quản Lý &amp; Chia Sẻ Thiệp
                    </h4>

                    <p>
                        Xem lại thiệp đã tạo, chỉnh sửa thông tin,
                        sao chép đường dẫn và gửi tấm thiệp đến những người thân yêu.
                    </p>

                </div>
            </div>

        </div>

    </div>
</section>


<style>

/* ==========================================
   WEDDING PROCESS
========================================== */

.wedding-process-section {
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(circle at 10% 20%,
            rgba(244, 114, 182, .10),
            transparent 30%),
        radial-gradient(circle at 90% 80%,
            rgba(244, 114, 182, .10),
            transparent 30%),
        #fff5f8;
}


/* HOA VĂN MỜ */

.wedding-process-section::before {
    content: "♡";
    position: absolute;
    left: 3%;
    top: 8%;
    font-size: 180px;
    color: rgba(236, 72, 153, .035);
    font-family: serif;
    transform: rotate(-15deg);
}

.wedding-process-section::after {
    content: "♡";
    position: absolute;
    right: 3%;
    bottom: 5%;
    font-size: 150px;
    color: rgba(236, 72, 153, .035);
    font-family: serif;
    transform: rotate(15deg);
}


/* HEADER */

.process-heading {
    position: relative;
    z-index: 2;
}

.process-badge {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 50px;
    background: rgba(244, 114, 182, .12);
    color: #be185d;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.process-heading h2 {
    color: #3f1728;
    font-size: 2rem;
}

.process-heading p {
    max-width: 650px;
    margin: 0 auto;
    color: #8b6f79;
    font-size: .95rem;
    line-height: 1.7;
}


/* ==========================================
   TIMELINE
========================================== */

.process-timeline {
    position: relative;
    z-index: 2;

    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;

    align-items: start;
}


/* CARD */

.process-item {
    position: relative;
    grid-column: span 2;
}


/* 4 + 5 nằm giữa */

.process-item:nth-child(4) {
    grid-column: 2 / span 2;
    margin-top: 20px;
}

.process-item:nth-child(5) {
    grid-column: 4 / span 2;
    margin-top: 20px;
}


/* CARD */

.process-card {
    position: relative;

    background: rgba(255,255,255,.88);

    border: 1px solid rgba(244,114,182,.18);

    border-radius: 28px;

    padding: 30px 24px 28px;

    min-height: 265px;

    text-align: center;

    box-shadow:
        0 12px 35px rgba(190,24,93,.07);

    transition:
        transform .35s ease,
        box-shadow .35s ease,
        border-color .35s ease;
}


/* HOVER */

.process-card:hover {
    transform: translateY(-9px);

    border-color: rgba(244,114,182,.40);

    box-shadow:
        0 20px 45px rgba(190,24,93,.14);
}


/* ICON */

.process-icon {
    width: 58px;
    height: 58px;

    margin: 0 auto 16px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background:
        linear-gradient(
            135deg,
            #fce7f3,
            #fdf2f8
        );

    color: #db2777;

    font-size: 22px;

    box-shadow:
        0 8px 20px rgba(236,72,153,.12);

    transition: transform .35s ease;
}

.process-card:hover .process-icon {
    transform: scale(1.1) rotate(-5deg);
}


/* STEP */

.process-step {
    color: #db2777;

    font-size: 10px;

    font-weight: 800;

    letter-spacing: 2px;

    margin-bottom: 7px;
}


/* TITLE */

.process-card h4 {
    color: #3f1728;

    font-size: 1.05rem;

    font-weight: 800;

    margin-bottom: 12px;
}


/* DESCRIPTION */

.process-card p {
    color: #8b6f79;

    font-size: .82rem;

    line-height: 1.65;

    margin: 0;
}


/* ==========================================
   NUMBER
========================================== */

.process-number {
    position: absolute;

    top: -15px;
    left: 50%;

    transform: translateX(-50%);

    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #fff;

    border: 2px solid #f9a8d4;

    color: #be185d;

    font-size: 12px;

    font-weight: 800;

    z-index: 5;

    box-shadow:
        0 5px 15px rgba(190,24,93,.12);
}


/* ==========================================
   ĐƯỜNG NỐI
========================================== */

.process-item:not(.process-final)::after {
    content: "";

    position: absolute;

    top: 125px;

    right: -30px;

    width: 40px;

    height: 1px;

    background:
        repeating-linear-gradient(
            to right,
            #f9a8d4 0,
            #f9a8d4 5px,
            transparent 5px,
            transparent 10px
        );

    z-index: 1;
}


/* MŨI TÊN NHỎ */

.process-item:not(.process-final)::before {
    content: "›";

    position: absolute;

    top: 113px;

    right: -34px;

    color: #f472b6;

    font-size: 18px;

    z-index: 3;
}


/* ==========================================
   BƯỚC CUỐI
========================================== */

.process-final .process-card {
    background:
        linear-gradient(
            145deg,
            #fff,
            #fff1f7
        );

    border-color: rgba(236,72,153,.30);
}

.process-final .process-number {
    background: #ec4899;
    color: white;
    border-color: #ec4899;
}


/* ==========================================
   RESPONSIVE TABLET
========================================== */

@media (max-width: 991px) {

    .process-timeline {
        grid-template-columns: repeat(2, 1fr);
    }

    .process-item,
    .process-item:nth-child(4),
    .process-item:nth-child(5) {
        grid-column: auto;
        margin-top: 0;
    }

    .process-item:not(.process-final)::after,
    .process-item:not(.process-final)::before {
        display: none;
    }

}


/* ==========================================
   MOBILE
========================================== */

@media (max-width: 575px) {

    .wedding-process-section {
        padding-top: 55px !important;
        padding-bottom: 55px !important;
    }

    .process-heading h2 {
        font-size: 1.65rem;
    }

    .process-heading p {
        font-size: .85rem;
    }

    .process-timeline {
        grid-template-columns: 1fr;
        gap: 18px;
        padding: 0 8px;
    }

    .process-card {
        min-height: auto;
        padding: 26px 22px;
    }

    .process-icon {
        width: 52px;
        height: 52px;
    }

}

</style>

    <section class="py-5 bg-wed-pink-100">
        <div class="container text-center px-3 p-4 p-md-5 rounded-4xl bg-white border border-wed-pink shadow-sm" style="max-width:900px;">
            <span class="badge rounded-pill bg-wed-pink-100 text-wed-pink text-uppercase fw-bold px-3 py-2 mb-2" style="letter-spacing:.15em;">Giá trị cốt lõi</span>
            <h2 class="fw-bold mb-4" style="font-size:2rem;">Vì Sao Chọn Biihappy Premium?</h2>
            
            <div class="row g-4 text-start mt-2">
                <div class="col-12 col-md-6 d-flex gap-3">
                    <div class="text-wed-pink fs-3"><i class="fa-solid fa-cubes"></i></div>
                    <div>
                        <h5 class="fw-bold fs-6 mb-1">Công Nghệ 3D Độc Quyền</h5>
                        <p class="text-wed-stone small mb-0">Tạo hiệu ứng chiều sâu và tương tác chân thực như thiệp cưới vật lý cao cấp.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex gap-3">
                    <div class="text-wed-pink fs-3"><i class="fa-solid fa-bolt"></i></div>
                    <div>
                        <h5 class="fw-bold fs-6 mb-1">Tốc Độ Tải Cực Nhanh</h5>
                        <p class="text-wed-stone small mb-0">Tối ưu hóa hình ảnh và mã nguồn giúp thiệp mở mượt mà trên mọi thiết bị di động.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex gap-3">
                    <div class="text-wed-pink fs-3"><i class="fa-solid fa-shield-halved"></i></div>
                    <div>
                        <h5 class="fw-bold fs-6 mb-1">Bảo Mật &amp; Riêng Tư</h5>
                        <p class="text-wed-stone small mb-0">Tùy chọn cài đặt mật khẩu cho thiệp cưới, đảm bảo thông tin chỉ chia sẻ đúng người.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex gap-3">
                    <div class="text-wed-pink fs-3"><i class="fa-solid fa-headset"></i></div>
                    <div>
                        <h5 class="fw-bold fs-6 mb-1">Hỗ Trợ 24/7</h5>
                        <p class="text-wed-stone small mb-0">Đội ngũ kỹ thuật đồng hành cùng bạn từ khâu lên ý tưởng tới khi sự kiện kết thúc.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="position-relative bg-wed-pink-100 py-5 px-3 border-top" style="z-index:30;">
        <div class="container" style="max-width:800px;">
            <div class="text-center mb-5">
                <h2 class="text-uppercase fw-bold text-wed-pink mb-2" style="font-size:.75rem; letter-spacing:.15em;">Giải đáp thắc mắc</h2>
                <p class="fw-bold" style="font-size:2rem;">Câu Hỏi Thường Gặp</p>
            </div>

            <div class="d-flex flex-column gap-3">
                <div class="faq-item bg-white border border-wed-pink rounded-4 shadow-sm overflow-hidden">
                    <button class="faq-toggle w-100 d-flex justify-content-between align-items-center p-4 text-start fw-semibold fs-5 border-0 bg-white">
                        <span>1. Website đám cưới 3D này có lưu giữ mãi mãi không?</span>
                        <i class="fa-solid fa-chevron-down text-wed-pink"></i>
                    </button>
                    <div class="faq-content">
                        <p class="p-4 text-wed-stone small mb-0 border-top">
                            Có, hệ thống của chúng tôi hỗ trợ lưu trữ website đám cưới của bạn hoạt động lâu dài để làm kỷ niệm, giúp bạn có thể mở ra xem lại bất cứ lúc nào vào các ngày kỷ niệm ngày cưới sau này.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white border border-wed-pink rounded-4 shadow-sm overflow-hidden">
                    <button class="faq-toggle w-100 d-flex justify-content-between align-items-center p-4 text-start fw-semibold fs-5 border-0 bg-white">
                        <span>2. Tôi có thể tự thay đổi hình ảnh và nhạc nền không?</span>
                        <i class="fa-solid fa-chevron-down text-wed-pink"></i>
                    </button>
                    <div class="faq-content">
                        <p class="p-4 text-wed-stone small mb-0 border-top">
                            Hoàn toàn được! Hệ thống cung cấp trang quản trị cực kỳ dễ dùng, bạn có thể tự up ảnh cưới của mình, đổi bài nhạc nền yêu thích và cập nhật thông tin tiệc cưới chỉ trong vài cú click chuột.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white border border-wed-pink rounded-4 shadow-sm overflow-hidden">
                    <button class="faq-toggle w-100 d-flex justify-content-between align-items-center p-4 text-start fw-semibold fs-5 border-0 bg-white">
                        <span>3. Khách mời xác nhận tham dự (RSVP) thì tôi xem ở đâu?</span>
                        <i class="fa-solid fa-chevron-down text-wed-pink"></i>
                    </button>
                    <div class="faq-content">
                        <p class="p-4 text-wed-stone small mb-0 border-top">
                            Mọi thông tin phản hồi RSVP (số người tham dự, chế độ ăn uống, lời chúc) sẽ được gửi trực tiếp về bảng quản trị cá nhân của bạn và thông báo qua Email/Zalo theo thời gian thực.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white border border-wed-pink rounded-4 shadow-sm overflow-hidden">
                    <button class="faq-toggle w-100 d-flex justify-content-between align-items-center p-4 text-start fw-semibold fs-5 border-0 bg-white">
                        <span>4. Chi phí tạo thiệp cưới online là bao nhiêu?</span>
                        <i class="fa-solid fa-chevron-down text-wed-pink"></i>
                    </button>
                    <div class="faq-content">
                        <p class="p-4 text-wed-stone small mb-0 border-top">
                            Chúng tôi cung cấp cả gói Miễn Phí với các tính năng cơ bản và gói Premium với đầy đủ tính năng 3D, Voice RSVP và sơ đồ chỗ ngồi thông minh với mức chi phí rất tiết kiệm.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   
@endsection