<?php 
session_start();
include("conn.php");

echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';	

$courseID = $_GET['course_id'];

$topicname = $_POST["topicname"];
$cloID = $_POST["clo"];

$domainlevel1 = $_POST["dt1"];
$domainlevel2 = $_POST["dt2"];
$domainlevel3 = $_POST["dt3"];
$domainlevel4 = $_POST["dt4"];
$domainlevel5 = $_POST["dt5"];
$domainlevel6 = $_POST["dt6"];

$mark1 = $_POST["mark1"];
$mark2 = $_POST["mark2"];
$mark3 = $_POST["mark3"];
$mark4 = $_POST["mark4"];
$mark5 = $_POST["mark5"];
$mark6 = $_POST["mark6"];

$sql = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPASSWORD='" . $_SESSION['password'] . "' "; 

$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

$user = $row['Staff_ID'];

$topicQuery = "INSERT INTO topic (T_Name, CourseID, Staff_ID) VALUES ('$topicname', '$courseID','$user')";

if ($conn->query($topicQuery) === TRUE) {
    $topicID = mysqli_insert_id($conn); // Retrieve the auto-generated TID

    $mark1Query = "INSERT INTO mark (Mark, DTID, TID, CID, CourseID, Staff_ID) VALUES ('$mark1', '$domainlevel1', '$topicID', '$cloID', '$courseID', '$user')";

    if ($conn->query($mark1Query) === TRUE) {
        $mark2Query = "INSERT INTO mark (Mark, DTID, TID, CID, CourseID, Staff_ID) VALUES ('$mark2', '$domainlevel2', '$topicID', '$cloID', '$courseID', '$user')";

        if ($conn->query($mark2Query) === TRUE) {
            $mark3Query = "INSERT INTO mark (Mark, DTID, TID, CID, CourseID, Staff_ID) VALUES ('$mark3', '$domainlevel3', '$topicID', '$cloID', '$courseID', '$user')";

            if ($conn->query($mark3Query) === TRUE) {
                $mark4Query = "INSERT INTO mark (Mark, DTID, TID, CID, CourseID, Staff_ID) VALUES ('$mark4', '$domainlevel4', '$topicID', '$cloID', '$courseID', '$user')";

                if ($conn->query($mark4Query) === TRUE) {
                    $mark5Query = "INSERT INTO mark (Mark, DTID, TID, CID, CourseID, Staff_ID) VALUES ('$mark5', '$domainlevel5', '$topicID', '$cloID', '$courseID', '$user')";

                    if ($conn->query($mark5Query) === TRUE) {
                        $mark6Query = "INSERT INTO mark (Mark, DTID, TID, CID, CourseID, Staff_ID) VALUES ('$mark6', '$domainlevel6', '$topicID', '$cloID', '$courseID', '$user')";

                        if ($conn->query($mark6Query) === TRUE) {

                            echo "<script>
                                window.onload = function() {
                                    Swal.fire({
                                        position: 'top',
                                        icon: 'success',
                                        title: 'Successfully Added!',
                                        showConfirmButton: false,
                                        timer: 2000
                                      }).then(function() {
                                        window.location = 'jpu.php?action=edit&course_id=$courseID';
                                    });
                                }
                                </script>";                            
                        } else {
                            echo "Error inserting mark 6: ";
                        }
                    } else {
                        echo "Error inserting mark 5: ";
                    }
                } else {
                    echo "Error inserting mark 4: ";
                }
            } else {
                echo "Error inserting mark 3: ";
            }
        } else {
            echo "Error inserting mark 2: ";
        }
    } else {
        // echo "Error" . mysqli_error($conn);
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'jpu.php?action=edit&course_id=$courseID';
                });
            }
            </script>";
    }
}
?>