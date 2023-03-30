<?php 
siteheader('Assign Course To Teacher');

// Loads module and assignment to enter marks
function load_modules(){

    global $sess_data, $mark_data;

    $module_list = array();
    $arr_cid_name = array();
    $quiz_module = array();
    $quiz_mod_asign = array();

    $isSubmitMode = 0;
    $isEditMode = 0;

    if(isset($_GET['mode']) == 'edit_mark' && isset($mark_data['is_submit']) && $mark_data['is_submit'] != 1){
        $isEditMode = 1;
    }elseif(isset($mark_data['is_submit']) && $mark_data['is_submit'] == 1 && $sess_data['logged_in_as'] != 'admin'){
        $isSubmitMode = 1;
    }

    if($sess_data['logged_in_as'] == 'admin'){
        $_tid = base64_decode($_GET['tid']);
    }else{
        $_tid = $sess_data['uid'];
    }

    $condi = ' AND tid = "'.$_tid.'"';

    $query = 'SELECT * FROM assign_course WHERE status = 1 '.$condi;
    $sql = executeQuery($query);
    while($row = fetchData($sql))
    {
        $_course_id = $row['cid'];
        // $arr_course_id[$row['cid']] = $row['cid'];
    }

    if(empty($_course_id)){
        return false;
    }
    
    $where = ' status = 1';
    $where .= ' AND cid = "'.$_course_id.'"';
    // $where .= ' AND cid IN (\''.implode("', '", $arr_course_id).'\')';

    $sql = executeQuery('SELECT * FROM module WHERE '.$where);
    while($row = fetchData($sql)){
        $module_list[$row['mid']] = $row['modulename'];
        $module_color[$row['mid']] = $row['modcolor'];
        if ($row['is_quiz_mod']) {
            $quiz_module[$row['mid']] = $row['mid'];
        }
    }

    $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
    while($row = fetchData($sql)){
        $module_assign_list[$row['mid']][$row['aid']] = $row['assignname'];
        if (in_array($row['mid'], $quiz_module)) {
            $quiz_mod_asign[$row['mid']][$row['aid']] = $row['aid'];
            $is_quiz_assign[$row['aid']] = $row['aid'];
        }
    }

    $get_val = get_val('SELECT is_quiz FROM course WHERE '.$where.' LIMIT 1');

    // edit-update marks condition when edit do not get all student value
    if(!isset($_GET['mode'])){

        if ($get_val['is_quiz'] == 1)
        {
            
            // quizz data query
            $_stage1 = get_val('SELECT mid FROM module WHERE stage = 1 LIMIT 1');
            $_stage2 = get_val('SELECT mid FROM module WHERE stage = 2 LIMIT 1');

            $sql = "SELECT ud.uniq_id, ud.fname, ud.fathername, ud.mothername, ud.lname, uc.quizz_stage, uc.round_1_mark, uc.round_2_mark from userdata as ud join userscore as uc on ud.user_id=uc.user_id WHERE ud.quizz_stage != 5";
            $run = executeQuery($sql);
            $i = 0;
            while($row=fetchData($run))
            {
                extract($row);

                $search_val = $fname.' '.$fathername.' '.$mothername.' '.$lname;
                
                $arr_quiz_data[$uniq_id]['option'] = $search_val;
                $arr_quiz_data[$uniq_id]['fname'] = $fname;
                $arr_quiz_data[$uniq_id]['lname'] = $lname;
                $arr_quiz_data[$uniq_id]['fathername'] = $fathername;

                if ($quizz_stage == 1) {
                    $r1_mark = json_decode($round_1_mark, true);
                    $stage_module1 = $_stage1['mid'];
                }
                elseif ($quizz_stage == 2) {
                    $r2_mark = json_decode($round_2_mark, true);
                    $stage_module2 = $_stage2['mid'];
                }

                if (empty($r1_mark)) {
                    $r1_mark = array('mark'=>0);
                    $stage_module1 = 0;
                }
                if (empty($r2_mark)) {
                    $r2_mark = array('mark'=>0);
                    $stage_module2 = 0;
                }
                
                $arr_quiz_data[$uniq_id]['module'] = $stage_module1.'_'.$stage_module2;
                $arr_quiz_data[$uniq_id]['value'] = $r1_mark['mark'].'_'.$r2_mark['mark'];
            }
            // r_print($arr_quiz_data);
            // quizz data query end
            ?>
            <!-- Search Student Div -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <select class="form-control chosen" name="set_quiz_info" onchange="return ajax_onsubmit('add_data_form', 'res', 'set_stu_data');">
                        <option value="">Search Student</option>
                        <?php
                        foreach ($arr_quiz_data as $stu_uniq_id => $value) {
                            ?>
                            <option value="<?php echo $value['value'].'|'.$value['fname'].'|'.$value['lname'].'|'.$value['fathername'].'|'.$value['module']; ?>">
                                <?php echo $value['option']; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <?php
        }
    }

    ?>
    <!-- Personal Info -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <input type="hidden" name="mark_id" value="<?php echo (isset($mark_data['markid']) ? $mark_data['markid'] : ''); ?>">
                <input type="hidden" name="mode" value="<?php echo (isset($_GET['mode']) ? 'update' : 'add'); ?>">
                <label>First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" value="<?php echo POSTval('first_name', (isset($mark_data['first_name']) ? $mark_data['first_name'] : '') )?>">
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <label>Middle Name</label>
                <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter Middle Name" value="<?php echo POSTval('middle_name', (isset($mark_data['middle_name']) ? $mark_data['middle_name'] : '') )?>">

                <input type="hidden" id="course" name="course" value="<?php echo $_course_id; ?>">
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" value="<?php echo POSTval('last_name', (isset($mark_data['last_name']) ? $mark_data['last_name'] : '') )?>">
            </div>
        </div>
    </div>
    <?php
    foreach($module_assign_list as $kmid => $arr_assign)
    {

        $col_div = round(12/count($arr_assign));
        if($col_div == '12'){
            $col_div = '4';
        }
        ?>
        <div class="row mt-4 mb-4">
            <div class="col-lg-12 alert text-light" style="background:<?php echo $module_color[$kmid]; ?>"><?php echo $module_list[$kmid]; ?></div>
            <?php
                foreach($arr_assign as $kaid => $assign)
                {
                    $_value = 'asign_'.$kmid.'_'.$kaid;

                    // set marks edit mode
                    $assign_mark = (isset($mark_data['marks'][$kmid][$kaid])) ? $mark_data['marks'][$kmid][$kaid] : '';

                    ?>
                    <div class="col-lg-<?php echo $col_div; ?>">
                        <input type="hidden" name="combi[]" value="<?php echo $_value; ?>">
                        <?php if($isSubmitMode == 1 OR $isEditMode == 1){ ?>
                            <label><?php echo $assign; ?></label>
                        <?php } ?>
                        <input class="form-control asign_<?php echo $kmid; ?>" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="<?php echo $_value; ?>" name="asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>" placeholder="<?php echo $assign; ?>" value="<?php echo $assign_mark; ?>">
                    </div>
                    <?php if($isSubmitMode == 1){ ?>
                        <script>$('#<?php echo $_value; ?>').prop('disabled', true);</script>
                    <?php } 
                }
                
                // If quiz module then fetch data from quiz table
                if (in_array('1'.$kmid, $quiz_module)) {
                    ?>
                    <div class="col-lg-6">
                        <select class="form-control chosen" onchange="get_marks(this.value, 'asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>');">
                            <option value="">Search Student</option>
                            <?php
                            foreach ($arr_quiz_data as $stu_uniq_id => $value) {
                                ?>
                                <option value="<?php echo $value['value'].'|'.$value['fname'].'|'.$value['lname'].'|'.$value['fathername']; ?>">
                                    <?php echo $value['option']; ?>
                                </option>
                                <?php
                            }
                            
                            ?>
                        </select>
                    </div>
                    <?php
                }

            ?>
        </div>
        <?php
    } // foreach

    // If quizz show portfolio option
    if($get_val['is_quiz'] == '1')
    {
        $arr_port_ass = array('1','2','3','4','5','6','7','8','9','10');
        ?>
        <div class="row mt-4 mb-4">
        <div class="col-lg-12 alert alert-primary">Portfolio</div>
            <?php
            foreach ($arr_port_ass as $index => $value) {
                // set marks edit mode
                $portfolio_mark = (isset($mark_data['portfolio'][$value])) ? $mark_data['portfolio'][$value] : '';
                ?>
                <div class="col-lg-<?php echo $col_div; ?> mt-2">
                    <input type="hidden" name="portfolio[]" value="<?php echo $value; ?>">
                    <?php if($isSubmitMode == 1 OR $isEditMode == 1){ ?>
                        <label>Assignment <?php echo $value; ?></label>
                    <?php } ?>
                    <input class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="port_<?php echo $value; ?>" name="port_<?php echo $value; ?>" placeholder="Assignment <?php echo $value; ?>" value="<?php echo $portfolio_mark; ?>">
                </div>

                <?php if($isSubmitMode == 1){ ?>
                    <script>$('#port_<?php echo $value; ?>').prop('disabled', true);</script>
                <?php } ?>

                <?php
            }
            ?>
        </div>
        <script>
            $('#first_name').prop('readonly', true);
            $('#last_name').prop('readonly', true);
            $('#middle_name').prop('readonly', true);
        </script>
        <?php
    }

    if(isset($mark_data['is_submit']) && $mark_data['is_submit'] == 1 && $sess_data['logged_in_as'] != 'admin'){
        ?>
        <!-- <script>alert();</script> -->
        <?php
    }
}

function assign_course_list(){

    global $theme, $arr_cid_name, $sess_data, $course_list, $module_list, $assign_list, $mark_data, $table_header, $_course_id;

    $theme['name'] = 'assign_course_list';

    global $error, $done;

    if(optPOST('submit_detail')){
        $sql = executeQuery("UPDATE `student_marks` SET `is_submit` = 1 WHERE markid = '".$_POST['mark_id']."' LIMIT 1");
        ?>
        <script>
            alert('Marks Submited Successfully...!');
            window.location.href='index.php?act=student_marks';
        </script>
        <?php
        die();
    }
    // r_print($_REQUEST); die();
    if($sess_data['logged_in_as'] == 'admin'){
        $condi = '';
        $_tid = base64_decode($_REQUEST['tid']);
    }else{
        $_tid = $sess_data['uid'];
        $condi = ' AND tid = "'.$_tid.'"';
    }
    
    $qry = 'SELECT * FROM assign_course WHERE status = 1 AND tid = "'.$_tid.'"';
    $sql = executeQuery($qry);
    while($row = fetchData($sql))
    {
        $_course_id = $row['cid'];
    }

    if (optPOST('set_quiz_info') && optREQ('special_val') == 'set_stu_data') {
        
        ?>
        <script>
            var marks = "<?php echo optPOST('set_quiz_info'); ?>";
            
            var stu_data = marks.split('|');
            var quiz_mark = stu_data[0];

            var split_quiz_mark = quiz_mark.split('_');

            var __fname = stu_data[1];
            var __lname = stu_data[2];
            var __father = stu_data[3];
            var quiz_stage = stu_data[4];

            var split_quiz_stage = quiz_stage.split('_');
            $('.asign_'+split_quiz_stage[0]).val(split_quiz_mark[0]);
            $('.asign_'+split_quiz_stage[1]).val(split_quiz_mark[1]);

            $('.asign_'+split_quiz_stage[0]).prop('readonly', true);
            $('.asign_'+split_quiz_stage[1]).prop('readonly', true);

            $('#first_name').val(__fname);
            $('#last_name').val(__lname);
            $('#middle_name').val(__father);
        </script>
        <?php

        return false;
    }

    $error = array();
    $done = array();
    // $module_list = array();
    $arr_cid_name = array();
    // $quiz_module = array();

    $sql = executeQuery('SELECT * FROM course');
    while($row = fetchData($sql)){
        $arr_cid_name[$row['cid']] = $row['course_name'];
    }

    $sql = executeQuery('SELECT * FROM assign_course WHERE status = 1 '.$condi);
    while($row = fetchData($sql))
    {
        $course_name = $arr_cid_name[$row['cid']];
        $course_list[$row['cid']] = $course_name;
    }

    if (optPOST('add_detail')) {

        // r_print($_POST);
        $post['course'] = optPOST('course');

        $com_input = array('first_name', 'last_name', 'middle_name');
        $com_input_msg = array('Enter First Name', 'Please Enter Last Name', 'Please Enter Middle Name', 'Select Course');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                echo show_error($error);
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));

        }

        if (optPOST_r('quiz')) {
            $_quiz = optPOST_r('quiz');
            
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

        }

        // asign_moduleid_assignid
        $_combi = optPOST_r('combi');
        foreach ($_combi as $key => $value) {

            $combination = $value;
            if (optPOST($combination) < 0) {
                $error['empty_'.$combination] = 'Please Enter Marks...!';
                echo show_error($error);
                ?><script>$('#<?php echo $combination; ?>').focus();</script><?php
                return false;
            }

            $exp_combi = explode('_',$value);

            $arr_marks['marks'][$exp_combi[1]][$exp_combi[2]] = optPOST($combination);

        }
        
        if (optPOST_r('portfolio')) {
            $_portfolio = optPOST_r('portfolio');
            
            foreach ($_portfolio as $key => $value) {

                $combination = 'port_'.$value;
                if (empty(optPOST($combination))) {
                    $error['port_'.$combination] = 'Please Portfolio Assignment Marks...!';
                    echo show_error($error);
                    ?><script>$('#<?php echo $combination; ?>').focus();</script><?php
                    return false;
                }

                $arr_marks['portfolio'][$value] = optPOST($combination);

            }

        }

        $arr_marks['total'] = array_multisum($arr_marks);

        $_json_marks = json_encode($arr_marks);

        $datetime = get_current_datetime();

        // update
        if($_POST['mode'] == 'update'){

            $where = ' status = 1';
            $where .= ' AND cid = "'.$_course_id.'"';
            $get_val = get_val('SELECT is_quiz FROM course WHERE '.$where.' LIMIT 1');
            $update_col = '';
            if ($get_val['is_quiz'] != 1){
                $update_col = ", first_name='".$_POST['first_name']."', last_name='".$_POST['last_name']."', middle_name='".$_POST['middle_name']."'";
            }

            $sql = executeQuery("UPDATE `student_marks` SET `marks_json` = '".$_json_marks."' $update_col WHERE markid = '".$_POST['mark_id']."' LIMIT 1");
            $message = 'Marks Updated Successfully...!';

        }else{

            $sql = insertData('INSERT INTO `student_marks`(`tid`, `first_name`, `last_name`, `middle_name`, `course`, `marks_json`, `date`, `date_modified`, `status`) VALUES ("'.$_tid.'", "'.$post['first_name'].'", "'.$post['last_name'].'", "'.$post['middle_name'].'", "'.$post['course'].'", \''.$_json_marks.'\', "'.$datetime.'", "'.$datetime.'", "1")');
            $message = 'Marks Added Successfully...!';

        }
        
        // r_print($_json_marks,1);
    
        if($sql){

            $done[] = $message;
            echo show_success($done);
            return true;

        }else{

            $error[] = $insert;
            echo show_error($error);
            return false;

        }
        
    }

    // $student_data = array();
    // $sql = executeQuery('SELECT * FROM student_marks WHERE  tid = "'.$_tid.'" ORDER BY course');
    // while($row = fetchData($sql)){

    //     $decode_data = json_decode($row['marks_json'], true);

    //     $student_data[$row['course']][$row['markid']] = $row;
    //     $student_data[$row['course']][$row['markid']]['marks_json'] = $decode_data;
    // }

    
    // edit-update marks part start
    $mark_data = array();
    if(isset($_GET['mid']) && $_GET['mid'] != ''){
        $edit_id = base64_decode($_GET['mid']);

        $sql = executeQuery('SELECT * FROM student_marks WHERE markid = "'.$edit_id.'" LIMIT 1');
        $row = fetchData($sql);

        $decode_data = json_decode($row['marks_json'], true);
        // $row['marks_json'] = $decode_data;
        $row = array_merge($row,$decode_data);
        $mark_data = $row;

        // r_print($mark_data);

    }

}

function html_assign_course_list(){

    global $error, $done, $l, $arr_cid_name, $course_list, $module_list, $assign_list, $student_data, $table_header, $_course_id, $mark_data, $sess_data;
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
                return false;
            }
            $form_heading = (!isset($_GET['mode']) ? 'Add Marks' : 'Update Marks');
        ?>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $form_heading; ?></h6>
        </div>
        <div class="card-body">
            <div class="card-body">
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=assign_course_list" name="add_data_form" id="add_data_form">

                <!-- Module and assignment -->
                <div class="row">
                    <div class="col-md-12">
                        <div id="div_module_assignment">
                            <?php load_modules(); ?>
                        </div>
                    </div>
                </div>
                <?php if(isset($mark_data['is_submit']) && $mark_data['is_submit'] == 1 && $sess_data['logged_in_as'] != 'admin'){
                    echo 'Marks Submited';
                }else{
                    ?>
                        <div class="row mt-3">
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <?php
                            $form_display = (!isset($_GET['mode']) ? 'Add Marks' : 'Update Marks');
                            $tid = (isset($_GET['tid']) ? $_GET['tid'] :base64_encode($sess_data['uid']));
                            ?>
                            <input type="hidden" name="tid" id="tid" value="<?php echo $tid; ?>" >
                            <input type="hidden" name="add_detail" id="add_detail" value="<?php echo $form_display; ?>" >
                            <input type="submit" name="add_detail" id="add_detail" value="<?php echo $form_display; ?>" class="btn btn-primary btn-block" onclick="return custom_onsubmit('add_data_form','res')" <?php echo $dis_btn; ?> />

                        </div>
                        <?php 
                        if(isset($_GET['mode']) && $_GET['mode'] == 'edit_mark' && $sess_data['logged_in_as'] != 'admin'){
                            ?>
                            <div class="col-lg-3 col-md-3 col-sm-3">
                                <input type="submit" name="submit_detail" id="submit_detail" value="Submit" class="btn btn-info btn-block" onclick="submit()" />
                            </div>
                            <?php
                        }
                        ?>
                        </div>
                    <?php
                }
                ?>
                </form>
            </div>
        </div>
    </div>
    <?php
    // extra code
    $show = 0;
    if ($show) { ?>
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
                                        <th width="5%" class="text-center">Sr.No</th>
                                        <th width="15%">Date</th>
                                        <th width="30%">Student Name</th>
                                        <?php
                                        $j = 1;
                                        foreach($table_header[$kcid] AS $key_mid => $module_arr){
                                            $colspan = count($module_arr);
                                            echo '<th width="10%" colspan="'.$colspan.'" class="text-center colorheader'.$j.'">'.$module_list[$key_mid].'</th>';
											$j++;
                                        }
                                        ?>
                                        <th width="10%" class="text-center ">Total Marks</th>
                                    </tr>
                                    <tr>
                                        <?php
                                        echo '<th colspan="3" class="text-center">'.$course_list[$kcid].'</th>';
                                        foreach($table_header[$kcid] AS $key_mid => $module_arr){
                                            foreach ($module_arr as $key_aid => $asign_arr) {
                                                echo '<th class="text-center" >'.$assign_list[$asign_arr].'</th>';
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($arr_marks as $kmid => $mdata) 
                                    {
                                        $stu_name = ucwords($mdata['first_name']).' '.ucwords($mdata['middle_name']).' '.ucwords($mdata['last_name']);

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
    <?php } ?>
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

    // Dependent Combo
    // $where = ' status = 1';
    // if(optPOST('course') && optREQ('special_val') == 'course_'){
    //     $where .= ' AND cid = "'.optPOST('course').'"';
    // }
 
    // $sql = executeQuery('SELECT * FROM module WHERE '.$where);
    // while($row = fetchData($sql)){
    //     $module_list[$row['mid']] = $row['modulename'];
    //     if ($row['is_quiz_mod']) {
    //         $quiz_module[$row['mid']] = $row['mid'];
    //     }
    // }
    
    // $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
    // while($row = fetchData($sql)){
    //     $assign_list[$row['aid']] = $row['assignname'];
    //     $table_header[$row['cid']][$row['mid']][] = $row['aid'];
    // }

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

                            <input class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>" name="asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>" placeholder="<?php echo $assign; ?>">
                        </div>
                        <?php
                    }
                    
                    // If quiz module then fetch data from quiz table
                    if (in_array($kmid, $quiz_module)) {
                        ?>
                        <div class="col-lg-6">
                            <select class="form-control chosen" onchange="get_marks(this.value, 'asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>');">
                                <option value="">Search Student</option>
                                <?php
                                foreach ($arr_quiz_data as $stu_uniq_id => $value) {
                                    ?>
                                    <option value="<?php echo $value['value'].'|'.$value['fname'].'|'.$value['lname'].'|'.$value['fathername']; ?>">
                                        <?php echo $value['option']; ?>
                                    </option>
                                    <?php
                                }
                                
                                ?>
                            </select>
                        </div>
                        <?php
                    }

                ?>
            </div>
            <?php
        } // foreach

        // If quizz show portfolio option
        if($get_val['is_quiz'] == '1')
        {
            $arr_port_ass = array('1','2','3','4','5','6','7','8','9','10');
            ?>
            <div class="row mt-4 mb-4">
            <div class="col-lg-12 alert alert-primary">Portfolio</div>
                <?php
                foreach ($arr_port_ass as $index => $value) {
                    ?>
                    <div class="col-lg-<?php echo $col_div; ?> mt-2">
                        <input type="hidden" name="portfolio[]" value="<?php echo $value; ?>">
                        <input class="form-control" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="port_<?php echo $value; ?>" name="port_<?php echo $value; ?>" placeholder="Assignment <?php echo $value; ?>">
                    </div>
                    <?php
                }
                ?>
            </div>
            <script>
                $('#first_name').prop('readonly', true);
                $('#last_name').prop('readonly', true);
                $('#middle_name').prop('readonly', true);
            </script>
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

            <div class="row">
                
                <div class="col-lg-4 col-md-6 d-none">
                    <div class="form-group">
                        <label>Course</label>
                        <!-- <select class="form-control chosen select" id="course" name="course" onchange="return ajax_onsubmit('add_data_form', 'div_module', 'course_');"> -->
                        <select class="form-control chosen select" id="course1" name="course1" onchange="return ajax_onsubmit('add_data_form', 'div_module_assignment', 'course_');">
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
            </div>

    
    <select class="form-control chosen" onchange="get_marks(this.value, 'asign_<?php echo $kmid; ?>_<?php echo $kaid; ?>');">
                <option value="">Search Student</option>
                <?php
                foreach ($arr_quiz_data as $stu_uniq_id => $value) {
                    ?>
                    <option value="<?php echo $value['value'].'|'.$value['fname'].'|'.$value['lname'].'|'.$value['fathername']; ?>">
                        <?php echo $value['option']; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
    <?php 
} ?>

<script>

    function get_marks(marks, ele_id){

        var stu_data = marks.split('|');
        let __marks = stu_data[0];
        let __fname = stu_data[1];
        let __lname = stu_data[2];
        let __father = stu_data[3];

        $('#'+ele_id).val(__marks);
        $('#'+ele_id).prop('readonly', true);
        $('#first_name').val(__fname);
        $('#last_name').val(__lname);
        $('#middle_name').val(__father);

    }
</script>