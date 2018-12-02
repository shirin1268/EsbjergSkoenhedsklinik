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
                if ($row["Adminlevel"] == 1)
                {
                    echo "<h4>Velkommen " . $_SESSION['username'] ."</h4>";
                }
        }
    }
}


