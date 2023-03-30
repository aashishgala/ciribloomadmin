<?php 
siteheader('Assign Course To Teacher'); 

function assign_course(){

    global $theme, $arr_cid_name, $teacher_data, $assign_course_data;
    $theme['name'] = 'assign_course';

    global $error, $done;
    $error = array();
    $done = array();

    $sql = executeQuery('SELECT * FROM course');
    while ($row = fetchData($sql)) {
        $arr_cid_name[$row['cid']] = $row['course_name'];
    }

    $sql = executeQuery('SELECT uid,uinfo FROM users WHERE utype = "teacher"');
    while ($row = fetchData($sql)) {
        $row['uinfo'] = json_decode($row['uinfo'], true);
        $teacher_data[$row['uid']] = $row['uinfo']['fname'].' '.$row['uinfo']['lname'];
    }

    if (optREQ('special_val') == 'delete') {
        // echo json_encode('done');
        $del_id = optPOST('id');
        $exp_del_id = explode('_', $del_id);
        $_tid = $exp_del_id[0];
        $_caid = $exp_del_id[1];
        $_courseid = $exp_del_id[2];

        $sql = executeQuery('SELECT * FROM student_marks WHERE tid = "'.$_tid.'" AND course = "'.$_courseid.'"');
        if(num_rows($sql) > 0){
            // virtual delete marks table
            $delete = deletData('UPDATE `student_marks` SET status = "0", date_modified = "'.get_current_datetime().'" WHERE tid = "'.$_tid.'" AND course = "'.$_courseid.'"');
        }

        // $delete = deletData('DELETE FROM `assign_course` WHERE caid="'.$del_id.'" LIMIT 1');
        $delete = deletData('UPDATE `assign_course` SET status = "0", date_modified = "'.get_current_datetime().'" WHERE caid="'.$_caid.'" LIMIT 1');
        if ($delete === TRUE) {
            
            echo 'Course Assignment Deleted Successfully...!';
            return true;

        }else{

            echo $delete;
            return false;
        }

    }
    
    $sql = executeQuery('SELECT * FROM assign_course WHERE status = 1');
    while($row = fetchData($sql))
    {
        $course_name = $arr_cid_name[$row['cid']];

        $assign_course_data[$row['tid']][$row['cid']] = array('caid'=>$row['caid'], 'co_name'=>$course_name);

    }

    // r_print($assign_course_data);

    if (optPOST('assign_course_btn')) {

        $com_input = array('teacher', 'course');
        $com_input_msg = array('Select Teacher', 'Select Course');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));

        }

        // Check Module and assignmet exists
        $pipe = '|';

        // Is this course has module and assignment ?
        $sql = executeQuery('SELECT mid FROM module WHERE cid = "'.$post['course'].'"');
        if(num_rows($sql) == 0){
            $error[] = 'No Module Found For Course, Please Add Module!';
            return $error;
        }else{
            while($row = fetchData($sql)){
                $__module[] = $row['mid'];
            }
            $pipe_module = $pipe.implode('|', $__module).$pipe;
        }

        $sql = executeQuery('SELECT aid FROM assignment WHERE cid = "'.$post['course'].'"');
        if(num_rows($sql) == 0){
            $error[] = 'No Assignment Found, Please Add Assignment!';
            return $error;
        }else{
            while($row = fetchData($sql)){
                $__assignment[] = $row['aid'];
            }
            $pipe_assignment = $pipe.implode('|', $__assignment).$pipe;
        }

        // Check Module and assignmet exists end

        // check if teacher has assigned any course ( 1 teache 1 course / 1 course multiple teacher )
        $where = ' AND tid = "'.$post['teacher'].'"';
        $sql = executeQuery('SELECT tid FROM assign_course WHERE status = 1 '.$where.' LIMIT 1');
        if(num_rows($sql) > 0){
            $_tname = $teacher_data[$post['teacher']];
            $error[] = '( '.$_tname.' ) Has Already Assigned Course! Please assign course to another teacher.';
            return $error;
        }

        // $sql = executeQuery('SELECT tid FROM assign_course WHERE cid = "'.$post['course'].'" AND status = 1 LIMIT 1');
        // if(num_rows($sql) > 0){

        //     $row = fetchData($sql);
        //     $_tname = $teacher_data[$row['tid']];

        //     $update = executeQuery('UPDATE assign_course SET mid = "'.$pipe_module.'", aid = "'.$pipe_assignment.'" WHERE tid = "'.$row['tid'].'" AND cid = "'.$post['course'].'" LIMIT 1');

        //     $error[] = 'Course Already Assigned To ( '.$_tname.' )';
        //     return $error;
            
        // }

        $datetime = get_current_datetime();

        $insert = insertData('INSERT INTO `assign_course`( `tid`, `cid`, `mid`, `aid`, `status`, `date_assigned`, `date_modified` ) VALUES ("'.$post['teacher'].'", "'.$post['course'].'", "'.$pipe_module.'", "'.$pipe_assignment.'", "1", "'.$datetime.'", "'.$datetime.'")');

        if($insert){

            $done[] = 'Course Assigned Successfully...!';
            return $done;

        }else{

            $error[] = $insert;
            return $error[] = 'Opps, Something Went Wrong...!';

        }
        
    }
}

function html_assign_course(){

    global $error, $done, $l, $arr_cid_name, $teacher_data, $assign_course_data, $globals;

    ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        <div id="res"></div>
        <?php 
            echo show_error($error);
            echo show_success($done);
            $dis_btn = '';
            if (empty($teacher_data)) {
                echo '<div class="alert alert-danger mt-5 font-weight-bold" role="alert">
                No Teacher Data Found...!</div>';
                $dis_btn = 'disabled';
            }
        ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-0"> </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Assign Course To Teacher</h1>
                </div>
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=assign_course" name="assign_course" id="assign_course">
                    <div class="form-group">
                        <select class="form-control chosen" id="teacher" name="teacher">
                            <option value="">Select Teacher</option>
                            <?php
                            foreach ($teacher_data as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php echo (POSTval('teacher', '') == $key ? 'selected' : '' ); ?> >
                                    <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control chosen" id="course" name="course">
                            <option value="">Select Course</option>
                            <?php
                            foreach ($arr_cid_name as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php echo (POSTval('course', '') == $key ? 'selected' : '' ); ?> >
                                    <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" name="assign_course_btn" id="assign_course_btn" value="Add Assignment"  class="btn btn-primary btn-block" <?php echo $dis_btn; ?> />
                </form>
            </div>
        </div>
        <div class="col-lg-3 col-sm-0"> </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assigned Course List</h6>
                </div>
                <div class="card-body">
                    <?php
                    if(!empty($assign_course_data)){
                        $i = 0;
                        // Course Loop
                        foreach ($assign_course_data as $tid => $arr_course) 
                        {
                            ?>
                            <h6 class="font-weight-bold mt-2 mb-3 p-2 bg-primary text-white">
                                Teacher: <?php echo $teacher_data[$tid]; ?>
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-hover" id="mod<?php echo $mid; ?>" width="100%" cellspacing="0">
                                <tbody>
                                    <?php
                                    foreach ($arr_course as $cid => $assign_detail)
                                    {
                                        ?>
                                        <tr>
                                            <td width="50%"><?php echo $assign_detail['co_name']; ?></td>
                                            <td>
                                                <span class="icon-sty">
                                                    <a href="#" onclick='ajax_action("<?php echo $tid."_".$assign_detail["caid"]."_".$cid; ?>", "delete")'><i class="<?php echo $globals['del_fa_icon']; ?>"></i>
                                                    </a>
                                                </span>
                                                <!-- <span class="icon-sty">
                                                    <a href="#" onclick='ajax_action("<?php //echo $aid; ?>", "edit")'><i class="<?php //echo $globals['edit_fa_icon']; ?>"></i></a>
                                                </span> -->
                                            </td>

                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                </table>
                            </div>
                            <?php
                        }
                    }
                    else
                    {
                        ?>
                        <tr>
                            <td colspan="4" align="center" class="red">
                                <?php echo $l['no_data']; ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <?php

}

function API_assign_course(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

?>
