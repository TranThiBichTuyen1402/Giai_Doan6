
    // Countdown
    function updateCountdown() {
        const dateElement = document.querySelector('[data-field="wedding_date"]');
        if (!dateElement) return;

        let dateText = dateElement.innerText.trim();
        // Xử lý chuyển đổi định dạng ngày tiếng Việt (VD: "12 Tháng 12, 2026")
        let parsedText = dateText.replace(/tháng/gi, '-').replace(/,/g, '');
        let targetDate = new Date(parsedText).getTime();

        if (isNaN(targetDate)) {
            targetDate = new Date("{{ $card->wedding_date ?? '2026-12-12' }}").getTime();
        }

        const now = new Date().getTime();
        const diff = targetDate - now;

        const countdown = document.querySelector('.countdown-flex');
        if (!countdown) return;

        if (diff > 0) {
            document.getElementById('cd-days').innerText = Math.floor(diff / (1000 * 60 * 60 * 24));
            document.getElementById('cd-hours').innerText = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            document.getElementById('cd-mins').innerText = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            document.getElementById('cd-secs').innerText = Math.floor((diff % (1000 * 60)) / 1000);
        } else {
            countdown.innerHTML = "<h5 class='text-warning'>Đã diễn ra 🎉</h5>";
        }
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // Voice Invite & Audio Player
    let player = null;
    function playVoice(src) {
        if (player) { player.pause(); }
        player = new Audio(src);
        player.play().catch(() => { alert("Không thể phát âm thanh!"); });
    }

    // RSVP Form
   document.getElementById('rsvpForm')?.addEventListener('submit', async function(e) {

    e.preventDefault();

    const form = this;
    const button = form.querySelector('button[type="submit"]');

    button.disabled = true;
    button.innerHTML = 'Đang gửi...';

    try {

        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector(
                    'meta[name="csrf-token"]'
                )?.getAttribute('content'),

                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new FormData(form)
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message || 'Không thể gửi xác nhận.'
            );
        }

        alert(data.message);

        form.reset();

        const modalEl = document.getElementById('rsvpModal');
        const modal = bootstrap.Modal.getInstance(modalEl);

        if (modal) {
            modal.hide();
        }

    } catch (error) {

        console.error('RSVP ERROR:', error);

        alert(
            error.message ||
            'Có lỗi xảy ra. Vui lòng thử lại.'
        );

    } finally {

        button.disabled = false;

        button.innerHTML =
            '<i class="bi bi-envelope-check-fill me-1"></i> Gửi Xác Nhận';
    }

});

    // LẮNG NGHE DỮ LIỆU TỪ TRANG BUILDER BẮN SANG REAL-TIME
    window.addEventListener('message', function (event) {
        if (event.data && event.data.type === 'UPDATE_CARD_FIELD') {
            const field = event.data.field;
            const value = event.data.value;

            // 1. Cập nhật Text
            const targetElements = document.querySelectorAll(`[data-field="${field}"]`);
            targetElements.forEach(el => {
                if (value !== undefined && value.trim() !== '') {
                    el.innerText = value;
                }
            });

            // 2. Cập nhật Ảnh
            if (field === 'groom_avatar' && value) {
                const img = document.getElementById('preview_groom_avatar');
                if (img) img.src = value;
            }
            if (field === 'bride_avatar' && value) {
                const img = document.getElementById('preview_bride_avatar');
                if (img) img.src = value;
            }
            if (field === 'cover_img' && value) {
                const bg = document.getElementById('page-bg');
                if (bg) bg.style.backgroundImage = `linear-gradient(to bottom, rgba(15,23,42,.8), rgba(15,23,42,.93)), url(${value})`;
            }
        }
    });

    // Moment Photo Upload
    function uploadMoment(){
        const fileInput = document.getElementById("momentImage");
        if(!fileInput || !fileInput.files[0]){
            alert("Vui lòng chọn ảnh.");
            return;
        }
        alert("Ảnh đã được chọn.\nSau này sẽ upload lên server.");
    }

    // Tra cứu bàn tiệc
    function findSeat(){
        let name = document.getElementById("seatName").value.trim();
        if(!name){
            alert("Vui lòng nhập tên khách.");
            return;
        }
        document.getElementById("seatResult").innerHTML = `Bàn số: 12 <br> Khu A - Cạnh sân khấu`;
    }

    // Gửi lời chúc (Đã sửa lỗi trùng lặp hàm & thiếu dữ liệu)
    function sendWish(){
        let name = document.getElementById("wishName")?.value.trim() || 'Ẩn danh';
        let msg = document.getElementById("wishMessage")?.value.trim() || '';

        if(!msg) {
            alert("Vui lòng nhập nội dung lời chúc!");
            return;
        }
        alert(`Đã gửi lời chúc thành công!\nTừ: ${name}`);
        if(document.getElementById("wishMessage")) document.getElementById("wishMessage").value = '';
    }

    function recordVoice(){
        alert("Chức năng ghi âm sẽ được bổ sung ở backend.");
    }
  

    /* ============================================================
       EDITOR: BẤM CÂY BÚT TRÊN THIỆP -> CUỘN SANG FORM BÊN TRÁI
       ============================================================ */
    document.addEventListener('DOMContentLoaded', function () {
        const isEditor = document.body.classList.contains('editor-mode');
        if (!isEditor) return;

        const fieldElements = document.querySelectorAll('[data-field]');
        if (!fieldElements.length) return;

        /* Thông báo nhỏ cho người dùng */
        const toast = document.createElement('div');
        toast.className = 'editor-edit-toast';
        // toast.innerHTML = '<i class="bi bi-pencil-fill me-1"></i> Đang mở phần chỉnh sửa...';
        document.body.appendChild(toast);

        let toastTimer = null;

        function showToast() {
            clearTimeout(toastTimer);
            toast.classList.add('show');
            toastTimer = setTimeout(function () {
                toast.classList.remove('show');
            }, 1400);
        }

        /*
         * Những field này là block lớn. Cây bút nằm cuối dòng để không
         * phá bố cục thiệp. Các field còn lại dùng inline-flex.
         */
        const blockFields = new Set([
            'invitation_msg',
            'groom_bio',
            'bride_bio',
            'wedding_location',
            'thank_msg'
        ]);

        fieldElements.forEach(function (fieldEl) {
            // Không tạo bút 2 lần nếu script được load lại
            if (fieldEl.closest('.editor-field-wrap')) return;

            const fieldName = fieldEl.dataset.field;
            if (!fieldName) return;

            const wrapper = document.createElement('span');
            wrapper.className = 'editor-field-wrap';
            if (blockFields.has(fieldName)) {
                wrapper.classList.add('block-field');
            }

            // Giữ nguyên vị trí của phần tử trong layout hiện tại
            fieldEl.parentNode.insertBefore(wrapper, fieldEl);
            wrapper.appendChild(fieldEl);

            const pencil = document.createElement('button');
            pencil.type = 'button';
            pencil.className = 'editor-pencil';
            pencil.title = 'Chỉnh sửa phần này';
            pencil.setAttribute('aria-label', 'Chỉnh sửa ' + fieldName);
            pencil.innerHTML = '<i class="bi bi-pencil-fill"></i>';

            pencil.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                showToast();

                /*
                 * Builder.blade.php đã có listener cho FOCUS_EDITOR_FIELD.
                 * Message này sẽ yêu cầu builder cuộn đúng input bên trái
                 * và focus vào ô nhập.
                 */
                window.parent.postMessage({
                    type: 'FOCUS_EDITOR_FIELD',
                    field: fieldName
                }, '*');
            });

            wrapper.appendChild(pencil);
        });

        /*
         * Nếu người dùng bấm trực tiếp vào nội dung thay vì cây bút,
         * vẫn chuyển sang form bên trái. Không contenteditable nữa để
         * tránh người dùng vô tình sửa nội dung trong iframe.
         */
        document.querySelectorAll('.editor-field-wrap > [data-field]').forEach(function (fieldEl) {
            fieldEl.addEventListener('click', function (e) {
                if (e.target.closest('.editor-pencil')) return;

                e.preventDefault();
                e.stopPropagation();

                showToast();
                window.parent.postMessage({
                    type: 'FOCUS_EDITOR_FIELD',
                    field: this.dataset.field
                }, '*');
            });
        });
    });