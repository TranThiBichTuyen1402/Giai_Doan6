@extends('layouts.admin.app')

@section('title', 'Quản Lý Bài Viết - WedPlan Hub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@endpush

@section('content')
<main class="p-4 container-fluid">
    <div class="card card-custom shadow-sm bg-white p-4">
        <h4 class="fw-bold mb-3">Trang Quản Lý Toàn Bộ Bài Viết</h4>
        <p class="text-secondary mb-0">
            Giao diện danh sách bài viết, bộ lọc và các nút thêm/sửa/xóa bài viết sẽ hiển thị tại đây.
        </p>
    </div>
</main>
@endsection