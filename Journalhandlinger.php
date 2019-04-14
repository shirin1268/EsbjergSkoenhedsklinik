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
                     Tilføj Billede
                </a>
                <br/>
                <a href='displayJournal.php?mode=OpretJournal&cpr=".$encoded."' class='btn btn-login'>
                    Tilføj Behandling
                </a>
                <br/>
                <a href='UpdateJournal.php?mode=UpdateProfile&cpr=".$encoded."' class='btn btn-login'>
                    Rediger profilen
                </a>
                <br/>
                <a href='displayJournal.php?mode=ShowJournal&cpr=" . $encoded. " ' class='btn btn-login'>
                    Se journal
                </a>
                <br/>
                <a href='Pdfconvert.php?cpr=" . $encoded. "' target='_blank' class='btn btn-login'>
                    Vis/Download pdf
                </a>
            </div>
        </div>

        <div class='col-md-9'>";