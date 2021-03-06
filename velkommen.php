<?php
require_once("Toploader.php");

$fh = new FormHandler();
$ua = new UserAccountHandler();
$pa = new PatientAccountHandler();
$ah = new AdminHandler();
$sh = new SearchHandler();

$page_title = "Velkomst page";


include_once "Header.php";


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
        $adminpass = ValidateHandler::adminlevelvalidation($_POST["adminpass"]);
    $password = ValidateHandler::hashing($_POST["password"]);



        if($ua->RegisterNewUser($fornavn,$efternavn,$email,$username, $password,$adminpass)==true)
        {
            echo "<div class='alert alert-success'><strong>Fint!</strong>En ny bruger er oprettet.</div>";
        }

        // if unable to create the product, tell the user
        else{
            echo "<div class='alert alert-danger'><strong>Beklager!</strong> Det er ikke muligt at oprette brugeren.</div>";
        }
    }

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
        $cpr =$encrypt->encrypt_decrypt('encrypt',$_POST["cpr"]);

            if( $pa->RegisterNewPatient($fornavn ,$efternavn , $email, $tlf , $cpr, $alder, $gender)==true)
        {
            echo "<div class='alert alert-success'><strong>Fint! </strong> ny patientprofil er oprettet.</div>";
        }
        else{
            echo "<div class='alert alert-danger'><strong>Beklager!</strong> Det er ikke muligt at oprette profil til denne patient.</div>";
        }
        }
    else
        {
        echo "<div class='alert alert-danger'>Det <strong>CPR-nr</strong> ligner ikke et rigtig CPR-nr!!!!:<strong> ".$_POST["cpr"]. "</strong></div>";
        }
    }
}
?>

<div class="row">
    <div class="col-sm-4">
        <div class="btn-group-vertical">
            <a class="btn btn-login" href="velkommen.php?mode=RegisterNewPatient">
                    <i class="fas fa-address-card"></i>
                    Opret profil til en ny kunde
            </a><br/>
            <a class="btn btn-login" href="displayJournal.php">
                    <i class="fas fa-address-book"></i>
                    Find en eksisterende kunde
            </a><br/>
            <a class="btn btn-login" href="displayJournal.php">
                    <i class="fas fa-file-prescription"></i>
                    Opret journal
            </a><br/>
            <a class="btn btn-login" href="velkommen.php?mode=RegisterNewUser">
                    <i class="fas fa-user-md"></i>
                    Opret ny admin
            </a><br/>
            <a class="btn btn-login" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    Log ud
            </a><br/>
        </div>
    </div>

    <div class="col-md-8 banner-sec" style="min-width: 60%">
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
                if($_SESSION["Adminlevel"]=="owner"){

                $fh->DisplayRegisterUserForm();
                }else{
                    echo "<div class='alert alert-danger'>This function is just for the <strong>system owner!</strong> </div>";
                }
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

        }else {
            echo "<div class='carousel'><img src='img/Mesotherapy-needle-injection-2.jpg' class='img-fluid'>

                                        <div class='banner-text'>
                                            <h2>Velkommen til din arkive</h2>
                                            <p>I menuen på højre side har du flere muligheder for at vælge imellem. Er det ny patient der skal registreres eller 
                                            en eksisterende patient som du skal finde og se/oprette journalen. 
                                            Ligeledes kan du som ejern oprette en ny admin til systemet. 
                                            </p>
                                        </div>
                                    </div>
    ";
        }
        ?>

</div>

</div>
<?php

 include_once "footer.php";
?>


