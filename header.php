<?php
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");
// if (session_status() === PHP_SESSION_NONE) {
//     session_start();
// }
require_once '../project_path.php';

// $host = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

// if ($_SERVER['REMOTE_ADDR'] == "::1" OR $_SERVER['SERVER_ADDR'] == "::1" OR $_SERVER['SERVER_ADDR'] == "127.0.0.1") {
//     $ProjectPath = $host."/quiz_forum/";
//     $configuration = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/conf.json';
//     $DocumentRoot = $_SERVER[ 'DOCUMENT_ROOT' ].'/quiz_forum/';
// }else{
//     $ProjectPath = $host."/quizz/quiz_forum/";
//     $configuration = $_SERVER[ 'DOCUMENT_ROOT' ].'/quizz/quiz_forum/conf.json';
//     $DocumentRoot = $_SERVER[ 'DOCUMENT_ROOT' ].'/quizz/quiz_forum/';
// }

$configuration = $site_path.'conf.json';
$DocumentRoot = $site_path;

require $path = $DocumentRoot.'language/language.php';
if (!isset($__SESSION['languagePath'])) {
    $_SESSION['languagePath'] = $path;
}

// $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$jsondata = @json_decode(file_get_contents($configuration), true);
// echo "<pre>"; print_r($GLOBALS); echo "</pre>"; 
if(!empty($jsondata)){
    foreach($jsondata as $sk => $sv){
        $globals[$sk] = $sv;
    }
}

?>
<html>
<head>
	<title><?php if(!empty($globals['sitetitle'])){ echo $globals['sitetitle']; }else{ echo $language['site_name']; } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--Custom CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo $ProjectPath; ?>css/global.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $ProjectPath; ?>css/style.css">
	<!--Bootstrap CSS-->
	<link rel="stylesheet" type="text/css" href="<?php echo $ProjectPath; ?>css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $ProjectPath; ?>css/bootstrap.min.css">

    <link href="<?php echo $ProjectPath; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!--Script-->
    <script src="<?php echo $ProjectPath; ?>js/jquery.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/jquery.min1.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/bootstrap.min1.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/custom.js"></script>

    <!-- script bootstrap 4 -->
    <!-- <script src="<?php echo $ProjectPath; ?>js/jquery-3.2.1.slim.min.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/popper.min.js"></script>
    <script src="<?php echo $ProjectPath; ?>js/bootstrap4.min.js"></script> -->

</head>
<body>
    <?php
    // admin nav
    if (!empty($utype) && $utype == 'ad') { ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="home.php"></a>
            </div>
            <div class="navbar-header">
                <!-- <a class="navbar-brand" href="user.php?p=users">Administrator</a> -->
                <a class="navbar-brand" href="user_score_list.php?p=user_score_list">Administrator</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav adm-nav navbar-left">
                    <!-- <li id="dashboard"><a href="home.php?p=dashboard"> Dashboard</a></li> -->
                    <!-- <li id="topic"><a href="post.php?p=topic"> Topics</a></li> -->
                    <li id="user"><a href="user.php?p=user">User Score</a></li>
                    <li id="user_score_list"><a href="user_score_list.php?p=user_score_list"> Users</a></li>
                    <!-- <li id="utilities"><a href="utilities.php?p=utilities">Utilities</a></li> -->
                    <!-- <li id="category"><a href="category.php?p=category">Category</a></li> -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#" ><span class="glyphicon glyphicon-user"></span> <?php echo $uname;?></a></li>
                    <li ><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <?php
    }else{ ?>
	<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="home.php"> <span class="glyphicon  glyphicon-home"></span>  </a>
            </div>
            <div class="navbar-header">
                <a class="navbar-brand" href="home.php"><?php if(!empty($globals['sitename'])){ echo $globals['sitename']; }else{ echo $language['site_name']; } ?></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <div>
                    <?php 
                    if (@!isset($_SESSION['username']) && @$_SESSION['username']==""){
                    ?>
					<form class="navbar-form navbar-right" method="POST"role="search" action="pages/login.php">
					<div class="form-group">
					<input type="text" class="form-control" name="username"placeholder="Username">
					<input type="password" class="form-control" name="password"placeholder="Password">
					</div>
					<button type="submit" class="btn btn-success usr-btn">Login</button>
					</form>
                    <?php
                    }
                    else
                    {
                        $username=$_SESSION['username'];
                        $userid = $_SESSION['user_id'];
                      ?>
                        <!-- <ul class="nav navbar-nav navbar-left">
                        <li><a href="#quest"> Post a Question</a></li>
                        </ul> -->
                            
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="#" ><span class="glyphicon glyphicon-user"></span> <?php echo $username;?></a></li>
                                <li ><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                        
                        </ul>	
                      <?php
                    }
                    ?>
				</div>
                
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <?php } ?>