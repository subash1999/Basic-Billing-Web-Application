<?php
include_once("helper_functions.php");
include_once(controller("Controller.php"));
class ContactController extends Controller{
    private $table_name = "contact";

    public function get_contacts(){
        $sql = "SELECT * FROM {$this->table_name} ORDER BY `created_at` DESC";
        return $this->get_array_results($sql);
    }

    public function get_count(){
        $sql = "SELECT COUNT(*) FROM {$this->table_name}";
        return $this->get_array_results($sql,"COUNT(*)")[0];
    }

    public function get_contact_information($id){
        if ($id == Null){
            return Null;
        }
        $sql = "SELECT * FROM {$this->table_name} WHERE `id`=$id";
        return $this->get_array_results($sql)[0];
    }

    public function add_contact($contact_dict){
        $name = $contact_dict['name'];
        $address = $contact_dict['address'];
        $phone = $contact_dict['phone'];
        $email = $contact_dict['email'];
        $description = $contact_dict['description'];

        $sql = "INSERT INTO `{$this->table_name}` (`name`,`address`,`phone`,`email`,`description`) VALUES ";
        $sql .= "('$name','$address','$phone','$email','$description')";

        return $this->conn->query($sql);
    }

    public function delete_contact($id){
        $sql = "DELETE FROM `{$this->table_name}` WHERE `id`=$id";
        return $this->conn->query($sql);
    }

    public function edit_contact($id,$contact_dict){
        $name = $contact_dict['name'];
        $address = $contact_dict['address'];
        $phone = $contact_dict['phone'];
        $email = $contact_dict['email'];
        $description = $contact_dict['description'];
        
        $sql = "UPDATE `{$this->table_name}` SET ";
        $sql .= "`name`='{$name}',";
        $sql .= "`address` = '{$address}',";
        $sql .= "`phone` = '{$phone}',";
        $sql .= "`email` = '{$email}',";
        $sql .= "`description` = '{$description}' ";
        $sql .= "WHERE `id`=$id;";
        return $this->conn->query($sql);
    }

}