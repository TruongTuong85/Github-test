<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Lấy ID từ URL và chuyển đổi thành số nguyên

    try {
        // Chuẩn bị câu lệnh xóa
        $stmt = $pdo->prepare("DELETE FROM nguoidung WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Nếu xóa thành công, chuyển hướng sang trang index.php
            header("Location: index.php?message=success");
            exit();
        } else {
            // Nếu xảy ra lỗi khi xóa, cũng chuyển hướng với thông báo lỗi
            header("Location: index.php?message=error");
            exit();
        }
    } catch (PDOException $e) {
        // Hiển thị lỗi nếu không thể thực hiện truy vấn
        echo "Lỗi: " . $e->getMessage();
    }
} else {
    // Nếu không có ID trong URL, chuyển hướng về index.php
    header("Location: index.php");
    exit();
}
