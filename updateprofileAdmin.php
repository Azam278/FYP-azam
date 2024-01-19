<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    // Retrieve the submitted form data
    $userid = $_POST['userid'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $phonenumber = $_POST['phonenumber'];


    // Update the user's information in the database
    $updateQuery = "UPDATE administrator SET A_NAME = '$name', A_PASSWORD = '$password', A_PHNUMBER = '$phonenumber' WHERE ADMIN_ID = '$userid'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // Update successful
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Edited!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'profileAdmin.php';
                });
            }
        </script>";
    } else {
        // Update failed
        // $errorMessage = "Error updating profile: " . mysqli_error($conn);
        // echo $errorMessage;
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'profileAdmin.php';
                });
            }
            </script>";
    }
?>