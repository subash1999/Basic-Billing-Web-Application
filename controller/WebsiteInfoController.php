<?php
include_once("helper_functions.php");
include_once(controller("Controller.php"));
class WebsiteInfoController extends Controller {
    private $table_name = "website_info";
    
    public function get_short_name(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='short_name'";
        return $this->get_array_results($sql,'val')[0];
    }

    public function set_short_name($new_short_name){
        $sql = "UPDATE {$this->table_name} SET `val`='{$new_short_name}' WHERE `attribute`='short_name'";
        return $this->conn->query($sql);
    }

    public function get_name(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='name'";
        return $this->get_array_results($sql,'val')[0];
    } 
    
    public function set_name($new_name){
        $sql = "UPDATE {$this->table_name} SET `val`='{$new_name}' WHERE `attribute`='name'";
        return $this->conn->query($sql);
    }
    
    public function get_email(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='email'";
        return $this->get_array_results($sql,'val')[0];
    }   

    public function set_email($new_email){
        $sql = "UPDATE {$this->table_name} SET `val`='{$new_email}' WHERE `attribute`='email'";
        return $this->conn->query($sql);
    }
    
    public function get_phone(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='phone'";
        return $this->get_array_results($sql,'val')[0];
    }   

    public function set_phone($new_phone){
        $sql = "UPDATE {$this->table_name} SET `val`='{$new_phone}' WHERE `attribute`='phone'";
        return $this->conn->query($sql);
    }

    public function get_address(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='address'";
        return $this->get_array_results($sql,'val')[0];
    }  
    
    public function set_address($new_address){
        $sql = "UPDATE {$this->table_name} SET `val`='{$new_address}' WHERE `attribute`='address'";
        return $this->conn->query($sql);
    }

    public function get_password(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='password'";
        return $this->get_array_results($sql,'val')[0];
    }   

    public function set_password($new_password){
        $new_password = password_hash($new_password,PASSWORD_DEFAULT);
        $sql = "UPDATE {$this->table_name} SET `val`='{$new_password}' WHERE `attribute`='password'";
        return $this->conn->query($sql);
    }

    public function get_username(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='username'";
        return $this->get_array_results($sql,'val')[0];
    }   
    public function set_username($username){
        $sql = "UPDATE {$this->table_name} SET `val`='{$username}' WHERE `attribute`='username'";
        return $this->conn->query($sql);
    }   

    public function get_reset_emails(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='reset_emails'";
        return $this->get_reset_emails($sql,'val');
    }

    public function set_reset_email($reset_email){
        $sql = "UPDATE {$this->table_name} SET `val`='{$reset_email}' WHERE `attribute`='reset_emails'";
        return $this->conn->query($sql);
    }   

    public function get_carousel_images(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='carousel_image'";
        return $this->get_array_results($sql,'val');
    }

    public function get_carousel_images_to_edit(){
        $sql = "SELECT * FROM {$this->table_name} WHERE `attribute`='carousel_image'";
        return $this->get_array_results($sql);
    }

    public function add_carousel_image($img_file_name){
        $sql = "INSERT INTO {$this->table_name} (`attribute`,`val`) VALUES ('carousel_image','{$img_file_name}')";
        return $this->conn->query($sql);
    }

    public function delete_website_info($id){
        $sql = "DELETE FROM {$this->table_name} WHERE `id`='{$id}'";
        return $this->conn->query($sql);
    }

    public function get_val_from_id($id){
        $sql = "SELECT * FROM {$this->table_name} WHERE `id`='{$id}'";
        return $this->get_array_results($sql,'val')[0];
    }

    public function get_attribute_from_id($id){
        $sql = "SELECT * FROM {$this->table_name} WHERE `id`='{$id}'";
        return $this->get_array_results($sql,'attribute')[0];
    }

    public function get_row_from_id($id){
        $sql = "SELECT * FROM {$this->table_name} WHERE `id`='{$id}'";
        return $this->get_array_results($sql)[0];
    }

    public function get_profile_pic(){
        $sql = "SELECT `val` FROM {$this->table_name} WHERE `attribute`='profile_pic'";
        return $this->get_array_results($sql,'val')[0];
    }

    public function set_profile_pic($image_file_name){
        $sql = "UPDATE {$this->table_name} SET `val`='{$image_file_name}' WHERE `attribute`='profile_pic'";
        return $this->conn->query($sql);
    }
    

}