<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';	

    $actverb = $_POST["actverb"];

    $sql = "SELECT * FROM administrator WHERE ADMIN_ID='" . $_SESSION['userid'] . "' AND A_PASSWORD='" . $_SESSION['password'] . "' "; 

    $result=$conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    $user=$row['ADMIN_ID'];

    $sqlinsert = "INSERT INTO verb (V_Name, ADMIN_ID) VALUES ('$actverb','$user')" 
    or die ("Error inserting data into table");

    if ($conn->query($sqlinsert)) {
        echo "<script>
        window.onload = function() {
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'Successfully Added!',
                showConfirmButton: false,
                timer: 2000
              }).then(function() {
                window.location = 'actionverb.php';
            });
        }
        </script>";      
    } else {
        // echo "Error: ".$sqlinsert."<br>";
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'actionverb.php';
                });
            }
            </script>";
    }
    $conn->close();
?>