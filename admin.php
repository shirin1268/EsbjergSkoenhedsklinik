<?php
require_once("Toploader.php");

spl_autoload_register(function ($class)
{
    include "Handler/" . $class . ".php";
});

$ah = new AdminHandler();


if (!$ah->checkForAdmin($_SESSION['user_id']))
{
    redirect_to("adminlogin.php");
}
$page_title = "administrator";
include_once "Header.php";
?>


