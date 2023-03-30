<?php
require './globals.php'; 
require './functions/function.php';
require './class/mysql.php';

// Craete mysql class object to use mysql functions
$mysql_obj = new mysql_function();

function register(){

    global $error, $done;
    $error = array();
    $done = array();

    $ip = get_user_ip();
    
    if (optPOST('register')) {

        // r_print($_POST);
        $com_input = array('fname', 'lname', 'email', 'number', 'pass', 'repeatpass');
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

        if ($post['pass'] != $post['repeatpass']) {
            $error['pass_missmatch'] = 'Password did not matched...!';
            return $error;
        }

        // r_print($post);

        // Check Already register
        $sql = executeQuery('SELECT uid FROM users WHERE uname = "'.$post['number'].'" OR email = "'.$post['email'].'" LIMIT 1');
        
        if(num_rows($sql) > 0){
            return $error[] = 'You Are Already Registered, <a href="login.php">Click Here To Login</a>...!';
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

        $password = base64_encode($post['pass']);
        $date = date('Y-m-d H:i:s');

        $insert = insertData('INSERT INTO `users`( `utype`, `uinfo`, `uname`, `email`, `upass`, `date`, `lastlogin`) VALUES ("admin", \''.$json_info.'\', "'.$_username.'", "'.$_email.'", "'.$password.'", "'.$date.'", "'.$date.'")');

        if($insert){

            $done[] = 'You Have Registered Successfully, <a href="login.php">Click Here To Login</a>...!';
            return $done;

        }else{

            $error[] = $insert;
            return $error[] = 'Opps, Something Went Wrong...!';

        }
        
    }

}

register();

function register_theme(){

    global $error, $done;

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Register</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">


        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>
        
    </head>

    <body class="bg-gradient-primary">

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <?php 
                    echo show_error($error);
                    echo show_success($done);
                ?>
                </div>
            </div>
            <div class="card o-hidden border-0 shadow-lg my-2">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                        <div class="col-lg-7">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <form class="user" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="register_form" id="register_form">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" class="form-control form-control-user" id="fname" name="fname" placeholder="First Name" value="<?php echo POSTval('fname', ''); ?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control form-control-user" id="lname" name="lname" placeholder="Last Name" value="<?php echo POSTval('lname', '')?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" value="<?php echo POSTval('email', '')?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" id="number" name="number" placeholder="Mobile Number" value="<?php echo POSTval('number', '')?>">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user"
                                                id="pass" name="pass" placeholder="Password" value="<?php echo POSTval('pass', '')?>">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user"
                                                id="repeatpass" name="repeatpass" placeholder="Repeat Password" value="<?php echo POSTval('repeatpass', '')?>">
                                        </div>
                                    </div>
                                    <input type="submit" name="register" id="register" value="Register Account"  class="btn btn-primary btn-user btn-block"/>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="login.php">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>

    </html>

    <?php

}

register_theme();