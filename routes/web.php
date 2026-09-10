<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;

// Client Controllers
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\WeddingCardController;
use App\Http\Controllers\Client\WeddingRsvpController;
use App\Http\Controllers\Client\TableController;
use App\Http\Controllers\Client\GalleryController;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WeddingCardController as AdminWeddingCardController;


/*
|--------------------------------------------------------------------------
| TRANG CHỦ
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('trangchu');
})->name('home');

Route::get('/trang-chu', function () {
    return view('trangchu');
});


/*
|--------------------------------------------------------------------------
| LOGIN / REGISTER
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return redirect('/trang-chu?action=login');
})->name('login');

Route::get('/register', function () {
    return redirect('/trang-chu?action=register');
})->name('register');


/*
|--------------------------------------------------------------------------
| XỬ LÝ ĐĂNG NHẬP / ĐĂNG KÝ
|--------------------------------------------------------------------------
*/

Route::post('/api/auth', [AuthController::class, 'handleAuth']);


/*
|--------------------------------------------------------------------------
| ĐĂNG XUẤT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/trang-chu');

})->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD CLIENT
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard tổng quan
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Thiệp của tôi
    Route::get('/thiep-cua-toi', [DashboardController::class, 'myCards'])->name('my.cards');

    // Danh sách RSVP của thiệp
    Route::get('/danh-sach-rsvp', [DashboardController::class, 'rsvpList'])->name('rsvp.index');

    // Quản lý Bàn Tiệc (Xử lý qua DashboardController)
    Route::post('/wedding-tables', [DashboardController::class, 'storeTable'])->name('wedding_tables.store');
    Route::patch('/wedding-rsvps/{id}/assign-table', [DashboardController::class, 'assignTable'])->name('wedding_rsvps.assignTable');

    // Thêm & Xóa Khách
    Route::post('/wedding-rsvps', [WeddingRsvpController::class, 'storeAdmin'])->name('wedding_rsvps.store');
    Route::put('/wedding-rsvps/{id}', [WeddingRsvpController::class, 'update'])->name('wedding_rsvps.update');
    Route::delete('/wedding-rsvps/{id}', [DashboardController::class, 'destroyRsvp'])->name('wedding_rsvps.destroy');

    // Route quản lý Lời chúc & Voice
    // Route::get('/dashboard/wishes', [WishController::class, 'index'])->name('wishes.index');
    Route::delete('/wishes/{id}', [DashboardController::class, 'destroyWish'])->name('wishes.destroy');

    // Route quản lý Kho ảnh khách chụp (Moments)
    // Route::get('/dashboard/moments', [MomentController::class, 'index'])->name('moments.index');
    Route::post('/dashboard/moments', [DashboardController::class, 'storeMoment'])->name('moments.store');
    Route::delete('/dashboard/moments/{id}', [DashboardController::class, 'destroyMoment'])->name('moments.destroy');

    // Route quản lý Mừng cưới & QR Bank
    // Route::get('/dashboard/money', [MoneyController::class, 'index'])->name('money.index');
    Route::post('/dashboard/bank-info', [DashboardController::class, 'updateBankInfo'])->name('bank.update');

    // Xóa Thiệp Cưới
    Route::delete('/thiep-cua-toi/{id}', [DashboardController::class, 'destroyCard'])->name('card.destroy');


    Route::post('/rsvp/import', [App\Http\Controllers\Client\WeddingRsvpController::class, 'importExcel'])->name('wedding_rsvps.import');
    Route::get('/rsvp/download-sample', [WeddingRsvpController::class, 'downloadSampleExcel'])->name('wedding_rsvps.download_sample');
}); // <-- ĐÃ THÊM DẤU ĐÓNG NGOẶC CÒN THIẾU Ở ĐÂY


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
|
| Tất cả route /admin đều yêu cầu:
| - Đăng nhập
| - Có quyền admin
|
|--------------------------------------------------------------------------
*/

Route::redirect('/admin', '/admin/dashboard');

Route::middleware(['auth', 'isAdmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | QUẢN LÝ KHÁCH HÀNG
        |--------------------------------------------------------------------------
        */

        // Danh sách khách hàng
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');

        // Form thêm khách hàng
        Route::get('/users/create', [UserController::class, 'create'])
            ->name('users.create');

        // Lưu khách hàng
        Route::post('/users/store', [UserController::class, 'store'])
            ->name('users.store');

        // Form sửa khách hàng
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])
            ->name('users.edit');

        // Cập nhật khách hàng
        Route::put('/users/{user}', [UserController::class, 'update'])
            ->name('users.update');

        Route::delete('/wedding-cards/{card}', [AdminWeddingCardController::class, 'destroy'])
            ->name('wedding-cards.destroy');


        /*
        |--------------------------------------------------------------------------
        | QUẢN LÝ THIỆP CƯỚI
        |--------------------------------------------------------------------------
        */

        // Danh sách thiệp
        Route::get('/wedding-cards', [AdminWeddingCardController::class, 'index'])
            ->name('wedding-cards.index');

        // Xem chi tiết thiệp
        Route::get('/wedding-cards/{card}', [AdminWeddingCardController::class, 'show'])
            ->name('wedding-cards.show');

        // Form sửa thiệp
        Route::get('/wedding-cards/{card}/edit', [AdminWeddingCardController::class, 'edit'])
            ->name('wedding-cards.edit');


        // Danh sách thiệp
        Route::get('/wedding-cards', [AdminWeddingCardController::class, 'index'])
            ->name('wedding-cards.index');

        // Kích hoạt / Hủy VIP thủ công (MỚI THÊM)
        Route::patch('/wedding-cards/{id}/toggle-vip', [AdminWeddingCardController::class, 'toggleVip'])
            ->name('wedding-cards.toggle_vip');

        // Xem chi tiết thiệp
        Route::get('/wedding-cards/{card}', [AdminWeddingCardController::class, 'show'])
            ->name('wedding-cards.show');
        /*
        |--------------------------------------------------------------------------
        | BÀI VIẾT
        |--------------------------------------------------------------------------
        */

        Route::get('/bai-viet', function () {
            return view('admin.posts');
        })->name('posts');


        /*
        |--------------------------------------------------------------------------
        | RSVP / KHÁCH MỜI
        |--------------------------------------------------------------------------
        */

        Route::get('/khach-moi', function () {
            return view('admin.rsvp');
        })->name('rsvp');

    });


/*
|--------------------------------------------------------------------------
| BUILDER THIỆP
|--------------------------------------------------------------------------
*/

Route::get('/builder/{template_id?}', [WeddingCardController::class, 'index'])
    ->name('card.builder');


/*
|--------------------------------------------------------------------------
| LƯU THIỆP
|--------------------------------------------------------------------------
*/

Route::post('/api/save-wedding-card', [WeddingCardController::class, 'store'])
    ->name('wedding.store');

Route::post('/save-wedding-card', [WeddingCardController::class, 'save']);


/*
|--------------------------------------------------------------------------
| HIỂN THỊ THIỆP CÔNG KHAI
|--------------------------------------------------------------------------
*/

// Thiệp mẫu
Route::get('/wedding-invitation/sample', [WeddingCardController::class, 'showSampleCard'])
    ->name('wedding.sample');

// Thiệp thật
Route::get('/wedding-invitation/{slug}', [WeddingCardController::class, 'showPublicCard'])
    ->name('wedding.show');

// Route cho Khách mời tải ảnh kỷ niệm lên thiệp
Route::post('/wedding-invitation/{id}/guest-upload-photo', [App\Http\Controllers\Client\DashboardController::class, 'guestUploadPhoto'])->name('guest.upload_photo');
// Demo
Route::get('/demo/{id}', [WeddingCardController::class, 'demo'])
    ->name('card.demo');


/*
|--------------------------------------------------------------------------
| VIP / THANH TOÁN
|--------------------------------------------------------------------------
*/

// Kích hoạt VIP
Route::post('/api/wedding/upgrade-vip', [WeddingCardController::class, 'upgradeToVip'])
    ->name('wedding.upgradeVip');
// Webhook thanh toán
Route::post('/api/webhook/payment', [WeddingCardController::class, 'handlePaymentWebhook']);

// Nhấn nút "Chọn thiệp" trên trang dashboard
Route::get('/chon-mau-thiep', [WeddingCardController::class, 'chooseTemplate'])
    ->name('card.choose');

Route::post(
    '/wedding-invitation/{slug}/rsvp',
    [WeddingRsvpController::class, 'store']
)->name('wedding.rsvp');

// ROUTE DÀNH CHO KHÁCH TRA CỨU
Route::get('/search-table', [TableController::class, 'findSeat'])->name('rsvp.searchTable');
