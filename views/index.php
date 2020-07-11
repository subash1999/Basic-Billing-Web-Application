<?php include_once("helper_functions.php"); ?>
<?php include_once(snippet("dashboard_top.php")); ?>
<?php include_once(controller("ContactController.php")); ?>
<?php include_once(controller("TransistionController.php")); ?>
<?php include_once(controller("BillController.php")); ?>
<?php
$contact = new ContactController();
$contact_count = $contact->get_count(); 
$transistion = new TransistionController();
$transistion_count = $transistion->get_count(); 
$bill = new BillController();
$bill_count = $bill->get_count();
?>

<!-- Page Header-->
<header class="page-header">
  <div class="container-fluid">
    <h2 class="no-margin-bottom">Dashboard</h2>
  </div>
</header>
<?php
  $images = website_info()->get_carousel_images();
  $images_url = [];
  foreach ($images as $img){
    array_push($images_url,uploads_url($img));
  }
  show_carousel($images_url);
?>
<h1 class="text-center mt-3 text-primary text-capitalize"><?php echo(website_info()->get_name()); ?>'s Summary</h1>
<!-- Dashboard Counts Section-->
<section class="dashboard-counts no-padding-bottom">
  <div class="container-fluid">
    <div class="row bg-white has-shadow">
      <!-- Item -->
      <div class="col-xl-6 col-sm-6">
        <div class="item d-flex align-items-center">
          <div class="icon bg-violet"><i class="icon-user"></i></div>
          <div class="title">
            <a href="<?php echo(view_url("contacts/contacts.php")); ?>">
              <span>Contacts<br>Available</span>
              <div class="progress">
                <div role="progressbar" style="width: <?php echo($contact_count); ?>%; height: 4px;"
                  aria-valuenow="<?php echo($contact_count); ?>" aria-valuemin="0"
                  aria-valuemax="<?php echo($contact_count+100); ?>" class="progress-bar bg-violet"></div>
              </div>
            </a>
          </div>
          <div class="number"><strong><?php echo($contact_count); ?></strong></div>
        </div>
      </div>
      <!-- Item -->
      <div class="col-xl-6 col-sm-6">
        <div class="item d-flex align-items-center">
          <div class="icon bg-red"><i class="icon-padnote"></i></div>
          <div class="title">
            <a href="<?php echo(view_url("transistions/transistions.php")); ?>">
              <span>Total<br>Transistions</span>
              <div class="progress">
                <div role="progressbar" style="width:  <?php echo($transistion_count); ?>%; height: 4px;"
                  aria-valuenow=" <?php echo($transistion_count); ?>" aria-valuemin="0"
                  aria-valuemax=" <?php echo($transistion_count+100); ?>" class="progress-bar bg-red"></div>
              </div>
            </a>
          </div>
          <div class="number"><strong> <?php echo($transistion_count); ?></strong></div>
        </div>
      </div>
    </div>
    <div class="row bg-white has-shadow">
      <!-- Item -->
      <div class="col-xl-6 col-sm-6">
        <div class="item d-flex align-items-center">
          <div class="icon bg-green"><i class="fa fa-tasks"></i></div>
          <div class="title">
            <a href="<?php echo(view_url("bills/bills.php")); ?>">
              <span>Total<br>Bills</span>
              <div class="progress">
                <div role="progressbar" style="width: <?php echo($bill_count); ?>%; height: 4px;"
                  aria-valuenow="<?php echo($bill_count); ?>" aria-valuemin="0"
                  aria-valuemax="<?php echo($bill_count+100); ?>" class="progress-bar bg-violet"></div>
              </div>
            </a>
          </div>
          <div class="number"><strong><?php echo($bill_count); ?></strong></div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="dashboard-container">
  <div class="container-fluid">
    <hr style="border-width:5px;">
    <h3 class="text-uppercase text-center"><a href="<?php echo(view_url("transistions/transistions.php")); ?>"><u>Transistions</u></a></h3>
    <div class="row">
      <div class="col-6 bg-transparent">
        <hr>
        <label>Number of Transistions: <b><?php echo($transistion_count); ?></b></label>
        <br>
        <label>Total Quantities Sold or Brought: <b><?php echo($transistion->get_total_transisiton_quantity()); ?></b></label>
        <br>
        <label>Total Amount of Transistions: <b>Rs <?php echo($transistion->get_total_amount_of_transistion()); ?></b></label>
        <hr>
        <h3><b><u><i>Net Profit: Rs <?php echo($transistion->get_total_amount_of_sell()-$transistion->get_total_amount_of_buy()); ?></i></u></u></b></h3>
      </div>
      <div class="col-6">
        <hr>
        <div>
          <h5 class="text-uppercase"><a href="<?php echo(view_url("transistions/sell_transistions.php")); ?>">Sales (Sell)</a></h5>
          <label>Number of Sales: <b><?php echo($transistion->get_sell_count()); ?></b></label>
          <br>
          <label>Total Quantities  Sold: <b><?php echo($transistion->get_total_sell_quantity()); ?></b></label>
          <br>
          <label>Total Amount of Sales: <b>Rs <?php echo($transistion->get_total_amount_of_sell()); ?></b></label>
        </div>
        <hr>
        <div>
          <h5 class="text-uppercase"><a href="<?php echo(view_url("transistions/buy_transistions.php")); ?>">Buy</a></h5>
          <label>Number of Buy Transistions: <b><?php echo($transistion->get_buy_count()); ?></b></label>
          <br>
          <label>Total Quantities Brought: <b><?php echo($transistion->get_total_buy_quantity()); ?></b></label>
          <br>
          <label>Total Amount of Buy: <b>Rs <?php echo($transistion->get_total_amount_of_buy()); ?></b></label>
        </div>
      </div>
    </div>
    <hr style="border-width:5px;">
    <h3 class="text-uppercase text-center"><a href="<?php echo(view_url("bills/bills.php")); ?>"><u>Bills</u></a></h3>
    <div>
      <label>Number of Bills: <b><?php echo($bill->get_count()); ?></b></label>
      <br>
      <label>Total Quantity in Bills: <b><?php echo($bill->get_total_bill_quantity()); ?></b></label>
      <br>
      <label>Total Amount of Bills: <b>Rs <?php echo($bill->get_total_bill_amount()); ?></b></label>
    </div>
  </div>
</section>
<?php include_once(snippet("dashboard_bottom.php")); ?>