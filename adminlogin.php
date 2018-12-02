<?php
require_once("Toploader.php");

spl_autoload_register(function ($class){
    include "../Handler/".$class.".php";
});

$sh = new ServerHandler();



if(isset($_POST["LoginSomAdmin"]) &&
    !empty($_POST["username"]) &&
    !empty($_POST["password"])){

    $connection = $sh->dbConnect();
    $username = trim(mysqli_real_escape_string($connection, $_POST['username']));
    $password = trim(mysqli_real_escape_string($connection, $_POST['password']));


    $query = "SELECT * FROM `users` WHERE `username`= '$username' ";
    $result = mysqli_query($connection, $query);


    if (mysqli_num_rows($result) == 1)
    {
        // username/password authenticated
        // and only 1 match

        $found_user = mysqli_fetch_array($result);
        echo $found_user['FullName'];
        if (password_verify($password, $found_user['password']))

        {
            $_SESSION['adminID'] = $found_user['adminID'];
            $_SESSION['username'] = $found_user['username'];
        }

        redirect_to("velkommen.php");
        die();
    }
    else
    {
        // username/password combo was not found in the database

        echo '<script>alert("Brugernavn eller Password var inkorrekt. Prøv venligst igen.");</script>';
    }
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <title>Login | Esbjerg Skønhedsklinik</title>
    <meta name="description" content="   " />
    <link href="Css/stylesheet.css" rel="stylesheet" />
</head>
<body>

<div id="container">
    <!-- Content start -->
    <div id="content">
        <h3>Esbjerg Skønhedsklinik</h3>

        <form id="login_form" action="adminlogin.php " method="POST">
            <br>
            Brugernavn:<br>
            <input type="text" name="username"><br>
            Adgangskode:<br>
            <input type="password" name="password"><br>
            <br><br>
            <input name="LoginSomAdmin" type="submit" value="LoginSomAdmin" >
        </form>

    </div>
    <!-- Content end -->
</div>

</body>
</html>