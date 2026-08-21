@extends('layouts.dashboard')

@section('page-title', '💌 Quản lý Khách Phản Hồi & Bàn Tiệc')
@section('title', 'Danh sách RSVP')

@section('content')
<div class="container-fluid px-0">
    @if($selectedCard)
    
    {{-- THANH CHUYỂN TAB --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <ul class="nav nav-pills gap-2 bg-white p-2 rounded-4 shadow-sm border" id="rsvpTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill fw-bold px-4" id="guest-tab" data-bs-toggle="tab" data-bs-target="#guest-panel" type="button">
                    💌 Danh sách Khách Phản Hồi
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill fw-bold px-4" id="table-tab" data-bs-toggle="tab" data-bs-target="#table-panel" type="button">
                    🪑 Sơ đồ Bàn Tiệc & Xếp Chỗ
                </button>
            </li>
        </ul>

        @if($allCards->count() > 1)
        <form method="GET" action="{{ route('rsvp.index') }}" class="d-flex align-items-center gap-2">
            <label class="small text-muted fw-bold text-nowrap">Xem thiệp:</label>
            <select name="card_id" class="form-select form-select-sm rounded-3" onchange="this.form.submit()">
                @foreach($allCards as $c)
                    <option value="{{ $c->id }}" {{ $c->id == $selectedCard->id ? 'selected' : '' }}>
                        {{ $c->groom_name }} ❤️ {{ $c->bride_name }}
                    </option>
                @endforeach
            </select>
        </form>
        @endif
    </div>

    <div class="tab-content" id="rsvpTabsContent">
        
        {{-- TAB 1: DANH SÁCH KHÁCH PHẢN HỒI --}}
        <div class="tab-pane fade show active" id="guest-panel">
            <div class="card border-0 shadow-sm rounded-4 mb-4 p-4">
                <h5 class="fw-bold mb-3">
                    💌 Danh sách Khách Phản Hồi: <span class="text-danger">{{ $selectedCard->groom_name }} & {{ $selectedCard->bride_name }}</span>
                </h5>

                {{-- THỐNG KÊ --}}
                <div class="row g-3 mb-4 text-center">
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-light rounded-3">
                            <div class="text-muted small">Tổng lượt phản hồi</div>
                            <div class="h4 fw-bold mb-0">{{ $stats['total_rsvps'] }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-success bg-opacity-10 rounded-3">
                            <div class="text-success small fw-bold">Tham dự</div>
                            <div class="h4 fw-bold text-success mb-0">{{ $stats['attending'] }}</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-info bg-opacity-10 rounded-3">
                            <div class="text-info small fw-bold">Tổng số khách đi cùng</div>
                            <div class="h4 fw-bold text-info mb-0">{{ $stats['total_guests'] }} người</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="p-3 bg-secondary bg-opacity-10 rounded-3">
                            <div class="text-secondary small fw-bold">Vắng mặt</div>
                            <div class="h4 fw-bold text-secondary mb-0">{{ $stats['declined'] }}</div>
                        </div>
                    </div>
                </div>

                {{-- BẢNG KHÁCH MỜI --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rsvps as $rsvp)
                            <tr>
                                <td class="fw-bold">{{ $rsvp->guest_name }}</td>
                                <td class="small">{{ $rsvp->phone ?? '—' }}</td>
                                <td>
                                    @if($rsvp->side == 'groom')
                                        <span class="badge bg-primary bg-opacity-10 text-primary">Nhà trai</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger">Nhà gái</span>
                                    @endif
                                </td>
                                <td>
                                    @if($rsvp->is_attending)
                                        <span class="badge bg-success">Tham dự</span>
                                    @else
                                        <span class="badge bg-secondary">Vắng mặt</span>
                                    @endif
                                </td>
                                <td><span class="fw-bold text-dark">+{{ $rsvp->guest_count }}</span></td>
                                <td>
                                    @if(!empty($rsvp->table))
                                        <span class="badge bg-warning bg-opacity-10 text-dark fw-bold">🪑 {{ $rsvp->table->name }}</span>
                                    @else
                                        <span class="text-muted small">Chưa xếp</span>
                                    @endif
                                </td>
                                <td>{{ $rsvp->message ?? '—' }}</td>
                                <td class="small text-muted">{{ $rsvp->created_at ? $rsvp->created_at->format('H:i d/m/Y') : '' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Chưa có lượt phản hồi RSVP nào cho tấm thiệp này.</td>
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
                    {{-- DANH SÁCH BÀN TIỆC --}}
                    <div class="col-lg-8">
                        <div class="row g-3">
                            @forelse($tables as $table)
                            <div class="col-md-6">
                                <div class="card border-0 bg-light rounded-4 p-3 shadow-sm h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0 text-dark">🪑 {{ $table->name }}</h6>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">
                                            {{ $table->rsvps->sum('guest_count') + $table->rsvps->count() }}/{{ $table->capacity }} chỗ
                                        </span>
                                    </div>
                                    
                                    <ul class="list-group list-group-flush rounded-3 bg-white border-0 shadow-sm mb-0">
                                        @forelse($table->rsvps as $guest)
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3">
                                            <div>
                                                <span class="fw-bold text-dark small">{{ $guest->guest_name }}</span>
                                                @if($guest->guest_count > 0)
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border small">+{{ $guest->guest_count }} đi cùng</span>
                                                @endif
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

                    {{-- KHÁCH CHƯA XẾP BÀN --}}
                    <div class="col-lg-4">
                        <div class="card border-0 bg-warning bg-opacity-10 rounded-4 p-3">
                            <h6 class="fw-bold text-dark mb-3">⚠️ Khách Tham Dự Chưa Xếp Bàn ({{ count($unassignedGuests) }})</h6>
                            
                            <div class="d-flex flex-column gap-2" style="max-height: 400px; overflow-y: auto;">
                                @forelse($unassignedGuests as $uGuest)
                                <div class="p-2 bg-white rounded-3 shadow-sm d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="fw-bold small text-dark">{{ $uGuest->guest_name }}</div>
                                        <div class="text-muted extra-small" style="font-size: 11px;">
                                            {{ $uGuest->side == 'groom' ? 'Nhà trai' : 'Nhà gái' }} • +{{ $uGuest->guest_count }} người
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

    </div>

    @else
    <div class="text-center py-5 bg-white rounded-4 shadow-sm">
        <h5 class="text-muted mb-0">Bạn chưa có thiệp nào để xem danh sách RSVP.</h5>
    </div>
    @endif
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
                        <label class="form-label small fw-bold">Tên bàn tiệc</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="VD: Bàn VIP 01, Bạn Cấp 3, Bàn Họ Hàng..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Sức chứa (Số ghế)</label>
                        <input type="number" name="capacity" class="form-control rounded-3" value="10" min="1" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger rounded-pill fw-bold">Tạo Bàn</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection