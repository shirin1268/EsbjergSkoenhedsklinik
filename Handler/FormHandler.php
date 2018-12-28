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

        echo '<p class="display-4">Registrer en ny Admin</p>

			<form  action="" method="post" >
			    <table class="table table-hover table-responsive table-bordered">

				<tr >
					<p class="lead">Førnavn:</p>
					 <input class="form-control" id="exampleInputFornavn"  type="text" name="fornavn" required/>
				</tr><br>
				<tr>	     
					<p class="lead">Efternavn:</p>
					 <input type="text" name="efternavn" class="form-control" id="exampleInputEfternavn" required/>    
                </tr><br>
                <tr>
                	<p class="lead">Email:</p>
					<input type="email" name="email" placeholder="eksempl@domain.com"  class="form-control" id="exampleInputEmail">
				</tr> <br> 
				<tr>
					 <p class="lead">Brugernavn:</p>
					  <input type="text" name="username" class="form-control" id="exampleInputuser" required/>
				</tr><br>
				<tr>
					<p class="lead">Password:</p>
					<input class="form-control" id="exampleInputPassword1" type="password"  name="password" required>    
				</tr>  <br>  
				<tr>  
					<p class="lead">Admin level:</p>
					<input class="form-control" id="exampleInputPassword1" type="password"  name="adminpass" required>
				</tr> <br>
				<tr>
					<button type="submit" class="btn btn-login float-right" name="RegisterNewUser" value="RegisterNewUser" >Register</button>
				</tr>
			    </table>
			</form> ';

    }

    public function DisplayRegisterPatientForm(){

        echo '<p class="display-4">Registrer en ny kunde</p>
<form action="" method="post" >
		<table class="table table-hover table-responsive table-bordered">
				
				<tr>
				<p class="lead">Førnavn:</p>
					   <input class="form-control" id="exampleInputEmail1" type="text" name="fornavn" maxlength="30" value="" required/>
					</tr><br>
				<tr>
					<p class="lead">Efternavn:</p>
					<input class="form-control" id="exampleInputEmail1" type="text" name="efternavn" maxlength="30" value="" >
				</tr><br>
				<tr>
					<p class="lead">Alder:</p>   
					 <input class="form-control" id="exampleInputEmail1" type="text" name="alder" maxlength="30" value="" >
				</tr><br>
				<tr>
					<p class="lead">Køn:</p>   
					 <input class="form-control" id="exampleInputEmail1" type="text" name="gender" maxlength="30" value="" />
				</tr><br>
				<tr>
					<p class="lead">CPR nr.:</p> 
					 <input class="form-control" id="exampleInputEmail1" type="text" name="cpr" placeholder="000000000000" maxlength="30" value="" required/> 
				</tr><br>
				<tr>
					<p class="lead">Email:</p>   
					<input class="form-control" id="exampleInputEmail1" type="email" name="email" placeholder="eksempl@domain.com" maxlength="30" value="">
				</tr><br>
				<tr>
					<p class="lead">Tlf:</p>  
					 <input class="form-control" id="exampleInputEmail1" type="tel" placeholder="telefone" name="tlf" >  
				</tr>
				<br>

					<tr>            
					<button class="btn btn-login float-right" type="submit" name="RegisterNewPatient" value="RegisterNewPatient" > Register ny kunde</button>
					</tr>
		</table>		
		
</form> ';
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
        "<div class='table-responsive'>
            <table class='table table-bordered'>
                
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

    public function AddPictureForm(){
        echo "
        <form action='addPicture.php' method='post' enctype='multipart/form-data'>
       <table class='table table-hover table-responsive table-bordered'>
            <tr>
              CPR:
              <select class='form-control' name='cpr'>";
        echo $this->readCPR();
        echo "</select>
           </tr><br>
             <tr>
              Behandlingsdato:
             <br>
             <input type='date' name='dato' class='form-control' >
           </tr><br>
           <tr>
             Kategori:
                <select class='form-control' name='kategori'>";
        echo $this->readcategory();
        echo "</select>
              
           </tr><br>
           <tr>
              Tilføj filer:<br>
              <input name='filetoupload' type='file'/>
           </tr><br>
              <tr><br>
              Resize to:<br> 
              <select class='browser-default' name='resizetype'>
                 <option value='height'>Height</option>
                 <option value='width'>Width</option>
                 <option value='Scale'>Scale</option>
               </select>
           </tr><br><br>
           <tr>
		     Size (px or %):<br>
	         <input type='number' name='size' value='' class='validate'>
           </tr><br><br>
           <tr>
              Title for Pictures: 
              <textarea name='title' class='form-control'></textarea>
	       </tr><br>
	   
           <tr>
                <button class='btn btn-login float-right' name='UploadImg' value='UploadImg'>
                      Upload
                  </button>
           </tr><br>
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


}