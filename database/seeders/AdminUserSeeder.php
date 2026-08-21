<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Thêm dòng này để dùng Query Builder
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Xóa sạch các tài khoản admin cũ trùng email nếu có để tránh lỗi trùng lặp
        DB::table('users')->where('email', 'admin@gmail.com')->delete();

        // Dùng DB::table để ép buộc chèn thẳng vào Database không sợ bị nghẽn ở Model
        DB::table('users')->insert([
    'name' => 'Quản Trị Viên',
    'email' => 'admin@gmail.com',
    'password' => Hash::make('12345678'),
    'role' => 'admin', // Tài khoản này là ADMIN
    'created_at' => now(),
    'updated_at' => now(),
]);
    }
}