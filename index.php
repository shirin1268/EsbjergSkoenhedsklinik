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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
              integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="Css/stylesheet.css" />

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