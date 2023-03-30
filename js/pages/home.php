<?php
include "../functions/func.php";
require $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/header.php'; 
check_session($_SESSION['username'], "../index.php", "Authantication Failed");

    // if (!isset($_SESSION['username']) && $_SESSION['username']==""){
    //     header("Location:../index.php");
    //     die();
    // }
    $userid = $_SESSION['user_id'];

    $show_well = ''; $show_qiz = '';
    $SqlQuizzData = mysqlQuery("SELECT quizz_stage from userscore WHERE user_id = '".$userid."' ORDER BY id DESC LIMIT 1");
    $RowQuizzData=mysqliFetch($SqlQuizzData);
    if (!empty($RowQuizzData) && in_array($RowQuizzData['quizz_stage'], array(1,2,-2)))
    {
        $show_well = 1;
        $part = 1;
    }

    if (!empty($RowQuizzData) && in_array($RowQuizzData['quizz_stage'], array(1,-1,-2)))
    {
        $show_qiz = 1;
        $part = 0;
    }

    if (empty($RowQuizzData))
    {
        $show_qiz = 1;
    }
    $SqlQuizz = mysqlQuery("SELECT * from userscore WHERE user_id = '".$userid."' ORDER BY id");
    while($RowQuizz=mysqliFetch($SqlQuizz))
    {
        extract($RowQuizz);
        if($quizz_stage == 1){
            $round_1_mark = json_decode($round_1_mark, true);
            $UserData[$quizz_stage] = array('total_score'=>$round_1_mark['total_score'],'mark'=>$round_1_mark['mark'],'json_round1'=>$json_round1);
        }
        elseif ($quizz_stage == 2) {
            $round_2_mark = json_decode($round_2_mark, true);
            $UserData[$quizz_stage] = array('total_score'=>$round_2_mark['total_score'],'mark'=>$round_2_mark['mark'],'json_round2'=>$json_round2);
        }
    }
   
    if (!file_exists("../js/questions.js"))
    {
        $roundfirst = "SELECT * from quizz_data WHERE `qt_id` IN (1,5,6)";
        createQuestionFile("../js/questions.js", $roundfirst);
        $roundsecond = "SELECT * from quizz_data WHERE `qt_id` NOT IN (1,5,6)";
        createQuestionFile("../js/questions2.js", $roundsecond);
    }
    ?>
    <div class="container" style="margin:7% auto;">
    <?php 
        if($show_qiz == 1){ ?> 
            <a class="btn start-qiz" href="../test.php">Start Quizz</a> 
        <?php }
        if($show_well == 1)
        { 
            if ($part > 0) { ?>
                <div class="well show-well">You have completed your quiz...!</div>
            <?php } ?>
            <ul class="nav nav-tabs score-tab">
                <li class="active"><a data-toggle="tab" href="#quiz1">Round One</a></li>
                <li><a data-toggle="tab" href="#quiz2">Round Two</a></li>
            </ul>

            <div class="tab-content">
                <div id="quiz1" class="tab-pane fade in active">
                    <?php 
                    if(!empty(@$UserData[1])){ ?>
                        <p>
                            You have scored : <b><?php echo $UserData[1]['total_score']; ?> points</b> </br>
                            Your total marks : <b><?php echo $UserData[1]['mark']; ?> marks</b>
                        </p>
                    <?php } else{ echo "<p>First Round Is Not Compeleted...!</p>"; }?>
                </div>
                <div id="quiz2" class="tab-pane fade">
                    <?php
                    if(!empty($UserData[2]) && isset($UserData[2])){ ?>
                        <p>
                            You have scored : <b><?php echo $UserData[2]['total_score']; ?> points</b> </br>
                            Your total marks : <b><?php echo $UserData[2]['mark']; ?> marks</b>
                        </p>
                    <?php }  else{ echo "<p>Second Round Is Not Compeleted...!</p>"; } ?>
                </div>
            </div>
            <?php 
        } 
        ?>
    </div>
<?php
// require $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/footer.php'; 
die();
        $SqlQuizzData = mysqli_query($con,"SELECT * from quizz_data");
        while($RowQuizzData=mysqli_fetch_assoc($SqlQuizzData)){
            extract($RowQuizzData);
            $ArrQtype[$qt_id] = $question_type;
            $ArrQuizzDetail[$qt_id][] = array(
                'question'=>$question, 
                'explaination'=>$explaination,
                'choice1'=>$choice1,
                'choice2'=>$choice2,
                'choice3'=>$choice3,
                'choice4'=>$choice4
            );
        }
        foreach ($ArrQtype as $QtypeId => $QtypeTitle) {
        echo 
        '<div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">'.ucfirst($QtypeTitle).'</h3>
            </div> 
            <div class="panel-body quizz-body">
            <ul class="q-list">
            ';
            foreach ($ArrQuizzDetail[$QtypeId] as $Index => $Value) {
                $AttrName = $QtypeId.$Index;
                echo '<li type="square">';
                echo '<p class="q-qst">'.$Value['question'].'</p>';
                echo '<p class="q-desc">&nbsp;&nbsp; - '.$Value['explaination'].'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'"> '.$Value['choice1'].'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'"> '.$Value['choice2'].'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'"> '.$Value['choice3'].'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'"> '.$Value['choice4'].'</p>';
                echo '</li>';
            }
            echo 
            '</ul>
            </div>
        </div>';
    }
        ?>