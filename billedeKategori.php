<?php
/**
 * Created by PhpStorm.
 * User: shirin1268
 * Date: 08-01-2019
 * Time: 18:50
 */

// set page headers
$page_title = "Create Picture category";
include_once "Header.php";
include_once "menu.php";
$jh = new JournalHandler();
$pa = new PatientAccountHandler();
$fh =new FormHandler();
$encrypt= new Encryption();


$fh->DisplayOpretKategoriForm();


include_once "footer.php";
?>