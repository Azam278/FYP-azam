<?php
    session_start();
    include("conn.php");

    $queryEducators = "SELECT COUNT(*) AS total_educators FROM users WHERE RID = (SELECT RID FROM role WHERE R_NAME = 'Educator')";
    $resultEducators = mysqli_query($conn, $queryEducators);
    $rowEducators = mysqli_fetch_assoc($resultEducators);
    $totalEducators = $rowEducators['total_educators'];

    $queryEvaluators = "SELECT COUNT(*) AS total_evaluators FROM users WHERE RID = (SELECT RID FROM role WHERE R_NAME = 'Evaluator')";
    $resultEvaluators = mysqli_query($conn, $queryEvaluators);
    $rowEvaluators = mysqli_fetch_assoc($resultEvaluators);
    $totalEvaluators = $rowEvaluators['total_evaluators'];

    $queryCoordinators = "SELECT COUNT(*) AS total_coordinators FROM users WHERE RID = (SELECT RID FROM role WHERE R_NAME = 'Coordinator')";
    $resultCoordinators = mysqli_query($conn, $queryCoordinators);
    $rowCoordinators = mysqli_fetch_assoc($resultCoordinators);
    $totalCoordinators = $rowCoordinators['total_coordinators'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Page</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="css/style.css">

    <style>
        canvas {
            display: block;
            margin: 0 auto;
            width: 800px;
            height: 400px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Start Sidebar-->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion hide-on-print" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <?php
                $pageTitle = "Administrator"; // Default page title
                
                if (isset($_SESSION['userid'])) {
                    $userid = $_SESSION['userid'];
                    
                    $query = "SELECT r.R_NAME FROM role r
                            JOIN administrator ad ON r.RID = ad.RID
                            WHERE ad.ADMIN_ID = '$userid'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $roleName = $row['R_NAME'];

                    switch ($roleName) {
                        case 'Super Admin':
                            $pageTitle = "Administrator";
                            break;
                        case 'Committee':
                            $pageTitle = "Committee";
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
                            JOIN administrator ad ON r.RID = ad.RID
                            WHERE ad.ADMIN_ID = '$userid'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $roleName = $row['R_NAME'];
            
                    switch ($roleName) {
                        case 'Super Admin':
                            $homeLink = "adminhome.php";
                            break;
                        case 'Committee':
                            $homeLink = "adminhome.php";
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
                // Check if the user is a Super Admin
                if ($roleName == 'Super Admin') {
                    echo '<a class="nav-link" href="admin.php">';
                            echo '<i class="fas fa-fw fa-chart-area"></i>';
                            echo '<span>Committee</span>
                        </a>';
                }
                ?>
            </li>

            <li class="nav-item">
                <?php
                // Check if the user is a Super Admin
                if ($roleName == 'Super Admin') {
                    echo '<a class="nav-link" href="coordinator.php">';
                            echo '<i class="fas fa-fw fa-chart-area"></i>';
                            echo '<span>Coordinator</span>
                        </a>';
                }
                ?>
            </li>

            <li class="nav-item">
                <?php
                // Check if the user is a Super Admin
                if ($roleName == 'Super Admin') {
                    echo '<a class="nav-link" href="deleteUsers.php">';
                            echo '<i class="fas fa-fw fa-chart-area"></i>';
                            echo '<span>Delete Users</span>
                        </a>';
                }
                ?>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="btaxonomy.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Bloom Taxonomy</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="actionverb.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Action Verb</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="btverb.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Taxonomy & Verb</span>
                </a>
            </li>

            <li class="nav-item">
                <?php
                    if ($roleName == 'Super Admin') {
                        echo '<a class="nav-link" href="course.php">';
                                echo '<i class="fas fa-fw fa-chart-area"></i>';
                                echo '<span>Course</span>
                            </a>';
                    } else {
                        echo '<a class="nav-link" href="assignEv.php">';
                                echo '<i class="fas fa-fw fa-chart-area"></i>';
                                echo '<span>Assign Evaluator</span>
                            </a>';
                    }
                ?>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Report</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="userReport.php">User Report</a>
                        <a class="collapse-item" href="totalVerbDT.php">Verb for Domain Levels</a>
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
                            if (isset($_SESSION['userid'])) {
                                $userid = $_SESSION['userid'];

                                $query = "SELECT A_NAME FROM administrator WHERE ADMIN_ID = '$userid'";
                                $result = mysqli_query($conn, $query);
                                $row = mysqli_fetch_assoc($result);
                                $name = $row['A_NAME'];

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
                                        <a class="dropdown-item" href="profileAdmin.php">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4 hide-on-print">
                        <h1 class="h3 mb-0 text-gray-800 hide-on-print">Report Total User</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        
                        <div class="pdfcontainer">
                            <div class="button-container">
                                <button onclick="window.print()" class="btn-generatePDF hide-on-print">Generate PDF</button>
                            </div>
                            <h2>Totak User Report</h2>
                            <div class="container">
                                <canvas id="barChart"></canvas>
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
        var ctx = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Educators', 'Evaluators', 'Coordinators'],
            datasets: [{
            label: 'Total Users',
            data: [<?php echo $totalEducators; ?>, <?php echo $totalEvaluators; ?>, <?php echo $totalCoordinators; ?>],
            backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
            y: {
                beginAtZero: true,
                ticks: {
                precision: 0
                }
            }
            }
        }
        });
    </script>

</body>

</html>