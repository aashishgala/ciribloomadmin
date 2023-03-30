<?php
require './globals.php'; 
require './functions/function.php';
require './class/mysql.php';

php_start_session();

// Craete mysql class object to use mysql functions
$mysql_obj = new mysql_function();

$usertype = 'admin';
if(optPOST('usertype')){
    $usertype = optPOST('usertype');
}elseif(optGET('usertype')){
    $usertype = optGET('usertype');
}elseif(isset($_SESSION['logged_in_as'])){
    $usertype = $_SESSION['logged_in_as'];
}

if(isset($_SESSION['logged_in_as'])){
    header('Location:index.php');
    die();
}

// if($usertype == 'admin'){
    
//     $ip = $_SERVER['REMOTE_ADDR'];
//     $sess = check_session_key();

//     // If already logged in return to default page
//     if (!empty($sess)) {
//         header('Location:index.php');
//         die();
//     }

// }else{

//     if(isset($_SESSION['logged_in_as'])){
//         header('Location:index.php');
//         die();
//     }

// }

function login(){

    global $error;
    $error = array();
    
    if (optPOST('login')) {
        
        $username = optPOST('username');
        $password = base64_encode(optPOST('password'));
        $usertype = optPOST('usertype');

        if (empty($username)) {
            $error['unameempty'] = 'Please Enter Username...!';
            return $error;
        }

        if (empty($password)) {
            $error['passempty'] = 'Please Enter Password...!';
            return $error;
        }

        $sql = executeQuery('SELECT * FROM users WHERE ( uname = "'.$username.'" OR email = "'.$username.'" ) AND upass = "'.$password.'" AND utype = "'.$usertype.'" LIMIT 1');
        
        if(num_rows($sql) == 0){
            $error[] = 'Username Or Password Is Incorrect...!';
            return $error;
        }

        $result = fetchData($sql);
        // r_print($result);

        // Are we logged in ?
        $ip = $_SERVER['REMOTE_ADDR'];
        $userinfo['user'] = $result['uname'];
        $userinfo['logged_in_as'] = $usertype;

        $_SESSION = $userinfo;

        // if($usertype == 'admin'){
        //     create_session_file($ip, $userinfo);
        // }else{
        //     $_SESSION = $userinfo;
        // }

        header('location:index.php');

    }
    
}

login();

function login_theme(){

    global $error, $usertype;
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin - Login</title>

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

        <style>
            a{
                text-decoration: none !important;
            }
        </style>
    </head>

    <body class="bg-gradient-primary">

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">
                <?php if(!empty($error)) { ?>
                <div class="alert alert-danger mt-5 font-weight-bold" role="alert">
                    The Follwing errors found...!
                    <ul>
                    <?php
                    foreach ($error as $index => $value) {
                        ?>
                        <li><?php echo $value; ?></li>
                        <?php
                    }
                    ?>
                    </ul>
                </div>
                <?php } ?>
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <?php
                                    $a_active = 'active bg-gradient-primary';
                                    $t_active = '';
                                    if(optGET('loginuser') == 'teacher')
                                    {
                                        $t_active = 'active bg-gradient-primary';
                                        $a_active = '';
                                    }
                                    ?>
                                    <ul class="nav nav-tabs mt-5" style="margin-bottom: 15px;">
                                        <li class="nav-link <?php echo $a_active; ?>">
                                            <!-- <a href="#home" data-toggle="tab">Home</a> -->
                                            <a href="login.php?loginuser=admin">Admin</a>
                                        </li>
                                        <li class="nav-link <?php echo $t_active; ?>">
                                            <!-- <a href="#profile" data-toggle="tab">Profile</a> -->
                                            <a href="login.php?loginuser=teacher">Teacher</a>
                                        </li>
                                    </ul>

                                    <div class="p-5">
                                        <?php
                                        if(optGET('loginuser') == 'teacher')
                                        {
                                            $_post_url = optGET('loginuser');
                                            $_input = '<input type="hidden" name="usertype" id="usertype" value="'.optGET('loginuser').'">';

                                            $pass_link = '<a href="index.php?type=forgot_pass&for=teacher" id="cp_teacher" class="small">Forgot Password</a>';

                                            ?>
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Teacher Login</h1>
                                            </div>
                                            <?php
                                        }
                                        else
                                        {
                                            $_post_url = 'admin';
                                            $_input = '<input type="hidden" name="usertype" id="usertype" value="admin">';

                                            $pass_link = '<a href="index.php?type=forgot_pass&for=admin" id="cp_admin" class="small">Forgot Password</a>';

                                            ?>
                                            <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Admin Login</h1>
                                            </div>
                                            <?php
                                        }
                                        ?>

                                        <form method="POST" class="user" action="<?php echo $_SERVER['PHP_SELF'].'?loginuser='.$_post_url; ?>" name="admlogin" id="admlogin">
                                            <div class="form-group">
                                                
                                                <?php echo $_input; ?>

                                                <input type="text" class="form-control form-control-user"
                                                    id="username" name="username" aria-describedby="emailHelp"
                                                    placeholder="Enter Email / Mobile" value="<?php echo POSTval('username', '')?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="password" name="password" placeholder="Password" value="<?php echo POSTval('password', '')?>">
                                            </div>
                                            <input type="submit" name="login" id="login" value="login"  class="btn btn-primary btn-user btn-block"/>
                                            <hr>
                                        </form>
                                        <?php if($_post_url == 'admin'){ ?>
                                        <div class="text-center">
                                            <a class="small" href="register.php">Create an Account!</a>
                                        </div>
                                        <?php } 
                                        echo '<div class="text-center">'.$pass_link.'</div>'; 
                                        ?>
                                    </div>
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

login_theme();

?>
<script>
    $(".active a").css("color", "#fff");
</script>