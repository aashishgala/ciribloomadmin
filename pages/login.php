<?php 
    session_start();
    
    include '../functions/func.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $pwd = md5($password);

    $username = escape_string($_POST['username']);
    $password = escape_string($_POST['password']);

    $query = "SELECT * FROM tblaccount WHERE username = '$username' AND password = '$pwd' LIMIT 1";
    $result = mysqlQuery($query) or die ("Verification error");
    $array = mysqliFetch($result);
    if ($array && $array['username'] == $username)
    {
        $userData = mysqlQuery("SELECT * FROM `tbluser` WHERE user_Id='".$array['user_Id']."' LIMIT 1");
        $UserDataFetch = mysqliFetch($userData);
        extract($UserDataFetch);

        $_SESSION['username'] = $username;
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['user_Id'] = $user_Id;
        redirect("home.php","");
    }
    else
    {
	    redirect("../index.php","Incorrect username or password.");
    }
   
?>