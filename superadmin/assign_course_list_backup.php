<?php 
siteheader('Assign Course To Teacher'); 

function assign_course_list(){

    global $theme, $arr_cid_name, $sess_data, $course_list, $module_list, $assign_list;

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
    $where = '';
    if(optPOST('course')){
        $where = ' cid = "'.optPOST('course').'"';
        
        $sql = executeQuery('SELECT * FROM module WHERE '.$where);
        while($row = fetchData($sql)){
            $module_list[$row['mid']] = $row['modulename'];
        }
    }

    if(optPOST('module')){
        $where = ' mid = "'.optPOST('module').'"';
        
        $sql = executeQuery('SELECT * FROM assignment WHERE '.$where);
        while($row = fetchData($sql)){
            $assign_list[$row['aid']] = $row['assignname'];
        }
    }
    // Dependent Combo

    $_tid = $sess_data['uid'];

    $sql = executeQuery('SELECT * FROM assign_course WHERE tid = "'.$_tid.'"');
    while($row = fetchData($sql))
    {
        $course_name = $arr_cid_name[$row['cid']];
        $course_list[$row['cid']] = $course_name;

        // $_exp_mod = array_filter(explode('|', $row['mid']));
        // foreach ($_exp_mod as $ind => $mid) {
        //     $module_list[$row['cid']][$mid] = $arr_co_mod_list[$row['cid']][$mid];
        // }
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

        // Check duplicate
        // $where = ' AND tid = "'.$post['teacher'].'"';
        $sql = executeQuery('SELECT tid FROM assign_course WHERE cid = "'.$post['course'].'" LIMIT 1');
        if(num_rows($sql) > 0){

            $row = fetchData($sql);
            $_tname = $teacher_data[$row['tid']];

            $error[] = 'Course Already Assigned To ( '.$_tname.' )';
            // echo show_error($error);
            return false;
        }

        $insert = insertData('INSERT INTO `assign_course`( `tid`, `cid` ) VALUES ("'.$post['teacher'].'", "'.$post['course'].'")');

        if($insert){

            $done[] = 'Course Assigned Successfully...!';
            return $done;

        }else{

            $error[] = $insert;
            return $error[] = 'Opps, Something Went Wrong...!';

        }
        
    }

    // r_print($module_list);

}

function html_assign_course_list(){

    global $error, $done, $l, $arr_cid_name, $course_list, $module_list, $assign_list;

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
                    <!-- Course Combo -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Course</label>
                            <select class="form-control chosen select" id="course" name="course" onchange="form.submit();">
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
                    <!-- Module Combo -->
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Module</label>
                            <div id="div_module">
                            <select class="form-control chosen select" id="module" name="module" onchange="form.submit();">
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
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label>Assignment</label>
                            <select class="form-control chosen select" id="assignment" name="assignment">
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
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <input type="submit" name="add_detail" id="add_detail" value="Add Detail"  class="btn btn-primary btn-block"/>
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
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center">Sr.No</th>
                                    <th>Student Name</th>
                                    <th>Module</th>
                                    <th>Assignment</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $('.select').on('change', function() {
            let d = $(this).data('id');
            // alert(d);

            let _data_id = $(this).data('id');
            let _div_id;
            let special_val;

            if(_data_id == 'course'){
                _div_id = 'div_module';
                special_val = 'course_';
            }
            else if(_data_id == 'module'){
                _div_id = 'div_assign';
                special_val = 'module_';
            }else{
                _div_id = 'res';
                special_val = 'module_';
            }

            return ajax_onsubmit('add_data_form', _div_id, special_val);
        });
    </script>
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