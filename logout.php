<?php
require_once("Toploader.php");
session_destroy();
header("Location: adminlogin.php");