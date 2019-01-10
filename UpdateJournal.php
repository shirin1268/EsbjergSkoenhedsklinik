<?php
/**
 * Created by PhpStorm.
 * User: shirin1268
 * Date: 07-01-2019
 * Time: 19:51
 */
$page_title = "Update Journal";
include_once "Header.php";
include_once "menu.php";


$fh = new FormHandler();
$imgR= new ImageResizer();
$jh = new JournalHandler();
$crypt = new Encryption;


if (isset($_GET['mode'])) {
    $mode=$_GET['mode'];
    $encoded = trim($_GET['cpr']) ;
    include_once "Journalhandlinger.php";

    $patient = $jh->displaypatientname($encoded);
    $navn= $patient["fornavn"];
    $efternavn = $patient["efternavn"];
    $email=$patient["email"];
    $tel=$patient["tlf"];
    $alder=$patient["alder"];
    $køn=$patient["gender"];

    $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

        if ($mode=="UpdateProfile")
        {
    $fh->UpdateProfileForm($cpr,$encoded,$navn,$efternavn,$email,$tel,$alder,$køn);

    }elseif ($mode == "UpdateBehandling")
    {
    $id = trim($_GET['id']);
    $fh->UpdateBehandlingForm($id);

    if (isset($_POST["UpdateBehandling"]))
    {
        $connection = $sh->dbConnect();
        $behandlingname =ValidateHandler::validinput($_POST["behandlingname"],$connection);
        $betaling =ValidateHandler::validinput( $_POST["betaling"],$connection);
        $description =ValidateHandler::validinput($_POST["description"],$connection) ;
        $dato = $_POST["dato"];
        $encoded =$crypt->encrypt_decrypt('encrypt',$_POST["patientcpr"]) ;
        $previous_page="displayJournal.php?mode=ShowJournal&cpr=" .$encoded;

        if ($jh->UpdateBehandling($id, $behandlingname, $description, $dato, $betaling, $encoded) == true)
        {
            echo "<div class='alert alert-success'>Updated.<a href=". htmlspecialchars($previous_page). ">  Return</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to update.<a href=". htmlspecialchars($previous_page). ">  Return</a></div>";
        }
    }
} elseif ($mode == "UpdatePicture")
{
    $id = trim($_GET['id']);
    $fh->UpdatePictureForm($id);

    if (isset($_POST["UpdateImg"]))
    {
        $connection = $sh->dbConnect();
        $kategori = ValidateHandler::validinput($_POST['kategori'], $connection);
        $encoded =$crypt->encrypt_decrypt('encrypt',$_POST["cpr"]);
        $dato = ValidateHandler::validinput($_POST['dato'],$connection);
        $title = ValidateHandler::validinput($_POST['title'], $connection);
        $previous_page="displayJournal.php?mode=ShowJournal&cpr=" .$encoded;

        if ($jh->UpdatePicture($id, $kategori, $encoded, $dato, $title) == true)
        {

            echo "<div class='alert alert-success'>Image information updated!.
                             <a href=". htmlspecialchars($previous_page). ">Return</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to update image information.
                              <a href=". htmlspecialchars($previous_page). ">Return</a></div>";
        }
    }
    elseif (isset($_POST["DeleteImg"]))
    {
        $id = trim($_GET['id']);
        $encoded =$crypt->encrypt_decrypt('encrypt',$_POST["cpr"]);
        $previous_page="displayJournal.php?mode=ShowJournal&cpr=" .$encoded;
        if ($jh->DeletePicture($id) == true)
        {
            echo "<div class='alert alert-success'>Billedet er slettet.<a href=". htmlspecialchars($previous_page). ">Return</a></div>";
        } else {
            echo "<div class='alert alert-danger'>Det er ikke muligt at slette billedet!.<a href=". htmlspecialchars($previous_page). ">Return</a></div>";
        }

    }
}
}echo "</div>
</div>
";
include_once "footer.php";