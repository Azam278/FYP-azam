<?php
    session_start();
    include("conn.php");

    $totalPending = 0; // Initialize totalPending to 0

    if (isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];

        $query = "SELECT COUNT(*) AS total_pending, c.CourseID, c.EV1, c.EV2
                  FROM question_paper_list 
                  INNER JOIN course c ON question_paper_list.CourseID = c.CourseID
                  WHERE (QPLStatus = 'pending' AND c.EV1 = '$userid') OR (QPLStatus2 = 'pending' AND c.EV2 = '$userid')";
        $resultPending = mysqli_query($conn, $query);
        if ($resultPending) {
            $rowPending = mysqli_fetch_assoc($resultPending);
            $totalPending = $rowPending['total_pending'];
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        
        $query = "SELECT COUNT(*) AS total_approve, c.CourseID, c.EV1, c.EV2
                  FROM question_paper_list 
                  INNER JOIN course c ON question_paper_list.CourseID = c.CourseID
                  WHERE (QPLStatus = 'Approved' AND c.EV1 = '$userid') OR (QPLStatus2 = 'Approved' AND c.EV2 = '$userid')";
        $resultApprove = mysqli_query($conn, $query);
        if ($resultApprove) {
            $rowApprove = mysqli_fetch_assoc($resultApprove);
            $totalApprove = $rowApprove['total_approve'];
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        $query = "SELECT COUNT(*) AS total_not_approved, c.CourseID, c.EV1, c.EV2
                  FROM question_paper_list 
                  INNER JOIN course c ON question_paper_list.CourseID = c.CourseID
                  WHERE (QPLStatus = 'Not Approve' AND c.EV1 = '$userid') OR (QPLStatus2 = 'Not Approve' AND c.EV2 = '$userid')";
        $resultNotApprove = mysqli_query($conn, $query);
        if ($resultNotApprove) {
            $rowNotApprove = mysqli_fetch_assoc($resultNotApprove);
            $totalNotApprove = $rowNotApprove['total_not_approved'];
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        
    } else {
        echo "User ID not set in session.";
    }
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Start Sidebar-->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <?php
                $pageTitle = "Evaluator"; // Default page title
                
                if (isset($_SESSION['userid'])) {
                    $userid = $_SESSION['userid'];
                    
                    $query = "SELECT r.R_NAME FROM role r
                            JOIN users ad ON r.RID = ad.RID
                            WHERE ad.Staff_ID = '$userid'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $roleName = $row['R_NAME'];

                    switch ($roleName) {
                        case 'Evaluator':
                            $pageTitle = "Evaluator";
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

                        case 'Evaluator':
                            $homeLink = "evaluatorpage.php";
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Question Approval</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="pending.php">Pending</a>
                        <a class="collapse-item" href="approved.php">Approved</a>
                        <a class="collapse-item" href="not_approved.php">Not Approved</a>
                    </div>
                </div>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <div class="row">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pending Questions</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPending; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-hourglass-split fa-2x text-gray-600"></i>
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <a href="pending.php">
                                        <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </center> 
                            </div>                         
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Approved Questions</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalApprove; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-check fa-2x text-gray-600"></i>
                                        </div>
                                    </div>                                    
                                </div>
                                <center>
                                    <a href="approved.php">
                                        <div class="panel-footer">
                                        <span class="pull-left text-success">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </center>
                            </div>                         
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Total Not Approved Questions</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalNotApprove; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="bi bi-x fa-2x text-gray-600"></i>
                                        </div>
                                    </div>
                                </div>
                                <center>
                                    <a href="not_approved.php">
                                        <div class="panel-footer">
                                        <span class="pull-left text-danger">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </center>
                            </div>                         
                        </div>
                    </div>

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
        // Add event listener to the "Select All" checkbox
        document.getElementById('select_all').addEventListener('change', function(e) {
            // Get all checkboxes with the class "select"
            var checkboxes = document.getElementsByClassName('select');

            // Set the checked property of each checkbox to the checked property of the "Select All" checkbox
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = e.target.checked;
            }
        });
    </script>

</body>
</html>