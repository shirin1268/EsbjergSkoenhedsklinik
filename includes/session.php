<?php
session_start();

function logged_in()
{
    return isset($_SESSION['adminID']);
}

