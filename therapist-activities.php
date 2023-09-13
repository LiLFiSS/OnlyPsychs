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


if (isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $sql3 = " UPDATE appointments SET status = 'Rejected' WHERE AppID = '$delete_id' ";
    $delete_query = mysqli_query($conn, $sql3);


    if ($delete_query){
        date_default_timezone_set('America/Port_of_Spain');

        $find_search_1 = "SELECT * FROM appointments WHERE AppID = '$delete_id'";
        $find_search_1_query = mysqli_query($conn, $find_search_1);
        while ($user_find = mysqli_fetch_array($find_search_1_query)){
            $patient_ID = $user_find['PatientID'];
            $app_date2 = $user_find['AppDate'];
            $app_time2 = $user_find['AppTime'];
        }

        $CID = $patient_ID;
        $find_search_2 = "SELECT * FROM users WHERE UserID = '$CID'";
        $find_search_2_query = mysqli_query($conn, $find_search_2);
        while ($user_details = mysqli_fetch_array($find_search_2_query)){
            $user_fName = $user_details['first_name'];
            $user_lName = $user_details['last_name'];
        }


        $log_name = $firstName ." ". $lastName ." UserID:". $therapist_UID;
        $description = 'has rejected an appointment request from ' .$user_fName ." ". $user_lName;
        $task = 'Appointment Requests';
        $time = date("Y/m/d h:i:sa");


        $log_insert = " INSERT INTO logs (log_user, userID, log_description, task, log_time, status) 
                    VALUES  ('$log_name', '$therapist_UID', '$description', '$task', '$time', 'active') ";
        $result = mysqli_query($conn, $log_insert);

        $notification_desc = 'has rejected your appointment request for '. $app_date2 ." @ ". $app_time2;
        $notification_insert = "INSERT INTO notifications (sender_ID, receiverID, description, sent_date, status) 
                                VALUES ('$therapist_UID', '$CID', '$notification_desc', '$time', 'Active')";
        $notif_insert_query = mysqli_query($conn, $notification_insert);

        echo "<div class='alert alert-danger mov' role='alert'> Appointment Rejected! </div>";

        /*header( "refresh:4;url=activities.php" );*/
    } else {
        echo "<div class='alert alert-danger mov' role='alert'> Error Processing Request! </div>";
    }
}

// ============================ ACCEPTED ============================ //

if (isset($_GET['accept'])){
    $accept_id = $_GET['accept'];
    $sql_4 = " UPDATE appointments SET status = 'Accepted' WHERE AppID = '$accept_id' ";
    $accept_query = mysqli_query($conn, $sql_4);

    if ($accept_query){
        date_default_timezone_set('America/Port_of_Spain');

        $find_search_3 = "SELECT * FROM appointments WHERE AppID = '$accept_id'";
        $find_search_3_query = mysqli_query($conn, $find_search_3);
        while ($user_find2 = mysqli_fetch_array($find_search_3_query)){
            $patient_ID2 = $user_find2['PatientID'];
            $app_date3 = $user_find2['AppDate'];
            $app_time3 = $user_find2['AppTime'];
        }

        $CID2 = $patient_ID2;
        $find_search_4 = "SELECT * FROM users WHERE UserID = '$CID2'";
        $find_search_4_query = mysqli_query($conn, $find_search_4);
        while ($user_details2 = mysqli_fetch_array($find_search_4_query)){
            $user_fName2 = $user_details2['first_name'];
            $user_lName2 = $user_details2['last_name'];
        }

        $log_name = $firstName ." ". $lastName ." UserID:". $therapist_UID;
        $description = 'has rejected an appointment request for '. $user_fName2 ." ". $user_lName2;
        $task = 'Appointment Requests';
        $time = date("Y/m/d h:i:sa");

        $log_insert = " INSERT INTO logs (log_user, userID, log_description, task, log_time, status) 
                    VALUES  ('$log_name', '$therapist_UID', '$description', '$task', '$time', 'active') ";
        $result = mysqli_query($conn, $log_insert);

        $notification_desc = 'has accepted your appointment request for '. $app_date3 ." @ ". $app_time3;
        $notification_insert = "INSERT INTO notifications (sender_ID, receiverID, description, sent_date, status) 
                                VALUES ('$therapist_UID', '$CID2', '$notification_desc', '$time', 'Active')";
        $notif_insert_query = mysqli_query($conn, $notification_insert);

        $find_case = "SELECT * FROM cases WHERE patient_id = '$CID2'";
        $case_query = mysqli_query($conn, $find_case);

        if (!mysqli_num_rows($case_query) > 0){
            $case_insert = "INSERT INTO cases (therapist_id, patient_id, creation_date, case_description, Status) 
                        VALUES ('$therapist_UID', '$CID2', '$time', 'TBD', 'Active')";
            $insert_query = mysqli_query($conn, $case_insert);
        }

        echo "<div class='alert alert-success mov' role='alert'> Appointment Accepted! </div>";

        /*header( "refresh:4;url=activities.php" );*/
    } else {
        echo "<div class='alert alert-danger mov' role='alert'> Error Processing Request! </div>";
    }
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
                    <li>
                        <a href="therapist-home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href="clients-therapist.php"><i class="fa fa-users"></i> <span>Clients</span></a>
                    </li>
                    <li>
                        <a href="therapist-schedule.php"><i class="fa fa-calendar"></i> <span>Schedule</span></a>
                    </li>
                    <li class="active">
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
                    <h4 class="page-title">Appointment Request </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="activity">
                        <div class="activity-box">
                            <ul class="activity-list" >
                                <?php
                                $sql = "SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' AND Status = 'Pending'";
                                $select_requests = mysqli_query($conn, $sql) or die('query failed');
                                if (mysqli_num_rows($select_requests) > 0) {
                                    while ($fetch_requests = mysqli_fetch_assoc($select_requests)) {
                                        $app_id = $fetch_requests['AppID'];
                                        $user_id = $fetch_requests['PatientID'];
                                        $app_time = $fetch_requests['AppTime'];
                                        $app_date = $fetch_requests['AppDate'];
                                        $creation_date = $fetch_requests['CreationDate'];

                                        $find_client = "SELECT * FROM users WHERE UserID = '$user_id'";
                                        $find_query = mysqli_query($conn, $find_client);
                                        while ($find_client = mysqli_fetch_array($find_query)){
                                            $client_fName = $find_client['first_name'];
                                            $client_lName = $find_client['last_name'];
                                            $client_picture = $find_client['profile_picture'];
                                            ?>
                                            <li id="list-item">
                                                <div class="activity-user">
                                                    <a href="#" title="<?php echo $client_fName ." ". $client_lName ?>" data-toggle="tooltip" class="avatar">
                                                        <img alt="Lesley Grauer" src="assets/uploaded_img/<?php echo $client_picture ?>" class="img-fluid rounded-circle">
                                                    </a>
                                                </div>
                                                <div class="activity-content">
                                                    <div class="timeline-content">
                                                        <a href="#" class="name"><?php echo $client_fName ." ". $client_lName ?></a> requests an appointment with you on
                                                        <a href="#"><?php echo $app_date ." @". $app_time ?></a>
                                                        <span class="time"><?php echo $creation_date ?></span>
                                                    </div>
                                                </div>
                                                <a class="activity-delete" href="therapist-activities.php?delete=<?php echo $app_id ?>" onclick="return confirm('Are you sure you want to decline this appointment?');" title="Reject" type="submit">&times;</a>
                                                <a class="activity-accept" id="accept-btn" href="therapist-activities.php?accept=<?php echo $app_id ?> " title="Accept" type="submit"><i class=" fa fa-check"></i> </a>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                                ?>

                            </ul>

                            <script>
                                /*let acceptbtn = document.getElementById('accept-btn');
                                let list_item = document.getElementById('list-item');

                                // Show the target element on hover
                                list_item.addEventListener('mouseenter', function() {
                                    acceptbtn.style.display = 'revert';
                                });

                                // Hide the target element when not hovering
                                list_item.addEventListener('mouseleave', function() {
                                    acceptbtn.style.display = 'none';
                                });*/
                            </script>
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
