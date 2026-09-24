<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 

Route::get('/trang-chu', function () {
    return view('trangchu'); // Đổi từ 'home' thành 'welcome'
})->name('home');

Route::get('/demo/thanh-lich', function () {
    return view('demo-elegant');
})->name('demo.elegant');

// Demo mẫu thiệp
Route::get('/templates/elegant', function () {
    return view('demo-elegant');
})->name('templates.elegant');

// Danh sách tất cả mẫu
Route::get('/templates', function () {
    return view('templates');
})->name('templates');

// Trang tạo thiệp (tạm)
Route::get('/create', function () {
    return "Trang tạo thiệp";
})->name('create');

Route::get('/rsvp', function () {
    return view('rsvp');
})->name('rsvp');