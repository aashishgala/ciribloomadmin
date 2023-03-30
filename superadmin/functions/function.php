<?php

function php_start_session(){
	if (session_status() === PHP_SESSION_NONE) {
		session_start();
	}
}

function php_errors(){

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

}

function get_user_ip(){

	return $_SERVER['REMOTE_ADDR'];

}

function make_json($arr_data){

	return json_encode($arr_data, JSON_UNESCAPED_SLASHES);

}

function deletData($query){

	global $mysql_obj;

	return $mysql_obj->delete_data($query);

}

function insertData($query){

	global $mysql_obj;

	return $mysql_obj->insert_data($query);

}

function executeQuery($query){
	
	global $mysql_obj;

	return $mysql_obj->execute_query($query);

}

function num_rows($query){
	
	global $mysql_obj;

	return $mysql_obj->mysql_num_rows($query);

}

function get_val($query){

	global $mysql_obj;

	return $mysql_obj->get_val($query);

}

function fetchData($result){

	global $mysql_obj;

	return $mysql_obj->fetch_data($result);

}

// Load theme part of the page
function init_theme($theme){

    call_user_func('html_'.$theme['name']);
    
}

function r_print($var, $exit = 0){
	echo '<pre>';
	print_r($var);
	echo '</pre>';
	if($exit == 1){
		die();
	}
}

function show_error($error){

	$err_div = '';

	if(!empty($error)) {
		$err_div = '<div class="alert alert-danger mt-5 font-weight-bold" role="alert">
			The Follwing errors found...!
			<ul>';
			foreach ($error as $index => $value) {
				$err_div .= '<li>'.$value.'</li>';
			}
			$err_div .= '</ul>
		</div>
		<script>
		window.scrollTo(0, 0);
		</script>
		';
	}

	return $err_div;
}

function show_success($done){

	$done_div = '';

	if(!empty($done)) {
		$done_div = '<div class="alert alert-primary mt-5 font-weight-bold succe-alt" role="alert">
			<ul>';
			foreach ($done as $index => $value) {
				$done_div .= '<li>'.$value.'</li>';
			}
			$done_div .= '</ul>
		</div>

		<script>
		var loc = window.location.toString();
		replce_to = loc.replace(\'#\', \'\');

			$(\'.succe-alt\').delay(1000).fadeOut(\'slow\');
			window.scrollTo(0, 0);
			setTimeout(function(){ 
				// window.location.href=window.location.href;
				window.location.replace(replce_to);
			}, 1500);
		</script>
		';
	}

	return $done_div;
}

function cleanpath($path){
	
	$path = str_replace('\\\\', '/', $path);
	$path = str_replace('\\', '/', $path);
	$path = str_replace('//', '/', $path);
	
	if($path == '/'){
		return '/';
	}
	
	return rtrim($path, '/');
}

// Load the data
function loaddata($path){
	
	if(!file_exists($path)){
		return [];
	}
	
	$path = cleanpath($path);
	
	$data = file_get_contents($path);
	$data = json_decode($data, true);
	
	// Is it a serialized string !
	if(empty($data)){
		$tmp = file_get_contents($path);
		
		if(soft_is_serialized_str($tmp)){
			$data = unserialize($tmp);
		}
		
	}
	
	return $data;
	
}

function generateRandStr($length, $special = 0){

	$randstack = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	
	$specialchars = array('!', '[', ']', '(', ')', '.', '-', '@');
	
	$randstr = '';

	while(strlen($randstr) < $length){
		
		$randstr .= $randstack[array_rand($randstack)];
		
		if(!empty($special) && strlen($randstr) < $length && (strlen($randstr)%2 == 0)){
			$randstr .= $specialchars[array_rand($specialchars)];
		}
		
	}
	
	return str_shuffle($randstr);

}

function writefile($file, $data, $overwrite){

	$pathinfo = pathinfo($file);
	
	$folderpath = '';
	
	$folders = explode('/', $pathinfo['dirname']);
	
	$prefix = (substr($pathinfo['dirname'], 0, 1) == '/' ? '/' : '');
	
	//Create folders if they are not there
	foreach ($folders as $folder){
		
		if(empty($folder)) continue;
		
		$folderpath = (!empty($folderpath)) ? $folderpath.'/'.$folder : $prefix.$folder;
		
	}
	
	//Does the file exist
	if(file_exists($file) && empty($overwrite)){
	
		return false;
		
	}

	
	//Create and Open the file for writing
	if(!$fp = @fopen($file, "wb")){
	
		return false;
	
	}
	
	//Write the contents
	if (@fwrite($fp, $data) === FALSE) {
		
		return false;
		
	}
	
	//Close the handle
	fclose($fp);
	
	return true;
	
}

// To maintain consistency for data writing
function writedata($path, $data){
	$data = json_encode($data, JSON_PRETTY_PRINT);
	$ret = writefile($path, $data, 1);
	return $ret;
}

function check_session_key(){

	global $globals;

	if(isset($_COOKIE[$globals['cookie_name'].'_sid']) &&
	strlen(trim($_COOKIE[$globals['cookie_name'].'_sid'])) == 32){

		$id = $_COOKIE[$globals['cookie_name'].'_sid'];

		if(preg_match('~^[A-Za-z0-9]{32}$~', $id) == 0){
			 
			//Return False
			return 0;
			 
		}else{

			//Return Session ID
			return $id;

		}
	}
}

// Delete sess files
function sessDel(){
	
	global $globals, $SESS;

	$cookie_name = $globals['cookie_name'].'_sid';
	unset($_COOKIE[$cookie_name]);
	setcookie($cookie_name, null, -1, '/'); 
	unset($SESS);

	foreach(glob($globals['sess_path'].'/sess_*') as $filename){
		unlink($filename);
	}

}

function make_session($IP, $user){

	global $SESS, $globals;

	sessDel();

	$cookie_name = $globals['cookie_name'].'_sid';

	if(!isset($_COOKIE[$cookie_name])){
		// echo "Cookie named '" . $cookie_name . "' Was not set!";

		$key = check_session_key();
		$SESS['sid'] = empty($key) ? generateRandStr(32) : $key;
		$SESS['token'] = 'sess'.substr($SESS['sid'], 0, 16);
		@setcookie($globals['cookie_name'].'_sid', $SESS['sid'], 0, '/');

		// Create Session file
		if (!file_exists($globals['sess_path'])) {
			mkdir($globals['sess_path'], 0777, true);
		}

		$sess_file = $globals['sess_path'].'/sess_'.$SESS['sid'];
		
		foreach ($user as $key => $value) {
			$tmp[$key] = $value;
		}
		$tmp['ip'] = $IP;
		$tmp['token'] = $SESS['token'];

		writedata($sess_file, $tmp);

	}
	
}

// Creates the session file
function create_session_file($IP, $user){
	
	global $globals;
	
	$key = check_session_key();
	$sess_file = $globals['sess_path'].'/sess_'.$key;
	$cookie_name = $globals['cookie_name'].'_sid';

	// Check if session file exists
	if(!file_exists($sess_file) || !isset($_COOKIE[$cookie_name])){

		make_session($IP, $user);
		
	}
	
}

function isLogin($ip){
	
	global $globals, $SESS;
	
	//------------------------------------------------------------------------------------------
	// NOTE : Any changes done here will require changes to be done in sdk/sessions.php as well
	//------------------------------------------------------------------------------------------
	
	// Clear old sessions
	// sessDel();
	
	$key = check_session_key();
	$sess_file = $globals['sess_path'].'/sess_'.$key;
	
	if (!file_exists($sess_file)){
		sessDel();
		header('location:login.php?act=login');
		die();
	}
	
	$SESS = loaddata($sess_file);

	touch($sess_file);
	
	return $SESS;
	
}

function inputsec($string){
	
	//get_magic_quotes_gpc is depricated in php 7.4
	if(version_compare(PHP_VERSION, '7.4', '<')){
		if(!get_magic_quotes_gpc()){
		
			$string = addslashes($string);
		
		}else{
		
			$string = stripslashes($string);
			$string = addslashes($string);
		
		}
	}else{
		$string = addslashes($string);
	}
	
	// This is to replace ` which can cause the command to be executed in exec()
	$string = str_replace('`', '\`', $string);
	
	return $string;

}

function htmlizer($string){

global $globals;

	$string = htmlentities($string, ENT_QUOTES, $globals['charset']);
	
	preg_match_all('/(&amp;#(\d{1,7}|x[0-9a-fA-F]{1,6});)/', $string, $matches);//r_print($matches);
	
	foreach($matches[1] as $mk => $mv){
		$tmp_m = entity_check($matches[2][$mk]);
		$string = str_replace($matches[1][$mk], $tmp_m, $string);
	}
	
	return $string;
	
}

function optGET($name, $default = ''){

global $error;

    //Check the GETED NAME was GETed
    if(isset($_GET[$name])){
    
        return inputsec(htmlizer(trim($_GET[$name])));
        
    }else{
        
        return $default;
    
    }

}

function optPOST($name, $default = ''){

global $error;

	//Check the POSTED NAME was posted
	if(isset($_POST[$name])){
	
		return inputsec(htmlizer(trim($_POST[$name])));
		
	}else{
		
		return $default;
	
	}

}

function optPOST_r($post_arr){

	if(isset($_POST[$post_arr])){
		
		$array = $_POST[$post_arr];

		if(is_array($array)){

			$data = array();

			foreach($array as $key => $value){

				$data[] =  inputsec(htmlizer(trim($value)));

			}

			return $data;
		}

	}
}

function POSTval($name, $default = ''){
	
	return (!empty($_POST) ? (!isset($_POST[$name]) ? '' : inputsec(htmlizer(trim($_POST[$name])))) : $default);

}

function optREQ($name, $default = ''){

global $error;

	//Check the POSTED NAME was posted
	if(isset($_REQUEST[$name])){
	
		return inputsec(htmlizer(trim($_REQUEST[$name])));
		
	}else{
		
		return $default;
	
	}

}

// returs true or false
function isJSON($string){
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

function array_multisum(array $arr): float {
    $sum = array_sum($arr);
    foreach($arr as $child) {
        $sum += is_array($child) ? array_multisum($child) : 0;
    }
    return $sum;
}


function get_current_datetime(){

	date_default_timezone_set("Asia/Kolkata");
	return date('Y-m-d H:i:s');

}


function get_current_date(){

	date_default_timezone_set("Asia/Kolkata");
	return date('Y-m-d');
	
}



function printLable($lableName){
    echo '<lable>'.$lableName.'</lable>';
}

?>