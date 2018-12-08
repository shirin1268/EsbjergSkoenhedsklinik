<?php
$page_title = "Se Journal";
include_once "Header.php";
include_once "menu.php";

$fh = new FormHandler();
$imgR= new ImageResizer();
$jh = new JournalHandler();
$crypt = new Encryption;

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];

       if ($mode=="ShowJournal")
       {;
           $encoded = trim($_GET['cpr']) ;

           $behandlinger = $jh->displayJournal($encoded);

           if($behandlinger>0)
           {
               $name=$jh->displaypatientname($encoded);
               $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

               echo "
<table class='table'>
   <tr class='table-warning'>
       <th scope='row'>Patientsnavn: </th>
        <td style='text-transform:capitalize'>  " . $name['fornavn'] . "  ".$name['efternavn'] . "</td>
    </tr>
    <tr class='shadow p-3 mb-5 bg-white rounded'>
    <th scope='row'>CPR nummer: </th>
        <td>  " . $cpr . " </td>
    </tr>
</table>
<br>
<table class='table table-hover table-responsive table-bordered'>
<tr class='table-warning'>
  <th >Behandling</th>
  <th>  Dato  </th>
  <th>Forklaring</th>
  <th>Betaling</th>
  <th></th>
</tr>
    ";
       foreach ($behandlinger as $behandling)
       {
           echo "
<tr>
  <td style='text-transform: capitalize'>" . $behandling['behandlingname'] . "</td>
  <td>" . $behandling['dato'] . "</td>   
  <td>" . $behandling['description'] . "</td>
  <td>" . $behandling['betaling'] . "</td>
  <td> <a href='displayJournal.php?mode=UpdateBehandling&id=" . $behandling['behandlingID'] . "'>Ret</a> </td>
</tr> "; }

echo "
 </table>";

           }
           $pictures = $jh->displayPictures($encoded);
           if ($pictures > 0)
           {
               echo "

<br>
           <table class='table table-hover table-responsive table-bordered'>
               <tr class='table-warning'>
                   <th>Dato & kategori</th>
                   <th>Picture</th>
                   <th>Title</th>
                   <th></th>
               </tr>";

               foreach ($pictures as $image)
               {
                   echo "
<tr>
<td>" . $image['dato'] . "<br>" . $image['picturekategori'] . "</td>
<td><img id='myImg' class='img-thumbnail' src='img/" . $image['picture'] . "' alt='" . $image['picturetitle'] . "'></td>
<td> " . $image['picturetitle'] . "</td>
<td><a href='displayJournal.php?mode=UpdatePicture&id=" . $image['pictureID'] . "' >Ret/Slet</a></td>
 </tr>

 ";
               }
           echo " </table>
    <br>
      <div class='row'>
         <a href='createJournal.php'  class='btn btn-login float-right'>Tilføj Behandling</a>
      </div>
    <br>
    ";
           }
       }
           if ($mode == "UpdateBehandling")
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

           }

           if ($mode == "UpdatePicture")
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
           }

           elseif (isset($_POST["DeleteImg"]))
           {
               $id = trim($_GET['id']);
               if ($jh->DeletePicture($id) == true)
               {
                   echo "<div class='alert alert-success'>Image deleted.</div>";
               } else {
               echo "<div class='alert alert-danger'>Unable to delete image.</div>";
               }

           }
}

include_once "footer.php";
