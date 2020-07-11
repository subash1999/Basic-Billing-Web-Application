<?php include_once("helper_functions.php"); ?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header("Location: ".view_url("contacts/contacts.php"));
    exit;
}

include_once(controller('contactController.php'));
$contact = new ContactController();
$c = $contact->get_contact_information($id);
include_once(controller('ContactController.php'));
$contact = new ContactController();

if(isset($_POST)){
    if(isset($_POST["delete_contact_id"])){
        $contact->delete_contact($_POST["delete_contact_id"]);
        unset($_POST);
        header("Location: ".view_url("contacts/contacts.php"));
        exit;
    }
}

?>
<?php $header = "contact/ View : ".$id;?>
<?php include_once(snippet("dashboard_top.php")); ?>
<div class="container">
    <form action="" method="POST" name="delete_contact_form"
        id="delete_contact_form_<?php echo($c['id']); ?>">
        <input type="hidden" value="<?php echo($c['id']) ?>" name="delete_contact_id"
            id="delete_contact_id_<?php echo($c['id']) ?>">
    </form>    
    <h3 class="text-primary text-center mt-2 text-uppercase"><u>Contact : <?php echo($id); ?></u></h3>
    <div align="center" class="mt-1 mr-3 ml-3">       
        <a href="<?php echo(view_url("contacts/edit.php?id=".$id)); ?>" class="btn btn-info btn-sm">Edit</a>    
        <button class="btn btn-danger btn-sm" name="delete_contact_btn_<?php echo($c['id']); ?>"
            id="delete_contact_btn_<?php echo($c['id']); ?>">
        <small>Delete</small></button>
        <script>
            jQuery(function($){
                $("#delete_contact_btn_<?php echo($c['id']); ?>").click(function () {
                    var res = confirm("Do You Want To Delete the Contact Id <?php echo($c['id']); ?> of Contact ?");
                    if (res == true) {
                        $('#delete_contact_form_<?php echo($c['id']); ?>').submit();
                    } 
                });
            });            
        </script>

        <br><br>
        <a href="<?php echo(view_url("contacts/contacts.php")); ?>" class="btn btn-warning">View All Contacts</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo(view_url("contacts/contacts.php#add_contact_heading")); ?>" class="btn btn-secondary">Add Contact</a>
    </div>
    
    <br>
    <div class="alert alert-info m-2">
    <h6>ID : <?php echo($c['id']); ?></h6>
    <h6>Name : <?php echo($c['name']); ?></h6>
    <h6>Address : <?php echo($c['address']); ?></h6>
    <h6>Phone : <?php echo($c['phone']); ?></h6>
    <h6>Email : <?php echo($c['email']); ?></h6>
    <h6>Description : <?php echo($c['description']); ?></h6>    
    <hr>
    <h6>Created At : <?php echo($c['created_at']); ?></h6>

    </div>

</div>
<?php include_once(snippet("dashboard_top.php")); ?>