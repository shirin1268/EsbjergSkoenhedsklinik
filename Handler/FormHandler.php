<?php

/**
 * Created by PhpStorm.
 * User: shirin1268
 * Date: 13-11-2018
 * Time: 13:19
 */
class FormHandler extends ServerHandler
{
    public function DisplayRegisterUserForm()
    {

        echo "<p class='display-4'>Registrer en ny Admin</p>

			<form  action='' method='post'' >
			    <div class='form-row'>
				<div class='form-group col-md-6'>
					<p>Førnavn:</p>
					 <input class='form-control' id='exampleInputFornavn'  type='text' name='fornavn' required/>
				</div><br>
				<div class='form-group col-md-6'>	     
					<p>Efternavn:</p>
					 <input type='text' name='efternavn' class='form-control' id='exampleInputEfternavn' required/>    
                </div>
                </div>
                <div class='form-row'>
				<div class='form-group col-md-6'>
                	<p>Email:</p>
					<input type='email' name='email' placeholder='eksempl@domain.com'  class='form-control' id='exampleInputEmail'>
				</div>  
				<div class='form-group col-md-6'>
					 <p>Brugernavn:</p>
					  <input type='text' name='username' class='form-control' id='exampleInputuser' required/>
				</div>
				</div>
				<div class='form-row'>
				<div class='form-group col-md-6'>
					<p>Password:</p>
					<input class='form-control' id='exampleInputPassword1' type='password'  name='password' required>    
				</div>  <br>  
				<div class='form-group col-md-6'>  
					<p>Admin level:</p>
					<input class='form-control' id='exampleInputPassword1' type='password'  name='adminpass' required>
				</div> </div>
				<div class='form-row'>
					<button type='submit' class='btn btn-login float-right' name='RegisterNewUser' value='RegisterNewUser' >Register</button>
				</div>
			  
			</form> ";

    }

    public function DisplayRegisterPatientForm(){

        echo "
<div class='col-md-auto' style='min-width: 80%'>
    <form id='createJ' action='' method='post'>
        <p class='display-4'>Opret profile til ny kunde</p>

				<div class='form-row'>
				<div class='form-group col-md-6'>
				<p>Førnavn:</p>
					   <input class='form-control'  type='text' name='fornavn'  value='' required/>
					</div>
				<div class='form-group col-md-6'>
					<p>Efternavn:</p>
					<input class=form-control type=text name=efternavn  value=' ' >
				</div>
				</div>
				
				<div class='form-row'>
				<div class='form-group col-md-6'>
					<p>Alder:</p>   
					 <input class='form-control' type='text' name='alder'  value=' ' >
				</div>
				<div class='form-group col-md-6'>
					<p>Email:</p>   
					<input class='form-control' type='email' name='email'  value=''>
				</div>
				</div>
				
				<div class='form-row'>
				<div class='form-group col-md-4'>
					<p>CPR nr.:</p> 
					 <input class='form-control' type='text' name='cpr'  value='' required/> 
				</div>
				<div class='form-group col-md-4'>
					<p>Køn:</p> 
					  <select class='form-control' name='gender'>
					     <option>Male</option>
					     <option>Female</option>
                      </select> 
				</div>
				<div class='form-group col-md-4'>
					<p>Tlf:</p>  
					 <input class='form-control'  type='tel'  name='tlf' value='' >  
				</div></div>
				

					<div class='form-row'>            
					<button class='btn btn-login float-right' type='submit' name='RegisterNewPatient' value='RegisterNewPatient' >Register ny patient</button>
					</div>
			
    </form>

</div>";
    }

    public function readCPR()
    {
        //select all data
        $connection = $this->dbConnect();
        $query = "SELECT `CPR` FROM `patient`" ;
        $stmt=mysqli_query($connection,$query);
        $result = mysqli_fetch_all($stmt,MYSQLI_ASSOC);

        foreach($stmt as $result)
        {   $crypt = new Encryption;
            $encodedcpr=$result['CPR'];
            $cpr = $crypt->encrypt_decrypt('decrypt',$encodedcpr);
            echo "<option >".$cpr."</option> ";
        }
    }

    public function readcategory()
    {
        //select all data
        $connection = $this->dbConnect();
        $query = "SELECT `picturekategori` FROM `picturekategori`" ;
        $stmt=mysqli_query($connection,$query);
        $result = mysqli_fetch_all($stmt,MYSQLI_ASSOC);

        foreach($stmt as $result)
        {
            echo "<option >".$result['picturekategori']."</option> ";
        }
    }

    public function readBehandlingsdato()
    {
        //select all data
        $connection = $this->dbConnect();
        $query = "SELECT `dato` FROM `behandling` " ;
        $stmt=mysqli_query($connection,$query);
        $result = mysqli_fetch_all($stmt,MYSQLI_ASSOC);

        foreach($stmt as $result)
        {
            echo "<option >".$result['dato']."</option> ";
        }
    }

    public function DisplaySearchResult($searchresult){

        echo 
        "<div >
            <table class='table'>
                
                <tr>
                <th>Fornavn</th>
                <th>Efternavn</th>
                <th>CPR nr.</th>
                <th>Email</th>
                <th></th>
                <th></th>
                </tr>
                ";
        foreach ($searchresult as $result) {
            $crypt = new Encryption;
            $encodedcpr=$result['CPR'];
            $decodedcpr = $crypt->encrypt_decrypt('decrypt',$encodedcpr);
            echo
                "<tr>
                    <td><input name='fornavn' value=' ". $result['fornavn'] ." '></td>
                    <td><input name='efternavn' value=' ". $result['efternavn'] ." '></td>
                    <td><input name='cpr' value=' ". $decodedcpr . " ' ></td>
                    <td><input name='email' value=' ". $result['email'] . " ' ></td>
                    <td>
                    <a name='SeeJournal' href='displayJournal.php?mode=ShowJournal&cpr=" . $result['CPR']. " '>
                    <button class='btn btn-link'  value='SeeJournal'>Se Journal</button>
                    </a>
                    </td>
                    <td>
                    <a name='OpretJournal' href='displayJournal.php?mode=OpretJournal&cpr=" . $result['CPR']. " '>
                    <button class='btn btn-link'  value='CreateJournal'>Opret Journal</button>
                    </a>
                    </td>
                </tr>";
        }
        echo "</table></div>";
    }

    public function AddPictureForm($cpr,$navn,$efternavn){
        echo "
        <form action='addPicture.php' method='post' enctype='multipart/form-data'>
        <h4>Tilføj billeder til:"." <strong style='color:#DE6262'>" .$navn ." ".$efternavn. "</strong> journal</h4>
            <div class='form-row'>
              CPR:
              <input type='text' name='cpr' class='form-control' value='" . $cpr . "' >
           </div><br>
             <div class='form-row'>
              Behandlingsdato:
             <br>
             <input type='date' name='dato' class='form-control' >
           </div><br>
          <div class='form-row'>
             Kategori:
                <select class='form-control' name='kategori'>";
        echo $this->readcategory();
        echo "</select>
              
           </div><br>
            <div class='form-row'>
           <div class='form-group col-md-4'>
              Tilføj file:
           </div>
              <div class='form-group col-md-4'>
              Billedstørrelse kan ændres med hensyn til:
              </div>
           <div class='form-group col-md-4'>
		     Angiv størrelsen i(px or %):
           </div>
           </div>
            <div class='form-row'>
            <div class='form-group col-md-4'>
              <input class='form-control' name='filetoupload' type='file'/>
           </div>
              <div class='form-group col-md-4'>
              <select class='form-control' name='resizetype'>
                 <option value='height'>Højden </option>
                 <option value='width'>Bredden</option>
                 <option value='Scale'>Skaleres i procent:</option>
               </select>
               </div>
           <div class='form-group col-md-4'>
	         <input type='number' name='size' value='' class='form-control'>
           </div>
           </div>
          
           <div class='form-row'>
              Title for Pictures: 
              <textarea name='title' class='form-control'></textarea>
	       </div><br>
	   
           <div class='form-row'>
                <button class='btn btn-login float-right' name='UploadImg' value='UploadImg'>
                      Upload
                  </button>
           </div><br>
  </table> 
</form>";
    }

    public function UpdateBehandlingForm($id){
        $connection = $this->dbConnect();
        $query = "select * from `behandling` WHERE `behandlingID`=?";
        $stmt = $connection->prepare($query);
        $stmt ->bind_param("i",$id);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=mysqli_fetch_array($result);
        $crypt = new Encryption;
        $encodedcpr=$row['CPR'];
        $cpr = $crypt->encrypt_decrypt('decrypt',$encodedcpr);
        echo "
        <form action='' method='post'>
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
              CPR:
              <select class='form-control' name='cpr'>
              <option>".$cpr."</option>";
        echo $this->readCPR();
        echo "</select>
           </tr><br>
             <tr>
              Behandlingsdato:<br>
              <input name='dato' type='date'  class='form-control' value='".$row['dato']."'>
           </tr><br>
        
           <tr>
              Behandlingsnavn:<br>
              <input name='behandlingname'  class='form-control' type='text' value='".$row['behandlingname']."'>
           </tr><br>
           <tr>
              Betaling:<br>
              <input name='betaling'  class='form-control' type='text' value='".$row['betaling']."'>
           </tr><br>
              
           <tr>
              Forklaring: <br>
	          <textarea name='description' class='form-control' row='10'>".$row['description']."</textarea>
	       </tr><br>
	   
           <tr>
                  <button onclick='return confirm(\"Er du sikker på at du vil opdatere denne behandling ? \") '
                     class='btn btn-login float-right ' name='UpdateBehandling' value='UpdateBehandling'>
                      Update
                  </button>
           </tr><br>
           </table>
</form> ";
    }

    public function UpdatePictureForm($id){
        $connection = $this->dbConnect();
        $query = "select * from `picture` WHERE `pictureID`=?";
        $stmt = $connection->prepare($query);
        $stmt ->bind_param("i",$id);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=mysqli_fetch_array($result);$crypt = new Encryption;
        $encodedcpr=$row['CPR'];
        $cpr = $crypt->encrypt_decrypt('decrypt',$encodedcpr);

        echo "
        <form action='' method='post'>
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
              CPR:
              <select class='form-control' name='cpr'>
              <option>".$cpr."</option>";
              echo $this->readCPR();
        echo "</select>
           </tr><br>
             <tr>
              Behandlingsdato:<br>
              <input name='dato' type='text'  class='form-control' value='".$row['dato']."'>
           </tr><br>
           <tr>
              Kategori:<br>
                <select class='form-control' name='kategori'>
                 <option>".$row['picturekategori']."</option>";
        echo $this->readcategory();
        echo "</select>
           </tr><br>
           <tr>
              Tilføj filer:<br>
              <img src='img/".$row['picture']."'></br></br>
           </tr><br>
           
           <tr>
             Title for Pictures:<br>
	          <input name='title' class='form-control' value='".$row['picturetitle']."'>
	       </tr><br>
           <tr>
           <button class='btn btn-login float-right' name='UpdateImg' value='UpdateImg'>
                      Update
                  </button>
                  <button class='btn btn-login float-right' 
                          onclick='return confirm(\"Er du sikker på at du vil slette denne billede?\") '
                          name='DeleteImg' value='DeleteImg'>
                      Slet billede
                  </button>
           </tr><br>
           </table>
</form> ";}

    public function DisplayCreateJournalForm($cpr,$navn,$efternavn){
    echo "
<div class='col-md-auto' style='min-width: 80%'>
    <form id='createJ' action='createJournal.php' method='post'>
        <h4>Opret journal til:"." " .$navn ." ".$efternavn."</h4>
        <table class='table table-hover table-responsive table-bordered'>
        <tr>
        CPR nummer: 
        <input type='text' name='cpr' class='form-control' value='" . $cpr . "'>  
        </tr>
            <br>
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
                <textarea type='text' name='description' class='form-control' id='exampleFormControlTextarea1' rows='10' ></textarea>
            </tr><br>

            <tr>
                Betaling
                <textarea name='betaling' class='form-control'></textarea>
            </tr><br>

            <tr>
                <button type='submit' name='CreateJournal' class='btn btn-login float-right'>Create Journal</button>
            </tr><br><br>

        </table><br>
    </form>

</div>";
}

    public function DisplayOpretKategoriForm(){
echo "
        <h4> Hvis du ikke kan finde den relevante kategori til billedet så opret den her: </h4>
<form id='createJ' action='addPicture.php' method='post'>

    <table class='table table-hover table-responsive table-bordered'>

        <tr class='lead font-weight-normal'>
        Kategori name
        <input name='kategori' class='form-control'>
        </tr><br>
        <tr>
                <button type='submit' name='CreateKategori' class='btn btn-login float-right'>Create ny kategori for billeder </button>
        </tr><br><br>

    </table><br>
</form>"  ;
    }

    public function UpdateProfileForm($cpr,$encoded,$navn,$efternavn,$email,$tel,$alder,$køn){
        echo "
<div class='col-md-auto' style='min-width: 80%'>
    <form id='createJ' action='createJournal.php?&cpr=".$encoded."' method='post'>
        <h4>Rediger profilen til:"." " .$navn ." ".$efternavn."</h4>

				<div class='form-row'>
				<div class='form-group col-md-6'>
				<p>Førnavn:</p>
					   <input class='form-control'  type='text' name='fornavn'  value='".$navn." ' required/>
					</div>
				<div class='form-group col-md-6'>
					<p>Efternavn:</p>
					<input class=form-control type=text name=efternavn  value='".$efternavn." ' >
				</div>
				</div>
				
				<div class='form-row'>
				<div class='form-group col-md-6'>
					<p>Alder:</p>   
					 <input class='form-control' type='text' name='alder'  value='".$alder." ' >
				</div>
				<div class='form-group col-md-6'>
					<p>Køn:</p> 
					  <select class='form-control' name='gender'>
					  <option>".$køn."</option>
					     <option>Male</option>
					     <option>Female</option>
                      </select> 
				</div>
				</div>
				
				<div class='form-row'>
				<div class='form-group col-md-4'>
					<p>CPR nr.:</p> 
					 <input class='form-control' type='text' name='newcpr'  value='".$cpr."'> 
				</div>
				<div class='form-group col-md-4'>
					<p>Email:</p>   
					<input class='form-control' type='email' name='email'  value='".$email." '>
				</div>
				<div class='form-group col-md-4'>
					<p>Tlf:</p>  
					 <input class='form-control'  type='tel'  name='tlf' value='".$tel." ' >  
				</div></div>
				

					<div class='form-row'>            
					<button class='btn btn-login float-right' type='submit' name='updatePatientProfile' value='updatePatientProfile' >Opdater profilen</button>
					</div>
			
    </form>

</div>";
    }


}