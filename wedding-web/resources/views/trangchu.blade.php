<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biihappy Premium Wedding - Nền Tảng Tạo Website Đám Cưới 3D</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
//đầu trang
     <nav class="fixed top-0 left-0 right-0 z-50 bg-black/30 backdrop-blur-xl border-b border-white/10 px-6 py-4 transition-all duration-300">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="flex flex-col items-start gap-1">
            <span class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-amber-400 bg-clip-text text-transparent font-luxury leading-none">Wedding web</span>
            <span class="bg-pink-500/20 text-pink-400 text-[10px] uppercase font-bold tracking-widest px-2 py-0.5 rounded-full border border-pink-500/30 block w-max">Tạo dấu ấn ngày vui</span>
            </a>

            <div class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-200">
                <a href="#features" class="hover:text-pink-400 transition">Tính năng</a>
                <a href="#templates" class="hover:text-pink-400 transition font-medium flex items-center gap-1">Mẫu nổi bật <span class="bg-amber-400 text-black text-[9px] px-1 rounded font-bold">HOT</span></a>
                <a href="#pricing" class="hover:text-pink-400 transition">Bảng giá</a>
                <a href="#instructions" class="hover:text-pink-400 transition">Hướng dẫn</a>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="openAuthModal('login')" class="text-sm font-bold text-white hover:text-pink-400 transition px-3 py-2">
                    Tạo thiệp ngay
                </button>
                <button onclick="openAuthModal('login')" class="text-sm font-bold text-white hover:text-pink-400 transition px-3 py-2">
                    Đăng nhập
                </button>
                <button onclick="openAuthModal('register')" class="text-sm font-bold bg-gradient-to-r from-pink-500 to-rose-500 text-white px-5 py-2.5 rounded-full shadow-lg shadow-pink-500/20 hover:scale-105 transition active:scale-95">
                    Tạo tài khoản miễn phí
                </button>
            </div>
        </div>
    </nav>
//phần chính
    <section class="relative w-full h-screen overflow-hidden view-3d-space flex items-center justify-center">
        <div id="card-wrapper" class="wrapper-3d relative w-full h-full flex items-center justify-center">
            <div class="layer-bg-photo absolute inset-0 bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-gradient-to-tr from-purple-950/90 via-transparent to-rose-950/50 mix-blend-color-burn"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0b020f] via-transparent to-transparent"></div>

            <div id="particle-container" class="absolute inset-0 z-10 pointer-events-none"></div>

            <div class="layer-foreground-text relative z-20 text-center px-4 max-w-4xl mt-12">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 mb-6 shadow-lg">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span class="text-white text-xs font-bold tracking-widest uppercase">Xu Hướng Thiệp Cưới Công Nghệ 2026</span>
                </div>

                <h1 class="text-6xl md:text-8xl font-luxury text-gold-gradient drop-shadow-[0_10px_15px_rgba(0,0,0,0.6)] py-2">
                    Gia Huy & Minh Anh
                </h1>

                <p class="text-white font-bold text-base md:text-xl mt-4 tracking-widest drop-shadow">
                    SAVE THE DATE — 25 . 12 . 2026
                </p>
                
                <div class="w-24 h-0.5 bg-gradient-to-r from-transparent via-pink-400 to-transparent mx-auto my-6"></div>

                <div class="flex flex-wrap justify-center gap-4">
                    <button class="px-8 py-4 bg-gradient-to-r from-pink-500 via-rose-500 to-amber-500 text-white font-bold rounded-full shadow-[0_4px_25px_rgba(244,63,94,0.5)] hover:scale-105 active:scale-95 transition-all duration-300">
                        <i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Bắt đầu thiết kế ngay
                    </button>
                    <a href="#features" class="px-8 py-4 bg-white/10 text-white font-bold rounded-full border border-white/20 backdrop-blur-md hover:bg-white/20 hover:scale-105 active:scale-95 transition-all duration-300">
                        Xem các tính năng thông minh <i class="fa-solid fa-arrow-down ml-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="features">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-xs uppercase font-bold tracking-widest text-pink-500 mb-2">Hệ sinh thái thông minh</h2>
            <p class="text-3xl md:text-4xl font-bold text-white mb-16">Website Đám Cưới Của Bạn Có Gì?</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa-solid fa-microphone-lines"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Lời mời & Lưu bút bằng Voice</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Tích hợp AI cá nhân hóa gọi tên khách mời, cho phép ghi âm lời chúc trực tiếp gửi tới cặp đôi.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="color: #a855f7; background-color: rgba(168, 85, 247, 0.2);">
                        <i class="fa-solid fa-chair"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Sơ đồ vị trí ngồi thông minh</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Khách mời chỉ cần nhập tên để biết chính xác số bàn, vị trí khu vực sảnh tiệc mà không cần hỏi lễ tân.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="color: #f59e0b; background-color: rgba(245, 158, 11, 0.2);">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Hệ thống quản trị RSVP</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Theo dõi thời gian thực ai tham gia, ai vắng mặt, số lượng người đi kèm để quản lý cỗ cưới chính xác.</p>
                </div>
            </div>
        </div>
    </section>
<!-- //các bước thực hiện và vì sao chọn wedding web -->
   <section class="section-block">
        <div class="custom-container">
            <span class="section-badge badge-amber">Các bước thực hiện</span>
            <h2>Quy trình tạo thiệp</h2>
            <p>✨ cập nhật sau.</p>
        </div>
    </section> 

    <section class="section-block">
        <div class="custom-container" style="background: linear-gradient(to bottom right, rgba(88, 28, 135, 0.2), rgba(136, 19, 55, 0.2));">
            <span class="section-badge badge-pink">Giá trị cốt lõi</span>
            <h2>Vì sao chọn Wedding Web?</h2>
            <p>✨ cập nhật sau.</p>
        </div>
    </section>
    <!-- câu hỏi thường gặp -->
     <section id="faq" class="relative z-30 bg-[#0b020f] py-24 px-6 border-t border-white/5">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-xs uppercase font-bold tracking-widest text-pink-500 mb-2">Giải đáp thắc mắc</h2>
                <p class="text-3xl md:text-4xl font-bold text-white">Câu Hỏi Thường Gặp</p>
            </div>

            <div class="space-y-4">
                <div class="faq-item bg-white/5 border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left text-white font-semibold text-lg hover:bg-white/5 transition-colors">
                        <span>1. Website đám cưới 3D này có lưu giữ mãi mãi không?</span>
                        <i class="fa-solid fa-chevron-down text-pink-400 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-white/[0.02]">
                        <p class="p-6 text-gray-400 leading-relaxed text-sm">
                            Có, hệ thống của chúng tôi hỗ trợ lưu trữ website đám cưới của bạn hoạt động lâu dài để làm kỷ niệm, giúp bạn có thể mở ra xem lại bất cứ lúc nào vào các ngày kỷ niệm ngày cưới sau này.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white/5 border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left text-white font-semibold text-lg hover:bg-white/5 transition-colors">
                        <span>2. Tôi có thể tự thay đổi hình ảnh và nhạc nền không?</span>
                        <i class="fa-solid fa-chevron-down text-pink-400 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-white/[0.02]">
                        <p class="p-6 text-gray-400 leading-relaxed text-sm">
                            Hoàn toàn được! Hệ thống cung cấp trang quản trị cực kỳ dễ dùng, bạn có thể tự up ảnh cưới của mình, đổi bài nhạc nền yêu thích và cập nhật thông tin tiệc cưới chỉ trong vài cú click chuột.
                        </p>
                    </div>
                </div>

                <div class="faq-item bg-white/5 border border-white/10 rounded-2xl overflow-hidden transition-all duration-300">
                    <button class="faq-toggle w-full flex justify-between items-center p-6 text-left text-white font-semibold text-lg hover:bg-white/5 transition-colors">
                        <span>3. Tính năng RSVP (Xác nhận tham dự) hoạt động thế nào?</span>
                        <i class="fa-solid fa-chevron-down text-pink-400 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-white/[0.02]">
                        <p class="p-6 text-gray-400 leading-relaxed text-sm">
                            Khi khách mời nhấn vào nút "Xác nhận tham dự" trên website, họ sẽ nhập tên và số người đi cùng. Toàn bộ dữ liệu này sẽ lập tức được gửi về trang quản lý của bạn theo thời gian thực để bạn nắm được số lượng cỗ cưới chính xác.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="auth-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-md hidden transition-opacity duration-300">
        <div class="bg-gray-900 border border-white/10 w-full max-w-md rounded-3xl p-8 relative shadow-2xl m-4 transform scale-95 transition-transform duration-300" id="modal-content">
            
            <button onclick="closeAuthModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="text-center mb-8">
                <h3 id="modal-title" class="text-2xl font-bold text-white mb-2">Đăng Nhập Tài Khoản</h3>
                <p id="modal-subtitle" class="text-xs text-gray-400">Chào mừng bạn trở lại với thiên đường cưới</p>
            </div>

            <form onsubmit="handleAuthSubmit(event)" class="space-y-4">
                <div id="field-fullname" class="hidden">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Họ và Tên</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-3 top-3.5 text-gray-500 text-sm"></i>
                        <input type="text" id="auth-name" placeholder="Nguyễn Văn A" class="w-full bg-black/40 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-white text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Địa chỉ Email</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-3 top-3.5 text-gray-500 text-sm"></i>
                        <input type="email" id="auth-email" required placeholder="name@example.com" class="w-full bg-black/40 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-white text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Mật khẩu</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3.5 text-gray-500 text-sm"></i>
                        <input type="password" id="auth-pass" required placeholder="••••••••" class="w-full bg-black/40 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-white text-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                    </div>
                </div>

                <div id="field-terms" class="hidden flex items-start gap-2 pt-1">
                    <input type="checkbox" id="auth-check" class="mt-0.5 rounded border-white/10 bg-black text-pink-500">
                    <label class="text-xs text-gray-400">Tôi đồng ý với các điều khoản bảo mật dịch vụ cưới.</label>
                </div>

                <button type="submit" id="btn-auth-submit" class="w-full py-3 mt-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold rounded-xl shadow-lg shadow-pink-500/20 hover:opacity-90 transition">
                    Đăng Nhập
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-white/5 text-center text-sm text-gray-400">
                <span id="switch-text">Chưa có tài khoản đám cưới?</span>
                <button onclick="toggleAuthMode()" id="btn-switch-mode" class="text-pink-400 font-bold ml-1 hover:underline">Đăng ký ngay</button>
            </div>
        </div>
    </div>


    <footer class="bg-[#05010a] text-gray-300 py-16 px-6 border-t border-white/10 relative z-30">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-6">
            
            <div class="space-y-4">
                <h3 class="text-xl font-bold bg-gradient-to-r from-pink-400 to-amber-400 bg-clip-text text-transparent font-luxury">
                    Wedding Web
                </h3>
                <p class="text-gray-200 text-sm leading-relaxed max-w-sm font-medium">
                    Nền tảng tạo thiệp cưới điện tử hiện đại, giúp bạn chia sẻ lời mời đẹp mắt và quản lý khách mời thuận tiện hơn.
                </p>
            </div>

            <div class="space-y-4">
                <h4 class="text-white font-bold text-sm uppercase tracking-wider border-b border-white/10 pb-2 max-w-[150px]">
                    Liên kết
                </h4>
                <ul class="space-y-2.5 text-sm font-semibold">
                    <li>
                        <a href="#" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-chevron-right text-[10px] text-pink-500"></i> Trang chủ
                        </a>
                    </td>
                    <li>
                        <a href="#features" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-chevron-right text-[10px] text-pink-500"></i> Tính năng
                        </a>
                    </td>
                    <li>
                        <a href="#templates" class="text-gray-400 hover:text-pink-400 transition-colors duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-chevron-right text-[10px] text-pink-500"></i> Mẫu thiệp nổi bật
                        </a>
                    </td>
                </ul>
            </div>

            <div class="space-y-4">
                <h4 class="text-white font-bold text-sm uppercase tracking-wider border-b border-white/10 pb-2 max-w-[150px]">
                    Liên hệ
                </h4>
                <ul class="space-y-3 text-sm font-semibold">
                    <li>
                        <a href="mailto:hello@weddingweb.vn" class="text-gray-400 hover:text-amber-400 transition-colors duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-amber-400"></i> hello@weddingweb.vn
                        </a>
                    </td>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-200 flex items-center gap-2">
                            <i class="fa-brands fa-facebook text-blue-400"></i> Facebook
                        </a>
                    </td>
                    <li>
                        <a href="#" class="text-gray-400 hover:text-sky-400 transition-colors duration-200 flex items-center gap-2">
                            <i class="fa-solid fa-comment-sms text-sky-400"></i> Zalo
                        </a>
                    </td>
                </ul>
            </div>

        </div>

        <div class="max-w-7xl mx-auto mt-12 pt-6 border-t border-white/5 text-center text-xs text-gray-500 font-medium">
            <p>© 2026 Wedding Web Platform. Tất cả quyền được bảo lưu.</p>
        </div>
    </footer>

    <!-- <script src="script.js"></script> -->
     <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>