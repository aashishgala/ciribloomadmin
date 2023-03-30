<?php
require_once './project_path.php';

require './functions/db.php';
require './functions/mysql_fun.php';

$configuration = $site_path.'conf.json';
$DocumentRoot = $site_path;

$uid = (isset($_SESSION['uniq_id'])) ? $_SESSION['uniq_id'] : '' ;

if(empty($uid)){
    ?>
    <script>
    alert('Authentication Failed...!');
    window.location.href='<?php echo $ciri_url; ?>';
    </script>
    <?php
    die();
}
$sel = "SELECT * FROM userscore WHERE uniq_id = '".$uid."'";
$marks = mysqlQuery($sel);
while($row=mysqliFetch($marks))
{
    extract($row);
    if ($quizz_stage == 1) {
        $r1_mark = json_decode($round_1_mark, true);
        $arr_data['stage_one'] = $r1_mark;
    }
    elseif ($quizz_stage == 2) {
        $r2_mark = json_decode($round_2_mark, true);
        $arr_data['stage_two'] = $r2_mark;
    }
}

if(!isset($arr_data['stage_one']) || !isset($arr_data['stage_two'])){
    include 'sessout.php';
    ?>
    <script>
    window.location.href='<?php echo $ciri_url; ?>';
    </script>
    <?php
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Compeleted</title>
    <link rel="stylesheet" href="css/qstyle.css">
    <link src="font-awesome/css/font-awesome.css" rel="stylesheet">
    <style>
        .btn-info{
            background: transparent;
            padding: 10px;
            border: 1px solid;
            text-decoration: none;
            color: #000;
        }
    </style>
</head>
    <body>
        <!-- Certificate Download button -->
        <div class='parent'>
            <h4 style="text-align: center;">Congratulations You have Compeleted Your quiz.</h4>
            <br>
            <a href='certificate.php?file=certificate' target="_BLANK" class="btn-info">Download Certificate</a>
            <a href="#" onclick="redirect_ciri()" class="btn-info">Home</a>
            <p style="margin-top: 15px; color:red;">Note: Please click on download button to download certificate you can download only once.</p>
        </div>
        
        <!--Script-->
    <script src="<?php echo $ProjectPath; ?>js/jquery.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/jquery.min1.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/bootstrap.min1.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/custom.js"></script>
    
        <script>
            function redirect_ciri(){
                user_score_ajax("sessout.php","");
                setTimeout(function(){window.location.href = "<?php echo $ciri_url; ?>";}, 200);
            }
        </script>
    </body>
</html>