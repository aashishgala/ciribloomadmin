<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REMOTE_ADDR'] == "::1" OR isset($_SERVER['SERVER_ADDR']) == "::1" OR isset($_SERVER['SERVER_ADDR']) == "127.0.0.1") {
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $db = "dbforum";
}
else{
    // $host = "localhost";
    // $user = "quizz";
    // $pwd  = "1@Quizz#";
    // $db   = "pgpl_quizz";
    $host = "localhost";
    $user = "aditee_quizz";
    $pwd  = "quizz@123";
    $db   = "aditee_quizz";
}

$con = mysqli_connect($host,$user,$pwd,$db) or die("Could not connect");
// mysqli_select_db($db,$con) or die("No database");

if ($_SERVER['REMOTE_ADDR'] == "::1" OR isset($_SERVER['SERVER_ADDR']) == "::1" OR isset($_SERVER['SERVER_ADDR']) == "127.0.0.1") {
    require $path = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/language/language.php';
    require_once $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/global.php';
}else{
    require $path = $_SERVER[ 'DOCUMENT_ROOT' ].'/language/language.php';
    require_once $_SERVER[ 'DOCUMENT_ROOT' ].'/global.php';
}

// print_r($language);
$_SESSION['languagePath'] = $path;
// require $_SESSION['languagePath'];

// echo "<pre>";
// print_r($langauge);
// echo "</pre>";
?>