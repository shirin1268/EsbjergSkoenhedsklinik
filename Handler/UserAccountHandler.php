<?php


class UserAccountHandler extends ServerHandler
{
    private $table_name= "users";





    public function RegisterNewUser($fornavn,$efternavn,$email,$username, $password,$adminpass)
    {
        $connection = $this->dbConnect();

        $sql = "INSERT INTO " .$this->table_name . "
        (`fornavn`,`efternavn`,`email`,`username`,`password`,`Adminlevel`)
                 VALUES (?,?,?,?,?,?)";

        $stmt= $connection->prepare($sql);
        $stmt-> bind_param("ssssss",$fornavn,$efternavn,$email,$username, $password,$adminpass);
        $stmt->execute();

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
}

