<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");

$uname=$_SESSION['uname'];
$utype=$_SESSION['utype'];

$username = '';
if (isset($_POST['username']) && !empty($_POST['username'])) {
    $username = $_POST['username'];
}

// (!empty($username)) ? $whr_filter = " WHERE username LIKE '%".$username."%'" : $whr_filter = '';
(!empty($username)) ? $whr_filter = " AND fname LIKE '%".$username."%'" : $whr_filter = '';

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
            <!-- <a href="view_score.php?id=<?php echo base64_encode('all'); ?>" target="_blank" class="btn btn-success add-q">View All Users</a> -->
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
                    <th class='text-center'>Action</th>
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
                        <td class="text-center">
                            <!-- <a title="View Score" href="view_score.php?id=<?php echo base64_encode($uniqid); ?>" class="user-score" target="_blank"><i class="fa fa-eye"></i> </a> |  -->
                            <a title="View Certificate" href="../certificate.php?uid=<?php echo base64_encode($uniqid); ?>" class="user-score" target="_blank"><i class="fa fa-certificate"></i> </a>
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
<script type="text/javascript">
function deleteuser(user_id){
    var datastring = 'action=deleteuser&user_id='+user_id;
    var con = confirm("Are you sure you want to delete?");
    if(con==true){
        $.ajax({
            type: "POST",
            url: "functions/crud.php",
            data: datastring,
            success: function(result){
                if(result=="success"){
                    window.location.href="user.php?p=user";
                }
                else{
                    alert(result);
                }
            }
        });
    }
    return false;
}
</script>


<?php die(); ?>
<table class="table table-striped adm-tbl">
<thead>
<th>Username</th>
<th>Name</th>
<th>Gender</th>
<th class="text-center">Score</th>
<th class="text-center">Actions</th>
</thead>
<tbody>
<?php
$run = mysqlQuery("SELECT * from tbluser as tu join tblaccount as ta on tu.user_id=ta.user_id".$whr_filter);
$i = 0;
while($row=mysqliFetch($run))
{
    extract($row);
    echo "<tr>";
    echo "<td>".$username."</td>";
    echo "<td>".$fname.' '.$lname."</td>";
    echo "<td>".$gender."</td>";
    echo '<td class="text-center"><a title="View Score" href="view_score.php?id='.base64_encode($user_id).'" class="user-score" target="_blank"><i class="fa fa-eye"></i> </a></td>';
    echo '<td class="text-center"><p title="Delete" class="delete-user" onclick="deleteuser('.$user_id.')"><i class="fa fa-trash"></p></i>';
    echo "</tr>";
    ++$i;
}
if ($i == 0) {
    echo '<tr><td colspan="5" class="text-center"><b>No Users Found...!</b></td></tr>';
}
?>
</tbody>
</table>