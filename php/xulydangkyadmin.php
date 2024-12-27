<?php
session_start();
require ("../BackEnd/models/DB_driver.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $taikhoan = $_POST['data_username'];
    $matkhau = md5($_POST['data_password']); // Mã hóa mật khẩu bằng MD5
    $email = $_POST['data_email'];

    $db = new DB_driver();
    $db->connect();

    // Bảo vệ dữ liệu đầu vào
    $taikhoan = mysqli_escape_string($db->__conn, $taikhoan);
    $matkhau = mysqli_escape_string($db->__conn, $matkhau);
    $email = mysqli_escape_string($db->__conn, $email);

    // Kiểm tra tài khoản đã tồn tại
    $check_sql = "SELECT * FROM nguoidung WHERE TaiKhoan = '$taikhoan'";
    $existing_user = $db->get_list($check_sql);

    if (sizeof($existing_user) > 0) {
        echo "exist"; // Trả về nếu tài khoản đã tồn tại
    } else {
        // Thêm tài khoản mới vào cơ sở dữ liệu
        $insert_sql = "INSERT INTO nguoidung (TaiKhoan, MatKhau, Email, MaQuyen, TrangThai) 
                       VALUES ('$taikhoan', '$matkhau', '$email', 2, 1)";
        
        if ($db->execute($insert_sql)) {
            echo "success"; // Trả về nếu thêm thành công
        } else {
            echo "error"; // Trả về nếu có lỗi xảy ra
        }
    }

    $db->dis_connect();
}
?>
