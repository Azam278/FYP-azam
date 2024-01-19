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
    <title>JPU</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

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
                        <h1 class="h3 mb-0 text-gray-800">JPU</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        
                        <div class="jpucontainer">
                            <div class="container">
                                <h2>Jadual Penentu Ujian</h2>
                                <?php
                                    $query = "SELECT Semester
                                            FROM jpu j
                                            INNER JOIN course c ON j.CourseID = c.CourseID
                                            WHERE c.CourseID = '$courseID'";
                                    $result = $conn->query($query);

                                    if ($result && $result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $semester = $row['Semester'];
                                        echo "<p>$semester</p>";
                                    }
                                ?>
                                <?php
                                    $queryCourse = "SELECT CourseName from course WHERE CourseID = '$courseID'";
                                    $result = $conn->query($queryCourse);

                                    if ($result && $result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $course = $row['CourseName'];

                                        echo "<p>$course</p>";
                                    }
                                ?>

                                <?php
                                    $queryCLO = "SELECT C_Level, C_Desc FROM clo WHERE CourseID = '$courseID'";
                                    $result = $conn->query($queryCLO);

                                    if ($result) {
                                        if ($result->num_rows > 0){
                                            echo '<table class="table table-bordered">';
                                            echo "<tr><th>CLO</th><th>Description</th></tr>";

                                            while ($row = $result->fetch_assoc()) {
                                                $clolevel = $row['C_Level'];
                                                $clodescription = $row['C_Desc'];
                            
                                                echo "<tr>";
                                                echo "<td>$clolevel</td>";
                                                echo "<td>$clodescription</td>";
                                            }
                                            echo "</table>";
                                        } else {
                                            echo '<p style="text-align: center; color: red;">No List.</p>';
                                        }
                                    } else {
                                        // Query execution error
                                        echo 'Error executing the query: ' . mysqli_error($conn);
                                    }
                                ?>
                            </div>
                            <!-- End of container -->
                            <div class="button-container">
                                <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;" class="btn-addTopic">Add Topic </button>
                                <button class="btn-generatePDF"><a href="printpdfjpu.php?course_id=<?php echo $courseID; ?>">Generate PDF</a></button>
                            </div>
                            <div id="id02" class="tablelist">
                                <form action="addjpu.php?course_id=<?php echo $courseID; ?>" method="POST" class="needs-validation" novalidate>
                                    <?php
                                        $queryCourse = "SELECT CourseName from course WHERE CourseID = '$courseID'";
                                        $result = $conn->query($queryCourse);

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $course = $row['CourseName'];

                                            echo "<p>$course</p>";
                                        }
                                    ?> 
                                    <table id="tableJPU">                   
                                        <tr>
                                            <td><label style="text-align: center;">Topic Name</label></td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" type="text" name="topicname" placeholder="Topic Name" pattern="^[A-Za-z\s]+$" required>
                                                <div class="invalid-feedback">
                                                    Please enter only letters.
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>CLO</td>
                                            <td>:</td>
                                            <td>
                                                <?php
                                                    include("conn.php");

                                                    $query = "SELECT * FROM clo WHERE CourseID = '$courseID'";
                                                    $result = mysqli_query($conn, $query);
                                                    ?>
                                                    <select class="form-control" name="clo" id="clo" aria-label="Default select example" required>
                                                        <option value="">Select CLO</option>
                                                        <?php
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo '<option value="' . $row['CID'] . '">' . $row['C_Level'] . '</option>';
                                                            }
                                                        ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please choose the CLO.
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Taxonomy Level</td>
                                            <td>:</td>
                                            <td>Mark</td>
                                        </tr>

                                        <tr>
                                            <td>            
                                                <?php
                                                    $query = 'SELECT * FROM domain_taxonomy WHERE DT_Level = "C1"';
                                                    $result = mysqli_query($conn, $query);

                                                    if (!$result) {
                                                        die('Error executing the query: ' . mysqli_error($conn));
                                                    }

                                                    $row = mysqli_fetch_assoc($result);
                                                ?>

                                                <label for="dt1"><?php echo $row['DT_Level']; ?></label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" type="text" name="mark1">
                                                <input type="hidden" name="dt1" value="<?php echo $row['DTID']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                    $query = 'SELECT * FROM domain_taxonomy WHERE DT_Level = "C2"';
                                                    $result = mysqli_query($conn, $query);

                                                    if (!$result) {
                                                        die('Error executing the query: ' . mysqli_error($conn));
                                                    }

                                                    $row = mysqli_fetch_assoc($result);
                                                ?>

                                                <label id="dt2"><?php echo $row['DT_Level']; ?></label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" type="text" name="mark2">
                                                <input type="hidden" name="dt2" value="<?php echo $row['DTID']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                    $query = 'SELECT * FROM domain_taxonomy WHERE DT_Level = "C3"';
                                                    $result = mysqli_query($conn, $query);

                                                    if (!$result) {
                                                        die('Error executing the query: ' . mysqli_error($conn));
                                                    }

                                                    $row = mysqli_fetch_assoc($result);
                                                ?>

                                                <label id="dt3"><?php echo $row['DT_Level']; ?></label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" type="text" name="mark3">
                                                <input type="hidden" name="dt3" value="<?php echo $row['DTID']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                    $query = 'SELECT * FROM domain_taxonomy WHERE DT_Level = "C4"';
                                                    $result = mysqli_query($conn, $query);

                                                    if (!$result) {
                                                        die('Error executing the query: ' . mysqli_error($conn));
                                                    }

                                                    $row = mysqli_fetch_assoc($result);
                                                ?>

                                                <label id="dt4"><?php echo $row['DT_Level']; ?></label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" type="text" name="mark4">
                                                <input type="hidden" name="dt4" value="<?php echo $row['DTID']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                    $query = 'SELECT * FROM domain_taxonomy WHERE DT_Level = "C5"';
                                                    $result = mysqli_query($conn, $query);

                                                    if (!$result) {
                                                        die('Error executing the query: ' . mysqli_error($conn));
                                                    }

                                                    $row = mysqli_fetch_assoc($result);
                                                ?>

                                                <label id="dt5"><?php echo $row['DT_Level']; ?></label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" type="text" name="mark5">
                                                <input type="hidden" name="dt5" value="<?php echo $row['DTID']; ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php
                                                    $query = 'SELECT * FROM domain_taxonomy WHERE DT_Level = "C6"';
                                                    $result = mysqli_query($conn, $query);

                                                    if (!$result) {
                                                        die('Error executing the query: ' . mysqli_error($conn));
                                                    }

                                                    $row = mysqli_fetch_assoc($result);
                                                ?>

                                                <label id="dt6"><?php echo $row['DT_Level']; ?></label>
                                            </td>
                                            <td>:</td>
                                            <td>
                                                <input class="form-control" type="text" name="mark6"> 
                                                <input type="hidden" name="dt6" value="<?php echo $row['DTID']; ?>">
                                            </td>
                                        </tr>
                                    </table>
                                    <button type="submit" class="btn-add" value="submit">Save</button>
                                    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="btn-cancel">Cancel</button>
                                </form>
                            </div>
                            <hr>
                            <?php
                                if (isset($_SESSION['userid'])) {
                                    $userId = $_SESSION['userid'];
                                    if (isset($_GET['action'])) {
                                        if ($_GET['action'] == 'add') {
                                            echo '<p style="text-align: center; color: red; font-weight: bolder; font-size: 25px;">No items found.</p>';
                                        } else if ($_GET['action'] == 'edit') {
                                            $query = "SELECT tn.TID, tn.T_Name, cl.C_Level, dt.DTID, dt.DT_Level, mrk.Mark
                                                    FROM topic tn
                                                    INNER JOIN mark mrk ON tn.TID = mrk.TID
                                                    INNER JOIN clo cl ON mrk.CID = cl.CID
                                                    INNER JOIN domain_taxonomy dt ON mrk.DTID = dt.DTID
                                                    INNER JOIN course c ON cl.CourseID = c.CourseID
                                                    WHERE tn.Staff_ID = '$userId' AND c.CourseID = '$courseID'";
                                            $result = mysqli_query($conn, $query);
                                
                                            if ($result) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    $courseIDs = array();
                                                    $topicIDs = array();
                                                    $counter = 1;
                                
                                                    // Initialize counters for each DT_Level
                                                    $totalC1Questions = $totalC2Questions = $totalC3Questions = $totalC4Questions = $totalC5Questions = $totalC6Questions = 0;
                                
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $topicID = $row['TID'];
                                                        $topicname = $row['T_Name'];
                                                        $cLevel = $row['C_Level'];
                                                        $domainLevel = $row['DT_Level'];
                                                        $mark = $row['Mark'];
                                
                                                        if (!isset($topics[$topicname])) {
                                                            $topics[$topicname] = array(
                                                                'C_Level' => $cLevel,
                                                                'C1' => '',
                                                                'C2' => '',
                                                                'C3' => '',
                                                                'C4' => '',
                                                                'C5' => '',
                                                                'C6' => '',
                                                                'Total' => 0
                                                            );
                                                        }
                                
                                                        $topics[$topicname][$cLevel][$domainLevel] = $mark;
                                                        $topics[$topicname]['Total'] += $mark;
                                
                                                        $courseIDs[$topicname] = $courseID;
                                                        $topicIDs[$topicname] = $topicID;
                                                    }
                                
                                                    // Count the number of non-zero marks for each DT_Level across all rows
                                                    foreach ($topics as $topicname => $marks) {
                                                        if ($marks[$marks['C_Level']]['C1'] != 0) $totalC1Questions++;
                                                        if ($marks[$marks['C_Level']]['C2'] != 0) $totalC2Questions++;
                                                        if ($marks[$marks['C_Level']]['C3'] != 0) $totalC3Questions++;
                                                        if ($marks[$marks['C_Level']]['C4'] != 0) $totalC4Questions++;
                                                        if ($marks[$marks['C_Level']]['C5'] != 0) $totalC5Questions++;
                                                        if ($marks[$marks['C_Level']]['C6'] != 0) $totalC6Questions++;
                                                    }
                                
                                                    echo '<table class="table table-bordered table-striped">';
                                                        echo '<tr>';
                                                        echo '<th>No</th>';
                                                        echo '<th>Topic Name</th>';
                                                        echo '<th>CLO</th>';
                                                        echo '<th>C1</th>';
                                                        echo '<th>C2</th>';
                                                        echo '<th>C3</th>';
                                                        echo '<th>C4</th>';
                                                        echo '<th>C5</th>';
                                                        echo '<th>C6</th>';
                                                        echo '<th>Total</th>';
                                                        echo '<th class="actionCol" colspan="2">Action</th>';
                                                        echo '</tr>';

                                                        // Loop through the topics array to display the data with correct course and topic IDs
                                                        foreach ($topics as $topicname => $marks) {
                                                            $courseID = $courseIDs[$topicname]; // Get the corresponding courseID
                                                            $topicID = $topicIDs[$topicname];   // Get the corresponding topicID

                                                            echo '<tr>';
                                                            echo '<td>' . $counter . '</td>';
                                                            echo '<td>' . $topicname . '</td>';
                                                            echo '<td>' . $marks['C_Level'] . '</td>';
                                                            echo '<td>' . (isset($marks[$marks['C_Level']]['C1']) ? $marks[$marks['C_Level']]['C1'] : '') . '</td>';
                                                            echo '<td>' . (isset($marks[$marks['C_Level']]['C2']) ? $marks[$marks['C_Level']]['C2'] : '') . '</td>';
                                                            echo '<td>' . (isset($marks[$marks['C_Level']]['C3']) ? $marks[$marks['C_Level']]['C3'] : '') . '</td>';
                                                            echo '<td>' . (isset($marks[$marks['C_Level']]['C4']) ? $marks[$marks['C_Level']]['C4'] : '') . '</td>';
                                                            echo '<td>' . (isset($marks[$marks['C_Level']]['C5']) ? $marks[$marks['C_Level']]['C5'] : '') . '</td>';
                                                            echo '<td>' . (isset($marks[$marks['C_Level']]['C6']) ? $marks[$marks['C_Level']]['C6'] : '') . '</td>';
                                                            echo '<td>' . $marks['Total'] . '</td>';
                                                            echo '<td class="text-center"><a class="btn btn-success" onclick="handleEdit(' . $courseID . ', ' . $topicID . ')"><i class="bi bi-pen"> Edit</i></a></td>';
                                                            echo '<td class="text-center"><a class="btn btn-danger" onclick="handleDelete(' . $courseID . ', ' . $topicID . ')"><i class="bi bi-trash3-fill"> Delete</i></a></td>';
                                                            echo '</tr>';
                                                            
                                                            $counter++;
                                                        }
                                                        echo '</table>';

                                                        echo '<br>';

                                                        // Calculate totals
                                                        $totalTopicCount = count($topics);
                                                        $totalC1Marks = $totalC2Marks = $totalC3Marks = $totalC4Marks = $totalC5Marks = $totalC6Marks = 0;

                                                        $counterTotal = 1;
                                                        foreach ($topics as $marks) {
                                                            $totalC1Marks += isset($marks[$marks['C_Level']]['C1']) ? $marks[$marks['C_Level']]['C1'] : 0;
                                                            $totalC2Marks += isset($marks[$marks['C_Level']]['C2']) ? $marks[$marks['C_Level']]['C2'] : 0;
                                                            $totalC3Marks += isset($marks[$marks['C_Level']]['C3']) ? $marks[$marks['C_Level']]['C3'] : 0;
                                                            $totalC4Marks += isset($marks[$marks['C_Level']]['C4']) ? $marks[$marks['C_Level']]['C4'] : 0;
                                                            $totalC5Marks += isset($marks[$marks['C_Level']]['C5']) ? $marks[$marks['C_Level']]['C5'] : 0;
                                                            $totalC6Marks += isset($marks[$marks['C_Level']]['C6']) ? $marks[$marks['C_Level']]['C6'] : 0;
                                                        }

                                                        echo '<table class="table table-bordered table-striped">';
                                                        echo '<tr>';                                
                                                        echo '<th>No</th>';
                                                        echo '<th>Total Topics</th>';
                                                        echo '<th>Total C1 Marks</th>';
                                                        echo '<th>Total C2 Marks</th>';
                                                        echo '<th>Total C3 Marks</th>';
                                                        echo '<th>Total C4 Marks</th>';
                                                        echo '<th>Total C5 Marks</th>';
                                                        echo '<th>Total C6 Marks</th>';
                                                        echo '</tr>';

                                                        echo '<tr>';                                                   
                                                        echo '<td>'. $counterTotal. '</td>';
                                                        echo '<td>' . $totalTopicCount . '</td>';
                                                        echo '<td>' . $totalC1Marks . '</td>';
                                                        echo '<td>' . $totalC2Marks . '</td>';
                                                        echo '<td>' . $totalC3Marks . '</td>';
                                                        echo '<td>' . $totalC4Marks . '</td>';
                                                        echo '<td>' . $totalC5Marks . '</td>';
                                                        echo '<td>' . $totalC6Marks . '</td>';
                                                        echo '</tr>';
                                                        $counterTotal++;
                                                        echo '</table>';
                                
                                                    // Add a new table to display the total number of questions for each DT_Level
                                                    echo '<table class="table table-bordered table-striped">';
                                                    echo '<tr>';
                                                    echo '<th>Total C1 Questions</th>';
                                                    echo '<th>Total C2 Questions</th>';
                                                    echo '<th>Total C3 Questions</th>';
                                                    echo '<th>Total C4 Questions</th>';
                                                    echo '<th>Total C5 Questions</th>';
                                                    echo '<th>Total C6 Questions</th>';
                                                    echo '</tr>';
                                
                                                    echo '<tr>';
                                                    echo '<td>' . $totalC1Questions . '</td>';
                                                    echo '<td>' . $totalC2Questions . '</td>';
                                                    echo '<td>' . $totalC3Questions . '</td>';
                                                    echo '<td>' . $totalC4Questions . '</td>';
                                                    echo '<td>' . $totalC5Questions . '</td>';
                                                    echo '<td>' . $totalC6Questions . '</td>';
                                                    echo '</tr>';
                                                    echo '</table>';
                                                } else {
                                                    echo '<p style="text-align: center; color: red; font-weight: bolder; font-size: 25px;">No items found.</p>';
                                                }
                                            } else {
                                                echo 'Error executing the query: ' . mysqli_error($conn);
                                            }
                                        }
                                    }
                                }
                            ?>                           
    
                        </div>
                        <!-- End of jpucontainer -->
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
        var modal = document.getElementById("id02");

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

        function handleEdit(courseID, topicID) {
            // Redirect to the editjpu.php page with the courseID and topicID as parameters
            window.location.href = 'editjpu.php?course_id=' + courseID + '&topic_id=' + topicID;
        }

        function handleDelete(courseID, topicID) {
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
                    window.location.href = 'deletejpu.php?course_id=' + courseID + '&topic_id=' + topicID;
                }
            });
        }
    </script>
    
</body>
</html>