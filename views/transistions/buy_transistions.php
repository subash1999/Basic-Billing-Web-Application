<?php include_once("helper_functions.php"); ?>
<?php
include_once(controller("TransistionController.php"));
include_once(controller("ContactController.php"));
include_once(controller("BillController.php"));
$transistion = new TransistionController();
$contact = new ContactController();

?>
<?php
if(isset($_POST)){
    if(isset($_POST["delete_transistion_id"])){
        $transistion->delete_transistion($_POST["delete_transistion_id"]);
        unset($_POST);
        header("Location: ".view_url("transistions/buy_transistions.php?id=$new_bill_id"));
        exit;
    }
    if(isset($_POST['create_bill_from_transistion'])){
        $transistion_id = $_POST['transistion_id'];
        $transistion = new TransistionController();
        $transistion = $transistion->get_transistion_information($transistion_id);
        $bill_dict = array();
        $bill_dict['name'] = $transistion['name'];
        $bill_dict['address'] = $transistion['address'];
        $bill_dict['bill_description'] = $transistion['description'];
        $bill_dict['contact_id'] = $transistion['contact_id'];
        $bill = new BillController();
        $new_bill_id = $bill->add_bill($bill_dict);
        $transistion = new TransistionController();
        $transistion->update_bill_id_of_transistion($transistion_id,$new_bill_id);
        unset($_POST);
        header("Location: ".view_url("bills/view.php?id=$new_bill_id"));
        exit;

    }
}
$transistions = $transistion->get_buy_transistions();
if(isset($_GET['date'])){
    $date = $_GET['date'];
    if($date == NULL || empty($date) ){
        header("Location: ".view_url("transistions/buy_transistions.php"));
        exit;
    }
    else{
        $transistions = $transistion->get_buy_transistions_of_date($date);
    }
}
?>
<?php $header = "Transistions";?>
<?php include_once(snippet("dashboard_top.php")); ?>

<script>
jQuery(function ($) {
    $('[data-toggle="popover"]').popover();
});
jQuery(function ($) {    
    $('#transistions_table').DataTable({
        "scrollY": "260px",
        "scrollX": true,
        "scrollCollapse": false,
        stateSave: true,       
        fixedColumns:   {
            leftColumns: 2,
            rightColumns: 1
        }, 
    });
});
</script>
<div class="container">
    <h3 class="text-primary text-center text-uppercase m-3"><u>Transistions</u></h3>
    <hr>
    <h5>Transistions of Particular Date : <input type="date" id="filter_date" <?php if(isset($date)){echo("value=\"$date\"");}?>>
    <button class="btn btn-primary m-3 btn-sm" id="filter_by_date_btn">Filter By Date</button></h5>
    <script>
        $("#filter_by_date_btn").click(function(){
            var date_val = $("#filter_date").val();
            var new_location = "<?php echo(view_url("transistions/buy_transistions.php")); ?>?date="+date_val;
            window.location.assign(new_location);
        });
    </script>
    
    <?php
    if(isset($date)){
        echo("<h3 class=\"text-center text-blue\">Date: $date</h3>");
        echo("<h5 style=\"font-weight:normal;\">Transistion is showed below for date: <span style=\"font-weight:bold;\"><u>".$date."</u></span></h5>");
        ?>
        <h5 style="font-weight:normal;">Total Transistion Amount For Date (<?php echo($date) ?>): 
            <span style="font-weight:bold;"> Rs <?php echo($transistion->get_total_transistion_amount_of_date($date)); ?></span>
        </h5>
        <h5 style="font-weight:normal;">Total Sell Amount For Date (<?php echo($date) ?>): 
            <span style="font-weight:bold;"> Rs <?php echo($transistion->get_total_sell_amount_of_date($date)); ?></span>
        </h5>
        <h5 style="font-weight:normal;">Total Buy Amount For Date (<?php echo($date) ?>): 
            <span style="font-weight:bold;"> Rs <?php echo($transistion->get_total_buy_amount_of_date($date)); ?></span>
        </h5>
        <h5 style="font-weight:normal;">Net Profit For Date (<?php echo($date) ?>): 
            <span style="font-weight:bold;"> Rs <?php echo($transistion->get_total_sell_amount_of_date($date)-$transistion->get_total_buy_amount_of_date($date)); ?></span>
        </h5>
        <?php
    }
    ?>
    <hr>
    <table class="table-bordered" id="transistions_table">
        <thead>
            <th>S.N</th>
            <th>ID</th>
            <th>Bill ID</th>
            <th>Type</th>
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
            <th>Action</th>
        </thead>
        <tbody>
            <?php $sn = 1; ?>
            <?php foreach($transistions as $t){?>
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
                <td><?php echo($t['type']) ?></td>
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
                
                <td>
                    <a id="view_<?php echo($t['id']); ?>" href="<?php echo(view_url("transistions/view.php?id=".$t['id'])); ?>" class="btn btn-sm btn-dark mb-2"><small>View</small></a>
                    <br>
                    <a href="<?php echo(view_url("transistions/edit.php?id=".$t['id'])); ?>" class="btn btn-sm btn-info"><small>Edit</small></a>
                    <form action="" class="m-2 delete_transistion_form_<?php echo($t['id']); ?>" 
                    method="POST" name="delete_transistion_form">
                        <input type="hidden" value="<?php echo($t['id']) ?>" name="delete_transistion_id">
                    </form>
                    <button class="btn btn-danger btn-sm delete_transistion_btn_<?php echo($t['id']); ?>"
                     name="delete_transistion_btn_<?php echo($t['id']); ?>">Delete</button>
                        
                    <script>
                        jQuery(function($){
                            $(".delete_transistion_btn_<?php echo($t['id']); ?>").click(function () {
                                var res = confirm("Do You Want To Delete the Transistion Id <?php echo($t['id']); ?> of Transistion ?");
                                if (res == true) {
                                    $('.delete_transistion_form_<?php echo($t['id']); ?>').submit();
                                } 
                            });
                        });
                        
                    </script>
                    <?php 
                    if(strcasecmp($t['type'],'Sell')==0){
                    if($t['bill_id']==NUll || $t['bill_id']==""){?>
                    <form action="" method="POST" name="create_bill_from_transistion_form">
                        <input type="hidden" name="transistion_id" value="<?php echo($t['id']); ?>">
                        <input type="submit" value="Create Bill" class="btn btn-sm btn-secondary mt-2" name="create_bill_from_transistion">
                    </form>
                    <?php }
                    else{
                        $temp_bill_id = $t['bill_id'];
                        echo("<a href=\"".view_url("bills/view.php?id=$temp_bill_id")."\" class=\"btn btn-secondary btn-sm mt-2\"><small>View Bill ".$t['bill_id']."</small></a>");
                    }
                }
                    ?>
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