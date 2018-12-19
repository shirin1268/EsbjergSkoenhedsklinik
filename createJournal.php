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
?>
    
<form id="createJ" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <div class="form-group">
        <label>CPR nr.:</label>
        <select class='form-control' name='cpr' >
            <?php
                $fh->readCPR();
            ?>
        </select>
    </div>
    <div class="form-group">
        <label>Behandlingsdato:</label>
        <input type='date' name='dato' class='form-control' >
    </div>
    <div class="form-group">
        <label>Behandling:</label>
        <input type='text' name='behandlingname' class='form-control' />
    </div>
    <div class="form-group">
        <label>Beskrivelse:</label>
        <textarea type='text' name='description' class="form-control" id="exampleFormControlTextarea1" rows="10" ></textarea>
    </div>
    <div class="form-group">
        <label>Betaling:</label>
        <textarea name='betaling' class='form-control'></textarea>
    </div>
    <button type="submit" name="CreateJournal" class="btn btn-login float-right">Create Journal</button>
</form>


<?php
include_once "footer.php";
?>