<?php
ob_start();
date_default_timezone_set('Asia/Kolkata');
$TimeStamp=date('d-m-Y h:i:s A');

	

// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
require_once './project_path.php';

// $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

// if ($_SERVER['REMOTE_ADDR'] == "::1") {
//     $ProjectPath = $host."/quiz_forum/";
//     $configuration = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/conf.json';
//     $DocumentRoot = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/';
// }else{
//     $ProjectPath = $host."/";
//     $configuration = $_SERVER[ 'DOCUMENT_ROOT' ].'/conf.json';
//     $DocumentRoot = $_SERVER[ 'DOCUMENT_ROOT' ].'/';
// }
$configuration = $site_path.'conf.json';
$DocumentRoot = $site_path;

$uid = (isset($_SESSION['uniq_id'])) ? $_SESSION['uniq_id'] : '' ;

if(empty($uid)){
    ?>
    <script>
    // alert('Authentication Failed...!');
    // window.location.href='https://www.ciribloom.co.uk';
    </script>
    <?php
}
require './functions/db.php';
require './functions/mysql_fun.php';

// $sel = "SELECT CONCAT(fname ,' ', fathername ,' ', lname) AS fullname FROM userdata WHERE uniq_id = '".$uid."' LIMIT 1";
// $sql_username = mysqlQuery($sel);
// $user_data = mysqliFetch($sql_username);
// $user_name = $user_data['fullname'];

// $sel = "SELECT * FROM userscore WHERE uniq_id = '".$uid."'";
// $marks = mysqlQuery($sel);
// while($row=mysqliFetch($marks))
// {
//     extract($row);
//     if ($quizz_stage == 1) {
//         $r1_mark = json_decode($round_1_mark, true);
//         $arr_data['stage_one'] = $r1_mark;
//     }
//     elseif ($quizz_stage == 2) {
//         $r2_mark = json_decode($round_2_mark, true);
//         $arr_data['stage_two'] = $r2_mark;
//     }
// }

// if(!isset($arr_data['stage_one']) || !isset($arr_data['stage_two'])){
//     die('Please Complete Both Quiz');
// }

// $total_scores = $arr_data['stage_one']['total_score'] + $arr_data['stage_two']['total_score'];
// $total_marks = $arr_data['stage_one']['mark'] + $arr_data['stage_two']['mark'];

?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--Custom CSS-->
	    <link rel="stylesheet" type="text/css" href="<?php echo $ProjectPath; ?>css/certificate.css">

        <!--Bootstrap CSS-->
        <link rel="stylesheet" type="text/css" href="<?php echo $ProjectPath; ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $ProjectPath; ?>css/bootstrap.min.css">

        <link href="<?php echo $ProjectPath; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container-fluid" id="certificatePDF">
            <div class="row">
            <!-- <div class="col-md-2 col-lg-2"></div> -->
            <!-- main div -->
                <div class="col-md-12 col-lg-12">
                    <!-- header -->
                    <div class="row header-bg">
                        <div class="col-md-12 col-lg-12"></div>
                    </div>
                    <!-- Images -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                        <table class="table table-hover">
                                <tr>
                                    <td width="25%">
                                        <img src="https://www.ciribloom.co.uk/wp-content/uploads/Ciribloom_Transparent_Background__1K.png" height="100px" width="100px">
                                    </td>
                                    <td width="50%"></td>
                                    <td width="25%" style="float: right !important;">
                                        <img src="https://www.ciribloom.co.uk/wp-content/uploads/Ciribloom_Transparent_Background__1K.png" height="100px" width="100px">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- content -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class=" text-center">
                                <h1 class="certi_head">Certification Of completion</h1>
                                <p><b>This certificate is awarded to</b></p>
                                <span class="border-sty border-name"> <?php echo $user_name; ?></span>
                                
                                <p style="margin-top: 25px;">
                                    on <span class="border-sty border-on"> - </span> for successfully <br>
                                    completing the Online Diploma Course - for Learning & Teaching Languages <br>
                                    by Ciribloom, UK, with <span class="border-sty border-grade"> <?php echo $total_marks; ?></span> Grade
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- Signature -->
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <table class="table table-hover">
                                <tr>
                                    <td width="50%"  class="text-center">
                                        ______________________________
                                        <br>
                                        <b>Dilip Amdekar, CA</b> <br>
                                        Chairman & CEO, Ciribloom, UK
                                    </td>
                                    <td width="50%" style="float: right !important;" class="text-center">
                                        ______________________________
                                        <br>
                                        <b>Dr. Amrutha Joshi Amdekar</b> <br>
                                        Language Learning,Course Designer, Ciribloom, UK
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            <!-- main div end-->
            <!-- <div class="col-md-2 col-lg-2"></div> -->
            </div>
            <!-- main row -->
        </div>
        <!-- container fluid -->
    </body>
</html>

<?php
// die();
	$html=ob_get_contents();

    include('./MPDF/mpdf.php');
	$mpdf=new mPDF('win-1252','A4','','',10,10,42,10,10,10);
	$mpdf->SetDisplayMode('fullpage');
	$mpdf->setFooter("||Print Date: $TimeStamp");

	$footer='
	<table width="100%" style="border:0px !important;">
	    <tr>
	        <td width="13.33%"  style="font-size:12px; border:0px !important; text-align:center;">&nbsp;&nbsp;Page {PAGENO} of {nb}</td>
	    </tr>
	</table>
	';
	$mpdf->setFooter("||Print Date: $TimeStamp");

	ob_end_clean();
    $stylesheet = file_get_contents('./css/certificate.css');
    $stylesheetb = file_get_contents('./css/bootstrap.css');
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($stylesheetb,1);
	$mpdf->WriteHTML($html,2); 
	// $mpdf->Output('Certificate.pdf','D');
	$mpdf->Output();
?>