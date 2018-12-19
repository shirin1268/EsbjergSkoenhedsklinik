<?php
$sh = new SearchHandler();
$fh = new FormHandler();
?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<nav class="navbar navbar-expand-lg navbar-light" >
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active">
           <a class="nav-link text-white" href="createJournal.php">Opret journal<span class="sr-only">(current)</span></a>
        </li>
            <li class="nav-item">
           <a class="nav-link text-white"  href="addPicture.php"> Tilføj billeder </a>
        </li>
            <li class="nav-item">
            <a class="nav-link text-white" href="displayJournal.php"> Se journal </a>
        </li>
            <li class="nav-item">
            <a class="nav-link text-white" href="imageGalleri.php"> Se Album </a>
        </li>
            <li class="nav-item">
            <a class="nav-link text-white" href="http://www.google.com/calendar/event?action=TEMPLATE&text=Example%20Event&dates=20131124T010000Z/20131124T020000Z&details=Event%20Details%20Here&location=123%20Main%20St%2C%20Example%2C%20NY">Google Calender</a>
        </li>
            <li class="nav-item">
            <a class="nav-link text-white" href="logout.php">Log ud</a>
        </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="" method="post">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search" required>
            <button class="btn btn-outline-light my-2 my-sm-0" name="submitSearch" type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</nav>

<br/>

<div class="col">
<?php
    if (isset($_POST['submitSearch'])) {
        $searchTerm= $_POST['search'];
        $sh->search($searchTerm);
        $min_length = 2;

        if(strlen($searchTerm) >= $min_length) {
            $searchTerm = htmlspecialchars($searchTerm);
            $searchresult = $sh->search($searchTerm);

            //var_dump($searchresult);
            if (sizeof($searchresult) > 0) {
                $fh->DisplaySearchResult($searchresult);
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
                    No entry found
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" id="alert" role="alert">
                No entry found
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
        }
    }
?>
            


