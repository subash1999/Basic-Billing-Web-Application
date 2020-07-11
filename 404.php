<?php
header("HTTP/1.0 404 Not Found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found</title>
    <?php include("helper_functions.php"); ?>
    <?php include(snippet("basic_head.php")) ?>
</head>
<body class="bg-secondary">
    <div class="bg-warning pt-3 ">
        <div class="text-center">
            <h1 class="text-uppercase">
                <?php echo(website_info()->get_name()); ?>
                (<?php echo(website_info()->get_short_name()); ?>)
            </h1>
            <div class="text-capitalize">
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

        <div class="container-fluid justify-content-center text-center bg-info p-5 mt-3">
            <div class="alert">
                <div class="alert-heading">
                    <h2><b><u>Page Not Found 404 !!!</u></b></h2>
                </div>
                <p>Sorry this page does not exists in the website</p>
                <button class="btn btn-danger btn-lg m-3" onclick="window.history.back();"> <= GO BACK</button>
                
                <a class="btn btn-primary btn-lg m-3" href="<?php echo(view_url("index.php")) ?>">GO Home => </a>
                
            </div>
        </div>
    </div>
</body>
</html>