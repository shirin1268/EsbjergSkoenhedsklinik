<?php


class ImageResizer extends ServerHandler
{
    protected $image;
    protected $image_type;

    public function load($filename){
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG){
            $this->image = imagecreatefromjpeg($filename);
        }elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        }elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }
    public function save($filename,
                         $image_type = IMAGETYPE_JPEG,
                         $compression = 100){
        if($image_type == IMAGETYPE_JPEG){
            imagejpeg($this->image, $filename, $compression);
        }elseif ($image_type==IMAGETYPE_GIF){
            imagegif($this->image,$filename);
        }elseif ($image_type==IMAGETYPE_PNG){
            imagepng($this->image,$filename);
        }
    }
    protected function getWidth()
    {
        return imagesx($this->image);
    }

    public function resizeToWidth($width)
    {
        $ratio = $width/$this->getWidth();
        $height = $this->getHeight()*$ratio;
        $this->resize($width,$height);
    }

    protected function getHeight()
    {
        return imagesy($this->image);
    }

    public function resizeToHeight($height)
    {
        $ratio = $height/$this->getHeight();
        $width = $this->getWidth()*$ratio;
        $this->resize($width,$height);
    }

    public function scale($scale)
    {
        $width = $this->getWidth()*$scale/100;
        $height = $this->getHeight()*$scale/100;
        $this->resize($width,$height);
    }

    public function resize($width, $height)
    {

        $new_image = imagecreatetruecolor($width, $height);

        imagecopyresampled($new_image,$this->image,0,0,0,0,
            $width,$height,$this->getWidth(),$this->getHeight());
        $this->image = $new_image;


    }

    public function createImgKategori($kategori){
        $connection=$this->dbConnect();

        $query="INSERT INTO `picturekategori`(`picturekategori`) VALUES (?)";

        $stmt = $connection->prepare($query);
        $stmt-> bind_param("s",$kategori);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function UploadPicture($iName,$kategoriname,$cpr,$dato,$title)
    {
        $connection=$this->dbConnect();

        $query="INSERT INTO `picture`( `picture`, `picturekategori`, `CPR`, `dato`, `picturetitle`)
        VALUES (?,?,?,?,?)";
        $stmt = $connection->prepare($query);
        $stmt-> bind_param("sssss",$iName,$kategoriname,$cpr,$dato,$title);
        if($stmt->execute()){

            return true;
        }else{
            return false;
        }
    }

    public function DeletePicture($id)
    {
        $connection=$this->dbConnect();
        $query="DELETE FROM `picture` WHERE `pictureID`='$id'";
        $stmt=$connection->prepare($query);
        $stmt->execute();
        $result=$stmt->get_result();
    }

    public function OpenImageGallery()
    {
        $connection = $this->dbConnect();
        $sql="SELECT * FROM `picture`";
        $stmt=$connection->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=mysqli_fetch_all($result,MYSQLI_ASSOC);

        return $row;
        // echo "<img src='img/".$row[0]['picture']."' >";
       // echo "<img src='img/".$row[1]['picture']."' >";
        //echo "<img src='img/".$row[2]['picture']."' >";
        //echo "<img src='img/".$row[3]['picture']."' >";
        //echo "<img src='img/".$row[4]['picture']."' >";
    }
    public function ImageSlider()
    {

    }

}