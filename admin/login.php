<?php
    session_start();
    include '../functions/func.php';

	$uname = $_POST['uname'];
    $pwd = $_POST['pwd'];
	//$pwd = md5($password);

	$uname = escape_string($_POST['uname']);
    $pwd = escape_string($_POST['pwd']);

    $admin_res = mysqlQuery("SELECT * FROM tbladmin WHERE uname = '$uname' AND pwd = '$pwd'") or die ("Verification error");
    $data_admin = mysqliFetch($admin_res);
    
    if ($data_admin['uname'] == $uname){
        $_SESSION['uname'] = $uname;
        $_SESSION['utype'] = $data_admin['utype'];
        redirect("user_score_list.php?p=user_score_list","");
    }
    else{
        redirect("../index.php","Incorrect username or password.");
    }
?>
