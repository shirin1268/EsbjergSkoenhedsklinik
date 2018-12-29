<?php
$page_title = "Se Journal";
include_once "Header.php";
include_once "menu.php";

$fh = new FormHandler();
$imgR= new ImageResizer();
$jh = new JournalHandler();
$crypt = new Encryption;
?>

<?php
if (!isset($_GET['mode'])) {
    echo "<div class='alert alert-secondary' role='alert' style='width: 50%; margin: auto; text-align: center '>
<br><h4 class='alert-heading'>Du skal lede efter patienten først!</h4>
<hr>
<p class='mb-0'>
<strong>Find patienten</strong> via <strong>søgfeltet</strong> for at <strong>oprette</strong> ny journal eller <strong>
se/opdater</strong> en eksisterende journal eller<strong> tilføje billede</strong>
    </p><br><br>
    </div>
      ";
}else{

    $mode = $_GET['mode'];

    if($mode=="OpretJournal"){
        $encoded = trim($_GET['cpr']) ;

        $patient = $jh->displaypatientname($encoded);
        $navn= $patient["fornavn"];
        $efternavn = $patient["efternavn"];

        $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

        $fh->DisplayCreateJournalForm($cpr,$navn,$efternavn);
    }elseif($mode=="AddPicture")
    {
        $encoded = trim($_GET['cpr']) ;

        $patient = $jh->displaypatientname($encoded);
        $navn= $patient["fornavn"];
        $efternavn = $patient["efternavn"];

        $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

        $fh->AddPictureForm($cpr,$navn,$efternavn);

    }
       elseif ($mode=="ShowJournal")
       {
           $encoded = trim($_GET['cpr']);

           $behandlinger = $jh->displayJournal($encoded);

           if($behandlinger>0)
           {
               $name=$jh->displaypatientname($encoded);
               $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

               echo "
<table class='table'>
   <tr class='table-warning'>
       <th scope='row'>Patientsnavn: </th>
       <th scope='row'>Tel: </th> 
       <th scope='row'>Email: </th>
       <th scope='row'>Alder: </th>
       <th scope='row'>CPR nummer: </th>
    </tr>
    <tr class='shadow p-3 mb-5 bg-white rounded'>
     <td style='text-transform:capitalize'><strong>  " . $name['fornavn'] . "  ".$name['efternavn'] . "</strong></td>
     <td scope='row'> ".$name['tlf'] . "</td>
     <td scope='row'> ".$name['email'] . "</td>
     <td scope='row'> ".$name['alder'] . "</td>
     <td>  " . $cpr . " </td>
    </tr>
</table>
<div class='row'>
         <a href='displayJournal.php?mode=UpdateProfile&cpr=".$encoded."'  class='btn btn-login'>Rediger profilen</a>
      </div>
<br>
<table class='table'>
<tr class='table-warning'>
  <th>Behandling</th>
  <th>  Dato  </th>
  <th>Forklaring</th>
  <th>Betaling</th>
  <th></th>
</tr>
    ";
       foreach ($behandlinger as $behandling)
       {
           echo "
<tr class='shadow p-3 mb-5 bg-white rounded'>
  <td style='text-transform: capitalize'>" . $behandling['behandlingname'] . "</td>
  <td>" . $behandling['dato'] . "</td>   
  <td style='width:50%'>" . $behandling['description'] . "</td>
  <td>" . $behandling['betaling'] . "</td>
  <td> <a href='displayJournal.php?mode=UpdateBehandling&id=" . $behandling['behandlingID'] . "'>Ret</a> </td>
</tr>
 "; }
               echo "
               <br>
      <div class='row'>
         <a href='displayJournal.php?mode=OpretJournal&cpr=".$encoded."'  class='btn btn-login'>Tilføj Behandling</a>
      </div>
    <br>";

echo "
 </table>";

           }
           $pictures = $jh->displayPictures($encoded);
           if ($pictures > 0)
           {
               echo "

<br>
           <table class='table'>
               <tr class='table-warning'>
                   <th> Dato </th>
                   <th>Kategori</th>
                   <th>Picture</th>
                   <th>Title</th>
                   <th></th>
               </tr>";

               foreach ($pictures as $image)
               {
                   echo "
<tr class='shadow p-3 mb-5 bg-white rounded'>
<td style='width:13%'>" . $image['dato'] . "</td>
<td style='width:13%'>" . $image['picturekategori'] . "</td>
<td style='width:50%'><img id='myImg' class='img-thumbnail' src='img/" . $image['picture'] . "' alt='" . $image['picturetitle'] . "'></td>
<td> " . $image['picturetitle'] . "</td>
<td><a href='displayJournal.php?mode=UpdatePicture&id=" . $image['pictureID'] . "' >Ret/Slet</a></td>
 </tr>

 ";
               }
               echo "
               <br>
      <div class='row'>
         <a href='displayJournal.php?mode=AddPicture&cpr=".$encoded."'  class='btn btn-login'>Tilføj Billede</a>
      </div>
    <br>";

           echo " </table>
    
    ";
           }
       }
    if ($mode=="UpdateProfile")
    {
        $encoded = trim($_GET['cpr']) ;

        $patient = $jh->displaypatientname($encoded);
        $navn= $patient["fornavn"];
        $efternavn = $patient["efternavn"];
        $email=$patient["email"];
        $tel=$patient["tlf"];
        $alder=$patient["alder"];
        $køn=$patient["gender"];

        $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

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
            $encoded =$crypt->encrypt_decrypt('encrypt',$_POST["cpr"]) ;
            if ($jh->UpdateBehandling($id, $behandlingname, $description, $dato, $betaling, $encoded) == true)
            {
                echo "<div class='alert alert-success'>Updated.</div>";
            } else {
                echo "<div class='alert alert-danger'>Unable to update.</div>";
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

            if ($jh->UpdatePicture($id, $kategori, $encoded, $dato, $title) == true)
            {

                       echo "<div class='alert alert-success'>Image information updated!.</div>";
                   } else {
                       echo "<div class='alert alert-danger'>Unable to update image information.</div>";
                   }
        }
        elseif (isset($_POST["DeleteImg"]))
        {
                   $id = trim($_GET['id']);
                   if ($jh->DeletePicture($id) == true)
                   {
                       echo "<div class='alert alert-success'>Billedet er slettet.</div>";
                   } else {
                       echo "<div class='alert alert-danger'>Det er ikke muligt at slette billedet!.</div>";
                   }

        }
    }


}

include_once "footer.php";
