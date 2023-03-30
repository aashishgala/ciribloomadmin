<?php 
siteheader('Profile'); 

function profile(){

    global $theme, $sess_data;
    $theme['name'] = 'profile';
    // r_print($sess_data,1);
    global $error, $done;
    $error = array();
    $done = array();

    if(optPOST('update_user_profile')){
       
        // r_print($_POST); die();
        $number = optPOST('number');

        $com_input = array('fname','lname','email','number');
        $com_input_msg = array('First Name','Last Name','Email Id','Number');

        foreach ($com_input as $index => $input_ele) {

            if (empty(optPOST($input_ele))) {
                $error['empty_'.$input_ele] = 'Please Enter'.$com_input_msg[$index].'...!';
                return false;
            }

            $post[$input_ele] = htmlspecialchars(optPOST($input_ele));
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

        $is_email_exists = get_val('SELECT email FROM users WHERE email = "'.$_email.'" AND uid != "'.$sess_data['uid'].'"');
        // r_print($is_email, 1);

        if(!empty($is_email_exists)){
            $error[] = 'Email Id Is Alredy In Use...!';
            return false;
        }

        $is_mobile_exists = get_val('SELECT email FROM users WHERE uname = "'.$_username.'"  AND uid != "'.$sess_data['uid'].'"');
        // r_print($is_email, 1);

        if(!empty($is_mobile_exists)){
            $error[] = 'Mobile Number Is Alredy In Use...!';
            return false;
        }

        $update = executeQuery('UPDATE users SET uinfo = \''.$json_info.'\', uname = "'.$_username.'", email = "'.$_email.'" WHERE uname = "'.$sess_data['user'].'"');
        
        if($update){
            $sess_data['uinfo'] = json_decode($json_info); 
            $sess_data['email'] = $post['email'];
            $sess_data['uname'] = $post['number'];
            $_SESSION['user'] = $_username;
            $done[] = 'Profile Detail Updated Successfully...!';
            return true;

        }else{

            $error[] = 'Profile To Update Course Detail...!';
            return false;

        }

    }

}

function html_profile(){

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
    <div class="row">
        <div class="col-lg-3 col-sm-0"> </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="p-5">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Profile Detail</h1>
                </div>
                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?act=profile" name="update_profile" id="update_profile">
                    <!-- <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="User Name" value="<?php echo $sess_data['user']; ?>" disabled>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php echo $sess_data['uinfo']->fname; ?>">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo $sess_data['uinfo']->lname; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="<?php echo $sess_data['uinfo']->email; ?>">
                    </div>
                    
                    <div class="form-group">
                        <input type="number" class="form-control" id="number" name="number" placeholder="Mobile Number" value="<?php echo $sess_data['uinfo']->number; ?>">
                    </div>

                    <div class="col-lg-4 offset-lg-4 col-md-12" style="padding:0;">
                        <input type="submit" name="update_user_profile" id="update_user_profile" value="Update"  class="btn btn-primary btn-block"/>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-3 col-sm-0"> </div>
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
