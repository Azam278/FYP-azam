<?php
    session_start();
    include("conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile User</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
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
                <?php
                // Check if the user is a Coordinator
                if ($roleName == 'Coordinator' || $roleName == 'Educator') {
                    echo '<a class="nav-link" href="searchverb.php">';
                            echo '<i class="fas fa-fw fa-chart-area"></i>';
                            echo '<span>Search Verb</span>
                        </a>';
                }
                ?>
            </li>

            <li class="nav-item">
                <?php
                // Check if the user is a Coordinator
                if ($roleName == 'Coordinator' || $roleName == 'Educator') {
                    echo '<a class="nav-link" href="assessment.php">';
                            echo '<i class="fas fa-fw fa-chart-area"></i>';
                            echo '<span>Assessment</span>
                        </a>';
                }
                ?>
            </li>

            <li class="nav-item">
                <?php
                // Check if the user is a Coordinator
                if ($roleName == 'Coordinator' || $roleName == 'Educator') {
                    echo '<a class="nav-link" href="questionpaperlist.php">';
                            echo '<i class="fas fa-fw fa-chart-area"></i>';
                            echo '<span>Question</span>
                        </a>';
                }
                ?>
            </li>

            <li class="nav-item">
                <?php
                // Check if the user is a Super Admin
                if ($roleName == 'Evaluator') {
                    echo '<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
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
                        </div>';
                }
                ?>
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
                        <h1 class="h3 mb-0 text-gray-800">Edit Profile</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        
                        <?php
                            // Check if the user is logged in and the userid is set in the session
                            if (isset($_SESSION['userid'])) {
                                // Get the user's Staff_ID from the session
                                $userid = $_SESSION['userid'];

                                // Fetch the user's information from the database based on the Staff_ID
                                $query = "SELECT * FROM users WHERE Staff_ID = '$userid'";
                                $result = mysqli_query($conn, $query);

                                // Check if the query was successful
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    $pass = $row['StPassword'];
                                    $name = $row['StName'];
                                    $gender = $row['Gender'];
                                    $phonenumber = $row['PHNumber'];
                        ?>
                            <div class="editProfile">
                                <div class="container">
                                    <center>
                                        <h1>Welcome, <?php echo $name; ?>!</h1>
                                        <table>
                                            <tr>
                                                <td>Staff ID:</td>
                                                <td><?php echo $userid; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Password:</td>
                                                <td><?php echo $pass; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Name:</td>
                                                <td><?php echo $name; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Gender:</td>
                                                <td><?php echo $gender; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Phone Number:</td>
                                                <td><?php echo $phonenumber; ?></td>
                                            </tr>
                                        </table>
                                    </center>
                                    <hr>
                                    <h2 style="text-align: center;">Edit Information</h2>
                                    <form action="updateprofileUser.php" method="post">
                                        <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                                        <table id="tableJPU">
                                            <tr>
                                                <td>Name:</td>
                                                <td><input type="text" name="name" value="<?php echo $name; ?>"></td>
                                            </tr>
                                            <tr>
                                                <td>Password:</td>
                                                <td><input type="text" name="password" minlength="8" maxlength="12" value="<?php echo $pass; ?>" required></td>
                                            </tr>
                                            <tr>
                                                <td>Phone Number:</td>
                                                <td><input type="text" name="phonenumber" value="<?php echo $phonenumber; ?>"></td>
                                            </tr>
                                        </table>
                                        <div class="button-container">
                                            <button class="btn-edit">Save Edit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                                
                            <br>
                                
                            <?php
                                } else {
                                    echo "User not found.";
                                }

                            // Close the database connection
                                mysqli_close($conn);
                        }
                            ?>

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