<?php
include_once("helper_functions.php");
include_once(controller("Controller.php"));

if (!isset($_SESSION)){
    session_start();
}

class Login extends Controller{

    public function __construct(){
        parent::__construct();
    }

    public static function login($pwd){

        $correct_password_hash = website_info()->get_password();
        if (password_verify($pwd,$correct_password_hash)){
            self::session_login();
            unset($_POST);
            header("Location: ".view_url("index.php"));
            exit;
        }
        else{
            return "Incorrect Password, Try Again or Try to Reset Password";
        }

    }

    public static function logout(){
        if(self::is_logined()){
            self::session_logout();
        }
        header("Location: ".view_url("login.php"));
        exit;
    }

    private static function session_login(){
        self::set_is_logined(True);
    }

    private static function session_logout(){
        self::set_is_logined(False);
    }

    private static function set_is_logined($is_logined){
        $_SESSION["is_logined"] = $is_logined;
    }

    public static function is_logined(){
        if(!isset($_SESSION["is_logined"])){
            return False; 
        }
        return $_SESSION["is_logined"];
    }    
   
}
