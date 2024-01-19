<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $courseId = $_POST["coursename"];
    $assessmentType = $_POST["assessmentType"];
    $percentage = $_POST["percentage"];
    $selectedClos = isset($_POST["clo"]) ? $_POST["clo"] : []; // Check if 'clo' is set

    // Check if all required fields are filled
    if (empty($courseId) || empty($assessmentType) || empty($percentage) || empty($selectedClos)) {
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

    // Insert assessment record into the database
    $insertQuery = "INSERT INTO assessment (CourseID, AssessmentType, Percent, Staff_ID) VALUES ('$courseId', '$assessmentType', '$percentage', '$user')";
    mysqli_query($conn, $insertQuery);

    // Get the ID of the inserted assessment record
    $assessmentId = mysqli_insert_id($conn);

    // Insert selected CLOs into the database
    foreach ($selectedClos as $cloId) {
        $insertCloQuery = "INSERT INTO assessment_clo (AssessmentID, CID) VALUES ('$assessmentId', '$cloId')";
        mysqli_query($conn, $insertCloQuery);
    }

    echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Added!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'assessment.php';
                });
            }
        </script>";
    exit;
?>
