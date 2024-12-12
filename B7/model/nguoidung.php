<?php
class NGUOIDUNG{
    private $id;
    private $email;
    private $sodt;
    private $matkhau;
    private $hoten;
    private $loai;
    private $trangthai;
    private $hinhanh;

    public function getid(){
        return $this->id;
    }

    public function setid($value){
        $this->id = $value;
    }

    public function getemail(){
        return $this->email;
    }

    public function setemail($value){
        $this->id = $value;
    }

    public function getsodt(){
        return $this->sodt;
    }

    public function setsodt($value){
        $this->id = $value;
    }

    public function getmatkhau(){
        return $this->matkhau;
    }

    public function setmatkhau($value){
        $this->id = $value;
    }

    public function gethoten(){
        return $this->hoten;
    }

    public function sethoten($value){
        $this->id = $value;
    }

    public function getloai(){
        return $this->loai;
    }

    public function setloai($value){
        $this->id = $value;
    }

    public function gettrangthai(){
        return $this->trangthai;
    }

    public function settrangthai($value){
        $this->id = $value;
    }

    public function gethinhanh(){
        return $this->hoten;
    }

    public function sethinhanh($value){
        $this->id = $value;
    }


    // khai báo các thuộc tính (SV tự viết)
    public function kiemtranguoidunghople($email,$matkhau){
    $db = DATABASE::connect();
    try{
        $sql = "SELECT * FROM nguoidung WHERE email=:email AND
        matkhau=:matkhau AND trangthai=1";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(":email", $email);
        $cmd->bindValue(":matkhau", md5($matkhau));
        $cmd->execute();
        $valid = ($cmd->rowCount () == 1);
        $cmd->closeCursor ();
        return $valid;
        }
        catch(PDOException $e){
        $error_message=$e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
        }
    }
// lấy thông tin người dùng có $email
public function laythongtinnguoidung($email){
    $db = DATABASE::connect();
    try{
    $sql = "SELECT * FROM nguoidung WHERE email=:email";
    $cmd = $db->prepare($sql);
    $cmd->bindValue(":email", $email);
    $cmd->execute();
    $ketqua = $cmd->fetch();
    $cmd->closeCursor();
    return $ketqua;
    }
    catch(PDOException $e){
    $error_message=$e->getMessage();
    echo "<p>Lỗi truy vấn: $error_message</p>";
    exit();
    }
}
// lấy tất cả ng dùng
public function laydanhsachnguoidung(){
    $db = DATABASE::connect();
    try{
    $sql = "SELECT * FROM nguoidung";
    $cmd = $db->prepare($sql);
    $cmd->execute();
    $ketqua = $cmd->fetchAll();
    return $ketqua;
    }
    catch(PDOException $e){
    $error_message=$e->getMessage();
    echo "<p>Lỗi truy vấn: $error_message</p>";
    exit();
    }
}
// Thêm ng dùng mới, trả về khóa của dòng mới thêm
// (SV nên truyền tham số là 1 đối tượng kiểu người dùng, không nên truyền
public function themnguoidung($email,$matkhau,$sodt,$hoten,$loai){
    $db = DATABASE::connect();
    try{
    $sql = "INSERT INTO nguoidung(email,matkhau,sodienthoai,hoten,loai)
    VALUES(:email,:matkhau,:sodt,:hoten,:loai)";
    $cmd = $db->prepare($sql);
    $cmd->bindValue(':email',$email);
    $cmd->bindValue(':matkhau',md5($matkhau));
    $cmd->bindValue(':sodt',$sodt);
    $cmd->bindValue(':hoten',$hoten);
    $cmd->bindValue(':loai',$loai);
    $cmd->execute();
    $id = $db->lastInsertId();
    return $id;
    }
    catch(PDOException $e){
    $error_message=$e->getMessage();
    echo "<p>Lỗi truy vấn: $error_message</p>";
    exit();
    }
}
// Cập nhật thông tin ng dùng: họ tên, số đt, email, ảnh đại diện
// (SV nên truyền tham số là 1 đối tượng kiểu người dùng, không nên truyền
public function capnhatnguoidung($id,$email,$sodt,$hoten,$hinhanh){
    $db = DATABASE::connect();
    try{
    $sql = "UPDATE nguoidung set hoten=:hoten, email=:email,
    sodienthoai=:sodt, hinhanh=:hinhanh where id=:id";
    $cmd = $db->prepare($sql);
    $cmd->bindValue(':id',$id);
    $cmd->bindValue(':email',$email);
    $cmd->bindValue(':sodt',$sodt);
    $cmd->bindValue(':hoten',$hoten);
    $cmd->bindValue(':hinhanh',$hinhanh);
    $ketqua = $cmd->execute();
    return $ketqua;
    }
    catch(PDOException $e){
    $error_message=$e->getMessage();
    echo "<p>Lỗi truy vấn: $error_message</p>";
    exit();
    }
}
public function doimatkhau($email,$matkhau){
        $db = DATABASE::connect();
        try{
        $sql = "UPDATE nguoidung set matkhau=:matkhau where email=:email";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(':email',$email);
        $cmd->bindValue(':matkhau',md5($matkhau));
        $ketqua = $cmd->execute();
        return $ketqua;
        }
        catch(PDOException $e){
        $error_message=$e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
        }
    }
    // Đổi quyền (loại người dùng: 1 quản trị, 2 nhân viên. Không cần nâng cấp
    public function doiloainguoidung($email,$loai){
        $db = DATABASE::connect();
        try{
        $sql = "UPDATE nguoidung set loai=:loai where email=:email";
        $cmd = $db->prepare($sql);
        $cmd->bindValue(':email',$email);
        $cmd->bindValue(':loai',$loai);
        $ketqua = $cmd->execute();
        return $ketqua;
    }
    catch(PDOException $e){
        $error_message=$e->getMessage();
        echo "<p>Lỗi truy vấn: $error_message</p>";
        exit();
        }
    }
    // Đổi trạng thái (0 khóa, 1 kích hoạt)
    public function doitrangthai($id,$trangthai){
            $db = DATABASE::connect();
            try{
            $sql = "UPDATE nguoidung set trangthai=:trangthai where id=:id";
            $cmd = $db->prepare($sql);
            $cmd->bindValue(':id',$id);
            $cmd->bindValue(':trangthai',$trangthai);
            $ketqua = $cmd->execute();
            return $ketqua;
        }
            catch(PDOException $e){
                $error_message=$e->getMessage();
                echo "<p>Lỗi truy vấn: $error_message</p>";
                exit();
            }
        }
}
?>