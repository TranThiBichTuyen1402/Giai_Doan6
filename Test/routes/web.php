<?php

use Illuminate\Support\Facades\Route;
// Nạp file StudentController (bước 3) vào đây
use App\Http\Controllers\StudentController; 
// nếu tạo Cotroller là môn hc thì thêm vào
use App\Http\Controllers\SubjectController; 
//login
use App\Http\Controllers\AuthController;
// 1. Vào link: web/students -> chạy hàm index của StudentController,Hành động gõ link để xem dữ liệu gọi là "get", vào StudentController chạy hàm index
Route::get('/students', [StudentController::class, 'index']);

// 2. ng dùng bấm thêm-> Vào link: web/students/create -> chạy hàm create để mở form nhập, vào StudentController chạy hàm create
Route::get('/students/create', [StudentController::class, 'create']);

//delete
Route::delete('/students/{id}', [StudentController::class, 'delete']);
// 3. Khi bấm nút gửi dữ liệu từ Form đi -> chạy hàm store để lưu, gửi dữ liệu đi "post", vào StudentController chạy hàm store
Route::post('/students', [StudentController::class, 'store']);

//có thêm thêm 
//Route::get('/subject', [SubjectController::class, 'index']);
//Route::get('/subject/create',[SubjectController::class,'create']);

// 1. Khi gõ /login trên trình duyệt -> Dẫn vào hàm hiện giao diện
Route::get('/login', [AuthController::class, 'showLogin']);

// 2. Khi bấm nút "Đăng nhập" trên Form -> Bắn dữ liệu vào hàm xử lý kiểm tra
Route::post('/login', [AuthController::class, 'login']);