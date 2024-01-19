<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $userid = $_POST['userid'];
    $password = "admin123";
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phnumber = $_POST['phnumber'];
    $role = $_POST['role'];

    if ($role == 4) { 
        $insertQuery = "INSERT INTO administrator (ADMIN_ID, A_PASSWORD, A_NAME, A_GENDER, A_PHNUMBER, RID) VALUES ('$userid','$password','$name','$gender','$phnumber','$role')";
    } else {
        echo "Error!!! Please Try again";
    }
    $result = mysqli_query($conn, $insertQuery);

    // Check if the query was successful
    if ($result) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Register!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'admin.php';
                });
            }
            </script>";
    } else {
        // echo "Error: " . mysqli_error($conn);
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'admin.php';
                });
            }
            </script>";
    }

    // Close the database connection
    //mysqli_close($connection);
?>