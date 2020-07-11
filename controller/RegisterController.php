<?php

include_once("controller/Controller.php");
// use Connection;

class RegisterController extends Connection{

    public function index(){

    }
    
    public function create(){

    }

    public function read(){
        
    }

    public function update(){

    }

    public function delete(){

    }

    
    public function get_user_types(){
        $sql = "SELECT `user_type` FROM  `user_types`";
        // var_dump($conn);
        $result = $this->conn->query($sql);
        $res = [];
    
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                array_push($res,$row['user_type']);
                // $res.append($row['user_type']);
            }
        }
        
        return $res;
    }
    
}
