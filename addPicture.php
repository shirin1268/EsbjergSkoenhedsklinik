<?php
$page_title = "Add Image";
include_once "Header.php";
include_once "menu.php";

$fh = new FormHandler();
$sh = new ServerHandler();
$imgh = new ImageResizer();



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
            $previous_page="displayJournal.php?mode=ShowJournal&cpr=" . $cpr;
           if( $imgh->UploadPicture($iName, $kategoriname, $cpr, $dato, $title)==true){

            array_push($upmsg, "image uploaded!");

        }else{array_push($upmsg, "no file selected!");}}

}

foreach($upmsg as $msg){
    echo "<div class='alert alert-secondary'>".$msg. "<a href=". htmlspecialchars($previous_page). ">  Return</a></div>";
}


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


include_once "footer.php";
?>