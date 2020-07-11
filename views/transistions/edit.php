<?php include_once("helper_functions.php"); ?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header("Location: ".view_url("transistions/transistions.php"));
    exit;
}

if(! empty($_POST)){
    include_once(controller("TransistionController.php"));
    $transistion = new TransistionController();
    $val = $transistion->edit_transistion($_POST['id'],$_POST);
    $id = $_POST['id'];   
    unset($_POST); 
    header("Location: ".view_url("transistions/view.php?id=".$id));    
    exit;
} 

include_once(controller('TransistionController.php'));
$transistion = new TransistionController();
$t = $transistion->get_transistion_information($id);
include_once(controller('ContactController.php'));
$contact = new ContactController();

?>

<?php $header = "Transistions/ Edit Transistion id : ".$id;?>
<?php include_once(snippet("dashboard_top.php")); ?>
   
<div class="container">
    <h3 class="text-primary text-center m-3 text-uppercase"><u>Edit Transistion Id : <?php echo($id); ?></u></h3>
    <div align="center">
        <a href="<?php echo(view_url("transistions/view.php?id=$id")); ?>" class="btn btn-info">View Transistion : <?php echo($id); ?></a>
        <a href="<?php echo(view_url("transistions/transistions.php")); ?>" class="btn btn-warning">View All Transistions</a>    
    </div>
    <form action="" method="POST" class="m-3" name="edit_transistion_form" id="edit_transistion_form">
        <input type="hidden" name="id" id="id" value="<?php echo($id); ?>">
        <label for="type" class="text-info">Transistion Type</label>
        <select name="type" id="type" class="form-control">
            <?php
            foreach(["Buy","Sell"] as $type){
                $selected = "";
                if(strtolower($type) == strtolower($t['type'])){
                    $selected = "selected";
                }
            ?>
            <option value="<?php echo($type); ?>" <?php echo($selected); ?>><?php echo($type); ?></option>
            <?php
            } 
            ?>
        </select>
        <div class="form-group">
            <label for="title" class="text-info form-control-label text-capitalize">Transistion Title</label>
            <input type="text" name="title" id="title" max="100" 
            class="form-control" required="required" value="<?php echo($t['title']); ?>">
        </div>
        <div class="form-group">
            <label for="contact_id" class="text-info form-control-label text-capitalize">Contact Concerned</label>
            <select name="contact_id" id="contact_id" class="form-control" >
                <option value="NULL" class="contact_id_option"></option>
                <?php foreach($contact->get_contacts() as $c){
                    $option = $c['name']."";
                    if($c['address'] != ''){
                        $option .= ", Address: ".$c['address'];
                    }
                    if($c['phone'] != ''){
                        $option .= ", Phone: ".$c['phone'];
                    }
                    if($c['email'] != ''){
                        $option .= ", Email: ".$c['email'];
                    }
                    $selected = "";
                    if($t['contact_id']==$c['id']){
                        $selected = "selected";
                    }
                    ?>                 
                    <option value="<?php echo($c['id']) ?>" <?php echo($selected) ?> class="contact_id_option"><?php echo($option) ?></option>
                <?php } ?>
                <?php foreach($contact->get_contacts() as $c){ ?>
                    <input type="hidden" id="contact_name_<?php echo($c['id']); ?>" value="<?php echo($c['name']); ?>">
                    <input type="hidden" id="contact_address_<?php echo($c['id']); ?>" value="<?php echo($c['address']); ?>">
                    <input type="hidden" id="contact_phone_<?php echo($c['id']); ?>" value="<?php echo($c['phone']); ?>">
                    <input type="hidden" id="contact_email_<?php echo($c['id']); ?>" value="<?php echo($c['email']); ?>">               
                <?php } ?>
            </select>
            <br>
            <button type="button" class="btn btn-sm btn-secondary" id="copy_contact_information_btn">Copy Contact Information Below</button>
        </div>
        <div class="form-group">
            <label for="name" class="text-info form-control-label text-capitalize">Name (Bought From)</label>
            <input type="text" name="name" id="name" max="100" 
            class="form-control" required="required" value="<?php echo($t['name']); ?>">
        </div>
        <div class="form-group">
            <label for="address" class="text-info form-control-label text-capitalize">Address (Address of person from whom you brought the product)</label>
            <input type="text" name="address" id="address" max="100"
            class="form-control" value="<?php echo($t['address']); ?>">
        </div> 
        <div class="form-group">
            <label for="quantity" class="text-info form-control-label text-capitalize">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="0" class="form-control" required="required"
            value="<?php echo($t['quantity']); ?>">
        </div>
        <div class="form-group">
            <label for="rate" class="text-info form-control-label text-capitalize">Rate (Rs)</label>
            <input type="number" name="rate" id="rate" min="0" class="form-control" required="required"
            value="<?php echo($t['rate']); ?>">
        </div>
        <div class="form-group">
            <label for="amount" class="text-info form-control-label text-capitalize">Amount of Product in Rupees (Rs)</label>
            <input type="number" name="amount" id="amount" min="0" class="form-control" 
            required="required" value="<?php echo($t['quantity']*$t['rate']); ?>">
        </div>
        <div class="form-group">
            <label for="address" class="text-info form-control-label text-capitalize">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control"><?php echo($t['description']); ?></textarea>
        </div>
        <input type="submit" value="Save Changes" name="save_changes_btn" id="save_changes_btn" class="btn btn-primary">
    </form>
</div>
<script>
    jQuery(function($){
        $("#copy_contact_information_btn").click(function(){
            $("#name").val($("#contact_name_"+$(".contact_id_option:selected").val()).val());
            $("#address").val($("#contact_address_"+$(".contact_id_option:selected").val()).val());
        });
        $("#quantity,#rate,#amount").change(function(){
            $("#amount").val($("#quantity").val()*$("#rate").val());
        });
    });
</script>
<?php include_once(snippet("dashboard_bottom.php")); ?>