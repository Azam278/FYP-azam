<?php
    session_start();
    include("conn.php");

    echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $VID = $_POST['VID'];
        $V_Name = $_POST['V_Name'];
        $DTIDs = $_POST['DTID']; // An array of DTIDs
        $DTVIDs = $_POST['DTVIDs']; // An array of DTVIDs

        $query = "UPDATE verb SET V_Name = ? WHERE VID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'si', $V_Name, $VID);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) >= 0) {
            // Update the existing DTVerb records based on the selected DTIDs
            foreach ($DTIDs as $index => $selectedDTID) {
                $DTID = $selectedDTID;
                $DTVID = $DTVIDs[$index];

                $updateQuery = "UPDATE dt_verb SET DTID = ? WHERE DTVID = ?";
                $updateStmt = mysqli_prepare($conn, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, 'ii', $DTID, $DTVID);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt); // Close the statement
            }

            echo "<script>
                window.onload = function() {
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Successfully Edited!',
                        showConfirmButton: false,
                        timer: 2000 // No dot (.) after timer
                    }).then(function() {
                        window.location.href = 'btverb.php';
                    });
                }
            </script>";

        } else {
            echo "<script>
            window.onload = function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please try again.!'
                  }).then(function() {
                    window.location = 'btaxonomy.php';
                });
            }
            </script>";
        }
    }
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Start Sidebar-->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Link Taxonomy with Verb</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        
                        <div class="taxonomyverb">
                            <div class="container">
                                <center>
                                    <form action="addbtverb.php" method="post">
                                        <h2>Link Taxonomy & Verb</h2>
                                        <table>
                                            <tr>
                                                <td><label for="vid">Action Verb:</label></td>
                                                <td>:</td>
                                                <td>
                                                    <?php
                                                        $query = "SELECT * FROM verb";
                                                        $result = mysqli_query($conn, $query);
                                                    ?>
                                                    <select class="form-control" name="vid" id="vid">
                                                        <option hidden>Select Verb</option>
                                                        <?php
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="' . $row['VID'] . '">' . $row['V_Name'] . '</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label for="btid">Domain Taxonomy Level</label></td>
                                                <td>:</td>
                                                <td>
                                                    <?php
                                                        include("conn.php");

                                                        $query = "SELECT * FROM domain_taxonomy";
                                                        $result = mysqli_query($conn, $query);
                                                    ?>
                                
                                                    <select class="form-control" name="btid" id="btid">
                                                        <option hidden>Select Level</option>
                                                        <?php
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="' . $row['DTID'] . '">' . $row['DT_Level'] . '</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="button-container">
                                            <button type="submit" class="btn-submit" value="submit">Submit</button>
                                        </div>                                           
                                    </form>
                                </center>                        
                            </div>
                            <?php
                                $query = "SELECT dtv.DTVID, v.VID, v.V_Name, dt.DTID, 
                                        GROUP_CONCAT(dt.DT_Level SEPARATOR ', ') as DT_Levels,
                                        GROUP_CONCAT(dtv.DTVID SEPARATOR ', ') as DTVIDs
                                        FROM verb v
                                        INNER JOIN dt_verb dtv ON v.VID = dtv.VID
                                        INNER JOIN domain_taxonomy dt ON dtv.DTID = dt.DTID
                                        GROUP BY v.V_Name";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    echo '<table class="table table-bordered" id="taxverbTable">';
                                    echo '<tr>';
                                    echo '<th>No.</th>';
                                    echo '<th>Action Verb</th>';
                                    echo '<th>Domain Taxonomy</th>';
                                    echo '<th colspan="2">Action</th>';
                                    echo '</tr>';

                                    $counter = 1;

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td>'. $counter. '</td>';
                                        echo '<td>' . $row['V_Name'] . '</td>';
                                        echo '<td>' . $row['DT_Levels'] . '</td>';
                                        echo "<td class='text-center'><a class='btn btn-success' data-dtvids='" . $row['DTVIDs'] . "' data-dtid='" . $row['DTID'] . "' data-dtlevels='" . $row['DT_Levels'] . "' onclick=\"editTaxVerb(" . $row['VID'] . ", '" . $row['V_Name'] . "', this)\"><i class='bi bi-pen'> Edit</i></a></td>";                             
                                        echo "<td class='text-center'><a class='btn btn-danger' onclick=\"showPopupForm(" . $row['VID'] . ")\"><i class='bi bi-trash3-fill'> Delete</i></a></td>";
                                        
                                        echo '</tr>';

                                        $counter++;
                                    }
                                    echo '</table>';
                                } else {
                                    echo '<p style = "text-align: center; color: red; font-weight: bolder; font-size: 25px;">No items found.</p>';
                                }
                            ?>            
                        </div>

                        
                        <div id="popupForm" class="popupForm">
                            <h2>Edit Form</h2>
                            <center>
                                <form method="post" action="btverb.php">
                                    <input type="hidden" id="editVID" name="VID" value="">
                                    <table>
                                        <tr>
                                            <th style="text-align: center;">Action Verb</th>
                                            <th style="text-align: center;">Domain Taxonomy</th>
                                        </tr>
                                        <tr>
                                            <td><input type="text" id="editVName" name="V_Name" value=""></td>
                                            <td>
                                                <div id="editDTLevelsContainer"></div>
                                                <div id="editDTVIDsContainer"></div>
                                            </td>
                                        </tr>
                                    </table>                                                                       
                                    <br><br>
                                    <input class="btn-submit" type="submit" value="Submit">
                                    <button type="button" onclick="document.getElementById('popupForm').style.display='none'" class="btn-cancel">Cancel</button>
                                </form>
                            </center>                                          
                        </div>

                        <div id="formPopup" class="modal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Rows</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- The data will be displayed here -->
                                    </div>
                                    <div class="modal-footer">                                    
                                        <button type="button" class="btn btn-danger" onclick="deleteDTVerb()">OK</button>
                                    </div>
                                </div>
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

        function editTaxVerb(VID, V_Name, button) {
            var DTVIDs = button.getAttribute('data-dtvids').split(', '); // Split into array
            var DTID = button.getAttribute('data-dtid');
            var DTLevels = button.getAttribute('data-dtlevels').split(', ');

            document.getElementById('editVID').value = VID;
            document.getElementById('editVName').value = V_Name;

            var selectContainer = document.getElementById('editDTLevelsContainer');
            var inputContainer = document.getElementById('editDTVIDsContainer');
            selectContainer.innerHTML = '';
            inputContainer.innerHTML = '';

            DTLevels.forEach(function(level, index) {
                var select = document.createElement('select');
                select.name = 'DTID[' + index + ']'; // Use an array for the select name
                select.id = 'editDTLevels' + index;

                var option = document.createElement('option');
                option.text = 'Select Level';
                option.value = '';
                select.add(option);

                <?php
                include("conn.php");
                $query = "SELECT * FROM domain_taxonomy";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo 'option = document.createElement("option");';
                    echo 'option.text = "' . $row['DT_Level'] . '";';
                    echo 'option.value = "' . $row['DTID'] . '";';
                    echo 'if (level == "' . $row['DT_Level'] . '") option.selected = true;';
                    echo 'select.add(option);';
                }
                ?>

                selectContainer.appendChild(select);

                // Create a hidden input field for each DTVID
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'DTVIDs[' + index + ']';
                input.value = DTVIDs[index]; // The DTVID value for this level
                inputContainer.appendChild(input);
            });

            document.getElementById('popupForm').style.display = 'block';
        }

        // function deleteDTVerb(vid) {
        //     Swal.fire({
        //         title: 'Are you sure you want to delete this row?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             window.location.href = "delete_tax_verb.php?verb_id=" + vid;
        //         }
        //     });
        // }

        function showPopupForm(vid) {
            // Fetch the data for the selected verb
            $.ajax({
                url: 'fetch_data.php',
                type: 'post',
                data: {vid: vid},
                success: function(response){
                    // Show the data in the popup form
                    $('#formPopup .modal-body').html(response);
                    var myModal = new bootstrap.Modal(document.getElementById('formPopup'), {});
                    myModal.show();
                }
            });
        }
        

        function deleteDTVerb() {
            // Get the selected checkboxes
            var selected = [];
            $('#formPopup input:checked').each(function() {
                selected.push($(this).val());
            });

            // Show Swal.fire confirmation dialog
            Swal.fire({
                title: 'Are you sure you want to delete the selected rows?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Delete the selected rows if the user confirms
                    $.ajax({
                        url: 'delete_tax_verb.php',
                        type: 'post',
                        data: { dtvids: selected },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.status === 'success') {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'success',
                                    title: 'Deleted Successfully!',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    window.location = 'btverb.php';
                                });
                            } else if (result.status === 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Unable to delete the rows!'
                                }).then(function() {
                                    window.location = 'btverb.php';
                                });
                            } else if (result.status === 'no_selection') {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'No Rows Selected',
                                    text: 'No rows were selected for deletion.'
                                });
                            }
                        }
                    });
                }
            });
        }
        
    </script>

</body>

</html>