<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang chính</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Chào mừng, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="qlnguoidung/index.php" class="btn btn-primary">Quản lý người dùng</a>
        <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
    </div>
</body>
</html>