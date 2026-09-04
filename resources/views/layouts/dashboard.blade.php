<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title','Dashboard')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @stack('styles')

    <style>

        body{
            background:#f5f7fb;
        }

        .sidebar{

            width:260px;

            min-height:100vh;

            background:white;

            border-right:1px solid #eee;

            position:fixed;

            left:0;

            top:0;

            padding:30px;

        }

        .main-content{

            margin-left:260px;

            min-height:100vh;

        }

        .topbar{

            height:75px;

            background:white;

            border-bottom:1px solid #eee;

            display:flex;

            align-items:center;

            justify-content:space-between;

            padding:0 30px;

        }

        .content{

            padding:35px;

        }

        .menu-item{

            display:block;

            padding:13px 16px;

            border-radius:12px;

            color:#444;

            text-decoration:none;

            margin-bottom:8px;

            font-weight:600;

        }

        .menu-item:hover{

            background:#ffe6ef;

            color:#e91e63;

        }

        .menu-active{

            background:#e91e63;

            color:white !important;

        }

    </style>

</head>

<body>

<div class="sidebar">

    <h3 class="fw-bold text-danger mb-4">
        ❤️ Wedding Web
    </h3>

    <a href="{{ route('dashboard') }}"
        class="menu-item menu-active">

        <i class="fa fa-home me-2"></i>

        🏠 Tổng quan

    </a>

   <a href="{{ route('my.cards') }}"
        class="menu-item">

        <i class="fa fa-heart me-2"></i>

        Thiệp của tôi

    </a>

    <a href="{{ route('rsvp.index') }}" 
     class="menu-item">

        <i class="fa fa-heart me-2"></i>

    Quản lý khách mời
</a>



  <a href="{{ route('card.choose') }}" class="btn btn-danger">
    <i class="fa-solid fa-plus"></i>
    Tạo Thiệp
</a>

    <a href="#"
        class="menu-item">

        <i class="fa fa-user me-2"></i>

        Tài khoản

    </a>

    <form action="{{ route('logout') }}"
        method="POST">

        @csrf

        <button
        class="btn btn-outline-danger w-100 mt-4">

            Đăng xuất

        </button>

    </form>

</div>

<div class="main-content">

    <div class="topbar">

        <div>

            <h5 class="mb-0 fw-bold">

                @yield('page-title')

            </h5>

        </div>

        <div>

            Xin chào

            <strong>

                {{ auth()->user()->name }}

            </strong>

            👋

        </div>

    </div>

    <div class="content">

        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>