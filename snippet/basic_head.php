<?php
include_once("helper_functions.php");

?>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo($title) ?></title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="robots" content="all,follow">
<!-- Bootstrap CSS-->
<link rel="stylesheet" href="<?php echo(vendor_url("bootstrap/css/bootstrap.min.css")); ?>">
<!-- Datatables-->
<link rel="stylesheet" href="<?php echo(vendor_url("DataTables/datatables.min.css")); ?>">
<!-- Font Awesome CSS-->
<link rel="stylesheet" href="<?php echo(vendor_url("font-awesome/css/font-awesome.min.css")); ?>">
<!-- Fontastic Custom icon font-->
<link rel="stylesheet" href="<?php echo(css_url("fontastic.css")); ?>">
<!-- Google fonts - Poppins -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
<!-- theme stylesheet-->
<link rel="stylesheet" href="<?php echo(css_url("style.default.css")); ?>" id="theme-stylesheet">
<!-- Custom stylesheet - for your changes-->
<link rel="stylesheet" href="<?php echo(css_url("style.default.css")); ?>">
<!-- Favicon-->
<link rel="shortcut icon" href="<?php echo(image_url("favicon.ico")); ?>">
<!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
<!-- Custom Scrollbar -->
<style>
    html::-webkit-scrollbar, div::-webkit-scrollbar {
        width: 7px;
        background-color:#f5f5f5;
    }
    html::-webkit-scrollbar-thumb, div::-webkit-scrollbar-thumb{
        border-radius : 7px;
        -webkit-boc-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color:#8391a6;

    }
    html::-webkit-scrollbar-track, div::-webkit-scrollbar-track{
        border-radius : 7px;
        -webkit-boc-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        background-color:#f5f5f5;

    }
</style>

<!-- -------------------------------------------------------------------------------------- -->
<!-- --------------------------------------------------------------------------------------- -->

<!-- JavaScript files-->
<script src="<?php echo(vendor_url("jquery/jquery.min.js")); ?>"></script>
<script src="<?php echo(vendor_url("DataTables/datatables.min.js")) ?>"></script>
<script src="<?php echo(js_url("dataTables.fixedColumns.min.js")) ?>"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.1/js/dataTables.fixedColumns.min.js"></script>
<script src="<?php echo(vendor_url("popper.js/umd/popper.min.js")); ?>"> </script>
<script src="<?php echo(vendor_url("bootstrap/js/bootstrap.min.js")); ?>"></script>
<script src="<?php echo(vendor_url("jquery.cookie/jquery.cookie.js")); ?>"> </script>
<script src="<?php echo(vendor_url("chart.js/Chart.min.js")); ?>"></script>
<script src="<?php echo(vendor_url("jquery-validation/jquery.validate.min.js")); ?>"></script>
<script src="<?php// echo(js_url("popper.min.js")); ?>"></script>
<script src="<?php echo(js_url("charts-home.js")); ?>"></script>
<script type="text/javascript" src="<?php echo(vendor_url("fusioncharts-suite-xt/js/fusioncharts.js")); ?>"></script>
<script type="text/javascript" src="<?php echo(vendor_url("fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js")); ?>"></script>
<script type="text/javascript" src="<?php echo(vendor_url("fusioncharts-suite-xt/js/themes/fusioncharts.theme.candy.js")); ?>"></script>
<!-- Include fusioncharts jquery plugin -->
<script type="text/javascript" src="<?php echo(vendor_url("fusioncharts-suite-xt/js/fusioncharts.jqueryplugin.min.js")); ?>"></script>
    
<!-- Main File-->
<script src="<?php echo(js_url("front.js")); ?>"></script>
