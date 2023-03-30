<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");

$uname=$_SESSION['uname'];
$utype=$_SESSION['utype'];

require '../header.php';
// echo "<pre>";print_r($GLOBALS);
global $globals;
$globals = array();
$configuration = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/conf.json';
read_json_data($configuration);
?>
<div class="container" style="margin:8% auto;width:900px;">
<div class="well" id="res_div"></div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><b>Administrator Utilities</b></h3>
            <span class="text-muted"><b>Note:</b> Content Added here will be reflacted in website</span>
        </div> 
        <div class="panel-body">
            <form name="adm_utility" id="adm_utility" method="POST" action="" autocomplete="off">
                <div class="row">
                    <div class="col-md-6">
                        <label class="text-muted">Website Title ( Will be displayed In browser tab )</label>
                        <input name="sitetitle" id="sitetitle" value="<?php if(!empty($globals['sitetitle'])){ echo $globals['sitetitle']; } ?>" placeholder="Enter Website Name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted">Website Name ( Will be displayed In header )</label>
                        <input name="sitename" id="sitename"  value="<?php if(!empty($globals['sitename'])){ echo $globals['sitename']; } ?>" placeholder="Enter Website Name" class="form-control">
                    </div>
                </div>
                <div class="row" style="margin-top: 15px;">
                    <div class="col-md-12">
                        <label class="text-muted">Website Description ( Will be displayed In user main page )</label>
                        <textarea name="sitedesc" id="sitedesc" placeholder="Enter Website Description" class="form-control" rows="6"> <?php if(!empty($globals['sitedesc'])){ echo $globals['sitedesc']; } ?> </textarea>
                    </div>
                </div>
                <div class="row" style="margin-top: 15px; text-align:center;">
                    <div class="col-md-12">
                        <input type="hidden" name="override" id="override" value="1">
                        <input type="button" name="submit" id="submit" onclick='ajax_call_("utilities_save.php","adm_utility","res_div")' value="Save" class="btn btn-success adm-btn" style="width: 20%;">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>