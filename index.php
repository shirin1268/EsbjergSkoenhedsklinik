<?php

require_once("Toploader.php");

spl_autoload_register(function ($class){
    include "Handler/".$class.".php";
});
$page_title = "Index page";

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
        <div class="row align-items-bottom" id="header">


            <div class="carousel-item active">
                <img src="img/Beauty-clinics-.jpg" class="img-rounded" alt="Cinque Terre">
                <div class="carousel-caption d-none d-md-block">
                    <div class="banner-text">
                        <h1><a href="adminlogin.php"> login som admin</a></h1>
                    </div>
                </div>
            </div>





<?php
include_once "footer.php";
?>