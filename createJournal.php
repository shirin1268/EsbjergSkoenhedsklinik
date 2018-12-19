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
        echo "<div class='alert alert-success'>Journal was created.</div>";
    }
    else{
        echo "<div class='alert alert-danger'>Unable to create Journal.</div>";
    }
    }

}
?>

    <div class="col-md-auto" style="min-width: 80%">
        <form id="createJ" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <h4>Opret journal til patienten via nedenstående form</h4>
            <table class='table table-hover table-responsive table-bordered'>

                <tr>
                    Find patientens CPR
                    <select class='form-control' name='cpr' >
                        <?php
                        $fh->readCPR();
                        ?>
                    </select>
                </tr><br>
                <tr>
                    Behandlingsdato:
                    <br>
                    <input type='date' name='dato' class='form-control' >
                </tr><br>
                <tr>
                    Behandlingsnavn:
                    <input type='text' name='behandlingname' class='form-control' />
                </tr><br>

                <tr>
                    Beskrivelse af behandlingen:
                    <textarea type='text' name='description' class="form-control" id="exampleFormControlTextarea1" rows="10" ></textarea>
                </tr><br>

                <tr>
                    Betaling
                    <textarea name='betaling' class='form-control'></textarea>
                </tr><br>

                <tr>
                    <button type="submit" name="CreateJournal" class="btn btn-login float-right">Create Journal</button>
                </tr><br><br>

            </table><br>
        </form>

    </div>

<?php


include_once "footer.php";
?>