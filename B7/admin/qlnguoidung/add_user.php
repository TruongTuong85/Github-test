<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ biểu mẫu
    $hoten = $_POST['hoten'];
    $email = $_POST['email'];
    $sodienthoai = $_POST['sodienthoai']; // Lấy số điện thoại
    $MatKhau = $_POST['MatKhau'];

    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $dbname = "shop"; // Đổi tên database của bạn
    $dbuser = "root";          // Tên người dùng MySQL
    $dbpass = "";              // Mật khẩu MySQL

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $dbuser, $dbpass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Mã hóa mật khẩu trước khi lưu vào database
        $hashedPassword = password_hash($MatKhau, PASSWORD_BCRYPT);

        // Thêm người dùng vào cơ sở dữ liệu
        $sql = "INSERT INTO nguoidung (hoten, email, sodienthoai, MatKhau) VALUES (:hoten, :email, :sodienthoai, :MatKhau)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':hoten', $hoten);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':sodienthoai', $sodienthoai);
        $stmt->bindParam(':MatKhau', $hashedPassword);

        if ($stmt->execute()) {
            // Đăng ký thành công, chuyển hướng sang trang index.php
            header("Location: index.php");
            exit(); // Đảm bảo không thực thi thêm mã nào sau đây
        } else {
            echo "<script>alert('Có lỗi xảy ra, vui lòng thử lại.');</script>";
        }
    } catch (PDOException $e) {
        echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm Người Dùng</title>
    <style>
       /* Reset some default styles */
body, h1, label, button, input {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

h1 {
    font-size: 24px;
    text-align: center;
    color: #555;
    margin-bottom: 20px;
}

form {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px 30px;
    width: 100%;
    max-width: 400px;
}

label {
    display: block;
    font-size: 14px;
    margin-bottom: 8px;
    color: #555;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    transition: border-color 0.2s ease-in-out;
}

input:focus {
    border-color: #007BFF;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

button {
    background-color: #007BFF;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

form {
    text-align: center;
}


    </style>
</head>
<body>
  
    <form method="post">
    <h1>Thêm Người Dùng</h1>
        <label for="hoten">Tên Người Dùng:</label>
        <input type="text" id="hoten" name="hoten" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="email">Số Điện Thoại:</label>
        <input type="sodienthoai" id="sodienthoai" name="sodienthoai" required><br>
        <label for="MatKhau">Mật Khẩu:</label>
        <input type="MatKhau" id="MatKhau" name="MatKhau" required><br>
        <button type="submit">Thêm</button>
    </form>
</body>
</html>
