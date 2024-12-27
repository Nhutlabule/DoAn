<?php
require_once("DB_business.php");

function show_DataBUS_as_Table($bus)
{
    echo "<table cellspacing='15'>";
    foreach ($bus->select_all() as $rowname => $row) {
        echo "<tr>";
        foreach ($row as $colname => $col) {
            echo "<td>" . $col . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

class SanPhamBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("SanPham", "MaSP");
    }

    function capNhapTrangThai($trangthai, $id) {
        $sanpham = $this->select_by_id("*", $id);
        $sanpham["TrangThai"] = $trangthai;

        return $this->update_by_id($sanpham, $id);
    }

    function themDanhGia($id) {
        $sanpham = $this->select_by_id("*", $id);
        $sanpham["SoDanhGia"] = $sanpham["SoDanhGia"] + 1;

        $dsbl = (new DB_driver())->get_list("SELECT * FROM danhgia WHERE MaSP=$id");
        $tongSoSao = 0;
        for($i = 0; $i < sizeof($dsbl); $i++) {
            $tongSoSao += $dsbl[$i]["SoSao"];
        }
        $sanpham["SoSao"] = $tongSoSao / sizeof($dsbl);

        return $this->update_by_id($sanpham, $id);
    }
}

class LoaiSanPhamBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("LoaiSanPham", "MaLSP");
    }
}

class ChiTietSanPhamBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("ChiTietSanPham", "MaSP");
    }
}

class NguoiDungBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("NguoiDung", "MaND");
    }

    function add_new($data)
    {
        parent::add_new($data);
    }
}

class HoaDonBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("HoaDon", "MaHD");
    }

    function getHoaDonCuaNguoiDung($mand) {
        $sql = "SELECT * FROM hoadon WHERE MaND=$mand";
        $dsdh = (new HoaDonBUS())->get_list($sql);
    }
}

class TaiKhoanBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("TaiKhoan", "TenTaiKhoan");
    }
}

class PhanQuyenBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("PhanQuyen", "MaQuyen");
    }
}

class KhuyenMaiBUS extends DB_business
{
    function __construct()
    {
        $this->setTable("KhuyenMai", "MaKM");
    }
}

class ChiTietHoaDonBUS extends DB_business
{
    protected $key2;

    function __construct()
    {
        $this->setTable("ChiTietHoaDon", "MaHD");
        $this->_key2 = "MaSP";
    }

    function delete_by_2id($id, $id2)
    {
        return $this->remove($this->_table_name, $this->_key . "='" . $id . "' AND " . $this->_key2 . "='" . $id2 . "'");
    }

    function update_by_2id($data, $id, $id2)
    {
        return $this->update($this->_table_name, $data, $this->_key . "='" . $id . "' AND " . $this->_key2 . "='" . $id2 . "'");
    }

    function select_by_2id($select, $id, $id2)
    {
        $sql = "select $select from " . $this->_table_name . " where " . $this->_key . " = '" . $id . "' AND " . $this->_key2 . "='" . $id2 . "'";
        return $this->get_row($sql);
    }

    function select_all_in_hoadon($id)
    {
        $sql = "select * from " . $this->_table_name . " where " . $this->_key . " ='" . $id . "'";
        return $this->get_list($sql);
    }
}
