<?php
    session_start();
    include("conn.php");

    // Get the VID from the AJAX request
    $vid = $_POST['vid'];

    // Fetch the data for the selected verb
    $query = "SELECT dtv.DTVID, v.V_Name, dt.DTID, dt.DT_Level
            FROM verb v
            INNER JOIN dt_verb dtv ON v.VID = dtv.VID
            INNER JOIN domain_taxonomy dt ON dtv.DTID = dt.DTID
            WHERE v.VID = $vid";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table table-bordered">';
        echo '<tr>';
        echo '<th>Select</th>';
        echo '<th>Action Verb</th>';
        echo '<th>Domain Taxonomy</th>';
        echo '</tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td><input type="checkbox" value="' . $row['DTVID'] . '"></td>';
            echo '<td>' . $row['V_Name'] . '</td>';
            echo '<td>' . $row['DT_Level'] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>No items found.</p>';
    }

    mysqli_close($conn);
?>
