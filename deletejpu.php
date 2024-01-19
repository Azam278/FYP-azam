<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $courseID = $_GET['course_id'];
    $topicID = $_GET['topic_id'];

    // Check if the user is logged in
    if (isset($_SESSION['userid'])) {
        // Delete the mark associated with the course and topic
        $deleteMarkQuery = "DELETE FROM mark WHERE TID = '$topicID'";
        $deleteMarkResult = mysqli_query($conn, $deleteMarkQuery);

        // Check if the deletion of choices was successful
        if ($deleteMarkResult !== false) {
            // Delete the text answer question from the database
            $deleteQuery = "DELETE FROM topic WHERE CourseID = '$courseID' AND TID = '$topicID'";
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
                        window.location = 'jpu.php?action=edit&course_id=$courseID';
                    });
                }
                </script>";
            } else {
                echo "<script>alert('Error deleting topic.');</script> " . mysqli_error($conn);
            }
        } else {
            echo "<script>alert('Error deleting mark.');</script> " . mysqli_error($conn);
        }
    } else {
        echo "User not logged in.";
    }

?>