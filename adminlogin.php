<?php
require_once("Toploader.php");

spl_autoload_register(function ($class){
    include "../Handler/".$class.".php";
});

$sh = new ServerHandler();



if(isset($_POST["LoginSomAdmin"]) &&
    !empty($_POST["username"]) &&
    !empty($_POST["password"])){

    $connection = $sh->dbConnect();
    $username = trim(mysqli_real_escape_string($connection, $_POST['username']));
    $password = trim(mysqli_real_escape_string($connection, $_POST['password']));


    $query = "SELECT * FROM `users` WHERE `username`= '$username' ";
    $result = mysqli_query($connection, $query);


    if (mysqli_num_rows($result) == 1)
    {
        // username/password authenticated
        // and only 1 match

        $found_user = mysqli_fetch_array($result);
        echo $found_user['FullName'];
        if (password_verify($password, $found_user['password']))

        {
            $_SESSION['adminID'] = $found_user['adminID'];
            $_SESSION['username'] = $found_user['username'];
        }

        redirect_to("velkommen.php");
        die();
    }
    else
    {
        // username/password combo was not found in the database

        echo '<script>alert("Brugernavn eller Password var inkorrekt. Prøv venligst igen.");</script>';
    }
}
$page_title = "Admin login";

?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $page_title; ?> </title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="Css/stylesheet.css" />
</head>
<body>
<div class="container">

    <div class="row align-items-center" id="header">
        <div class="row-header">
        <img class="img" id='logo' src='img/logo-3.png'>
        </div>
    <section class="login-block">

                <div class="row">
                    <div class="col-md-4 login-sec">
                        <h2 class="text-center">Login Now</h2>
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
</div>
</div>

</body>
</html>