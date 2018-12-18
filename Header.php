<?php
require_once("Toploader.php");

spl_autoload_register(function ($class)
{
    include 'Handler/'. $class . '.php';
});

$ah =new AdminHandler();
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

    <script>
        $('.carousel').carousel()
    </script>
</head>
<body>
<div class="container">

    <div class="row align-items-bottom" id="header">

        <div class="col-md-4">
            <?php
            $ah->confirm_logged_in();
            ?>
        </div>


    <div class="col-6 col-md-4">
        <p class="lead float-right">
            <?php

            ?>
        </p>
    </div>
        <div class="col-md-4">
            <img class="img" id='logo' src='img/logo-3.png'>
        </div>
    </div>
    <?php
    If($page_title!="Velkomst page"&& $page_title!="Admin login"){

   echo '<a class="text-dark" href="velkommen.php"><h5>Tilbag til forside</h5></a>';
    }
    ?>
    <hr>
    
    