<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    if (isset($_POST['selected'])) {
        $selected = $_POST['selected'];

        $stmt = $conn->prepare("UPDATE course SET EV1 = ?, EV2 = ? WHERE CourseID = ?");
        $stmt->bind_param("ssi", $assign, $assign2, $id);

        foreach ($selected as $id) {
            $assign = $_POST['evaluator1'][$id];
            $assign2 = $_POST['evaluator2'][$id];
            $stmt->execute();

            if ($stmt->error) {
                // echo 'Error updating status: ' . $stmt->error;
                echo "<script>
                    echo 'Error updating status: ' . $stmt->error;
                    window.onload = function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please try again.!'
                        }).then(function() {
                            window.location = 'assignEv.php';
                        });
                    }
                    </script>";
            }
        }
        $stmt->close();

        echo "<script>
            window.onload = function() {              
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Assign!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location = 'assignEv.php';
                });
            }
        </script>";
    }
?>
