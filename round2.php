<?php
include "functions/func.php";
include "language/language.php";
$userid = $_SESSION['user_id'];
$uniq_id = $_SESSION['uniq_id'];
check_session($uniq_id, "quizone.php", "Authantication Failed");
$SqlQuizzData = mysqlQuery("SELECT * from userscore WHERE user_id = '".$userid."'  AND quizz_stage IN(2,-2)");
$RowQuizzData=mysqliFetch($SqlQuizzData);
// print_r($RowQuizzData);
$UserQuizStage ='';
if (empty($RowQuizzData))
{
    $SqlInsert = "INSERT INTO userscore (`user_id`, `quizz_stage`, `uniq_id`) VALUES ('".$userid."','-2','".$uniq_id."')";
    mysqlQuery($SqlInsert);
    $UserQuizStage = 2;
}
elseif (!empty($RowQuizzData) && $RowQuizzData['quizz_stage'] == '-2') 
{
    $UserQuizStage = 2;
}
elseif (!empty($RowQuizzData) && $RowQuizzData['quizz_stage'] == '2') 
{
    header("Location:./quiztwo.php?completed=yes");
}

$getquestotal = mysqlQuery("SELECT * from question_type WHERE `qt_id` NOT IN (1,5,6,8)");
while ($rowquestotal=mysqliFetch($getquestotal)) {
    extract($rowquestotal);
    $catwise_total[$qt_id] = $total_q;
}

$getques = mysqlQuery("SELECT * from quizz_data WHERE `qt_id` NOT IN (1,5,6,8)");
while ($rowques=mysqliFetch($getques)) {
    extract($rowques);
    $arr_catwise_q[$qt_id][] = $id;
}

foreach ($arr_catwise_q as $cat_id => $arr_qid) {
    if (!empty($catwise_total[$cat_id])) {
        shuffle($arr_qid);
        foreach ($arr_qid as $newkey => $newval) {
            $random_q[$cat_id][] = $newval;
        }

        $FinalQuestions[$cat_id] = array_slice($random_q[$cat_id], 0, $catwise_total[$cat_id]);

        foreach ($FinalQuestions[$cat_id] as $k => $v) {
            $allques[$v] = $v;
        }
    }
}
// echo "<pre>";print_r($allques);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $language['site_name']; ?></title>
    <link rel="stylesheet" href="css/qstyle.css">
    <link src="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- FontAweome CDN Link for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body class="rounds">
    <!-- <div id="back-home">
        <a class="btn-home" href="./main.php"> <span class="glyphicon  glyphicon-home"></span> Home 
        </a>
    </div> -->
    <!-- start Quiz button -->
    <div class="start_btn"><button>Start Quiz Round 2</button></div>
    <?php 
    $Rules = array(
        "Press the start button once you are completely ready for the test",
        "You will have only <span>".$language['quiz_max_time']." seconds</span> per each question",
        "No second attempt is allowed",
        "Once you select your answer, it can't be undone",
        "Each MCQ carries 2 marks",
        "If you don't answer within the stipulated time, it would be considered as a wrong answer and the program will automatically take you forward to the next question",
    );
    ?>
    <!-- Info Box -->
    <div class="info_box">
        <div class="info-title"><span>Rules of Quiz</span></div>
        <div class="info-list">
            <ol>
            <?php
                foreach($Rules AS $Key => $Rule)
                {
                    echo '<li class="info">'.$Rule.'</li>';
                }
            ?>
            </ol>
        </div>
        <div class="buttons">
            <button class="quit">Exit Quiz</button>
            <button class="restart">Start</button>
        </div>
    </div>

    <!-- Quiz Box -->
    <div class="quiz_box">
        <header>
            <div class="title">Quiz</div>
            <div class="timer">
                <div class="time_left_txt">Time Left</div>
                <div class="timer_sec"><?php echo $language['quiz_max_time']; ?></div>
            </div>
            <div class="time_line"></div>
        </header>
        <section>
            <div class="que_text">
                <!-- Here I've inserted question from JavaScript -->
            </div>
            <div class="option_list">
                <!-- Here I've inserted options from JavaScript -->
            </div>
            <div class="option_description">
                <!-- Here I've inserted options from JavaScript -->
            </div>
        </section>

        <!-- footer of Quiz Box -->
        <footer>
            <div class="total_que">
                <!-- Here I've inserted Question Count Number from JavaScript -->
            </div>
            <button class="next_btn">Next</button>
        </footer>
    </div>

    <!-- Result Box -->
    <div class="result_box">
        <div class="icon">
            <i class="fas fa-crown"></i>
        </div>
        <div class="complete_text">You have completed quiz <br> Continue with your pending course</div>
        <div class="score_text">
            <!-- Here I've inserted Score Result from JavaScript -->
        </div>
        <div class="buttons">
            <button class="restart" style="display: none;">Replay Quiz</button>
            <button class="quit">Quit Quiz</button>
        </div>
    </div>

    <script src="./js/jquery.js"></script>
    <script src="./js/jquery.min1.js"></script>

    <!-- Inside this JavaScript file I've inserted Questions and Options only -->
    <?php 
    if($UserQuizStage == 2) 
    {
        ?>
        <script>let round = 2;</script>
        <script src="./js/questions2.js"></script>
        <?php 
    }
    ?>
    <script>
        var passedArray = <?php echo json_encode($allques); ?>;
        // console.log(arr_quizz_que);
        let q_tbl_id, qi = 0;
        let questions = [];
        for(var j = 0; j < arr_quizz_que.length; j++){
            q_tbl_id = arr_quizz_que[j].tblAutoId;
            // console.log(q_tbl_id);
            if(q_tbl_id == passedArray[q_tbl_id]){
                questions[qi] = arr_quizz_que[j];
                qi++;
                // console.log(passedArray[q_tbl_id]);
            }
        }
        // console.log(questions);
            
        // let random_q = [];
        // function shuffle(array) {
        //     let currentIndex = array.length,  randomIndex;
        //     // While there remain elements to shuffle.
        //     while (currentIndex != 0) {

        //         // Pick a remaining element.
        //         randomIndex = Math.floor(Math.random() * currentIndex);
        //         currentIndex--;
                
        //         // console.log(array[randomIndex].tblAutoId);
        //         if(passedArray.includes(array[randomIndex].tblAutoId)){
        //             random_q[array[currentIndex]] = array[randomIndex];
        //         }
        //         // And swap it with the current element.
        //             [array[currentIndex], array[randomIndex]] = [
        //             array[randomIndex], array[currentIndex]];
        //     }

        //     return array;
        // }
        // questions = shuffle(questions);
        // console.log(questions);
    </script>
    <!-- Inside this JavaScript file I've coded all Quiz Codes -->
    <script src="./js/script.js"></script>
    <script src="./js/custom.js"></script>
</body>
</html>
</html>