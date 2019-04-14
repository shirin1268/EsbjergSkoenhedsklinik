<?php
require_once("Toploader.php");

spl_autoload_register(function ($class){
    include "../Handler/".$class.".php";
});

$ah = new AdminHandler();

$page_title = "Admin login";

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo $page_title; ?> </title>
        <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" href="Css/stylesheet.css" />

        <script src="assets/jquery-3.3.1.min.js"></script>
        <script src="assets/popper.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
    <div class="container">
        <div class="row align-items-center" id="header">

    <section class="login-block">
        <img id="admin-logo" src='img/logo-final-blue.png'>

        <br><br>
                <div class="row">
                    <div class="col-md-4 login-sec">


                        <h2 class="text-center" style="color: #578f9d">Login Now</h2>
                        <form class="login-form" action="adminlogin.php " method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="text-uppercase">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="">

                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="">
                            </div>


                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input">
                                    <small>Remember Me</small>
                                </label>
                                <button type="submit" name="LoginSomAdmin" class="btn btn-login float-right">Login</button>
                            </div>

                        </form>

                    </div>
                    <div class="col-md-8 banner-sec">
                                <div class="carousel-item active">
                                    <img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg" alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <div class="banner-text">
                                            <h2>This is Heaven</h2>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div>
        </section>

<?php
if(isset($_POST["LoginSomAdmin"]) &&
    !empty($_POST["username"]) &&
    !empty($_POST["password"])){

    $ah->LogInSomAdmin();
}
include_once "footer.php";
?>