<?php

require './globals.php';
require './language.php';
require './class/mysql.php';
require './functions/function.php';
require '../language/title.php';

// php_errors();
php_start_session();
// r_print($_SESSION);/

// Craete mysql class object to use mysql functions
$mysql_obj = new mysql_function();

if(isset($_SESSION['logged_in_as'])){

    $sess_data['logged_in_as'] = $_SESSION['logged_in_as'];
    $sess_data['user'] = $_SESSION['user'];

}
else{

    $ip = $_SERVER['REMOTE_ADDR'];
    $sess_data = isLogin($ip);

}

$sql = executeQuery('SELECT * FROM users WHERE ( uname = "'.$sess_data['user'].'" OR email = "'.$sess_data['user'].'" ) AND utype = "'.$sess_data['logged_in_as'].'" LIMIT 1');

$result = fetchData($sql);

foreach ($result as $key => $value) {

    if(isJSON($value)){
        $sess_data[$key] = json_decode($value); 
    }else{
        $sess_data[$key] = $value;
    }

}

// r_print($sess_data);
// die();

$act = '';
$api = '';

if(empty($act)) $act = optGET('act');
if(optREQ('api')) $api = optREQ('api');

(empty($api)) ? require 'header.php' : require './api/header.php';

switch($act){
	
	//The DEFAULT Page
	default:	
    
    include_once('blank.php');
    welcome();
	break;

    // Add Course
	case 'add_course':
    include_once('add_course.php');
    add_course();
    break;

    // Add Module
	case 'add_module':
    include_once('add_module.php');
    add_module();
    break;

    // Add Module
	case 'add_assignment':
    include_once('add_assignment.php');
    add_assignment();
    break;

    // add teacher
	case 'add_teacher':
    include_once('addteacher.php');
    add_teacher();
    break;

    // assign course to teacher
	case 'assign_course':
    include_once('assign_course.php');
    assign_course();
    break;

    // assign course list to teacher
	case 'assign_course_list':
    include_once('assign_course_list.php');
    assign_course_list();
    break;

    case 'student_marks':
    include_once('student_marks.php');
    student_marks();
    break;

    // Profile
	case 'profile':
    include_once('profile.php');
    profile();
    break;

    // Profile
	case 'change_password':
    include_once('change_password.php');
    change_password();
    break;
}

if(empty($api)){

    init_theme($theme);

    require 'footer.php';

}else{

	$api_func = 'API_'.$theme['name']; // -6 is to remove _theme
    call_user_func($api_func);

    sitefooter();

}

?>