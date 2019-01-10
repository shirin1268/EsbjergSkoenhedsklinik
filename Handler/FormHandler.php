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
            <h4>Det er resultatet af din søgning: </h4>
            <br>
            <table class='table table-striped' style='border: 1px solid #dee2e6'>
            <thead>
                <tr>
                    <th>Fornavn</th>
                    <th>Efternavn</th>
                    <th>CPR nr.</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";

        foreach ($searchresult as $result) {
            $crypt = new Encryption;
            $encodedcpr=$result['CPR'];
            $decodedcpr = $crypt->encrypt_decrypt('decrypt',$encodedcpr);
            echo
                "<tr>
                    <td>
                        <input class='form-control' name='fornavn' value='". $result['fornavn'] ."' disabled>
                    </td>
                    <td>
                        <input class='form-control' name='efternavn' value='". $result['efternavn'] ."' disabled>
                    </td>
                    <td>
                        <input class='form-control' name='cpr' value='". $decodedcpr . "' disabled>
                    </td>
                    <td>
                        <a name='mailto' href='mailto:".$result['email']."'>
                            <button class='btn btn-info' title='Write an E-Mail'>". $result['email'] ."</button>
                        </a>
                    </td>
                    <td>
                        <a name='SeeJournal' href='displayJournal.php?mode=ShowJournal&cpr=" . $result['CPR']. " '>
                            <button class='btn btn-login' title='Se profil'>Se patient profil</button>
                        </a>
                    </td>
                </tr>";
        }

        echo 
                "</tbody>
            </table>
        <br>
        <hr>
        </div>";
    }

    public function AddPictureForm($cpr,$navn,$efternavn){
        echo "
        <form action='addPicture.php' method='post' enctype='multipart/form-data'>
        <h4>Tilføj billeder til:"." <strong style='color:#17a2b8'>" .$navn ." ".$efternavn. "</strong> journal</h4><br>
            <div class='form-row'>
            <div class='form-group col-md-4'>
              CPR:
              <input type='text' name='cpr' class='form-control' value='" . $cpr . "' >
           </div><br>
             <div class='form-group col-md-4'>
              Behandlingsdato:
             <br>
             <input type='date' name='dato' class='form-control' >
           </div><br>
          <div class='form-group col-md-4'>
             Billedekategori:
                <select class='form-control' name='kategori'>";
        echo $this->readcategory();
        echo "</select>
              </div>
           </div><br>
            <div class='form-row'>
           <div class='form-group col-md-4'>
              Tilføj file:
           </div>
              <div class='form-group col-md-4'>
              Billedstørrelsen kan ændres med hensyn til:
              </div>
           <div class='form-group col-md-4'>
		     Angiv størrelsen (i pixel eller i procent):
           </div>
           </div>
            <div class='form-row'>
            <div class='form-group col-md-4'>
              <input class='form-control' name='filetoupload' type='file'/>
           </div>
              <div class='form-group col-md-4'>
              <select class='form-control' name='resizetype'>
                 <option value='height'>Højden (str. skal angives i pixel) </option>
                 <option value='width'>Bredden (str. skal angives i pixel)</option>
                 <option value='Scale'>Skaleres (str. skal angives i procent)</option>
               </select>
               </div>
           <div class='form-group col-md-4'>
	         <input type='number' name='size' value='' placeholder='f.eks. 200 eller 0,5' class='form-control'>
           </div>
           </div>
          <br>
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
        $encoded=$row['CPR'];
        $cpr = $crypt->encrypt_decrypt('decrypt',$encoded);
        echo "
        <form action='' method='post'>
        <h5>Opdater behandlingen til patienten med CPR-nr: <strong style='color:#DE6262'>". $cpr."</strong></h5><br>
        <div class='form-row'>
            <div class='form-group col-md-3'>
              CPR:
              <input type='text'  class='form-control' name='patientcpr' value='". $cpr."'>
           </div><br>
             <div class='form-group col-md-3'>
              Behandlingsdato:<br>
              <input name='dato' type='date'  class='form-control' value='".$row['dato']."'>
           </div><br>
        
           <div class='form-group col-md-3'>
              Behandlingsnavn:<br>
              <input name='behandlingname'  class='form-control' type='text' value='".$row['behandlingname']."'>
           </div><br>
           <div class='form-group col-md-3'>
              Betaling:<br>
              <input name='betaling'  class='form-control' type='text' value='".$row['betaling']."'>
           </div></div><br>
              
           <div class='form-row'>
            
              Forklaring: <br>
	          <textarea name='description' class='form-control' row='10'>".$row['description']."</textarea>
	       </div><br>
	   
           <div class='form-row'>
          
                  <button onclick='return confirm(\"Er du sikker på at du vil opdatere denne behandling ? \") '
                     class='btn btn-login float-right ' name='UpdateBehandling' value='UpdateBehandling'>
                      Update
                  </button>
           </div><br>
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
<h5>Opdater billedetsoplysninger her eller slet billedet</h5><br>
        <form action='' method='post'>
            <div class='form-row'>
            <div class='form-group col-md-4'>
              CPR:
              <input type='text'  class='form-control' name='cpr' value='". $cpr."'>
           </div><br>
             <div class='form-group col-md-4'>
              Behandlingsdato:<br>
              <input name='dato' type='text'  class='form-control' value='".$row['dato']."'>
           </div><br>
           <div class='form-group col-md-4'>
              Kategori:<br>
                <select class='form-control' name='kategori'>
                 <option>".$row['picturekategori']."</option>";
        echo $this->readcategory();
        echo "</select>
           </div></div><br>
           <div class='form-row'>
            <div class='form-group col-md-6'>
              <br>
              <img src='img/".$row['picture']."'></br></br>
           </div><br>
           
           <div class='form-group col-md-6'>
             Title for Pictures:<br>
	          <input name='title' class='form-control' value='".$row['picturetitle']."'>
	       </div></div><br>
           <div class='form-row'>
           <div class='form-group col-md-3'>
           <button class='btn btn-login' name='UpdateImg' value='UpdateImg'>
                      Opdater oplysninger
                  </button></div>
                  <div class='form-group col-md-2'>
                  <button class='btn btn-login' 
                          onclick='return confirm(\"Er du sikker på at du vil slette denne billede?\") '
                          name='DeleteImg' value='DeleteImg'>
                      Slet billede
                  </button></div>
           </div><br>
          
</form> ";}

    public function DisplayCreateJournalForm($cpr,$navn,$efternavn){
    echo "

    <form id='createJ' action='createJournal.php' method='post'>
        <h4>Opret journal til:"."<strong style='color:#17a2b8'> " .$navn ." ".$efternavn."</strong></h4>
        <div class='form-row'>
            <div class='form-group col-md-4'>
        CPR nummer: 
        <input type='text' name='cpr' class='form-control' value='" . $cpr . "'>  
        </div>
             <div class='form-group col-md-4'>
                Behandlingsdato:
                
                <input type='date' name='dato' class='form-control' >
            </div>
            </div>
            <div class='form-row'>
             <div class='form-group col-md-4'>
                Behandlingsnavn:
                <input type='text' name='behandlingname' class='form-control' />
            </div>
<div class='form-group col-md-4'>
                Betaling
                <input type='text' name='betaling' class='form-control'>
            </div>
            </div>
             <div class='form-row'>
                Beskrivelse af behandlingen:
                <textarea type='text' name='description' class='form-control' id='exampleFormControlTextarea1' rows='10' ></textarea>
            </div><br>
            <div class='form-row'>
                <button type='submit' name='CreateJournal' class='btn btn-login float-right'>Opret journal</button>
            </div>
    </form>
";
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
        <h4>Rediger profilen til:"."<strong style='color:#17a2b8'> " .$navn ." ".$efternavn."</strong> </h4>

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