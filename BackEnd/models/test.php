<?php
require_once('DB_classes.php');

$nguoidung = new NguoiDungBUS();
 $nguoidung->add_new(array('ND3', 'Nguyen', 'Hoang Nhut', 'NguyenNhut@gmail.com'));

show_DataBUS_as_Table(new NguoiDungBUS());
die('LOL');
