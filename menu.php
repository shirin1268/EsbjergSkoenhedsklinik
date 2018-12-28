<?php
$sh = new SearchHandler();
$fh = new FormHandler();
?>
<nav class="navbar navbar-expand-lg navbar-light" >
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link text-white" href="velkommen.php"><i class="fas fa-home"></i> Forside</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="imageGalleri.php"><i class="fas fa-images"></i> Se Album </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" target="_blank"
                   href="http://www.google.com/calendar/event?action=TEMPLATE&text=Example%20Event&dates=20131124T010000Z/20131124T020000Z&details=Event%20Details%20Here&location=123%20Main%20St%2C%20Example%2C%20NY">
                    <i class="fas fa-calendar-alt"></i> Google Calender</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Log ud</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" action="" method="post">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Søg patienten her" aria-label="Search" required>
            <button class="btn btn-outline-light my-2 my-sm-0" name="submitSearch" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</nav>

<br/>
<div class="row">
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
            


