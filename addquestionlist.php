<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $courseId = $_POST["coursename"];
    $questiontype = $_POST["questiontype"];
    $questiondesc = $_POST["questiondesc"];

    if (empty($courseId) || empty($questiontype) || empty($questiondesc)) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all the fields!'
                  }).then(function() {
                    window.location = 'assessment.php';
                });
            }
            </script>";
        exit;
    }

    $sql = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPASSWORD='" . $_SESSION['password'] . "'"; 

    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    $user = $row['Staff_ID'];

    $qpQuery = "INSERT INTO question_paper (CourseID, AssessmentID, generalDesc, Staff_ID) VALUES ('$courseId', '$questiontype', '$questiondesc', '$user') ";

    if ($conn->query($qpQuery) === TRUE){
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Added!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'questionpaperlist.php';
                });
            }
            </script>";
    } else {
        // echo "Error : ".$sqlinsert."<br>";
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'questionpaperlist.php';
                });
            }
            </script>";
    }
?>