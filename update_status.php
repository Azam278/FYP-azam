<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    if (isset($_POST['selected'])) {
        $selected = $_POST['selected'];
        $status = isset($_POST['approve']) ? 'Approved' : 'Not Approved';
        $userid = $_SESSION['userid'];
    
        // Check if the user is EV1 or EV2 and set the statusColumn accordingly
        // $statusColumn = ($_SESSION['EV1'] == $userid) ? 'QPLStatus' : 'QPLStatus2';

        if ($userid == $_SESSION['EV1']) {
            $statusColumn = 'QPLStatus';
        } elseif ($userid == $_SESSION['EV2']) {
            $statusColumn = 'QPLStatus2';
        }
    
        echo "User ID: " . $_SESSION['userid'] . "<br>";
        echo "Status Column: " . $statusColumn . "<br>";
    
        foreach ($selected as $id) {
            $query = "UPDATE question_paper_list SET $statusColumn = '$status' WHERE QPLID = $id";
            $result = $conn->query($query);
    
            if (!$result) {
                echo 'Error updating status: ' . mysqli_error($conn);
            }
        }
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successful!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'pending.php';
                });
            }
        </script>";
    }
    
?>
