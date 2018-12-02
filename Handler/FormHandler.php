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

        echo '<h2>Registrer en ny Admin</h2>

			<form  action="" method="post" >
			    <table class="table table-hover table-responsive table-bordered">

				<tr >
					<b>Førnavn:</b>
					 <input class="form-control" id="exampleInputFornavn"  type="text" name="fornavn" required/>
				</tr><br>
				<tr>	     
					<b>Efternavn:</b>
					 <input type="text" name="efternavn" class="form-control" id="exampleInputEfternavn" required/>    
                </tr><br>
                <tr>
                	<b>Email:</b>
					<input type="email" name="email" placeholder="eksempl@domain.com"  class="form-control" id="exampleInputEmail">
				</tr> <br> 
				<tr>
					 <b>Brugernavn:</b>
					  <input type="text" name="username" class="form-control" id="exampleInputuser" required/>
				</tr><br>
				<tr>
					<b>Password:</b>
					<input class="form-control" id="exampleInputPassword1" type="password"  name="password" required>    
				</tr>  <br>  
				<tr>  
					<b>Adminpass:</b>
					<input class="form-control" id="exampleInputPassword1" type="password"  name="adminpass" required>
				</tr> <br>
				<tr>
					<button type="submit" class="btn btn-light" name="RegisterNewUser" value="RegisterNewUser" >Register</button>
				</tr>
			    </table>
			</form> ';

    }

    public function DisplayRegisterPatientForm(){

        echo '<h2>Registrer en ny kunde</h2>
<form action="" method="post" >
		<table class="table table-hover table-responsive table-bordered">
				
				<tr>
				<b>Førnavn:</b>
					   <input class="form-control" id="exampleInputEmail1" type="text" name="fornavn" maxlength="30" value="" required/>
					</tr><br>
				<tr>
					<b>Efternavn:</b>
					<input class="form-control" id="exampleInputEmail1" type="text" name="efternavn" maxlength="30" value="" >
				</tr><br>
				<tr>
					<b>Alder:</b>   
					 <input class="form-control" id="exampleInputEmail1" type="text" name="alder" maxlength="30" value="" >
				</tr><br>
				<tr>
					<b>Køn:</b>   
					 <input class="form-control" id="exampleInputEmail1" type="text" name="gender" maxlength="30" value="" />
				</tr><br>
				<tr>
					<b>CPR nr.:</b> 
					 <input class="form-control" id="exampleInputEmail1" type="text" name="cpr" placeholder="000000000000" maxlength="30" value="" required/> 
				</tr><br>
				<tr>
					<b>Email:</b>   
					<input class="form-control" id="exampleInputEmail1" type="email" name="email" placeholder="eksempl@domain.com" maxlength="30" value="">
				</tr><br>
				<tr>
					<b>Tlf:</b>  
					 <input class="form-control" id="exampleInputEmail1" type="tel" placeholder="telefone" name="tlf" >  
				</tr>
				<br>

					<tr>            
					<button class="btn btn-light" type="submit" name="RegisterNewPatient" value="RegisterNewPatient" > Register ny kunde</button>
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
            $cpr = $crypt->decode($encodedcpr);
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

    public function DisplaySearchForm(){

        echo "<form id='searchform' role='search' action='' method='post'>
        <div class='input-group mb-3'>" ;
        $searchValue=isset($searchTerm) ? "value='{$searchTerm}'" : "";
        echo "<input type='text' class='form-control' placeholder='Indtast venligst navn eller efternavn.' name='search' id='srch-term' required {$searchValue} />
        <div class='input-group-btn'>
        <button class='btn btn-primary' name='submitSearch' type='submit'><i class='fa fa-search'></i></button>
        </div>
        </div>
        </form>";
    }

    public function DisplaySearchResult($searchresult){

        echo "

<table class='table table-hover table-responsive table-bordered'>
        <tr>
        <th>Fornavn</th>
        <th>Efternavn</th>
        <th>CPR nr.</th>
        <th>Email</th>
        <th></th>
        </tr>";
                foreach ($searchresult as $result)
                {
                    $crypt = new Encryption;
                    $encodedcpr=$result['CPR'];
                    $decodedcpr = $crypt->decode($encodedcpr);
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
                </tr>";
                }
                echo "</table>

        ";
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
                <button class='btn btn-secondary left-margin' name='UploadImg' value='UploadImg'>
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
        $cpr = $crypt->decode($encodedcpr);
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
                     class='btn btn-secondary left-margin' name='UpdateBehandling' value='UpdateBehandling'>
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
        $cpr = $crypt->decode($encodedcpr);

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
           <button class='btn btn-secondary left-margin' name='UpdateImg' value='UpdateImg'>
                      Update
                  </button>
                  <button class='btn btn-secondary left-margin' 
                          onclick='return confirm(\"Er du sikker på at du vil slette denne billede?\") '
                          name='DeleteImg' value='DeleteImg'>
                      Slet billede
                  </button>
           </tr><br>
           </table>
</form> ";}



}