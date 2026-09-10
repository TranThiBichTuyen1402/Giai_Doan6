@extends('layouts.dashboard')

@section('page-title', '💌 Quản lý Khách Phản Hồi & Bàn Tiệc')
@section('title', 'Danh sách RSVP')

@section('content')
<div class="container-fluid px-0">
    @if($selectedCard)
    
    {{-- THANH CHUYỂN TAB & CHỌN THIỆP --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <ul class="nav nav-pills gap-2 bg-white p-2 rounded-4 shadow-sm border" id="rsvpTabs" role="tablist">
    <li class="nav-item">
        <button class="nav-link active rounded-pill fw-bold px-4" id="guest-tab" data-bs-toggle="tab" data-bs-target="#guest-panel" type="button">
            💌 Khách Phản Hồi
        </button>
    </li>
    
    {{-- TAB 2: BÀN TIỆC --}}
    <li class="nav-item">
        @if($selectedCard->is_vip)
            <button class="nav-link rounded-pill fw-bold px-4" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-panel" type="button">
                🪑 Sơ đồ Bàn Tiệc
            </button>
        @else
            <button class="nav-link rounded-pill fw-bold px-4 text-muted" type="button" data-bs-toggle="modal" data-bs-target="#vipRequiredModal">
                🪑 Sơ đồ Bàn Tiệc <span class="badge bg-warning text-dark rounded-pill ms-1" style="font-size: 10px;">👑 VIP</span>
            </button>
        @endif
    </li>

    {{-- TAB 3: LỜI CHÚC & VOICE --}}
    <li class="nav-item">
        @if($selectedCard->is_vip)
            <button class="nav-link rounded-pill fw-bold px-4" id="wishes-tab" data-bs-toggle="tab" data-bs-target="#wishes-panel" type="button">
                💬 Lời Chúc & Voice
            </button>
        @else
            <button class="nav-link rounded-pill fw-bold px-4 text-muted" type="button" data-bs-toggle="modal" data-bs-target="#vipRequiredModal">
                💬 Lời Chúc & Voice <span class="badge bg-warning text-dark rounded-pill ms-1" style="font-size: 10px;">👑 VIP</span>
            </button>
        @endif
    </li>

    <li class="nav-item">
        <button class="nav-link rounded-pill fw-bold px-4" id="moments-tab" data-bs-toggle="tab" data-bs-target="#moments-panel" type="button">
            📸 Kho Ảnh Kỷ Niệm
        </button>
    </li>

    <li class="nav-item">
        <button class="nav-link rounded-pill fw-bold px-4" id="money-tab" data-bs-toggle="tab" data-bs-target="#money-panel" type="button">
            💸 Mừng Cưới & QR
        </button>
    </li>
</ul>

        <div class="d-flex align-items-center gap-2 ms-auto">
            @if($allCards->count() > 1)
            <form method="GET" action="{{ route('rsvp.index') }}" class="d-flex align-items-center gap-2">
                <label class="small text-muted fw-bold text-nowrap">Xem thiệp:</label>
                <select name="card_id" class="form-select form-select-sm rounded-3 shadow-sm" onchange="this.form.submit()">
                    @foreach($allCards as $c)
                        <option value="{{ $c->id }}" {{ $c->id == $selectedCard->id ? 'selected' : '' }}>
                            {{ $c->groom_name }} ❤️ {{ $c->bride_name }}
                        </option>
                    @endforeach
                </select>
            </form>
            @endif

            <button class="btn btn-sm btn-primary rounded-pill fw-bold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addGuestModal">
                <i class="bi bi-person-plus-fill me-1"></i> + Thêm khách
            </button>
            
        <button class="btn btn-sm btn-success rounded-pill fw-bold px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#importExcelModal">
            <i class="bi bi-file-earmark-excel me-1"></i> Nhập Excel
        </button>
            <button class="btn btn-sm btn-outline-secondary rounded-pill fw-bold px-3 shadow-sm" onclick="window.print()">
                <i class="bi bi-printer me-1"></i> In danh sách
            </button>
        </div>
    </div>

    <div class="tab-content" id="rsvpTabsContent">
        
        {{-- TAB 1: DANH SÁCH KHÁCH PHẢN HỒI --}}
        <div class="tab-pane fade show active" id="guest-panel">
            <div class="card border-0 shadow-sm rounded-4 mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">
                        💌 Danh sách Khách Phản Hồi: <span class="text-danger">{{ $selectedCard->groom_name }} & {{ $selectedCard->bride_name }}</span>
                    </h5>
                </div>

                {{-- THỐNG KÊ --}}
                <div class="row g-3 mb-4 text-center">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="text-muted small">Tổng lượt phản hồi</div>
                            <div class="h4 fw-bold mb-0">{{ $stats['total_rsvps'] }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
                            <div class="text-success small fw-bold">Tham dự</div>
                            <div class="h4 fw-bold text-success mb-0">{{ $stats['attending'] }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-info bg-opacity-10 rounded-3 border border-info border-opacity-25">
                            <div class="text-info small fw-bold">Tổng khách đi cùng</div>
                            <div class="h4 fw-bold text-info mb-0">{{ $stats['total_guests'] }} người</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-secondary bg-opacity-10 rounded-3 border">
                            <div class="text-secondary small fw-bold">Chờ phản hồi</div>
                            <div class="h4 fw-bold text-secondary mb-0">{{ $stats['declined'] }}</div>
                        </div>
                    </div>
                </div>

                {{-- BỘ LỌC VÀ TÌM KIẾM --}}
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input type="text" id="searchInput" class="form-control form-control-sm rounded-3" placeholder="🔍 Tìm tên khách hoặc SĐT..." onkeyup="filterTable()">
                    </div>
                    <div class="col-md-3">
                        <select id="sideFilter" class="form-select form-select-sm rounded-3" onchange="filterTable()">
                            <option value="">-- Tất cả nhà (Trai/Gái) --</option>
                            <option value="groom">Nhà trai</option>
                            <option value="bride">Nhà gái</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="statusFilter" class="form-select form-select-sm rounded-3" onchange="filterTable()">
                            <option value="">-- Tất cả trạng thái --</option>
                            <option value="pending">Chờ phản hồi</option>
                            <option value="1">Tham dự</option>
                            <option value="0">Vắng mặt</option>
                        </select>
                    </div>
                </div>

                {{-- BẢNG KHÁCH MỜI --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="rsvpTable">
                        <thead class="table-light">
                            <tr>
                                <th>Khách mời</th>
                                <th>SĐT</th>
                                <th>Khách nhà</th>
                                <th>Xác nhận</th>
                                <th>Số người</th>
                                <th>Bàn tiệc</th>
                                <th>Lời chúc / Lời nhắn</th>
                                <th>Thời gian</th>
                                <th class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rsvps as $rsvp)
                            <tr data-side="{{ $rsvp->side }}" data-status="{{ is_null($rsvp->is_attending) ? 'pending' : ($rsvp->is_attending ? '1' : '0') }}">
                                <td class="fw-bold search-target">{{ $rsvp->guest_name }}</td>
                                <td class="small search-target">{{ $rsvp->phone ?? '—' }}</td>
                                <td>
                                    @if($rsvp->side == 'groom')
                                        <span class="badge bg-primary bg-opacity-10 text-primary">Nhà trai</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger">Nhà gái</span>
                                    @endif
                                </td>
                                <td>
                                @if(is_null($rsvp->is_attending))
                                    <span class="badge bg-secondary">Chờ phản hồi</span>
                                @elseif($rsvp->is_attending)
                                    <span class="badge bg-success">Tham dự</span>
                                @else
                                    <span class="badge bg-danger">Vắng mặt</span>
                                @endif
                            </td>
                                <td><span class="fw-bold text-dark">{{ $rsvp->guest_count }}</span></td>
                                <td>
                                    @if(!empty($rsvp->table))
                                        <span class="badge bg-warning bg-opacity-10 text-dark fw-bold">🪑 {{ $rsvp->table->name }}</span>
                                    @else
                                        <span class="text-muted small">Chưa xếp</span>
                                    @endif
                                </td>
                                <td class="small">{{ $rsvp->message ?? '—' }}</td>
                                <td class="small text-muted">{{ $rsvp->created_at ? $rsvp->created_at->format('H:i d/m/Y') : '' }}</td>
                               <td class="text-center">
    <div class="d-flex justify-content-center gap-1">
        {{-- NÚT SỬA --}}
        <button type="button" class="btn btn-sm btn-outline-primary border-0 rounded-circle px-2" data-bs-toggle="modal" data-bs-target="#editGuestModal{{ $rsvp->id }}" title="Chỉnh sửa">
            ✏️
        </button>

        {{-- NÚT XÓA --}}
<form action="{{ route('wedding_rsvps.destroy', ['id' => $rsvp->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa khách {{ $rsvp->guest_name }}?')">            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle px-2" title="Xóa khách này">
                🗑️
            </button>
        </form>
    </div>

    {{-- MODAL CHỈNH SỬA CHO TỪNG KHÁCH --}}
    <div class="modal fade" id="editGuestModal{{ $rsvp->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered text-start">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">✏️ Cập nhật thông tin khách mời</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('wedding_rsvps.update', $rsvp->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tên khách mời</label>
                            <input type="text" name="guest_name" class="form-control rounded-3" value="{{ $rsvp->guest_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control rounded-3" value="{{ $rsvp->phone }}">
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Khách nhà</label>
                                <select name="side" class="form-select rounded-3">
                                    <option value="groom" {{ $rsvp->side == 'groom' ? 'selected' : '' }}>Nhà trai</option>
                                    <option value="bride" {{ $rsvp->side == 'bride' ? 'selected' : '' }}>Nhà gái</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Trạng thái</label>
                                <select name="is_attending" class="form-select rounded-3">
                                    <option value="" {{ is_null($rsvp->is_attending) ? 'selected' : '' }}>Chờ phản hồi</option>
                                    <option value="1" {{ $rsvp->is_attending === 1 ? 'selected' : '' }}>Tham dự</option>
                                    <option value="0" {{ $rsvp->is_attending === 0 ? 'selected' : '' }}>Vắng mặt</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Số người tham dự</label>
                            <input type="number" name="guest_count" class="form-control rounded-3" value="{{ $rsvp->guest_count }}" min="0">
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-bold">Lời nhắn / Ghi chú</label>
                            <textarea name="message" class="form-control rounded-3" rows="2">{{ $rsvp->message }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">Lưu cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">Chưa có lượt phản hồi RSVP nào cho tấm thiệp này.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 2: QUẢN LÝ BÀN TIỆC & XẾP CHỖ --}}
        <div class="tab-pane fade" id="table-panel">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">🪑 Quản lý Bàn Tiệc & Xếp Chỗ Ngồi</h5>
                        <p class="text-muted small mb-0">Tạo bàn tiệc và phân bổ khách tham dự vào từng bàn.</p>
                    </div>
                    <button class="btn btn-danger rounded-pill fw-bold px-3" data-bs-toggle="modal" data-bs-target="#addTableModal">
                        + Tạo Bàn Tiệc Mới
                    </button>
                </div>
        
                <div class="row g-4">
                    {{-- CỘT BÊN TRÁI: DANH SÁCH BÀN TIỆC --}}
                    <div class="col-lg-8">
                        <div class="row g-3">
                            @forelse($tables as $table)
                            @php
    $totalSeated = $table->rsvps->sum(function($g) {
        return $g->guest_count > 0 ? $g->guest_count : 1;
    });
    $isOverloaded = $totalSeated > $table->capacity;
@endphp
                            <div class="col-md-6">
                                <div class="card border-0 bg-light rounded-4 p-3 shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0 text-dark">🪑 {{ $table->name }}</h6>
                                        <span class="badge {{ $isOverloaded ? 'bg-danger' : 'bg-danger bg-opacity-10 text-danger' }} rounded-pill px-3">
                                            {{ $totalSeated }}/{{ $table->capacity }} chỗ
                                        </span>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush rounded-3 bg-white border-0 shadow-sm mb-0">
                                        @forelse($table->rsvps as $guest)
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                                            <div>
                                                <div class="fw-bold small text-dark">{{ $guest->guest_name }}</div>
                                                <div class="text-muted extra-small" style="font-size: 11px;">
                                                {{ $guest->guest_count ?? 1 }} người tham dự
                                            </div>
                                            </div>
                                            <form action="{{ route('wedding_rsvps.assignTable', $guest->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="table_id" value="">
                                                <button type="submit" class="btn btn-link text-danger p-0 text-decoration-none small" title="Bỏ khỏi bàn">✕</button>
                                            </form>
                                        </li>
                                        @empty
                                        <li class="list-group-item text-muted text-center py-3 small">Bàn chưa có khách nào</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-5 text-muted">
                                Chưa có bàn tiệc nào. Hãy bấm <strong>"+ Tạo Bàn Tiệc Mới"</strong> để bắt đầu!
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- CỘT BÊN PHẢI: KHÁCH CHƯA XẾP BÀN --}}
                    <div class="col-lg-4">
                        <div class="card border-0 bg-warning bg-opacity-10 rounded-4 p-3">
                            <h6 class="fw-bold text-dark mb-3">⚠️ Khách Tham Dự Chưa Xếp Bàn ({{ count($unassignedGuests) }})</h6>
                            
                            <div class="d-flex flex-column gap-2" style="max-height: 400px; overflow-y: auto;">
                                @forelse($unassignedGuests as $uGuest)
                                <div class="p-2 bg-white rounded-3 shadow-sm d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold small text-dark">{{ $uGuest->guest_name }}</div>
                                        <div class="text-muted extra-small" style="font-size: 11px;">
                                            {{ $uGuest->side == 'groom' ? 'Nhà trai' : 'Nhà gái' }} • {{ $uGuest->guest_count ?? 1 }} người tham dự
                                        </div>
                                    </div>
                                    <form action="{{ route('wedding_rsvps.assignTable', $uGuest->id) }}" method="POST" class="d-flex align-items-center gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <select name="table_id" class="form-select form-select-sm rounded-pill border-warning" onchange="this.form.submit()" style="font-size: 12px;">
                                            <option value="">+ Chọn bàn</option>
                                            @foreach($tables as $tb)
                                                <option value="{{ $tb->id }}">{{ $tb->name }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                                @empty
                                <div class="text-muted text-center py-3 small">Tất cả khách tham dự đã được xếp bàn! 🎉</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 3: QUẢN LÝ LỜI CHÚC & VOICE --}}
        <div class="tab-pane fade" id="wishes-panel">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-danger">💬 Sổ Lời Chúc & Ghi Âm Giọng Nói từ Khách Mời</h5>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 fw-bold">
                        Tổng cộng: {{ count($wishes) }} lời chúc
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 20%;">Khách mời</th>
                                <th style="width: 40%;">Lời chúc</th>
                                <th style="width: 20%;">Voice ghi âm</th>
                                <th style="width: 12%;">Thời gian</th>
                                <th style="width: 8%;" class="text-end">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wishes as $wish)
                            <tr>
                                <td class="fw-bold text-dark">{{ $wish->sender_name }}</td>
                                <td>{{ $wish->message ?? '—' }}</td>
                                <td>
                                    @if(!empty($wish->voice_url))
                                        <audio controls style="height: 32px; max-width: 220px;">
                                            <source src="{{ asset($wish->voice_url) }}" type="audio/mpeg">
                                            Trình duyệt không hỗ trợ phát âm thanh.
                                        </audio>
                                    @else
                                        <span class="badge bg-light text-muted fw-normal">Không có voice</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $wish->created_at ? $wish->created_at->format('H:i d/m/Y') : '—' }}
                                </td>
                                <td class="text-end">
                                    <form action="{{ route('wishes.destroy', $wish->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa lời chúc này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0 border-0" title="Xóa lời chúc">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-chat-square-dots fs-3 d-block mb-2"></i>
                                    Chưa có lời chúc hoặc ghi âm voice nào cho thiệp này.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

     {{-- TAB 4: QUẢN LÝ KHO ẢNH CƯỚI --}}
<div class="tab-pane fade" id="moments-panel">
    {{-- Form Đăng Ảnh --}}
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
        <h5 class="fw-bold mb-3 text-primary">📤 Tải thêm ảnh cưới / ảnh kỷ niệm</h5>
        <form action="{{ route('moments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="wedding_card_id" value="{{ $selectedCard->id }}">
            <div class="row g-3 align-items-center">
                <div class="col-md-8">
                    <input type="file" name="photos[]" class="form-control" multiple accept="image/*" required>
                    <small class="text-muted">Chọn một hoặc nhiều ảnh (JPG, PNG, WEBP - Tối đa 10MB/ảnh)</small>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        <i class="bi bi-cloud-arrow-up"></i> Tải ảnh lên
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    {{-- Danh sách Ảnh --}}
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-3">🖼️ Tất cả ảnh trong kho</h5>
        <div class="row g-3">
            @forelse($moments as $moment)
            <div class="col-6 col-md-3">
                <div class="border rounded-3 overflow-hidden shadow-sm position-relative">
                    <img src="{{ asset($moment->photo_url) }}" class="w-100" style="height: 180px; object-fit: cover;" loading="lazy">
                    <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                        <small class="text-truncate text-muted" style="max-width: 120px;">
                            👤 {{ $moment->uploaded_by ?? 'Khách' }}
                        </small>
                        <form action="{{ route('moments.destroy', $moment->id) }}" method="POST" onsubmit="return confirm('Bạn muốn xóa ảnh này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-link text-danger p-0 border-0" title="Xóa ảnh">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4 text-muted">
                <i class="bi bi-images fs-2 d-block mb-2"></i>
                Chưa có ảnh nào trong kho.
            </div>
            @endforelse
        </div>
    </div>
</div>
        {{-- TAB 5: MỪNG CƯỚI & QR BANK --}}
       {{-- TAB 5: MỪNG CƯỚI & QR BANK --}}
<div class="tab-pane fade" id="money-panel" role="tabpanel">
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <h5 class="fw-bold mb-4 text-primary">💳 Cấu Hình Mã QR Mừng Cưới</h5>
        
        <form action="{{ route('bank.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="wedding_card_id" value="{{ $selectedCard->id ?? '' }}">
            
            <div class="row g-4">
                {{-- NHÀ TRAI --}}
                <div class="col-md-6 border-end">
                    <h6 class="fw-bold text-danger mb-3">🤵 Mừng Cưới Chú Rể (Nhà Trai)</h6>
                    <div class="mb-3">
                        <label class="form-label">Tên Ngân Hàng</label>
                        <input type="text" name="groom_bank_name" class="form-control" placeholder="MB Bank, Vietcombank..." value="{{ $selectedCard->groom_bank_name ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số Tài Khoản</label>
                        <input type="text" name="groom_bank_acc" class="form-control" value="{{ $selectedCard->groom_bank_acc ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên Chủ Tài Khoản</label>
                        <input type="text" name="groom_bank_owner" class="form-control" value="{{ $selectedCard->groom_bank_owner ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tải Mã QR Chú Rể</label>
                        <input type="file" name="groom_qr" class="form-control" accept="image/*">
                        @if(!empty($selectedCard->groom_qr_code))
                            <img src="{{ asset($selectedCard->groom_qr_code) }}" class="mt-2 rounded border" style="height: 120px;">
                        @endif
                    </div>
                </div>

                {{-- NHÀ GÁI --}}
                <div class="col-md-6">
                    <h6 class="fw-bold text-danger mb-3">👰 Mừng Cưới Cô Dâu (Nhà Gái)</h6>
                    <div class="mb-3">
                        <label class="form-label">Tên Ngân Hàng</label>
                        <input type="text" name="bride_bank_name" class="form-control" placeholder="MB Bank, Vietcombank..." value="{{ $selectedCard->bride_bank_name ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số Tài Khoản</label>
                        <input type="text" name="bride_bank_acc" class="form-control" value="{{ $selectedCard->bride_bank_acc ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tên Chủ Tài Khoản</label>
                        <input type="text" name="bride_bank_owner" class="form-control" value="{{ $selectedCard->bride_bank_owner ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tải Mã QR Cô Dâu</label>
                        <input type="file" name="bride_qr" class="form-control" accept="image/*">
                        @if(!empty($selectedCard->bride_qr_code))
                            <img src="{{ asset($selectedCard->bride_qr_code) }}" class="mt-2 rounded border" style="height: 120px;">
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary fw-bold px-4">
                    <i class="bi bi-save"></i> Lưu Thông Tin Mừng Cưới
                </button>
            </div>
        </form>
    </div>
</div>

    </div>

    @else
    <div class="text-center py-5 bg-white rounded-4 shadow-sm">
        <h5 class="text-muted mb-0">Bạn chưa có thiệp nào để xem danh sách RSVP.</h5>
    </div>
    @endif
</div>

{{-- MODAL THÊM KHÁCH MỜI THỦ CÔNG --}}
@if($selectedCard)
<div class="modal fade" id="addGuestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            
            <div class="modal-header border-0 pb-0 flex-column align-items-start">
                <div class="d-flex justify-content-between w-100 align-items-center mb-2">
                    <h5 class="modal-title fw-bold">➕ Thêm Khách Mời</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <ul class="nav nav-pills nav-justified w-100 bg-light p-1 rounded-3" id="addGuestTypeTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active rounded-3 py-1 fw-bold small" id="single-guest-tab" data-bs-toggle="tab" data-bs-target="#single-guest" type="button">
                            👤 Thêm 1 khách
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link rounded-3 py-1 fw-bold small" id="bulk-guest-tab" data-bs-toggle="tab" data-bs-target="#bulk-guest" type="button">
                            📋 Nhập danh sách nhanh
                        </button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="addGuestTypeTabContent">
                
                {{-- TAB 1: THÊM 1 KHÁCH ĐƠN LẺ --}}
                <div class="tab-pane fade show active" id="single-guest">
                    <form action="{{ route('wedding_rsvps.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="wedding_card_id" value="{{ $selectedCard->id }}">
                        
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Tên khách mời *</label>
                                <input type="text" name="guest_names" class="form-control rounded-3" placeholder="VD: Anh Tuấn" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Khách nhà *</label>
                                <select name="side" class="form-select rounded-3">
                                    <option value="groom">Nhà trai</option>
                                    <option value="bride">Nhà gái</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control rounded-3" placeholder="0901234567">
                            </div>

                            <div class="mb-2">
                                <label class="form-label small fw-bold">Ghi chú</label>
                                <textarea name="message" class="form-control rounded-3" rows="2" placeholder="Ghi chú thêm..."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold px-4">Lưu Khách Mời</button>
                        </div>
                    </form>
                </div>

                {{-- TAB 2: NHẬP DANH SÁCH NHIỀU KHÁCH --}}
                <div class="tab-pane fade" id="bulk-guest">
                    <form action="{{ route('wedding_rsvps.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="wedding_card_id" value="{{ $selectedCard->id }}">
                        
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Danh sách tên (Mỗi người 1 dòng) *</label>
                                <textarea name="guest_names" class="form-control rounded-3" rows="5" placeholder="Anh Tuấn&#10;Cô Bảy&#10;Chú 8 Cần Thơ" required></textarea>
                            </div>

                            <div class="mb-2">
                                <label class="form-label small fw-bold">Áp dụng cho nhà *</label>
                                <select name="side" class="form-select rounded-3">
                                    <option value="groom">Nhà trai</option>
                                    <option value="bride">Nhà gái</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-success rounded-pill fw-bold px-4">Thêm Danh Sách</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endif
<!-- MODAL NHẬP DỮ LIỆU TỪ EXCEL -->
@if($selectedCard)
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-success">📂 Import Danh Sách Khách Mời</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('wedding_rsvps.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="wedding_card_id" value="{{ $selectedCard->id }}">
                
                <div class="modal-body">
                    <p class="text-muted small mb-3">Tải lên danh sách khách mời dự kiến để hệ thống tạo thiệp online và gửi link phản hồi.</p>
                    
                    {{-- LINK TẢI FILE MẪU --}}
                    <div class="p-3 bg-light rounded-3 border mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="small fw-bold text-dark">File mẫu Excel (.xlsx)</div>
                                <div class="text-muted extra-small" style="font-size: 11px;">Gồm 3 cột: Tên khách, SĐT, Phía (groom/bride)</div>
                            </div>
                            <a href="{{ route('wedding_rsvps.download_sample') }}" class="btn btn-sm btn-outline-success rounded-pill fw-bold">
                                <i class="bi bi-download me-1"></i> Tải Mẫu
                            </a>
                        </div>
                    </div>

                    {{-- CHỌN FILE --}}
                    <div class="mb-2">
                        <label class="form-label small fw-bold">Chọn File Excel / CSV *</label>
                        <input type="file" name="excel_file" class="form-control rounded-3" accept=".xlsx, .xls, .csv" required>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-success rounded-pill fw-bold px-4">
                        <i class="bi bi-cloud-arrow-up me-1"></i> Upload & Tải lên
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
{{-- POPUP THÔNG BÁO DÀNH CHO TÀI KHOẢN CẦN NÂNG CẤP VIP --}}
<div class="modal fade" id="vipRequiredModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow text-center p-4">
            <div class="modal-body p-0">
                <div class="mb-3">
                    <span style="font-size: 48px;">👑</span>
                </div>
                <h4 class="fw-bold text-dark mb-2">Tính năng dành cho thiệp VIP</h4>
                <p class="text-muted small mb-4">
                    Nâng cấp VIP chỉ với 99.000đ để mở khóa toàn bộ tính năng cao cấp!
                </p>
                <div class="p-3 bg-light rounded-3 border mb-4 text-start">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="small fw-bold">Sơ đồ Bàn Tiệc & Xếp chỗ ngồi cho khách</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="small fw-bold">Nhận và nghe Lời chúc ghi âm (Voice)</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <span class="small fw-bold">Tải không giới hạn ảnh kỷ niệm</span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light rounded-pill w-50 fw-bold" data-bs-dismiss="modal">Đóng</button>
                    <a href="#" class="btn btn-warning text-dark rounded-pill w-50 fw-bold shadow-sm">
                        ⚡ Nâng cấp VIP (99k)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MODAL TẠO BÀN TIỆC MỚI --}}
@if($selectedCard)
<div class="modal fade" id="addTableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">🪑 Tạo Bàn Tiệc Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('wedding_tables.store') }}" method="POST">
                @csrf
                <input type="hidden" name="wedding_card_id" value="{{ $selectedCard->id }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tên bàn tiệc *</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="VD: Bàn Họ Hàng 1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Số ghế tối đa</label>
                        <input type="number" name="capacity" class="form-control rounded-3" value="10" min="1">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger rounded-pill fw-bold px-4">Tạo Bàn</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
<script>
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const side = document.getElementById('sideFilter').value;
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#rsvpTable tbody tr');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        const rowSide = row.getAttribute('data-side');
        const rowStatus = row.getAttribute('data-status');

        const matchSearch = text.includes(search);
        const matchSide = !side || rowSide === side;
        const matchStatus = !status || rowStatus === status;

        if (matchSearch && matchSide && matchStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    let activeTab = localStorage.getItem('activeRsvpTab');
    if (location.hash) {
        activeTab = location.hash;
    }
    if (activeTab) {
        let tabTrigger = document.querySelector(`button[data-bs-target="${activeTab}"]`);
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }

    document.querySelectorAll('#rsvpTabs button[data-bs-toggle="tab"]').forEach(tabBtn => {
        tabBtn.addEventListener('shown.bs.tab', function (e) {
            let target = e.target.getAttribute('data-bs-target');
            localStorage.setItem('activeRsvpTab', target);
            location.hash = target;
        });
    });
});
</script>
@endsection