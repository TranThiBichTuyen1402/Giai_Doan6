@extends('layouts.admin.app')

@section('title', 'Cập nhật khách hàng')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h4 class="fw-bold mb-0">
                Cập nhật khách hàng
            </h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">

    <label class="form-label fw-bold">
        Gói thành viên
    </label>

    @if($user->membership == 'vip')

        <div class="alert alert-warning d-flex justify-content-between align-items-center">

            <div>
                <i class="fa-solid fa-crown text-warning me-2"></i>

                Khách hàng đang sử dụng
                <strong>Gói VIP</strong>

            </div>

            <button
                type="submit"
                name="membership"
                value="free"
                class="btn btn-outline-danger">

                Hủy VIP

            </button>

        </div>

    @else

        <div class="alert alert-light border d-flex justify-content-between align-items-center">

            <div>

        <i class="fa-regular fa-user me-2"></i>
                Khách hàng đang sử dụng
                <strong>Gói FREE</strong>

            </div>

            <button
                type="submit"
                name="membership"
                value="vip"
                class="btn btn-warning">

                <i class="fa-solid fa-crown me-1"></i>

                Kích hoạt VIP

            </button>

        </div>

@endif
</div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng thái</label>

                        <select name="status" class="form-select">

                            <option value="1"
                                {{ $user->status ? 'selected' : '' }}>
                                Hoạt động
                            </option>

                            <option value="0"
                                {{ !$user->status ? 'selected' : '' }}>
                                Đã khóa
                            </option>

                        </select>

                    </div>

                </div>

                <hr>

                <button class="btn btn-danger">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Lưu thay đổi
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-secondary">
                    Quay lại
                </a>

            </form>

        </div>

    </div>

</div>

@endsection