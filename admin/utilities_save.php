<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");
// echo "<pre>";
// print_r($_POST);
extract($_POST);

$arr_empty_ele = array("sitetitle","sitename","sitedesc");
$arr_empty_ele_desc = array("Website Title","Website Name","Website Description");
// Input validation
foreach($arr_empty_ele AS $index => $element){
    if(empty($_POST[$element])){
        echo "<p class='txt-red'>Please Enter ".$arr_empty_ele_desc[$index]."...!</p>";
        die();
    }
}

$configuration = '../conf.json';

$data = '{
    "sitetitle": "'.$sitetitle.'",
    "sitename": "'.$sitename.'",
    "sitedesc": "'.$sitedesc.'"
}';

$mode = (!file_exists($configuration)) ? 'w':'a';
!empty($override) ? $mode = 'w' : $mode = 'a';
$confFile = fopen($configuration, $mode) or die("Unable to open file!");
if(fwrite($confFile, $data)){
    fclose($confFile);
    $arr_empty_ele = array("sitetitle","sitename","sitedesc");
    foreach($arr_empty_ele AS $index => $element){
        ?><script>$("#<?php echo $element; ?>").val("");</script><?php
    }
    echo "Configuration Saved Successfully...!";
}else{
    echo "Opps, Something Went Wrong...!";
}

?>