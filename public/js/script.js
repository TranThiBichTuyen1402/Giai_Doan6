document.addEventListener('DOMContentLoaded', function () {
    // ==========================================================================
    // KHAI BÁO BIẾN & ĐỐI TƯỢNG DOM
    // ==========================================================================
    const wrapper = document.getElementById('card-wrapper');
    const isMobile = /Android|iPhone|iPad/i.test(navigator.userAgent);
    const particleContainer = document.getElementById('particle-container');
    const modal = document.getElementById('auth-modal');
    const modalContent = document.getElementById('modal-content');
    const authForm = document.getElementById('auth-form');

    // ==========================================================================
    // 1. GENERATE HẠT ÁNH SÁNG BAY PHÍA TRÊN LỚP ẢNH
    // ==========================================================================
    if (particleContainer) {
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
    }

    // ==========================================================================
    // 2. PHÁT TRIỂN HỆ THỐNG ĐIỀU HƯỚNG XOAY KHÔNG GIAN 3D TƯƠNG TÁC CHUỘT
    // ==========================================================================
    if (wrapper) {
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
    }

    // ==========================================================================
    // 3. ĐIỀU KHIỂN HỘP THOẠI POP-UP ĐĂNG NHẬP / ĐĂNG KÝ (AUTH SYSTEM MODAL)
    // ==========================================================================
    let currentMode = 'login'; // Mặc định chế độ login

    window.openAuthModal = function(mode) {
        if (!modal || !modalContent) return;
        currentMode = mode || 'login';
        modal.classList.remove('d-none');
        modal.classList.add('d-flex');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            if (modalContent) modalContent.classList.remove('scale-95');
        }, 50);
        updateModalUI();
    }

    window.closeAuthModal = function() {
        if (!modal || !modalContent) return;
        modal.classList.remove('d-flex');
        modal.classList.add('d-none');
        setTimeout(() => { modal.classList.add('d-none'); }, 300);
    }

    window.toggleAuthMode = function() {
        currentMode = (currentMode === 'login') ? 'register' : 'login';
        updateModalUI();
    }

    function updateModalUI() {
        const title = document.getElementById('modal-title');
        const subtitle = document.getElementById('modal-subtitle');
        const fieldName = document.getElementById('field-fullname');
        const fieldTerms = document.getElementById('field-terms');
        const btnSubmit = document.getElementById('btn-auth-submit');
        const switchText = document.getElementById('switch-text');
        const btnSwitch = document.getElementById('btn-switch-mode');

        if (!title || !subtitle || !fieldName || !fieldTerms || !btnSubmit || !switchText || !btnSwitch) return;

        if (currentMode === 'login') {
            title.innerText = "Đăng Nhập Tài Khoản";
            subtitle.innerText = "Chào mừng bạn trở lại với thiên đường cưới";
            fieldName.classList.add('d-none');
            fieldTerms.classList.add('d-none');
            btnSubmit.innerText = "Đăng Nhập";
            switchText.innerText = "Chưa có tài khoản đám cưới?";
            btnSwitch.innerText = "Đăng ký ngay";
        } else {
            title.innerText = "Đăng Ký Nền Tảng";
            subtitle.innerText = "Chỉ mất 30 giây để sở hữu một không gian cưới độc bản";
            fieldName.classList.remove('d-none');
            fieldTerms.classList.remove('d-none');
            btnSubmit.innerText = "Tạo Tài Khoản Kỷ Niệm";
            switchText.innerText = "Đã có tài khoản quản lý?";
            btnSwitch.innerText = "Đăng nhập";
        }
    }

    // ==========================================================================
    // 3.1. BẮT SỰ KIỆN NÚT LƯU THIỆP & GỌI HÀM AJAX LƯU THIỆP
    // ==========================================================================
    const btnSaveCard = document.getElementById('btnSaveCard'); 
    const builderForm = document.getElementById('builderForm'); 

    if (btnSaveCard) {
        btnSaveCard.addEventListener('click', function (e) {
            e.preventDefault();
            executeSaveCard();
        });
    }

    function executeSaveCard() {
        if (!builderForm) return;

        let formData = new FormData(builderForm);
        let token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        Swal.fire({
            title: 'Đang lưu thiệp...',
            text: 'Vui lòng chờ trong giây lát',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        fetch("/api/save-wedding-card", { 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const isLoggedIn = document.querySelector('meta[name="user-logged-in"]')?.getAttribute('content') === 'true';

                if (isLoggedIn) {
                    // TRƯỜNG HỢP 1: ĐÃ ĐĂNG NHẬP
                    Swal.fire({
                        icon: 'success',
                        title: 'Lưu thiệp thành công! 🎉',
                        text: 'Thiệp cưới của bạn đã được cập nhật vào tài khoản.',
                        showCancelButton: true,
                        confirmButtonText: 'Xem thiệp ngay 🔗',
                        cancelButtonText: 'Ở lại chỉnh sửa ✏️'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.open(data.card_url, '_blank');
                        }
                    });
                } else {
                    // TRƯỜNG HỢP 2: CHƯA ĐĂNG NHẬP -> Pop-up nhắc Đăng ký/Đăng nhập
                   // TRƯỜNG HỢP 2: CHƯA ĐĂNG NHẬP -> Pop-up nhắc Đăng ký giữ thiệp
Swal.fire({
    icon: 'success',
    title: 'Tạo thiệp thành công! 🎉',
    html: `
        <p class="text-muted small mb-2">Thiệp cưới của bạn đã được khởi tạo thành công.</p>
        <div style="background: #fff3cd; color: #856404; padding: 10px 14px; border-radius: 8px; font-size: 13px; text-align: left; line-height: 1.5; margin-top: 10px;">
            ⚠️ <b>Lưu ý quan trọng:</b> Hãy <b>Tạo tài khoản miễn phí</b> để lưu thiệp này vào danh sách quản lý & chỉnh sửa sau này!
        </div>
    `,
    showCancelButton: true,
    confirmButtonText: 'Tạo tài khoản miễn phí',
    cancelButtonText: 'Xem thiệp trước 🔗',
    allowOutsideClick: false,
    customClass: {
        // Sử dụng lại 100% class nút của Trang Chủ
        confirmButton: 'btn btn-sm fw-bold gradient-btn rounded-pill px-4 py-2 shadow border-0',
        cancelButton: 'btn btn-sm btn-secondary rounded-pill px-3 py-2'
    },
    buttonsStyling: false // Tắt style mặc định của SweetAlert2
}).then((result) => {
    if (result.isConfirmed) {
        // 1. Lưu ID thiệp tạm thời vào LocalStorage
        if (data.card_id) {
            localStorage.setItem('pending_card_id', data.card_id);
        }
        
        // 2. Mở thẳng Modal Đăng Ký ('register')
        if (typeof openAuthModal === 'function') {
            openAuthModal('register');
        } else {
            window.location.href = "/?open_auth=register";
        }
    } else if (data.card_url) {
        window.open(data.card_url, '_blank');
    }
});
            
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: data.message || 'Lưu thiệp thất bại'
                });
            }
        })
        .catch(err => {
            console.error('Error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Lỗi máy chủ',
                text: 'Có lỗi xảy ra khi lưu thiệp. Vui lòng thử lại!'
            });
        });
    }

    // ==========================================================================
    // 3.2. SUBMIT FORM ĐĂNG NHẬP / ĐĂNG KÝ (XỬ LÝ ROUTE /api/auth)
    // ==========================================================================
    if (authForm) {
        authForm.addEventListener('submit', handleAuthSubmit);
    }

    async function handleAuthSubmit(e) {
        e.preventDefault(); 

        const nameField = document.getElementById('auth-name');
        const name = nameField ? nameField.value : '';
        const emailField = document.getElementById('auth-email');
        const passwordField = document.getElementById('auth-password');

        if (!emailField || !passwordField) return;

        const email = emailField.value;
        const password = passwordField.value;
        
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') 
                      || document.querySelector('input[name="_token"]')?.value 
                      || '';

        try {
            // 1. Gọi Auth API
            let response = await fetch('/api/auth', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    mode: currentMode, 
                    name: name,
                    email: email,
                    password: password
                })
            });

            if (response.status === 419) throw new Error('Hết phiên làm việc (CSRF). Vui lòng nhấn F5!');
            if (!response.ok) throw new Error(`Lỗi máy chủ (${response.status})`);

            let data = await response.json();

            if (data.success) {
                let metaAuth = document.querySelector('meta[name="user-logged-in"]');
                if (metaAuth) metaAuth.setAttribute('content', 'true');
                
                closeAuthModal();

                // 2. GÁN THIỆP CHỜ VÀO TÀI KHOẢN VỪA ĐĂNG NHẬP (NẾU CÓ)
                const pendingCardId = localStorage.getItem('pending_card_id');
                if (pendingCardId) {
                    await fetch('/api/claim-pending-card', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ card_id: pendingCardId })
                    }).catch(err => console.error("Lỗi claim thiệp:", err));

                    localStorage.removeItem('pending_card_id');
                }

                // 3. Thông báo thành công
       Swal.fire({
    icon: 'success',
    title: 'Đăng nhập thành công!',
    timer: 1200,
    showConfirmButton: false
}).then(() => {

    if (data.redirect) {
        window.location.href = data.redirect;
    } else {
        window.location.reload();
    }

});

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại!',
                    text: data.message || 'Sai thông tin đăng nhập',
                    confirmButtonColor: '#ec4899'
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'warning',
                title: 'Lỗi',
                text: error.message,
                confirmButtonColor: '#ec4899'
            });
        }
    }

    // ==========================================================================
    // 4. ĐÓNG MỞ CÂU HỎI THƯỜNG GẶP (FAQ)
    // ==========================================================================
    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const faqItem = button.parentElement;
            const content = button.nextElementSibling;
            const icon = button.querySelector('i');

            if (!content || !icon) return;

            document.querySelectorAll('.faq-item').forEach(item => {
                if (item !== faqItem) {
                    item.classList.remove('border-pink-500/50', 'bg-white/10');
                    const otherContent = item.querySelector('.faq-content');
                    const otherIcon = item.querySelector('i');
                    if (otherContent) otherContent.style.maxHeight = null;
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                }
            });

            if (content.style.maxHeight && content.style.maxHeight !== '0px') {
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

    // ==========================================================================
    // 5. BANNER CHUYỂN ẢNH NỀN HERO BANNER
    // ==========================================================================
    const weddingImages = [
        "https://soheewedding.com/wp-content/uploads/2024/11/462762352_122165694566254080_8803890886102325504_n-min-1.jpg", 
        "https://soheewedding.com/wp-content/uploads/2024/11/465777166_122169990530254080_4176896853385219856_n-min-1-1800x1200.jpg",         
        "https://alohastudio.vn/wp-content/uploads/2024/05/ngoai-canh-sai-gon-5.jpg", 
        "https://soheewedding.com/wp-content/uploads/2026/02/619960705_122263468652254080_9025865039419060986_n.jpg", 
        "https://soheewedding.com/wp-content/uploads/2026/03/633245759_122266625954254080_7415266727982912241_n.jpg" 
    ];
    let currentImageIndex = 0;

    window.nextWeddingImage = function(event) {
        if (event) {
            event.stopPropagation(); 
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(() => { nextWeddingImage(null); }, 5000);
        }
        
        const bgPhotoDiv = document.getElementById('bg-photo');
        if (bgPhotoDiv) {
            currentImageIndex = (currentImageIndex + 1) % weddingImages.length;
            bgPhotoDiv.style.backgroundImage = `url('${weddingImages[currentImageIndex]}')`;
        }
    }

    let autoSlideInterval = setInterval(() => {
        nextWeddingImage(null);
    }, 5000);
});
document.addEventListener("DOMContentLoaded", function () {
    // Lấy tham số 'action' trên đường dẫn URL (ví dụ: /trang-chu?action=register)
    const urlParams = new URLSearchParams(window.location.search);
    const action = urlParams.get('action');

    // Nếu có tham số action (login hoặc register), tự động bật Modal
    if (action === 'login' || action === 'register') {
        // Kiểm tra hàm bật Modal của bạn (thường là openAuthModal hoặc tự bỏ class d-none)
        if (typeof openAuthModal === 'function') {
            openAuthModal(action);
        } else {
            // Trường hợp dùng Bootstrap Modal thông thường:
            const authModal = document.getElementById('auth-modal'); // Sửa đúng ID modal của bạn
            if (authModal) {
                authModal.classList.remove('d-none');
                authModal.classList.add('d-flex');
            }
        }
    }
});