<?php
require_once '../Init.php';

if(Input::exists()) {
    $user = new User();
    $remember = (Input::get('remember') === 'on') ? true : false;
    $login = $user->login(Input::get('username'), Input::get('password'), $remember);

    if($login) {
        Redirect::to('../dashboard/');
    } else {
        Redirect::to('../login/');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../assets/images/favicon.png">

    <title>SDXng</title>
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>

    <!-- Bootstrap core CSS -->
    <link href="../assets/login/js/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/login/fonts/font-awesome-4/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="../assets/login/css/style.css" rel="stylesheet" />
</head>
<body class="texture">
<div id="cl-wrapper" class="login-container">
    <div class="middle-login">
        <div class="block-flat">
            <div class="header">
                <h3 class="text-center"><img class="logo-img" src="../assets/images/logo.png" alt="logo"/></h3>
            </div>
            <div>
                <form style="margin-bottom: 0px !important;" class="form-horizontal" action="" method="post">
                    <div class="content">
                        <h4 class="title">Login Access</h4>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" placeholder="Username" name="username" id="username" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    <input type="password" placeholder="Password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                        </div>
                        <label style="float: left;"><input type="checkbox" id="remember" style="float: left; margin-right: 10px;" name="remember"> <h4 class="title" style="float: right;">Remember Me</h4></label>
                    </div>
                    <div class="foot">
                        <button class="btn btn-primary" style="width: 100%;" type="submit">Sign in to Continue</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="text-center out-links block-flat" style="padding: 10px; margin-top: -15px;">
            <h4 class="title">&copy; 2014 SDXng</h4>
        </div>
    </div>
</div>
<script src="../assets/login/js/jquery.js"></script>
<script type="text/javascript" src="../assets/login/js/behaviour/general.js"></script>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="../assets/login/js/jquery.flot/jquery.flot.js"></script>
<script type="text/javascript" src="../assets/login/js/jquery.flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="../assets/login/js/jquery.flot/jquery.flot.resize.js"></script>
<script type="text/javascript" src="../assets/login/js/jquery.flot/jquery.flot.labels.js"></script>
</body>
</html>
