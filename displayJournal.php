<?php
$page_title = "Se Journal";
include_once "Header.php";
include_once "menu.php";

$fh = new FormHandler();
$imgR= new ImageResizer();
$jh = new JournalHandler();
$crypt = new Encryption;

if (!isset($_GET['mode'])) {
    echo "<div class='alert alert-secondary' role='alert' style='width: 50%; margin: auto; text-align: center '>
<br><h4 class='alert-heading'>Du skal lede efter patienten først!</h4>
<hr>
<p class='mb-0'>
<strong>Find patienten</strong> via <strong>søgfeltet</strong> hver gang du vil <strong>oprette</strong> ny journal eller <strong>
se/opdater</strong> en eksisterende journal eller<strong> tilføje billede</strong>
    </p><br><br>
    </div>
      ";
}else{
    $encoded = trim($_GET['cpr']) ;
    $patient = $jh->displaypatientname($encoded);
    $navn= $patient["fornavn"];
    $efternavn = $patient["efternavn"];

    $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

   include_once "Journalhandlinger.php";


    $mode = $_GET['mode'];

    if($mode=="OpretJournal"){

        $fh->DisplayCreateJournalForm($cpr,$navn,$efternavn);
    }elseif($mode=="AddPicture")
    {
        $fh->AddPictureForm($cpr,$navn,$efternavn);

    }
       elseif ($mode=="ShowJournal")
       {
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
  <td style='width:15%; text-transform: capitalize'>" . $behandling['behandlingname'] . "</td>
  <td style='width:15%; font-size:12px'>" . $behandling['dato'] . "</td>   
  <td style='width:50%'>" . $behandling['description'] . "</td>
  <td>" . $behandling['betaling'] . "</td>
  <td> <a href='UpdateJournal.php?mode=UpdateBehandling&id=" . $behandling['behandlingID'] . "&cpr=". $encoded ."'>Ret</a> </td>
</tr>
 "; }
               echo "
               <br>
   ";

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
<tr class='shadow bg-white rounded'>
<td style='width:15%; font-size:12px'>" . $image['dato'] . "</td>
<td style='width:13%'>" . $image['picturekategori'] . "</td>
<td style='width:50%'><img id='myImg' class='img-thumbnail' src='img/" . $image['picture'] . "' alt='" . $image['picturetitle'] . "'></td>
<td> " . $image['picturetitle'] . "</td>
<td><a href='UpdateJournal.php?mode=UpdatePicture&id=" . $image['pictureID'] . "&cpr=". $encoded ."' >Ret/Slet</a></td>
 </tr>

 ";
               }
               echo "
     
    <br>";

           echo " </table>
    
    ";
           }
       }


}
echo "</div>
</div>
";
include_once "footer.php";
