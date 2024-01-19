<?php
    session_start();
    include("conn.php");
    
    // echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    // Check if the form is submitted
        $courseID = $_GET['course_id'];

        $tid2 = $_POST["tid2"];
        $btidDT = $_POST["btidDT"];
        $actionverb = $_POST["actionverb"];
        $questionPaper = $_POST["questionPaper"];
        $markText = $_POST["markText"];
        $qtypeText = $_POST["qtypeSubjective"];
        $qplStatus = "pending";
        $qplStatus2 = "pending";

        $sql = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPASSWORD='" . $_SESSION['password'] . "' ";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);

        $user = $row['Staff_ID'];

        // Insert into the question_paper_list table for Subjective
        $insertQuestionListQuery = "INSERT INTO question_paper_list (TID, DTID, VID, Question, Mark, Type, QPLStatus, QPLStatus2, CourseID, Staff_ID) VALUES ('$tid2', '$btidDT', '$actionverb', '$questionPaper', '$markText', '$qtypeText', '$qplStatus', '$qplStatus2', '$courseID', '$user')";

        if (mysqli_query($conn, $insertQuestionListQuery)) {
            $qplId = mysqli_insert_id($conn);
            $textAnswer = $_POST["textAnswer"];

            // Insert the text answer into the choice table
            $insertTextQuery = "INSERT INTO choice (QPLID, ChoiceText) VALUES ('$qplId', '$textAnswer')";
            mysqli_query($conn, $insertTextQuery);

            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Successfully Added!',
                        showConfirmButton: false,
                        timer: 2000
                      }).then(function() {
                        window.location = 'qpdetails.php?action=edit&course_id=$courseID';
                    });
                }
            </script>";
            exit();
        } else {
            // echo "Error: " . mysqli_error($conn);
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'aqpdetails.php?action=edit&course_id=$courseID';
                });
            }
            </script>";
        }
    ?>