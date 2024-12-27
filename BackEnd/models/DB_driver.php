<?php

class DB_driver
{

    public $__conn,
        $localhost = "localhost",
        $user = "root",
        $pass = "",
        $DbName = "be1";

 
    function connect()
    {

        if (!$this->__conn) {
          
            $this->__conn = mysqli_connect($this->localhost, $this->user, $this->pass, $this->DbName) or die('Lỗi kết nối');

   
            mysqli_query($this->__conn, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
            mysqli_query($this->__conn, "set names 'utf8'");
            mysqli_set_charset($this->__conn, "utf8");
        }
    }


    function dis_connect()
    {
      
        if ($this->__conn) {
            mysqli_close($this->__conn);
        }
    }


    function insert($table, $data)
    {
    
        $this->connect();

        $value_list = '';

        foreach ($data as $key => $value) {
         
            $value_list .= ",'" . mysqli_escape_string($this->__conn, $value) . "'";
        }

      
      
        $sql = 'INSERT INTO ' . $table . ' VALUES (' . trim($value_list, ',') . ')';

        return mysqli_query($this->__conn, $sql);
        
    }

    
    function update($table, $data, $where)
    {
    
        $this->connect();
        $sql = '';
      
        foreach ($data as $key => $value) {
            $sql .= "$key = '" . mysqli_escape_string($this->__conn, $value) . "',";
        }

 
        $sql = 'UPDATE ' . $table . ' SET ' . trim($sql, ',') . ' WHERE ' . $where;

        return mysqli_query($this->__conn, $sql);
    }


    function remove($table, $where)
    {
    
        $this->connect();

  
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->__conn, $sql);
    }


    function get_list($sql)
    {
   
        $this->connect();

        $result = mysqli_query($this->__conn, $sql);

        if (!$result) {
            die('Câu truy vấn bị sai ' . $sql);
        }

        $return = array();


        while ($row = mysqli_fetch_assoc($result)) {
            $return[] = $row;
        }

        mysqli_free_result($result);

        return $return;
    }

    function get_row($sql)
    {
        $this->connect();

        $result = mysqli_query($this->__conn, $sql);

        if (!$result) {
            die('Câu truy vấn bị sai ' . $sql);
        }

        $row = mysqli_fetch_assoc($result);

        mysqli_free_result($result);

        if ($row) {
            return $row;
        }

        return false;
    }
}
