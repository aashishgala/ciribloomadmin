<?php 
siteheader('Add Teacher'); 

function add_teacher(){

    global $theme, $teacher_data;
    $theme['name'] = 'add_teacher';

    global $error, $done;
    $error = array();
    $done = array();
   
    if (optREQ('special_val') == 'delete') {
        // echo json_encode('done');
        $del_id = optPOST('id');

        $sql = executeQuery('SELECT * FROM `assign_course` WHERE status = 1 AND tid="'.$del_id.'" LIMIT 1');
        if(num_rows($sql) > 0){

            $sql = executeQuery('SELECT * FROM `student_marks` WHERE status = 1 AND tid="'.$del_id.'" LIMIT 1');

            echo 'Teacher data can not delete, teacher has assigned course and entered students marks...!';
            return true;

        }

        $delete = deletData('DELETE FROM `users` WHERE uid="'.$del_id.'" LIMIT 1');
        if ($delete === TRUE) {
            
            echo 'User Deleted Successfully...!';
            return true;

        }else{

            echo $delete;
            return false;
        }

    }

    if (optREQ('special_val') == 'edit') {
        
        $edit_id = optPOST('id');
        $sql = executeQuery('SELECT * FROM users WHERE uid="'.$edit_id.'" LIMIT 1');

        if(!$sql){
            echo $sql;
            return false;
        }

        $edit_data = fetchData($sql);

        $edit_data['upass'] = base64_decode($edit_data['upass']);

        $uinfo = json_decode($edit_data['uinfo']);
        foreach($uinfo AS $k => $v){
            $edit_data[$k] = $v;
        }

        $html_ele = array('fname', 'lname', 'email', 'number', 'upass');

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

        $("#repeatpass").val("<?php echo $edit_data['upass']; ?>");
        $('#upass').attr('type', 'text');
        $('#repeatpass').attr('type', 'text');

        $("#uid, #update_teacher").remove();
        $('#add_teacher_form').append('<input type="hidden" name="uid" id="uid" value="<?php echo $edit_data['uid']; ?>" />');
        $('#add_teacher_form').append('<input type="hidden" name="update_teacher" id="update_teacher" value="update_teacher" />');

        $("#add_teacher").val("Update");
        $("#add_teacher").attr( {type:"button", name:"update_teacher_btn", id:"update_teacher_btn", onclick:"return custom_onsubmit('add_teacher_form','res')"} );
        </script>
        <?php
        die();

    }

    if(optPOST('update_teacher')){
       
        // r_print($_POST);
        $uid = optPOST('uid');

        $com_input = array('fname', 'lname', 'email', 'number', 'upass', 'repeatpass');
        $com_input_msg = array('First Name', 'Last Name', 'Email Id', 'Phone Number', 'Password', 'Re-Enter Password');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please Enter'.$com_input_msg[$index].'...!';
                echo show_error($error);
                return false;
            }
            if ($input_ele == 'number' && strlen(optPOST($input_ele)) > 10) {
                $error['invalid_mobile'] = 'Please Enter Correct Mobile Number...!';
                echo show_error($error);
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }

        if ($post['upass'] != $post['repeatpass']) {
            $error['pass_missmatch'] = 'Password did not matched...!';
            echo show_error($error);
            return false;
        }

        $_info = array(
            'fname' => $post['fname'],
            'lname' => $post['lname'],
            'email' => $post['email'],
            'number' => $post['number']
        );

        $json_info = make_json($_info);

        $_username = $post['number'];
        $_email = $post['email'];

        $password = base64_encode($post['upass']);

        $sql = executeQuery('SELECT uid FROM users WHERE ( uname = "'.$post['number'].'" OR email = "'.$post['email'].'" ) AND uid != "'.$uid.'" LIMIT 1');
        
        if(num_rows($sql) > 0){
            $error[] = 'Mobile OR Email Already Exists...!';
            echo show_error($error);
            return false;
        }
        
        $update = executeQuery('UPDATE users SET uinfo = \''.$json_info.'\', uname = "'.$_username.'", email = "'.$_email.'", upass = "'.$password.'" WHERE uid = "'.$uid.'"');

        if($update){

            $done[] = 'Teacher Detail Updated Successfully...!';
            echo show_success($done);
            return true;

        }else{

            $error[] = 'Failed To Update Teacher Detail...!';
            echo show_error($error);
            return false;

        }

    }

    if (optPOST('add_teacher')) {

        // r_print($_POST);
        $usertyp = optPOST('usertype');

        $com_input = array('fname', 'lname', 'email', 'number', 'upass', 'repeatpass');
        $com_input_msg = array('First Name', 'Last Name', 'Email Id', 'Phone Number', 'Password', 'Re-Enter Password');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please Enter'.$com_input_msg[$index].'...!';
                return $error;
            }
            if ($input_ele == 'number' && strlen(optPOST($input_ele)) > 10) {
                $error['invalid_mobile'] = 'Please Enter Correct Mobile Number...!';
                return $error;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }

        if ($post['upass'] != $post['repeatpass']) {
            $error['pass_missmatch'] = 'Password did not matched...!';
            return $error;
        }

        // r_print($post);

        // Check Already added
        $sql = executeQuery('SELECT uid FROM users WHERE uname = "'.$post['number'].'" OR email = "'.$post['email'].'" LIMIT 1');
        
        if(num_rows($sql) > 0){
            $error[] = 'Teacher Data Exists, Email OR Mobile Already Exists...!';
            return $error;
        }

        $_info = array(
            'fname' => $post['fname'],
            'lname' => $post['lname'],
            'email' => $post['email'],
            'number' => $post['number']
        );

        $json_info = make_json($_info);

        $_username = $post['number'];
        $_email = $post['email'];

        $password = base64_encode($post['upass']);
        $date = date('Y-m-d H:i:s');

        $insert = insertData('INSERT INTO `users`( `utype`, `uinfo`, `uname`, `email`, `upass`, `date`, `lastlogin`) VALUES ("'.$usertyp.'", \''.$json_info.'\', "'.$_username.'", "'.$_email.'", "'.$password.'", "'.$date.'", "'.$date.'")');

        if($insert){

            $done[] = 'Teacher Added Successfully...!';
            return $done;

        }else{

            $error[] = $insert;
            return $error[] = 'Opps, Something Went Wrong...!';

        }
        
    }

    $sql = executeQuery('SELECT * FROM users WHERE utype = "teacher"');
    while ($row = fetchData($sql)) {
        $row['uinfo'] = json_decode($row['uinfo'], true);
        $teacher_data[] = $row;
    }

    // r_print($teacher_data);

}

function html_add_teacher(){

    global $error, $done, $l, $teacher_data, $globals, $lables;

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
        <div class="col-lg-12">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Add Teacher!</h1>
                </div>
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=add_teacher" name="add_teacher_form" id="add_teacher_form">
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="hidden" name="usertype" id="usertype" value="teacher">
                            <?php printLable($lables['fn']); ?>
                            <input type="text" class="form-control" id="fname" name="fname" value="<?php echo POSTval('fname', ''); ?>">
                        </div>
                        <div class="col-sm-6">
                            <?php printLable($lables['ln']); ?>
                            <input type="text" class="form-control" id="lname" name="lname" value="<?php echo POSTval('lname', '')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <?php printLable($lables['email']); ?>
                        <input type="email" class="form-control" id="email" name="email" placeholder="" value="<?php echo POSTval('email', '')?>">
                    </div>
                    
                    <div class="form-group">
                        <?php printLable($lables['phone']); ?>
                        <input type="number" class="form-control" id="number" name="number" value="<?php echo POSTval('number', '')?>">
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                        <?php printLable($lables['pass']); ?>
                            <input type="password" class="form-control"
                                id="upass" name="upass" placeholder="" value="<?php echo POSTval('upass', '')?>">
                        </div>
                        <div class="col-sm-6">
                        <?php printLable($lables['repass']); ?>
                            <input type="password" class="form-control"
                                id="repeatpass" name="repeatpass" placeholder="" value="<?php echo POSTval('repeatpass', '')?>">
                        </div>
                    </div>

                    <div class="col-lg-4 offset-lg-4 col-md-12" style="padding:0;">
                        <input type="submit" name="add_teacher" id="add_teacher" value="Add Teacher"  class="btn btn-primary btn-block"/>
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
                        <h6 class="m-0 font-weight-bold text-primary">Teacher List</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Sr.No</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(!empty($teacher_data)){
                                        $i = 0;
                                        foreach ($teacher_data as $key => $value) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php echo ++$i; ?></td>
                                                <td><?php echo $value['uname'].' <div> OR </div> '.$value['email']; ?></td>
                                                <td><?php echo $value['uinfo']['fname'].' '.$value['uinfo']['lname']; ?></td>
                                                <td>
                                                    <span class="icon-sty">
                                                        <a href="#" onclick='ajax_action("<?php echo $value["uid"]; ?>", "delete")'><i class="<?php echo $globals['del_fa_icon']; ?>"></i>
                                                        </a>
                                                    </span>
                                                    <span class="icon-sty">
                                                        <a href="#" onclick='ajax_action("<?php echo $value["uid"]; ?>", "edit")'><i class="<?php echo $globals['edit_fa_icon']; ?>"></i></a>
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

function API_add_teacher(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

?>
