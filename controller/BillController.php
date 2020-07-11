<?php
include_once("helper_functions.php");
include_once(controller("Controller.php"));
include_once(controller("TransistionController.php"));

class BillController extends Controller{
    private $table_name = "bill";

    public function get_bills(){
        $sql = "SELECT * FROM {$this->table_name} ORDER BY `created_at` DESC";
        return $this->get_array_results($sql);
    }

    public function get_bill_information($id){
        if ($id == Null){
            return Null;
        }
        $sql = "SELECT * FROM {$this->table_name} WHERE `id`=$id";
        return $this->get_array_results($sql)[0];
    }
    
    public function get_count(){
        $sql = "SELECT COUNT(*) FROM {$this->table_name}";
        return $this->get_array_results($sql,"COUNT(*)")[0];
    }

    public function get_total_quantity_of_bill($bill_id){
        return (new TransistionController())->get_total_quantity_of_bill($bill_id);
    }

    public function get_total_amount_of_bill($bill_id){
        return (new TransistionController())->get_total_amount_of_bill($bill_id);
    }

    public function get_total_bill_quantity(){
        $sql = "SELECT id FROM {$this->table_name} ;";
        $bill_ids = $this->get_array_results($sql,"id");
        $total_quantity = 0;
        foreach($bill_ids as $bill_id){
            $total_quantity += $this->get_total_quantity_of_bill($bill_id);
        }
        return $total_quantity;
    }

    public function get_total_bill_amount(){
        $sql = "SELECT id FROM {$this->table_name} ;";
        $bill_ids = $this->get_array_results($sql,"id");
        $total_amount = 0;
        foreach($bill_ids as $bill_id){
            $total_amount += $this->get_total_amount_of_bill($bill_id);
        }
        return $total_amount;
    }

    public function add_bill($bill_dict){
        $name = $bill_dict['name'];
        $address = $bill_dict['address'];
        $description = $bill_dict['bill_description'];
        if($bill_dict['contact_id'] == ""){
            $contact_id = 'NULL';
        }
        else{
            $contact_id = $bill_dict['contact_id'];
        }
       

        $sql = "INSERT INTO `{$this->table_name}` (`name`,`address`,`description`,`contact_id`) VALUES ";
        $sql .= "('$name','$address','$description',$contact_id)";

        $this->conn->query($sql);

        $sql = "SELECT LAST_INSERT_ID()";
        $bill_id = $this->get_array_results($sql,"LAST_INSERT_ID()")[0];
        if(isset($_POST['title'])){
            for($i=0;$i< count($_POST['title']); $i++){
                $t = array('title'=>$_POST['title'][$i], 'name'=>$_POST['name'],'address'=>$_POST['address'],
                    'quantity'=>$_POST['quantity'][$i], 'rate'=>$_POST['rate'][$i],'contact_id'=>$_POST['contact_id'],
                    'bill_id'=>$bill_id, 'description'=>$_POST['description'][$i]);
                $transistion = new TransistionController();
                $transistion->add_sell($t);
            }
        }

        return $bill_id;

    }

    public function edit_bill($id,$bill_dict){
        $name = $bill_dict['name'];
        $address = $bill_dict['address'];
        $description = $bill_dict['description'];
        $contact_id = $bill_dict['contact_id'];
        
        $sql = "UPDATE `{$this->table_name}` SET ";
        $sql .= "`name`='{$name}',";
        $sql .= "`address` = '{$address}',";
        $sql .= "`contact_id` = {$contact_id},";
        $sql .= "`description` = '{$description}' ";
        $sql .= "WHERE `id`=$id;";
        return $this->conn->query($sql);
    }

    public function delete_bill($id){
        $sql = "DELETE FROM `{$this->table_name}` WHERE `id`=$id";
        return $this->conn->query($sql);
    }


}