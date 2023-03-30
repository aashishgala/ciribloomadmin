<?php 
siteheader('Welcome'); 

function welcome(){

    global $theme;
    $theme['name'] = 'welcome';

}

function html_welcome(){

    global $sess_data;
    // r_print($sess_data);

    ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Welcome <?php echo ucwords($sess_data['uinfo']->fname.' '.$sess_data['uinfo']->lname);?> </h1>

        <?php
        if ($sess_data['logged_in_as'] == 'teacher') {
            
            $_tid = $sess_data['uid'];
            $sql = executeQuery('SELECT c.course_name FROM course AS c JOIN assign_course AS ac ON c.cid=ac.cid WHERE ac.tid = "'.$_tid.'" AND ac.status = 1');
            $row = fetchData($sql);
            if(!empty($row)){
                echo '<h6> Course: '.$row['course_name'].'</h6>';
            }
        }
        ?>
    </div>
    <!-- /.container-fluid -->
    <?php

}
?>
