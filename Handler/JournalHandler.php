<?php


class JournalHandler extends ServerHandler
{

    private $table_name = "behandling";

    // object properties
    public $behandlingname;
    public $betaling;
    public $description;
    public $cpr;



    function createJournal($behandlingname,$description,$dato ,$betaling,$cpr)
    {
        $connection = $this->dbConnect();

        $query = "INSERT INTO " .$this->table_name . "
        ( `behandlingname`, `description`, `dato`, `betaling`, `CPR`)
         VALUES (?,?,?,?,?)";

        $stmt = $connection->prepare($query);
        $stmt-> bind_param("sssss",$behandlingname,$description,$dato,$betaling,$cpr);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    function displayJournal($encoded)
    {
        $connection = $this->dbConnect();

        $sql = "SELECT * FROM `patient` 
INNER JOIN `behandling` ON `patient`.`CPR`= `behandling`.`CPR`
 WHERE `patient`.`CPR`='$encoded' ";

        $stmt=$connection->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=mysqli_fetch_all($result,MYSQLI_ASSOC);

        return $row ;
    }

    function displaypatientname($encoded)
    {
        $connection = $this->dbConnect();

        $sql = "SELECT * FROM `patient` 
 WHERE `patient`.`CPR`='$encoded' ";

        $stmt=$connection->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=mysqli_fetch_array($result);

        return $row ;
    }


    function displayPictures($encoded)
    {
        $connection = $this->dbConnect();
        $sql = "SELECT * FROM `patient` 
 INNER JOIN `picture` ON `patient`.`CPR`= `picture`.`CPR` 
 WHERE `patient`.`CPR`='$encoded' ";

        $stmt=$connection->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=mysqli_fetch_all($result,MYSQLI_ASSOC);

        return $row ;
    }
    function UpdateBehandling($id,$behandlingname,$description,$dato,$betaling,$encoded)
    {
        $connection = $this->dbConnect();
        $sql="UPDATE `behandling` SET `behandlingname`=?,
             `description`=?,`dato`=?,`betaling`=?,`CPR`=? WHERE `behandlingID`= '$id'";
        $stmt=$connection->prepare($sql);
        $stmt->bind_param("sssss",$behandlingname,$description,$dato,$betaling,$encoded);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function UpdatePicture($id,$kategori, $cpr, $dato, $title)
    {
        $connection = $this->dbConnect();
        $sql="UPDATE `picture` SET 
             `picturekategori`=? ,`CPR`=? ,`dato`=? ,`picturetitle`=?  
              WHERE `pictureID`= '$id'";
        $stmt=$connection->prepare($sql);
        $stmt->bind_param("ssss",$kategori, $cpr, $dato, $title);

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    function DeletePicture($id)
    {
        $connection = $this->dbConnect();
        $sql="DELETE FROM `picture` WHERE `pictureID`= '$id' ";
        $stmt= $connection->prepare($sql);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}