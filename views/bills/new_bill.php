<?php include_once("helper_functions.php"); ?>
<?php 
include_once(controller("ContactController.php"));
include_once(Controller("WebsiteInfoController.php"));
$contact = new ContactController();
$website_info = new WebsiteInfoController();
?>
<?php
if(! empty($_POST)){
    include_once(controller("BillController.php"));
    $bill = new BillController();
    $last_inserted_id = $bill->add_bill($_POST);    
    unset($_POST);
    header("Location: ".view_url("bills/view.php?id=$last_inserted_id"));
    exit;
} 
?>
<?php $header = "Bills/ New Buy";?>
<?php include_once(snippet("dashboard_top.php")); ?>
<div class="container">
    <h3 class="text-primary text-center m-3 text-uppercase"><u>New Bill</u></h3>
    
    <form action="" name="new_bill" id="new_bill" method="POST"
     class="pt-4 pr-4 pl-4 pb-4" style="border-width:6px;border-style:solid;">
        <h3 class="text-center text-truncate"><?php echo($website_info->get_name()); ?></h3>
        <h6 class="text-center text-truncate"><?php echo($website_info->get_address()); ?></h6>
        <h6 class="text-center text-truncate"><?php echo($website_info->get_phone()); ?></h6>
        <h6 class="text-center text-truncate"><?php echo($website_info->get_email()); ?></h6>
        <hr style="border-width:5px;border-color:pink;">
        <div class="form-group">
            <label for="contact_id" class="form-control-label">Contact Id:</label>
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
            <script>
                jQuery(function($){
                    $("#copy_contact_information_btn").click(function(){
                        $("#name").val($("#contact_name_"+$("option:selected").val()).val());
                        $("#address").val($("#contact_address_"+$("option:selected").val()).val());
                    });
                });
            </script>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">Name: </label>
            <input type="text" class="form-control" name="name" id="name" class="form-control-inline" required="required">
        </div>
        <div class="form-group">
            <label for="address" class="form-control-label">Address: </label>
            <input type="text" class="form-control" name="address" id="address" class="form-control-inline">
        </div>
        <hr style="border-width:5px;">
        <div style="overflow-x:scroll;overflow-y:scroll;height:350px;">
            <table class="table table-bordered table-hover" style="height:100px;"
             id="transistion_table" name="transisiton_table">
                <thead>
                    <th>S.N</th>
                    <th>Transistion Title</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Transistion Description</th>
                    <th>Action</th>
                </thead>
                <tbody>
                <script>
                    var sn = 1;
                </script>
                    <tr id="table_row_1">
                        <td>1</td>
                        <td><input type="text" class="form-control" name="title[]" id="title_1" required="required"></td>
                        <td>Rs<input min="0" type="number" class="form-control" name="rate[]" id="rate_1" step="0.001" required="required"></td>
                        <td><input min="0" type="number" class="form-control transistion_quantity" name="quantity[]" id="quantity_1" required="required"></td>
                        <td>Rs<input min="0" class="form-control transistion_total" type="number" id="total_1" name="total[]" required="required"></td>
                        <td><textarea name="description[]" id="description_1" cols="16" rows="3"></textarea></td>
                        <td> </td>
                        <script>
                        $(function(){
                            $("#rate_1,#quantity_1,#total_1").change(function(){
                                $("#total_1").val($("#rate_1").val()*$("#quantity_1").val());     
                                var values = $("[name=\"total[]\"").map(function(){return $(this).val();}).get();
                                var sum = values.reduce(function(a,b){
                                    return Number(a)+Number(b);
                                });
                                $("#grand_total").html(sum);
                                var quantities = $("[name=\"quantity[]\"").map(function(){return $(this).val();}).get();

                                var sum = quantities.reduce(function(a,b){
                                    return Number(a)+Number(b);
                                });
                                $("#total_quantities").html(sum);                           
                            });                                
                            
                        });
                    </script>
                    </tr>                    
                </tbody>
            </table>                        
        </div>
        <button type="button" id="add_new_row" name="add_new_row" class="btn btn-info mb-3 float-left">Add Row</button>
        <script>
            $(function(){
                $("#add_new_row").click(function() {
                    sn+=1;
                    var new_row = "<tr id=table_row_"+sn+">" +
                        "<td>"+sn+"</td>" +
                        "<td><input type=\"text\" class=\"form-control\" name=\"title[]\" id=\"title_"+sn+"\" required=\"required\"></td>" +
                        "<td>Rs<input min=\"0\" type=\"number\" class=\"form-control\" name=\"rate[]\" id=\"rate_"+sn+"\" step=\"0.001\" required=\"required\"></td>" +
                        "<td><input min=\"0\" type=\"number\" class=\"form-control \" name=\"quantity[]\" id=\"quantity_"+sn+"\" required=\"required\"></td>" +
                        "<td>Rs<input min=\"0\" class=\"form-control\" type=\"number\" id=\"total_"+sn+"\" name=\"total[]\" required=\"required\"></td>"+
                        "<td><textarea name=\"description[]\" id=\"description_"+sn+"\" cols=\"16\" rows=\"3\"></textarea></td>" +
                        "<td>" +                       
                            "<button type=\"button\" id=\"delete_transistion_btn_"+sn+"\" class=\"btn btn-sm btn-danger m-1\">" +
                            "<small>Delete</small></button>" +                     
                        "</td>" +
                        "<script>"+
                            "$(function(){"+
                                "$(\"#delete_transistion_btn_"+sn+"\").click(function(){"+
                                    "$(\"#table_row_"+sn+"\").remove();"+
                                "});"+
                                "$(\"#rate_"+sn+",#quantity_"+sn+",#total_"+sn+"\").change(function(){"+
                                    "$(\"#total_"+sn+"\").val($(\"#rate_"+sn+"\").val()*$(\"#quantity_"+sn+"\").val());"+
                                    "var values = $(\"[name='total[]'\").map(function(){return $(this).val();}).get();"+
                                    "var sum = values.reduce(function(a,b){"+
                                        "return Number(a)+Number(b);"+
                                    "});"+
                                    "$(\"#grand_total\").html(sum);"+
                                    "var quantities = $(\"[name='quantity[]'\").map(function(){return $(this).val();}).get();"+
                                    "var sum = quantities.reduce(function(a,b){"+                                    
                                        "return Number(a)+Number(b);"+
                                    "});"+
                                    "$(\"#total_quantities\").html(sum);"+    
                                "});"+                                
                            "});"+                            
                        "\</script\>"+
                        "</tr>";
                    $("#transistion_table tbody").append(new_row);
                });
            });
        </script>
        <br><br>
        <hr>
        <label class="float-left">Total Quantities : <b><span id="total_quantities">0</span></b></label>
        <label class="float-right">Grand Total Price : Rs <b><span id="grand_total">0</span></b></label>
        <br><br>
        <hr style="border-width:5px;">
        <div class="form-group">
            <label for="bill_description">Bill Description : </label>
            <textarea name="bill_description" id="bill_description" rows="3" class="form-control"></textarea>
        </div>
        <br>
        <input type="submit" value="Submit" class="btn btn-primary">
    </form>
</div>

<?php include_once(snippet("dashboard_bottom.php")); ?>