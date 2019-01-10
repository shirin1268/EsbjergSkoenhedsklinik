<?php
/**
 * Created by PhpStorm.
 * User: shirin1268
 * Date: 07-01-2019
 * Time: 19:55
 */

echo "
<div class='row'>
        <div class='col-sm-3'>
            <br/>
            <div class='btn-group-vertical'>
                <a href='displayJournal.php?mode=AddPicture&cpr=".$encoded."' class='btn btn-login'>
                    <span class='lead'> Tilføj Billede</span>
                </a>
                <br/>
                <a href='displayJournal.php?mode=OpretJournal&cpr=".$encoded."' class='btn btn-login'>
                    <span class='lead'>Tilføj Behandling</span>
                </a>
                <br/>
                <a href='UpdateJournal.php?mode=UpdateProfile&cpr=".$encoded."' class='btn btn-login'>
                    <span class='lead'>Rediger profilen</spanp>
                </a>
                <br/>
                <a href='displayJournal.php?mode=ShowJournal&cpr=" . $encoded. " ' class='btn btn-login'>
                    <span class='lead'>Se journal</span>
                </a>
                <br/>
                <a href='Pdfconvert.php?cpr=" . $encoded. "' target='_blank' class='btn btn-login'>
                    <span class='lead'>Vis/Download pdf</span>
                </a>
            </div>
        </div>

        <div class='col-md-9'>";