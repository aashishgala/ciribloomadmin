<?php 
siteheader('Add Assignment'); 

function add_assignment(){

    global $theme, $assigndata, $arr_co_mod_list, $arr_cid_name, $arr_coures, $arr_module;
    $theme['name'] = 'add_assignment';

    global $error, $done;
    $error = array();
    $done = array(); 

    // load module course wise
    if(optPOST('special_val') == 'load_module_data' && optPOST('course_id')){

        $course_id = optPOST('course_id');

        $sql = executeQuery('SELECT * FROM module where cid='.$course_id);
        while ($row = fetchData($sql)) {
            echo '<option value="'.$row['mid'].'">'.$row['modulename'].'</option>';
        }

        return true;
        die();
    }

    $sql = executeQuery('SELECT * FROM course');
    while ($row = fetchData($sql)) {
        // $course_data[] = $row;
        $arr_cid_name['cid'][$row['cid']] = $row['course_name'];
    }

    $sql = executeQuery('SELECT * FROM module ORDER BY cid');
    while ($row = fetchData($sql)) {

        $_course_name = $arr_cid_name['cid'][$row['cid']];
        $_module_name = $row['modulename'];

        $_co_mod_name = $_course_name.' - '.$_module_name;

        $arr_mid_name[$row['mid']] = $_module_name;

        $arr_co_mod_list[$row['cid'].'_'.$row['mid']] = $_co_mod_name;

    }

    if (optREQ('special_val') == 'delete') {
        // echo json_encode('done');
        $del_id = optPOST('id');

        // Is assigned to teacher?
        $sql = executeQuery('SELECT * FROM assign_course WHERE aid LIKE "%|'.$del_id.'|%" AND status = 1 LIMIT 1');
        if(num_rows($sql) > 0){
            echo 'You Can Not Delete This Assignment, It Is Assigned To Teacher!';
            return false;
        }

        $delete = deletData('DELETE FROM `assignment` WHERE aid="'.$del_id.'" LIMIT 1');
        if ($delete === TRUE) {
            
            echo 'Assignment Deleted Successfully...!';
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
        $set_mod_op = '';
        $sql = executeQuery('SELECT * FROM module where cid='.$edit_data['cid']);
        while ($row = fetchData($sql)) {
            $set_mod_op .= '<option value="'.$row['mid'].'">'.$row['modulename'].'</option>';
        }
        ?>
        <script>
            $('#mid').html('<?php echo $set_mod_op; ?>');
        </script>
        <?php
        $html_ele = array('cid', 'mid', 'assignname');

        foreach ($html_ele as $key => $value) {
            ?>
            <script>$("#<?php echo $value; ?>").val("<?php echo $edit_data[$value]; ?>");</script>
            <?php
        }
        ?>
        <script>
        $("#aid, #update_assign").remove();
        $('#add_assign_form').append('<input type="hidden" name="aid" id="aid" value="<?php echo $edit_data['aid']; ?>" />');
        $('#add_assign_form').append('<input type="hidden" name="update_assign" id="update_assign" value="update_assign" />');

        $("#add_assign").val("Update");
        $("#add_assign").attr( {type:"button", name:"update_assign_btn", id:"update_assign_btn", onclick:"return custom_onsubmit('add_assign_form','res')"} );
        </script>
        <?php
        die();

    }

    if(optPOST('update_assign')){
       
        // r_print($_POST);
        $aid = optPOST('aid');

        $com_input = array('cid', 'mid', 'assignname');

        // $com_input = array('co_mod', 'assignname');
        $com_input_msg = array('Select Course', 'Select Module', 'Enter Assignment Name');

        foreach ($com_input as $index => $input_ele) {
            
            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                echo show_error($error);
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }

        // $co_mod = array_filter(explode('_', $post['co_mod']));
        // $post['cid'] = $co_mod[0];
        // $post['mid'] = $co_mod[1];
        $sql_update = 'UPDATE assignment SET assignname = "'.$post['assignname'].'", cid = "'.$post['cid'].'", mid = "'.$post['mid'].'" WHERE aid = "'.$aid.'"';
        $update = executeQuery($sql_update);

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

    if (optPOST('add_assign')) {

        $com_input = array('co_mod', 'assignname');
        $com_input_msg = array('Select Course-Module', 'Enter Assignment Name');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please '.$com_input_msg[$index].'...!';
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));

        }

        $co_mod = array_filter(explode('_', $post['co_mod']));
        $post['cid'] = $co_mod[0];
        $post['mid'] = $co_mod[1];

        // Check duplicate
        // $sql = executeQuery('SELECT aid FROM assignment WHERE cid = "'.$post['cid'].'" AND mid = "'.$post['mid'].'" LIMIT 1');
        // if(num_rows($sql) > 0){
        //     $error[] = 'Combination Already Exists...!';
        //     echo show_error($error);
        //     return false;
        // }

        $insert = insertData('INSERT INTO `assignment`( `cid`, `mid`, `assignname` ) VALUES ("'.$post['cid'].'", "'.$post['mid'].'", "'.$post['assignname'].'")');

        if($insert){

            $done[] = 'Assignment Added Successfully...!';
            return $done;

        }else{

            $error[] = $insert;
            return $error[] = 'Opps, Something Went Wrong...!';

        }
        
    }

    $sql = executeQuery('SELECT * FROM assignment ORDER BY cid, aid');
    while ($row = fetchData($sql)) {

        $_course_name = $arr_cid_name['cid'][$row['cid']];  
        $_module_name = $arr_mid_name[$row['mid']];
        
        $arr_coures[$row['cid']] = $_course_name;
        $arr_module[$row['cid']][$row['mid']] = $_module_name;

        $assigndata[$row['cid']][$row['mid']][$row['aid']] = $row['assignname'];

    }

    // r_print($arr_coures);
    // r_print($arr_module);
    // r_print($assigndata);
    // die();

}

function html_add_assignment(){

    global $error, $done, $l, $assigndata, $arr_co_mod_list, $arr_cid_name, $arr_coures, $arr_module, $globals;

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
            if (empty($arr_co_mod_list)) {
                echo '<div class="alert alert-danger mt-5 font-weight-bold" role="alert">
                No Course Or Module Found, Please Add Course/Module...!</div>';
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
                    <h1 class="h4 text-gray-900 mb-4">Add Assignment</h1>
                </div>
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=add_assignment" name="add_assign_form" id="add_assign_form">
                    <div class="form-group">
                        <select class="form-control" id="cid" name="cid" onchange='course_wise_module(this.value)'>
                            <option value="">Select Course</option>
                            <?php
                            // echo POSTval('course', '');
                            foreach ($arr_coures as $key => $value) {
                                ?>
                                <option value="<?php echo $key; ?>" <?php echo (POSTval('cid', '') == $key ? 'selected' : '' ); ?> >
                                    <?php echo $value; ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control" id="mid" name="mid">
                            <option value="">Select Module</option>
                            <?php
                            // echo POSTval('course', '');
                            foreach ($arr_module as $ckey => $value) {
                                foreach ($value as $mkey => $_module_name) {
                                ?>
                                <option value="<?php echo $mkey; ?>" <?php echo (POSTval('mid', '') == $mkey ? 'selected' : '' ); ?> >
                                    <?php echo $_module_name; ?>
                                </option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="assignname" name="assignname" placeholder="Enter Assignment Name" value="<?php echo POSTval('assignname', '')?>">
                    </div>
                    <input type="submit" name="add_assign" id="add_assign" value="Add Assignment"  class="btn btn-primary btn-block" <?php echo $dis_btn; ?> />
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
                    <h6 class="m-0 font-weight-bold text-primary">Assignment List</h6>
                </div>
                <div class="card-body">
                    <?php
                    if(!empty($assigndata)){
                        $i = 0;
                        // Course Loop
                        foreach ($assigndata as $cid => $arr_mod) 
                        {
                            ?>
                            <h6 class="font-weight-bold mt-2 mb-3 p-2 bg-primary text-white">
                                Course: <?php echo $arr_coures[$cid]; ?>
                            </h6>
                            <?php
                            // Module Loop
                            foreach ($arr_mod as $mid => $arr_assign)
                            {
                                ?>
                                <p>
                                    <span class="bg-info text-white p-2 mt-2 mb-2">
                                    Module: <?php echo $arr_module[$cid][$mid]; ?>
                                    </span>
                                </p>
                                
                                <div class="table-responsive">
                                    <table class="table table-hover" id="mod<?php echo $mid; ?>" width="100%" cellspacing="0">
                                    <tbody>
                                        <?php
                                        foreach ($arr_assign as $aid => $assign)
                                        {
                                            ?>
                                            <tr>
                                                <td width="50%"><?php echo $assign; ?></td>
                                                <td>
                                                    <span class="icon-sty">
                                                        <a href="#" onclick='ajax_action("<?php echo $aid; ?>", "delete")'><i class="<?php echo $globals['del_fa_icon']; ?>"></i>
                                                        </a>
                                                    </span>
                                                    <span class="icon-sty">
                                                        <a href="#" onclick='ajax_action("<?php echo $aid; ?>", "edit")'><i class="<?php echo $globals['edit_fa_icon']; ?>"></i></a>
                                                    </span>
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
                            
                            ?>
                            
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

    <script>
        function course_wise_module(id){

            // Data to post
            var d = "special_val=load_module_data&course_id="+id;

            // Get Current Location
            var loc = window.location.toString();

            if(loc.indexOf("#") > 0){
                loc = loc.substring(0, loc.indexOf("#"));
            }

            replce_to = loc.replace('#', '');
            $.ajax({
                type: "post",
                url: loc+"&api=json",
                data: d,

                success: function(result){
                    $("#mid").html(result);
                },

                error: function(err){   
                    alert(err);
                }

            });
        }

    </script>
    <!-- /.container-fluid -->
    <?php

}

function API_add_assignment(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

?>
