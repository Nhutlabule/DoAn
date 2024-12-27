<?php
        session_start();
        $taikhoan=$_POST['data_username'];
        $matkhau=md5($_POST['data_password']);
        
        require ("../BackEnd/models/DB_driver.php");

        $db = new DB_driver();
        $db->connect();

        $taikhoan = mysqli_escape_string($db->__conn, $taikhoan);
        $matkhau = mysqli_escape_string($db->__conn, $matkhau);

        $sql = "SELECT * FROM nguoidung WHERE TaiKhoan = '$taikhoan' AND MatKhau='$matkhau' AND MaQuyen!='1' AND TrangThai=1";

        $dsad = $db->get_list($sql);

        if(sizeof($dsad) > 0){
            $_SESSION['currentUser'] = $dsad[0];   

            echo "yes";

        } else  echo "no";

        $db->dis_connect();
        ?>