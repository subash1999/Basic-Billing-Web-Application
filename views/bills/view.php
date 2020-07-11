<?php include_once("helper_functions.php"); ?>
<?php
include_once(controller("BillController.php"));
include_once(controller("TransistionController.php"));
include_once(Controller("ContactController.php"));
include_once(Controller("WebsiteInfoController.php"));
$bill = new BillController();

if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header("Location: ".view_url("bills/bills.php"));
    exit;
}
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

<?php 


$bill = $bill->get_bill_information($id);

$transistions = new TransistionController();
$transistions = $transistions->get_transistions_of_bill($id);

$contact = new ContactController();
$related_contact = $contact->get_contact_information($bill['contact_id']);

$website_info = new WebsiteInfoController();
?>

<?php $header = "Bills/ View bill id : ".$id;?>
<?php include_once(snippet("dashboard_top.php")); ?>
<div class="container">
    <h3 class="text-primary text-center m-3 text-uppercase"><u>Bill Id: <?php echo($id); ?></u>
        <button class="print_button btn btn-info btn-lg float-right m-3">Print Bill</button>
    </h3>
    <div align="center">
        <form action="" method="POST" name="delete_bill_form"
            id="delete_bill_form_<?php echo($id); ?>">
            <input type="hidden" value="<?php echo($id) ?>" name="delete_bill_id"
                id="delete_bill_id_<?php echo($id) ?>">
        </form>
        <form action="" class="m-2" method="POST" name="delete_bill_and_transistion_form"
            id="delete_bill_and_transistion_form_<?php echo($id); ?>">
            <input type="hidden" value="<?php echo($id) ?>" name="delete_bill_and_transistion_id"
                id="delete_bill_and_transistion_id_<?php echo($id) ?>">
        </form>
        <a href="<?php echo(view_url("bills/bills.php")); ?>" class="btn btn-info btn-sm">All Bills</a>
        <a href="<?php echo(view_url("bills/edit.php?id=$id")); ?>" class="btn btn-secondary btn-sm">Edit</a>
        <button class="btn btn-warning btn-sm" name="delete_bill_btn_<?php echo($id); ?>"
            id="delete_bill_btn_<?php echo($id); ?>">
            <small>Delete Bill</small></button>
        <script>
            jQuery(function($){
                $("#delete_bill_btn_<?php echo($id); ?>").click(function () {
                    var msg = "Do You Want To Delete the Bill Id: <?php echo($id); ?> of Bills ?";
                    msg+= "\n  The bill will be deleted but the related transistion will be kept.";
                    var res = confirm(msg);
                    if (res == true) {
                        $('#delete_bill_form_<?php echo($id); ?>').submit();
                    } 
                });
            });            
        </script>
        <button class="btn btn-danger btn-sm" name="delete_bill_and_transistion_btn_<?php echo($id); ?>"
            id="delete_bill_and_transistion_btn_<?php echo($id); ?>">
            <small>Delete Bill and Transistion</small></button>
        <script>
            jQuery(function($){
                $("#delete_bill_and_transistion_btn_<?php echo($id); ?>").click(function () {
                    var msg = "Do You Want To Delete the Bill Id: <?php echo($id); ?> and all it's transistionof Bills ?";
                    msg+= "\n Bills and Transistions of the bill will be deleted permanently";
                    var res = confirm(msg);
                    if (res == true) {
                        $('#delete_bill_and_transistion_form_<?php echo($id) ?>').submit();
                    } 
                });
            });            
        </script>
    </div>
    <label for="contact_id" class="form-control-label">Related Contact:</label>
    <a href="<?php echo(view_url("contacts/view.php?id=".$related_contact['id'])); ?>">
        <b><?php echo($related_contact['name']);  ?></b>
    </a>
    <div id="bill_div" name="bill_div" class="pt-4 pr-4 pl-4 pb-4" style="border-width:6px;border-style:solid;">
        <h3 class="text-center text-truncate"><?php echo($website_info->get_name()); ?></h3>
        <h6 class="text-center text-truncate"><?php echo($website_info->get_address()); ?></h6>
        <h6 class="text-center text-truncate"><?php echo($website_info->get_phone()); ?></h6>
        <h6 class="text-center text-truncate"><?php echo($website_info->get_email()); ?></h6>
        <hr style="border-width:5px;border-color:pink;">
        <div class="form-group">
            <label for="bill_id" class="form-control-label"><u>Bill Id: <b><?php echo($bill['id']); ?></b></u></label>
            <br>
            <div class="float-right">
            <?php
            $date = (new DateTime($bill['created_at']))->format('Y-m-d');
            ?>
            <label for="date_time" class="form-control-label">Date:</label>
            <input type="text" name="input" placeholder="YYYY-MM-DD"
            pattern="(?:19|20)\[0-9\]{2}-(?:(?:0\[1-9\]|1\[0-2\])-(?:0\[1-9\]|1\[0-9\]|2\[0-9\])|(?:(?!02)(?:0\[1-9\]|1\[0-2\])-(?:30))|(?:(?:0\[13578\]|1\[02\])-31))" 
            title="Enter a date in this format YYYY-MM-DD" value="<?php echo($date); ?>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">Name: <b><?php echo($bill['name']); ?></b></label>
            <br>
            <label for="address" class="form-control-label">Address: <b><?php echo($bill['address']); ?></b></label>
            <br>
            <?php if($bill['contact_id'] != NUll && $bill['contact_id'] != "") { ?>
            <label for="phone" class="form-control-label">Phone:
                <b><?php echo($related_contact['phone']); ?></b></label>
            <br>
            <label for="email" class="form-control-label">Email:
                <b><?php echo($related_contact['email']); ?></b></label>
            <?php } ?>
        </div>

        <hr style="border-width:5px;">
        <div>
            <table class="table table-bordered table-hover" style="height:100px;" id="transistion_table"
                name="transisiton_table">
                <thead>
                    <th>S.N</th>
                    <th>Transistion Title</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Transistion Description</th>
                </thead>
                <tbody>
                    <?php 
                $sn = 1;
                $total_quantities = 0;
                $grand_total_price = 0;
                foreach($transistions as $t){?>
                    <tr>
                        <td><?php echo($sn)?></td>
                        <td><?php echo($t['title']); ?></td>
                        <td>Rs <?php echo($t['rate']); ?></td>
                        <td><?php echo($t['quantity']); ?></td>
                        <td>Rs <?php echo($t['rate']*$t['quantity']); ?></td>
                        <td><?php echo($t['description']); ?></td>
                    </tr>
                    <?php
                $sn++;
                $total_quantities += $t['quantity'];
                $grand_total_price += $t['rate']*$t['quantity'];
                }?>

                </tbody>
            </table>
            </div>
            <br><br>
            <hr>
            <label class="float-left">Total Quantities : <b><span
                        id="total_quantities"><?php echo($total_quantities); ?></span></b></label>
            <label class="float-right">Grand Total Price : Rs <b><span
                        id="grand_total"><?php echo($grand_total_price); ?></span></b></label>
            <br><br>
            <hr style="border-width:5px;">
            <div class="form-group">
                <label for="bill_description">Bill Description : </label>
                <textarea name="bill_description" id="bill_description" rows="3" class="form-control"
                    disabled><?php echo($bill['description']); ?></textarea>
            </div>
            <br>

        </div>
        <h3><button class="print_button btn btn-info btn-lg float-right m-3">Print Bill</button></h3>
    </div>


    <script>
        jQuery(function ($) {

            $(".print_button").click(function () {
                var print_contents = document.getElementById("bill_div").innerHTML;
                print_contents = encodeURIComponent(print_contents)
                var my_window = window.open('<?php echo(view_url("print.php")); ?>'+'?content_to_print='+print_contents+'','PRINT');               

            });
            function printElementById(id) {
                
                document.body.innerHTML = print_contents;
                window.print();
                document.body.innerHTML = original_contents;
            }
        });
    </script>

    <?php include_once(snippet("dashboard_bottom.php")); ?>