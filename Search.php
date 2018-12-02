<?php
include_once "Header.php";
include_once "menu.php";

$sh = new SearchHandler();

// get search term
$searchTerm=isset($_GET['s']) ? $_GET['s'] : '';

$page_title = "You searched for \"{$searchTerm}\"";

$searchresult = $sh->search($searchTerm);

if($searchresult>0){

    echo "<table class='table table-hover table-responsive table-bordered'>";
    echo "<tr>";
    echo "<th>Fornavn</th>";
    echo "<th>Efternavn</th>";
    echo "<th>CPR nr.</th>";
    echo "<th>Email</th>";
    echo "</tr>";

    foreach ($searchresult as $result){

        extract($searchresult);

        echo "<tr>
        <td>".$searchresult['fornavn'] ."</td>
        <td>".$searchresult['efternavn'] ."</td>
        <td>".$searchresult['CPR'] ."</td>
        <td>".$searchresult['email'] ."</td>

        <td>

        <button class='btn btn-info left-margin'>
        <span class='glyphicon glyphicon-edit'></span> Edit
        </button>
        </td>
        </tr>";

    }

    echo "</table>";
}

// tell the user there are no products
else{
    echo "<div class='alert alert-danger'>No products found.</div>";
}
?>