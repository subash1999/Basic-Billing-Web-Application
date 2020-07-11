<!DOCTYPE html>
<html>
  <head>

    <?php
    include_once("helper_functions.php"); 
    $title="Website Admin";
    include_once(snippet("dashboard_head.php"));
    include_once(helper("Login.php"));
    include_once(snippet("carousel.php"));
    
    ?>

  </head>
  <body>
    <div class="page">
      <!-- Main Navbar-->
     <?php include_once(snippet("nav.php")); ?>
      <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        <?php include_once(snippet("sidebar.php")); ?>
        <div class="content-inner">
        <?php
        if(isset($header)){
          ?>
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom"><?php echo($header) ?></h2>
            </div>
          </header>
        <?php
        }
        ?>