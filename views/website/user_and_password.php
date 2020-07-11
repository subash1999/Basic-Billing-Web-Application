<?php include_once("helper_functions.php");?>
<?php
if(isset($_POST['save_data'])){
    $username = $_POST["username"];
    $profile_pic = $_FILES['profile_pic_upload'];

    if(!empty($profile_pic)){
        $ext = pathinfo($_FILES['profile_pic_upload']['name'],PATHINFO_EXTENSION);
        $new_file_name = "_profile_pic_".time()."_".uniqid()."_.".$ext;
        if (move_uploaded_file($_FILES["profile_pic_upload"]["tmp_name"], rel_path_to_abs_path(uploads($new_file_name)))) {
            // delete previous pic
            $old_pp_name = website_info()->get_profile_pic();
            if(unlink(rel_path_to_abs_path(uploads($old_pp_name)))){
                $msg = "Profile picture has been successfully updated.";
            }
            else{
                $msg = "Old Profile Picture cannot be deleted before setting new profile picture";
            }
            website_info()->set_profile_pic($new_file_name);
            
        }
        else{
            $msg = "Sorry, there was an error uploading your profile picture.";            
        }
        echo("<script>alert('$msg');</script>");
    }
    if(!empty($username)){
        if(strcmp(website_info()->get_username(),$username)!=0){
            website_info()->set_username($username);
            $username_msg = "Username Updated Successfully !!!";
        }   
        
    }   
    else{
        $username_msg = "Username is required.";   
    }
    if(isset($username_msg)){
        echo("<script>alert('$username_msg');</script>");
    }

}

// password change
if(isset($_POST['change_password'])){
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $new_password_confirmation = $_POST['new_password_confirmation'];
    $msg = '';
    if (password_verify($old_password,website_info()->get_password())){
        if(strcmp($new_password,$new_password_confirmation) == 0){
                website_info()->set_password($new_password);
                unset($_POST);
                $msg = "Password is changed successfully :)";           
        }
        else{
            $msg = "Password confirmation is not same as password !!!";
        }
    }
    else{
        $msg = "Old Password Entered is Wrong !!!";
    }
    echo("<script>alert('$msg');</script>");
}
?>
<?php $header = "Website / User and Password"; ?>
<?php include_once(snippet("dashboard_top.php")); ?>
<script>
jQuery(function ($) {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $("#profile_pic_view").attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile_pic_upload").change(function (){
        console.log(this.files);
        readURL(this);
    });
    $("#new_password_confirmation,#new_password").change(function(){
        new_pwd_confirm = document.getElementById("new_password_confirmation");
        new_pwd = document.getElementById("new_password");
       if( new_pwd_confirm.value != new_pwd.value ){
          new_pwd.setCustomValidity("Password confirmation must match with password entered!!!");
       }
       else{
          new_pwd.setCustomValidity('');
       }
    });
});
</script>

<div class="container">
    <form action="" method="POST" class="m-4" enctype="multipart/form-data">
        <h3 class="text-center text-primary m-3 text-uppercase">Edit User Information</h3>
        <div class="form-group">
            <label for="username" class="text-info">Username</label>
            <input type="text" name="username" id="username" required="required" class="form-control"
            value="<?php echo(website_info()->get_username()); ?>">
        </div>
        <div class="form-group" align="center">
            <label for="profile_pic" class="text-info">Profile Picture</label>
            <br>
            <img src="<?php echo(uploads_url(website_info()->get_profile_pic())) ?>" alt="profile_pic" class="m-3 rounded-circle" name="profile_pic_view" id="profile_pic_view" height="200px" width="200px">
            <br>
            <input type="file" name="profile_pic_upload" id="profile_pic_upload" class="form-control col-5 btn btn-info" accept="image/*">
        </div>
        <input type="submit" value="SAVE DATA" class="btn btn-primary" name="save_data" id="save_data">
    </form>
    <hr style="border-width:5px;" class="bg-primary">
    <form action="" method="POST" class="m-4">
        <h3 class="text-center text-primary m-3 text-uppercase">CHANGE PASSWORD</h3>
        <div class="form-group">
            <label for="old_password" class="text-info">Old Password</label>
            <input type="password" name="old_password" id="old_password" required="required" class="form-control" min="4" max="16">
        </div>
        <div class="form-group">
            <label for="new_password" class="text-info">New Password</label>
            <input type="password" name="new_password" id="new_password" required="required" class="form-control" min="4" max="16">
        </div>
        <div class="form-group">
            <label for="new_password_confirmation" class="text-info">New Password Confirmation</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required="required" class="form-control" min="4" max="16">
        </div>
        <input type="submit" value="CHANGE PASSWORD" class="btn btn-warning" name="change_password" id="change_password">
    </form>
</div>
<?php include_once(snippet("dashboard_bottom.php")); ?>