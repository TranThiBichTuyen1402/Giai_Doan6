@extends('layouts.admin.app')

@section('title', 'Quản lý người dùng')

@section('content')

<div class="container py-4">

    {{-- Tiêu đề --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Quản lý khách hàng
            </h3>

            <small class="text-muted">
                Quản lý khách hàng sử dụng WedPlan Hub
            </small>
        </div>

    </div>


    {{-- Danh sách khách hàng --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h5 class="mb-0 fw-bold">
                Danh sách khách hàng
            </h5>

        </div>


        {{-- Tìm kiếm --}}
        <div class="card-body border-bottom">

            <form method="GET"
                  action="{{ route('admin.users.index') }}">

                <div class="row g-2">

                    <div class="col-md-6">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            value="{{ request('search') }}"
                            placeholder="Tìm theo tên hoặc email..."
                        >

                    </div>

                    <div class="col-md-auto">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="fa-solid fa-magnifying-glass me-1"></i>

                            Tìm kiếm

                        </button>

                    </div>

                    @if(request('search'))

                        <div class="col-md-auto">

                            <a href="{{ route('admin.users.index') }}"
                               class="btn btn-outline-secondary">

                                <i class="fa-solid fa-rotate-left me-1"></i>

                                Xóa lọc

                            </a>

                        </div>

                    @endif

                </div>

            </form>

        </div>


        {{-- Bảng khách hàng --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>STT</th>

                            <th>Avatar</th>

                            <th>Họ tên</th>

                            <th>Email</th>

                            <th>Membership</th>

                            <th>Số thiệp</th>

                            <th>Ngày đăng ký</th>

                            <th>Status</th>

                            <th width="160">Thao tác</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($users as $user)

                        <tr>

                            {{-- STT --}}
                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>


                            {{-- Avatar --}}
                            <td>

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                                    width="40"
                                    height="40"
                                    class="rounded-circle"
                                    alt="Avatar"
                                >

                            </td>


                            {{-- Họ tên --}}
                            <td>

                                {{ $user->name }}

                            </td>


                            {{-- Email --}}
                            <td>

                                {{ $user->email }}

                            </td>


                            {{-- Membership --}}
                            <td>

                                @if($user->membership == 'vip')

                                    <span class="badge bg-warning text-dark">
                                        VIP
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        FREE
                                    </span>

                                @endif

                            </td>


                            {{-- Số thiệp --}}
                            <td>

                                {{ $user->wedding_cards_count }}

                            </td>


                            {{-- Ngày đăng ký --}}
                            <td>

                                {{ $user->created_at->format('d/m/Y') }}

                            </td>


                            {{-- Status --}}
                            <td>

                                @if($user->status)

                                    <span class="badge bg-success">
                                        Hoạt động
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Đã khóa
                                    </span>

                                @endif

                            </td>


                            {{-- Thao tác --}}
                            <td>

                                <a
                                    href="{{ route('admin.users.edit', $user->id) }}"
                                    class="btn btn-warning btn-sm"
                                    title="Chỉnh sửa"
                                >

                                    <i class="fa-solid fa-pen"></i>

                                </a>


                                <a
                                    href="#"
                                    class="btn btn-danger btn-sm"
                                    title="Xóa"
                                >

                                    <i class="fa-solid fa-trash"></i>

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center py-5 text-muted">

                                <i class="fa-solid fa-user-slash fa-2x mb-2"></i>

                                <div>
                                    Không tìm thấy khách hàng.
                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- Phân trang --}}
    @if($users->hasPages())

        <div class="mt-3">

            {{ $users->links() }}

        </div>

    @endif

</div>

@endsection