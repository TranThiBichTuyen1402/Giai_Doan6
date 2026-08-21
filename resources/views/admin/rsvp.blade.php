@extends('layouts.admin.app')

@section('title', 'Quản Lý Bài Viết - WedPlan Hub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@endpush

@section('content')
   
    <!-- Content -->
    <div class="content">

        <!-- Header -->
        <header class="bg-white border-bottom p-4">

            <h4 class="mb-0 fw-bold">
                Danh Sách Khách Phản Hồi (RSVP)
            </h4>

        </header>

        <!-- Main -->
        <main class="p-4">

            <div class="card card-custom shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Quản lý phản hồi tham dự đám cưới
                    </h5>

                    <p class="text-secondary mb-0">
                        Toàn bộ danh sách khách xác nhận tham dự, vắng mặt, số lượng người đi cùng và các bộ lọc thống kê sẽ được hiển thị tại đây.
                    </p>

                </div>

            </div>

        </main>

    </div>
    @endsection