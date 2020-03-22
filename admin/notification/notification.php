<?php 
include("../control/security.inc.php");
include("../control/control.inc.php");
include("../includes/header.php"); 
// include("../includes/navbar.php"); 
?>


<?php
    try{
        $oldstatus = 0;
        $newstatus = 1;
        $state = $connection->prepare("UPDATE notifications SET status='$newstatus' WHERE status='$oldstatus'");
        $state->execute();

    }catch(PDOException $e){
        header("Location:../error/error.php?show=dberror");
        error_log("meter.php, SQL error=" .$e->getMessage());
        return;
    }
//     $sql = $connection->prepare("SELECT * FROM notifications ORDER BY nid DESC LIMIT 5");
//     $sql->execute();

// $response='';

//     if($sql->rowCount() > 0){}
//     while($row = $sql->fetch()) {
//         $response = $response . "<div class='notification-item'>" .
//         "<div class='notification-subject'>". $row["subject"] . "</div>" . 
//         "<div class='notification-comment'>" . $row["comment"]  . "</div>" .
//         "</div>";
//     }
//     if(!empty($response)) {
//         print $response;
//     }

?>