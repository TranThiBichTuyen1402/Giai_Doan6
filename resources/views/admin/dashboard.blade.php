@extends('layouts.admin.app')

@section('title', 'Hệ Thống Quản Trị Toàn Diện - WedPlan Hub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')

<div class="container-fluid px-4 mt-4">


<div class="d-flex gap-3 mb-4">


  <a href="{{ route('card.choose') }}" class="btn btn-danger">
    <i class="fa-solid fa-plus"></i>
    Tạo Thiệp
</a>


<a href="#" class="btn btn-outline-danger">
<i class="fa-solid fa-layer-group"></i>
Thêm Mẫu
</a>


<a href="{{ route('admin.users.index') }}"
   class="btn btn-outline-primary">

    <i class="fa-solid fa-users"></i>

        Khách hàng
</a>
</div>
<main class="p-4 container-fluid">
    <div class="row g-4">
        
        <div class="col-12 col-lg-3">
            <div class="card p-3 card-custom h-100 bg-white">
                <div class="mb-3">
                    <span class="badge bg-danger-subtle text-danger rounded-pill mb-1" style="font-size: 0.55rem; padding: 0.3em 0.6em;">Lối tắt lõi</span>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.85rem;">Quản Lý Nhanh Website</h6>
                    <p class="text-muted mb-0" style="font-size: 0.65rem;">Thao tác nhanh các module nội dung</p>
                </div>

                <div class="d-flex flex-column gap-2">
                    <a href="{{ route('admin.posts') }}" class="quick-link-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-3 d-flex align-items-center justify-content-center text-primary" style="width: 32px; height: 32px; background-color: #e3effb;"><i class="fa-solid fa-newspaper text-xs"></i></span>
                                <div><h6 class="fw-bold mb-0 text-dark" style="font-size: 0.75rem;">Bài viết hệ thống</h6><small class="text-muted d-block" style="font-size: 0.55rem;">Đăng bài & cấu hình SEO</small></div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 0.55rem;"></i>
                        </div>
                    </a>

                    <a href="#" class="quick-link-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-3 d-flex align-items-center justify-content-center text-danger" style="width: 32px; height: 32px; background-color: #ffebee;"><i class="fa-solid fa-images text-xs"></i></span>
                                <div><h6 class="fw-bold mb-0 text-dark" style="font-size: 0.75rem;">Album ảnh cưới</h6><small class="text-muted d-block" style="font-size: 0.55rem;">Quản lý ảnh đại diện gallery</small></div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 0.55rem;"></i>
                        </div>
                    </a>

                    <a href="#" class="quick-link-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-3 d-flex align-items-center justify-content-center text-warning" style="width: 32px; height: 32px; background-color: #fffde7;"><i class="fa-solid fa-video text-xs"></i></span>
                                <div><h6 class="fw-bold mb-0 text-dark" style="font-size: 0.75rem;">Video & Nhạc nền</h6><small class="text-muted d-block" style="font-size: 0.55rem;">Cập nhật nhạc nền mẫu thiệp</small></div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 0.55rem;"></i>
                        </div>
                    </a>

                    <a href="#" class="quick-link-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <span class="rounded-3 d-flex align-items-center justify-content-center text-info" style="width: 32px; height: 32px; background-color: #e0f7fa;"><i class="fa-solid fa-sliders text-xs"></i></span>
                                <div><h6 class="fw-bold mb-0 text-dark" style="font-size: 0.75rem;">Banner & Giới thiệu</h6><small class="text-muted d-block" style="font-size: 0.55rem;">Sửa slider trang chủ</small></div>
                            </div>
                            <i class="fa-solid fa-chevron-right text-muted" style="font-size: 0.55rem;"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-9">
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="card p-3 card-custom border-0 d-flex flex-column justify-content-between shadow-sm" style="background-color: #E3FBF9 !important; height: 135px;">
                        <div class="d-flex align-items-center justify-content-between text-teal" style="color: #115e59; font-size: 0.8rem; font-weight: 700;">
                           <span>TỔNG NGƯỜI DÙNG</span>
                            <span class="badge bg-white bg-opacity-50 text-dark font-bold" style="font-size: 0.6rem;">Realtime</span>
                        </div>
                        <div class="mt-2">
                            <h3 class="fw-bold text-dark mb-0">{{ number_format($totalUsers) }}</h3>
                            <small class="text-muted" style="font-size: 0.6rem; font-weight: 500;">
    Người dùng đã đăng ký trên hệ thống
</small>
                        </div>
                        <div class="text-muted" style="font-size: 0.55rem; font-weight: 600;">
    Dữ liệu thống kê truy cập sẽ được cập nhật sau
</div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card p-3 card-custom border-0 d-flex flex-column justify-content-between shadow-sm" style="background-color: #F3EBFD !important; height: 135px;">
                        <div class="d-flex align-items-center justify-content-between text-purple" style="color: #6b21a8; font-size: 0.8rem; font-weight: 700;">
                            <span>TỔNG THIỆP CƯỚI</span>
                            <span class="badge bg-primary text-white" style="font-size: 0.55rem; background-color: #6b21a8 !important;">Tuần này</span>
                        </div>
                        <div class="mt-2">
                            <h3 class="fw-bold text-dark mb-0">{{ number_format($totalCards) }}</h3>
                            <small class="text-muted" style="font-size: 0.6rem; font-weight: 500;">
    Tổng số thiệp đã được tạo trên hệ thống
</small>
                        </div>
                        
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card p-3 card-custom text-white border-0 d-flex flex-column justify-content-between shadow-sm" style="background: linear-gradient(to top right, #ec4899, #f43f5e); height: 135px;">
                        <div class="d-flex align-items-center justify-content-between font-bold" style="font-size: 0.75rem; font-weight: 700;">
                            <span>GÓI THÀNH VIÊN</span>
                            <span class="badge bg-white bg-opacity-25" style="font-size: 0.55rem;">Tháng này</span>
                        </div>
                       <div class="mt-2">
    <h3 class="fw-bold mb-0">
    {{ number_format($totalVipUsers) }}
</h3>

<small class="opacity-75">
    Khách FREE: {{ number_format($totalFreeUsers) }}
</small>

<small class="opacity-75 d-block">
    Thiệp đã thanh toán: {{ number_format($paidCards) }}
</small>
</div>
                        <div class="d-flex justify-content-between align-items-center opacity-90" style="font-size: 0.55rem;">
                            <div class="d-flex justify-content-end align-items-center opacity-90"
     style="font-size: 0.55rem;">
    <span>Thống kê thanh toán thực tế</span>
</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-12">
                    <div class="card p-3 card-custom h-100 bg-white">
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;">Danh Sách Khách Hàng & Tiến Độ Đám Cưới</h6>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="font-size: 0.75rem;">
                                <thead class="table-light text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">
                                    <tr>
                                        <th class="py-2.5 px-3 rounded-start-3">Tên Cặp Đôi</th>
                                        <th class="py-2.5 px-3">Mẫu Thiệp Tùy Biến</th>
                                        <th class="py-2.5 px-3">Hạng Gói</th>
                                        <th class="py-2.5 px-3 rounded-end-3">Lời Chúc / RSVP</th>
                                    </tr>
                                </thead>
  <tbody>

@forelse($recentCards as $card)

<tr>

    <td>
        {{ $card->groom_name ?? 'Chưa có tên' }}
        ❤️
        {{ $card->bride_name ?? 'Chưa có tên' }}
    </td>

    <td>
        Template {{ $card->template_id }}
    </td>

    <td>

        @if($card->is_vip)

            <span class="badge bg-warning text-dark">
                VIP
            </span>

        @else

            <span class="badge bg-secondary">
                FREE
            </span>

        @endif

    </td>

    <td>

        {{ $card->thank_msg ?? 'Chưa có lời chúc' }}

    </td>

</tr>

@empty

<tr>
    <td colspan="4" class="text-center text-muted py-5">
        Chưa có dữ liệu.
    </td>
</tr>

@endforelse

</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection