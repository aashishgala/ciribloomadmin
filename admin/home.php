<?php
include "../functions/func.php";
check_session($_SESSION['uname'], "index.php", "Authantication Failed");

$uname=$_SESSION['uname'];
$utype=$_SESSION['utype'];

require '../header.php'; 
?>
<div class="container" style="margin:8% auto;width:900px;">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title">Question Category</h3>
        </div> 
        <div class="panel-body">
            <table class="table table-hover adm-tbl">
                <thead>
                <th class="text-center">Sr.No</th>
                <th>Question Type</th>
                </thead>
                <tbody>
                    <?php
                    $sql_q_type = mysqlQuery("SELECT * FROM question_type ORDER BY `qt_id` ASC");
                    $i = 1;
                    while($row=mysqliFetch($sql_q_type))
                    {
                        echo "<tr>";
                        echo "<td class=\"text-center\" width=\"20%\">".$i++."</td>";
                        echo "<td>".$row['que_typ_name']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>