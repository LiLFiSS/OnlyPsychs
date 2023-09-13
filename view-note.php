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

$sql_TU = "SELECT * FROM users WHERE UserID = '$therapist_UID'";
$result2 = mysqli_query($conn, $sql_TU);

while ($row21 = mysqli_fetch_array($result2)){
    $PFP = $row21['profile_picture'];
    $gender = $row21['gender'];
    $dob = $row21['dob'];
    $phone_num = $row21['phone_num'];
    $userID = $row21['UserID'];
}

$PP = $PFP;
$Gender = $gender;
$Birthday = $dob;
$PhoneNumber = $phone_num;
$TUserID = $userID;


// Get Record Info
$RID = $_GET['rid'];
$record_search = "SELECT * FROM records WHERE recordID = '$RID'";
$record_query = mysqli_query($conn, $record_search);
while ($fetch_record_info = mysqli_fetch_array($record_query)){
    $record_title = $fetch_record_info['title'];
    $record_content = $fetch_record_info['content'];
    $creation_date = $fetch_record_info['creation_date'];
    $last_updated = $fetch_record_info['last_update'];
    $clientID = $fetch_record_info['CID'];
}

//  Get Client Info

$CID = $clientID;
$sql = "SELECT * FROM users WHERE UserID = '$CID'";
$query_result = mysqli_query($conn, $sql);

while ($fetch_client = mysqli_fetch_array($query_result)){
    $client_picture = $fetch_client['profile_picture'];
    $client_first_name = $fetch_client['first_name'];
    $client_last_name = $fetch_client['last_name'];
    $client_dob = $fetch_client['dob'];
    $client_gender = $fetch_client['gender'];
    $client_phone_number = $fetch_client['phone_num'];
    $client_email = $fetch_client['email'];
    $client_ID = $fetch_client['UserID'];

    $Date = $client_dob;
    $Date = explode('-', $Date);
    $Year = $Date[2];
    $Year_Current = date("Y");
    $Age = $Year_Current - $Year;
}


?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
    <link href="assets/img/OnlyPsychs-3-x.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - View Client Record</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/notes-style.css">
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

        .print-btn:hover{
            border-color: transparent;
            background-image: linear-gradient(90deg, #00C0FF 0%, #FFCF00 49%, #FC4F4F 80%, #00C0FF 100%);
            animation:slidebg 5s linear infinite;
        }

        @media print {
            .header{
                display: none;
            }

            .sidebar{
                display: none;
            }

            .page-title{
                display: none;
            }

            .mail-view-action{
                display: none;
            }

            .card-box{
                margin-left: -10rem;
                /*width: 100vh;*/
            }

            .mail-view-title{
                font-size: 5rem;
            }

            body{
                font-size: 2rem;
            }

            .update-ting{
                display: none;
            }
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
            <a class="logo" href="admin-home.php">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-words.png" height="30"></span>
            </a>
        </div>
        <a href="javascript:void(0);" id="toggle_btn"><i class="fa fa-bars"></i></a>
        <a class="mobile_btn float-left" href="#sidebar" id="mobile_btn"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown">
                <?php
                $notification_query = " SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' ORDER BY AppID DESC ";
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

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">View Patient Note for <span style="color: #5D3FD3; font-weight: 600"><?php echo $client_first_name ." ". $client_last_name ?></span> </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="mailview-content">
                            <div class="mailview-header">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <div class="text-ellipsis m-b-10">
                                            <span class="mail-view-title"><?php echo $record_title ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="mail-view-action">

                                            <button type="submit" name="delete" class="btn btn-white btn-sm"  data-toggle="tooltip" title="Delete"> <i class="fa fa-trash-o"></i></button>

                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Edit"> <i class="fa fa-edit"></i></button>

                                            <button type="button" class="btn btn-white btn-sm" data-toggle="tooltip" title="Reply"> <i class="fa fa-download"></i></button>

                                            <button type="button" class="btn btn-white btn-sm print-btn" data-toggle="tooltip" onclick="window.print()" title="Oh Yeah, Print it!"> <i class="fa fa-print"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="sender-info">
                                    <div class="sender-img">
                                        <img width="40" alt="" src="assets/uploaded_img/<?php echo $client_picture ?>" class="rounded-circle">
                                    </div>
                                    <div class="receiver-details float-left">
                                        <span class="sender-name"><?php echo $client_first_name ." ". $client_last_name ?></span>
                                        <span class="receiver-name">Age: <?php echo $Age ?>
                                            </span>
                                    </div>
                                    <div class="mail-sent-time">
                                        <span class="mail-time"><?php echo $creation_date?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="mailview-inner">
                                <p class="record-content"><?php echo $record_content ?></p>
                                <p class="update-ting">Last Updated: <?php echo $last_updated?>,
                                    <br>Therapist ID: TR-000<?php echo $therapist_UID ?></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sidebar-overlay" data-reff=""></div>

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
