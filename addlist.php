<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';	

    $coursename = $_POST["coursename"];
    $desc = $_POST["description"];
    $semster = $_POST['semester'];

    $sql = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPASSWORD='" . $_SESSION['password'] . "' "; 

    $result=$conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    $user=$row['Staff_ID'];

    $listQuery = "INSERT INTO jpu (CourseID, listDescription, Semester, Staff_ID) VALUES ('$coursename', '$desc', '$semster', '$user') ";

    if ($conn->query($listQuery) === TRUE){
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Added!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'jpulist.php';
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
                    window.location = 'jpulist.php';
                });
            }
            </script>";
    }

?>