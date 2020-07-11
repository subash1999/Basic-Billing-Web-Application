<?php
include_once("helper_functions.php");
include_once(controller("Controller.php"));

class TransistionController extends Controller{
    private $table_name = "transistions";

    public function get_transistions(){
        $sql = "SELECT * FROM {$this->table_name} ORDER BY `created_at` DESC";
        return $this->get_array_results($sql);
    }

    public function get_total_transistion_group_by_date(){
        $sql = "SELECT DATE(created_at) AS `date`,SUM(quantity*rate) AS amount  FROM {$this->table_name} GROUP BY DATE(created_at) ORDER BY DATE(created_at)";
        return $this->get_array_results($sql);
    }

    public function get_total_sell_transistion_group_by_date(){
        $sql = "SELECT DATE(created_at) AS `date`,SUM(quantity*rate) AS amount  FROM {$this->table_name} WHERE `type`='Sell'  GROUP BY DATE(created_at) ORDER BY DATE(created_at)";
        return $this->get_array_results($sql);
    }

    public function get_total_buy_transistion_group_by_date(){
        $sql = "SELECT DATE(created_at) AS `date`,SUM(quantity*rate) AS amount  FROM {$this->table_name} WHERE `type`='Buy'  GROUP BY DATE(created_at) ORDER BY DATE(created_at)";
        return $this->get_array_results($sql);
    }

    public function get_sell_transistions(){
        $sql = "SELECT * FROM {$this->table_name} WHERE `type`='Sell' ORDER BY `created_at` DESC ;";
        return $this->get_array_results($sql);
    }

    public function get_buy_transistions(){
        $sql = "SELECT * FROM {$this->table_name} WHERE `type`='Buy' ORDER BY `created_at` DESC ;";
        return $this->get_array_results($sql);
    }

    public function get_transistions_of_date($date){
        $sql = "SELECT * FROM {$this->table_name} WHERE created_at LIKE \"{$date}%\"";
        return $this->get_array_results($sql);
    }

    public function get_sell_transistions_of_date($date){
        $sql = "SELECT * FROM {$this->table_name} WHERE `type`='Sell' AND created_at LIKE \"{$date}%\"";
        return $this->get_array_results($sql);
    }

    public function get_buy_transistions_of_date($date){
        $sql = "SELECT * FROM {$this->table_name} WHERE `type`='Buy' AND created_at LIKE \"{$date}%\"";
        return $this->get_array_results($sql);
    }

    public function get_total_transistion_amount_of_date($date){
        $sql = "SELECT SUM(quantity*rate) FROM {$this->table_name} WHERE created_at LIKE \"{$date}%\"";
        return $this->get_array_results($sql,"SUM(quantity*rate)")[0];
    }

    public function get_total_sell_amount_of_date($date){
        $sql = "SELECT SUM(quantity*rate) FROM {$this->table_name} WHERE `type`='Sell' AND created_at LIKE \"{$date}%\"";
        return $this->get_array_results($sql,"SUM(quantity*rate)")[0];
    }

    public function get_total_buy_amount_of_date($date){
        $sql = "SELECT SUM(quantity*rate) FROM {$this->table_name} WHERE `type`='Buy' AND created_at LIKE \"{$date}%\"";
        return $this->get_array_results($sql,"SUM(quantity*rate)")[0];
    }

    public function get_transistion_information($id){
        if ($id == Null){
            return Null;
        }
        $sql = "SELECT * FROM {$this->table_name} WHERE `id`=$id ;";
        return $this->get_array_results($sql)[0];
    }
    
    public function get_count(){
        $sql = "SELECT COUNT(*) FROM {$this->table_name} ;";
        return $this->get_array_results($sql,"COUNT(*)")[0];
    }

    public function get_sell_count(){
        $sql = "SELECT COUNT(*) FROM {$this->table_name} WHERE `type`='Sell' ;";
        return $this->get_array_results($sql,"COUNT(*)")[0];
    }

    public function get_buy_count(){
        $sql = "SELECT COUNT(*) FROM {$this->table_name} WHERE `type`='Buy' ;";
        return $this->get_array_results($sql,"COUNT(*)")[0];
    }

    public function get_total_transisiton_quantity(){
        $sql = "SELECT SUM(quantity) FROM `{$this->table_name}` ;";
        return $this->get_array_results($sql,"SUM(quantity)")[0];
    }

    public function get_total_sell_quantity(){
        $sql = "SELECT SUM(quantity) FROM `{$this->table_name}` WHERE `type`='Sell' ;";
        return $this->get_array_results($sql,"SUM(quantity)")[0];
    }

    public function get_total_buy_quantity(){
        $sql = "SELECT SUM(quantity) FROM `{$this->table_name}` WHERE `type`='Buy' ;";
        return $this->get_array_results($sql,"SUM(quantity)")[0];
    }

    public function get_total_amount_of_transistion(){
        $sql = "SELECT SUM(quantity*rate) from `{$this->table_name}` ;";
        return $this->get_array_results($sql,"SUM(quantity*rate)")[0];
    }

    public function get_total_amount_of_sell(){
        $sql = "SELECT SUM(quantity*rate) from `{$this->table_name}` WHERE `type`='Sell';";
        return $this->get_array_results($sql,"SUM(quantity*rate)")[0];
    }

    public function get_total_amount_of_buy(){
        $sql = "SELECT SUM(quantity*rate) from `{$this->table_name}` WHERE `type`='Buy';";
        return $this->get_array_results($sql,"SUM(quantity*rate)")[0];
    }

    public function get_total_quantity_of_bill($bill_id){
        $sql = "SELECT SUM(quantity) from {$this->table_name} where `bill_id`=$bill_id ;";
        return $this->get_array_results($sql,"SUM(quantity)")[0];
    }
    
    public function get_total_amount_of_bill($bill_id){
        $sql = "SELECT SUM(quantity*rate) from {$this->table_name} where `bill_id`=$bill_id ;";
        return $this->get_array_results($sql,"SUM(quantity*rate)")[0];
    }

    public function add_buy($transistion_dict){
        return $this->add_transistion($transistion_dict,"Buy");
    }

    public function add_sell($transistion_dict){
        return $this->add_transistion($transistion_dict,"Sell");
    }

    public function get_transistions_of_bill($bill_id){
        $sql = "SELECT * FROM {$this->table_name} WHERE `bill_id`={$bill_id}";
        return $this->get_array_results($sql);
    }

    private function add_transistion($transistion_dict,$transistion_type){
        $type = $transistion_type;
        $title = $transistion_dict['title'];
        $name = $transistion_dict['name'];
        $address = $transistion_dict['address'];
        $quantity = $transistion_dict['quantity'];
        $rate = $transistion_dict['rate'];
        $description = $transistion_dict['description'];
        if($transistion_dict['contact_id'] == ""){
            $contact_id = 'NULL';
        }
        else{
            $contact_id = $transistion_dict['contact_id'];
        }
        if($transistion_dict['bill_id'] == ""){
            $bill_id = 'NULL';
        }
        else{
            $bill_id = $transistion_dict['bill_id'];
        }

        $sql = "INSERT INTO `{$this->table_name}` (`type`,`title`,`name`,`address`,`quantity`,`rate`,`description`,`contact_id`,`bill_id`) VALUES ";
        $sql .= "('$type','$title','$name','$address',$quantity,$rate,'$description',$contact_id,$bill_id)";

        $this->conn->query($sql);

        $sql = "SELECT LAST_INSERT_ID()";
        $res = $this->get_array_results($sql,"LAST_INSERT_ID()")[0];
        return $res;

    }

    public function edit_transistion($id,$transistion_dict){
        $type = $transistion_dict['type'];
        $title = $transistion_dict['title'];
        $name = $transistion_dict['name'];
        $address = $transistion_dict['address'];
        $quantity = $transistion_dict['quantity'];
        $rate = $transistion_dict['rate'];
        $description = $transistion_dict['description'];
        $contact_id = $transistion_dict['contact_id'];
        
        $sql = "UPDATE `{$this->table_name}` SET ";
        $sql .= "`type`='{$type}',";
        $sql .= "`title`='{$title}',";
        $sql .= "`name`='{$name}',";
        $sql .= "`address` = '{$address}',";
        $sql .= "`quantity` = '{$quantity}',";
        $sql .= "`rate` = {$rate},";
        $sql .= "`contact_id` = {$contact_id},";
        $sql .= "`description` = '{$description}' ";
        $sql .= "WHERE `id`=$id;";
        return $this->conn->query($sql);
    }

    public function delete_transistion($id){
        $sql = "DELETE FROM `{$this->table_name}` WHERE `id`=$id";
        return $this->conn->query($sql);
    }

    public function update_contact_id_related_to_bill($bill_id,$contact_id){
        $sql = "UPDATE `{$this->table_name}` SET ";
        $sql .= "`contact_id`=$contact_id ";
        $sql .= "WHERE `bill_id`=$bill_id;";
        return $this->conn->query($sql);
    }

    public function update_bill_id_of_transistion($transistion_id,$bill_id){
        $sql = "UPDATE `{$this->table_name}` SET ";
        $sql .= "`bill_id`=$bill_id ";
        $sql .= "WHERE `id`=$transistion_id;";
        return $this->conn->query($sql);
    }

    public function set_bill_id_null($id){
        $sql = "UPDATE `{$this->table_name}` SET ";
        $sql .= "`bill_id`=NULL ";
        $sql .= "WHERE `id`=$id;";
        return $this->conn->query($sql);
    }

    public function delete_all_transistions_of_bill($bill_id){
        $sql = "DELETE FROM `{$this->table_name}` ";
        $sql .= "WHERE `bill_id`=$bill_id;";
        return $this->conn->query($sql);
    }
}