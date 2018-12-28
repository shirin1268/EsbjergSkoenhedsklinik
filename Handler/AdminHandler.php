<?php


class AdminHandler extends ServerHandler
{
// DISPLAY FUNCTIONS FOR DISPLAYING INFORMATION
    // is used to check if user is Admin. Returns True or False.
    public function checkForAdmin($adminID)
    {
        $adminID= $_SESSION['adminID'];
        $connection = $this->dbConnect();
        $sql = ("SELECT * FROM users WHERE adminID = $adminID ");
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_assoc($result))
                if ($row["Adminlevel"] == "owner"|| $row["Adminlevel"] == "administrator")
                {
                    echo "<h2 class='float-left'>Velkommen <br> " . $_SESSION['username'] ."</h2>";
                }
        }else {
            redirect_to("adminlogin.php");

        }
    }

    function confirm_logged_in()
    {
        if (!logged_in())
        {
            redirect_to("adminlogin.php");
        }else {
            echo $this->checkForAdmin($_SESSION['adminID']);
        }
    }
    public function LogInSomAdmin(){


            $connection = $this->dbConnect();
            $username = trim(mysqli_real_escape_string($connection, $_POST['username']));
            $password = trim(mysqli_real_escape_string($connection, $_POST['password']));


            $query = "SELECT * FROM `users` WHERE `username`= ? ";
            $stmt=$connection->prepare($query);
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $result=$stmt->get_result();

            if (mysqli_num_rows($result) == 1)
            {
                // username/password authenticated
                // and only 1 match

                $found_user = mysqli_fetch_array($result);
                echo $found_user['fornavn'];
                if (password_verify($password, $found_user['password']))

                {
                    $_SESSION['adminID'] = $found_user['adminID'];
                    $_SESSION['username'] = $found_user['username'];
                    $_SESSION['Adminlevel']=$found_user['Adminlevel'];
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

}


