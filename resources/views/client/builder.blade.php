<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thiết Kế Thiệp Cưới Direct Preview - Dark Magazine Style</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&family=Playfair+Display:ital,wght@0,600;0,800;1,400&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-logged-in" content="{{ Auth::check() ? 'true' : 'false' }}">

    <style>
        body { background-color: #f8f9fa; font-family: 'Quicksand', sans-serif; }
        .editor-sidebar { height: calc(100vh - 60px); overflow-y: auto; background: #ffffff; border-right: 1px solid #e9ecef; }
        .preview-stage { height: calc(100vh - 60px); overflow-y: auto; background: #090d16; display: flex; justify-content: center; align-items: flex-start; padding: 30px 15px; }
        .phone-mockup { width: 100%; max-width: 410px; height: 760px; background: #0f172a; border-radius: 36px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.7); border: 10px solid #2b2b2b; overflow: hidden; position: relative; color: #ffffff; }
        .btn-pink { background: #e11d48; color: #fff; border: none; font-weight: 600; }
        .btn-pink:hover { background: #be123c; color: #fff; }
        
        /* CSS Badge VIP & Feature Lock */
        .badge-vip { background: linear-gradient(45deg, #f59e0b, #d97706); color: #fff; font-size: 0.7rem; padding: 3px 8px; border-radius: 12px; font-weight: bold; }
        .vip-feature-wrapper { position: relative; }
        .vip-lock-overlay { 
            position: absolute; 
            top: 0; left: 0; right: 0; bottom: 0; 
            background: rgba(255, 255, 255, 0.65); 
            backdrop-filter: blur(2px); 
            z-index: 10; 
            cursor: pointer; 
            border-radius: 8px; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            justify-content: center; 
            transition: all 0.2s ease;
        }
        .vip-lock-overlay:hover { background: rgba(255, 255, 255, 0.8); }
    </style>
</head>
<body>

    @php
        $isVip = $card->is_vip ?? false; 
    @endphp

    <header class="bg-white border-bottom py-2 px-4 d-flex justify-content-between align-items-center sticky-top" style="height: 60px;">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-heart-fill text-danger fs-4"></i>
            <h6 class="mb-0 fw-bold">Tạo Thiệp Cưới Trực Tiếp</h6>
            @if($isVip)
                <span class="badge bg-warning text-dark rounded-pill ms-2 fw-bold" id="cardStatusBadge">👑 Đã Nâng VIP</span>
            @else
                <span class="badge bg-secondary rounded-pill ms-2" id="cardStatusBadge">Gói Free (Miễn phí)</span>
            @endif
        </div>
        <div class="d-flex gap-2">
            @if(!$isVip)
                <button type="button" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#vipUpgradeModal">
                    👑 Nâng Cấp VIP (99k)
                </button>
            @endif
            <button id="btnSaveCard" type="button" class="btn btn-pink btn-sm rounded-pill px-4">
    <i class="bi bi-floppy me-1"></i>
    {{ !empty($card->id) ? 'Lưu thay đổi' : 'Lưu & Tạo thiệp' }}
</button>
        </div>
    </header>

    <div class="container-fluid p-0">
        <div class="row g-0">
            
            <div class="col-12 col-lg-5 col-xl-4 editor-sidebar p-4">
                <h5 class="fw-bold mb-2 text-danger"><i class="bi bi-pencil-square me-2"></i>Nhập Thông Tin Thiệp</h5>
                <p class="text-muted small mb-4">Các thông tin từ mẫu đã được điền sẵn, hãy chỉnh sửa theo ý bạn!</p>

                <form id="builderForm" enctype="multipart/form-data">
    @csrf

    <input type="hidden"
           name="template_id"
           value="{{ $templateId ?? request()->route('template_id') ?? 1 }}">

    <input type="hidden"
           name="card_id"
           value="{{ $card->id ?? '' }}">

    <input type="hidden"
           name="slug"
           value="{{ $card->slug ?? '' }}">
                    
                    <div class="card p-3 mb-3 border-0 bg-light rounded-3">
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-person-fill text-primary me-2"></i>Thông Tin Chú Rể & Nhà Trai</h6>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Họ và Tên Chú Rể</label>
                    <input
type="text"
id="input_groom_name"
name="groom_name"
class="form-control form-control-sm"
value="{{ old('groom_name', $card->groom_name) }}">                       
                    </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Số Điện Thoại Chú Rể</label>
                            <input type="text" id="input_groom_phone" name="groom_phone" class="form-control form-control-sm" value="{{ old('groom_phone', $card->groom_phone) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Thân Phụ (Bố Chú Rể)</label>
                            <input type="text" id="input_groom_father" name="groom_father" class="form-control form-control-sm" value="{{ old('groom_father', $card->groom_father) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Thân Mẫu (Mẹ Chú Rể)</label>
                            <input type="text" id="input_groom_mother" name="groom_mother" class="form-control form-control-sm" value="{{ old('groom_mother', $card->groom_mother) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Ảnh Chú Rể</label>
                            <input type="file" id="input_groom_avatar" name="groom_avatar" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Giới Thiệu Chú Rể</label>
<textarea
    name="groom_bio"
    class="form-control form-control-sm"
    rows="2">{{ old('groom_bio', $card->groom_bio) }}</textarea>
 </div>
                    </div>

                    <div class="card p-3 mb-3 border-0 bg-light rounded-3">
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-person-heart text-danger me-2"></i>Thông Tin Cô Dâu & Nhà Gái</h6>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Họ và Tên Cô Dâu</label>
                            <input type="text" id="input_bride_name" name="bride_name" class="form-control form-control-sm" value="{{ old('bride_name', $card->bride_name) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Số Điện Thoại Cô Dâu</label>
                            <input type="text" id="input_bride_phone" name="bride_phone" class="form-control form-control-sm" value="{{ old('bride_phone', $card->bride_phone) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Thân Phụ (Bố Cô Dâu)</label>
                            <input type="text" id="input_bride_father" name="bride_father" class="form-control form-control-sm" value="{{ old('bride_father', $card->bride_father) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Thân Mẫu (Mẹ Cô Dâu)</label>
                            <input type="text" id="input_bride_mother" name="bride_mother" class="form-control form-control-sm" value="{{ old('bride_mother', $card->bride_mother) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Ảnh Cô Dâu</label>
                            <input type="file" id="input_bride_avatar" name="bride_avatar" class="form-control form-control-sm" accept="image/*">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Giới Thiệu Cô Dâu</label>
                        <textarea
                        id="input_bride_bio"
                        name="bride_bio"
                        class="form-control form-control-sm"
                        rows="2">{{ old('bride_bio', $card->bride_bio) }}</textarea>                       
 </div>
                    </div>

                    <div class="card p-3 mb-3 border-0 bg-light rounded-3">
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-calendar-event me-2"></i>Thông Tin Lễ Cưới & Tiệc Cưới</h6>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Ngày Cưới Dương Lịch</label>
                            <input type="date" id="input_wedding_date" name="wedding_date" class="form-control form-control-sm" value="{{ old('wedding_date', $card->wedding_date) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Âm Lịch</label>
                            <input type="text" id="input_lunar_date" name="lunar_date" class="form-control form-control-sm" value="{{ old('lunar_date', $card->lunar_date) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Giờ Tiệc Cưới</label>
                            <input type="text" id="input_wedding_time" name="wedding_time" class="form-control form-control-sm" value="{{ old('wedding_time', $card->wedding_time) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Địa Điểm / Sảnh Tiệc</label>
                            <input type="text" id="input_wedding_location" name="wedding_location" class="form-control form-control-sm" value="{{ old('wedding_location', $card->wedding_location) }}">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Google Maps</label>
                            <input type="url" id="input_map_link" name="map_link" class="form-control form-control-sm" value="{{ old('map_link', $card->map_link) }}">
                        </div>
                    </div>

                    <div class="card p-3 mb-3 border-0 bg-light rounded-3">
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-images me-2"></i>Nội Dung Thiệp & Album</h6>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Lời Mời Từ Cặp Đôi</label>
<textarea
    name="invitation_msg"
    class="form-control form-control-sm"
    rows="3">{{ old('invitation_msg', $card->invitation_msg) }}</textarea>
</div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Upload Ảnh Bìa Thiệp</label>
                            <input type="file" id="input_cover_img" name="cover_img" class="form-control form-control-sm" accept="image/*">
                        </div>
                    </div>

                    <div class="card p-3 mb-3 border-0 bg-light rounded-3 vip-feature-wrapper">
                        @if(!$isVip)
                            <div class="vip-lock-overlay" data-bs-toggle="modal" data-bs-target="#vipUpgradeModal">
                                <i class="bi bi-lock-fill text-warning fs-3 mb-1"></i>
                                <span class="fw-bold text-dark small">Mở khóa tính năng VietQR Mừng Cưới</span>
                                <span class="badge bg-warning text-dark mt-1">Nâng VIP 99k</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-qr-code-scan me-2"></i>Mừng Cưới & Mã VietQR</h6>
                            <span class="badge-vip">👑 Gói VIP</span>
                        </div>
                        <p class="text-muted small mb-2">Gói VIP hỗ trợ tự động quét mã QR khi mừng cưới!</p>

                        <p class="fw-bold text-primary mb-1 small">STK Chú Rể</p>
                        <div class="mb-2"><input type="text" name="groom_bank_name" class="form-control form-control-sm" placeholder="Ngân hàng" value="{{ old('groom_bank_name', $card->groom_bank_name) }}"></div>
                        <div class="mb-2"><input type="text" name="groom_bank_acc" class="form-control form-control-sm" placeholder="Số tài khoản" value="{{ old('groom_bank_acc', $card->groom_bank_acc) }}"></div>
                        <div class="mb-3"><input type="text" name="groom_bank_owner" class="form-control form-control-sm" placeholder="Chủ tài khoản" value="{{ old('groom_bank_owner', $card->groom_bank_owner) }}"></div>

                        <p class="fw-bold text-danger mb-1 small">STK Cô Dâu</p>
                        <div class="mb-2"><input type="text" name="bride_bank_name" class="form-control form-control-sm" placeholder="Ngân hàng" value="{{ old('bride_bank_name', $card->bride_bank_name) }}"></div>
                        <div class="mb-2"><input type="text" name="bride_bank_acc" class="form-control form-control-sm" placeholder="Số tài khoản" value="{{ old('bride_bank_acc', $card->bride_bank_acc) }}"></div>
                        <div class="mb-2"><input type="text" name="bride_bank_owner" class="form-control form-control-sm" placeholder="Chủ tài khoản" value="{{ old('bride_bank_owner', $card->bride_bank_owner) }}"></div>
                    </div>

                    <div class="card p-3 mb-3 border-0 bg-light rounded-3 vip-feature-wrapper">
                        @if(!$isVip)
                            <div class="vip-lock-overlay" data-bs-toggle="modal" data-bs-target="#vipUpgradeModal">
                                <i class="bi bi-lock-fill text-warning fs-3 mb-1"></i>
                                <span class="fw-bold text-dark small">Mở khóa Upload Nhạc & Voice Lời Mời</span>
                                <span class="badge bg-warning text-dark mt-1">Nâng VIP 99k</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-music-note-beamed me-2"></i>Nhạc Nền & Voice Lời Mời</h6>
                            <span class="badge-vip">👑 Gói VIP</span>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Upload Nhạc Nền Riêng (.mp3)</label>
                            <input type="file" name="custom_music" class="form-control form-control-sm" accept="audio/*">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold">Upload Voice Lời Mời (.mp3)</label>
                            <input type="file" name="custom_voice" class="form-control form-control-sm" accept="audio/*">
                        </div>
                    </div>

                    <div class="card p-3 mb-3 border-0 bg-light rounded-3">
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-chat-quote me-2"></i>Lời Cảm Ơn</h6>
                        <div class="mb-2">
<textarea
name="thank_msg"
class="form-control form-control-sm"
rows="2">{{ old('thank_msg', $card->thank_msg) }}</textarea>
                        </div>
                    </div>

                </form>
            </div>

            <div class="col-12 col-lg-7 col-xl-8 preview-stage">
               <div id="previewLoading" class="text-white text-center py-5">
    Đang tải Preview...
</div>
                    @php
                        $currentTemplate = $templateId ?? request()->route('template_id') ?? 1;
                    @endphp
<iframe id="previewFrame"
    src="{{ route('wedding.sample', ['template' => $currentTemplate, 'editor' => 1]) }}"
    class="w-100 h-100 border-0"
    style="border-radius: 26px;">
</iframe>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="vipUpgradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header border-0 bg-dark text-white p-4 rounded-top-4">
                    <h5 class="modal-title fw-bold"><i class="bi bi-gem text-warning me-2"></i>Nâng Cấp VIP - Trải Nghiệm Thiệp Trọn Vẹn</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-start">Tính năng</th>
                                    <th>🆓 Miễn phí (Free)</th>
                                    <th class="bg-warning-subtle text-dark">👑 VIP (99.000đ)</th>
                                </tr>
                            </thead>
                            <tbody class="small">
                                <tr>
                                    <td class="text-start fw-semibold">Kho Mẫu Thiệp</td>
                                    <td>Cơ bản (Basic)</td>
                                    <td class="bg-warning-subtle fw-bold text-success">Mở toàn bộ Premium/Luxury</td>
                                </tr>
                                <tr>
                                    <td class="text-start fw-semibold">Xóa Watermark Bản Quyền</td>
                                    <td>❌ Dính Watermark</td>
                                    <td class="bg-warning-subtle fw-bold text-success">✅ Xóa hoàn toàn</td>
                                </tr>
                                <tr>
                                    <td class="text-start fw-semibold">Mã VietQR Chuyển Khoản</td>
                                    <td>Hiện STK chữ</td>
                                    <td class="bg-warning-subtle fw-bold text-success">✅ Tự sinh VietQR thông minh</td>
                                </tr>
                                <tr>
                                    <td class="text-start fw-semibold">Nhạc Nền & Voice Lời Mời</td>
                                    <td>Nhạc mặc định</td>
                                    <td class="bg-warning-subtle fw-bold text-success">✅ Đổi nhạc MP3 & Upload Voice</td>
                                </tr>
                                <tr>
                                    <td class="text-start fw-semibold">Thời Gian Chỉnh Sửa</td>
                                    <td>Trong 24 giờ</td>
                                    <td class="bg-warning-subtle fw-bold text-success">✅ Thoải mái chỉnh sửa trọn đời</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <button type="button" id="btnConfirmPayVip" class="btn btn-warning btn-lg rounded-pill fw-bold px-5 py-2 shadow">
                            💳 Thanh Toán Nâng Cấp VIP (99.000đ)
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="vietqrPaymentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-header bg-warning text-dark border-0 p-3 rounded-top-4">
                    <h6 class="modal-title fw-bold"><i class="bi bi-qr-code-scan me-2"></i>Thanh Toán Nâng Cấp VIP (99.000đ)</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <p class="text-muted small mb-2">Mở App Ngân hàng hoặc Ví điện tử bất kỳ để quét mã QR bên dưới:</p>
                    
                    <div class="position-relative d-inline-block p-2 bg-light border rounded-3 mb-3">
                        <img id="vietqrImg" src="" alt="Mã QR VietQR" class="img-fluid rounded" style="max-width: 250px; min-height: 250px;">
                    </div>

                    <div class="bg-light p-3 rounded-3 text-start small mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Ngân hàng:</span>
                            <strong class="text-dark">{{ config('services.vietqr.bank_id', 'MB') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Số tài khoản:</span>
                            <strong class="text-primary fs-6" id="displayBankAcc">{{ config('services.vietqr.account_no') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Chủ tài khoản:</span>
                            <strong class="text-dark">{{ config('services.vietqr.account_name') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Số tiền:</span>
                            <strong class="text-danger fs-6">99.000 VNĐ</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Nội dung CK:</span>
                            <strong class="text-warning-emphasis bg-warning bg-opacity-25 px-2 rounded" id="displayMemo">VIP ...</strong>
                        </div>
                    </div>

                    <button type="button" id="btnCheckPaymentStatus" class="btn btn-success w-100 rounded-pill py-2 fw-bold">
                        <i class="bi bi-check2-circle me-1"></i> Tôi Đã Chuyển Khoản Thành Công
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const previewFrame = document.getElementById('previewFrame');
        // 1. LIVE PREVIEW INPUT TEXT
       const builderForm = document.getElementById('builderForm');

builderForm.addEventListener('submit', function(e){
    e.preventDefault();
});
// ===============================
// GIỮ DỮ LIỆU BUILDER KHI MỞ TAB XEM THIỆP
// ===============================
// ===============================
// GIỮ DỮ LIỆU BUILDER KHI MỞ TAB XEM THIỆP
// ===============================
function saveBuilderDraft() {
    const data = {};
    builderForm.querySelectorAll('input, textarea, select').forEach(input => {
        if (input.type === 'file') return;
        if (input.name) {
            data[input.name] = input.value;
        }
    });
    sessionStorage.setItem('wedding_builder_draft', JSON.stringify(data));
}

function restoreBuilderDraft() {
    // CHỈ KHÔI PHỤC KHI ĐANG CHỈNH SỬA THIỆP CŨ (Có card_id)
    // Nếu tạo thiệp mới từ mẫu -> Xóa nháp cũ để lấy dữ liệu chuẩn của Controller
    const urlParams = new URLSearchParams(window.location.search);
    const cardIdInput = builderForm.querySelector('input[name="card_id"]');
    
    if (!cardIdInput || !cardIdInput.value) {
        sessionStorage.removeItem('wedding_builder_draft');
        return;
    }

    const saved = sessionStorage.getItem('wedding_builder_draft');
    if (!saved) return;

    const data = JSON.parse(saved);
    Object.keys(data).forEach(name => {
        const input = builderForm.querySelector(`[name="${name}"]`);
        if (input && input.type !== 'file') {
            input.value = data[name];
        }
    });
}

builderForm.addEventListener('input', saveBuilderDraft);
builderForm.addEventListener('change', saveBuilderDraft);
restoreBuilderDraft();

// Live Preview khi gõ
builderForm.addEventListener('input', function(e){

    const input = e.target;

    if(!input.name) return;

    previewFrame.contentWindow.postMessage({
        type:'UPDATE_CARD_FIELD',
        field:input.name,
        value:input.value
    },'*');

});

window.addEventListener('message', function (event) {

    if (!event.data) return;

    if (event.data.type === 'FOCUS_EDITOR_FIELD') {

        const fieldName = event.data.field;

        const input = builderForm.querySelector(
            '[name="' + fieldName + '"]'
        );

        if (!input) {
            console.warn('Không tìm thấy input:', fieldName);
            return;
        }

        // Cuộn tới input
        input.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Focus
        setTimeout(function () {

            input.focus();

            // Nếu là text thì bôi đen nội dung
            if (
                input.tagName === 'INPUT' ||
                input.tagName === 'TEXTAREA'
            ) {
                input.select();
            }

        }, 400);

    }

});

// Load dữ liệu ban đầu
previewFrame.onload = function () {

    document.getElementById('previewLoading').style.display = 'none';

    const inputs = builderForm.querySelectorAll('[name]');

    inputs.forEach(function(input){

        previewFrame.contentWindow.postMessage({

            type:'UPDATE_CARD_FIELD',

            field:input.name,

            value:input.value

        }, '*');

    });

};


   // 2. LIVE PREVIEW UPLOAD ẢNH
let activeImageUrls = {};

// Giải phóng URL ảnh khi đóng trang
window.addEventListener('beforeunload', function () {

    Object.values(activeImageUrls).forEach(function (url) {
        URL.revokeObjectURL(url);
    });

});

function bindImageToIframe(inputId, fieldName) {

    const inputEl = document.getElementById(inputId);

    if (inputEl) {

        inputEl.addEventListener('change', function (e) {

            const file = e.target.files[0];

            if (!file) return;

            if (!file.type.startsWith('image/')) {

                Swal.fire(
                    'Sai định dạng',
                    'Chỉ được upload ảnh',
                    'error'
                );

                return;
            }

            if (file.size > 5 * 1024 * 1024) {

                Swal.fire(
                    'Ảnh quá lớn',
                    'Chỉ được tối đa 5MB',
                    'warning'
                );

                return;
            }

            if (previewFrame && previewFrame.contentWindow) {

                if (activeImageUrls[fieldName]) {
                    URL.revokeObjectURL(activeImageUrls[fieldName]);
                }

                const imgUrl = URL.createObjectURL(file);
                activeImageUrls[fieldName] = imgUrl;

                previewFrame.contentWindow.postMessage({
                    type: 'UPDATE_CARD_FIELD',
                    field: fieldName,
                    value: imgUrl,
                    isImage: true
                }, '*');

            }

        });

    }

}
        bindImageToIframe('input_cover_img', 'cover_img');
        bindImageToIframe('input_groom_avatar', 'groom_avatar');
        bindImageToIframe('input_bride_avatar', 'bride_avatar');

        // =========================================================================
        // 3. XỬ LÝ NÚT LƯU THIỆP (CÁCH 1: GIỮ CHÂN KHÁCH VỚI POPUP ĐĂNG NHẬP)
        // =========================================================================
        const btnSave = document.getElementById('btnSaveCard');

        if (btnSave && builderForm) {
            btnSave.addEventListener('click', function(e) {
                e.preventDefault();

                // Đổi trạng thái Nút
                btnSave.disabled = true;
                btnSave.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Đang lưu...';

                let formData = new FormData(builderForm);
                let csrfMeta = document.querySelector('meta[name="csrf-token"]');
                let csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

                fetch("{{ route('wedding.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    // Nếu gặp 401 unauthenticated từ Laravel API
                    if(response.status===422){

    return response.json().then(data=>{

        throw data;

    });

}

return response.json();
                })
                .then(data => {
                    // Trả nút về cũ
                    btnSave.disabled = false;
                    btnSave.innerHTML = '<i class="bi bi-floppy me-1"></i> Lưu & Tạo thiệp';

                    if(data.success) {
                        const finalUrl = data.card_url || data.url || data.public_url || data.redirect_url;
                        const isLoggedIn = document.querySelector('meta[name="user-logged-in"]')?.getAttribute('content') === 'true';

                        // KIỂM TRA ĐĂNG NHẬP
                        if (!isLoggedIn || data.is_guest) {
                            // 🌟 CÁCH 1: KHÁCH CHƯA ĐĂNG NHẬP -> TẠO XONG NGHỆ THUẬT VÀ HIỆN POP-UP GIỮ CHÂN!
                        // Đoạn JS hiển thị SweetAlert2 khi tạo thiệp thành công
Swal.fire({
    icon: 'success',
    title: 'Thiệp cưới đã tạo thành công! 🎉',

    html: `
        <p style="margin-bottom: 8px; font-size: 15px;">
            Thiệp của bạn đã sẵn sàng!
        </p>

        <div style="
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 15px 0;
        ">
            <input
                id="weddingLinkInput"
                type="text"
                value="${finalUrl}"
                readonly
                style="
                    flex: 1;
                    height: 42px;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    padding: 8px 10px;
                    font-size: 13px;
                    background: #f8f9fa;
                    color: #333;
                "
            >

            <button
                type="button"
                id="btnCopyWeddingLink"
                style="
                    height: 42px;
                    border: none;
                    border-radius: 8px;
                    padding: 0 14px;
                    background: #e11d48;
                    color: white;
                    font-weight: 600;
                    cursor: pointer;
                "
            >
                📋 Copy
            </button>
        </div>

        <div style="
            background: #fff3cd;
            color: #856404;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            text-align: left;
            line-height: 1.5;
        ">
            ⚠️ <b>Đăng ký / Đăng nhập</b> để lưu thiệp vào tài khoản,
            quản lý và chỉnh sửa thiệp sau này.
        </div>
        <button
    type="button"
    id="btnViewWedding"
    style="
        width: 100%;
        margin-top: 12px;
        height: 42px;
        border: 1px solid #e11d48;
        border-radius: 8px;
        background: #fff;
        color: #e11d48;
        font-weight: 600;
        cursor: pointer;
    "
>
    💌 Xem thiệp
</button>
    `,

    showCancelButton: false,
confirmButtonColor: '#e11d48',
confirmButtonText: '🔑 Đăng ký / Đăng nhập',
allowOutsideClick: false,

    didOpen: () => {

        const copyBtn = document.getElementById('btnCopyWeddingLink');
        const linkInput = document.getElementById('weddingLinkInput');

        if (copyBtn && linkInput) {

            copyBtn.addEventListener('click', async function () {

                try {

                    await navigator.clipboard.writeText(linkInput.value);

                    copyBtn.innerHTML = '✅ Đã sao chép thành công';

                    setTimeout(() => {
                        copyBtn.innerHTML = '📋 Sao chép';
                    }, 2000);

                } catch (error) {

                    linkInput.select();
                    document.execCommand('copy');

                    copyBtn.innerHTML = '✅ Đã sao chép thành công';

                    setTimeout(() => {
                        copyBtn.innerHTML = '📋 Sao chép';
                    }, 2000);
                }

            });

        }
            const viewWeddingBtn = document.getElementById('btnViewWedding');

    if (viewWeddingBtn) {
        viewWeddingBtn.addEventListener('click', function () {

            if (finalUrl) {
                window.open(finalUrl, '_blank');
            }

        });
    }

    }

}).then((result) => {

    if (result.isConfirmed) {

        window.location.href = "{{ route('login') }}";

    }

});
                        } else {
                            // 🌟 ĐÃ ĐĂNG NHẬP -> HIỆN THÔNG BÁO XEM THIỆP
                            Swal.fire({
                                icon: 'success',
                                title: 'Lưu thiệp thành công! 🎉',
                                text: 'Thiệp cưới đã được lưu vào tài khoản của bạn.',
                                showCancelButton: true,
                                confirmButtonColor: '#e11d48',
                                cancelButtonColor: '#6c757d',
                                confirmButtonText: '🔗 Xem thiệp ngay',
                                cancelButtonText: 'Chỉnh sửa tiếp'
                            }).then((result) => {
                                if (result.isConfirmed && finalUrl) {
                                    window.open(finalUrl, '_blank');
                                }
                            });
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Không thể lưu thiệp',
                            text: data.message || 'Đã xảy ra lỗi trong quá trình lưu dữ liệu.'
                        });
                    }
                })
                .catch(error=>{

    btnSave.disabled=false;

    btnSave.innerHTML='<i class="bi bi-floppy me-1"></i> Lưu & Tạo thiệp';

    if(error.errors){

        let msg='';

        Object.values(error.errors).forEach(function(item){

            msg+=item[0]+'<br>';

        });

        Swal.fire({
            icon:'warning',
            title:'Thiếu thông tin',
            html:msg
        });

        return;
    }

    Swal.fire({
        icon:'error',
        title:'Có lỗi',
        text:'Không kết nối được máy chủ.'
    });

});
        });
}

        // 4. MỞ MODAL THANH TOÁN VIETQR
        const btnConfirmPayVip = document.getElementById('btnConfirmPayVip');
        const btnCheck = document.getElementById('btnCheckPaymentStatus');

if(btnCheck){

    btnCheck.addEventListener('click',function(){

        Swal.fire({
            icon:'info',
            title:'Đang kiểm tra thanh toán...',
            text:'Chức năng này sẽ kết nối backend sau.'
        });

    });

}
        if (btnConfirmPayVip) {
            btnConfirmPayVip.addEventListener('click', function(e) {
                e.preventDefault();

                const BANK_ID = "{{ config('services.vietqr.bank_id', 'MB') }}";
                const ACCOUNT_NO = "{{ config('services.vietqr.account_no') }}";
                const AMOUNT = 99000; 
                let cardId = Math.floor(Math.random() * 8999) + 1000; 
                let memo = 'VIP ' + cardId;

                let qrApiUrl = `https://img.vietqr.io/image/${BANK_ID}-${ACCOUNT_NO}-compact2.png?amount=${AMOUNT}&addInfo=${encodeURIComponent(memo)}`;

                document.getElementById('vietqrImg').src = qrApiUrl;
                document.getElementById('displayMemo').innerText = memo;

                // Ẩn modal cũ, mở modal VietQR
                let vipModalEl = document.getElementById('vipUpgradeModal');
                if(vipModalEl) {
                    let modalVip = bootstrap.Modal.getInstance(vipModalEl);
                    if(modalVip) modalVip.hide();
                }

                let qrModalEl = document.getElementById('vietqrPaymentModal');
                if(qrModalEl) {
                    let modalQr = bootstrap.Modal.getOrCreateInstance(qrModalEl);
                    modalQr.show();
                }
            });
        }
    });
    
    </script>
</body>
</html>