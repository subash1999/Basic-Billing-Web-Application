<?php
include_once("config.php");
include_once(controller("WebsiteInfoController.php"));

if(!isset($_SESSION)){
    session_start();
}

function website_info(){
    $website_info = new WebsiteInfoController;
    return $website_info;
}
// get_the_current_url of the website
/**
 * Return the current url of website in the string format
 */
function current_url(){
    return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!= 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        explode('?', $_SERVER['REQUEST_URI'], 2)[0]
    );
}
// get the realpath of the current project
/**
 * Returns the realpath of the project 
 */
function project(){
    global $project_folder;
    return $_SERVER['DOCUMENT_ROOT']."/".$project_folder;
}
// get the url of the current project
/**
 * Returns the root url of the project 
 */
function project_url(){
    global $project_folder;
    return sprintf(
        "%s://%s/%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!= 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $project_folder,
    );
}
/**
 * it converts file to the url 
 */
function rel_path_to_url($rel_file_name){
    return project_url().'/'.$rel_file_name;
}
/**
 * it converts file to the abs path 
 */
function rel_path_to_abs_path($rel_file_name){
    return project().'/'.$rel_file_name;
}
// code for the url of css
/** 
 * Give the url for the css inside the css folder, give parameter as rel link with css folder
 */

function css_url($rel_link){
    global $rel_css_path;
    return project_url()."/".$rel_css_path.$rel_link;
}

function css($rel_link){
    global $rel_css_path;
    return $rel_css_path.$rel_link;
}
// code for the url of uploads
/** 
 * Give the url for the uploads inside the uploads folder, give parameter as rel link with uploads folder
 */

function uploads_url($rel_link){
    global $rel_uploads_path;
    return project_url()."/".$rel_uploads_path.$rel_link;
}

function uploads($rel_link){
    global $rel_uploads_path;
    return $rel_uploads_path.$rel_link;
}

// code for the url of temp
/** 
 * Give the url for the temp inside the temp folder, give parameter as rel link with temp folder
 */

function temp_url($rel_link){
    global $rel_temp_path;
    return project_url()."/".$rel_temp_path.$rel_link;
}

function temp($rel_link){
    global $rel_temp_path;
    return $rel_temp_path.$rel_link;
}

// code for the url of js
/**
 * Give the url for the css inside the css folder, give parameter as rel link with js folder
 */
function js_url($rel_link){
    global $rel_js_path;
    return project_url()."/".$rel_js_path.$rel_link;
}

function js($rel_link){
    global $rel_js_path;
    return $rel_js_path.$rel_link;
}


function controller_url($rel_link){
    global $rel_controller_path;
    return project_url()."/".$rel_controller_path.$rel_link;

}

function controller($rel_link){
    global $rel_controller_path;
    return $rel_controller_path.$rel_link;
}

function vendor_url($rel_link){
    global $rel_vendor_path;
    return project_url()."/".$rel_vendor_path.$rel_link;

}

function vendor($rel_link){
    global $rel_vendor_path;
    return $rel_vendor_path.$rel_link;
}

function public_url($rel_link){
    global $rel_public_path;
    return project_url()."/".$rel_public_path.$rel_link;
}

function public_folder($rel_link){
    global $rel_public_path;
    return $rel_public_path.$rel_link;
}


function image_url($rel_link){
    global $rel_image_path;
    return project_url()."/".$rel_image_path.$rel_link;
}

function image($rel_link){
    global $rel_image_path;
    return $rel_image_path.$rel_link;
}


function view_url($rel_link){
    global $rel_view_path;
    return project_url()."/".$rel_view_path.$rel_link;
}

function view($rel_link){
    global $rel_view_path;
    return $rel_view_path.$rel_link;
}


function snippet_url($rel_link){
    global $rel_snippet_path;
    return project_url()."/".$rel_snippet_path.$rel_link;
}

function snippet($rel_link){
    global $rel_snippet_path;
    return $rel_snippet_path.$rel_link;
}

function model_url($rel_link){
    global $rel_model_path;
    return project_url()."/".$rel_model_path.$rel_link;
}

function model($rel_link){
    global $rel_model_path;
    return $rel_model_path.$rel_link;
}

function helper_url($rel_link){
    global $rel_helper_path;
    return project_url()."/".$rel_helper_path.$rel_link;
}

function helper($rel_link){
    global $rel_helper_path;
    return $rel_helper_path.$rel_link;
}

function set_errors($errors){
    if(!isset($_SESSION)){
        session_start();
    }
    $_SESSION['errors'] = [];

    if (is_array($errors)){
        foreach ($errors as $error){
            array_push($_SESSION['errors'],$error);
        }
    }
    else{
        array_push($_SESSION['errors'],$errors);
    }
    
    return True;
}

function get_errors(){
    if(!isset($_SESSION)){
        session_start();
    }

    $errors = [];
    if (isset($_SESSION['errors'])){
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
    }
    return $errors;   

}

function has_errors(){
    if(!isset($_SESSION['errors'])){
        return False;
    }
    else if (is_array($_SESSION['errors'])){
        return True;
    }
    return False;
}

function redirect_to_404(){
    http_response_code(404);
    header("Location: 404.php");
}


?>

