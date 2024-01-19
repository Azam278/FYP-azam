<?php
    session_start();
    include("conn.php");

    $courseID = $_GET['course_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Start Sidebar-->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <?php
                $pageTitle = "Coordinator"; // Default page title
                
                if (isset($_SESSION['userid'])) {
                    $userid = $_SESSION['userid'];
                    
                    $query = "SELECT r.R_NAME FROM role r
                            JOIN users ad ON r.RID = ad.RID
                            WHERE ad.Staff_ID = '$userid'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $roleName = $row['R_NAME'];

                    switch ($roleName) {
                        case 'Coordinator':
                            $pageTitle = "Coordinator";
                            break;
                        case 'Educator':
                            $pageTitle = "Educator";
                            break;
                        // Add more cases for other roles if needed
                        default:
                            // Handle unrecognized roles or redirect to a default page
                            // You can set a default title or handle it as per your requirements
                            break;
                    }
                }
            ?>
            <h2 style="color: white; margin-top: 20px;">&nbsp; <?php echo $pageTitle; ?></h2>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <?php
                $homeLink = "";
                if (isset($_SESSION['userid'])) {
                    $userid = $_SESSION['userid'];
            
                    $query = "SELECT r.R_NAME FROM role r
                                JOIN users u ON r.RID = u.RID
                                WHERE u.Staff_ID = '$userid'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $roleName = $row['R_NAME'];
            
                    switch ($roleName) {
                        case 'Educator':
                            $homeLink = "userhome.php";
                            break;
                        case 'Evaluator':
                            $homeLink = "evaluatorpage.php";
                            break;
                        case 'Coordinator':
                                $homeLink = "userhome.php";
                                break;
                        default:
                            // Handle unrecognized roles or redirect to a default page
                            $homeLink = "login.php";
                            break;
                    }
                }
            ?>
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo $homeLink; ?>">Home</a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $homeLink; ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <?php
                // Check if the user is a Coordinator
                if ($roleName == 'Coordinator') {
                    echo '<a class="nav-link" href="jpulist.php">';
                            echo '<i class="fas fa-fw fa-chart-area"></i>';
                            echo '<span>JPU</span>
                        </a>';
                }
                ?>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="searchverb.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Search Verb</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="assessment.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Assessment</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="questionpaperlist.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Question</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar-->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <?php
                            // Check if the user is logged in and the userid is set in the session
                            // session_start();
                            if (isset($_SESSION['userid'])) {
                                $userid = $_SESSION['userid'];

                                // Fetch the user's name from the database based on the userid
                                $query = "SELECT StName FROM users WHERE Staff_ID = '$userid'";
                                // Execute the query and fetch the result
                                // Replace this with your database connection and query execution code
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);
                                $name = $row['StName'];

                                echo '
                                    <li class="nav-item dropdown no-arrow">
                                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg"> &nbsp;
                                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">' . $name . '</span>
                                        </a>
                                        <!-- Dropdown - User Information -->
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                            aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="profileUser.php">
                                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Profile
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Logout
                                            </a>
                                        </div>
                                    </li>
                                ';
                            }
                        ?>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Question Paper Details</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        
                        <div class="questioncontainer">
                            <div class="container">
                                <h2>Question Paper</h2>
                                <?php

                                    if (isset($_SESSION['userid'])) {
                                        // Get the user ID from the session
                                        $userId = $_SESSION['userid'];

                                        // Fetch data from the jpu table
                                        $query = "SELECT c.CourseName, a.AssessmentType, qp.generalDesc,qp.QPStatus
                                        FROM question_paper qp
                                        JOIN course c ON qp.CourseID = c.CourseID
                                        JOIN assessment a ON qp.AssessmentID = a.AssessmentID
                                        WHERE qp.Staff_ID = '$userId' AND c.CourseID = '$courseID'";;

                                        $result = mysqli_query($conn, $query);

                                        // Check if the query executed successfully
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            // Fetch the data
                                            $row = mysqli_fetch_assoc($result);
                                            $courseName = $row['CourseName'];
                                            $assessmentType = $row['AssessmentType'];
                                            $description = $row['generalDesc'];
                                            $status = $row['QPStatus'];

                                            // Display the data
                                            echo '<p><b>Course Name:</b> ' . $courseName . '</p>';
                                            echo '<p><b>Question Type:</b> ' . $assessmentType . '</p>';
                                            echo '<p><b>General Description:</b> ' . $description . '</p>';
                                            echo '<p><b>Status:</b> ' . $status . '</p>';
                                        } else {
                                            echo '<p>No data available.</p>';
                                        }
                                    } else {
                                        echo 'User not logged in.';
                                    }        
                                ?>
                            </div>
                            <div class="button-container">
                                <button onclick="document.getElementById('id05').style.display='block'" class="btn-addQuestion">Add Question</button>
                                <?php
                                    $href = "#";
                                    $buttonText = "Please Wait for Approval";
                                    if (isset($_SESSION['userid'])) {
                                        // Get the user ID from the session
                                        $userId = $_SESSION['userid'];

                                        // Retrieve question details from question_paper_list table
                                        $retrieveQuestionDetailsQuery = "SELECT qpl.QPLID, qpl.Question, qpl.Mark, qpl.Type, qpl.QPLStatus, qpl.QPLStatus2 
                                                                        FROM question_paper_list qpl
                                                                        WHERE qpl.Staff_ID = '$userId' AND CourseID = '$courseID'";

                                        $questionDetailsResult = mysqli_query($conn, $retrieveQuestionDetailsQuery);

                                        // Assume all questions are approved initially
                                        $allApproved = true;
                                        // If any question has the 'QPLStatus' as 'Pending', set $allApproved to false
                                        while ($row = mysqli_fetch_assoc($questionDetailsResult)) {
                                            if ($row['QPLStatus'] != 'Approved' && $row['QPLStatus2'] != 'Approved') {
                                                $allApproved = false;
                                                break;
                                            }
                                        }
                                        
                                        // If all questions are approved, change the button text and href
                                        if ($allApproved) {
                                            $href = "printpdfquestion.php?course_id=$courseID";
                                            $buttonText = "Generate Question";
                                        }
                                        // Reset result pointer to be able to use the result in the next loop
                                        mysqli_data_seek($questionDetailsResult, 0);
                                    }
                                    echo "<button class='btn-generatePDF'><a href='$href'>$buttonText</a></button>";
                                ?>
                                <button class='btn-generatePDF'><a href="scheme_answer.php?course_id=<?php echo $courseID; ?>">Answer Scheme(MCQ)</a></button>
                            </div>
                            <hr>
                            
                            <div id="id05" class="addQuestionForm">
                                <div class="container">
                                    <h2 style="text-align: center;">Add Question</h2>
                                    <div class="tab">
                                        <button class="tablinks" onclick="openTab(event, 'mcq')">MCQ</button>
                                        <button class="tablinks" onclick="openTab(event, 'subjective')">Subjective</button>
                                    </div>
                            
                                    <form action="addmcq.php?course_id=<?php echo $courseID; ?>" method="POST">
                                        <div id="mcq" class="tabcontent">
                                            <div class="mcqQuestion">
                                                <div class="mcqpartA">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="tid">Topic:</label>
                                                                <select class="form-control" name="tid" id="tid">
                                                                    <option hidden>Select Topic</option>
                                                                    <?php
                                                                        $query = "SELECT DISTINCT t.TID, t.T_Name FROM topic t
                                                                                JOIN mark m ON t.TID = m.TID
                                                                                WHERE m.CourseID = '$courseID'";
                                                                        
                                                                        $result = mysqli_query($conn, $query);

                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo '<option value="' . $row['TID'] . '">' . $row['T_Name'] . '</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="btid">Taxonomy:</label>
                                                                <select class="form-control" name="btid" id="btid">
                                                                    <option hidden>Select Level</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="verb">Action Verb:</label>
                                                                <select class="form-control" name="verb" id="verb">
                                                                    <option hidden>Select Verb</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <br>
                            
                                                    <label for="question">Question:</label><br>
                                                    <textarea style="height: 80px; width: 300px;" name="question" id="question" placeholder="Please Write Your Question"></textarea>
                                                    <br>

                                                    <label for="mark">Mark:</label>
                                                    <div id="mark-container">
                                                        <input type="text" name="mark" id="mark">
                                                    </div>
                                                    
                                                </div>
                            
                                                <div class="mcqpartB">
                                                    <label for="qtype">Type:</label>                                                                                              
                                                    <input type="text" name="qtypeMCQ" value="MCQ" disabled>
                                                    <input type="hidden" name="qtypeMCQ" value="1">                                                    

                                                    <br><br>
                            
                                                    <div id="options" class="row">
                                                        <label>Choices:</label>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text" name="options[]" id="option1" placeholder="Option 1">
                                                                    <input type="checkbox" name="answer[]" value="0">
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                        <br>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text" name="options[]" id="option2" placeholder="Option 2">
                                                                    <input type="checkbox" name="answer[]" value="1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="input-group">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text" name="options[]" id="option3" placeholder="Option 3">
                                                                    <input type="checkbox" name="answer[]" value="2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text" name="options[]" id="option4" placeholder="Option 4">
                                                                    <input type="checkbox" name="answer[]" value="3">
                                                                </div>
                                                            </div>
                                                        </div>                                                       
                                                    </div>                       
                                                </div>
                                                <div class="button-container">                                                    
                                                    <button type="button" onclick="document.getElementById('id05').style.display='none'" class="btn-cancel">Cancel</button>
                                                    <button type="submit" class="btn-add" value="submit">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                            
                                    <form action="addsubjective.php?course_id=<?php echo $courseID; ?>" method="POST">
                                        <div id="subjective" class="tabcontent">
                                            <div class="subjectiveQuestion">
                                                <div class="subjpartA">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="tid2">Topic:</label>
                                                                <select class="form-control" name="tid2" id="tid2">
                                                                    <option hidden>Select Topic</option>
                                                                    <?php
                                                                        $query = "SELECT DISTINCT t.TID, t.T_Name FROM topic t
                                                                                JOIN mark m ON t.TID = m.TID
                                                                                WHERE m.CourseID = '$courseID'";
                                                                        
                                                                        $result = mysqli_query($conn, $query);

                                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                                            echo '<option value="' . $row['TID'] . '">' . $row['T_Name'] . '</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="btid2">Taxonomy:</label>
                                                                <select class="form-control" name="btidDT" id="btid2">
                                                                    <option hidden>Select Level</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="verb">Action Verb:</label>
                                                                <select class="form-control" name="actionverb" id="verb2">
                                                                    <option hidden>Select Verb</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <br>
                            
                                                    <label for="questionPaper">Question:</label><br>
                                                    <textarea style="height: 80px; width: 200px;" name="questionPaper" id="question2" placeholder="Please Write Your Question"></textarea>
                            
                                                    <br>
                            
                                                    <label for="mark">Mark:</label>
                                                    <div id="mark-container2">
                                                        <input type="text" name="markText" id="markText">
                                                    </div>
                                                </div>
                                                <div class="subjpartB">

                                                    <label for="qtype">Type:</label>                                                                                              
                                                    <input type="text" name="qtypeSubjective" value="Subjective" disabled>
                                                    <input type="hidden" name="qtypeSubjective" value="2"> 
                            
                                                    <div id="textarea" class="row">
                                                        <label>Text Answer:</label><br>
                                                        <textarea name="textAnswer" id="textAnswer" rows="4" cols="40"></textarea>
                                                    </div>
                                                    <div class="button-container">
                                                        <button type="submit" class="btn-add" value="submit">Save</button>
                                                        <button type="button" onclick="document.getElementById('id05').style.display='none'" class="btn-cancel">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                    
                            <!-- End of Add Question Form -->

                            <table  class="filterType">
                                <tr>
                                    <td><b>Search By Question</b></td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for question.." title="Type in a name">
                                    </td>
                                </tr>
                            </table>                            

                            <br>
                            
                            <?php
                                if (isset($_SESSION['userid'])) {
                                    $userId = $_SESSION['userid'];
                                    if (isset($_GET['action']) && $_GET['action'] == 'edit') {
                                        // Retrieve question details from question_paper_list table
                                        $retrieveQuestionDetailsQuery = "SELECT qpl.QPLID, qpl.Question, qpl.Mark, qpl.Type, qpl.QPLStatus, qpl.QPLStatus2 
                                                                        FROM question_paper_list qpl
                                                                        WHERE qpl.Staff_ID = '$userId' AND qpl.CourseID = '$courseID'";

                                        $questionDetailsResult = mysqli_query($conn, $retrieveQuestionDetailsQuery);

                                        // Display question details in a table
                                        if (mysqli_num_rows($questionDetailsResult) > 0) {
                                            echo "<table class='table table-bordered table-striped' id='listTable'>
                                                    <tr>
                                                    <th>No</th>
                                                    <th>Question</th>
                                                    <th>Mark</th>
                                                    <th>Type</th>
                                                    <th>Status 1</th>
                                                    <th>Status 2</th>
                                                    <th class='actionCol' colspan='2'>Action</th>
                                                    </tr>";

                                            $counter = 1;

                                            while ($row = mysqli_fetch_assoc($questionDetailsResult)) {
                                                $qplID = $row['QPLID'];
                                                echo "<tr>";                                                
                                                echo "<td>". $counter. "</td>";
                                                echo "<td>" . $row['Question'] . "</td>";
                                                echo "<td>" . $row['Mark'] . "</td>";

                                                // Determine the type of the question
                                                $questionType = "";
                                                if ($row['Type'] == "1") {
                                                    $questionType = "MCQ";
                                                } elseif ($row['Type'] == "2") {
                                                    $questionType = "Subjective";
                                                }

                                                echo "<td>" . $questionType . "</td>";
                                                echo "<td>" . $row['QPLStatus'] . "</td>";
                                                echo "<td>" . $row['QPLStatus2'] . "</td>";

                                                if ($questionType == "MCQ") {
                                                    echo "<td class='text-center'><a class='btn btn-success' onclick=\"editMCQ($qplID, $courseID)\"><i class='bi bi-pen'> Edit</i></a></td>";
                                                    echo "<td class='text-center'><a class='btn btn-danger' onclick=\"deleteMCQ($qplID, $courseID)\"><i class='bi bi-trash3-fill'> Delete</i></a></td>";
                                                } elseif ($questionType == "Subjective") {
                                                    echo "<td class='text-center'><a class='btn btn-success' onclick=\"editSubjective($qplID, $courseID)\"><i class='bi bi-pen'> Edit</i></a></td>";
                                                    echo "<td class='text-center'><a class='btn btn-danger' onclick=\"deleteSubjective($qplID, $courseID)\"><i class='bi bi-trash3-fill'> Delete</i></a></td>";
                                                }
                                                echo "</tr>";
                                                
                                                $counter++;
                                            }
                                            echo "</table>";
                                        } else {
                                        echo "<p style='text-align: center; color: red;'>No question details found.</p>";
                                        }
                                    }
                                }
                            ?>
                            
                        </div>

                    </div>
                    <!-- Ending of Row -->
                </div>
            </div>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script>
        // Get the modal
        var modal = document.getElementById("id05");

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
        
        ClassicEditor
            .create( document.querySelector( '#question' ) )
            .catch( error => {
                console.error( error );
            } );

        ClassicEditor
            .create( document.querySelector( '#question2' ) )
            .catch( error => {
                console.error( error );
            } );

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        $(document).ready(function(){
            $('#tid').change(function(){
                var tid = $(this).val();
                $.ajax({
                    url: 'fetch_domain_taxonomy.php',
                    type: 'post',
                    data: {tid:tid},
                    dataType: 'json',
                    success:function(response){
                        var len = response.length;
                        $("#btid").empty();
                        for( var i = 0; i<len; i++){
                            var dtid = response[i]['DTID'];
                            var dt_level = response[i]['DT_Level'];
                            $("#btid").append("<option value='"+dtid+"'>"+dt_level+"</option>");
                        }
                    }
                });
            });
        });
       
        $(document).ready(function() {
            $('#btid').change(function() {
                var tid = $('#tid').val();
                var dtid = $(this).val();
                $.ajax({
                    url: 'fetch_mark.php',
                    type: 'post',
                    data: { tid: tid, dtid: dtid },
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.length > 0) {
                            var mark = response[0]['Mark']; // Assuming you want the first Mark value
                            $('#mark').val(mark);
                        } else {
                            // Handle the case when no Mark is returned
                            $('#mark').val(''); // Clear the field or provide a default value
                        }
                    },
                    error: function() {
                        // Handle AJAX error, if necessary
                        console.log('Error fetching Mark');
                    }
                });
            });
        });
       
       $(document).ready(function(){
            $('#tid2').change(function(){
                var tid = $(this).val();
                $.ajax({
                    url: 'fetch_domain_taxonomy.php',
                    type: 'post',
                    data: {tid:tid},
                    dataType: 'json',
                    success:function(response){
                        var len = response.length;
                        $("#btid2").empty();
                        for( var i = 0; i<len; i++){
                            var dtid = response[i]['DTID'];
                            var dt_level = response[i]['DT_Level'];
                            $("#btid2").append("<option value='"+dtid+"'>"+dt_level+"</option>");
                        }
                    }
                });
            });
        });               

        
        document.getElementById("btid").addEventListener("change", function() {
            var btid = this.value; // Get the selected DTID
            
            // Clear previous options from the action verb select
            var verbSelect = document.getElementById("verb");
            verbSelect.innerHTML = '<option hidden>Select Verb</option>';
            
            // Fetch the associated action verbs using AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var verbs = JSON.parse(this.responseText);
                    
                    // Add fetched action verbs to the select
                    for (var i = 0; i < verbs.length; i++) {
                        var option = document.createElement("option");
                        option.value = verbs[i].VID;
                        option.text = verbs[i].V_Name;
                        verbSelect.add(option);
                    }
                }
            };
            xhttp.open("GET", "get_action_verbs.php?btid=" + btid, true);
            xhttp.send();
        });

        
        document.getElementById("btid2").addEventListener("change", function() {
            var btid = this.value; // Get the selected DTID
            
            // Clear previous options from the action verb select
            var verbSelect = document.getElementById("verb2");
            verbSelect.innerHTML = '<option hidden>Select Verb</option>';
            
            // Fetch the associated action verbs using AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var verbs = JSON.parse(this.responseText);
                    
                    // Add fetched action verbs to the select
                    for (var i = 0; i < verbs.length; i++) {
                        var option = document.createElement("option");
                        option.value = verbs[i].VID;
                        option.text = verbs[i].V_Name;
                        verbSelect.add(option);
                    }
                }
            };
            xhttp.open("GET", "get_action_verbs.php?btid=" + btid, true);
            xhttp.send();
        });

        
        $(document).ready(function() {
            $('#btid2').change(function() {
                var tid = $('#tid2').val();
                var dtid = $(this).val();
                $.ajax({
                    url: 'fetch_mark.php',
                    type: 'post',
                    data: { tid: tid, dtid: dtid },
                    dataType: 'json',
                    success: function(response) {
                        if (response && response.length > 0) {
                            var mark = response[0]['Mark']; // Assuming you want the first Mark value
                            $('#markText').val(mark);
                        } else {
                            // Handle the case when no Mark is returned
                            $('#markText').val(''); // Clear the field or provide a default value
                        }
                    },
                    error: function() {
                        // Handle AJAX error, if necessary
                        console.log('Error fetching Mark');
                    }
                });
            });
        });

        var options = document.querySelectorAll('input[name="options[]"]');
        var answers = document.querySelectorAll('input[name="answer[]"]');
    
        options.forEach(function(option, index) {
            option.addEventListener('input', function() {
                answers[index].value = option.value;
            });
        });
                

        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("listTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
                }       
            }
        }

        function editMCQ(qplID, courseID) {
            window.location.href = "editmcq.php?qpl_id=" + qplID + "&course_id=" + courseID;
        }

        function deleteMCQ(qplID, courseID) {
            Swal.fire({
                title: 'Are you sure you want to delete this row?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "deletemcq.php?qpl_id=" + qplID + "&course_id=" + courseID;
                }
            });
        }

        function editSubjective(qplID, courseID) {
            window.location.href = "editsubjective.php?qpl_id=" + qplID + "&course_id=" + courseID;
        }

        function deleteSubjective(qplID, courseID) {
            Swal.fire({
                title: 'Are you sure you want to delete this row?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "deletesubjective.php?qpl_id=" + qplID + "&course_id=" + courseID;
                }
            });
        }

    </script>
    
</body>
</html>



