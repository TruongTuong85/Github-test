<?php
include 'db.php';

// Lấy thông tin người dùng dựa trên ID
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM nguoidung WHERE id = ?");
$stmt->execute([$id]);
$nguoidung = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$nguoidung) {
    die("Người dùng không tồn tại!");
}

// Xử lý form khi người dùng submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoten = $_POST['hoten'];
    $email = $_POST['email'];
    $sodienthoai = $_POST['sodienthoai'];  // Nhận số điện thoại từ form

    // Nếu mật khẩu được nhập, cập nhật mật khẩu
    if (!empty($_POST['matkhau'])) {
        $matkhau = password_hash($_POST['matkhau'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE nguoidung SET hoten = ?, email = ?, sodienthoai = ?, matkhau = ? WHERE id = ?");
        $stmt->execute([$hoten, $email, $sodienthoai, $matkhau, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE nguoidung SET hoten = ?, email = ?, sodienthoai = ? WHERE id = ?");
        $stmt->execute([$hoten, $email, $sodienthoai, $id]);
    }
    
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sửa Người Dùng</title>
</head>
<body>
    <h1>Sửa Người Dùng</h1>
    <form method="post">
        <label for="hoten">Tên Người Dùng:</label>   
        <input type="text" id="hoten" name="hoten" value="<?php echo htmlspecialchars($nguoidung['hoten']); ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($nguoidung['email']); ?>" required>

        <br>

        <label for="sodienthoai">SĐT:</label>
        <input type="sodienthoai" id="sodienthoai" name="sodienthoai" value="<?php echo htmlspecialchars($nguoidung['sodienthoai']); ?>" required>

        <label for="matkhau">Mật Khẩu (Để trống nếu không muốn đổi):</label>
        <input type="matkhau" id="matkhau" name="matkhau"><br>
        <button type="submit">Cập Nhật</button>
    </form>
</body>
</html>