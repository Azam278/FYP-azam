<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    // Retrieve the selected options
    $coursename = $_POST['coursename'];
    $clo1 = $_POST["clo1"];
    $desc1 = $_POST["dsc1"];
    $clo2 = $_POST["clo2"];
    $desc2 = $_POST["dsc2"];
    $clo3 = $_POST["clo3"];
    $desc3 = $_POST["dsc3"];


    $sql = "SELECT * FROM administrator WHERE ADMIN_ID='" . $_SESSION['userid'] . "' AND A_PASSWORD='" . $_SESSION['password'] . "' "; 

    $result=$conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    $user=$row['ADMIN_ID'];

    $query = "INSERT INTO course(CourseName, ADMIN_ID) VALUES ('$coursename', '$user')";

    if ($conn->query($query) === TRUE){
        $courseID = mysqli_insert_id($conn);

        $clo1Query = "INSERT INTO clo (C_Level, C_Desc, CourseID, ADMIN_ID) VALUES ('$clo1', '$desc1', '$courseID','$user')";

        if ($conn->query($clo1Query) === TRUE) {
                // Insert clo2 into "clo" table
            $clo2Query = "INSERT INTO clo (C_Level, C_Desc, CourseID, ADMIN_ID) VALUES ('$clo2', '$desc2', '$courseID', '$user')";
    
            if ($conn->query($clo2Query) === TRUE) {
                $clo3Query = "INSERT INTO clo (C_Level, C_Desc, CourseID, ADMIN_ID) VALUES ('$clo3', '$desc3', '$courseID', '$user')";
    
                if ($conn->query($clo3Query) === TRUE) {
                    echo "<script>
                        window.onload = function() {
                            Swal.fire({
                                position: 'top',
                                icon: 'success',
                                title: 'Successfully Added!',
                                showConfirmButton: false,
                                timer: 2000
                              }).then(function() {
                                window.location = 'course.php';
                            });
                        }
                    </script>";
                }
            } 
        } else {
            // echo "Error : ".$clo1Query."<br>";
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'course.php';
                });
            }
            </script>";
        }
    }
?>
