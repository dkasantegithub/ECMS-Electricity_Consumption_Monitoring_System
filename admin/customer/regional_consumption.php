<?php 
    //get connection to db
    include("../control/security.inc.php");

    // setting header to json
    header('Content-Type: application/json');
        
    try{
        // query to get data from table
        $query = $connection->prepare("SELECT customer.region, SUM(consumption.energy_consumed) AS total FROM customer JOIN consumption
                                        ON customer.customer_id=consumption.customer_id GROUP BY customer.region");
        $query->execute();
        // create an array of data
        $data = array();
        foreach($query as $result){
            // loop through the returned data
            $data[] = $result;
        }
    
    // free mermory associated with result
    // $result->NULL;

    // now print result
    print json_encode($data);
}catch(PDOException $e){
        header("Location:../error/error.php?show=dberror");
        error_log("customer_chart.php, SQL error=" .$e->getMessage());
        return;
    }
?>