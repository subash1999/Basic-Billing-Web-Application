<?php include_once("helper_functions.php"); ?>
<?php
if(isset($_POST)){
    if(isset($_POST["delete_photo_id"])){
        $photo_name_to_delete = website_info()->get_val_from_id($_POST["delete_photo_id"]);
        $uploads_deleted = True;
        if(!unlink(rel_path_to_abs_path(uploads($photo_name_to_delete)))){
            $uploads_deleted = False;
        }
        $ret = website_info()->delete_website_info($_POST["delete_photo_id"]);
        if($ret){
            if(!$uploads_deleted){
                $msg = "Slideshow photo deletion failed !!! Not deleted from uploads folder but it is deleted from database.";
                
            }
            else{
                $msg = "Slideshow photo deleted successfully!!! both from uplads folder and database";
            }
            echo("<script>alert('$msg');</script>");
            unset($_POST);
            header("Location: ".current_url());
            exit;
        }
    }
}
?>
<?php

?>

<?php $header = "Website / Slideshow"; ?>
<?php include_once(snippet("dashboard_top.php")); ?>
<h3 class="text-center text-primary m-3">Add New Photo to Slideshow</h3>

<?php include_once(snippet("new_carousel_photo.php")); ?>


<hr style="border-width:5px;border-color:pink;">

<h3 class="text-center text-primary m-3"><u>Available Slideshow Photos</u></h3>
<table class="table table-bordered table-hover" id="slideshow_photos_table">
    <thead>
        <th>ID</th>
        <th>Screenshot Photo</th>
        <th>Action</th>
    </thead>
    <tbody>
<?php 
foreach(website_info()->get_carousel_images_to_edit() as $img){
?>
        <tr class="justify-content-start">
            <td>
                <b><?php echo($img['id']); ?></b>
            </td>
            <td class="w-75">
                <img src="<?php echo(uploads_url($img['val'])); ?> " alt="<?php echo($img) ?>" height="240px" class ="w-100 m-2">
            </td>
            <td class="p-5">
                <form action="<?php echo(current_url()); ?>"
                 method="POST" name="delete_photo_form" id="delete_photo_form_<?php echo($img['id']); ?>">
                    <input type="hidden" value="<?php echo($img['id']) ?>" name="delete_photo_id" id="delete_photo_id">                    
                </form>
                <button class="btn btn-danger"
                 name="delete_photo_btn_<?php echo($img['id']); ?>" id="delete_photo_btn_<?php echo($img['id']); ?>">
                 Delete Photo ID 
                 <b><?php echo($img['id']); ?></b></button>
                <script>
                $("#delete_photo_btn_<?php echo($img['id']); ?>").click(function (){
                    var res = confirm("Do You Want To Delete the Photo No <?php echo($img['id']); ?> of Slide Show ?");
                    if(res == true){
                        $('#delete_photo_form_<?php echo($img['id']); ?>').submit();
                    }                    
                });
                </script>
            </td>
        </tr>   
<?php
}
?>
    </tbody>
</table>
<script>
jQuery(function ($) {
    $('#slideshow_photos_table').DataTable({
        "scrollY": "600px",
        "scrollCollapse": false,
        stateSave: true,        
    });
});
</script>


<?php include_once(snippet("dashboard_bottom.php")); ?>