<?php include_once("helper_functions.php"); ?>
<?php 
include_once(controller("ContactController.php"));
$contact = new ContactController();
?>
<?php
if(! empty($_POST)){
    include_once(controller("TransistionController.php"));
    $transistion = new TransistionController();
    $last_inserted_id = $transistion->add_buy($_POST);    
    unset($_POST);
    header("Location: ".view_url("transistions/view.php?id=$last_inserted_id"));
    exit;
} 
?>
<?php $header = "Transistions/ New Buy";?>
<?php include_once(snippet("dashboard_top.php")); ?>
<div class="container">
    <h3 class="text-primary text-center m-3 text-uppercase"><u>Record New Buy</u></h3>
    <form action="" method="POST" class="m-3" name="new_buy_form" id="new_buy_form">
        <input type="hidden" name="type" id="type" value="buy">
        <div class="form-group">
            <label for="title" class="text-info form-control-label text-capitalize">Transistion Title</label>
            <input type="text" name="title" id="title" max="100" class="form-control" required="required">
        </div>
        <div class="form-group">
            <label for="contact_id" class="text-info form-control-label text-capitalize">Contact Concerned</label>
            <select name="contact_id" id="contact_id" class="form-control" >
                <option value="NULL" selected="selected"></option>
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
                    ?>     
                    <option value="<?php echo($c['id']) ?>"><?php echo($option) ?></option>
                <?php } ?>
                <?php foreach($contact->get_contacts() as $c){ ?>
                    <input type="hidden" id="contact_name_<?php echo($c['id']); ?>" value="<?php echo($c['name']); ?>">
                    <input type="hidden" id="contact_address_<?php echo($c['id']); ?>" value="<?php echo($c['address']); ?>">
                    <input type="hidden" id="contact_phone_<?php echo($c['id']); ?>" value="<?php echo($c['phone']); ?>">
                    <input type="hidden" id="contact_email_<?php echo($c['id']); ?>" value="<?php echo($c['email']); ?>">               
                <?php } ?>
            </select>
            <br>
            <button type="button" class="btn btn-sm btn-warning" id="copy_contact_information_btn">Copy Contact Information Below</button>
        </div>
        <div class="form-group">
            <label for="name" class="text-info form-control-label text-capitalize">Name (Bought From)</label>
            <input type="text" name="name" id="name" max="100" class="form-control" required="required">
        </div>
        <div class="form-group">
            <label for="address" class="text-info form-control-label text-capitalize">Address (Address of person from whom you brought the product)</label>
            <input type="text" name="address" id="address" max="100" class="form-control">
        </div>
        <div class="form-group">
            <label for="quantity" class="text-info form-control-label text-capitalize">Quantity</label>
            <input type="number" name="quantity" id="quantity" min="0" class="form-control" required="required" step="0.001">
        </div>
        <div class="form-group">
            <label for="rate" class="text-info form-control-label text-capitalize">Rate (Rs)</label>
            <input type="number" name="rate" id="rate" min="0" class="form-control" required="required" step="0.001">
        </div>
        <div class="form-group">
            <label for="amount" class="text-info form-control-label text-capitalize">Amount of Product in Rupees (Rs)</label>
            <input type="number" name="amount" id="amount" min="0" class="form-control" required="required">
        </div>
        <div class="form-group">
            <label for="address" class="text-info form-control-label text-capitalize">Description</label>
            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
        </div>
        <input type="submit" value="Save New Buy" name="save_buy_btn" id="save_buy_btn" class="btn btn-primary">
    </form>
</div>
<script>
    jQuery(function($){
        $("#copy_contact_information_btn").click(function(){
            $("#name").val($("#contact_name_"+$("option:selected").val()).val());
            $("#address").val($("#contact_address_"+$("option:selected").val()).val());
        });
        $("#quantity,#rate,#amount").change(function(){
            $("#amount").val($("#quantity").val()*$("#rate").val());
        });
    });
</script>
<?php include_once(snippet("dashboard_bottom.php")); ?>