<?php
if($skip_auth == 0){
    siteheader('Change Password'); 
}

function change_password(){

    global $theme, $sess_data;
    $theme['name'] = 'change_password';
    // r_print($sess_data, 1);
    global $error, $done;
    $error = array();
    $done = array();

    if(optPOST('reset_pass')){
       
        // r_print($_REQUEST, 1);
        $number = optPOST('number');
        $change_pass_for = (isset($_REQUEST['for'])) ? $_REQUEST['for'] : $sess_data['logged_in_as'] ;

        if($_REQUEST['type'] != 'change_pass'){
            $_email =  optPOST('email');
        }else{
            $_email = $sess_data['email'];
        }

        $com_input = array('upass','upass_new');
        $com_input_msg = array('Current Password','New Password');

        if($_REQUEST['type'] != 'change_pass'){
            $key = array_search('upass', $com_input);
            unset($com_input[$key]);
            unset($com_input_msg[$key]);
            array_push($com_input,'email');
            array_push($com_input_msg, 'Email Id');
        }

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please Enter'.$com_input_msg[$index].'...!';
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
        }

        $is_email = get_val('SELECT email FROM users WHERE utype = "'.$change_pass_for.'" AND email = "'.$_email.'"');
        // r_print($is_email, 1);

        if(empty($is_email)){
            $error[] = 'Email Id Is Not Registered Email...!';
            return false;
        }

        if($_REQUEST['type'] == 'change_pass'){

            $_upass = base64_encode($post['upass']);

            $is_old_pass = get_val('SELECT upass FROM users WHERE utype = "'.$change_pass_for.'" AND email = "'.$_email.'"');
            // r_print($is_old_pass, 1);

            if($is_old_pass['upass'] != $_upass){
                $error[] = 'Incorrect Current Password...!';
                return false;
            }
        }
        $_upass_new = base64_encode($post['upass_new']);
        
        $update = executeQuery('UPDATE users SET upass = "'.$_upass_new.'" WHERE utype = "'.$change_pass_for.'" AND email = "'.$_email.'" LIMIT 1');
        
        if($update){

            $done[] = 'Password Changed Successfully...!';
            return true;

        }else{

            $error[] = 'Fail To Update Password...!';
            return false;

        }

    }

}

function html_change_password(){

    global $error, $done, $l, $course_data, $globals, $sess_data;
    // r_print($sess_data);
    // r_print($_SESSION);
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
    <?php if(isset($_GET['type']) && $_GET['type'] != 'change_pass'){ ?>
    <!-- Forgot password  -->
    <style>
        body{
            background-color: #4e73df;
            background-image: linear-gradient(180deg,#4e73df 10%,#224abe 100%);
            background-size: cover;
        }
        a {
            text-decoration: none !important;
        }
    </style>
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and set new password</p>
                                </div>
                                <?php change_password_form(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <?php } else { ?>
    <!-- Change password super admin dashboard -->
    <div class="row">
        <div class="col-lg-3 col-sm-0"> </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Change Password</h1>
                </div>
                <?php change_password_form(); ?>
            </div>
        </div>
        <div class="col-lg-3 col-sm-0"> </div>
    </div>
    <?php } ?>
    <!-- /.container-fluid -->
    <?php

}

function change_password_form(){
    $home_link = '';
    $_url = '?act=change_password&type=change_pass';
    if(isset($_GET['type']) && $_GET['type'] == 'forgot_pass'){
        $_url = '?type=forgot_pass&for='.$_GET['for'];
        $home_link = '<div class="text-center"><a href="index.php" class="small">Home</a>';
    }
    ?>
    <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF'].''.$_url; ?>" name="reset_password" id="reset_password">

        <?php if(isset($_GET['type']) && $_GET['type'] != 'change_pass'){ ?>
            <div class="form-group">
                <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter Email Address...">
            </div>
        <?php } ?>
        
        <?php if(isset($_GET['type']) && $_GET['type'] == 'change_pass'){ ?>
        <div class="form-group">
            <input type="password" name="upass" class="form-control form-control-user" id="examplepassword" placeholder="Enter Current Password..." value="<?php echo POSTval('upass', '')?>">
        </div>
        <?php } ?>

        <div class="form-group">
            <input type="password" name="upass_new" class="form-control form-control-user" id="examplepasswordnew" placeholder="Enter New Password..." value="<?php echo POSTval('upass_new', '')?>">
        </div>
            <input type="hidden" name="cp_type" value="<?php echo $_GET['type']; ?>">
            <input type="hidden" name="cp_for" value="<?php echo (isset($_GET['for'])) ? $_GET['for'] : ''; ?>">
        <input type="submit" name="reset_pass" id="reset_pass" value="Reset Password"  class="btn btn-primary btn-block btn-user"/>
    </form>
    <?php
    echo $home_link;
}
function API_add_course(){

    global $globals, $error, $done;
	
	if(!empty($done)){
		$GLOBALS['_api']['done'] = $done;
	}
}

?>
