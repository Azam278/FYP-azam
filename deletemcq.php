<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $qplID = $_GET['qpl_id'];
    $courseID = $_GET['course_id'];

    // Check if the user is logged in
    if (isset($_SESSION['userid'])) {
        // Delete the choices associated with the question
        $deleteAnswerQuery = "DELETE FROM answer WHERE QPLID = '$qplID'";
        $deleteAnswerResult = mysqli_query($conn, $deleteAnswerQuery);

        // Check if the deletion of choices was successful
        if ($deleteAnswerResult !== false) {
            // Delete the answer associated with the question
            $deleteChoiceQuery = "DELETE FROM choice WHERE QPLID = '$qplID'";
            $deleteChoiceResult = mysqli_query($conn, $deleteChoiceQuery);

            // Check if the deletion of answer was successful
            if ($deleteChoiceResult !== false) {
                // Delete the question from the database
                $deleteQuery = "DELETE FROM question_paper_list WHERE QPLID = '$qplID' AND Type = '1'";
                $deleteResult = mysqli_query($conn, $deleteQuery);

                if ($deleteResult) {
                    echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Successfully Deleted!',
                            showConfirmButton: false,
                            timer: 2000
                          }).then(function() {
                            window.location = 'qpdetails.php?action=edit&course_id=$courseID';
                        });
                    }
                    </script>";
                } else {
                    echo "Error deleting question: " . mysqli_error($conn);
                }
            } else {
                echo "Error deleting answer: " . mysqli_error($conn);
            }
        } else {
            echo "Error deleting choices: " . mysqli_error($conn);
        }
    } else {
        echo "User not logged in.";
    }
?>
