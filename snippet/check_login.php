<?php
include_once(helper("Login.php"));

if((!Login::is_logined())){
    header("Location: ".view_url("Login.php"));
    exit;
}