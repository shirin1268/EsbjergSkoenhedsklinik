<?php
require_once "Toploader.php";

spl_autoload_register(function ($class) {
    include 'Handler/' . $class . '.php';
});

$ah = new AdminHandler();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title><?php echo $page_title; ?></title>
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
    /*        if ($page_title != "Velkomst page" && $page_title != "Admin login") {
                echo '<a class="text-dark" href="velkommen.php"><h5>Tilbag til forside</h5></a>';
            }*/
        ?>
        <hr>

