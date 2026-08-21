<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WedPlan Hub - Hệ Thống Quản Trị')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #fcf8f8;
        }
        .card-custom {
            border: 1px solid #fce4e6;
            border-radius: 12px;
        }
        .dropdown-menu-custom {
            font-size: 0.75rem;
            border-color: #fce4e6;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .dropdown-item-custom {
            padding: 6px 16px;
            font-weight: 500;
        }
        .dropdown-item-custom:hover {
            background-color: #ffeef2;
            color: #d63384;
        }
    </style>

    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top px-4" style="height: 68px; border-color: #fce4e6 !important;">
        <div class="container-fluid p-0">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <div class="rounded-3 text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px; background: linear-gradient(to top right, #e06, #f06) !important;">
                    <i class="fa-solid fa-heart text-xs"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.85rem;">WedPlan Hub</h6>
                    <small class="text-uppercase text-danger fw-bold d-block" style="font-size: 0.55rem; letter-spacing: 0.5px;">Hệ Thống Quản Trị 2026</small>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#topNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ms-lg-4" id="topNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1" style="font-size: 0.8rem; font-weight: 600;">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-solid fa-id-card me-1 text-secondary"></i> Quản lý Thiệp</a>
                        <ul class="dropdown-menu dropdown-menu-custom">
<li>
    <a class="dropdown-item dropdown-item-custom"
       href="{{ route('admin.wedding-cards.index') }}">
        Danh sách thiệp
    </a>
</li>                            <li><a class="dropdown-item dropdown-item-custom" href="#">Mẫu thiệp cưới</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-solid fa-ring me-1 text-secondary"></i> Đám cưới</a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom" href="#">Khách mời RSVP</a></li>
                        </ul>
                    </li>

                   
                </ul>

                <div class="d-flex align-items-center gap-3 ms-auto">
                    <button class="btn btn-light position-relative rounded-circle border" style="width:42px;height:42px;">
                        <i class="fa-solid fa-bell"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </button>

                    <div class="dropdown">
                        <button class="btn dropdown-toggle border-0 d-flex align-items-center" data-bs-toggle="dropdown">
                            <div class="me-3 text-end d-none d-md-block">
                                <div style="font-size:12px" class="text-muted">Xin chào,</div>
                                <div class="fw-bold" style="font-size:13px">{{ auth()->user()->name ?? 'Quản Trị Viên' }}</div>
                                <small class="text-success" style="font-size:10px">● Online</small>
                            </div>
                            <div class="rounded-circle bg-danger text-white d-flex justify-content-center align-items-center" style="width:38px;height:38px;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><span class="dropdown-item-text fw-bold text-muted" style="font-size: 12px;">{{ auth()->user()->email ?? '' }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-user me-2"></i>Hồ sơ</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fa fa-gear me-2"></i>Cài đặt</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-right-from-bracket me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <main class="flex-grow-1 py-4">
        <div class="container-fluid px-4">
            @yield('content')
        </div>
    </main>

    <footer class="text-center py-3 bg-white border-top mt-auto">
        <div class="fw-bold" style="font-size: 0.85rem;">WedPlan Hub © 2026</div>
        <small class="text-muted" style="font-size: 0.75rem;">Version 1.0 | Laravel 12 | Bootstrap 5</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>