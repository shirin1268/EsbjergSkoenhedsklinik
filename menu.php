<?php
$sh = new SearchHandler();
$fh = new FormHandler();
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<nav class="nav-extended" >
    <div class="nav-wrapper">
        <div class="nav-content">
    <ul class="tabs tabs-transparent">
        <li class="tab">
           <a class="text-white" href="createJournal.php">Opret journal</a>
        </li>
        <li class="tab">
           <a class="text-white"  href="addPicture.php"> Tilføj billeder </a>
        </li>
        <li class="tab">
            <a class="text-white" href="displayJournal.php"> Se journal </a>
        </li>
        <li class="tab">
            <a class="text-white" href="imageGalleri.php"> Se Album </a>
        </li>
        <li class="tab">
            <a class="text-white" href="http://www.google.com/calendar/event?action=TEMPLATE&text=Example%20Event&dates=20131124T010000Z/20131124T020000Z&details=Event%20Details%20Here&location=123%20Main%20St%2C%20Example%2C%20NY">Google Calender</a>
        </li>
        <li class="tab">
            <a class="text-white" href="logout.php">Log ud</a>
        </li>
    </ul>
            </div>
                <br/>
        </div>
        </nav>
<br/>
        <div class="col">
            <?php

            $fh->DisplaySearchForm();
            if (isset($_POST['submitSearch']))
            {
                $searchTerm= $_POST['search'];
                $sh->search($searchTerm);
                $min_length = 2;

                if(strlen($searchTerm) >= $min_length) {

                    $searchTerm = htmlspecialchars($searchTerm);
                    $searchresult = $sh->search($searchTerm);

                    if ($searchresult > 0) {

                        $fh->DisplaySearchResult($searchresult);
                    }
                }
// tell the user there are no patient
                else{
                    echo "<div class='alert alert-danger'>No one found.</div>";
                }

            }
            ?>


