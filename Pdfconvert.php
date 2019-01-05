<?php
$page_title = "Pdf generator";
require_once "Toploader.php";
require('Handler/FPDF/fpdf.php');
spl_autoload_register(function ($class) {
    include 'Handler/' . $class . '.php';
});

$jh = new JournalHandler();
$crypt = new Encryption;
$pdf = new FPDF();

$encoded = trim($_GET['cpr']) ;
$patient = $jh->displaypatientname($encoded);
$tel= $patient["tlf"];
$email = $patient["email"];
$alder= $patient["alder"];
$cpr = $crypt->encrypt_decrypt('decrypt', $encoded);

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->ChapterBody('CPR-nr : '.$cpr,'Alder: '.$alder);
$pdf->ChapterBody( 'email: '.$email, 'Tel: '.$tel);

$behandlinger = $jh->displayJournal($encoded);
if($behandlinger>0) {
    $cpr = $crypt->encrypt_decrypt('decrypt', $encoded);
    foreach ($behandlinger as $behandling) {

        $pdf->PrintChapter($behandling['dato'],$behandling['behandlingname'], $behandling['description'],'Betaling: '.$behandling['betaling']);

    }

    $pictures = $jh->displayPictures($encoded);
    if ($pictures > 0)
    {foreach ($pictures as $image)
    {
        $pdf->PrintChapter('Billedets oplysninger',$image['picturekategori'],$image['dato'], $image['picturetitle']);
        $pdf->Image('img/'.$image['picture'] );
        $pdf->Ln();



}}}$pdf->Output();
