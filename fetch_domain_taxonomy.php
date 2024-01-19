<?php
    session_start();
    include("conn.php");

    $tid = $_POST['tid']; 

    $query = "SELECT dt.DTID, dt.DT_Level FROM domain_taxonomy dt
              JOIN mark m ON dt.DTID = m.DTID
              WHERE m.TID = '$tid'";

    $result = mysqli_query($conn,$query);
    
    $domain_taxonomy_data = array();
    while($row = mysqli_fetch_assoc($result)){
        $domain_taxonomy_data[] = $row;
    }
    echo json_encode($domain_taxonomy_data);
?>
