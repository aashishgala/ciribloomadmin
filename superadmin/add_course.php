<?php 
siteheader('Add Course'); 

function add_course(){

    global $theme, $course_data;
    $theme['name'] = 'add_course';

    global $error, $done;
    $error = array();
    $done = array();

    if (optREQ('special_val') == 'delete') {
        // echo json_encode('done');
        $del_id = optPOST('id');

        // Referential integrity check

        // Is assigned to teacher?
        $sql = executeQuery('SELECT * FROM assign_course WHERE cid = "'.$del_id.'" LIMIT 1');
        if(num_rows($sql) > 0){
            echo 'You Can Not Delete This Course, It Is Assigned To Teacher!';
            return false;
        }

        // Is this course has module and assignment ?
        $sql = executeQuery('SELECT * FROM module WHERE cid = "'.$del_id.'" LIMIT 1');
        if(num_rows($sql) > 0){
            echo 'You Can Not Delete This Course, Module Existes!';
            return false;
        }

        $sql = executeQuery('SELECT * FROM assignment WHERE cid = "'.$del_id.'" LIMIT 1');
        if(num_rows($sql) > 0){
            echo 'You Can Not Delete This Course, Assignment Existes!';
            return false;
        }

        // Referential integrity end
        
        $delete = deletData('DELETE FROM `course` WHERE cid="'.$del_id.'" LIMIT 1');
        if ($delete === TRUE) {
            
            echo 'Course Deleted Successfully...!';
            return true;

        }else{

            echo $delete;
            return false;
        }

    }

    if (optREQ('special_val') == 'edit') {
        
        $edit_id = optPOST('id');
        $sql = executeQuery('SELECT * FROM course WHERE cid="'.$edit_id.'" LIMIT 1');

        if(!$sql){
            echo $sql;
            return false;
        }
        $edit_data = fetchData($sql);

        $html_ele = array('course_name');

        ?>
        <script>
            <?php
            foreach($html_ele AS $index => $ele)
            {
                ?>
                $("#<?php echo $ele; ?>").val("<?php echo $edit_data[$ele]; ?>");
                <?php
            }
            ?>

        $("#cid, #update_course").remove();
        $('#add_course_form').append('<input type="hidden" name="cid" id="cid" value="<?php echo $edit_data['cid']; ?>" />');
        $('#add_course_form').append('<input type="hidden" name="update_course" id="update_course" value="update_course" />');

        $("#add_course").val("Update");
        $("#add_course").attr( {type:"button", name:"update_course_btn", id:"update_course_btn", onclick:"return custom_onsubmit('add_course_form','res')"} );
        </script>
        <?php
        die();

    }

    if(optPOST('update_course')){
       
        // r_print($_POST);
        $cid = optPOST('cid');

        $com_input = array('course_name');
        $com_input_msg = array('Course Name');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please Enter'.$com_input_msg[$index].'...!';
                echo show_error($error);
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }
        
        $update = executeQuery('UPDATE course SET course_name = "'.$post['course_name'].'" WHERE cid = "'.$cid.'"');

        if($update){

            $done[] = 'Course Detail Updated Successfully...!';
            echo show_success($done);
            return true;

        }else{

            $error[] = 'Failed To Update Course Detail...!';
            echo show_error($error);
            return false;

        }

    }

    if (optPOST('add_course')) {

        // r_print($_POST);

        $com_input = array('course_name');
        $com_input_msg = array('Course Name');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please Enter'.$com_input_msg[$index].'...!';
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }

        $insert = insertData('INSERT INTO `course`( `course_name` ) VALUES ("'.$post['course_name'].'") ');

        if($insert){

            $done[] = 'Course Added Successfully...!';
            return $done;

        }else{

            $error[] = $insert;
            return $error[] = 'Opps, Something Went Wrong...!';

        }
        
    }

    $sql = executeQuery('SELECT * FROM course');
    while ($row = fetchData($sql)) {
        $course_data[] = $row;
    }

    // r_print($course_data);

}

function html_add_course(){

    global $error, $done, $l, $course_data, $globals, $lables;

    ?>
    <!-- Begin Page Content -->
    <div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
        <div id="res"></div>
        <?php 
            echo show_error($error);
            echo show_success($done);
        ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-0"> </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Course</h1>
                </div>
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=add_course" name="add_course_form" id="add_course_form">
                    <div class="form-group">
                    <?php printLable($lables['co_name']); ?>
                        <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo POSTval('course_name', '')?>">
                    </div>
                    <input type="submit" name="add_course" id="add_course" value="Add Course"  class="btn btn-primary btn-block"/>
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
                        <h6 class="m-0 font-weight-bold text-primary">Course List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr.No</th>
                                        <th>Course Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($course_data)){
                                        $i = 0;
                                        foreach ($course_data as $key => $value) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo ++$i; ?></td>
                                                <td><?php echo $value['course_name']; ?></td>
                                                <td>
                                                    <span class="icon-sty">
                                                        <a href="#" onclick='ajax_action("<?php echo $value["cid"]; ?>", "delete")'><i class="<?php echo $globals['del_fa_icon']; ?>"></i>
                                                        </a>
                                                    </span>
                                                    <span class="icon-sty">
                                                        <a href="#" onclick='ajax_action("<?php echo $value["cid"]; ?>", "edit")'><i class="<?php echo $globals['edit_fa_icon']; ?>"></i></a>
                                                    </span>
                                                </td>
                                            </tr>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /.container-fluid -->
    <?php

}

function API_add_course(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

?>
