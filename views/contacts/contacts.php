<?php include_once("helper_functions.php"); ?>
<?php
include_once(controller('ContactController.php'));
$contact = new ContactController();
if(isset($_POST['add_contact'])){
    $contact->add_contact($_POST);
    unset($_POST);
    header("Location: ".current_url());
    exit;
}
if(isset($_POST)){
    if(isset($_POST["delete_contact_id"])){
        $contact->delete_contact($_POST["delete_contact_id"]);
        unset($_POST);
    }
}
?>
<?php $header = "Contacts";?>
<?php include_once(snippet("dashboard_top.php")); ?>
<script>
jQuery(function ($) {
    $('#contacts_table').DataTable({
        "scrollY": "300px",
        "scrollCollapse": false,
        stateSave: true,        
    });
});
</script>
<div class="container">
    <h3 class="text-primary text-center text-uppercase m-3"><u>Contacts</u></h3>
    <table class="table table-bordered table-hover" id="contacts_table">
        <thead>
            <th>S.N</th>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Description</th>
            <th>Email</th>
            <th>Actions</th>
        </thead>
        <tbody>
            <?php $sn = 1; ?>
            <?php foreach($contact->get_contacts() as $c){?>
            <tr>
                <td><?php echo($sn); ?></td>
                <td><?php echo($c['id']); ?></td>
                <td><?php echo($c['name']) ?></td>
                <td><?php echo($c['address']) ?></td>
                <td><?php echo($c['phone']) ?></td>
                <td><?php echo($c['description']) ?></td>
                <td><?php echo($c['email']) ?></td>
                <td>
                    <a href="<?php echo(view_url("contacts/view.php?id=".$c['id'])); ?>" class="btn btn-sm btn-dark mb-2"><small>View</small></a>

                    <a href="<?php echo(view_url("contacts/edit.php?id=".$c['id'])); ?>" class="btn btn-sm btn-info"><small>Edit</small></a>

                    <form action="" class="m-2" method="POST" name="delete_contact_form"
                        id="delete_contact_form_<?php echo($c['id']); ?>">
                        <input type="hidden" value="<?php echo($c['id']) ?>" name="delete_contact_id"
                            id="delete_contact_id">
                    </form>
                    <button class="btn btn-danger btn-sm" name="delete_contact_btn_<?php echo($c['id']); ?>"
                        id="delete_contact_btn_<?php echo($c['id']); ?>">
                        <small>Delete</small></button>
                    <script>
                        $("#delete_contact_btn_<?php echo($c['id']); ?>").click(function () {
                            var res = confirm("Do You Want To Delete the Contact Id <?php echo($c['id']); ?> of Contacts ?");
                            if (res == true) {
                                $('#delete_contact_form_<?php echo($c['id']); ?>').submit();
                            }
                        });
                    </script>
                </td> 
            </tr>
            <?php $sn +=1 ?>
            <?php } 
            unset($sn);
        ?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
    <hr style="border-width:5px;border-color:pink;">
    <h3 class="text-primary text-center text-uppercase" id="add_contact_heading">ADD CONTACT</h3>
    <form action="" method="POST" class="m-3" name="add_contact" id="add_contact">
        <div class="form-group">
            <label for="name" class="text-info text-capitalize">Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" name="name" id="name" required="required">
        </div>
        <div class="form-group">
            <label for="address" class="text-info text-capitalize">Address</label>
            <input type="text" class="form-control" name="address" id="address">
        </div>
        <div class="form-group">
            <label for="phone" class="text-info text-capitalize">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone">
        </div>
        <div class="form-group">
            <label for="email" class="text-info text-capitalize">Email</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>
        <div class="form-group">
            <label for="description" class="text-info text-capitalize">Description</label>
            <textarea type="text" class="form-control" name="description" id="description" rows="3"></textarea>
        </div>
        <input type="submit" value="Add Contact" class="btn btn-primary" name="add_contact" id="add_contact">
    </form>
    
    
</div>
<?php include_once(snippet("dashboard_bottom.php")); ?>