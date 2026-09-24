@extends('layouts.dashboard')

@section('title', 'Thông tin tài khoản')
@section('page-title', '💌 Thông tin tài khoản')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4 text-danger"><i class="bi bi-person-circle me-2"></i>Thông tin tài khoản của bạn</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <!-- Thông tin cá nhân -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <h5 class="fw-bold fs-6 mb-3">Thông tin cá nhân</h5>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small">Họ và tên</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Email (Không thể sửa)</label>
                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone ?? '' }}">
                    </div>
                    <button type="submit" class="btn btn-danger btn-sm">Lưu thay đổi</button>
                </form>
            </div>
        </div>

        <!-- Đổi mật khẩu -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3">
                <h5 class="fw-bold fs-6 mb-3">Đổi mật khẩu</h5>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label small">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Mật khẩu mới</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Xác nhận mật khẩu mới</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-outline-danger btn-sm">Cập nhật mật khẩu</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection