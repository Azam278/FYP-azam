<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    // Retrieve the selected options
    $domaintaxonomyid = $_POST['btid'];
    $actionverbid = $_POST['vid'];

    $sql = "SELECT * FROM administrator WHERE ADMIN_ID='" . $_SESSION['userid'] . "' AND A_PASSWORD='" . $_SESSION['password'] . "' "; 

    $result=$conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    $user=$row['ADMIN_ID'];

    $query = "INSERT INTO dt_verb(DTID, VID, ADMIN_ID) VALUES ('$domaintaxonomyid','$actionverbid', '$user')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
                window.onload = function() {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Successfully Added!',
                        showConfirmButton: false,
                        timer: 2000
                      });
                      setTimeout(function() {
                        window.location = 'btverb.php';
                      }, 2000);
                }
            </script>";
    }
    else {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  });
                  setTimeout(function() {
                    window.location = 'btverb.php';
                  }, 2000);
            }
            </script>";
    }


?>
