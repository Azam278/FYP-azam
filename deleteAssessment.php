<!-- Delete Assessment -->
<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $assessmentID = $_GET['assessment_id'];

    // Check if the user is logged in
    if (isset($_SESSION['userid'])) {
        // Delete the choices associated with the question
        $deleteQuery = "DELETE FROM assessment_clo WHERE AssessmentID = '$assessmentID'";
        $deleteResult = mysqli_query($conn, $deleteQuery);

        // Check if the deletion of choices was successful
        if ($deleteResult !== false) {
            // Delete the text answer question from the database
            $deleteAssessmentQuery = "DELETE FROM assessment WHERE AssessmentID = '$assessmentID'";
            $deleteAssessmentResult = mysqli_query($conn, $deleteAssessmentQuery);

            if ($deleteAssessmentResult) {
                echo "<script>
                window.onload = function() {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Successfully Deleted!',
                        showConfirmButton: false,
                        timer: 2000
                      }).then(function() {
                        window.location = 'assessment.php';
                    });
                }
                </script>";
            } else {
                echo "Error deleting question: " . mysqli_error($conn);
            }
        } else {
            echo "Error deleting choices: " . mysqli_error($conn);
        }
    } else {
        echo "User not logged in.";
    }
?>

