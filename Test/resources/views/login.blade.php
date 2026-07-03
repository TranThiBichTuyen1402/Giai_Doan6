<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giao Diện Login</title>
</head>
<body>
    <div style="margin: 50px auto; width: 300px; border: 1px solid #ccc; padding: 20px;">
        <h2>🔐 ĐĂNG NHẬP</h2>

        <form action="/login" method="POST">
            @csrf <p>
                <label>Tài khoản (User):</label><br>
                <input type="text" name="username" placeholder="Tên đăng nhập của bạn" required>
            </p>

            <p>
                <label>Mật khẩu (Password):</label><br>
                <input type="password" name="password" placeholder="Nhập mật khẩu" required>
            </p>

            <button type="submit" style="width: 100%; padding: 8px;">Đăng nhập</button>
        </form>
    </div>
</body>
</html>