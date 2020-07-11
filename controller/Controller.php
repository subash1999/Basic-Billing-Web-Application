<?php
include_once("connection.php");

class Controller {

    public $conn;
    public $conn_obj;
    
    public function __construct(){
        $this->conn_obj = new connection;
        $this->conn = $this->conn_obj->create_conn();
    } 

    public function get_columns($table_name){
        $sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='{$table_name}'";
        $result = $this->conn->query($sql);
        $cols = [];
        if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    $cols = array_push($cols,$row['COLUMN_NAME']);
                }
        }
        return $cols;
    }
    public function get_array_results($sql,$col_name = "*"){
        $result = $this->conn->query($sql);
        $res = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                if ($col_name != "*"){
                   array_push($res,$row[$col_name]);        
                }
                else{
                    array_push($res,$row);
                }
            }
        }    
        return $res;
    }

    public function __destruct(){
        $this->conn_obj->close_conn();
    }

}