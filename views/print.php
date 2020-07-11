<?php include_once("helper_functions.php"); ?>
<?php
if(isset($_GET['content_to_print'])){
    $content_to_print = $_GET['content_to_print'];
}
else{
    redirect_to_404();
    exit;
}
?>
<html>
<head>
<?php $title="PRINT"; ?>
<?php include_once(snippet("basic_head.php"));?>
</head>
<body>
<div class="container">
<?php echo($content_to_print); ?>
<div class="float-right">
    <input type="text" style="border: 0;border-bottom: 1px solid #000;" >
    <br>
    <label class="ml-5">Signature</label>
</div>
</div>

</body>
<script>
    window.print();
</script>
</html>

