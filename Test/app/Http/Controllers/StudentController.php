<?php

namespace App\Http\Controllers; //địa chỉ file

use App\Models\Student;  /* Gọi Model Student ở Bước 2 vào để dùng */
use Illuminate\Http\Request;  /* Công cụ lấy dữ liệu từ Form nhập liệu, gom về controller xử lý */

class StudentController extends Controller
{
    // Hàm 1: Lấy danh sách học sinh đổ ra giao diện
    public function index() 
    {
        $dsHocSinh = Student::all();  /* Lấy sạch dữ liệu học sinh từ database */
        return view('students.index', compact('dsHocSinh')); // $dsHocSinh= ('dsHocSinh') phải viết giống
        // có thể dùng hàm compact
        // retun view('students.index', ['students' => $dsHocSinh]);r // Đóng gói $dsHocSinh lại, dán nhãn'students'->file giao diện, để file giao diện in ra cho người dùng.

        }

    // Hàm 2: Mở giao diện Form để nhập học sinh mới
    public function create() 
    {
        return view('students.create'); // Mở giao diện create, khi ng dùng nhấn thêm thì link địa chỉ là web/students/create
       // Ý nghĩa: Hàm này làm một việc cực kỳ đơn giản là mở đúng file giao diện create.blade.php
    }

    // Hàm 3: Nhận dữ liệu từ Form gửi lên để cất vào database
    public function store(Request $request) //gom hết vào trong biến $request
    {
        Student::create([ //Model Student tạo ngay một hàng mới dưới database.
            'name' => $request->input('name'), // Lấy tên nằm trong $request cất vào cột name dưới database.
            'age' => $request->input('age'),   // Lấy tuổi nằm trong $request cất vào cột age dưới database.
        ]);

        return redirect('/students'); // Lưu xong quay về trang danh sách học sinh ban đầu (/students) để nhìn thấy hs vừa thêm xuất hiện trên màn hình.
    }
    // Hàm 5: Xóa học sinh khỏi hệ thống
public function delete($id)
{
    /* cách truyền thống 
    $hocSinhCanXoa = Student::find($id); // 1. Tìm đúng ông học sinh theo ID
    $hocSinhCanXoa->delete();            // 2. Ra lệnh xóa bay màu khỏi database
   */
  //cách gọn
    Student::destroy($id); // Một phát chết luôn
    return redirect('/students'); // 3. Xóa xong, tự F5 quay lại trang danh sách
}
// Hàm 1: Tìm thông tin cũ và ném ra trang Form sửa
public function edit($id)
{
    $dsHocSinh = Student::findOrFail($id); // Tìm đúng 1 ông, không thấy tự hiện lỗi 404
    return view('students.edit', compact('dsHocSinh')); // Mở file edit.blade.php và gửi biến $student qua 
}

// Hàm 2: Hứng dữ liệu mới từ Form gửi lên và lưu đè vào database
public function update(\Illuminate\Http\Request $request, $id)
{
    $dsHocSinh = Student::findOrFail($id); // Tìm lại ông học sinh đó
    
    $dsHocSinh->name = $request->name; // Lấy tên mới đè lên tên cũ
    $dsHocSinh->age = $request->age;   // Lấy tuổi mới đè lên tuổi cũ
    $dsHocSinh->save();                // Lưu lại vào database

    return redirect('/students'); // Sửa xong đuổi về trang danh sách
}
}
