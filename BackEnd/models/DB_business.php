<?php
require_once("DB_driver.php");

class DB_business extends DB_driver
{
    protected $_table_name = '';

    protected $_key = '';

    function __construct()
    {
        parent::connect();
    }

    function setTable($tenBang, $khoaChinh)
    {
        $this->_table_name = $tenBang;

        $this->_key = $khoaChinh;
    }

    function __destruct()
    {
        parent::dis_connect();
    }

    function add_new($data)
    {
        return parent::insert($this->_table_name, $data);
    }

    function delete_by_id($id)
    {
        return $this->remove($this->_table_name, $this->_key . "='" . $id . "'");
    }

    function update_by_id($data, $id)
    {
        return $this->update($this->_table_name, $data, $this->_key . "='" . $id . "'");
    }

    function select_by_id($select, $id)
    {
        $sql = "select $select from " . $this->_table_name . " where " . $this->_key . " = '" . $id . "'";
        return $this->get_row($sql);
    }

    function select_all()
    {
        $sql = "select * from " . $this->_table_name;
        return $this->get_list($sql);
    }
}
