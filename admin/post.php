<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");

$uname=$_SESSION['uname'];
$utype=$_SESSION['utype'];
$selected_q_type = '';
if (isset($_POST['question_type']) && !empty($_POST['question_type'])) {
    $selected_q_type = $_POST['question_type'];
}

(!empty($selected_q_type)) ? $whr_filter = " WHERE question_type LIKE '%".$selected_q_type."%'" : $whr_filter = '';

unset($ArrQtype);
unset($ArrQuizzDetail);
$ArrQtype = array();
$ArrQuizzDetail = array();

$option = '<option>Select</option>';
$SqlQType = mysqlQuery("SELECT DISTINCT(question_type) from quizz_data");
while($RowQType=mysqliFetch($SqlQType)){
    $question_type = $RowQType['question_type'];
    ($selected_q_type == $question_type) ? $tick = 'selected' : $tick = '';
    $option .="<option value=".$question_type." ".$tick.">".$question_type."</option>";
}

$SqlQuizzData = mysqlQuery("SELECT * from quizz_data".$whr_filter);
while($RowQuizzData=mysqliFetch($SqlQuizzData)){
    extract($RowQuizzData);
    $ArrQtype[$qt_id] = $question_type;
    $ArrQuizzDetail[$qt_id][] = array(
        'question'=>$question, 
        'explaination'=>$explaination,
        'choice1'=>$choice1,
        'choice2'=>$choice2,
        'choice3'=>$choice3,
        'choice4'=>$choice4,
        'answer'=>$answer,
    );
}
require $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/header.php'; 
?>
<div class="container" style="margin:8% auto;width:900px;">
    <div class="panel panel-success">
        <div class="panel-heading q-panel">
            <div class="col-md-6 panel-title">
                <form name="qtype_form" id="qtype_form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <select name="question_type" id="question_type" class="form-control" onchange="form.submit();">
                        <?php echo $option; ?>
                    </select>
                </form>
            </div>
            <!-- <a href="add-topic.php" class="btn btn-success add-q">Add New</a> -->
        </div> 
    </div>
    
    <?php
    $pattern = '/[^A-Za-z0-9 ]/';
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
                $Opt1 = preg_replace($pattern, ' ', $Value['choice1']);
                $Opt2 = preg_replace($pattern, ' ', $Value['choice2']);
                $Opt3 = preg_replace($pattern, ' ', $Value['choice3']);
                $Opt4 = preg_replace($pattern, ' ', $Value['choice4']);
                $correctAns = $Value['answer'];

                $opt1Checked = '';
                $opt2Checked = '';
                $opt3Checked = '';
                $opt4Checked = '';
                
                if ($correctAns == 1) {
                    $opt1Checked = 'checked';
                }elseif ($correctAns == 2) {
                    $opt2Checked = 'checked';
                }elseif ($correctAns == 3) {
                    $opt3Checked = 'checked';
                }elseif ($correctAns == 4) {
                    $opt4Checked = 'checked';
                }

                echo '<li type="square">';
                echo '<p class="q-qst">'.$Value['question'].'</p>';
                echo '<p class="q-desc">&nbsp;&nbsp; - '.$Value['explaination'].'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'" '.$opt1Checked.'> '.$Opt1.'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'" '.$opt2Checked.'> '.$Opt2.'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'" '.$opt3Checked.'> '.$Opt3.'</p>';
                echo '<p><input type="radio" name="Quizz_'.$AttrName.'" '.$opt4Checked.'> '.$Opt4.'</p>';
                echo '</li>';
            }
            echo 
            '</ul>
            </div>
        </div>';
    }
    ?>
</div>