<?php
session_start();
include("conn.php");

// Get the array of DTVID values from the POST request
$dtvids = $_POST['dtvids'];

// Ensure that the array is not empty
if (!empty($dtvids)) {
    // Convert the array of DTVID values to a comma-separated string
    $dtvidsString = implode(',', $dtvids);

    // Create the SQL DELETE query
    $query = "DELETE FROM dt_verb WHERE DTVID IN ($dtvidsString)";

    // Execute the DELETE query
    $result = mysqli_query($conn, $query);

    // Check if the deletion was successful
    if ($result) {
        // Send a success response
        echo json_encode(array('status' => 'success'));
    } else {
        // Send an error response
        echo json_encode(array('status' => 'error'));
    }
} else {
    echo json_encode(array('status' => 'no_selection'));
}

// Close the database connection
mysqli_close($conn);
?>
