<?php
    include("conn.php");

    if (isset($_POST['dtLevel'])) {
        $dtLevel = $_POST['dtLevel'];

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT verb.V_Name FROM verb
                                INNER JOIN dt_verb ON verb.VID = dt_verb.VID
                                INNER JOIN domain_taxonomy ON dt_verb.DTID = domain_taxonomy.DTID
                                WHERE domain_taxonomy.DT_Level = ?");
        $stmt->bind_param("s", $dtLevel);
        $stmt->execute();

        // Fetch the results
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h3>Verbs for Domain Taxonomy Level: $dtLevel</h3>";
            echo "<table>";
            echo "<tr><th style='font:size: 16px;'>Verb</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td style='font:size: 20px;'>" . $row['V_Name'] . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No results found.";
        }

        // Close the database connection
        $stmt->close();
    }
?>