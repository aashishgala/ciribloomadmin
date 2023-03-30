<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
function dbcon(){
	if ($_SERVER['REMOTE_ADDR'] == "::1" OR $_SERVER['SERVER_ADDR'] == "::1" ) {
		$host = "localhost";
		$user = "root";
		$pwd = "";
		$db = "dbforum";
	}
	else{
		$host = "localhost";
		$user = "quizz";
		$pwd  = "1@Quizz#";
		$db   = "pgpl_quizz";
	}
	global $con;
	$con = mysqli_connect($host,$user,$pwd,$db) or die ("ERROR Connecting to Database");
}

function dbclose(){
	if ($_SERVER['REMOTE_ADDR'] == "::1" OR $_SERVER['SERVER_ADDR'] == "::1" ) {
		$host = "localhost";
		$user = "root";
		$pwd = "";
		$db = "dbforum";
	}
	else{
		$host = "localhost";
		$user = "quizz";
		$pwd  = "1@Quizz#";
		$db   = "pgpl_quizz";
	}

	$con = mysqli_connect($host,$user,$pwd,$db) or die ("ERROR Connecting to Database");
	mysqli_close($con);
}

// MysqlQuery
function mysqlQuery($query)
{
    global $con;
    return mysqli_query($con, $query);
}

function mysqliFetch($mysqlQryRes)
{
    return mysqli_fetch_array($mysqlQryRes);
}

function deleteuser($user_Id){
	dbcon();
	// check referential integrity
	$refinteg = mysqlQuery("SELECT * FROM userscore where user_Id='$user_Id'");
	$numrow = mysqli_num_rows($refinteg);
	if ($numrow > 0){
		echo "This user has attended quizz you can not delete this user...!";
	}else{
		$sel = mysqlQuery("DELETE from tbluser where user_Id='$user_Id'");

		if($sel==true){
			$del = mysqlQuery("DELETE from tblaccount where user_Id='$user_Id' ");
			echo "success";
		}
		else{
			echo "failed";
		}
	}
	dbclose();
}

function category(){
	dbcon();
	$sel = mysqlQuery("SELECT * from category");

	if($sel==true){
		while($row=mysqliFetch($sel)){
			extract($row);
			echo '<option value='.$cat_id.'>'.$category.'</option>';
		}
	}
	dbclose();
}

?>