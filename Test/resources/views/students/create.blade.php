<!DOCTYPE html>
<html>
<head><title>Thêm học sinh</title></head> <!-- trên trình duyệt hiện thêm hs -->
<body>
    <h1>Nhập Thông Tin Học Sinh Mới</h1>
    <hr>
    <form action="/students" method="POST"> <!-- gửi dữ liệu về đường link /students -->
        @csrf <!-- bảo mật -->
        <label>Tên học sinh:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Tuổi:</label><br>
        <input type="number" name="age" required><br><br>

        <button type="submit">Lưu lại</button>
    </form>
</body>
</html>
