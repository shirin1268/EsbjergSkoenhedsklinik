<?php
require_once("Toploader.php");

$fh = new FormHandler();
$ua = new UserAccountHandler();
$pa = new PatientAccountHandler();
$ah = new AdminHandler();
$sh = new SearchHandler();

$page_title = "Velkomst page";
include_once "Header.php";

?>

<div class="row">
    <div class="col-sm-4">
        <h5>Valg en af de nedenstående</h5>
        <br/>
        <div class="btn-group-vertical">

            <button type="button" class="btn btn-outline-secondary">
                <a href="velkommen.php?mode=RegisterNewPatient"> Opret profil til en ny kunde</a>
            </button><br/><br/>
            <button type="button" class="btn btn-outline-secondary">
                <a href="velkommen.php?mode=SearchPatient">Opdater en gammel profil</a>
            </button><br/><br/>
            <button type="button" class="btn btn-outline-secondary">
                <a href="velkommen.php?mode=RegisterNewUser"> Opret ny admin</a>
            </button><br/><br/>
            <button type="button" class="btn btn-outline-secondary">
                <a href="logout.php">Log ud</a>
            </button>
        <br/>
            </div>
    </div>

    <div class="col-md-auto" style="min-width: 60%">
        <?php
        if (isset($_GET['mode']))
        {
            $mode = $_GET['mode'];


            if ($mode == "RegisterNewPatient")
            {
                $fh->DisplayRegisterPatientForm();

            }

            elseif ($mode== "RegisterNewUser" )
            {
                $fh->DisplayRegisterUserForm();
            }
            elseif ($mode=="SearchPatient")
            {
                $fh->DisplaySearchForm();
            }

            if (isset($_POST['submitSearch']))
            {
                $searchTerm= $_POST['search'];
                $sh->search($searchTerm);

                $searchresult = $sh->search($searchTerm);

                if($searchresult>0){

                    $fh->DisplaySearchResult($searchresult);
                }

// tell the user there are no patient
                else{
                    echo "<div class='alert alert-danger'>No one found.</div>";
                }

            }

        }
        ?>

    </div>

</div>

<?php


if (isset($_POST['RegisterNewUser']))
{
    if(
        !empty($_POST["email"])&&
        !empty($_POST["username"])&&
        !empty($_POST["adminpass"])&&
        !empty($_POST["password"])
    )
    {

        $fornavn =ValidateHandler::validinput($_POST["fornavn"],$connection);
        $efternavn = ValidateHandler::validinput($_POST["efternavn"],$connection);
        $email = ValidateHandler::validinput($_POST["email"],$connection);
        $username = ValidateHandler::validinput($_POST["username"],$connection);
        $adminpass = ValidateHandler::validinput($_POST["adminpass"],$connection);
    $password = ValidateHandler::hashing($_POST["password"]);



        if($ua->RegisterNewUser($fornavn,$efternavn,$email,$username, $password,$adminpass)==true)
        {
            echo "<div class='alert alert-success'>User was created.</div>";
        }

        // if unable to create the product, tell the user
        else{
            echo "<div class='alert alert-danger'>Unable to create new user.</div>";
        }
    }

// redirect_to("velkommen.php");
}

if (isset($_POST['RegisterNewPatient']))
{
    if
    (
        !empty($_POST["email"])&&
        !empty($_POST["fornavn"])&&
        !empty($_POST["efternavn"])&&
        !empty($_POST["cpr"])
    )
    {
        $regexcpr= "/^(0?[1-9]|1[0-9]|2[0-9]|3[01])(0?[1-9]|[12]\d)(\d{2})(\d{4})$/";
        if (preg_match($regexcpr,$_POST["cpr"]))
        {
        $fornavn =ValidateHandler::validinput($_POST["fornavn"],$connection);
        $efternavn = ValidateHandler::validinput($_POST["efternavn"],$connection);
        $email = ValidateHandler::validinput($_POST["email"],$connection);
        $tlf = ValidateHandler::validinput($_POST["tlf"],$connection);
        $alder = ValidateHandler::validinput($_POST["alder"],$connection);
        $gender =ValidateHandler::validinput($_POST["gender"],$connection);

            $encrypt = new Encryption();
        $cpr =$encrypt->encode($_POST["cpr"]);

        if( $pa->RegisterNewPatient($fornavn ,$efternavn , $email, $tlf , $cpr, $alder, $gender)==true)
        {
            echo "<div class='alert alert-success'>Profile was created.</div>";
        }
        else{
            echo "<div class='alert alert-danger'>Unable to create new profile.</div>";
        }

        }
    else
        {
        echo "The cpr number is INVALID!!!!: ".$_POST["cpr"];
        }
    }

}


 include_once "footer.php";
?>


