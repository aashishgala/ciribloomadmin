<?php
ob_start();
require_once './project_path.php';

$configuration = $site_path.'conf.json';
$DocumentRoot = $site_path;

if(isset($_SESSION['uniq_id'])){
    $uid = $_SESSION['uniq_id'];
}elseif(isset($_REQUEST['uid'])){
    $uid = base64_decode($_REQUEST['uid']);
}

if(empty($uid)){
    ?>
    <script>
    alert('Authentication Failed...!');
    window.location.href='https://www.ciribloom.co.uk';
    </script>
    <?php
}

require './functions/db.php';
require './functions/mysql_fun.php';

$sel = "SELECT CONCAT(fname ,' ', fathername ,' ', lname) AS fullname FROM userdata WHERE uniq_id = '".$uid."' LIMIT 1";
$sql_username = mysqlQuery($sel);
$user_data = mysqliFetch($sql_username);
$user_name = $user_data['fullname'];

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
    die('Please Complete Both Quiz');
}

$total_scores = $arr_data['stage_one']['total_score'] + $arr_data['stage_two']['total_score'];
$total_marks = $arr_data['stage_one']['mark'] + $arr_data['stage_two']['mark'];

$grade_space = $on_space = '';
$grade_space_range = range(1,10);
foreach($grade_space_range AS $range){
    $grade_space .= '&nbsp;';
}

$on_space_range = range(1,15);
foreach($on_space_range AS $range){
    $on_space .= '&nbsp;';
}
?>
<html>
    <body>
        <div class="container-fluid" id="certificatePDF">
            <!-- header -->
            <div class="row header-bg">
                <div class="col-md-12 col-lg-12">
                </div>
            </div>
            <!-- Images -->

            <div style="width:100%">
                <div style="width:50%; float:left;">
                    <img src="images/logo2.jpg" height="100px" width="100px" alt="Pineapple" style="width:170px;height:170px;margin-left:15px;" style="float: left;">
                </div>
                <div style="width:50%; float:left;">
                    <img src="https://www.ciribloom.co.uk/wp-content/uploads/Ciribloom_Transparent_Background__1K.png" height="100px" width="100px" alt="Pineapple" style="width:170px;height:170px;margin-left:15px;" style="float: right;">
                </div>
            </div>
            <!-- content -->
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="text-center">
                        <h1 class="certi_head" style="font-size: 45px;">Certification Of completion</h1>
                        <p style="margin-bottom: 25px;margin-top: 25px;"><b>This certificate is awarded to</b></p>
                        <p style="border-bottom:1px solid; border-bottom-style:dotted; width:80%; text-align:center; margin:auto;">
                            <?php echo ucwords($user_name); ?>
                        </p>
                        
                        <p style="margin-top: 25px; line-height:30px;">
                            on <span style="border-bottom:1px solid; border-bottom-style:dotted;">
                            <?php echo $on_space.'-'.$on_space; ?></span> for successfully <br>
                            completing the Online Diploma Course - for Graphic Design <br>
                            by Ciribloom, UK, with <span style="border-bottom:1px solid; border-bottom-style:dotted;"> 
                            <?php echo $grade_space.' '.$total_marks.' '.$grade_space; ?></span> Grade
                        </p>
                    </div>
                </div>
            </div>
            <!-- Signature -->
            <div class="row" style="margin-top: 50px;">
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
                <div class="col-md-12 col-lg-12 text-center">
                    <p style="font-size: 12px; color:#757c80;"><b>CiriBloom is a brand owned by STEM-ASTM Ltd, a 100% subsidiary of ASTML, UK</b></p>
                </div>
            </div>
        </div>
        <!-- container fluid -->
    </body>
</html>
<?php
// die();
	$html=ob_get_contents();
    ob_clean();
	ob_end_clean();
    include('./MPDF/mpdf.php');
	$mpdf=new mPDF('win-1252','A4','','',1,1,10,10,0,0);
	$mpdf->SetDisplayMode('fullpage');

    $stylesheetb = file_get_contents($ProjectPath.'css/bootstrap.css');
    $stylesheet = file_get_contents($ProjectPath.'css/certificate.css');
	$mpdf->WriteHTML($stylesheetb,1);
	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html,2); 
	// $mpdf->Output('Certificate.pdf','D');
	$mpdf->Output();
?>