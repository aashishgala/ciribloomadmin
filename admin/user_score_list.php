<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");

$uname=$_SESSION['uname'];
$utype=$_SESSION['utype'];

$username = '';
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = $_POST['username'];
}

(!empty($username)) ? $whr_filter = " and fname LIKE '%".$username."%'" : $whr_filter = '';

require '../header.php';
?>
<div class="container" style="margin:8% auto;width:900px;">
    <div class="panel panel-success">
        <div class="panel-heading q-panel">
            <div class="col-md-6 panel-title">
                <form name="qtype_form" id="qtype_form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" autocomplete="off">
                    <input type="text" name="username" id="username" value="<?php echo $username; ?>" placeholder="Search User By Username" class="form-control">
                </form>
            </div>
        </div> 
        <div class="panel-body">
            <table class="table table-striped adm-tbl">
                <thead>
                    <th class='text-center'>Sr. No.</th>
                    <th class='text-center'>Date</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Father Name</th>
                    <th>Mother Name</th>
                </thead>
                <tbody>
                <?php
                $sql_all = "select distinct(uniq_id) from userdata";
                $run_all = mysqlQuery($sql_all);
                while($row_all=mysqliFetch($run_all))
                {
                    $usr_uid = $row_all['uniq_id'];
                    $sql = "SELECT uc.id, ud.uniq_id, ud.fname, ud.fathername, ud.mothername, ud.lname, uc.quizz_stage, uc.round_1_mark, uc.round_2_mark, uc.date from userdata as ud join userscore as uc on ud.user_id=uc.user_id WHERE ud.quizz_stage != 5 ".$whr_filter." and ud.uniq_id = '".$usr_uid."' order by ud.uniq_id, ud.quizz_stage";
                    $run = mysqlQuery($sql);
                    $i = 0;
                    while($row=mysqliFetch($run))
                    {
                        extract($row);
                        $arr_data[$uniq_id]['date'] = substr($date, 0, 10);
                        $arr_data[$uniq_id]['fname'] = $fname;
                        $arr_data[$uniq_id]['lname'] = $lname;
                        $arr_data[$uniq_id]['fathername'] = $fathername;
                        $arr_data[$uniq_id]['mothername'] = $mothername;
                        if ($quizz_stage == 1) {
                            $r1_mark = json_decode($round_1_mark, true);
                            $arr_data[$uniq_id]['stage_one'] = $r1_mark;
                        }
                        elseif ($quizz_stage == 2) {
                            $r2_mark = json_decode($round_2_mark, true);
                            $arr_data[$uniq_id]['stage_two'] = $r2_mark;
                        }
                        elseif ($quizz_stage == -1) {
                            $arr_data[$uniq_id]['stage_one'] = 'Pending';
                        }
                        elseif ($quizz_stage == -2) {
                            $arr_data[$uniq_id]['stage_two'] = 'Pending';
                        }
                    }
                }

                foreach ($arr_data as $uniqid => $userinfo) {
                    ?>
                    <tr>
                        <td class="text-center"><?php echo ++$i; ?></td>
                        <td class="text-center"><?php echo $userinfo['date']; ?></td>
                        <td><?php echo $userinfo['fname']; ?></td>
                        <td><?php echo $userinfo['lname']; ?></td>
                        <td><?php echo $userinfo['fathername']; ?></td>
                        <td><?php echo $userinfo['mothername']; ?></td>
                    </tr>
                    <tr>
                        <td colspan="6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th colspan="2" class="text-center">Quiz One</th>
                                    <th colspan="2" class="text-center">Quiz Two</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Score</th>
                                        <th class="text-center">Mark</th>
                                        <th class="text-center">Score</th>
                                        <th class="text-center">Mark</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <?php
                                    $s1m = 0; $s2m = 0;
                                    if (isset($userinfo['stage_one'])) {
                                        if (is_array($userinfo['stage_one']) ) {
                                            ?>
                                            <td class="text-center"><?php echo $userinfo['stage_one']['total_score']; ?></td>
                                            <td class="text-center"><?php echo $s1m = $userinfo['stage_one']['mark']; ?></td>
                                            <?php
                                        }
                                        else{
                                            $s1m = 0;
                                            ?>
                                            <td class="text-center" colspan="2"><?php echo $userinfo['stage_one']; ?></td>
                                            <?php 
                                        }
                                    }else{
                                        echo "<td colspan='2' class='text-center'> Pending </td>";
                                    }
                                    
                                    if (isset($userinfo['stage_two'])) {
                                        if (is_array($userinfo['stage_two'])) {
                                            ?>
                                            <td class="text-center"><?php echo $userinfo['stage_two']['total_score']; ?></td>
                                            <td class="text-center"><?php echo $s2m = $userinfo['stage_two']['mark']; ?></td>
                                            <?php
                                        }
                                        else{
                                            $s2m = 0;
                                            ?>
                                            <td class="text-center" colspan="2"><?php echo $userinfo['stage_two']; ?></td>
                                            <?php 
                                        }
                                    }else{
                                        echo "<td colspan='2' class='text-center'> Pending </td>";
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <?php 
                                        $total = $s1m + $s2m;
                                        echo "<b>Total Marks : ".$total."</b>";
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <?php 
                }
                // echo "<pre>"; print_r($arr_data);
                if ($i == 0) {
                    echo '<tr><td colspan="5" class="text-center"><b>No Users Found...!</b></td></tr>';
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 

die();

foreach ($arr_data as $key => $userinfo) {
                    ?>
                        <table class="table table-bordered">
                            <tr>
                                <td class="text-center"><?php echo $userinfo['date']; ?></td>
                                <td><?php echo $userinfo['fname']; ?></td>
                                <td><?php echo $userinfo['lname']; ?></td>
                                <td><?php echo $userinfo['fathername']; ?></td>
                                <td><?php echo $userinfo['mothername']; ?></td>
                            </tr>
                        </table>

                        <ul class="nav nav-tabs score-tab">
                            <li class="active"><a data-toggle="tab" href="#quiz1<?php echo $key; ?>">Round One</a></li>
                            <li><a data-toggle="tab" href="#quiz2<?php echo $key; ?>">Round Two</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="quiz1<?php echo $key; ?>" class="tab-pane fade in active">
                                <?php 
                                $s1m = 0; $s2m = 0;
                                if (isset($userinfo['stage_one'])) {
                                    if (is_array($userinfo['stage_one']) ) {
                                        ?>
                                        <ul>
                                            <li>
                                                <?php echo $userinfo['stage_one']['total_score']; ?>
                                            </li>
                                            <li>
                                                <?php echo $s1m = $userinfo['stage_one']['mark']; ?>
                                            </li>
                                        </ul>
                                        <?php
                                    }
                                    else{
                                        $s1m = 0;
                                        ?>
                                        <p><?php echo $userinfo['stage_one']; ?></p>
                                        <?php 
                                    }
                                }else{
                                    echo "<p> Pending </p>";
                                }
                                ?>
                            </div>
                            <div id="quiz2<?php echo $key; ?>" class="tab-pane fade">
                                <?php
                                if(!empty($UserData[2]) && isset($UserData[2])){ }?>
                            </div>
                        </div>
                    <?php
                }