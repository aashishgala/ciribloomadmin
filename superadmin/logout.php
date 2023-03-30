<?php
require './globals.php'; 
require './functions/function.php'; 

php_start_session();

session_destroy();
session_unset();

// Teacher Login
// if(isset($_SESSION['logged_in_as'])){

//     session_destroy();
//     session_unset();

// }
// else{
//     // Admin login
//     sessDel();
// }


header('location:login.php');

?>