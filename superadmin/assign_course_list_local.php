<?php 
siteheader('Assign Course To Teacher'); 

function assign_course_list(){

    global $theme, $arr_cid_name, $sess_data, $course_list, $module_list, $assign_list, $student_data, $table_header;

    $theme['name'] = 'assign_course_list';

    global $error, $done;
    $error = array();
    $done = array();
    $module_list = array();
    $arr_cid_name = array();

    $sql = executeQuery('SELECT * FROM course');
    while($row = fetchData($sql)){
        $arr_cid_name[$row['cid']] = $row['course_name'];
    }

    // Dependent Combo
    $where = ' status = 1';
    if(optPOST('course') && optREQ('special_val') == 'course_'){
        $where .= ' AND cid = "'.optPOST('course').'"';
    }
 
    $sql = executeQuery('SELECT * FROM module WHERE '.$where);
    while($row = fetchData($sql)){
        $module_list[$row['mid']] = $row['modulename'];
    }
    
    $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
    while($row = fetchData($sql)){
        $assign_list[$row['aid']] = $row['assignname'];
        $table_header[$row['cid']][$row['mid']][] = $row['aid'];
    }

    if(optPOST('course') && optREQ('special_val') == 'course_'){

        $post_co_id = optPOST('course');
        $get_val = get_val('SELECT is_quiz FROM course WHERE '.$where.' LIMIT 1');

        $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
        while($row = fetchData($sql)){
            $module_assign_list[$row['mid']][$row['aid']] = $row['assignname'];
        }
        // r_print($module_assign_list);
        
        foreach($module_assign_list as $kmid => $arr_assign)
        {
            $col_div = round(12/count($arr_assign));
            if($col_div == '12'){
                $col_div = '4';
            }
            ?>
            <div class="row mt-4 mb-4">
                <div class="col-lg-12 alert alert-primary"><?php echo $module_list[$kmid]; ?></div>
                <?php
                    foreach($arr_assign as $kaid => $assign)
                    {
                        ?>
                        <div class="col-lg-<?php echo $col_div; ?>">
                            <input type="hidden" name="combi[]" value="<?php echo $kmid; ?>_<?php echo $kaid; ?>">

                            <input class="form-control" type="number" id="asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>" name="asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>" placeholder="<?php echo $assign; ?>">
                        </div>
                        <?php
                    }
                ?>
                <?php
                ?>
            </div>
            <?php
        }

        
        if($get_val['is_quiz'] == '1')
        {
            ?>
            <div class="row mt-4 mb-4">
                <div class="col-lg-<?php echo $col_div; ?>">
                    <input type="hidden" name="quiz[]" value="101">
                    <input class="form-control" type="number" id="asign_101" name="asign_101" placeholder="Quiz One">
                </div>
                <div class="col-lg-<?php echo $col_div; ?>">
                    <input type="hidden" name="quiz[]" value="102">
                    <input class="form-control" type="number" id="asign_102" name="asign_102" placeholder="Quiz Two">
                </div>
            </div>
            <?php
        }
        die();
        ?>
        <select class="form-control chosen select" id="module" name="module"  onchange="return ajax_onsubmit('add_data_form', 'div_assign', 'module_');">
            <option value="">Select Module</option>
            <?php
            foreach ($module_list as $mid => $modules) {
            ?>
            <option value="<?php echo $mid; ?>" <?php echo (POSTval('module', '') == $mid ? 'selected' : '' ); ?> >
                <?php echo $modules; ?>
            </option>
            <?php
            }
            ?>
        </select>
        <?php
    }

    if(optPOST('module') && optREQ('special_val') == 'module_'){
        $where = ' mid = "'.optPOST('module').'"';
        
        $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
        while($row = fetchData($sql)){
            $assign_list[$row['aid']] = $row['assignname'];
        }
        ?>
        <select class="form-control chosen select" id="assignment" name="assignment" data-id="assignment">
            <option value="">Select Assignment</option>
            <?php
            foreach ($assign_list as $aid => $assignments) {
            ?>
            <option value="<?php echo $aid; ?>" <?php echo (POSTval('assignment', '') == $aid ? 'selected' : '' ); ?> >
                <?php echo $assignments; ?>
            </option>
            <?php
            }
            ?>
        </select>
        <?php
    }
    // Dependent Combo

    $_tid = $sess_data['uid'];

    $sql = executeQuery('SELECT * FROM assign_course WHERE tid = "'.$_tid.'"');
    while($row = fetchData($sql))
    {
        $course_name = $arr_cid_name[$row['cid']];
        $course_list[$row['cid']] = $course_name;
    }

    if (optREQ('special_val') == 'delete') {
        // echo json_encode('done');
        $del_id = optPOST('id');

        $delete = deletData('DELETE FROM `assign_course` WHERE caid="'.$del_id.'" LIMIT 1');
        if ($delete === TRUE) {
            
            echo 'Course Assignment Deleted Successfully...!';
            return true;

        }else{

            echo $delete;
            return false;
        }

    }

    if (optREQ('special_val') == 'edit') {
        
        $edit_id = optPOST('id');
        $sql = executeQuery('SELECT * FROM assignment WHERE aid="'.$edit_id.'" LIMIT 1');

        if(!$sql){
            echo $sql;
            return false;
        }

        $edit_data = fetchData($sql);

        $html_ele = array('co_mod', 'assignname');

        ?>
        <script>
        $("#co_mod").val("<?php echo $edit_data['cid'].'_'.$edit_data['mid']; ?>");
        $("#assignname").val("<?php echo $edit_data['assignname']; ?>");
             

        $("#aid, #update_assign").remove();
        $('#assign_course').append('<input type="hidden" name="aid" id="aid" value="<?php echo $edit_data['aid']; ?>" />');
        $('#assign_course').append('<input type="hidden" name="update_assign" id="update_assign" value="update_assign" />');

        $("#assign_course_btn").val("Update");
        $("#assign_course_btn").attr( {type:"button", name:"update_assign_btn", id:"update_assign_btn", onclick:"return ajax_onsubmit('assign_course','res')"} );
        </script>
        <?php
        die();

    }

    if(optPOST('update_assign')){
       
        // r_print($_POST);
        $aid = optPOST('aid');

        $com_input = array('co_mod', 'assignname');
        $com_input_msg = array('Select Course-Module', 'Enter Assignment Name');

        foreach ($com_input as $index => $input_ele) {
            
            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                echo show_error($error);
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }

        $co_mod = array_filter(explode('_', $post['co_mod']));
        $post['cid'] = $co_mod[0];
        $post['mid'] = $co_mod[1];

        $update = executeQuery('UPDATE assignment SET assignname = "'.$post['assignname'].'", cid = "'.$post['cid'].'", mid = "'.$post['mid'].'" WHERE aid = "'.$aid.'"');

        if($update){

            $done[] = 'Assignment Detail Updated Successfully...!';
            echo show_success($done);
            return true;

        }else{

            $error[] = 'Failed To Update Assignment Detail...!';
            echo show_error($error);
            return false;

        }

    }

    if (optPOST('add_detail')) {

        // r_print($_POST);

        $com_input = array('first_name', 'last_name', 'middle_name', 'course');
        $com_input_msg = array('Enter First Name', 'Please Enter Last Name', 'Please Enter Middle Name', 'Select Course');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                echo show_error($error);
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));

        }

        $_combi = optPOST_r('combi');

        if (optPOST_r('quiz')) {
            $_quiz = optPOST_r('quiz');
        }

        foreach ($_quiz as $key => $value) {

            $combination = 'asign_'.$value;
            if (empty(optPOST($combination))) {
                $error['empty_'.$combination] = 'Please Enter Marks...!';
                echo show_error($error);
                ?><script>$('#<?php echo $combination; ?>').focus();</script><?php
                return false;
            }

            $arr_marks['quiz'][$value] = optPOST($combination);

        }

        foreach ($_combi as $key => $value) {

            $combination = 'asign_'.$value;
            if (empty(optPOST($combination))) {
                $error['empty_'.$combination] = 'Please Enter Marks...!';
                echo show_error($error);
                ?><script>$('#<?php echo $combination; ?>').focus();</script><?php
                return false;
            }

            $exp_combi = explode('_',$value);

            $arr_marks['marks'][$exp_combi[0]][$exp_combi[1]] = optPOST($combination);

        }


        $arr_marks['total'] = array_multisum($arr_marks);

        $_json_marks = json_encode($arr_marks);

        $datetime = get_current_datetime();
        
        $insert = insertData('INSERT INTO `student_marks`(`tid`, `first_name`, `last_name`, `middle_name`, `course`, `marks_json`, `date`, `date_modified`, `status`) VALUES ("'.$_tid.'", "'.$post['first_name'].'", "'.$post['last_name'].'", "'.$post['middle_name'].'", "'.$post['course'].'", \''.$_json_marks.'\', "'.$datetime.'", "'.$datetime.'", "1")');

        if($insert){

            $done[] = 'Details Added Successfully...!';
            echo show_success($done);
            return true;

        }else{

            $error[] = $insert;
            echo show_error($error);
            return false;

        }
        
    }

    $student_data = array();
    $sql = executeQuery('SELECT * FROM student_marks WHERE  tid = "'.$_tid.'" ORDER BY course');
    while($row = fetchData($sql)){

        $decode_data = json_decode($row['marks_json'], true);

        $student_data[$row['course']][$row['markid']] = $row;
        $student_data[$row['course']][$row['markid']]['marks_json'] = $decode_data;
    }

    // r_print($student_data);

}

function html_assign_course_list(){

    global $error, $done, $l, $arr_cid_name, $course_list, $module_list, $assign_list, $student_data, $table_header;

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
            if (empty($course_list)) {
                echo '<div class="alert alert-danger font-weight-bold" role="alert">
                Course Not Assigned...!</div>';
                $dis_btn = 'disabled';
            }
        ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Detail</h6>
        </div>
        <div class="card-body">
            <div class="card-body">
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=assign_course_list" name="add_data_form" id="add_data_form">

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php echo POSTval('first_name', '')?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo POSTval('last_name', '')?>">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php echo POSTval('middle_name', '')?>">
                        </div>
                    </div>
                </div>
                <!-- Module and assignment -->
                <div class="row">
                
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Course</label>
                            <!-- <select class="form-control chosen select" id="course" name="course" onchange="return ajax_onsubmit('add_data_form', 'div_module', 'course_');"> -->
                            <select class="form-control chosen select" id="course" name="course" onchange="return ajax_onsubmit('add_data_form', 'div_module_assignment', 'course_');">
                                <option value="">Select Course</option>
                                <?php
                                foreach ($course_list as $cid => $cname) {
                                    ?>
                                    <option value="<?php echo $cid; ?>" <?php echo (POSTval('course', '') == $cid ? 'selected' : '' ); ?> >
                                        <?php echo $cname; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Module</label>
                            <div id="div_module">
                                <select class="form-control chosen select" id="module" name="module">
                                    <option value="">Select Module</option>
                                </select>
                            </div>
                        </div>
                    </div> -->

                    <!-- <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Assignment</label>
                            <div id="div_assign">
                                <select class="form-control chosen select" id="assignment" name="assignment">
                                    <option value="">Select Assignment</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div id="div_module_assignment">

                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <input type="hidden" name="add_detail" id="add_detail" value="Add Detail" >
                    <input type="submit" name="add_detail" id="add_detail" value="Add Detail" class="btn btn-primary btn-block" onclick="return custom_onsubmit('add_data_form','res')"/>
                </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Student List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <?php
                        $i = 1;
                        foreach ($student_data as $kcid => $arr_marks) 
                        {
                            ?>
                            <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr.No</th>
                                        <th>Date</th>
                                        <th>Student Name</th>
                                        <?php
                                        foreach($table_header AS $key_coid => $module_arr){
                                            foreach ($module_arr as $key_mid => $asign_arr) {
                                                $colspan = count($asign_arr);
                                                echo '<th colspan="'.$colspan.'" class="text-center">'.$module_list[$key_mid].'</th>';
                                            }
                                        }
                                        ?>
                                        <th>Total Marks</th>
                                    </tr>
                                    <tr>
                                        <!-- <th colspan="3"></th> -->
                                        <?php
                                        foreach($table_header AS $key_coid => $module_arr){
                                            echo '
                                            <th colspan="3">'.$course_list[$key_coid].'</th>';
                                            foreach ($module_arr as $key_mid => $asign_arr) {
                                                foreach ($asign_arr as $key => $asign_id) {
                                                    echo '<th>'.$assign_list[$asign_id].'</th>';
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arr_marks as $kmid => $mdata) 
                                    {
                                        $stu_name = ucwords($mdata['first_name']).' '.ucwords($mdata['first_name']).' '.ucwords($mdata['first_name']);

                                        $date = substr($mdata['date'], 0, 10);

                                        $marks = $mdata['marks_json']['marks'];
                                        $total = $mdata['marks_json']['total'];
                                            // r_print($marks);
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td><?php echo $date; ?></td>
                                            <td><?php echo $stu_name; ?></td>

                                            <?php
                                                foreach($marks as $kmid => $arr_assign)
                                                {
                                                    foreach($arr_assign as $kaid => $assign)
                                                    {
                                                        ?>
                                                        <td class="text-center">
                                                            <?php
                                                            echo $assign; 
                                                            ?>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                            ?>

                                            <td class="text-center align-middle">
                                                <?php echo $total; ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <?php

}

function API_assign_course_list(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

?>

<script>
    $(".chosen").chosen();
</script>

<?php 
function extra__(){
    ?>
<tr>
<td colspan="2">
    <?php
    foreach($marks as $kmid => $arr_assign)
    {
        $col_div = 12;

        ?>
        <div class="row">
            <div class="col-lg-12">
            <p class="text-light bg-dark p-1">
                Module : <?php echo $module_list[$kmid]; ?>
            </p>
            </div>
            
            <div class="col-lg-<?php echo $col_div; ?>">
            <?php
                foreach($arr_assign as $kaid => $assign)
                {
                ?>
                <p>
                    <?php
                    echo $assign_list[$kaid].' - '.$assign; 
                    ?>
                </p>
                <?php
                }
            ?>
            </div>
        </div>
        <?php
    }
    ?>
</td>
<td class="text-center align-middle">
    Total Marks : <?php echo $total; ?>
</td>
</tr>
<?php } ?>