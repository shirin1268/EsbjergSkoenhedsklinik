<?php

require_once("Toploader.php");

spl_autoload_register(function ($class){
    include "Handler/".$class.".php";
});

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forside | Esbjerg Skønhedsklinik</title>
    <meta name="description"
          content="     "/>
    <link href="Css/stylesheet.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>


<body>
<h1><a href="adminlogin.php"> login som admin</a></h1>
</body>

</html>