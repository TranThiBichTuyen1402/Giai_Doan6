<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa Học Sinh</title>
</head>
<body>
    <h2>Chỉnh sửa thông tin học sinh</h2>

    <form action="/students/{{ $student->id }}" method="POST">
        @csrf
        @method('PUT') <p>
            <label>Tên học sinh:</label>
            <input type="text" name="name" value="{{ $student->name }}" required>
        </p>

        <p>
            <label>Tuổi:</label>
            <input type="number" name="age" value="{{ $student->age }}" required>
        </p>

        <button type="submit">Cập nhật</button>
        <a href="/students">Hủy bỏ</a>
    </form>
</body>
</html>