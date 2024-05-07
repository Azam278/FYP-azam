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

    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="css/style.css">
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Start Sidebar-->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion hide-on-print" id="accordionSidebar">
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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow hide-on-print">

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
                        <h1 class="h3 mb-0 text-gray-800 hide-on-print">Print Question to PDF</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        
                        <div class="pdfcontainerQuestion">
                            <div class="button-container">
                                <button onclick="window.print()" class="btn-generatePDF hide-on-print">Generate PDF</button>
                            </div>
                            <div class="container">
                                <?php
                                    if (isset($_SESSION['userid'])) {
                                        // Get the user ID from the session
                                        $userId = $_SESSION['userid'];

                                        // Fetch data from the jpu table
                                        $query = "SELECT c.CourseName, a.AssessmentType, qp.generalDesc
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

                                            // Display the data
                                            echo '<p><b>Course Name:</b> ' . $courseName . '</p>';
                                            echo '<p><b>Question Type:</b> ' . $assessmentType . '</p>';
                                            echo '<p><b>General Description:</b> ' . $description . '</p>';
                                        } else {
                                            echo '<p>No data available.</p>';
                                        }
                                    } else {
                                        echo 'User not logged in.';
                                    }        
                                ?>
                            </div>
                            <div class="container">
                                <?php
                                    if (isset($_SESSION['userid'])) {
                                        // Get the user ID from the session
                                        $userId = $_SESSION['userid'];

                                        // Retrieve question details from question_paper_list table
                                        $retrieveQuestionDetailsQuery = "SELECT qpl.QPLID, qpl.Question, qpl.Type, ch.ChoiceText 
                                                                        FROM question_paper_list qpl
                                                                        JOIN choice ch ON qpl.QPLID = ch.QPLID
                                                                        WHERE qpl.Staff_ID = '$userId' AND qpl.CourseID = '$courseID'";

                                        $result = mysqli_query($conn, $retrieveQuestionDetailsQuery);

                                        $currentQuestionID = null;
                                        $questionNumber = 1;

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            // Check if the question ID has changed (to display the question text)
                                            if ($currentQuestionID !== $row['QPLID']) {
                                                echo "<p>Question " . $questionNumber . ": " . $row['Question'] . "</p>";
                                                echo "<input type='hidden' name='question_ids[]' value='" . $row['QPLID'] . "'>";
                                                $currentQuestionID = $row['QPLID'];
                                                $questionNumber++;
                                            }

                                            if ($row['Type'] == 1) {
                                                echo "<label class='choiceText form-check-label' style='display: block;'>
                                                    <input type='radio' name='answers[" . $row['QPLID'] . "]' value='" . $row['ChoiceText'] . "'>
                                                    " . $row['ChoiceText'] . "
                                                </label>";
                                            } elseif ($row['Type'] == 2) {
                                                echo "<label class='choiceText'>
                                                        <textarea style='height: 80px; width: 300px;' name='answers[" . $row['QPLID'] . "]'></textarea>
                                                    </label>";
                                            } else {
                                                echo "Error";
                                            }
                                        }
                                    } else {
                                        echo "No question details found.";
                                    }
                                ?>
                            </div>
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
    
</body>
</html>