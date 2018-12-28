<?php

// set page headers
$page_title = "Create Journal";
include_once "Header.php";
include_once "menu.php";
$jh = new JournalHandler();
$pa = new PatientAccountHandler();
$fh =new FormHandler();
$encrypt= new Encryption();


if (isset($_POST['CreateJournal']))
{
    if(
        !empty($_POST["cpr"])&&
        !empty($_POST["behandlingname"])&&
        !empty($_POST["description"])&&
        !empty($_POST["betaling"])
    )
    {
        $behandlingname = ValidateHandler::validinput($_POST["behandlingname"],$connection);
        $description = ValidateHandler::validinput($_POST["description"],$connection);
        $betaling =ValidateHandler::validinput($_POST["betaling"],$connection);
        $dato=ValidateHandler::validinput($_POST['dato'],$connection);
        $cpr = $encrypt->encrypt_decrypt('encrypt',trim($_POST["cpr"]));
        if($jh->createJournal($behandlingname,$description,$dato,$betaling,$cpr)==true)
        {
            echo '<div class="alert alert-success alert-dismissible fade show" id="alert" role="alert">
                Journal was created.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
        else{
            echo '<div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
                Unable to create Journal.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    }
}

if (isset($_POST['updatePatientProfile'])) {
    $encrypt = new Encryption();
$cpr=$_GET['cpr'];
    if
    (
        !empty($_POST["email"]) &&
        !empty($_POST["fornavn"]) &&
        !empty($_POST["efternavn"]) &&
        !empty($_POST["newcpr"])
    ) {

            $fornavn = ValidateHandler::validinput($_POST["fornavn"], $connection);
            $efternavn = ValidateHandler::validinput($_POST["efternavn"], $connection);
            $email = ValidateHandler::validinput($_POST["email"], $connection);
            $tlf = ValidateHandler::validinput($_POST["tlf"], $connection);
            $alder = ValidateHandler::validinput($_POST["alder"], $connection);
            $gender = ValidateHandler::validinput($_POST["gender"], $connection);


            $newcpr = $encrypt->encrypt_decrypt('encrypt', $_POST["newcpr"]);
        $previous_page="displayJournal.php?mode=ShowJournal&cpr=" . $newcpr;

            if ($jh->UpdatePatientProfile($fornavn, $efternavn, $email, $tlf, $cpr ,$newcpr, $alder, $gender) == true) {
                echo "<div class='alert alert-success'><strong>Fint! </strong> Patientprofilen er opdateret succesfully.
                <a href=". htmlspecialchars($previous_page). ">Return</a></div>";

            }

            else {
                echo "<div class='alert alert-danger'><strong>Beklager!</strong> Patientprofilen kan ikke blive opdateret.
                      <a href=". htmlspecialchars($previous_page). ">Return</a>
                      </div>";

            }

        }

}

include_once "footer.php";
?>
