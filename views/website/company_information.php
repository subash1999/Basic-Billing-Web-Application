<?php include_once("helper_functions.php");?>
<?php
if(isset($_POST['save'])){
    $name = $_POST['name'];
    $short_name = $_POST['short_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    website_info()->set_name($name);
    website_info()->set_short_name($short_name);
    website_info()->set_phone($phone);
    website_info()->set_address($address);
    website_info()->set_email($email);
    unset($_POST);
    header("Location: ".current_url());
    exit;
}
?>
<?php $header = "Website / Company Information"; ?>
<?php include_once(snippet("dashboard_top.php")); ?>
<script>
jQuery(function ($) {
    $("#name").on("change paste keyup",function(){
        var val = $(this).val();
        var res  = val.split(" ");
        var i = 0;
        var short_name = "";
        for(i = 0;i<res.length;i++){
            short_name = short_name+res[i].charAt(0).toUpperCase();
        }
        $("#short_name").val(short_name);
    });
});
</script>
<div class="container m-3">
    <h3 class="text-primary text-center">Edit Company Information</h3>
    <form action="" method="POST" class="m-5">
        <div class="form-group">
            <label for="name" class="text-info">Company Name<small class="text-danger">*</small></label>
            <input type="text" name="name" id="name" value="<?php echo(website_info()->get_name()); ?>" class="form-control" max="50" required="required">
        </div>
        <div class="form-group">
            <label for="short_name" class="text-info">Short Name<small class="text-danger">*</small></label>
            <input type="text" name="short_name" id="short_name" value="<?php echo(website_info()->get_short_name()); ?>" 
            class="form-control" required="required">
        </div>        
        <div class="form-group">
            <label for="phone" class="text-info">Phone</label>
            <input type="text" name="phone" id="phone" value="<?php echo(website_info()->get_phone()); ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="address" class="text-info">address</label>
            <input type="text" name="address" id="address" value="<?php echo(website_info()->get_address()); ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="email" class="text-info">Email</label>
            <input type="email" name="email" id="email" value="<?php echo(website_info()->get_email()); ?>" class="form-control">
        </div>
        <input type="submit" value="Save Data" name="save" id="save" class="btn btn-primary">
    </form>
</div>
<?php include_once(snippet("dashboard_bottom.php")); ?>