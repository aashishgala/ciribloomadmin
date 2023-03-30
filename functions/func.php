<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// require_once '../functions/db.php';
if ($_SERVER['REMOTE_ADDR'] == "::1" OR isset($_SERVER['SERVER_ADDR']) == "::1" OR isset($_SERVER['SERVER_ADDR']) == "127.0.0.1") {
    require_once $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/functions/db.php';
}else{
    require_once $_SERVER[ 'DOCUMENT_ROOT' ].'/functions/db.php';
}

function check_session($username, $location, $redirect)
{
    if (!isset($username) && $username==""){
        redirect($location, $redirect);
        die();
    }
}
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
    $m_name = '';
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

function redirect($locaton, $message = '')
{
    if (!empty($message)) 
    {
        echo '<script language="javascript">';
        echo 'alert("'.$message.'")';
        echo '</script>';
    }
	echo '<meta http-equiv="refresh" content="0;url='.$locaton.'" />';
}

function createQuestionFile($filePath, $query)
{
    $queFile = fopen($filePath, "w") or die("Unable to open file!");

    $SqlQuizzData = mysqlQuery($query);
    $txt = 'let arr_quizz_que = [';
    $pattern = '/[^A-Za-z0-9 ]/';
    $i = 1;
    while($RowQuizzData=mysqliFetch($SqlQuizzData))
    {
        extract($RowQuizzData);
        $choice1 = preg_replace($pattern, '', $choice1);
        $choice2 = preg_replace($pattern, '', $choice2);
        $choice3 = preg_replace($pattern, '', $choice3);
        $choice4 = preg_replace($pattern, '', $choice4);
        $correctAns = '';
        if ($answer == 1) {
            $correctAns = $choice1;
        }elseif ($answer == 2) {
            $correctAns = $choice2;
        }elseif ($answer == 3) {
            $correctAns = $choice3;
        }elseif ($answer == 4) {
            $correctAns = $choice4;
        }

    $txt .= '
    {
        tblAutoId: '.$id.',
        numb: '.$i.',
        question: "'.$question.'",
        answer: "'.$correctAns.'",
        explanation: "'.htmlspecialchars($explanation).'",
        options: [
            "'.$choice1.'",
            "'.$choice2.'",
            "'.$choice3.'",
            "'.$choice4.'"
        ]
    },';
        $i++;
    }
$txt .= '
];
';
fwrite($queFile, $txt);
fclose($queFile);
}

function createUserScoreFile($filePath, $txt, $override)
{
    $mode = (!file_exists($filePath)) ? 'w':'a';
    !empty($override) ? $mode = 'w' : $mode = 'a';
    $scoreFile = fopen($filePath, $mode) or die("Unable to open file!");
    fwrite($scoreFile, $txt);
    fclose($scoreFile);
}

function read_json_data($filepath){
    global $globals;

    $jsondata = @json_decode(file_get_contents($filepath), true);
	
	if(!empty($jsondata)){
		foreach($jsondata as $sk => $sv){
			$globals[$sk] = $sv;
		}
	}
}

// validate json file
function isJson($file_json) {
   json_decode($file_json);
   if(json_last_error() === JSON_ERROR_NONE){
       return 1;
   }else{
       return 0;
   }
}
?>