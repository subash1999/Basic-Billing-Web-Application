<?php include_once("helper_functions.php"); ?>

<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];
}
else{
    header("Location: ".view_url("transistions/transistions.php"));
    exit;
}

include_once(controller('TransistionController.php'));
$transistion = new TransistionController();
$t = $transistion->get_transistion_information($id);
include_once(controller('ContactController.php'));
$contact = new ContactController();

if(isset($_POST)){
    if(isset($_POST["delete_transistion_id"])){
        $transistion->delete_transistion($_POST["delete_transistion_id"]);
        unset($_POST);
        header("Location: ".view_url("transistions/transistions.php"));
        exit;
    }
}

?>
<?php $header = "Transistion/ View : ".$id;?>
<?php include_once(snippet("dashboard_top.php")); ?>
<div class="container">
    <form action="" method="POST" name="delete_transistion_form"
        id="delete_transistion_form_<?php echo($t['id']); ?>">
        <input type="hidden" value="<?php echo($t['id']) ?>" name="delete_transistion_id"
            id="delete_transistion_id_<?php echo($t['id']) ?>">
    </form>    
    <h3 class="text-primary text-center mt-2 text-uppercase"><u>Transistion : <?php echo($id); ?></u></h3>
    <div align="center" class="mt-1 mr-3 ml-3">       
        <a href="<?php echo(view_url("transistions/edit.php?id=".$id)); ?>" class="btn btn-info btn-sm">Edit</a>    
        <button class="btn btn-danger btn-sm" name="delete_transistion_btn_<?php echo($t['id']); ?>"
            id="delete_transistion_btn_<?php echo($t['id']); ?>">
        <small>Delete</small></button>
        <script>
            jQuery(function($){
                $("#delete_transistion_btn_<?php echo($t['id']); ?>").click(function () {
                    var res = confirm("Do You Want To Delete the Transistion Id <?php echo($t['id']); ?> of Transistion ?");
                    if (res == true) {
                        $('#delete_transistion_form_<?php echo($t['id']); ?>').submit();
                    } 
                });
            });            
        </script>

        <br><br>
        <a href="<?php echo(view_url("transistions/transistions.php")); ?>" class="btn btn-warning">View All Transistions</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo(view_url("transistions/new_buy.php")); ?>" class="btn btn-secondary">New Buy</a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a href="<?php echo(view_url("transistions/new_sell.php")); ?>" class="btn btn-dark">New Sell</a>
    </div>
    
    <br>
    <div class="alert alert-info m-2">
    <h6>ID : <?php echo($t['id']); ?></h6>
    <h6>Type : <?php echo($t['type']); ?></h6>
    <h6>Title : <?php echo($t['title']); ?></h6>
    <h6><a href="<?php echo(view_url("bills/view.php?id=".$t['bill_id'])); ?>">Bill ID: <?php echo($t['bill_id']); ?></a></h6>
    <h6>Name : <?php echo($t['name']); ?></h6>
    <h6>Address : <?php echo($t['address']); ?></h6>
    <h6>Quantity : <?php echo($t['quantity']); ?></h6>
    <h6>Rate : Rs <?php echo($t['rate']); ?></h6>
    <h6>Amount : Rs <?php echo($t['quantity']*$t['rate']); ?></h6>
    <h6>Description : <?php echo($t['description']); ?></h6>
    <?php
    $c = ""; 
    if(! empty($t['contact_id'])){
        $c = $contact->get_contact_information($t['contact_id']);
    }                
    if(! empty($c)){
    ?>
        <h6 id="contact_info_of_<?php echo($t['id']); ?>">
            <a href="<?php echo(view_url("contacts/view.php?id=".$t['contact_id'])); ?>">
            Related Contact : 
                <?php echo($c['name'])?>
            </a>
        </h6>
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
        echo("<h6>Related Contact : </h6>");
    }
    ?>
    <hr>
    <h6>Updated At : <?php echo($t['updated_at']); ?></h6>
    <h6>Created At : <?php echo($t['created_at']); ?></h6>

    </div>

</div>
<?php include_once(snippet("dashboard_top.php")); ?>