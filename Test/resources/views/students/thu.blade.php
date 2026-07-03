<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hồ Sơ Thiết Kế Trang Chủ Wedding Web - Canva sang Code</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Pinyon+Script&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        .font-handwriting {
            font-family: 'Pinyon Script', cursive;
        }
        .font-serif-title {
            font-family: 'Playfair Display', serif;
        }
        .font-sans-clean {
            font-family: 'Montserrat', sans-serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #FFF0F2;
        }
        ::-webkit-scrollbar-thumb {
            background: #C38D94;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-[#FFF8F8] text-[#4A3E3F] font-sans-clean min-h-screen">

    <!-- HEADER / NAVIGATION -->
    <header class="bg-white border-b border-[#F5E1E3] py-4 px-6 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#FFF0F2] flex items-center justify-center border border-[#C38D94]">
                    <span class="font-handwriting text-2xl text-[#C38D94] font-bold">W</span>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-[#8A5A60] tracking-wide uppercase">Wedding Web Blueprint</h1>
                    <p class="text-xs text-gray-400">Trình giả lập thiết kế từ Canva sang Code</p>
                </div>
            </div>
            
            <!-- Quick Color Palette Display -->
            <div class="flex items-center gap-2 bg-[#FFF0F2] py-1.5 px-3 rounded-full border border-[#F5E1E3]">
                <span class="text-xs font-semibold text-[#8A5A60] mr-1">Palette màu:</span>
                <div class="w-5 h-5 rounded-full border border-gray-300" style="background-color: #FFF0F2;" title="Hồng Nhạt Nền (#FFF0F2)"></div>
                <div class="w-5 h-5 rounded-full border border-gray-300" style="background-color: #C38D94;" title="Hồng Trầm Chữ (#C38D94)"></div>
                <div class="w-5 h-5 rounded-full border border-gray-300" style="background-color: #B56B73;" title="Hồng Đậm Nhấn (#B56B73)"></div>
                <div class="w-5 h-5 rounded-full border border-gray-300" style="background-color: #FFFFFF;" title="Trắng Tinh (#FFFFFF)"></div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8 md:px-6">
        
        <!-- Welcome intro -->
        <div class="mb-8 text-center md:text-left bg-white p-6 rounded-2xl border border-[#F5E1E3] shadow-sm">
            <span class="bg-[#FFF0F2] text-[#B56B73] px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider">Học tập từ The Knot</span>
            <h2 class="text-2xl md:text-3xl font-serif-title text-[#4A3E3F] mt-2">Bản thiết kế tương tác Trang Chủ (Tone Hồng - Trắng)</h2>
            <p class="text-sm text-gray-500 mt-1 max-w-3xl">
                Dưới đây là sơ đồ bố cục lý tưởng nhất được chắt lọc từ những mẫu đẹp nhất trên **The Knot**. Hãy sử dụng điện thoại mô phỏng bên trái làm khung tham chiếu trực quan và bảng hướng dẫn bên phải để thực hiện chính xác các thao tác kéo-thả trên Canva.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- LEFT COLUMN: INTERACTIVE PHONE SIMULATOR (4 cols on large screens) -->
            <div class="lg:col-span-5 flex justify-center sticky top-24">
                <div class="relative w-[375px] h-[780px] bg-white rounded-[50px] shadow-[0_25px_60px_-15px_rgba(181,107,115,0.3)] border-[12px] border-[#4A3E3F] overflow-hidden flex flex-col justify-between">
                    
                    <!-- Phone Camera Notch -->
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-36 h-6 bg-[#4A3E3F] rounded-b-2xl z-50 flex items-center justify-center">
                        <div class="w-3 h-3 rounded-full bg-gray-800 mr-2"></div>
                        <div class="w-12 h-1 bg-gray-700 rounded-full"></div>
                    </div>

                    <!-- SIMULATED MOBILE PAGE CONTENT -->
                    <div class="w-full h-full bg-[#FFF0F2] overflow-y-auto pt-8 flex flex-col justify-between relative" id="mobileScreen">
                        
                        <!-- Layer 1: Header / Navigation Menu -->
                        <div onclick="selectLayer('layer-header')" class="cursor-pointer group hover:bg-[#FFF8F8] p-3 transition-all duration-300 border border-transparent hover:border-[#C38D94] rounded-xl m-2 absolute top-6 left-0 right-0 z-40 flex justify-between items-center bg-white/70 backdrop-blur-sm shadow-sm" id="sim-header">
                            <!-- Hamburger Menu Icon -->
                            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm">
                                <i class="fa-solid fa-bars text-[#C38D94] text-xs"></i>
                            </div>
                            <!-- Small Monogram Logo -->
                            <span class="font-handwriting text-2xl text-[#C38D94] font-bold">N & L</span>
                            <!-- Voice / Music Invitation Trigger -->
                            <div class="w-8 h-8 rounded-full bg-[#FFF0F2] flex items-center justify-center animate-pulse shadow-sm border border-[#C38D94]">
                                <i class="fa-solid fa-microphone text-[#B56B73] text-xs"></i>
                            </div>
                        </div>

                        <!-- Spacer for Header padding -->
                        <div class="h-16"></div>

                        <!-- Layer 2: Typographic Hero content (Middle) -->
                        <div onclick="selectLayer('layer-typography')" class="cursor-pointer group hover:bg-white/80 p-4 transition-all duration-300 border border-transparent hover:border-[#C38D94] rounded-2xl mx-3 my-4 text-center" id="sim-typography">
                            <!-- Corner Line Art Ornaments (Simulated) -->
                            <div class="flex justify-center mb-1 text-[#C38D94]">
                                <i class="fa-solid fa-seedling text-sm opacity-60"></i>
                            </div>
                            
                            <!-- Subtitle / Welcome text -->
                            <p class="text-[9px] tracking-[0.25em] text-[#B56B73] font-semibold uppercase mb-1">Chào mừng bạn đến ngày vui của</p>
                            
                            <!-- Large Calligraphy Name -->
                            <h2 class="font-handwriting text-5xl text-[#C38D94] my-2 leading-none">Hoàng Nam</h2>
                            <p class="text-xs text-[#C38D94] font-serif-title my-1">&amp;</p>
                            <h2 class="font-handwriting text-5xl text-[#C38D94] my-2 leading-none">Khánh Linh</h2>
                            
                            <!-- Date -->
                            <div class="mt-3 inline-block border-y border-[#F5E1E3] py-1 px-4 text-[10px] tracking-widest text-gray-500 font-semibold uppercase">
                                26 . 12 . 2026
                            </div>
                        </div>

                        <!-- Layer 3: Landscape Photo Frame & Countdown Overlay -->
                        <div onclick="selectLayer('layer-photo')" class="cursor-pointer group hover:opacity-95 transition-all duration-300 relative mx-3 mb-4 rounded-3xl overflow-hidden border-2 border-transparent hover:border-[#C38D94] shadow-md h-72" id="sim-photo">
                            <!-- Placeholder Wedding Photo -->
                            <div class="w-full h-full bg-cover bg-center flex items-end justify-center pb-4" style="background-image: url('https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=600');">
                                <!-- Backdrop filter shadow to make countdown readable -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
                                
                                <!-- Countdown Widget -->
                                <div class="relative bg-white/90 backdrop-blur-sm rounded-2xl py-2 px-3 shadow-lg border border-[#FFF0F2] text-center w-[90%] mx-auto z-10 flex justify-around items-center">
                                    <div>
                                        <span class="block text-sm font-bold text-[#B56B73] font-sans-clean leading-tight">180</span>
                                        <span class="text-[8px] text-gray-400 uppercase tracking-widest">Ngày</span>
                                    </div>
                                    <span class="text-gray-300">:</span>
                                    <div>
                                        <span class="block text-sm font-bold text-[#B56B73] font-sans-clean leading-tight">12</span>
                                        <span class="text-[8px] text-gray-400 uppercase tracking-widest">Giờ</span>
                                    </div>
                                    <span class="text-gray-300">:</span>
                                    <div>
                                        <span class="block text-sm font-bold text-[#B56B73] font-sans-clean leading-tight">45</span>
                                        <span class="text-[8px] text-gray-400 uppercase tracking-widest">Phút</span>
                                    </div>
                                    <span class="text-gray-300">:</span>
                                    <div>
                                        <span class="block text-sm font-bold text-[#B56B73] font-sans-clean leading-tight">09</span>
                                        <span class="text-[8px] text-gray-400 uppercase tracking-widest">Giây</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Layer 4: Call-To-Action Floating RSVP Button -->
                        <div onclick="selectLayer('layer-rsvp')" class="cursor-pointer group hover:scale-[1.02] p-3 transition-all duration-300 border border-transparent hover:border-[#C38D94] rounded-2xl mx-3 mb-6" id="sim-rsvp">
                            <button class="w-full py-3 bg-[#B56B73] text-white rounded-full font-semibold text-xs tracking-widest shadow-md hover:bg-[#8A5A60] transition-colors uppercase flex items-center justify-center gap-2">
                                <i class="fa-solid fa-envelope-open-text"></i>
                                Xác nhận tham dự (RSVP)
                            </button>
                            <p class="text-center text-[9px] text-[#C38D94] mt-2 animate-bounce">
                                <i class="fa-solid fa-angle-down mr-1"></i> Cuộn xuống để xem chi tiết
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: INTERACTIVE DESIGN GUIDANCE (7 cols on large screens) -->
            <div class="lg:col-span-7 flex flex-col gap-6">
                
                <!-- Tab Headers -->
                <div class="flex border-b border-[#F5E1E3] bg-white rounded-t-2xl p-2 gap-2">
                    <button onclick="switchTab('canva-steps')" id="tab-btn-canva-steps" class="flex-1 py-3 text-sm font-semibold rounded-xl transition-all text-[#B56B73] bg-[#FFF0F2]">
                        <i class="fa-brands fa-canva mr-2 text-blue-500"></i> Hướng dẫn kéo Canva
                    </button>
                    <button onclick="switchTab('code-specs')" id="tab-btn-code-specs" class="flex-1 py-3 text-sm font-semibold rounded-xl transition-all text-gray-500 hover:bg-gray-50">
                        <i class="fa-solid fa-code mr-2"></i> Chuyển sang Code HTML/CSS
                    </button>
                    <button onclick="switchTab('system-flow')" id="tab-btn-system-flow" class="flex-1 py-3 text-sm font-semibold rounded-xl transition-all text-gray-500 hover:bg-gray-50">
                        <i class="fa-solid fa-diagram-project mr-2"></i> Lộ trình & Sơ đồ hệ thống
                    </button>
                </div>

                <!-- TAB CONTENT: CANVA STEPS -->
                <div id="tab-canva-steps" class="flex flex-col gap-6">
                    
                    <!-- Instruction Card for Header Layer -->
                    <div id="layer-header" class="bg-white p-6 rounded-2xl border-2 border-transparent transition-all duration-300 shadow-sm layer-card">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 rounded-full bg-[#FFF0F2] text-[#B56B73] flex items-center justify-center font-bold">1</span>
                            <h3 class="text-lg font-serif-title font-bold text-[#4A3E3F]">Header & Lời Mời Giọng Nói (Lớp 1)</h3>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600">
                            <p><strong class="text-[#B56B73]">Mục tiêu:</strong> Tạo điểm nhấn thương hiệu cá nhân của cặp đôi và nút kích hoạt ghi âm lời mời chào mừng cực kì ấm áp.</p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li><strong>Cách vẽ trên Canva:</strong> Tạo một hình chữ nhật dẹt ngang ở sát mép trên. Chỉnh màu nền hình chữ nhật này là Trắng tinh hoặc trong suốt, bo nhẹ góc.</li>
                                <li><strong>Chữ Monogram Logo:</strong> Gõ phím <kbd class="px-1.5 py-0.5 bg-gray-100 border rounded text-xs">T</kbd>, ghi tên viết tắt (ví dụ: `N & L` hoặc `N ✦ L`). Đổi font thành <strong class="text-[#C38D94]">"Pinyon Script"</strong> hoặc font viết tay uốn lượn bay bổng.</li>
                                <li><strong>Nút Lời Mời Bằng Giọng Nói (🎙️):</strong> Vào mục <strong class="text-[#B56B73]">Thành phần (Elements)</strong> -> Tìm từ khóa <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">"Microphone line icon"</code> hoặc <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">"Music wave"</code>. Vẽ một vòng tròn nhỏ ở bên phải, đổ màu hồng đậm <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">#B56B73</code>, chèn icon micro vào giữa vòng tròn.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Instruction Card for Typography Layer -->
                    <div id="layer-typography" class="bg-white p-6 rounded-2xl border-2 border-transparent transition-all duration-300 shadow-sm layer-card">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 rounded-full bg-[#FFF0F2] text-[#B56B73] flex items-center justify-center font-bold">2</span>
                            <h3 class="text-lg font-serif-title font-bold text-[#4A3E3F]">Phần Chữ Nghệ Thuật Calligraphy (Lớp 2)</h3>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600">
                            <p><strong class="text-[#B56B73]">Mục tiêu:</strong> Tạo sự bay bổng, nghệ thuật chuẩn phong cách "The Knot", gây ấn tượng thị giác mạnh mẽ ngay lập tức.</p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li><strong>Căn lề:</strong> Đặt tất cả khối chữ này vào **chính giữa trục dọc** màn hình để giao diện trông cân đối.</li>
                                <li><strong>Họa tiết đường mảnh (Line Art):</strong> Vào mục <strong class="text-[#B56B73]">Thành phần</strong> -> Tìm kiếm <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">"Wedding line ornament"</code> hoặc <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">"Rose stem minimal"</code>. Chọn dải hoa nhạt đặt nhẹ nhàng ở trên cùng để làm điểm tựa thị giác.</li>
                                <li><strong>Chữ Tên Cặp Đôi:</strong> Gõ <kbd class="px-1.5 py-0.5 bg-gray-100 border rounded text-xs">T</kbd>. Chọn font viết tay cực mảnh và uốn lượn như <strong class="text-[#C38D94]">"Pinyon Script"</strong> hoặc <strong class="text-[#C38D94]">"Celebration"</strong>. Để cỡ chữ khoảng 100-120pt trên Canva. Đổi sang màu hồng trầm sắc sảo <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">#C38D94</code>.</li>
                                <li><strong>Ngày cưới & Lời mời:</strong> Kẹp ngày cưới vào giữa 2 đường thẳng mảnh nằm ngang (sử dụng phím tắt <kbd class="px-1.5 py-0.5 bg-gray-100 border rounded text-xs">L</kbd> để vẽ đường thẳng nhanh). Font chữ ngày cưới nên dùng font cứng, sạch sẽ như <strong class="text-[#C38D94]">"Montserrat"</strong> hoặc <strong class="text-[#C38D94]">"Inter"</strong>, kéo giãn khoảng cách chữ (Letter spacing) rộng ra.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Instruction Card for Photo & Countdown Layer -->
                    <div id="layer-photo" class="bg-white p-6 rounded-2xl border-2 border-transparent transition-all duration-300 shadow-sm layer-card">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 rounded-full bg-[#FFF0F2] text-[#B56B73] flex items-center justify-center font-bold">3</span>
                            <h3 class="text-lg font-serif-title font-bold text-[#4A3E3F]">Ảnh Cưới Toàn Cảnh & Đồng Hồ Đếm Ngược (Lớp 3)</h3>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600">
                            <p><strong class="text-[#B56B73]">Mục tiêu:</strong> Hiển thị bức ảnh hạnh phúc nhất kèm widget đếm ngược khơi gợi cảm giác hồi hộp đến ngày hỷ.</p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li><strong>Tạo Khung Ảnh Bo Góc:</strong> Vào mục <strong class="text-[#B56B73]">Thành phần</strong> -> Tìm khung <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">"Frame round corner"</code> hoặc khung hình vòm cổng cưới thời thượng <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">"Arch frame"</code>. Thả ảnh cưới phong cảnh nằm ngang của bạn vào khung này.</li>
                                <li><strong>Vẽ Widget Đếm Ngược:</strong> Chọn hình vuông bo góc, kéo dẹt thành dải ngang mỏng đè lên phần mép dưới ảnh cưới. Đổi màu dải này sang màu Trắng và chỉnh độ trong suốt về <strong class="text-[#B56B73]">80%</strong> để hình nền cưới vẫn mờ mờ hiện ra phía sau.</li>
                                <li><strong>Nội dung đếm ngược:</strong> Điền các thông số số ngày, giờ, phút rõ nét bằng màu chữ hồng trầm <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">#C38D94</code>.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Instruction Card for RSVP Layer -->
                    <div id="layer-rsvp" class="bg-white p-6 rounded-2xl border-2 border-transparent transition-all duration-300 shadow-sm layer-card">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 rounded-full bg-[#FFF0F2] text-[#B56B73] flex items-center justify-center font-bold">4</span>
                            <h3 class="text-lg font-serif-title font-bold text-[#4A3E3F]">Nút Xác Nhận RSVP Nổi Bật (Lớp 4)</h3>
                        </div>
                        <div class="space-y-3 text-sm text-gray-600">
                            <p><strong class="text-[#B56B73]">Mục tiêu:</strong> Điểm kêu gọi hành động rõ nhất, kích thích khách bấm vào để phản hồi trực tiếp trạng thái tham gia.</p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li><strong>Tạo Hình Dáng Nút (Pill Shape):</strong> Vào mục <strong class="text-[#B56B73]">Thành phần</strong> -> Vẽ một hình chữ nhật bo tròn hẳn cả 2 đầu như viên thuốc nhộng.</li>
                                <li><strong>Đổ Màu Kích Thích Thị Giác:</strong> Sử dụng màu hồng nhấn đậm nhất trong bảng màu: <code class="bg-gray-100 px-1 py-0.5 rounded text-[#B56B73]">#B56B73</code>. Thêm hiệu ứng bóng đổ nhẹ phía dưới nút (Shadow) để tạo cảm giác nút nổi hẳn lên trên mặt phẳng màn hình, rất dễ bấm chạm trên mobile.</li>
                                <li><strong>Chữ hiển thị:</strong> Nhập chữ <strong class="text-white bg-[#B56B73] px-2 py-0.5 rounded">XÁC NHẬN THAM DỰ (RSVP)</strong> bằng màu trắng, in hoa, font nét dày tinh tế.</li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- TAB CONTENT: CODE SPECS -->
                <div id="tab-code-specs" class="hidden bg-white p-6 rounded-2xl border border-[#F5E1E3] shadow-sm">
                    <h3 class="text-lg font-serif-title font-bold text-[#4A3E3F] mb-4">Cấu Trúc Thẻ HTML & Lập Trình Giao Diện</h3>
                    <p class="text-xs text-gray-500 mb-6">Bạn có thể copy đoạn khung xương HTML này để triển khai code giao diện mượt mà y hệt bản thiết kế Canva:</p>
                    
                    <div class="bg-gray-900 text-gray-300 p-4 rounded-xl font-mono text-xs overflow-x-auto">
<pre><code>&lt;!-- KHUNG TRANG CHỦ HERO SECTION (MOBILE FIRST) --&gt;
&lt;section class="min-h-screen bg-[#FFF0F2] flex flex-col justify-between p-4"&gt;

  &lt;!-- Lớp 1: Header &amp; Lời mời giọng nói --&gt;
  &lt;header class="flex justify-between items-center bg-white/70 backdrop-blur-md p-3 rounded-2xl shadow-sm"&gt;
    &lt;button class="w-8 h-8 rounded-full flex items-center justify-center text-[#C38D94]"&gt;
      &lt;i class="fa-solid fa-bars"&gt;&lt;/i&gt;
    &lt;/button&gt;
    &lt;span class="font-serif-title italic text-xl text-[#C38D94]"&gt;N &amp; L&lt;/span&gt;
    &lt;!-- Nút voice cá nhân hóa --&gt;
    &lt;button id="playVoiceBtn" class="w-8 h-8 rounded-full bg-[#FFF0F2] flex items-center justify-center animate-bounce text-[#B56B73]" onclick="playVoiceInvite()"&gt;
      &lt;i class="fa-solid fa-microphone"&gt;&lt;/i&gt;
    &lt;/button&gt;
  &lt;/header&gt;

  &lt;!-- Lớp 2: Chữ nghệ thuật Calligraphy --&gt;
  &lt;div class="text-center my-6"&gt;
    &lt;p class="text-[9px] tracking-widest text-[#B56B73] uppercase font-semibold mb-2"&gt;Chào mừng bạn đến ngày vui của&lt;/p&gt;
    &lt;h1 class="font-serif-title italic text-4xl text-[#C38D94] leading-tight"&gt;Hoàng Nam&lt;/h1&gt;
    &lt;span class="text-[#C38D94] font-serif-title text-sm"&gt;&amp;amp;&lt;/span&gt;
    &lt;h1 class="font-serif-title italic text-4xl text-[#C38D94] leading-tight"&gt;Khánh Linh&lt;/h1&gt;
    &lt;div class="inline-block border-y border-[#F5E1E3] py-1 px-4 text-xs tracking-widest text-gray-500 mt-4"&gt;26.12.2026&lt;/div&gt;
  &lt;/div&gt;

  &lt;!-- Lớp 3: Khung ảnh cưới &amp; Countdown --&gt;
  &lt;div class="relative rounded-3xl overflow-hidden shadow-lg h-72"&gt;
    &lt;img src="path_to_wedding_photo.jpg" class="w-full h-full object-cover" alt="Wedding Couple"&gt;
    &lt;!-- Countdown Widget đè lên dưới cùng --&gt;
    &lt;div class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-sm rounded-2xl p-3 flex justify-around text-center shadow-md"&gt;
      &lt;div&gt;&lt;span class="block text-md font-bold text-[#B56B73]" id="days"&gt;180&lt;/span&gt;&lt;span class="text-[8px] text-gray-400"&gt;Ngày&lt;/span&gt;&lt;/div&gt;
      &lt;div&gt;&lt;span class="block text-md font-bold text-[#B56B73]" id="hours"&gt;12&lt;/span&gt;&lt;span class="text-[8px] text-gray-400"&gt;Giờ&lt;/span&gt;&lt;/div&gt;
      &lt;div&gt;&lt;span class="block text-md font-bold text-[#B56B73]" id="minutes"&gt;45&lt;/span&gt;&lt;span class="text-[8px] text-gray-400"&gt;Phút&lt;/span&gt;&lt;/div&gt;
    &lt;/div&gt;
  &lt;/div&gt;

  &lt;!-- Lớp 4: Nút RSVP --&gt;
  &lt;div class="mt-4 mb-2"&gt;
    &lt;button class="w-full py-3.5 bg-[#B56B73] text-white rounded-full font-bold text-xs tracking-wider shadow-lg hover:bg-[#8A5A60] transition-all uppercase"&gt;
      Xác nhận tham dự (RSVP)
    &lt;/button&gt;
  &lt;/div&gt;

&lt;/section&gt;</code></pre>
                    </div>
                </div>

                <!-- TAB CONTENT: SYSTEM FLOW -->
                <div id="tab-system-flow" class="hidden bg-white p-6 rounded-2xl border border-[#F5E1E3] shadow-sm space-y-6">
                    <h3 class="text-lg font-serif-title font-bold text-[#4A3E3F]">Sơ Đồ Kế Hoạch Đầy Đủ (Giai đoạn tiếp theo)</h3>
                    <p class="text-sm text-gray-600">
                        Sau khi hoàn thiện Canva cho trang chủ, đây là sơ đồ luồng tính năng cao cấp bạn cần chuẩn bị thiết kế kế tiếp:
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-[#FFF8F8] border border-[#F5E1E3] rounded-xl">
                            <h4 class="font-bold text-[#B56B73] text-sm flex items-center gap-2">
                                <i class="fa-solid fa-microphone"></i> 1. Luồng Giọng Nói Cá Nhân
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                Khi mở link: Hệ thống check tên khách trong DB ➔ Phát file audio cụ thể: "Chào bạn Nam..." ➔ RSVP xong phát âm thanh cảm ơn hoặc hiển thị form ghi âm lời chúc thoại của khách gửi ngược lại cho Cô dâu chú rể.
                            </p>
                        </div>
                        <div class="p-4 bg-[#FFF8F8] border border-[#F5E1E3] rounded-xl">
                            <h4 class="font-bold text-[#B56B73] text-sm flex items-center gap-2">
                                <i class="fa-solid fa-chair"></i> 2. Sơ Đồ Bàn Tiệc Hướng Nội
                            </h4>
                            <p class="text-xs text-gray-500 mt-1">
                                Khách gõ tên trên ô Tìm kiếm ➔ Kết quả tra cứu API trả về: "Bàn số 12 - Nhóm Bạn Cấp 3" ➔ Hiển thị bản vẽ sảnh tiệc của nhà hàng, tô màu đỏ nhấp nháy đúng bàn số 12 để khách tự đi vào không cần hỏi ai.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-[#F5E1E3] py-8 text-center text-xs text-gray-400 mt-16">
        <p>© 2026 Bản Kế Hoạch và Thiết Kế Website Đám Cưới Toàn Diện. Thiết kế đặc quyền cho dự án của hai bạn.</p>
    </footer>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        // Interactive Select Highlight Logic
        function selectLayer(layerId) {
            // Remove active style from all instruction cards
            document.querySelectorAll('.layer-card').forEach(card => {
                card.classList.remove('ring-4', 'ring-[#B56B73]', 'scale-[1.01]', 'border-transparent');
                card.classList.add('border-transparent');
            });

            // Remove active style from all simulator wrappers
            const simHeader = document.getElementById('sim-header');
            const simTypography = document.getElementById('sim-typography');
            const simPhoto = document.getElementById('sim-photo');
            const simRsvp = document.getElementById('sim-rsvp');

            simHeader.classList.remove('bg-white/90', 'border-[#C38D94]');
            simTypography.classList.remove('bg-white/90', 'border-[#C38D94]');
            simPhoto.classList.remove('border-[#C38D94]');
            simRsvp.classList.remove('border-[#C38D94]');

            // Apply selected styling
            const targetCard = document.getElementById(layerId);
            if (targetCard) {
                targetCard.classList.add('ring-4', 'ring-[#B56B73]', 'scale-[1.01]');
                targetCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            // Switch to Canva Tab to ensure users can see instructions
            switchTab('canva-steps');

            // Highlight in simulator
            if (layerId === 'layer-header') {
                simHeader.classList.add('bg-white/90', 'border-[#C38D94]');
            } else if (layerId === 'layer-typography') {
                simTypography.classList.add('bg-white/90', 'border-[#C38D94]');
            } else if (layerId === 'layer-photo') {
                simPhoto.classList.add('border-[#C38D94]');
            } else if (layerId === 'layer-rsvp') {
                simRsvp.classList.add('border-[#C38D94]');
            }
        }

        // Switch Tabs Logic
        function switchTab(tabId) {
            const tabs = ['canva-steps', 'code-specs', 'system-flow'];
            tabs.forEach(t => {
                const element = document.getElementById(`tab-${t}`);
                const btn = document.getElementById(`tab-btn-${t}`);
                if (t === tabId) {
                    element.classList.remove('hidden');
                    btn.classList.add('bg-white', 'text-[#B56B73]', 'bg-[#FFF0F2]');
                    btn.classList.remove('text-gray-500', 'hover:bg-gray-50');
                } else {
                    element.classList.add('hidden');
                    btn.classList.remove('bg-white', 'text-[#B56B73]', 'bg-[#FFF0F2]');
                    btn.classList.add('text-gray-500', 'hover:bg-gray-50');
                }
            });
        }
    </script>
</body>
</html>