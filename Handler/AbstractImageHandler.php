<?php

/**
 * Created by PhpStorm.
 * User: shirin1268
 * Date: 15-11-2018
 * Time: 09:28

abstract class AbstractImageHandler extends ServerHandler
{


    private $target_dir = "img/";
    public $uploadOk = 1;


    public function setImageFileType($file)
    {
        $imageFileType = pathinfo($this->target_dir, PATHINFO_EXTENSION);
        return $imageFileType;
    }




}

*/