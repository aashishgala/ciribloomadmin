<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

if ($_SERVER['REMOTE_ADDR'] == "::1" OR isset($_SERVER['SERVER_ADDR']) == "::1" OR isset($_SERVER['SERVER_ADDR']) == "127.0.0.1") {
    $site_path = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/';
    $ProjectPath = $host."/quiz_forum/";
}else{
    $site_path = $_SERVER[ 'DOCUMENT_ROOT' ].'/';
    $ProjectPath = $host."/";
}
?>