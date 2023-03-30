<?php 
siteheader('Add Module'); 

function add_module(){

    global $theme, $moduledata, $course_data, $arr_cid_name;
    $theme['name'] = 'add_module';

    global $error, $done;
    $error = array();
    $done = array();

    $sql = executeQuery('SELECT * FROM course');
    while ($row = fetchData($sql)) {
        $course_data[] = $row;
        $arr_cid_name['cid'][$row['cid']] = $row['course_name'];
    }

    if (optREQ('special_val') == 'delete') {
        // echo json_encode('done');
        $del_id = optPOST('id');


        // Referential integrity ( If module has assignment do not allow delete )
        $sql = executeQuery('SELECT aid FROM assignment WHERE mid = "'.$del_id.'" LIMIT 1');
        if(num_rows($sql) > 0){
            echo 'You Can Not Delete This Module, It Has Assignment!';
            return false;
        }
        
        // Is assigned to teacher?
        $sql = executeQuery('SELECT * FROM assign_course WHERE mid LIKE "%|'.$del_id.'|%" LIMIT 1');
        if(num_rows($sql) > 0){
            echo 'You Can Not Delete This Assignment, It Is Assigned To Teacher!';
            return false;
        }
        
        $delete = deletData('DELETE FROM `module` WHERE mid="'.$del_id.'" LIMIT 1');
        if ($delete === TRUE) {
            
            echo 'Module Deleted Successfully...!';
            return true;

        }else{

            echo $delete;
            return false;
        }

    }

    if (optREQ('special_val') == 'edit') {
        
        $edit_id = optPOST('id');
        $sql = executeQuery('SELECT * FROM module WHERE mid="'.$edit_id.'" LIMIT 1');

        if(!$sql){
            echo $sql;
            return false;
        }

        $edit_data = fetchData($sql);

        $html_ele = array('course', 'modulename', 'is_quiz_mod', 'modcolor', 'sequence');
        $tabl_col = array('cid', 'modulename', 'is_quiz_mod', 'modcolor', 'sequence');

        ?>
        <script>
            <?php
            foreach($tabl_col AS $index => $tbl_cname)
            {
                $ele_id = $html_ele[$index];
                ?>
                $("#<?php echo $ele_id; ?>").val("<?php echo $edit_data[$tbl_cname]; ?>");
                <?php
            }
            ?>

        $("#mid, #update_module").remove();
        $('#add_module_form').append('<input type="hidden" name="mid" id="mid" value="<?php echo $edit_data['mid']; ?>" />');
        $('#add_module_form').append('<input type="hidden" name="update_module" id="update_module" value="update_module" />');

        $("#add_module").val("Update");
        $("#add_module").attr( {type:"button", name:"update_module_btn", id:"update_module_btn", onclick:"return custom_onsubmit('add_module_form','res')"} );
        </script>
        <?php
        die();

    }

    if(optPOST('update_module')){
       
        // r_print($_POST); die();
        $mid = optPOST('mid');

        $com_input = array('course', 'modulename', 'modcolor');
        $com_input_msg = array('Select Course', 'Enter Module Name', 'Select Module Color');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                echo show_error($error);
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }
        
        $post['is_quiz_mod'] = optPOST('is_quiz_mod');
        $post['sequence'] = optPOST('sequence');

        $update = executeQuery('UPDATE module SET modcolor = "'.$post['modcolor'].'", modulename = "'.$post['modulename'].'", cid = "'.$post['course'].'", is_quiz_mod = "'.$post['is_quiz_mod'].'", sequence = "'.$post['sequence'].'" WHERE mid = "'.$mid.'"');

        if($update){

            $done[] = 'Module Detail Updated Successfully...!';
            echo show_success($done);
            return true;

        }else{

            $error[] = 'Failed To Update Module Detail...!';
            echo show_error($error);
            return false;

        }

    }

    if (optPOST('add_module')) {

        $com_input = array('course', 'modulename');
        $com_input_msg = array('Select Course', 'Enter Module Name');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }

        $post['is_quiz_mod'] = optPOST('is_quiz_mod');
        $post['sequence'] = optPOST('sequence');

        $insert = insertData('INSERT INTO `module`( `cid`, `modulename`, `is_quiz_mod`, `sequence` ) VALUES ("'.$post['course'].'", "'.$post['modulename'].'", "'.$post['is_quiz_mod'].'", "'.$post['sequence'].'")');

        if($insert){

            $done[] = 'Module Added Successfully...!';
            return $done;

        }else{

            $error[] = $insert;
            return $error[] = 'Opps, Something Went Wrong...!';

        }
        
    }

    $sql = executeQuery('SELECT * FROM module ORDER BY cid, sequence');
    while ($row = fetchData($sql)) {
        $moduledata[$row['cid']][$row['mid']] = $row;
    }

    // r_print($moduledata);

}

function html_add_module(){

    global $error, $done, $l, $moduledata, $course_data, $arr_cid_name, $globals, $lables;

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
            if (empty($course_data)) {
                echo '<div class="alert alert-danger mt-5 font-weight-bold" role="alert">
                No Course Found, Please Add Course...!</div>';
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
                    <h1 class="h4 text-gray-900 mb-4">Add Module</h1>
                </div>
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=add_module" name="add_module_form" id="add_module_form">
                    <div class="form-group">
                    <?php printLable($lables['course']); ?>
                        <select class="form-control" id="course" name="course">
                            <option value="">Select Course</option>
                            <?php
                            // echo POSTval('course', '');
                            foreach ($course_data as $key => $value) {
                                ?>
                                <option value="<?php echo $value['cid']; ?>" <?php echo (POSTval('course', '') == $value['cid'] ? 'selected' : '' ); ?> >
                                    <?php echo $value['course_name']; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <?php printLable($lables['module']); ?>
                        <input type="text" class="form-control" id="modulename" name="modulename" value="<?php echo POSTval('modulename', '')?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Select Module Color:</label>
                        <input type="color" id="modcolor" name="modcolor" value="#4066D4"><br>
                    </div>

                    <div class="form-group">
                        <label>Is Quiz Module</label>
                        <select class="form-control" id="is_quiz_mod" name="is_quiz_mod">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <?php $range = range(1,10); ?>
                        <label>Module Sequence</label>
                        <select class="form-control" id="sequence" name="sequence">
                            <?php
                            foreach ($range as $key => $range_no) {
                                echo '<option value="'.$range_no.'">'.$range_no.'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <input type="submit" name="add_module" id="add_module" value="Add Module"  class="btn btn-primary btn-block" <?php echo $dis_btn; ?> />
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
                        <h6 class="m-0 font-weight-bold text-primary">Module List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <?php
                        if(!empty($moduledata)){
                            $i = 0;
                            foreach($moduledata as $kcid => $arr_module)
                            {
                                ?>
                                <h6 class="font-weight-bold mt-2 mb-3 p-2 bg-primary text-white">
                                    Course: <?php echo $arr_cid_name['cid'][$kcid]; ?>
                                </h6>
                                <table class="table table-hover" width="100%" cellspacing="0">
                                    <tbody>
                                    <?php
                                    foreach($arr_module as $kmid => $value)
                                    {
                                        // $tr_color = '';
                                        // if ($value['is_quiz_mod']) {
                                        //     $tr_color = 'bg-warning text-light';
                                        // }
                                        $tr_color = $value['modcolor'];
                                        ?>
                                        <tr>
                                            <td style="background:<?php echo $tr_color; ?>; color:#fff;">
                                            <?php echo $value['modulename']; ?></td>
                                            <td>
                                                <span class="icon-sty">
                                                    <a href="#" onclick='ajax_action("<?php echo $value["mid"]; ?>", "delete")'><i class="<?php echo $globals['del_fa_icon']; ?>"></i>
                                                    </a>
                                                </span>
                                                <span class="icon-sty">
                                                    <a href="#" onclick='ajax_action("<?php echo $value["mid"]; ?>", "edit")'><i class="<?php echo $globals['edit_fa_icon']; ?>"></i></a>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                        }
                        else
                        {
                            ?>
                                <div class="red text-center">
                                    <?php echo $l['no_data']; ?>
                                </div>
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

function API_add_module(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

?>
