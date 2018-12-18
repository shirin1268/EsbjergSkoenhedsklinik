<?php
$page_title = "Add Image";
include_once "Header.php";
include_once "menu.php";

$fh = new FormHandler();
$sh = new ServerHandler();
$imgh = new ImageResizer();
?>
<h4 class="lead font-weight-normal"> Hvis du ikke kan finde den relevante kategori til billedet så opret den her: </h4>
<form id="createJ" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

    <table class='table table-hover table-responsive table-bordered'>

        <tr class="lead font-weight-normal">
           Kategori name
                <input name="kategori" class='form-control'>
        </tr><br>
        <tr>
                <button type="submit" name="CreateKategori" class="btn btn-login float-right">Create ny kategori for billeder </button>
        </tr><br><br>

    </table><br>
</form>


<?php
if (isset($_POST['CreateKategori']))
{
    if(
    !empty($_POST["kategori"])
    )
    {
        $connection= $sh ->dbConnect();
        $kategori = ValidateHandler::validinput($_POST["kategori"],$connection);

        if($imgh->createImgKategori($kategori)==true){
            echo "<div class='alert alert-success'>New category was created.</div>";
        }
        else{
            echo "<div class='alert alert-danger'>Unable to create new category.</div>";
        }
    }
}
?>
<h4 class="lead font-weight-normal"> Tilføj billede via denne form</h4>
<?php
$fh->AddPictureForm();
define("MAX_SIZE" , "30000");
$upmsg = array();
if(isset($_POST['UploadImg'])) {

        if($_FILES['filetoupload']['name']){
            $imagename = $_FILES['filetoupload']['name'];
            $file = $_FILES['filetoupload']['tmp_name'];
            $image_type = getimagesize($file);
            if($image_type[2]==2 || $image_type[2]==3 || $image_type[2]==4){
                $size = filesize($file);
                if($size<MAX_SIZE*1024){
                    $prefix = uniqid();
                    $iName = $prefix."_".$imagename;
                    $newname = "img/".$iName;

                    $imgh = new ImageResizer();
                    $imgh->load($file);
                    if($_POST['resizetype']=="width"){
                        $width = $_POST['size'];
                        $imgh->resizeToWidth(trim($width));
                        array_push($upmsg, "Image resized to $width px wide");
                    }elseif ($_POST['resizetype']=="height"){
                        $height = $_POST['size'];
                        $imgh->resizeToHeight(trim($height));
                        array_push($upmsg, "Image resized to $height px high");
                    }elseif ($_POST['resizetype']=="scale"){
                        $scale = $_POST['size'];
                        $imgh->scale(trim($scale));
                        array_push($upmsg,"image scaled to $scale %");
                    }
                }else{array_push($upmsg,"image to big! max 30mb");}
            }else{array_push($upmsg,"wrong filetype!");}

            $imgh->save($newname);
            $connection = $sh->dbConnect();
            $kategoriname = ValidateHandler::validinput($_POST['kategori'], $connection);

            $encrypt = new Encryption();
            $cpr = $encrypt->encrypt_decrypt('encrypt',$_POST['cpr']);
            $dato=$_POST['dato'];
            $title = ValidateHandler::validinput($_POST['title'], $connection);
           if( $imgh->UploadPicture($iName, $kategoriname, $cpr, $dato, $title)==true){

            array_push($upmsg, "image uploaded!");

        }else{array_push($upmsg, "no file selected!");}}

}

foreach($upmsg as $msg){
    echo "<div class='alert alert-secondary'>$msg</div>";
}


include_once "footer.php";
?>