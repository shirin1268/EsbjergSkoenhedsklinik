<?php

class ServerHandler
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "mani2008";
    private $dbname = "esbjerg-klinik";
    private $conn;

    public function dbConnect()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }
       else
        {
            mysqli_set_charset($conn, 'utf8mb4');
            return $conn;
        }
    }
}
