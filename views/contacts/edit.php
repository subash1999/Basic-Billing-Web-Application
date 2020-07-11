<?php include_once("helper_functions.php"); ?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header("Location: ".view_url("contacts/contacts.php"));
    exit;
}

include_once(controller('ContactController.php'));
$contact = new ContactController();
$c = $contact->get_contact_information($id);

if(isset($_POST["save_btn"])){
    $contact->edit_contact($_POST['id'],$_POST);
    unset($_POST);
    header("Location: ".view_url("contacts/contacts.php"));
    exit;
}
?>
<?php $header = "Contacts / Edit Contact Id : ".$id;?>
<?php include_once(snippet("dashboard_top.php")); ?>
<div class="container m-3">
    <h3 class="text-primary text-center text-uppercase">EDIT CONTACT</h3>
    <form action="" method="POST" class="m-3" name="edit_contact">
        <input type="hidden" name="id" id="id" value="<?php echo($c['id']) ?>">
        <div class="form-group">
            <label for="name" class="text-info text-capitalize">Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo($c['name']); ?>" required="required">
        </div>
        <div class="form-group">
            <label for="address" class="text-info text-capitalize">Address</label>
            <input type="text" class="form-control" name="address" id="address" value="<?php echo($c['address']); ?>">
        </div>
        <div class="form-group">
            <label for="phone" class="text-info text-capitalize">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo($c['phone']); ?>">
        </div>
        <div class="form-group">
            <label for="email" class="text-info text-capitalize">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="<?php echo($c['email']); ?>">
        </div>
        <div class="form-group">
            <label for="description" class="text-info text-capitalize">Description</label>
            <textarea type="text" class="form-control" name="description" id="description" rows="3"><?php echo($c['description']); ?></textarea>
        </div>
        <input type="submit" value="Save" class="btn btn-primary" name="save_btn" id="save_btn">
    </form>
</div>

<?php include_once(snippet("dashboard_bottom.php")); ?>
