
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
        //đóng mở câu hỏi thường gặp

    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const faqItem = button.parentElement;
            const content = button.nextElementSibling;
            const icon = button.querySelector('i');

            // Đóng tất cả các câu hỏi khác nếu muốn (Hiệu ứng Accordion đơn lẻ)
            document.querySelectorAll('.faq-item').forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('border-pink-500/50', 'bg-white/10');
                    item.querySelector('.faq-content').style.maxHeight = null;
                    item.querySelector('i').style.transform = 'rotate(0deg)';
                }
            });

            // Toggle trạng thái của câu hỏi hiện tại
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                faqItem.classList.remove('border-pink-500/50', 'bg-white/10');
                icon.style.transform = 'rotate(0deg)';
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
                faqItem.classList.add('border-pink-500/50', 'bg-white/10');
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });
    
