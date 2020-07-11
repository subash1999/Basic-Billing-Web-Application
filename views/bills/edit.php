<?php include_once("helper_functions.php"); ?>
<?php 
include_once(controller("BillController.php"));
include_once(Controller("TransistionController.php"));
include_once(Controller("ContactController.php"));
?>
<?php
if(isset($_POST['delete_from_bill'])){
    $transistion = new TransistionController();
    $transistion->set_bill_id_null($_POST['transistion_id']);
    $bill_id = $_POST['bill_id'];
    unset($_POST);
    header("Location: ".view_url("bills/edit.php?id=".$bill_id."#transistions_table"));
    exit;
}
if(isset($_POST['delete_transistion'])){
    $transistion = new TransistionController();
    $transistion->delete_transistion($_POST['transistion_id']);
    $bill_id = $_POST['bill_id'];
    unset($_POST);
    header("Location: ".view_url("bills/edit.php?id=".$bill_id."#transistions_table"));
    exit;
}
if(isset($_POST['add_existing_transistion_to_bill'])){
    $transistion = new TransistionController();
    $transistion->update_bill_id_of_transistion($_POST['transistion_id'],$_POST['bill_id']);
    $bill_id = $_POST['bill_id'];
    unset($_POST);
    header("Location: ".view_url("bills/edit.php?id=".$bill_id."#add_existing_transistion_header"));
    exit;
}
?>
<?php
if(isset($_POST['save_changes'])){
    $bill = new BillController();
    $transistion = new TransistionController();
    $bill_id = $_POST['bill_id'];
    $bill_dict = array();
    $bill_dict['name'] =$_POST['name'];
    $bill_dict['address'] = $_POST['address'];
    $bill_dict['contact_id'] = $_POST['contact_id'];
    $bill_dict['description'] = $_POST['bill_description'];
    $bill->edit_bill($bill_id,$bill_dict);
    $transistion->update_contact_id_related_to_bill($bill_id,$bill_dict['contact_id']);
    unset($_POST);
    header("Location: ".view_url("bills/edit.php?id=$bill_id"));
    exit;
}
if(isset($_POST['add_transistion'])){
    $transistion = new TransistionController();
    $bill = new BillController();
    $bill_info = $bill->get_bill_information($_POST['bill_id']);
    $transistion_dict = array();
    $transistion_dict['title'] = $_POST['title'];
    $transistion_dict['name'] = $bill_info['name'];
    $transistion_dict['address'] = $bill_info['address'];
    $transistion_dict['quantity'] = $_POST['quantity'];
    $transistion_dict['rate'] = $_POST['rate'];
    $transistion_dict['contact_id'] = $bill_info['contact_id'];
    $transistion_dict['bill_id'] = $bill_info['id'];
    $transistion_dict['description'] = $_POST['description'];
    $transistion->add_sell($transistion_dict);
    $bill_id = $_POST['bill_id'];
    unset($_POST);
    header("Location: ".view_url("bills/edit.php?id=$bill_id#transistions_table"));
    exit;

}
?>
<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header("Location: ".view_url("bills/bills.php"));
    exit;
}
?>
<?php 
$bill = new BillController();
$bill = $bill->get_bill_information($id);
$transistions = new TransistionController();
$transistions = $transistions->get_transistions_of_bill($id);
$contact = new ContactController();
$related_contact = $contact->get_contact_information($bill['contact_id']);
include_once(Controller("WebsiteInfoController.php"));
$website_info = new WebsiteInfoController();
?>
<?php $header = "Bills/ Edit bill id : ".$id;?>
<?php include_once(snippet("dashboard_top.php")); ?>
<div class="container">
    <h3 class="text-primary text-center m-3 text-uppercase"><u>Bill Id: <?php echo($id); ?></u></h3>
    <div align="center" class="m-2">
        <a href="<?php echo(view_url("bills/bills.php")); ?>" class="btn btn-secondary">All Bills</a>
        <a href="<?php echo(view_url("bills/view.php?id=$id")); ?>" class="btn btn-info">View</a>
    </div>
    <div style="border-width:6px;border-style:solid;" class="pt-4 pr-4 pl-4 pb-4">
        <form action="" name="new_bill" id="new_bill" method="POST">
            <h3 class="text-center text-truncate"><?php echo($website_info->get_name()); ?></h3>
            <h6 class="text-center text-truncate"><?php echo($website_info->get_address()); ?></h6>
            <h6 class="text-center text-truncate"><?php echo($website_info->get_phone()); ?></h6>
            <h6 class="text-center text-truncate"><?php echo($website_info->get_email()); ?></h6>
            <hr style="border-width:5px;border-color:pink;">
            <h4 class="text-uppercase">Bill General Information</h4>
            <input type="hidden" name="bill_id" value="<?php echo($bill['id']); ?>">
            <div class="form-group">
                <label for="contact_id" class="form-control-label">Contact:</label>
                <select name="contact_id" id="contact_id" class="form-control">
                    <option value="NULL" selected="selected" class="contact_id_option"></option>
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
                    if($bill['contact_id']==$c['id']){
                        $selected = "selected";
                    }
                    ?>
                    <option value="<?php echo($c['id']) ?>" <?php echo($selected) ?> class="contact_id_option"><?php echo($option) ?></option>
                    <?php } ?>
                    <?php foreach($contact->get_contacts() as $c){ ?>
                    <input type="hidden" id="contact_name_<?php echo($c['id']); ?>" value="<?php echo($c['name']); ?>">
                    <input type="hidden" id="contact_address_<?php echo($c['id']); ?>"
                        value="<?php echo($c['address']); ?>">
                    <input type="hidden" id="contact_phone_<?php echo($c['id']); ?>"
                        value="<?php echo($c['phone']); ?>">
                    <input type="hidden" id="contact_email_<?php echo($c['id']); ?>"
                        value="<?php echo($c['email']); ?>">
                    <?php } ?>
                </select>
                <br>
                <button type="button" class="btn btn-sm btn-warning" id="copy_contact_information_btn">Copy Contact
                    Information Below</button>
                <script>
                    jQuery(function ($) {
                        $("#copy_contact_information_btn").click(function () {
                            $("#name").val($("#contact_name_"+$(".contact_id_option:selected").val()).val());
                            $("#address").val($("#contact_address_"+$(".contact_id_option:selected").val()).val());
                        });
                    });
                </script>
            </div>
            <div class="form-group">
                <label for="name" class="form-control-label">Name: </label>
                <input type="text" class="form-control" name="name" id="name" class="form-control-inline"
                    required="required" value="<?php echo($bill['name']); ?>">
            </div>
            <div class="form-group">
                <label for="address" class="form-control-label">Address: </label>
                <input type="text" class="form-control" name="address" id="address" class="form-control-inline"
                    value="<?php echo($bill['address']); ?>">
            </div>
            <div class="form-group">
                <label for="bill_description">Bill Description : </label>
                <textarea name="bill_description" id="bill_description" rows="3"
                    class="form-control"><?php echo($bill['description']); ?></textarea>
            </div>
            <input type="submit" value="Save Changes" name="save_changes" class="btn btn-primary">
            <br>
        </form>
        <hr style="border-width:5px;">
        <h4 class="text-uppercase">ADD NEW TRANSISTION</h4>
        <form action="" method="POST">
            <input type="hidden" name="bill_id" value="<?php echo($bill['id']); ?>">            
            <div class="form-group">
                <label for="title" class="form-control-label">Transisiton Title</label>
                <input type="text" class="form-control" name="title" id="title" required="required">
            </div>
            <div class="form-group">
                <label for="rate" class="form-control-label">Rate (in Rs)</label>
                <input type="number" step="0.001" class="form-control" name="rate" id="rate" required="required">
            </div>
            <div class="form-group">
                <label for="quantity" class="form-control-label">Quantity</label>
                <input type="number" step="0.001" class="form-control" name="quantity" id="quantity"
                    required="required">
            </div>
            <div class="form-group">
                <label for="amount" class="form-control-label">Amount (in Rs)</label>
                <input type="number" step="0.001" class="form-control" name="amount" id="amount"
                    required="required">
            </div>
            <div class="form-group">
                <label for="description" class="form-control-label">Transistion Description</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>
            <input type="submit" value="Add New Transistion" name="add_transistion" class="btn btn-info">
            <script>
                jQuery(function($){
                    $("#rate,#quantity,#amount").change(function(){
                        var rate = $("#rate").val();
                        var quantity = $("#quantity").val();
                        $("#amount").val(rate*quantity);
                    });
                });
            </script>
        </form>
        <hr style="border-width:5px;">
        <h4 class="text-uppercase" id="add_existing_transistion_header">ADD EXISTING SELL TRANSISTION</h4>
        <!-- Large modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">View Existing Sell Transistions</button>

        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CHOOSE EXISTING SELL TRANSISTION</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <script>
                        jQuery(function ($) {
                            $('#existing_transistions_table').DataTable({
                                "scrollY": "300px",
                                "scrollX": true,
                                "scrollCollapse": false,
                                stateSave: true,
                                fixedHeader: true,
                            });
                        });
                    </script>
                    <?php
                    $existing_sell_transistions = new TransistionController();
                    $existing_sell_transistions = $existing_sell_transistions->get_sell_transistions();
                    ?>
                     <table class="table table-bordered table-hover" id="existing_transistions_table">
                        <thead>
                            <th>S.N</th>
                            <th>ID</th>                            
                            <th>Bill ID</th>
                            <th>Action</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Quantity</th>
                            <th>Rate</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Related Contact</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            
                            
                        </thead>
                        <tbody>
                            <?php $sn = 1; ?>
                            <?php foreach($existing_sell_transistions as $t){?>
                            <tr>
                                <td><?php echo($sn); ?></td>
                                <td><?php echo($t['id']); ?></td>
                                <td>
                                <?php 
                                    if($t['bill_id']!=""){
                                    ?>
                                    <a href="<?php echo(view_url("bills/view.php?id=".$t['bill_id'])); ?>">
                                        <?php echo($t['bill_id']); ?>
                                    </a>
                                    <?php
                                    }
                                    else{
                                        echo($t['bill_id']);
                                    }
                                ?>
                                </td>
                                <td>
                                    <a href="<?php echo(view_url("transistions/view.php?id=".$t['id'])); ?>" class="btn btn-sm btn-dark mb-2"><small>View</small></a>
                                    <br>
                                    <a href="<?php echo(view_url("transistions/edit.php?id=".$t['id'])); ?>" class="btn btn-sm btn-info"><small>Edit</small></a>  
                                    <br>
                                    <?php if($t['bill_id']==NULL || $t['bill_id']==""){?>
                                    <form action="" name="add_existing_transistion_to_bill_form" method="POST">
                                        <input type="hidden" name="bill_id" value="<?php echo($id); ?>">
                                        <input type="hidden" name="transistion_id" value="<?php echo($t['id']) ?>">
                                        <input type="submit" value="Add to Bill" name="add_existing_transistion_to_bill" class="btn btn-primary btn-sm mt-2">
                                    </form>   
                                    <?php }
                                    else if($id==$t['bill_id']){
                                        echo("<span class=\"text-warning\">Already Added To This Bill</span>");
                                    }
                                    else if($t['bill_id']!=NULL && $id!=$t['bill_id']){
                                        $bill_id = $t['bill_id'];
                                        echo("Added To Another <a href=\"".view_url("bills/view.php?id=$bill_id")."\" target=\"_blank\"> Bill ID: ".$t['bill_id']."</a>");
                                    }
                                    ?>                           
                                </td>
                                <td><?php echo($t['title']) ?></td>
                                <td><?php echo($t['name']) ?></td>
                                <td><?php echo($t['address']) ?></td>
                                <td><?php echo($t['quantity']) ?></td>
                                <td>Rs <?php echo($t['rate']) ?></td>
                                <td>Rs <?php echo($t['quantity']*$t['rate']) ?></td>
                                <td><?php echo($t['description']) ?></td>
                                <?php
                                $c = ""; 
                                if(! empty($t['contact_id'])){
                                    $c = $contact->get_contact_information($t['contact_id']);
                                    
                                }   
                                if(! empty($c)){
                                ?>
                                    <td id="contact_info_of_<?php echo($t['id']); ?>">
                                        <a href="<?php echo(view_url("contacts/view.php?id=".$t['contact_id'])); ?>">
                                            <?php echo($c['name'])?>
                                        </a>
                                    </td>
                                    <script>
                                        jQuery(function($){

                                            $("#contact_info_of_<?php echo($t['id']); ?>").popover({
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
                                <td><?php echo($t['created_at']) ?></td>
                                <td><?php echo($t['updated_at']) ?></td>
                                                                
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>

        <hr style="border-width:5px;">
        <script>
            jQuery(function ($) {
                $('#transistions_table').DataTable({
                    "scrollY": "500px",
                    "scrollX": true,
                    "scrollCollapse": false,
                    stateSave: true,
                    fixedHeader: true,
                });
            });
        </script>
        <table class="table table-bordered table-hover" style="height:100px;" id="transistions_table"
            name="transistions_table">
            <thead>
                <th>S.N</th>
                <th>ID</th>
                <th>Transistion Title</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Transistion Description</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php 
                $sn = 1;
                $total_quantities = 0;
                $grand_total_price = 0;
                foreach($transistions as $t){?>
                <tr>
                    <td><?php echo($sn)?></td>
                    <td><?php echo($t['id'])?></td>
                    <td><?php echo($t['title']); ?></td>
                    <td>Rs <?php echo($t['rate']); ?></td>
                    <td><?php echo($t['quantity']); ?></td>
                    <td>Rs <?php echo($t['rate']*$t['quantity']); ?></td>
                    <td><?php echo($t['description']); ?></td>
                    <td>
                        <a href="<?php echo(view_url("transistions/edit.php?id=").$t['id']); ?>"
                            class="btn btn-info btn-sm text-white mt-1"><small>Edit</small></a>
                        <form action="" method="POST" name="delete_from_bill_form" id="delete_from_bill_form_<?php echo($t['id']); ?>">
                            <input type="hidden" value="<?php echo($t['id']); ?>" 
                            name="transistion_id" id="transistion_id_<?php echo($t['id']); ?>">
                            <input type="hidden" name="bill_id" value="<?php echo($id); ?>">
                            <input type="hidden" name="delete_from_bill">
                        </form>
                        <form action="" method="POST" name="delete_transistion_form" id="delete_transistion_form_<?php echo($t['id']); ?>">
                            <input type="hidden" value="<?php echo($t['id']); ?>"
                            name="transistion_id" id="transistion_id_<?php echo($t['id']); ?>">
                            <input type="hidden" name="bill_id" value="<?php echo($id); ?>">
                            <input type="hidden" name="delete_transistion">
                        </form>
                        <button class="btn btn-warning btn-sm mt-1" id="delete_from_bill_btn_<?php echo($t['id']) ?>">
                            <small>Delete From Bill</small>
                        </button>                        
                        <button class="btn btn-danger btn-sm mt-1" id="delete_transistion_btn_<?php echo($t['id']) ?>">
                            <small>Delete Transistion</small>
                        </button>
                        <script>
                            $(function () {
                                $("#delete_from_bill_btn_<?php echo($t['id']) ?>").click(function(){
                                    var res = confirm("Delete the Transition with Transistion ID <?php echo($t['id']) ?>?\n The Transistion will remain but deleted from bill");
                                    if(res == true){
                                        $("#delete_from_bill_form_<?php echo($t['id']); ?>").submit();
                                    }
                                });
                                $("#delete_transistion_btn_<?php echo($t['id']) ?>").click(function(){
                                    var res = confirm("Delete the Transition with Transistion ID <?php echo($t['id']) ?>?\n The Transistion will be deleted completely");
                                    if(res == true){
                                        $("#delete_transistion_form_<?php echo($t['id']); ?>").submit();
                                    }
                                });
                            });
                        </script>
                    </td>
                </tr>
                <?php
                $sn++;
                $total_quantities += $t['quantity'];
                $grand_total_price += $t['rate']*$t['quantity'];
                }?>
            </tbody>
        </table>
        <br><br>
        <hr>
        <label class="float-left">Total Quantities : <b><span
                    id="total_quantities"><?php echo($total_quantities); ?></span></b></label>
        <label class="float-right">Grand Total Price : Rs <b><span
                    id="grand_total"><?php echo($grand_total_price); ?></span></b></label>
        <br><br>
    </div>
</div>
<?php include_once(snippet("dashboard_bottom.php")); ?>