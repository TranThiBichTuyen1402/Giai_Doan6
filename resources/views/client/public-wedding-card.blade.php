<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thiệp Cưới - {{ $card->groom_name ?? 'Chú Rể' }} & {{ $card->bride_name ?? 'Cô Dâu' }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Playfair+Display:ital,wght@0,700;0,900;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <style>
        :root {
            --primary-rose: #e11d48;
            --accent-gold: #f59e0b;
            --dark-slate: #0f172a;
        }
        body {
            background-color: var(--dark-slate);
            font-family: 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }
        #particle-canvas {
            position: fixed; top: 0; left: 0;
            width: 100vw; height: 100vh;
            pointer-events: none; z-index: 2;
        }
        .music-toggle-btn {
            position: fixed; bottom: 25px; right: 25px;
            z-index: 999; width: 50px; height: 50px;
            border-radius: 50%; background: var(--primary-rose);
            color: white; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 15px rgba(225, 29, 72, 0.5); cursor: pointer; border: 2px solid white;
        }
        .music-spinning { animation: spin 4s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
    </style>
    @stack('styles')
</head>
<body>

<canvas id="particle-canvas"></canvas>

@php
    $bgMusic = !empty($card->bg_music)
        ? asset('storage/' . ltrim($card->bg_music, '/'))
        : null;
@endphp

@if($bgMusic)
    <div class="music-toggle-btn music-spinning" id="music-control-btn" title="Bật/Tắt Nhạc">
        <i class="bi bi-disc fs-4"></i>
    </div>
    <audio id="bg-audio" src="{{ $bgMusic }}" loop></audio>
@endif

{{-- NƠI GIAO DIỆN CỦA MẪU 1, MẪU 2, MẪU 3 SẼ ĐƯỢC HIỂN THỊ --}}
@yield('content')

<script>
    // 1. Hiệu Ứng Hạt Kim Tuyến Chung
    const canvas = document.getElementById('particle-canvas');
    const ctx = canvas.getContext('2d');
    let width = canvas.width = window.innerWidth;
    let height = canvas.height = window.innerHeight;

    window.addEventListener('resize', () => {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    });

    class Particle {
        constructor() { this.reset(); }
        reset() {
            this.x = Math.random() * width;
            this.y = height + Math.random() * 50;
            this.size = Math.random() * 3 + 1;
            this.speedY = Math.random() * 1.2 + 0.3;
            this.speedX = Math.sin(Math.random() * Math.PI) * 0.5;
            this.opacity = Math.random() * 0.7 + 0.3;
            this.color = Math.random() > 0.4 ? '#fbbf24' : '#f43f5e';
        }
        update() {
            this.y -= this.speedY;
            this.x += this.speedX;
            if (this.y < -10) this.reset();
        }
        draw() {
            ctx.save();
            ctx.globalAlpha = this.opacity;
            ctx.fillStyle = this.color;
            ctx.shadowBlur = 8;
            ctx.shadowColor = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }
    }

    const particles = Array.from({ length: 45 }, () => new Particle());
    function animateParticles() {
        ctx.clearRect(0, 0, width, height);
        particles.forEach(p => { p.update(); p.draw(); });
        requestAnimationFrame(animateParticles);
    }
    animateParticles();

    // 2. Control Nhạc Nền Chung
    const musicBtn = document.getElementById('music-control-btn');
    const bgAudio = document.getElementById('bg-audio');
    if (musicBtn && bgAudio) {
        let isPlaying = false;
        musicBtn.addEventListener('click', () => {
            if (isPlaying) {
                bgAudio.pause();
                musicBtn.classList.remove('music-spinning');
            } else {
                bgAudio.play();
                musicBtn.classList.add('music-spinning');
            }
            isPlaying = !isPlaying;
        });
    }
     window.WEDDING_DATE = "{{ $card->wedding_date ?? '2026-12-12' }}";
    window.IS_DEMO = {{ !empty($isDemo) ? 'true' : 'false' }};
    window.BUILDER_URL = "{{ route('card.builder', $card->id ?? 1) }}";
    
  // cây but chỉnh sửa sẽ chỉ hiển thị khi ở chế độ editor, không hiển thị cho khách xem thiệp
    // AUTOMATIC STICKY BAR FOR LIVE DEMO MODE
    @if(!empty($isDemo))
    if (window.self === window.top) {
        document.addEventListener("DOMContentLoaded", function () {
            const stickyBarHTML = `
                <div class="demo-sticky-bar" style="position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(12px); border-top: 1px solid rgba(245, 158, 11, 0.3); padding: 12px 20px; z-index: 999999; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 -5px 25px rgba(0, 0, 0, 0.5);">
                    <div class="text-white small">
                        <span class="text-white-50 d-none d-sm-inline">Đang xem demo:</span>
                        <strong style="color: var(--accent-gold, #f59e0b);" class="ms-1">Mẫu Thiệp Luxury Gold</strong>
                    </div>
                    <a href="{{ route('card.builder', $card->id ?? 1) }}" 
                       class="btn btn-sm btn-danger fw-bold rounded-pill px-3 py-2 text-white text-decoration-none shadow-sm"
                       style="font-size: 0.8rem; background: linear-gradient(135deg, #f43f5e, #e11d48); border: none;">
                        <i class="bi bi-magic me-1"></i> Dùng mẫu này ngay
                    </a>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', stickyBarHTML);
        });
    }
    @endif
   
document.getElementById('btnSearchSeat').addEventListener('click', function() {
    let name = document.getElementById('guestNameInput').value;
    let cardId = "{{ $card->id }}";
    let resultDiv = document.getElementById('searchSeatResult');

    if (!name.trim()) {
        resultDiv.innerHTML = '<div class="alert alert-warning">Vui lòng nhập tên của bạn!</div>';
        return;
    }

    resultDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"></div></div>';

    fetch(`/api/search-table?card_id=${cardId}&keyword=${encodeURIComponent(name)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let html = '<div class="alert alert-success"><strong>Tìm thấy thông tin:</strong><ul class="mb-0 mt-2 pl-3">';
                data.guests.forEach(guest => {
                    html += `<li><strong>${guest.guest_name}</strong>: ${guest.table_name}`;
                    if (guest.plus_ones > 0) html += ` (Đi kèm: ${guest.plus_ones} người)`;
                    if (guest.note) html += `<br><small class="text-muted">Ghi chú: ${guest.note}</small>`;
                    html += `</li>`;
                });
                html += '</ul></div>';
                resultDiv.innerHTML = html;
            } else {
                resultDiv.innerHTML = `<div class="alert alert-info">${data.message}</div>`;
            }
        })
        .catch(error => {
            resultDiv.innerHTML = '<div class="alert alert-danger">Đã có lỗi xảy ra, vui lòng thử lại sau!</div>';
        });
});
function findSeat(e) {
    if(e) e.preventDefault();
    
    let nameInput = document.getElementById('seatNameInput').value;
    let cardId = "{{ $card->id ?? '' }}";
    let resultDiv = document.getElementById('seatResultArea');

    if (!nameInput.trim()) {
        resultDiv.innerHTML = '<div class="alert alert-warning py-2 mb-0 text-dark small">Vui lòng nhập tên của bạn!</div>';
        return;
    }

    resultDiv.innerHTML = '<div class="text-warning small my-2"><span class="spinner-border spinner-border-sm me-1"></span> Đang tra cứu...</div>';

    fetch(`/search-table?card_id=${cardId}&keyword=${encodeURIComponent(nameInput)}`)
        .then(res => {
            if (!res.ok) throw new Error('HTTP status ' + res.status);
            return res.json();
        })
        .then(data => {
            if (data.success) {
                let html = '';
                data.guests.forEach(guest => {
                    html += `
                        <div class="p-3 rounded my-2 text-center" style="background: rgba(255, 255, 255, 0.15); border: 1px solid #f59e0b;">
                            <div class="fw-bold fs-4 text-warning">${guest.table_name}</div>
                            <div class="text-white small">Khách mời: <strong>${guest.guest_name}</strong></div>
                            ${guest.plus_ones > 0 ? `<div class="text-info small">+${guest.plus_ones} người đi cùng</div>` : ''}
                            ${guest.note ? `<div class="text-white-50 small fst-italic mt-1">${guest.note}</div>` : ''}
                        </div>
                    `;
                });
                resultDiv.innerHTML = html;
            } else {
                resultDiv.innerHTML = `<div class="alert alert-info py-2 my-2 text-dark small">${data.message}</div>`;
            }
        })
        .catch(err => {
            console.error('Lỗi API:', err);
            resultDiv.innerHTML = '<div class="alert alert-danger py-2 my-2 text-dark small">Lỗi kết nối tra cứu! (Kiểm tra Console F12)</div>';
        });
}
// Biến lưu link map hiện tại
window.currentMapUrl = "{{ !empty($card->map_link) ? $card->map_link : '' }}";

// Hàm bắt sự kiện click mở Google Maps chuẩn 100%
function openGoogleMapDirect() {
    let mapUrl = window.currentMapUrl;
    
    // Nếu chưa có link map, tự lấy tên địa điểm đang hiển thị để tìm
    if (!mapUrl || mapUrl === '#' || mapUrl.trim() === '') {
        const locText = document.querySelector('[data-field="wedding_location"]')?.innerText || '';
        if (locText.trim()) {
            const cleanLoc = locText.split(',').slice(0, 3).join(',');
            mapUrl = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(cleanLoc); 
        } 
    } 
 
    if (mapUrl && mapUrl !== '#') { 
        window.open(mapUrl, '_blank'); 
    } else { 
        alert('Vui lòng nhập địa điểm lễ cưới ở bảng bên trái!'); 
    } 
} 
 
// Cập nhật biến currentMapUrl mỗi khi bên Builder gửi dữ liệu sang 
window.addEventListener('message', function (e) { 
    if (!e.data || e.data.type !== 'UPDATE_CARD_FIELD') return; 
 
    if (e.data.field === 'map_link') { 
        window.currentMapUrl = e.data.value; 
    } 
}); 
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/wedding-builder.js') }}"></script>

@stack('scripts')
</body>
</html>