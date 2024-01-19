<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    $qplID = $_GET['qpl_id'];
    $courseID = $_GET['course_id'];

    $queryQuestion = "SELECT Question, Mark FROM question_paper_list WHERE QPLID = '$qplID'";
    $resultQuestion = mysqli_query($conn, $queryQuestion);

    if ($resultQuestion) {
        if (mysqli_num_rows($resultQuestion) > 0) {
            $rowQuestion = mysqli_fetch_assoc($resultQuestion);
            $questionText = $rowQuestion['Question'];
            $markText = $rowQuestion['Mark'];
        } else {
            // Question not found
            echo "Question not found.";
            exit();
        }
    } else {
        // Error in the SQL query
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    // Retrieve the existing options for the question
    $queryOptions = "SELECT ChoiceText FROM choice WHERE QPLID = '$qplID'";
    $resultOptions = mysqli_query($conn, $queryOptions);

    if ($resultOptions) {
        if (mysqli_num_rows($resultOptions) > 0) {
            $rowOptions = mysqli_fetch_assoc($resultOptions);
            $textAnswer = $rowOptions['ChoiceText'];
        } else {
            // Options not found
            echo "Options not found.";
            exit();
        }
    } else {
        // Error in the SQL query
        echo "Error: " . mysqli_error($conn);
        exit();
}

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the updated question and mark from the form
        $questionText = $_POST['question'];
        $markText = $_POST['mark'];
        $updatedstatus = "pending";
        $textAnswer = $_POST['textAnswer'];

        // Update the question and mark in the database
        $updateQuery = "UPDATE question_paper_list SET Question = '$questionText', Mark = '$markText', QPLStatus = '$updatedstatus' WHERE QPLID = '$qplID'";
        $resultUpdate = mysqli_query($conn, $updateQuery);

        // Update the text answer in the database
        $updateAnswerQuery = "UPDATE choice SET ChoiceText = '$textAnswer' WHERE QPLID = '$qplID'";
        $resultAnswerUpdate = mysqli_query($conn, $updateAnswerQuery);

        if ($resultUpdate && $resultAnswerUpdate) {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    position: 'top',
                    icon: 'success',
                    title: 'Successfully Edited!',
                    showConfirmButton: false,
                    timer: 2000
                  }).then(function() {
                    window.location = 'qpdetails.php?action=edit&course_id=$courseID';
                });
            }
            </script>";
        } else {
            // echo "Error updating data: " . mysqli_error($conn);
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
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.0/classic/ckeditor.js"></script>
    
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Item</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        	
			            <div class="editQuestionForm">
                            <div class="container">
                                    <h2>Edit Question Item</h2>                                    
                                    <form action="editsubjective.php?qpl_id=<?php echo $qplID; ?>&course_id=<?php echo $courseID; ?>" method="POST">
                                        <table>
                                            <tr>
                                                <td>Question</td>
                                                <td>:</td>
                                                <td>
                                                    <textarea style="height: 80px; width: 300px;" name="question" id="question"><?php echo $questionText; ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Mark</td>
                                                <td>:</td>
                                                <td>
                                                    <input width="" type="text" name="mark" value="<?php echo $markText; ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Question Type</td>
                                                <td>:</td>
                                                <td>
                                                <?php
                                                    $queryQType = "SELECT Type from question_paper_list WHERE QPLID = '$qplID'";
                                                    $result = $conn->query($queryQType);

                                                    if ($result && $result->num_rows > 0) {
                                                        $row = $result->fetch_assoc();
                                                        $type = $row['Type'];

                                                        $questionType = "";
                                                        if ($type == 2) {
                                                            $questionType = "Subjective";
                                                        }
                                                        echo "<label class='form-control'>$questionType</label>";
                                                    }
                                                ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Text Answer</td>
                                                <td>:</td>
                                                <td>
                                                <textarea style="height: 80px; width: 300px;" name="textAnswer"><?php echo $textAnswer; ?></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="button-container">
                                            <a onclick="backToQuestion('<?php echo $courseID; ?>')" type="button" class="btn-cancel">Cancel</a>
                                            <button class="btn-edit" type="submit" value="submit">Save</button>
                                        </div>
                                    </form>
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

    <script>

        ClassicEditor
            .create( document.querySelector( '#question' ) )
            .catch( error => {
                console.error( error );
            } );
            
        function backToQuestion(courseID) {
            window.location.href = "qpdetails.php?action=edit&course_id=" + courseID;
        }
    </script>
</body>
</html>