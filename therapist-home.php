<?php

session_start();

$therapist_UID = $_SESSION['therapist_UID'];

if (!isset($_SESSION['therapist_UID'])){
    header("Location: login.php");
}

$therapist_Email = $_SESSION['therapist_Email'];
$firstName = $_SESSION['therapist_FirstName'];
$lastName = $_SESSION['therapist_LastName'];

$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

$sql_pfp = "SELECT * FROM users WHERE UserID = '$therapist_UID'";
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
    <link href="assets/img/Final.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Therapist Dashboard</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <style>
        .sidebar-menu li a:hover {
            color: #9682e3;
        }

        .sidebar-menu li.active a {
            color: #9682e3;
            background-color: #f3f3f3;
        }

        .dash-widget-bg1{
            background-color: #9682e3;
        }

        .dash-widget-info span.widget-title1{
            background: #9682e3;
        }

        .dash-widget-bg4{
            background: #FFD700;
        }

        .dash-widget-info span.widget-title4{
            background: #FFD700;
        }
    </style>
</head>

<body>

<?php
ini_set('display_errors', 'Off');
ini_set('error_reporting', E_ALL);
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
?>

<div class="main-wrapper">
    <div class="header" style="background-color: #5D3FD3;">
        <div class="header-left">
            <a class="logo" href="therapist-home.php">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-words.png" height="30"></span>
            </a>
        </div>
        <a href="javascript:void(0);" id="toggle_btn"><i class="fa fa-bars"></i></a>
        <a class="mobile_btn float-left" href="#sidebar" id="mobile_btn"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown">
                <?php
                $notification_query = " SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' AND Status = 'Pending' ORDER BY AppID DESC ";
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
                            $sql_2 = " SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' AND Status = 'Pending' ORDER BY AppID DESC ";
                            $select_requests_2 = mysqli_query($conn, $sql_2) or die('query failed');
                            if (mysqli_num_rows($select_requests_2) > 0) {
                                while ($fetch_request_2 = mysqli_fetch_assoc($select_requests_2)) {
                                    $log_id = $fetch_request_2['AppID'];
                                    $sender_id = $fetch_request_2['PatientID'];
                                    $sent_date = $fetch_request_2['CreationDate'];

                                    $find_log_user = "SELECT * FROM users WHERE UserID = '$sender_id'";
                                    $find_log_user_query = mysqli_query($conn, $find_log_user);
                                    while ($log_user_deets = mysqli_fetch_array($find_log_user_query)){
                                        $app_user_FN = $log_user_deets['first_name'];
                                        $app_user_LN = $log_user_deets['last_name'];
                                        $app_user_pp = $log_user_deets['profile_picture'];
                                        ?>
                                        <li class="notification-message">
                                            <a href="activities.php">
                                                <div class="media">
                                                            <span class="avatar">
                                                                <img alt="John Doe" src="assets/uploaded_img/<?php echo $app_user_pp?>" class="img-fluid rounded-circle">
                                                            </span>
                                                    <div class="media-body">
                                                        <p class="noti-details"><span class="noti-title"><?php echo $app_user_FN ." ". $app_user_LN; ?></span> has requested an <span class="noti-title">Appointment</span></p>
                                                        <p class="noti-time"><span class="notification-time"><?php echo $sent_date ?></span></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <?php
                                    }
                                }
                            } else {
                                echo '<p>No Requests Yet!</p>';
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="topnav-dropdown-footer">
                        <a href="therapist-activities.php">View all Notifications</a>
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
                            <img alt="Therapist" class="rounded-circle" src="assets/uploaded_img/<?php echo $PP?>" width="24">
                            <span class="status online"></span>
                        </span>
                    <span><?php echo $firstName;?></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="profile-therapist.php">My Profile</a>
                    <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
        <div class="dropdown mobile-user-menu float-right">
            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#"><i
                    class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile-therapist.php">My Profile</a>
                <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
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
                        <a href="therapist-home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="clients-therapist.php"><i class="fa fa-users"></i> <span>Clients</span></a>
                    </li>
                    <li>
                        <a href="therapist-schedule.php"><i class="fa fa-calendar"></i> <span>Schedule</span></a>
                    </li>
                    <li>
                        <a href="therapist-activities.php"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-envelope"></i> <span> Messages</span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a href="therapist-compose.php">Compose Mail</a></li>
                            <li><a href="inbox.html">Inbox</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="page-wrapper">
        <div class="content">
            <!-- ----------CARDS START----------- -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        $sql3 = " SELECT * FROM cases WHERE therapist_id = '$therapist_UID' AND Status = 'active' ";
                        $select_cases = mysqli_query($conn, $sql3) or die('query failed');
                        $num_of_cases = mysqli_num_rows($select_cases);
                        ?>
                        <span class="dash-widget-bg1"><i aria-hidden="true" class="fa fa-user-o"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?php echo $num_of_cases?></h3>
                            <span class="widget-title1">Client Cases <i aria-hidden="true" class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        $sql2 = " SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' AND Status = 'Pending'";
                        $select_appointments = mysqli_query($conn, $sql2) or die('query failed');
                        $num_of_appointments = mysqli_num_rows($select_appointments);
                        ?>
                        <span class="dash-widget-bg2"><i class="fa fa-bell-o"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?php echo $num_of_appointments?></h3>
                            <span class="widget-title2">Requests <i aria-hidden="true" class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        $sql3 = "SELECT * FROM records WHERE TID = '$therapist_UID'";
                        $select_records = mysqli_query($conn, $sql3) or die('query failed');
                        $num_of_records = mysqli_num_rows($select_records);
                        ?>
                        <span class="dash-widget-bg3"><i aria-hidden="true" class="fa fa-comment"></i></span>
                        <div class="dash-widget-info text-right">
                            <h3><?php echo $num_of_records?></h3>
                            <span class="widget-title3">Records <i aria-hidden="true" class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="dash-widget">
                        <?php
                        /*$totalReviews = 0;*/
                        $sql4 = "SELECT * FROM reviews where TID = '$therapist_UID'";
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
            <!-- ----------CARDS END----------- -->

            <div class="row">
                <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title d-inline-block">Upcoming Appointments</h4> <a href="therapist-activities.php" class="btn float-right" style="background-color: #9682e3; color: white;">View all</a>
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
                                    $sql_a1 = "SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' AND Status = 'Accepted' ";
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
                                                                echo  "<a href='therapist-activities.php' class='btn btn-outline-warning take-btn'>Take up</a>";
                                                            } else if ($app_status == 'Accepted') {
                                                                echo  "<a href='therapist-schedule.php' class='btn btn-outline-success take-btn'>View</a>";
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
                            <h4 class="card-title mb-0">Clients</h4>
                        </div>
                        <div class="card-body">
                            <ul class="contact-list">
                                <?php
                                $sql5 = "SELECT * FROM cases WHERE therapist_id = '$therapist_UID' AND Status = 'active'";
                                $select_patients_view = mysqli_query($conn, $sql5) or die('query failed');
                                if (mysqli_num_rows($select_patients_view) > 0) {
                                    while ($fetch_patients = mysqli_fetch_assoc($select_patients_view)){
                                        $PID = $fetch_patients['patient_id'];
                                        $CaseDesc = $fetch_patients['case_description'];
                                        $sql_users = " SELECT * FROM users WHERE UserID = '$PID'";
                                        $query_result = mysqli_query($conn, $sql_users);
                                        while ($fetch_patient_details = mysqli_fetch_array($query_result)){
                                            $Patient_PFP = $fetch_patient_details['profile_picture'];
                                            $Patient_FName = $fetch_patient_details['first_name'];
                                            $Patient_LName = $fetch_patient_details['last_name'];
                                            ?>
                                            <li>
                                                <div class="contact-cont">
                                                    <div class="float-left user-img m-r-10">
                                                        <a href="clients-therapist.php" title="John Doe"><img alt="" class="w-40 rounded-circle" src="assets/uploaded_img/<?php echo $Patient_PFP ?>"><span
                                                                class="status away"></span></a>
                                                    </div>
                                                    <div class="contact-info">
                                                        <span class="contact-name text-ellipsis"><?php echo $Patient_FName ." ". $Patient_LName ?></span>

                                                        <span class="contact-date"><?php echo $CaseDesc ?></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                } else {
                                    echo '<div class="empty-notification"><p">Nothing To Show!</p></div>';
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <a class="text-muted" href="therapists.php">View all Patients</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title d-inline-block">New Clients </h4> <a href="patients.html" class="btn float-right" style="background-color: #9682e3; color: #fff;">View all</a>
                        </div>
                        <div class="card-block">
                            <div class="table-responsive">
                                <table class="table mb-0 new-patient-table">
                                    <tbody>
                                    <?php
                                    $sql6 = " SELECT * FROM cases WHERE therapist_id = '$therapist_UID' AND Status = 'active' ORDER BY case_id DESC ";
                                    $select_patients_view_2 = mysqli_query($conn, $sql5) or die('query failed');
                                    if (mysqli_num_rows($select_patients_view_2) > 0){
                                        while ($fetch_patients_2 = mysqli_fetch_assoc($select_patients_view_2)){
                                            $PID_2 = $fetch_patients_2['patient_id'];
                                            $sql_users_2 = " SELECT * FROM users WHERE UserID = '$PID_2'";
                                            $query_result_2 = mysqli_query($conn, $sql_users_2);
                                            while ($fetch_patient_details_2 = mysqli_fetch_array($query_result_2)){
                                                $Patient_PFP_2 = $fetch_patient_details_2['profile_picture'];
                                                $Patient_FName_2 = $fetch_patient_details_2['first_name'];
                                                $Patient_LName_2 = $fetch_patient_details_2['last_name'];
                                                $Patient_Email = $fetch_patient_details_2['email'];
                                                $Patient_Phone_Num = $fetch_patient_details_2['phone_num'];
                                                $DOB = $fetch_patient_details_2['dob'];
                                                $Date = $DOB;
                                                $Date = explode('-', $Date);
                                                $Year = $Date[2];
                                                $Year_Current = date("Y");
                                                $Age = $Year_Current - $Year;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <img width="28" height="28" class="rounded-circle" src="assets/uploaded_img/<?php echo $Patient_PFP_2; ?>" alt="">
                                                        <h2><?php echo $Patient_FName_2 ." ". $Patient_LName_2; ?></h2>
                                                    </td>
                                                    <td><?php echo $Patient_Email; ?></td>
                                                    <td><?php echo $Patient_Phone_Num; ?></td>
                                                    <td><?php echo $Age; ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    } else {
                                        echo '<div class="empty-table"><p>Nothing To Show</p></div>';
                                    }
                                    ?>



                                    </tbody>
                                </table>
                            </div>
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