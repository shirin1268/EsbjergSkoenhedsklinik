<?php include_once("./includes/application_top.php"); ?>
<?php


$times = get_times_in_range("08:00", "22:44", 14, false);

var_dump($times);


include_once("application_bottom.php");
?>