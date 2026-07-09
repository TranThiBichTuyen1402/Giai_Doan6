<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biihappy Premium Wedding - Nền Tảng Tạo Website Đám Cưới 3D</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #0b020f;
            margin: 0;
            overflow-x: hidden;
        }
        .font-luxury {
            font-family: 'Alex Brush', cursive;
        }
        /* Cấu hình không gian 3D cho Hero Banner */
        .view-3d-space {
            perspective: 1200px;
            perspective-origin: 50% 50%;
        }
        .wrapper-3d {
            transform-style: preserve-3d;
            transition: transform 0.1s ease-out;
        }
        /* Lớp 1: Ảnh nền siêu bự nằm sâu phía dưới */
        .layer-bg-photo {
            transform: translateZ(-10px) scale(1);
            background-image: url('https://alohastudio.vn/wp-content/uploads/2024/05/ngoai-canh-sai-gon-5.jpg');
        }
        /* Lớp 2: Chữ và nút bấm đẩy hẳn lên phía trước */
        .layer-foreground-text {
            transform: translateZ(60px) scale(0.9);
        }
        /* Hiệu ứng chữ mạ vàng hồng Gradient óng ánh */
        .text-gold-gradient {
            background: linear-gradient(to right, #ffd700, #ff758c, #ff7eb3, #ffd700);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 4s linear infinite;
        }
        @keyframes shine {
            to { background-position: 200% center; }
        }
        .particle {
            position: absolute;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,117,140,0) 70%);
            border-radius: 50%;
            animation: floatParticle linear infinite;
            pointer-events: none;
        }
        @keyframes floatParticle {
            0% { transform: translateY(105vh) scale(0.5); opacity: 0; }
            50% { opacity: 0.8; }
            100% { transform: translateY(-5vh) scale(1.2); opacity: 0; }
        }
    </style>
</head>
<body>

    <nav class="fixed top-0 left-0 right-0 z-50 bg-black/30 backdrop-blur-xl border-b border-white/10 px-6 py-4 transition-all duration-300">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="#" class="flex items-center gap-2">
                <span class="text-2xl font-bold bg-gradient-to-r from-pink-400 to-amber-400 bg-clip-text text-transparent font-luxury">ForeverOne</span>
                <span class="bg-pink-500/20 text-pink-400 text-[10px] uppercase font-bold tracking-widest px-2 py-0.5 rounded-full border border-pink-500/30">3D Web</span>
            </a>

            <div class="hidden md:flex items-center space-x-8 text-sm font-semibold text-gray-200">
                <a href="#features" class="hover:text-pink-400 transition">Tính năng</a>
                <a href="#templates" class="hover:text-pink-400 transition font-medium flex items-center gap-1">Kho giao diện <span class="bg-amber-400 text-black text-[9px] px-1 rounded font-bold">HOT</span></a>
                <a href="#pricing" class="hover:text-pink-400 transition">Bảng giá</a>
                <a href="#instructions" class="hover:text-pink-400 transition">Hướng dẫn</a>
            </div>

            <div class="flex items-center gap-4">
                <button onclick="openAuthModal('login')" class="text-sm font-bold text-white hover:text-pink-400 transition px-3 py-2">
                    Đăng nhập
                </button>
                <button onclick="openAuthModal('register')" class="text-sm font-bold bg-gradient-to-r from-pink-500 to-rose-500 text-white px-5 py-2.5 rounded-full shadow-lg shadow-pink-500/20 hover:scale-105 transition active:scale-95">
                    Tạo tài khoản miễn phí
                </button>
            </div>
        </div>
    </nav>

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

    <section id="features" class="relative z-30 bg-[#0b020f] py-24 px-6 border-t border-white/5">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-xs uppercase font-bold tracking-widest text-pink-500 mb-2">Hệ sinh thái thông minh</h2>
            <p class="text-3xl md:text-4xl font-bold text-white mb-16">Website Đám Cưới Của Bạn Có Gì?</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="p-8 bg-white/5 rounded-2xl border border-white/10 hover:border-pink-500/50 transition duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-pink-500/20 text-pink-400 flex items-center justify-center text-xl mb-6 group-hover:bg-pink-500 group-hover:text-white transition duration-300">
                        <i class="fa-solid fa-microphone-lines"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Lời mời & Lưu bút bằng Voice</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Tích hợp AI cá nhân hóa gọi tên khách mời, cho phép ghi âm lời chúc trực tiếp gửi tới cặp đôi.</p>
                </div>
                <div class="p-8 bg-white/5 rounded-2xl border border-white/10 hover:border-purple-500/50 transition duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-xl mb-6 group-hover:bg-purple-500 group-hover:text-white transition duration-300">
                        <i class="fa-solid fa-chair"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Sơ đồ vị trí ngồi thông minh</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Khách mời chỉ cần nhập tên để biết chính xác số bàn, vị trí khu vực sảnh tiệc mà không cần hỏi lễ tân.</p>
                </div>
                <div class="p-8 bg-white/5 rounded-2xl border border-white/10 hover:border-amber-500/50 transition duration-300 group">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-xl mb-6 group-hover:bg-amber-500 group-hover:text-white transition duration-300">
                        <i class="fa-solid fa-users-gear"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Hệ thống quản trị RSVP</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Theo dõi thời gian thực ai tham gia, ai vắng mặt, số lượng người đi kèm để quản lý cỗ cưới chính xác.</p>
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


    <script>
        const wrapper = document.getElementById('card-wrapper');
        const isMobile = /Android|iPhone|iPad/i.test(navigator.userAgent);

        // 1. GENERATE HẠT ÁNH SÁNG BAY PHÍA TRÊN LỚP ẢNH
        const particleContainer = document.getElementById('particle-container');
        const particleCount = 40;
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            const size = Math.random() * 5 + 2;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.animationDuration = `${Math.random() * 5 + 4}s`;
            particle.style.animationDelay = `${Math.random() * 5}s`;
            particleContainer.appendChild(particle);
        }

        // 2. PHÁT TRIỂN HỆ THỐNG ĐIỀU HƯỚNG XOAY KHÔNG GIAN 3D TƯƠNG TÁC CHUỘT
        if (!isMobile) {
            window.addEventListener('mousemove', (e) => {
                const { clientX, clientY } = e;
                const { innerWidth, innerHeight } = window;
                const rotateY = ((clientX - innerWidth / 2) / (innerWidth / 2)) * 12;
                const rotateX = -((clientY - innerHeight / 2) / (innerHeight / 2)) * 12;
                wrapper.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
            window.addEventListener('mouseleave', () => {
                wrapper.style.transition = 'transform 0.6s ease-out';
                wrapper.style.transform = 'rotateX(0deg) rotateY(0deg)';
                setTimeout(() => { wrapper.style.transition = 'transform 0.1s ease-out'; }, 600);
            });
        } else if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', (e) => {
                const rotateY = Math.min(Math.max(e.gamma, -20), 20) * 0.5;
                const rotateX = (Math.min(Math.max(e.beta, 40), 80) - 60) * 0.5;
                wrapper.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
        }

        // 3. ĐIỀU KHIỂN HỘP THOẠI POP-UP ĐĂNG NHẬP / ĐĂNG KÝ (AUTH SYSTEM MODAL)
        let currentMode = 'login'; // Mặc định chế độ login
        const modal = document.getElementById('auth-modal');
        const modalContent = document.getElementById('modal-content');

        function openAuthModal(mode) {
            currentMode = mode;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 50);
            updateModalUI();
        }

        function closeAuthModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => { modal.classList.add('hidden'); }, 300);
        }

        function toggleAuthMode() {
            currentMode = (currentMode === 'login') ? 'register' : 'login';
            updateModalUI();
        }

        // Cập nhật giao diện bên trong Pop-up tương ứng theo trạng thái
        function updateModalUI() {
            const title = document.getElementById('modal-title');
            const subtitle = document.getElementById('modal-subtitle');
            const fieldName = document.getElementById('field-fullname');
            const fieldTerms = document.getElementById('field-terms');
            const btnSubmit = document.getElementById('btn-auth-submit');
            const switchText = document.getElementById('switch-text');
            const btnSwitch = document.getElementById('btn-switch-mode');

            if (currentMode === 'login') {
                title.innerText = "Đăng Nhập Tài Khoản";
                subtitle.innerText = "Chào mừng bạn trở lại với thiên đường cưới";
                fieldName.classList.add('hidden');
                fieldTerms.classList.add('hidden');
                btnSubmit.innerText = "Đăng Nhập";
                switchText.innerText = "Chưa có tài khoản đám cưới?";
                btnSwitch.innerText = "Đăng ký ngay";
            } else {
                title.innerText = "Đăng Ký Nền Tảng";
                subtitle.innerText = "Chỉ mất 30 giây để sở hữu một không gian cưới độc bản";
                fieldName.classList.remove('hidden');
                fieldTerms.classList.remove('hidden');
                btnSubmit.innerText = "Tạo Tài Khoản Kỷ Niệm";
                switchText.innerText = "Đã có tài khoản quản lý?";
                btnSwitch.innerText = "Đăng nhập";
            }
        }

        function handleAuthSubmit(e) {
            e.preventDefault();
            const email = document.getElementById('auth-email').value;
            alert(`Hệ thống giả lập thành công hành động xử lý [${currentMode.toUpperCase()}] cho tài khoản: ${email}`);
            closeAuthModal();
        }
    </script>
</body>
</html>