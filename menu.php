<?php
$sh = new SearchHandler();
$fh = new FormHandler();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center" >
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
           <a class="nav-link active" href="createJournal.php">Opret journal</a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="addPicture.php"> Tilføj billeder </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="displayJournal.php"> Se journal </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="imageGalleri.php"> Se Album </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="http://www.google.com/calendar/event?action=TEMPLATE&text=Example%20Event&dates=20131124T010000Z/20131124T020000Z&details=Event%20Details%20Here&location=123%20Main%20St%2C%20Example%2C%20NY">Google Calender</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Log ud</a>
        </li>
    </ul>
                <br/>
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


