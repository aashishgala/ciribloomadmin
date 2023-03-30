<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");

$uname=$_SESSION['uname'];
$utype=$_SESSION['utype'];

// $userid = base64_decode($_GET['id']);
$uniq_id = base64_decode($_GET['id']);
if ($uniq_id == 'all') {
    $where ='';
}else{
    // $where = " WHERE user_id = '".$userid."'";
    $where = " WHERE uniq_id = '".$uniq_id."'";
}
require '../header.php';

$SqlQuizz = mysqlQuery("SELECT * from userscore $where");
while($RowQuizz=mysqliFetch($SqlQuizz))
{
    extract($RowQuizz);
    // $username = get_val("SELECT username FROM tblaccount WHERE user_id = '".$user_id."' LIMIT 1","username");
    $username = get_val("SELECT CONCAT(fname,' ',fathername,' ',lname) AS username FROM userdata WHERE uniq_id = '".$uniq_id."'", "username");
    $UserData[$user_id]['uname'] = ucwords($username);

    if($quizz_stage == 1){
        $round_1_mark = json_decode($round_1_mark, true);
        $UserData[$user_id][$quizz_stage] = array('total_score'=>$round_1_mark['total_score'],'mark'=>$round_1_mark['mark'],'json_round1'=>$json_round1);
    }
    elseif ($quizz_stage == 2) {
        $round_2_mark = json_decode($round_2_mark, true);
        $UserData[$user_id][$quizz_stage] = array('total_score'=>$round_2_mark['total_score'],'mark'=>$round_2_mark['mark'],'json_round2'=>$json_round2);
    }
}
// echo "<pre>";print_r($UserData);
?>
<div class="container" style="margin:8% auto;width:900px;">
<?php
if(empty($UserData)){
    $username = get_val("SELECT username FROM tblaccount WHERE user_id = '".$userid."' LIMIT 1","username");
    echo '<div class="panel panel-success">
    <div class="panel-heading">
        <h3 class="panel-title"><b><i class="fa fa-user" aria-hidden="true"></i> '.$username.'</b> has not attended quizz...!</h3>
    </div>
    </div>';
}else{
    foreach ($UserData as $uid => $userscoredata) 
    {
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><b><i class="fa fa-user" aria-hidden="true"></i> <?php echo $UserData[$uid]['uname']; ?></b></h3>
            </div> 
            <div class="panel-body">
                <table class="table table-hover adm-tbl">
                    <thead>
                    <th>Quizz Round</th>
                    <th class="text-center">Score</th>
                    <th class="text-center">Marks</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>One</td>
                            <?php
                            if(!empty(@$userscoredata[1])){ ?>
                                <td class="text-center"><?php echo $userscoredata[1]['total_score']; ?></td>
                                <td class="text-center"><?php echo $userscoredata[1]['mark']; ?></td>
                            <?php } else{ echo "<td colspan='2' class=\"text-center\">First Round Is Not Compeleted...!</td>"; }?>
                        </tr>
                        <tr>
                            <td>Two</td>
                            <?php
                            if(!empty(@$userscoredata[2])){ ?>
                                <td class="text-center"><?php echo $userscoredata[2]['total_score']; ?></td>
                                <td class="text-center"><?php echo $userscoredata[2]['mark']; ?></td>
                            <?php } else{ echo "<td colspan='2' class=\"text-center\">Second Round Is Not Compeleted...!</td>"; }?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
}
?>
</div>