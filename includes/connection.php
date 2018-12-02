<?php
spl_autoload_register(function ($class) {
    include "Handler/" . $class . ".php";
});

$sc = new ServerHandler();
//opretter en forbindelse til mysql:
$connection = $sc->dbConnect();
//hvis forbindelsen ikke kan oprettes, så kom med en fejlbesked, og luk forbindselsen:
if (mysqli_connect_errno($connection)) //hvis der IKKE kunne læses noget til variablen, så luk forbindelsen:
{
    die ("Failed to connect to MySQL: " . mysqli_connect_error());
}
