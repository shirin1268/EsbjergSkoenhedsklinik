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

    <div class="row align-items-center" id="header">
        <div class="col-6 col-md-4">
            <h3>
            <?php
            echo date("d/m/Y");
            ?>
            </h3>
        </div>
        <div class="col-6 col-md-4">
            <?php
            echo $ah->checkForAdmin($_SESSION['adminID']);
            ?>
        </div>
        <div class="col-6 col-md-4">
            <img class="img" id='logo' src='img/logo-3.png'>
        </div>
    </div>
    <a href="velkommen.php"><h5>Tilbag til forside</h5></a>


    
    