<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuthController;

// Client Controllers
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\WeddingCardController;
use App\Http\Controllers\Client\WeddingRsvpController;
 use App\Http\Controllers\Client\TableController;
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

// Route::middleware('auth')->group(function () {

//     Route::get('/dashboard', [DashboardController::class, 'index'])
//         ->name('dashboard');

// });

Route::middleware('auth')->group(function () {

    // Dashboard tổng quan
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Thiệp của tôi
    Route::get('/thiep-cua-toi', [DashboardController::class, 'myCards'])
    ->name('my.cards');

    // Danh sách RSVP của thiệp
    Route::get('/danh-sach-rsvp', [DashboardController::class, 'rsvpList'])->name('rsvp.index');

// Quản lý bàn tiệc
Route::middleware(['auth'])->group(function () {
    Route::get('/ban-tiec', [TableController::class, 'index'])->name('client.tables.index');
    Route::post('/ban-tiec', [TableController::class, 'store'])->name('client.tables.store');
    Route::delete('/ban-tiec/{id}', [TableController::class, 'destroy'])->name('client.tables.destroy');
    Route::post('/ban-tiec/assign-guest', [TableController::class, 'assignGuest'])->name('client.tables.assignGuest');
});
Route::post('/wedding-tables', [DashboardController::class, 'storeTable'])->name('wedding_tables.store');
Route::patch('/wedding-rsvps/{id}/assign-table', [DashboardController::class, 'assignTable'])->name('wedding_rsvps.assignTable');
});
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


        /*
        |--------------------------------------------------------------------------
        | BÀI VIẾT
        |--------------------------------------------------------------------------
        |
        | Hiện tại mới có giao diện.
        | Chưa làm CRUD bài viết.
        |
        */

        Route::get('/bai-viet', function () {
            return view('admin.posts');
        })->name('posts');


        /*
        |--------------------------------------------------------------------------
        | RSVP / KHÁCH MỜI
        |--------------------------------------------------------------------------
        |
        | Hiện tại mới có giao diện.
        | Chưa làm logic RSVP.
        |
        */

        Route::get('/khach-moi', function () {
            return view('admin.rsvp');
        })->name('rsvp');

    });


/*
|--------------------------------------------------------------------------
| BUILDER THIỆP
|--------------------------------------------------------------------------
|
| Hỗ trợ:
| /builder
| /builder/1
| /builder/2
| /builder/3
|
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
    ->name('wedding.upgrade_vip');

// Webhook thanh toán
Route::post('/api/webhook/payment', [WeddingCardController::class, 'handlePaymentWebhook']);

//nhấn nút "Chọn thiệp" trên trang dashboard
Route::get('/chon-mau-thiep', [WeddingCardController::class, 'chooseTemplate'])
    ->name('card.choose');

Route::post(
    '/wedding-invitation/{slug}/rsvp',
    [WeddingRsvpController::class, 'store']
)->name('wedding.rsvp');
Route::get('/search-table', [InvitationController::class, 'searchTable'])->name('rsvp.searchTable');