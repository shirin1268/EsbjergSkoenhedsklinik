<?php
session_start();

function logged_in()
{
    return isset($_SESSION['adminID']);
}

function confirm_logged_in($value)
{
    if (!logged_in())
    {
        redirect_to("$value");
    }
}