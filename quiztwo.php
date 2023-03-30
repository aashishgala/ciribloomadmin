<?php
if (!file_exists("./js/questions.js") || !file_exists("./js/questions2.js"))
{
    include "./functions/func.php";
    $roundfirst = "SELECT * from quizz_data WHERE `qt_id` IN (1,5,6)";
    createQuestionFile("./js/questions.js", $roundfirst);
    $roundsecond = "SELECT * from quizz_data WHERE `qt_id` NOT IN (1,5,6)";
    createQuestionFile("./js/questions2.js", $roundsecond);
}
if (isset($_GET['completed']) && $_GET['completed'] == 'yes') {
    ?>
    <script>
    alert('You Have Complete Second Round...!');
    window.location.href='https://www.ciribloom.co.uk';
    </script>
    <?php
}
if (isset($_POST['userdata']) && $_POST['userdata']) {
    require './functions/db.php';
    require './functions/mysql_fun.php';
    // echo "<pre>";  
    // print_r($_POST);
    // extract($_POST);

    foreach($_POST AS $key => $eleval){
        $filter_input[$key] = trim(strtolower($eleval));
        // $filter_input[$key.'_after_len'] = strlen($filter_input[$key]);
        // $filter_input[$key.'_len'] = strlen($eleval);
    }
    extract($filter_input);
    // print_r($filter_input);
    // exit;

    date_default_timezone_set('Asia/Kolkata');
    $CurrentTime=date('Y-m-d h:i:s');

    $sel = "SELECT * FROM userdata WHERE fname = '".$fname."' AND lname = '".$lname."' AND fathername = '".$fathername."' AND mothername = '".$mothername."' AND quizz_stage = 2 LIMIT 1";
    $sql_chk_dup = mysqlQuery($sel);
    if(mysqli_num_rows($sql_chk_dup) > 0) {
        $login_detail = mysqliFetch($sql_chk_dup);
        $_SESSION['user_id'] = $_user_id = $login_detail['user_id'];
        $_SESSION['uniq_id'] = $login_detail['uniq_id'];
        
        mysqlQuery("UPDATE userdata SET last_login = '".$CurrentTime."' WHERE user_id = '".$_user_id."'");
        header("location:round2.php");
    }
    else{
        $uniq_id = get_val("SELECT uniq_id FROM userdata WHERE fname = '".$fname."' AND lname = '".$lname."' AND fathername = '".$fathername."' AND mothername = '".$mothername."' AND quizz_stage = 1 LIMIT 1","uniq_id");

        // if user directly came for second round
        if (empty($uniq_id)) {
            $uniq_id = "qz".uniqid();
        }

        $ins = "INSERT INTO `userdata`(`uniq_id`,`fname`, `fathername`, `mothername`, `lname`, `country`, `date`, `quizz_stage`) VALUES ('".$uniq_id."','".$fname."','".$fathername."','".$mothername."','".$lname."','india','".$CurrentTime."','2')";
        $sql_ins = mysqlQuery($ins);
        if ($sql_ins) {
            $last_id = mysqli_insert_id($con);
            ?><script>alert('Detail saved successfully...!');</script><?php
            $_SESSION['user_id'] = $last_id;
            $_SESSION['uniq_id'] = $uniq_id;
            header("location:round2.php");
        }else{
            ?><script>alert('Unable to save detail...!');</script><?php
        }
    }
}
?>
<html>
<head>
	<title>Quizz</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--Custom CSS-->
	<link rel="stylesheet" type="text/css" href="./css/userlogin.css">
	<!--Bootstrap CSS-->
	<link rel="stylesheet" type="text/css" href="css/bootstrap4.min.css">

    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
</head>
<body>
	<div class="container" id="quiztwo">
        <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Enter Your Detail</h5>
            <p class="card-text">
                <form method="POST" class="form-signin" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="text" class="form-control form-control-sm" name="fname" id="fname" placeholder="First Name" required>
                    <input type="text" class="form-control form-control-sm" name="fathername" id="fathername" placeholder="Father's Name" required>
                    <input type="text" class="form-control form-control-sm" name="mothername" id="mothername" placeholder="Mother's Name" required>
                    <input type="text" class="form-control form-control-sm" name="lname" id="lname" placeholder="Last Name" required>
                    <!-- <select name="country" class="custom-select" required>
                        <option selected>Country</option>
                        <option value="india" selected>INDIA</option>
                    </select> -->
                    <input type="submit" name="userdata" id="userdata" class="btn btn-success adm-login" value="Login" style="width:100%;">
                </form>
                <div class="form-signin">
                <a href="main.php" class="btn btn-success adm-login">Back</a>
                </div>
            </p>
        </div>
        </div>
	</div>

    <!-- script bootstrap 4 -->
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap4.min.js"></script>
    <script type = "text/javascript" >  
        function preventBack() { window.history.forward();}  
        setTimeout("preventBack()", 0);  
        window.onunload = function () { null };  
    </script> 
	</body>
</html