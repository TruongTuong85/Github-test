<?php
require("../../model/database.php");
require("../../model/nguoidung.php");
// Biến $isLogin cho biết người dùng đăng nhập chưa
$isLogin = isset($_SESSION["nguoidung"]);
// Kiểm tra hành động $action: yêu cầu đăng nhập nếu chưa xác thực
if(isset($_REQUEST["action"])){
$action = $_REQUEST["action"];
}
elseif($isLogin == FALSE){
$action = "dangnhap";
}
else{
$action="macdinh";
}
$nd = new NGUOIDUNG();
switch($action){
case "macdinh":
    include("main.php");
    break;
case "dangnhap":
    include("login.php");
    break;
case "xldangnhap":
    $email = $_POST["txtemail"];
    $matkhau = $_POST["txtmatkhau"];
    if($nd->kiemtranguoidunghople($email,$matkhau)==TRUE){
        $_SESSION["nguoidung"] = $nd->laythongtinnguoidung($email); //Muốn thêm điều kiện thì ["nguoidung"][...]
    include("main.php");
    }
    else{
    include("login.php");
    }
    break;
case "dangxuat":
    unset($_SESSION["nguoidung"]);
    include("login.php");
    break;
case "hoso":
    include("profile.php");
    break;
case "xlhoso":
        $mand = $_POST["txtid"];
        $email = $_POST["txtemail"]; 
        $sodt = $_POST["txtdienthoai"]; 
        $hoten = $_POST["txthoten"];
        $hinhanh = $_POST["txthinhanh"];
        if ($_FILES["fhinh"]["name"] != null) {
            $hinhanh = basename($_FILES["fhinh"]["name"]); 
            $duongdan ="../../images/users/". $hinhanh;
            move_uploaded_file($_FILES["fhinh"]["tmp_name"], $duongdan);
        }
            $nd->capnhatnguoidung ($mand, $email, $sodt, $hoten, $hinhanh);
            $_SESSION["nguoidung"]  = $nd->laythongtinnguoidung ($email);
            include("main.php");
            break;
            

default:
    break;


  // Khởi động session nếu cần
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Kiểm tra hành động gửi form
        if (isset($_POST['action']) && $_POST['action'] === 'xlhoso') {
            // Kiểm tra từng trường dữ liệu
            $id = $_POST['txtid'] ?? null;
            $email = $_POST['txtemail'] ?? '';
            $dienthoai = $_POST['txtdienthoai'] ?? '';
            $hoten = $_POST['txthoten'] ?? '';
            $hinhanh = $_POST['txthinhanh'] ?? '';
    
            // Ghi log để debug (tuỳ chọn)
            error_log("Form nhận được: ID = $id, Email = $email, SĐT = $dienthoai, Họ tên = $hoten", 3, "form_debug.log");
    
            // Kiểm tra dữ liệu hợp lệ (ví dụ kiểm tra email)
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Email không hợp lệ!");
            }
    
            // Xử lý thêm các kiểm tra khác nếu cần
            // ...
    
            // Nếu có tệp hình ảnh được tải lên
            if (isset($_FILES['fhinh']) && $_FILES['fhinh']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../../images/users/';
                $fileName = basename($_FILES['fhinh']['name']);
                $targetFilePath = $uploadDir . $fileName;
    
                // Kiểm tra và di chuyển file tải lên
                if (!move_uploaded_file($_FILES['fhinh']['tmp_name'], $targetFilePath)) {
                    die("Không thể tải tệp hình ảnh.");
                }
    
                $hinhanh = $fileName; // Cập nhật đường dẫn tệp hình ảnh
            }
    
            // Sau khi kiểm tra, thực hiện cập nhật vào cơ sở dữ liệu
            $sql = "UPDATE nguoidung SET email = ?, sodienthoai = ?, hoten = ?, hinhanh = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssi', $email, $dienthoai, $hoten, $hinhanh, $id);
    
            if ($stmt->execute()) {
                echo "Cập nhật thành công!";
            } else {
                die("Lỗi khi cập nhật dữ liệu: " . $stmt->error);
            }
        } else {
            die("Hành động không hợp lệ!");
        }
    } else {
        die("Yêu cầu không hợp lệ!");
    }
    
    
    
}
?>