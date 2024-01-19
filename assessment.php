<?php
    session_start();
    include("conn.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $courseId = $_POST["courseId"];
        $query = "SELECT * FROM clo WHERE CourseID = $courseId";
        $result = mysqli_query($conn, $query);
        $clos = array();
        
        while ($row = mysqli_fetch_assoc($result)) {
            $clo = array(
                'CID' => $row['CID'],
                'C_Level' => $row['C_Level']
            );
            $clos[] = $clo;
        }
        
        echo json_encode($clos);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

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
                        <h1 class="h3 mb-0 text-gray-800">Assessment</h1>
                        <a onclick="document.getElementById('id03').style.display='block'" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Create New</a>
                    </div>

                    <div id="id03" class="tablelist">
                        <h2> Add Assessment</h2>
                        <form action="addAssessment.php" method="POST" class="needs-validation" novalidate>
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
                                            Please choose the Course.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Assessment Type</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" id="assessmentType" name="assessmentType" aria-label="Default select example" required>                                            
                                            <option value="">Select Assessment Type</option>
                                            <option value="Midterm Test">Midterm Test</option>
                                            <option value="Lab Test">Lab Test</option>
                                            <option value="Final Examination">Final Examination</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose the Assessment Type.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Percentage</td>
                                    <td>:</td>
                                    <td>
                                        <select class="form-control" id="percentage" name="percentage" aria-label="Default select example" required>
                                            <option value="">Select Percentage</option>
                                            <option value="30%">30%</option>
                                            <option value="40%">40%</option>
                                            <option value="50%">50%</option>
                                            <option value="60%">60%</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please choose the Percentage.
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>CLO</td>
                                    <td>:</td>
                                    <td id="cloSection"></td>
                                </tr>
                            </table>
                            <button type="submit" class="btn-add" value="submit">Save</button>
                            <button type="button" onclick="document.getElementById('id03').style.display='none'" class="btn-cancel">Cancel</button>               
                        </form>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <?php
                            // Check if the user is logged in
                            if (isset($_SESSION['userid'])) {
                                // Get the user ID from the session
                                $userId = $_SESSION['userid'];

                                // Fetch data from the assessment table
                                $query = "SELECT a.AssessmentID, c.CourseName, a.AssessmentType, a.Percent, cl.C_Level
                                FROM assessment a
                                JOIN course c ON a.CourseID = c.CourseID
                                JOIN assessment_clo ac ON a.AssessmentID = ac.AssessmentID
                                JOIN clo cl ON ac.CID = cl.CID
                                WHERE a.Staff_ID = '$userId'";


                                $result = mysqli_query($conn, $query);

                                if ($result) {
                                    if (mysqli_num_rows($result) > 0) {
                                        echo '<table class="table table-striped table-bordered">';
                                        echo '<tr><th>No.</th><th>Course Name</th><th>Assessment Type</th><th>Percentage</th><th>CLO</th><th class="actionCol" colspan="2">Action</th></tr>';
                                
                                        $groupedData = array(); // Array to store grouped data

                                        $counter = 1;
                                
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $assessmentID = $row['AssessmentID'];
                                
                                            // Check if AssessmentID already exists in the grouped data array
                                            if (isset($groupedData[$assessmentID])) {
                                                // Append the current C_Level to the existing value
                                                $groupedData[$assessmentID]['C_Level'] .= ', ' . $row['C_Level'];
                                            } else {
                                                // Add the new AssessmentID entry to the grouped data array
                                                $groupedData[$assessmentID] = $row;
                                            }
                                        }
                                
                                        // Output the grouped data
                                        foreach ($groupedData as $row) {
                                            echo '<tr>';                                           
                                            echo '<td>'. $counter. '</td>';
                                            echo '<td>' . (isset($row['CourseName']) ? $row['CourseName'] : '') . '</td>';
                                            echo '<td>' . (isset($row['AssessmentType']) ? $row['AssessmentType'] : '') . '</td>';
                                            echo '<td>' . (isset($row['Percent']) ? $row['Percent'] : '') . '</td>';
                                            echo '<td>' . (isset($row['C_Level']) ? $row['C_Level'] : '') . '</td>';
                                            echo '<td class="text-center"><a class="btn btn-success" onclick="handleEdit(' . $assessmentID . ')"><i class="bi bi-pen"> Edit</i></a></td>';
                                            echo '<td class="text-center"><a class="btn btn-danger" onclick="handleDelete(' . $assessmentID . ')"><i class="bi bi-trash3-fill"> Delete</i></a></td>';
                                            echo '</tr>';
                                            
                                            $counter++;
                                        }
                                
                                        echo '</table>';
                                    } else {
                                        echo 'No records found.';
                                    }
                                } else {
                                    echo 'Error executing the query: ' . mysqli_error($conn);
                                }                            
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
        var modal = document.getElementById("id03");

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        $(document).ready(function() {
            // Event listener for course select
            $('#coursename').change(function() {
                var courseId = $(this).val(); // Get the selected course ID
                var cloSection = $('#cloSection'); // Element to hold the checkbox options

                // Clear previous options
                cloSection.empty();

                // Make AJAX request to fetch CLOs
                $.ajax({
                    url: '<?php echo $_SERVER["PHP_SELF"]; ?>', // Replace with the actual PHP file to fetch CLOs
                    method: 'POST',
                    data: { courseId: courseId }, // Send the selected course ID to the server
                    dataType: 'json',
                    success: function(response) {
                        // Populate the checkbox options
                        for (var i = 0; i < response.length; i++) {
                            var cloId = response[i].CID;
                            var cloName = response[i].C_Level;
                            var checkbox = $('<input type="checkbox" name="clo[]" value="' + cloId + '"> ' + cloName + '<br>');
                            cloSection.append(checkbox);
                        }
                    },
                    error: function() {
                        console.log('Error occurred while fetching CLOs.');
                    }
                });
            });
        });

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

        function handleEdit(assessmentID) {
            // Redirect to the editjpu.php page with the courseID and topicID as parameters
            window.location.href = 'editAssessment.php?assessment_id=' + assessmentID;
        }

        function handleDelete(assessmentID) {
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
                    window.location.href = 'deleteAssessment.php?assessment_id=' + assessmentID;
                }
            });
        }
    </script>
    
</body>
</html>