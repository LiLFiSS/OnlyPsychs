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


//  Get Client Info

$CID = $_GET['id'];
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

    if ($client_dob == '' || $client_dob == null){
        $client_dob = 'xx-xx-xxxx';
    }
}




?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
    <link href="assets/img/OnlyPsychs-3-x.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Client Records</title>
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

        .btn-primary{
            background-color: #5D3FD3;
        }

        .btn-primary:hover{
            background-image: linear-gradient(90deg, #00C0FF 0%, #FFCF00 49%, #FC4F4F 80%, #00C0FF 100%);
            animation:slidebg 5s linear infinite;
            border-color: transparent;
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
            <a href="therapist-home.php" class="logo">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-words.png" height="30"></span>
            </a>
        </div>
        <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
        <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown d-none d-sm-block">
                <?php
                $notification_query = " SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' ORDER BY AppID DESC ";
                $select_notifications = mysqli_query($conn, $notification_query) or die('query failed');
                $notifications_count = mysqli_num_rows($select_notifications);
                ?>
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-pill bg-danger float-right"><?php echo $notifications_count ?></span></a>
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
                        <a href="activities.html">View all Notifications</a>
                    </div>
                </div>
            </li>
            <!--<li class="nav-item dropdown d-none d-sm-block">
                <a href="javascript:void(0);" id="open_msg_box" class="hasnotifications nav-link"><i class="fa fa-comment-o"></i> <span class="badge badge-pill bg-danger float-right">8</span></a>
            </li>-->
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img"><img class="rounded-circle" src="assets/uploaded_img/<?php echo $PP?>" width="40" alt="Admin">
							<span class="status online"></span></span>
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
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile-therapist.php">My Profile</a>
                <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">Main</li>
                    <li >
                        <a href="therapist-home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="active">
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
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">Client Records </h4>
                </div>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <!--<a href="add-patient.php" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Patient</a>-->
                </div>
            </div>

            <div class="card-box profile-header m-b-20">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-view">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#"><img class="avatar" src="assets/uploaded_img/<?php echo $client_picture?>" alt=""></a>
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0"><?php echo $client_first_name ." ". $client_last_name ?></h3>
                                            <div class="staff-id">User ID : UID-00<?php echo  $client_ID ?></div>
                                            <div class="staff-msg"><a href="therapist-new-note.php?id=<?php echo $CID?>" class="btn btn-primary">Add Record</a></div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <span class="title">Contact Number:</span>
                                                <span class="text"><a href="#"><?php echo $client_phone_number ?></a></span>
                                            </li>
                                            <li>
                                                <span class="title">Email:</span>
                                                <span class="text"><a href="#"><?php echo $client_email ?></a></span>
                                            </li>
                                            <li>
                                                <span class="title">Birthday:</span>
                                                <span class="text"><?php echo $client_dob ?></span>
                                            </li>
                                            <li>
                                                <span class="title">Gender:</span>
                                                <span class="text"><?php echo $client_gender ?></span>
                                            </li>
                                            <li>
                                                <span class="title">Assigned Therapist:</span>
                                                <span class="text"><?php echo  $firstName ." ". $lastName?></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-border table-striped custom-table datatable mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Record Title</th>
                                <th>Creation Date</th>
                                <th>Last Updated</th>
                                <!--<th>Email</th>
                                <th>Phone Number</th>
                                <th>Status</th>-->
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $find_records = "SELECT * FROM records WHERE CID = '$CID' AND TID = '$therapist_UID'";
                            $select_records = mysqli_query($conn, $find_records) or die('query failed');
                            if (mysqli_num_rows($select_records) > 0){
                                while ($fetch_records = mysqli_fetch_assoc($select_records)){
                                    $record_ID = $fetch_records['recordID'];
                                    $record_title = $fetch_records['title'];
                                    $creation_date = $fetch_records['creation_date'];
                                    $last_updated = $fetch_records['last_update'];
                                    ?>
                                    <tr>
                                        <td><?php echo $record_ID ?></td>
                                        <td><?php echo $record_title ?></td>
                                        <td><?php echo $creation_date ?></td>
                                        <td><?php echo $last_updated ?></td>
                                        <td class="text-right">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="view-note.php?rid=<?php echo $record_ID ?>"><i class="fa fa-envelope-open m-r-5"></i> View</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<p>No Records Added For this Client Yet!</p>";
                            }
                            ?>

                            </tbody>
                        </table>
                        <div class="trash-btn">
                            <a href="clients-therapist-dropped.php"><span class="fa fa-trash fa-lg" style="margin-left: 10px; color: #4d4d4d;"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="notification-box">
            <div class="msg-sidebar notifications msg-noti">
                <div class="topnav-dropdown-header">
                    <span>Messages</span>
                </div>
                <div class="drop-scroll msg-list-scroll" id="msg_list">
                    <ul class="list-box">

                    </ul>
                </div>
                <!--<div class="topnav-dropdown-footer">
                    <a href="chat.html">See all messages</a>
                </div>-->
            </div>
        </div>
    </div>
    <!--<div id="delete_patient" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="delete-user.php" method="post">
                    <div class="modal-body text-center">
                        <img src="assets/img/sent.png" alt="" width="50" height="46">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <h3>Are you sure want to delete this Patient?</h3>
                        <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>-->

</div>
<div class="sidebar-overlay" data-reff=""></div>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/app.js"></script>
</body>


<!-- profile23:03-->
</html>
