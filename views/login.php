<!DOCTYPE html>
<html>
  <head>
    <?php

      $title = "Login To Dashboard";
      include_once("helper_functions.php");
      include_once(snippet("basic_head.php"));
      include_once(helper("Login.php"));

      if(Login::is_logined()){
        header("Location: ".view_url("dashboard.php"));
      }

      if(isset($_POST)){
        if(isset($_POST['login_password'])){
          $password = $_POST['login_password'];
          $errors = [];
          if($password == ''){
            array_push($errors,"Password is Required");
          }
          array_push($errors,Login::login($password));
          set_errors($errors);
        }       
        
      }
    ?>

  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo text-capitalize text-center">
                    <h1><?php echo(website_info()->get_name()); ?></h1>
                    <div class="text-black-50">
                      <h4>
                          <?php
                              if(website_info()->get_address()!= "" ){
                                  echo(website_info()->get_address());
                              } 
                          ?>
                      </h4>                
                      <h5>
                        <?php
                          if(website_info()->get_phone()!= "" ){
                              echo("Phone : ".website_info()->get_phone());
                          } 
                          if(website_info()->get_email()!= "" ){
                              echo(", Email : ".website_info()->get_email());
                          } 
                        ?>
                      </h5>
                  </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <form method="post" class="form-validate" action="<?php echo(view_url("login.php")) ?>">
                    <!-- <div class="form-group">
                      <input id="login-username" type="text" name="loginUsername" required data-msg="Please enter your username" class="input-material">
                      <label for="login-username" class="label-material">User Name</label>
                    </div> -->
                    <?php
                    if(has_errors()){
                      echo("<small class='text-danger'>
                      <div class='text-center'><u>ERROR</u></div>
                      <br>
                      <ul>");
                      foreach(get_errors() as $e){
                        echo("<li class='text-danger text-capitalize'>".$e."</li>");
                      }
                      echo("</ul></small>");
                    }
                    ?>
                    <div class="form-group">
                      <input id="login_password" type="password" name="login_password" required data-msg="Please enter your password" class="input-material">
                      <label for="login_password" class="label-material">Password</label>
                    </div>
                    
                    <input type="submit" id="login" name="name" value="Login" class="btn btn-primary">
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </form>
                  <a href="#" class="forgot-pass">Forgot Password?</a>
                  <!-- <br><small>Do not have an account? </small><a href="register.html" class="signup">Signup</a> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyrights text-center">
        <p>Design by <a href="https://bootstrapious.com/p/admin-template" class="external">Bootstrapious</a>
          <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
        </p>
      </div>
    </div>
  </body>
</html>
