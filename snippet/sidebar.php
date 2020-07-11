<?php
include_once("helper_functions.php");
function get_active_class($url){
    if(strcmp($url,current_url()) == 0){
        return "active";
    }
    return "";
}

function get_collapse_class($url){
    $collapse = True;
    if(is_array($url)){
        foreach( $url as $u){
            if(strcasecmp($u,current_url())== 0){
                $collapse = False;
                break;
            }
        }
    }
    else{
        if(strcasecmp($url,current_url())== 0){
            $collapse = False;
        }
    }
    if($collapse){
        return "collapse";
    }
    return "";
}
?>
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
    <div class="avatar"><img src="<?php echo(uploads_url(website_info()->get_profile_pic())) ?>" alt="..." class="img-fluid rounded-circle"></div>
    <div class="title">
        <?php
        include_once("helper_functions.php");
        include_once(helper("Login.php")); 
        ?>
        <h1 class="h4"><?php echo(website_info()->get_username()); ?></h1>
        <p><?php echo(website_info()->get_name()." (".website_info()->get_short_name().")"); ?></p>
    </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
    <li class="<?php echo(get_active_class(view_url("index.php"))) ?>"><a href="<?php echo(view_url("index.php")); ?>"> <i class="icon-home"></i>Home </a></li>
    <li class="<?php echo(get_active_class(view_url("chart.php"))) ?>"><a href="<?php echo(view_url("chart.php")); ?>"> <i class="fa fa-line-chart"></i>Chart </a></li>
    <li class="<?php echo(get_active_class(view_url("contacts/contacts.php"))) ?>"><a href="<?php echo(view_url("contacts/contacts.php")); ?>"> <i class="fa fa-user"></i>Contacts </a></li>
    <li><a href="#transistionsdropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-padnote"></i>Transistions</a>
        <?php
            $collapse_urls = [view_url("transistions/transistions.php")];
            array_push($collapse_urls,view_url("transistions/buy_transistions.php"));
            array_push($collapse_urls,view_url("transistions/new_buy.php"));
            array_push($collapse_urls,view_url("transistions/sell_transistions.php"));
            array_push($collapse_urls,view_url("transistions/new_sell.php"));
        ?>
        <ul id="transistionsdropdown" class="<?php echo(get_collapse_class($collapse_urls)) ?> list-unstyled ">
        <li class="<?php echo(get_active_class(view_url("transistions/transistions.php"))) ?>"><a href="<?php echo(view_url("transistions/transistions.php")); ?>">All Transistions</a></li>
        <li class="<?php echo(get_active_class(view_url("transistions/buy_transistions.php"))) ?>"><a href="<?php echo(view_url("transistions/buy_transistions.php")); ?>">Buy Transistions</a></li>
        <li class="<?php echo(get_active_class(view_url("transistions/new_buy.php"))) ?>"><a href="<?php echo(view_url("transistions/new_buy.php")); ?>">New Buy</a></li>
        <li class="<?php echo(get_active_class(view_url("transistions/sell_transistions.php"))) ?>"><a href="<?php echo(view_url("transistions/sell_transistions.php")); ?>">Sell Transistions</a></li>
        <li class="<?php echo(get_active_class(view_url("transistions/new_sell.php"))) ?>"><a href="<?php echo(view_url("transistions/new_sell.php")); ?>">New Sell</a></li>
        </ul>
    </li>
    <li><a href="#billsdropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-padnote"></i>Bills</a>
        <?php
            $collapse_urls = [view_url("bills/bills.php")];
            array_push($collapse_urls,view_url("bills/new_bill.php"));
        ?>
        <ul id="billsdropdown" class="<?php echo(get_collapse_class($collapse_urls)) ?> list-unstyled ">
        <li class="<?php echo(get_active_class(view_url("bills/bills.php"))) ?>"><a href="<?php echo(view_url("bills/bills.php")); ?>">All Bills</a></li>
        <li class="<?php echo(get_active_class(view_url("bills/new_bill.php"))) ?>"><a href="<?php echo(view_url("bills/new_bill.php")); ?>">New Bill</a></li>
        </ul>
    </li>
    
    <li><a href="#websitedropdown" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Website</a>
        <?php
            $collapse_urls = [view_url("website/slideshow.php")];
            array_push($collapse_urls,view_url("website/user_and_password.php"));
            array_push($collapse_urls,view_url("website/company_information.php"));
        ?>
        <ul id="websitedropdown" class="<?php echo(get_collapse_class($collapse_urls)) ?> list-unstyled ">
        <li class="<?php echo(get_active_class(view_url("website/slideshow.php"))) ?>"><a href="<?php echo(view_url("website/slideshow.php")); ?>">Slideshow</a></li>
        <li class="<?php echo(get_active_class(view_url("website/user_and_password.php"))) ?>"><a href="<?php echo(view_url("website/user_and_password.php")); ?>">User and Password</a></li>
        <li class="<?php echo(get_active_class(view_url("website/company_information.php"))) ?>"><a href="<?php echo(view_url("website/company_information.php")); ?>">Company Information</a></li>
        </ul>
    </li>
    </ul>
</nav>