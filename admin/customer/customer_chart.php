<?php 
    //get connection to db
    include("../control/security.inc.php");

    // setting header to json
    header('Content-Type: application/json');
        
    try{
        $cid = $_SESSION["cid"];
        // query to get data from table
        $query = $connection->prepare("SELECT * FROM consumption WHERE customer_id='$cid' ORDER BY id LIMIT 7");
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