<?php


class PatientAccountHandler extends ServerHandler
{
    public $patientID;
    public $fornavn;
    public $efternavn;
    public $alder;
    public $gender;
    public $cpr;
    public $email;
    public $tlf;



    public function RegisterNewPatient($fornavn ,$efternavn , $email, $tlf, $cpr, $alder, $gender){

        $connection = $this->dbConnect();

        $query= ("INSERT INTO `patient` (`fornavn`, `efternavn`, `email`, `tlf`, `CPR`, `alder`, `gender`) 
                  VALUES (?,?,?,?,?,?,? )");

        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssisis", $fornavn, $efternavn, $email, $tlf, $cpr, $alder,$gender);


        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }


}