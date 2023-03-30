<?php
include "func.php";

extract($_POST);

if (!empty($_REQUEST['qrystring'])) {
	$SqlChkDup = mysqlQuery("SELECT * FROM `tblaccount` WHERE `username` = '$username' LIMIT 1");
	$ChkDupRes = mysqliFetch($SqlChkDup);
	
	if($ChkDupRes && ($username == $ChkDupRes['username']) )
	{
		echo "<p style='color:red; font-size:12px;'>Opps, Username Already Exists, Please Choose Another Username.</p>";
		die();
	}
}
else{
	$fname = str_replace("'","`",$fname); 
	$fname = escape_string($fname);
	
	$lname = str_replace("'","`",$lname); 
	$lname = escape_string($lname); 
	        
	$username = str_replace("'","`",$username); 
	$username = escape_string($username); 

	$password = str_replace("'","`",$password); 
	$password = escape_string($password);
	$password = md5($password);

	$SqlChkDup = mysqlQuery("SELECT * FROM `tblaccount` WHERE `username` = '$username' ");
	$ChkDupRes = mysqliFetch($SqlChkDup);
	if($ChkDupRes && ($username == $ChkDupRes['username']) )
	{
		redirect("../index.php","Opps, Username Already Exists, Please Choose Another Username.");
		die();
	}

	$ins_user = mysqlQuery("INSERT INTO `tbluser`(`fname`, `lname`, `gender`) VALUES ('$fname','$lname','$gender')");
	$last_id = mysqli_insert_id($con);
 	if($ins_user)
	{
		$aaa = $last_id;
		$sql = "INSERT INTO `tblaccount`(`username`, `password`, `user_Id`) VALUES('$username','$password',$aaa)";
		$res = mysqlQuery($sql);
		
		if($res==true)
		{
			redirect("../index.php", "Successfully Registered");
		}
	}
}
?>