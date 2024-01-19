<?php
    // Assuming you have a database connection established in the "conn.php" file
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $assessmentID = $_GET['assessment_id'];
    $assessmentType = $_POST["assessmentType"];
    $percentage = $_POST["Percent"];

    // Perform the update operation in the database
    // Modify the following code according to your table structure and update logic
    $query = "UPDATE assessment SET AssessmentType = '$assessmentType', Percent = '$percentage'
              WHERE AssessmentID = '$assessmentID'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Edited!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'assessment.php';
                });
            }
        </script>";
    } else {
        // echo "Error occurred while updating assessment.";
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'assessment.php';
                });
            }
            </script>";
    }

    // Close the database connection
    mysqli_close($conn);
?>
