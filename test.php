<?php
include "functions/func.php";
$userid = $_SESSION['user_Id'];
// echo "SELECT * from userscore WHERE user_id = '".$userid."'";
$SqlQuizzData = mysqlQuery("SELECT * from userscore WHERE user_id = '".$userid."' ORDER BY id DESC");
$RowQuizzData=mysqliFetch($SqlQuizzData);
// print_r($RowQuizzData);
$UserQuizStage ='';
if (empty($RowQuizzData))
{
    $SqlInsert = "INSERT INTO userscore (`user_id`, `quizz_stage`) VALUES ('".$userid."','-1')";
    mysqlQuery($SqlInsert);
    $UserQuizStage = 1;
    $round_title = "Round 1";
}
elseif (!empty($RowQuizzData) && $RowQuizzData['quizz_stage'] == '-1') 
{
    $UserQuizStage = 1;
    $round_title = "Round 1";
}
elseif (!empty($RowQuizzData) && $RowQuizzData['quizz_stage'] == '-2') 
{
    $UserQuizStage = 2;
    $round_title = "Round 2";
}
elseif (!empty($RowQuizzData) && $RowQuizzData['quizz_stage'] == '2') 
{
    header("Location:./pages/home.php");
}
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
<body>
    <div id="back-home">
        <a class="btn-home" href="./pages/home.php"> <span class="glyphicon  glyphicon-home"></span> Home 
        </a>
    </div>
    <!-- start Quiz button -->
    <div class="start_btn"><button>Start Quiz <?php echo $round_title; ?></button></div>
    <?php 
    $Rules = array(
        "Press the start button once you are completely ready for the test",
        "You will have only <span>40 seconds</span> per each question.",
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
            <button class="restart">Continue</button>
        </div>
    </div>

    <!-- Quiz Box -->
    <div class="quiz_box">
        <header>
            <div class="title">Awesome Quiz Application</div>
            <div class="timer">
                <div class="time_left_txt">Time Left</div>
                <div class="timer_sec">40</div>
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
        <div class="complete_text">You've completed the Quiz!</div>
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
    if($UserQuizStage == 1) 
    {
        ?>
        <script>let round = 1;</script>
        <script src="./js/questions.js"></script>
        <?php 
    }
    elseif($UserQuizStage == 2) 
    {
        ?>
        <script>let round = 2;</script>
        <script src="./js/questions2.js"></script>
        <?php 
    }
    ?>
    <script>
        function shuffle(array) {
            let currentIndex = array.length,  randomIndex;

            // While there remain elements to shuffle.
            while (currentIndex != 0) {

                // Pick a remaining element.
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;

                // And swap it with the current element.
                [array[currentIndex], array[randomIndex]] = [
                array[randomIndex], array[currentIndex]];
            }

            return array;
        }
        questions = shuffle(questions);
    </script>
    <!-- Inside this JavaScript file I've coded all Quiz Codes -->
    <script src="./js/script.js"></script>
    <script src="./js/custom.js"></script>
</body>
</html>
</html>