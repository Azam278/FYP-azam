<?php
    session_start();
    include("conn.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JPU List</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">JPU List</h1>
                        <a onclick="document.getElementById('id01').style.display='block'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create New</a>
                    </div>

                    <div id="id01" class="tablelist"> 
                        <form action="addlist.php" method="POST" class="needs-validation" novalidate>
                            <br>
                            <h3>Add JPU</h3>
                            <table id="tableJPU">
                                <tr>
                                    <td>Course</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                        $query = "SELECT * FROM course";
                                        $result = mysqli_query($conn, $query);
                                        ?>
                                        <select class="form-control" name="coursename" id="coursename" aria-label="Default select example" required>
                                            <option value="">Select Course</option>
                                            <?php
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['CourseID'] . '">' . $row['CourseName'] . '</option>';
                                                }
                                            ?>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose the course.
                                        </div>                                          
                                    </td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>:</td>
                                    <td>
                                        <input class="form-control" type="text" name="description" placeholder="Description" pattern="^[A-Za-z\s]+$" required>
                                        <div class="invalid-feedback">
                                            Please enter only letters.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Semester</td>
                                    <td>:</td>
                                    <td>
                                        <input class="form-control" type="text" name="semester" placeholder="Semester" pattern="^Semester \d \d{4}/\d{2}$" required>
                                        <div class="invalid-feedback">
                                            Please enter a semester in the format "Semester X XXXX/XX".
                                        </div>                                                                               
                                    </td>
                                </tr>
                            </table>

                            <button type="submit" class="btn-add" value="submit">Save</button>
                            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="btn-cancel">Cancel</button>               
                        </form>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        
                        <?php
                            // Check if the user is logged in
                            if (isset($_SESSION['userid'])) {
                                // Get the user ID from the session
                                $userId = $_SESSION['userid'];

                                // Fetch data from the jpu table
                                $query = "SELECT j.CourseID, c.CourseName, j.listDescription, j.Semester
                                        FROM jpu AS j
                                        INNER JOIN course AS c ON j.CourseID = c.CourseID
                                        WHERE j.Staff_ID = '$userId'";

                                $result = $conn->query($query);

                                // Check if the query executed successfully
                                if ($result) {
                                    // Check if there are any results
                                    if ($result->num_rows > 0) {
                                        // Start generating the HTML table
                                        echo '<table class="table table-hover table-striped table-bordered">';
                                        echo "<tr><th>No.</th><th>Course Name</th><th>Description</th><th>Semester</th><th colspan = '2'>Action</th></tr>";

                                        $counter = 1;

                                        // Loop through the results and display the data in table rows
                                        while ($row = $result->fetch_assoc()) {
                                            $courseID = $row['CourseID'];
                                            $coursename = $row['CourseName'];
                                            $description = $row['listDescription'];
                                            $semester = $row['Semester'];

                                            echo "<tr>";
                                            
                                            echo "<td>$counter</td>";
                                            echo "<td>$coursename</td>";
                                            echo "<td>$description</td>";
                                            echo "<td>$semester</td>";

                                            // Add the action parameter
                                            echo '<td class="text-center"><a class="btn btn-primary" href="jpu.php?action=add&course_id=' . $courseID . '"><i class="bi bi-plus-lg"> Add</i></a></td>';
                                            // Add the edit button
                                            echo '<td class="text-center"><a class="btn btn-success" href="jpu.php?action=edit&course_id=' . $courseID . '"><i class="bi bi-pen"> Edit</i></a></td>';
                                            echo "</tr>";
                                            
                                            $counter++;
                                        }
                                        // Close the HTML table
                                        echo "</table>";
                                    } else {
                                        echo '<p style="text-align: center; color: red; font-weight: bolder; font-size: 25px;">No List.</p>';
                                    }
                                } else {
                                    // Query execution error
                                    echo 'Error executing the query: ' . mysqli_error($conn);
                                }
                            } else {
                                echo 'User not logged in.';
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

    <script>
        // Get the modal
        var modal = document.getElementById("id01");

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        (function () {
            'use strict'

            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)

                Array.from(form.elements).forEach(function(element) {
                    element.addEventListener('input', function(event) {
                    if (!element.checkValidity()) {
                        element.classList.add('is-invalid')
                    } else {
                        element.classList.remove('is-invalid')
                    }
                    })
                })
            })
        })()
    </script>
    
</body>
</html>