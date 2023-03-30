<?php 
// Escape special character from strings
function escape_string($string)
{
    global $con;
    return mysqli_real_escape_string($con, $string);
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

function get_val($str,$column_name)
{
	global $con;
    $resultstr = mysqli_query($con, $str);
	if($resultstr)
	{
		while($myrow1=mysqli_fetch_array($resultstr))
		{
			 $m_name=$myrow1[$column_name];
		}
	}
	return $m_name;
}

?>