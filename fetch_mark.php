<?php
    
    session_start();
    include("conn.php");

    $tid = $_POST['tid'];
    $dtid = $_POST['dtid'];  

    $query = "SELECT Mark FROM mark WHERE TID = '$tid' AND DTID = '$dtid'";

    $result = mysqli_query($conn,$query);
    
    $mark_data = array();
    while($row = mysqli_fetch_assoc($result)){
        $mark_data[] = $row;
    }
    echo json_encode($mark_data);
?>

