<?php

class SearchHandler extends ServerHandler
{

    public function search($searchTerm)
    {
        $connection = $this->dbConnect();
        // select query
        $query = "SELECT * FROM patient WHERE 
                  fornavn LIKE '%$searchTerm%' 
                  OR efternavn LIKE '%$searchTerm%' 
             /*  OR CPR LIKE '%$searchTerm%' */
                  ORDER BY CPR ASC ";

        $stmt = $connection->prepare($query);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=mysqli_fetch_all($result,MYSQLI_ASSOC);
        return $row;
    }


}