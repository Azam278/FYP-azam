<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    if (!isset($_SESSION['submit'])) {
        $_SESSION['userid'] = $_POST['userid'];
        $_SESSION['password'] = $_POST['password'];
    }

    $sql = "SELECT * FROM administrator WHERE ADMIN_ID='" . $_SESSION['userid'] . "' AND A_PASSWORD='" . $_SESSION['password'] . "' AND RID='1'"; // track super admin

    $sql2 = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPassword='" . $_SESSION['password'] . "' AND RID='2'"; // track educators

    $sql3 = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPassword='" . $_SESSION['password'] . "' AND RID='3'"; // track evaluators

    $sql4 = "SELECT * FROM administrator WHERE ADMIN_ID='" . $_SESSION['userid'] . "' AND A_PASSWORD='" . $_SESSION['password'] . "' AND RID='4'"; // track committee

    $sql5 = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPassword='" . $_SESSION['password'] . "' AND RID='5'"; // track coordinator

    $resultCommittee = $conn->query($sql4);

    if ($resultCommittee->num_rows == 1) {
        $row = $resultCommittee->fetch_assoc();
        $storedPassword = $row["A_PASSWORD"];
        
        if ($_SESSION['password'] == $storedPassword) {
            // Check if the password needs to be changed
            if ($_SESSION['password'] == "admin123") {
                // Store the username in session
                $_SESSION['userid'] = $_POST['userid'];
                // Redirect to change password page
                header("Location: change_password.php");
                exit();
            }
        } else {
            echo "<script>alert('Invalid Password.')</script>";
        }
    }

    $resultCoordinator = $conn->query($sql5);

    if ($resultCoordinator->num_rows == 1) {
        $row = $resultCoordinator->fetch_assoc();
        $storedPassword = $row["StPassword"];
        
        if ($_SESSION['password'] == $storedPassword) {
            // Check if the password needs to be changed
            if ($_SESSION['password'] == "coordinate12") {
                // Store the username in session
                $_SESSION['userid'] = $_POST['userid'];
                // Redirect to change password page
                header("Location: change_password.php");
                exit();
            }
        } else {
            echo "<script>alert('Invalid Password.')</script>";
        }
    }

    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
    $result4 = $conn->query($sql4);
    $result5 = $conn->query($sql5);

    if ($result === false || $result2 === false || $result3 === false || $result4 === false || $result5 === false) {
        // Display the MySQL error message
        echo "<script>alert('Error.')</script>";
    } else {
        if ($result->num_rows > 0) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Login!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'adminhome.php';
                });
            }
            </script>";
        } elseif ($result2->num_rows > 0) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Login!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'userhome.php';
                });
            }
            </script>";
        } elseif ($result3->num_rows > 0) {
            while ($row = $result3->fetch_assoc()) {
                $sqlEv = "SELECT * FROM course WHERE EV1='" . $_SESSION['userid'] . "' OR EV2='" . $_SESSION['userid'] . "'";
                $resultEv = $conn->query($sqlEv);
                if ($resultEv->num_rows > 0) {
                    while ($row2 = $resultEv->fetch_assoc()) {
                        if ($row2['EV1'] == $_SESSION['userid']) {
                            $_SESSION['EV1'] = $_POST['userid'];
                            $_SESSION['EV2'] = '';
                        } else {
                            $_SESSION['EV1'] = '';
                            $_SESSION['EV2'] = $_POST['userid'];
                        }
                    }
                }
            }        
            echo "<script>
                    window.onload = function() {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: 'Successfully Login!',
                            showConfirmButton: false,
                            timer: 2000
                          }).then(function() {
                            window.location = 'evaluatorpage.php';
                        });
                    }
                  </script>";
        } elseif ($result4->num_rows > 0) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Login!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'adminhome.php';
                });
            }
            </script>";
        } elseif ($result5->num_rows > 0) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Login!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'userhome.php';
                });
            }
            </script>";
        } else {        
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Invalid ID or Password. Please try again.!'
                  }).then(function() {
                    window.location = 'login.php';
                });
            }
            </script>";
        }
    }

    $conn->close();
?>
