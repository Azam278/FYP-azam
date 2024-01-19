<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';  

    $courseID = $_GET['course_id'];

    $tid = $_POST["tid"];
    $btid = $_POST["btid"];
    $verb = $_POST["verb"];
    $question = $_POST["question"];
    $mark = $_POST["mark"];
    $qtypeOptions = $_POST["qtypeMCQ"];
    $qplStatus = "pending";
    $qplStatus2 = "pending";
    $answers = isset($_POST["answer"]) ? $_POST["answer"] : []; // Check if 'answer' is set

    // Check if all required fields are filled
    if (empty($tid) || empty($btid) || empty($verb) || empty($question) || empty($mark) || empty($qtypeOptions) || empty($answers)) {
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all the fields!'
                  }).then(function() {
                    window.location = 'qpdetails.php?action=edit&course_id=$courseID';
                });
            }
            </script>";
        exit;
    }

    $sql = "SELECT * FROM users WHERE Staff_ID='" . $_SESSION['userid'] . "' AND StPASSWORD='" . $_SESSION['password'] . "' ";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);

    $user = $row['Staff_ID'];

    // Insert into choice table based on the question type
    
    $insertQuestionList = "INSERT INTO question_paper_list (TID, DTID, VID, Question, Mark, Type, QPLStatus, QPLStatus2, CourseID, Staff_ID)
                        VALUES ('$tid', '$btid', '$verb', '$question', '$mark', '$qtypeOptions', '$qplStatus','$qplStatus2','$courseID', '$user')";
        
    if (mysqli_query($conn, $insertQuestionList)){

        $qplId = mysqli_insert_id($conn);

        $options = $_POST["options"];

        foreach ($options as $index => $option) {
            $insertChoiceQuery = "INSERT INTO choice (QPLID, ChoiceText) VALUES ('$qplId', '$option')";
            mysqli_query($conn, $insertChoiceQuery);

            // If this option is an answer, insert it into the answer table
            if (in_array($option, $answers)) {
                $choiceId = mysqli_insert_id($conn);
                $insertAnswerQuery = "INSERT INTO answer (CourseID, QPLID, ChoiceID, Ans_Schema) VALUES ('$courseID', '$qplId', '$choiceId', '$option')";
                mysqli_query($conn, $insertAnswerQuery);
            }
        }

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
    } else {
        // echo "Error: " . mysqli_error($conn);
        echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'qpdetails.php?action=edit&course_id=$courseID';
                });
            }
            </script>";
    }
    exit();
?>
