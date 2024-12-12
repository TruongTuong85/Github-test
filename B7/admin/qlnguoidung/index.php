<?php include("../inc/top.php"); ?>
<?php
include 'db.php';
if(!isset($_SESSION["nguoidung"])) {  
    header("location:../index.php");  
}
// Lấy danh sách người dùng
$stmt = $pdo->query("SELECT * FROM nguoidung");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Người Dùng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .action-links a {
            margin: 0 10px;
            color: #e74c3c;
            font-size: 14px;
        }

        .action-links a:hover {
            color: #c0392b;
        }

        .add-user {
            display: inline-block;
            background-color: #2ecc71;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .add-user:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản Lý Người Dùng</h1>
        <a href="add_user.php" class="add-user">Thêm Người Dùng</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Người Dùng</th>
                    <th>Email</th>
                    <th>Số Điện Thoại</th>
                    <th>Loại Quyền</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['hoten']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo htmlspecialchars($user['sodienthoai']); ?></td>
                        <td>
                            <?php
                            switch ($user['loai']) {
                                case 1:
                                    echo 'Quản trị';
                                    break;
                                case 2:
                                    echo 'Nhân viên';
                                    break;
                                case 3:
                                    echo 'Khách hàng';
                                    break;
                                default:
                                    echo 'Không xác định';
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo ($user['trangthai'] == 1) ? 'Trạng thái' : 'Không xác định';
                            ?>
                        </td>

                        <td class="action-links">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Sửa</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">Xóa</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include("../inc/bottom.php"); ?>
</body>
</html>
