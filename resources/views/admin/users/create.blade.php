<!-- file này tạm thời để lại nhưng chưa dùng, Sau này nếu bạn muốn có Nhân viên (Staff) thì sẽ dùng lại. -->
@extends('layouts.admin.app')

@section('title', 'Thêm người dùng')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h4 class="fw-bold mb-0">
                Thêm người dùng
            </h4>

        </div>

        <div class="card-body">

            <form action="#" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ tên</label>
                        <input type="text"
                               name="name"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="password"
                               name="password"
                               class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Role</label>

                        <select name="role" class="form-select">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>

                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Membership</label>

                        <select name="membership" class="form-select">
                            <option value="free">Free</option>
                            <option value="vip">VIP</option>
                        </select>

                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>

                    </div>

                </div>

                <hr>

                <button class="btn btn-danger">
                    Lưu người dùng
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