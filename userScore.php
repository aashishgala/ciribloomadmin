<?php
include "functions/func.php";
$DocumentRoot = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/';
$ProjectPath = "http://localhost/quiz_forum/";

// $userid = $_SESSION['user_Id'];
$userid = $_SESSION['user_id'];
$uniq_id = $_SESSION['uniq_id'];
extract($_GET);

$StoreUserScore = "./UserScore/user_".$uniq_id;

if (!file_exists($StoreUserScore)) { mkdir($StoreUserScore, 0777, true); }

if($round == 5) { $file = "/demo.json"; } 
elseif($round == 1) { $file = "/round1.json"; } 
else { $file = "/round2.json"; }

$ScoreFilePath = $StoreUserScore.$file;

if (!empty($qrystring) && $qrystring == 'RewriteJson')
{
    $data = file_get_contents($ScoreFilePath);
    $data = substr($data, 0, -1);
    $FinalData = "[\n".$data."\n]";

    createUserScoreFile($ScoreFilePath, $FinalData, 1);

    $FinalDataDb = preg_replace("/\s+/", "", $FinalData);

    date_default_timezone_set('Asia/Kolkata');
    $CurrentTime=date('Y-m-d h:i:s');

    $quiz_mark = $TotalScore * 2; // for each right answer 2 mark

    $json_round2 = '';$json_round1 = '';
    $mark_round1 = '';$json_round2 = '';

    $date_update = ", date='".$CurrentTime."'";
    if ($round == 5) { 
        // demo
        $quizStage = $round; $whereStage = "-5";
        $json_round1 = ", json_round1 = '".$FinalDataDb."'";

        $marks_json = '{"total_score" : "'.$TotalScore.'", "mark" : "'.$quiz_mark.'"}';
        $mark_round1 = ", round_1_mark = '".$marks_json."'";
    }
    elseif ($round == 1) { 
        $quizStage = $round; $whereStage = "-1";
        $json_round1 = ", json_round1 = '".$FinalDataDb."'";

        $marks_json = '{"total_score" : "'.$TotalScore.'", "mark" : "'.$quiz_mark.'"}';
        $mark_round1 = ", round_1_mark = '".$marks_json."'";
    }
    else { 
        $quizStage = $round; $whereStage = "-2";
        $json_round2 = ", json_round2 = '".$FinalDataDb."'";

        $marks_json = '{"total_score" : "'.$TotalScore.'", "mark" : "'.$quiz_mark.'"}';
        $mark_round2 = ", round_2_mark = '".$marks_json."'";
    }

    $SqlUpdate = "UPDATE userscore SET quizz_stage = '".$quizStage."' $mark_round1 $mark_round2 $json_round1  $json_round2 $date_update WHERE user_id = '".$userid."' AND quizz_stage = '".$whereStage."'";
    mysqlQuery($SqlUpdate);
    if ($round == 1) 
    {
        // Ready for round 2
        $is_second_completed = get_val("SELECT id from userscore WHERE uniq_id='".$uniq_id."'","id");
        if (empty($is_second_completed)) {
            $SqlInsert = "INSERT INTO userscore (`user_id`, `quizz_stage`) VALUES ('".$userid."','-2')";
            mysqlQuery($SqlInsert);
        }
    }
}
if (!empty($qrystring) && $qrystring == 'UserScore') 
{
    $data = '
    {
        "databaseId" : "'.$databaseId.'",
        "que_numb" : "'.$que_numb.'",
        "correcAns" : "'.$correcAns.'",
        "userAns" : "'.$userAns.'"
    },';

    createUserScoreFile($ScoreFilePath, $data, '');
}
// echo "<pre>";
// print_r($_SESSION);
// print_r($_GET);