<?php
    session_start();
    include("conn.php");

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    if (isset($_GET['btid'])) {
        $btid = $_GET['btid'];

        $query = "SELECT v.VID, v.V_Name
        FROM verb v
        INNER JOIN dt_verb dtv ON v.VID = dtv.VID
        INNER JOIN domain_taxonomy dt ON dtv.DTID = dt.DTID
        WHERE dt.DTID = $btid";


        $result = mysqli_query($conn, $query);
        
        $verbs = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $verbs[] = $row;
        }
        
        echo json_encode($verbs);
    }
?>
