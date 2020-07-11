<?php
class Connection{
    // Code for the opening the connection
    /**
     *Open the connection
    */
    private $conn = NULL;
    function create_conn(){
        
        include_once("config.php");
        global $servername, $db_username, $db_password, $db_name;
        // Create Connection
        $conn = new mysqli($servername,$db_username,$db_password,$db_name);

        // Check Connection
        if ($conn->connect_error){
            die("Connection Failed : ". $conn->connect_error);
        }
        $this->conn = $conn;
        return $conn;

    }
    // Connection Close 
    /** 
     * Close the connection
    */
    function close_conn(){
        if(!$this->conn->ping()){
            $this->create_conn();
        }
        $this->conn->close();
    }
    
}