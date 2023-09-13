<?php

session_start();

$admin_UID = $_SESSION['admin_UID'];

if (!isset($_SESSION['admin_UID'])){
    header("Location: login.php");
}

$admin_Email = $_SESSION['admin_Email'];
$fullName = $_SESSION['adminName'];

$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

$sql_pfp = "SELECT * FROM users WHERE UserID = '$admin_UID'";
$result2 = mysqli_query($conn, $sql_pfp);

while ($row21 = mysqli_fetch_array($result2)){
    $PFP = $row21['profile_picture'];
}

$PP = $PFP;

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
    <link href="assets/img/OnlyPsychs-dark-blue-icon.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Administrator Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<?php
ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL);
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
?>

<div class="main-wrapper">
    <div class="header">
        <div class="header-left">
            <a class="logo" href="admin-home.php">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-words.png" height="30"></span>
            </a>
        </div>
        <a href="javascript:void(0);" id="toggle_btn"><i class="fa fa-bars"></i></a>
        <a class="mobile_btn float-left" href="#sidebar" id="mobile_btn"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown">
                <?php
                $notification_query = " SELECT * FROM logs WHERE status = 'active'";
                $select_notifications = mysqli_query($conn, $notification_query) or die('query failed');
                $notifications_count = mysqli_num_rows($select_notifications);
                ?>
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span
                        class="badge badge-pill bg-danger float-right"><?php echo $notifications_count ?></span></a>
                <div class="dropdown-menu notifications">
                    <div class="topnav-dropdown-header">
                        <span>Notifications</span>
                    </div>
                    <div class="drop-scroll">
                        <ul class="notification-list">
                            <?php
                            $sql_2 = " SELECT * FROM logs WHERE status = 'active' ORDER BY log_ID DESC ";
                            $select_logs_2 = mysqli_query($conn, $sql_2) or die('query failed');
                            if (mysqli_num_rows($select_logs_2) > 0) {
                                while ($fetch_logs_2 = mysqli_fetch_assoc($select_logs_2)) {
                                    $userID = $fetch_logs_2['userID'];
                                    $get_pfp = "SELECT * FROM users WHERE UserID = '$userID'";
                                    $pfp_query = mysqli_query($conn, $get_pfp);
                                    while ($fetch_pfp2 = mysqli_fetch_array($pfp_query)){
                                        $pfp = $fetch_pfp2['profile_picture'];
                                    ?>
                                    <li class="notification-message">
                                        <a href="activities.php">
                                            <div class="media">
                                            <span class="avatar">
                                                <img alt="John Doe" src="assets/uploaded_img/<?php echo $pfp?>" class="img-fluid rounded-circle">
                                            </span>
                                                <div class="media-body">
                                                    <p class="noti-details"><span class="noti-title"><?php echo $fetch_logs_2['log_user']; ?></span> <?php echo $fetch_logs_2['log_description'] ?><spanclass="noti-title"><?php echo $fetch_logs_2['task']; ?></span></p>
                                                    <p class="noti-time"><span class="notification-time"><?php echo $fetch_logs_2['log_time']; ?></span></p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                }
                            } else {
                                echo '<p>No Notifications To Show!</p>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="activities.php">View all Notifications</a>
                    </div>
                </div>
            </li>
            <!--<li class="nav-item dropdown d-none d-sm-block">
                <a class="hasnotifications nav-link" href="javascript:void(0);" id="open_msg_box"><i
                        class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">8</span></a>
            </li>-->
            <li class="nav-item dropdown has-arrow">
                <a class="dropdown-toggle nav-link user-link" data-toggle="dropdown" href="#">
                        <span class="user-img">
                            <img alt="Admin" class="rounded-circle" src="assets/uploaded_img/<?php echo $PP; ?>" width="24">
                            <span class="status online"></span>
                        </span>
                    <span><?php echo $fullName;?></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="admin-profile.php">My Profile</a>
                    <a class="dropdown-item" href="edit-admin-profile.php">Edit Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
        <div class="dropdown mobile-user-menu float-right">
            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#"><i
                    class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="admin-profile.php">My Profile</a>
                <a class="dropdown-item" href="edit-admin-profile.php">Edit Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div class="sidebar-menu" id="sidebar-menu">
                <ul>
                    <li class="menu-title">Main</li>
                    <li class="active">
                        <a href="admin-home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="therapists.php"><i class="fa fa-user-md"></i> <span>Therapists</span></a>
                    </li>
                    <li>
                        <a href="patients.php"><i class="fa fa-users"></i> <span>Clients</span></a>
                    </li>
                    <li>
                        <a href="users.php"><i class="fa fa-user"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Therapists Schedule</span></a>
                    </li>
                    <li>
                        <a href="reviews.php"><i class="fa fa-star"></i> <span>Reviews</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-bell-o"></i> <span> Activities</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="compose.html">Active</a></li>
                            <li><a href="inbox.html">Trash</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-envelope"></i> <span> Messages</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="compose.html">Compose Mail</a></li>
                            <li><a href="inbox.html">Inbox</a></li>
                            <li><a href="mail-view.html">Mail View</a></li>
                        </ul>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-commenting-o"></i> <span> Blog</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="blog-details.html">Blog View</a></li>
                            <li><a href="add-blog.html">Add Blog</a></li>
                            <li><a href="edit-blog.html">Edit Blog</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="content">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        /*$totalTherapists = 0;*/
                        $sql = " SELECT * FROM users WHERE user_type = 'therapist' ";
                        $select_therapists = mysqli_query($conn, $sql) or die('query failed');
                        $num_of_therapists = mysqli_num_rows($select_therapists);
                        ?>
                        <span class="dash-widget-bg1"><i aria-hidden="true" class="fa fa-user-md"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?php echo $num_of_therapists?></h3>
                            <span class="widget-title1">Therapists <i aria-hidden="true" class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        /*$totalPatients = 0;*/
                        $sql2 = " SELECT * FROM users WHERE user_type = 'user' ";
                        $select_users = mysqli_query($conn, $sql2) or die('query failed');
                        $num_of_users = mysqli_num_rows($select_users);
                        ?>
                        <span class="dash-widget-bg2"><i class="fa fa-user-o"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?php echo $num_of_users?></h3>
                            <span class="widget-title2">Patients <i aria-hidden="true" class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        $sql3 = "SELECT * FROM cases";
                        $select_cases = mysqli_query($conn, $sql3) or die('query failed');
                        $num_of_cases = mysqli_num_rows($select_cases);
                        ?>
                        <span class="dash-widget-bg3"><i aria-hidden="true" class="fa fa-arrow-up"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?php echo $num_of_cases?></h3>
                            <span class="widget-title3">Cases <i aria-hidden="true" class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        /*$totalReviews = 0;*/
                        $sql4 = "SELECT * FROM reviews";
                        $select_reviews = mysqli_query($conn, $sql4) or die('query failed');
                        $num_of_reviews = mysqli_num_rows($select_reviews);
                        ?>
                        <span class="dash-widget-bg4"><i aria-hidden="true" class="fa fa-star"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?php echo $num_of_reviews?></h3>
                            <span class="widget-title4">Reviews <i aria-hidden="true" class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-title">
                                <h4>Client Total</h4>
                                <span class="float-right"><i aria-hidden="true" class="fa fa-caret-up"></i> 15% Higher than Last Month</span>
                            </div>
                            <canvas id="linegraph"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="chart-title">
                                <h4>Clients In</h4>
                                <div class="float-right">
                                    <ul class="chat-user-total">
                                        <li><i aria-hidden="true" class="fa fa-circle current-users"></i>GAD</li>
                                        <li><i aria-hidden="true" class="fa fa-circle old-users"></i> PTSD</li>
                                    </ul>
                                </div>
                            </div>
                            <canvas id="bargraph"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title d-inline-block">All Appointments</h4> <a class="btn float-right" style="background-color: #1FCECB; color: #fff;" href="appointments.html">View
                            all</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="d-none">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Doctor Name</th>
                                        <th>Timing</th>
                                        <th class="text-right">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql_a1 = "SELECT * FROM appointments WHERE Status = 'Pending' OR Status = 'Accepted' ORDER BY AppID DESC ";
                                    $result1 = mysqli_query($conn, $sql_a1);
                                    if (mysqli_num_rows($result1) > 0){
                                        while ($rows = mysqli_fetch_array($result1)){
                                            $PatientID = $rows['PatientID'];
                                            $TherapistID = $rows['TherapistID'];
                                            $AppDateTime = $rows['AppDate'];
                                            $Location = $rows['location'];
                                            $app_status = $rows['Status'];
                                            $sql_a2 = " SELECT * FROM users WHERE UserID = '$PatientID' ";
                                            $result3 = mysqli_query($conn, $sql_a2);
                                            while ($fetch_details = mysqli_fetch_array($result3)){
                                                $FistName_Patient = $fetch_details['first_name'];
                                                $LastName_Patient = $fetch_details['last_name'];
                                                $ProfilePhoto_Patient = $fetch_details['profile_picture'];
                                                $sql_a3 = " SELECT * FROM users WHERE UserID = '$TherapistID' ";
                                                $result4 = mysqli_query($conn, $sql_a3);
                                                while ($fetch_therapist_details = mysqli_fetch_array($result4)){
                                                    $FirstName_Therapist = $fetch_therapist_details['first_name'];
                                                    $LastName_Therapist = $fetch_therapist_details['last_name'];
                                                    ?>
                                                    <tr>
                                                        <td style="min-width: 200px;">
                                                            <a class="avatar" href="#"><img alt="" class="w-40 rounded-circle" src="assets/uploaded_img/<?php echo $ProfilePhoto_Patient ?>"></a>
                                                            <h2><a href="#"><?php echo $FistName_Patient ." ". $LastName_Patient; ?><span><?php echo $Location; ?></span></a></h2>
                                                        </td>
                                                        <td>
                                                            <h5 class="time-title p-0">Appointment With</h5>
                                                            <p>Dr. <?php echo $FirstName_Therapist ." ". $LastName_Therapist?></p>
                                                        </td>
                                                        <td>
                                                            <h5 class="time-title p-0">Timing</h5>
                                                            <p><?php echo $AppDateTime; ?></p>
                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            if ($app_status == 'Pending'){
                                                                echo  "<a href='therapist-activities.php' class='btn btn-outline-warning take-btn'>Pending</a>";
                                                            } else if ($app_status == 'Accepted') {
                                                                echo  "<a href='therapist-schedule.php' class='btn btn-outline-success take-btn'>In Progress</a>";
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                        }
                                    } else {
                                        echo '<div class="empty-table"><p>No Appointments Set Yet!</p></div>';
                                    }
                                    ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="card member-panel">
                        <div class="card-header bg-white">
                            <h4 class="card-title mb-0">Therapists</h4>
                        </div>
                        <div class="card-body">
                            <ul class="contact-list">
                                <?php
                                $sql5 = " SELECT * FROM therapist ";
                                $select_therapists_view = mysqli_query($conn, $sql5) or die('query failed');
                                if (mysqli_num_rows($select_therapists_view) > 0) {
                                    while ($fetch_therapists = mysqli_fetch_assoc($select_therapists_view)){
                                        $TID = $fetch_therapists['UserID'];
                                        $sql5 = " SELECT * FROM users WHERE UserID = '$TID'";
                                        $query_result = mysqli_query($conn, $sql5);
                                        while ($fetch_pfps = mysqli_fetch_array($query_result)){
                                            $TPFP = $fetch_pfps['profile_picture'];
                                            $License1 = $fetch_therapists['license_1'];
                                            $License2 = $fetch_therapists['license_2'];
                                            if ($License2 == '' || $License2 == null){
                                                $License = $License1;
                                            } else {
                                                $License = $License1 .", ". $License2;
                                            }
                                        ?>
                                        <li>
                                            <div class="contact-cont">
                                                <div class="float-left user-img m-r-10">
                                                    <a href="profile.html" title="John Doe"><img alt="" class="w-40 rounded-circle" src="assets/uploaded_img/<?php echo $TPFP ?>"><span
                                                            class="status away"></span></a>
                                                </div>
                                                <div class="contact-info">
                                                    <span class="contact-name text-ellipsis"><?php echo $fetch_pfps['first_name'] ." ". $fetch_therapists['lastName'] ?></span>
                                                    <span class="contact-date"><?php echo $License?></span>
                                                </div>
                                            </div>
                                        </li>
                                        <?php
                                        }
                                    }
                                } else {
                                    echo '<p>Nothing To Show!</p>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <a class="text-muted" href="therapists.php">View all Therapists</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sidebar-overlay" data-reff=""></div>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/Chart.bundle.js"></script>
<script src="assets/js/chart.js"></script>
<script src="assets/js/app.js"></script>

</body>


</html>