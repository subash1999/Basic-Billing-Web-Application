<?php include_once("helper_functions.php"); ?>
<?php
include_once(controller("BillController.php"));
include_once(controller("ContactController.php"));
$bill = new BillController();
$contact = new ContactController();

?>
<?php
if(isset($_POST)){
    if(isset($_POST["delete_bill_id"])){
        $bill->delete_bill($_POST["delete_bill_id"]);
        unset($_POST);
        header("Location: ".view_url("bills/bills.php"));
        exit;
    }
    if(isset($_POST["delete_bill_and_transistion_id"])){
        $transistions = new TransistionController();
        $transistions->delete_all_transistions_of_bill($_POST["delete_bill_and_transistion_id"]);
        $bill->delete_bill($_POST["delete_bill_and_transistion_id"]);
        unset($_POST);
        header("Location: ".view_url("bills/bills.php"));
        exit;
    }
}
?>
<?php $header = "Bills";?>
<?php include_once(snippet("dashboard_top.php")); ?>

<script>
jQuery(function ($) {
    $('[data-toggle="popover"]').popover();
});
jQuery(function ($) {    
    $('#bills_table').DataTable({
        "scrollY": "260px",
        "scrollX": true,
        "scrollCollapse": false,
        stateSave: true,        
    });
});
</script>
<div class="container">
    <h3 class="text-primary text-center text-uppercase m-3"><u>Bills</u></h3>
    <table class="table table-bordered table-hover" id="bills_table" align="center">
        <thead>
            <th>S.N</th>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Total Bill Amount</th>
            <th>Description</th>
            <th>Related Contact</th>
            <th>Updated At</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php $sn = 1; ?>
            <?php foreach($bill->get_bills() as $b){?>
            <tr>
                <td><?php echo($sn); ?></td>
                <td><?php echo($b['id']); ?></td>
                <td><?php echo($b['name']) ?></td>
                <td><?php echo($b['address']) ?></td>
                <?php
                $amount = 0;
                $transistions = new TransistionController();
                $transistions = $transistions->get_transistions_of_bill($b['id']);
                foreach($transistions as $t){
                    $amount += $t['rate'] * $t['quantity'];
                } 
                ?>
                <td>Rs <?php echo($amount) ?></td>
                <td><?php echo($b['description']) ?></td>
                <?php
                $c = ""; 
                if(! empty($b['contact_id'])){
                    $c = $contact->get_contact_information($b['contact_id']);                    
                }   
                if(! empty($c)){
                ?>
                    <td id="contact_info_of_<?php echo($b['id']); ?>">
                        <a href="#">
                            <?php echo($c['name'])?>
                        </a>
                    </td>
                    <script>
                        jQuery(function($){

                            $("#contact_info_of_<?php echo($b['id']); ?>").popover({
                                title: '<h5 class="text-center text-info">ID: <?php echo($c['id']) ?>/ <?php echo($c['name']) ?></h5>',
                                content : '<ul width="100px"> \
                                <li>ID : <?php echo($c['id']) ?></li> \
                                <li>Address : <?php echo($c['address']) ?></li> \
                                <li>Phone : <?php echo($c['phone']) ?></li> \
                                <li>Email : <?php echo($c['email']) ?></li> \
                                </ul> \
                                <a class="btn btn-warning btn-sm" href="">View Contact Detail</a> ',
                                html : true,
                                
                                trigger : 'hover',                                
                            });
                        });
                    </script>
                <?php
                }
                else{
                    echo("<td></td>");
                }
                ?>
                
                <td><?php echo($b['updated_at']) ?></td>
                
                <td>
                    <a href="<?php echo(view_url("bills/view.php?id=".$b['id'])); ?>" class="btn btn-sm btn-dark mb-2"><small>View</small></a>
                    <br>
                    <a href="<?php echo(view_url("bills/edit.php?id=".$b['id'])); ?>" class="btn btn-sm btn-info"><small>Edit</small></a>

                    <form action="" class="m-2" method="POST" name="delete_bill_form"
                        id="delete_bill_form_<?php echo($b['id']); ?>">
                        <input type="hidden" value="<?php echo($b['id']) ?>" name="delete_bill_id"
                            id="delete_bill_id_<?php echo($b['id']) ?>">
                    </form>
                    <button class="btn btn-warning btn-sm" name="delete_bill_btn_<?php echo($b['id']); ?>"
                        id="delete_bill_btn_<?php echo($b['id']); ?>">
                        <small>Delete Bill</small></button>
                    <script>
                        jQuery(function($){
                            $("#delete_bill_btn_<?php echo($b['id']); ?>").click(function () {
                                var msg = "Do You Want To Delete the Bill Id: <?php echo($b['id']); ?> of Bills ?";
                                msg+= "\n  The bill will be deleted but the related transistion will be kept.";
                                var res = confirm(msg);
                                if (res == true) {
                                    $('#delete_bill_form_<?php echo($b['id']); ?>').submit();
                                } 
                            });
                        });
                        
                    </script>
                    <form action="" class="m-2" method="POST" name="delete_bill_and_transistion_form"
                        id="delete_bill_and_transistion_form_<?php echo($b['id']); ?>">
                        <input type="hidden" value="<?php echo($b['id']) ?>" name="delete_bill_and_transistion_id"
                            id="delete_bill_and_transistion_id_<?php echo($b['id']) ?>">
                    </form>
                    <button class="btn btn-danger btn-sm" name="delete_bill_and_transistion_btn_<?php echo($b['id']); ?>"
                        id="delete_bill_and_transistion_btn_<?php echo($b['id']); ?>">
                        <small>Delete Bill and Transistion</small></button>
                    <script>
                        jQuery(function($){
                            $("#delete_bill_and_transistion_btn_<?php echo($b['id']); ?>").click(function () {
                                var msg = "Do You Want To Delete the Bill Id: <?php echo($b['id']); ?> and all it's transistionof Bills ?";
                                msg+= "\n Bills and Transistions of the bill will be deleted permanently";
                                var res = confirm(msg);
                                if (res == true) {
                                    $('#delete_bill_and_transistion_form_<?php echo($b['id']); ?>').submit();
                                } 
                            });
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
</div>
<?php include_once(snippet("dashboard_bottom.php")); ?>