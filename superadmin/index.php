<?php
$skip_auth = 0;
if(isset($_GET['type']) && $_GET['type'] == 'forgot_pass'){
    $skip_auth = 1;

    require './globals.php';
    // require './language.php';
    require './class/mysql.php';
    $mysql_obj = new mysql_function();

    require './functions/function.php';
    require 'header.php';
    siteheader();
    include 'change_password.php';
    change_password();
    html_change_password();
    die();
}
require './admin.php'; 
// require './functions/function.php'; 

// // Are we logged in ?
// // $logged_in = isLogin();
// $ip = $_SERVER['REMOTE_ADDR'];

// // create_session_file($ip);
// isLogin($ip);
// $act = optGET('act');


// require 'header.php'; 
// siteheader();

// require 'footer.php'; 

?>