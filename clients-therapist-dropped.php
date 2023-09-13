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
    $sql_delete = "UPDATE cases SET Status = 'Inactive' WHERE patient_id = '$delete_id' ";
    $delete_query = mysqli_query($conn, $sql_delete);

    $findUserInfo = "SELECT * FROM users WHERE UserID = '$delete_id'";
    $query = mysqli_query($conn, $findUserInfo);
    while ($rows = mysqli_fetch_array($query)){
        $CFName = $rows['first_name'];
        $CLName = $rows['last_name'];
    }

    if ($delete_query){
        date_default_timezone_set('America/Port_of_Spain');

        $log_name = $firstName ." ". $lastName ."UserID: " .$TUserID;
        $description = 'has dropped the case for '. $CFName . " ". $CLName. ' using' ;
        $task = 'Client Cases';
        $time = date("Y/m/d h:i:sa");

        $log_insert = " INSERT INTO logs (userID, log_user, log_description, task, log_time, status) 
                    VALUES  ('$TUserID','$log_name', '$description', '$task', '$time', 'Active') ";
        $result = mysqli_query($conn, $log_insert);

        echo "<div class='alert alert-success mov' role='alert'> Case Removed! </div>";

        /*header( "refresh:4;url=activities.php" );*/
    } else {
        echo "<div class='alert alert-danger mov' role='alert'> Error Removing Case! </div>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
    <link href="assets/img/OnlyPsychs-3-x.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - My Profile</title>
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
                            $sql_2 = " SELECT * FROM appointments WHERE TherapistID = '$therapist_UID' ORDER BY AppID DESC ";
                            $select_logs_2 = mysqli_query($conn, $sql_2) or die('query failed');
                            if (mysqli_num_rows($select_logs_2) > 0) {
                                while ($fetch_logs_2 = mysqli_fetch_assoc($select_logs_2)) {
                                    ?>
                                    <li class="notification-message">
                                        <a href="activities.php">
                                            <div class="media">
                                            <span class="avatar">
                                                <img alt="John Doe" src="assets/img/user.jpg" class="img-fluid rounded-circle">
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
                            } else {
                                echo '<div class="empty-notification"><p>No Notifications To Show!</p></div>';
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
                    <li>
                        <a href="admin-home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li class="active">
                        <a href="clients-therapist.php"><i class="fa fa-users"></i> <span>Clients</span></a>
                    </li>
                    <li>
                        <a href="schedule.php"><i class="fa fa-calendar"></i> <span>Schedule</span></a>
                    </li>
                    <li>
                        <a href="reviews.php"><i class="fa fa-star"></i> <span>Reviews</span></a>
                    </li>
                    <li>
                        <a href="activities.php"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
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
                <div class="col-sm-4 col-3">
                    <h4 class="page-title">Client Cases - Inactive </h4>
                </div>
                <div class="col-sm-8 col-9 text-right m-b-20">
                    <!--<a href="add-patient.php" class="btn btn btn-primary btn-rounded float-right"><i class="fa fa-plus"></i> Add Patient</a>-->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-border table-striped custom-table datatable mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>DOB</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM cases WHERE therapist_id = '$TUserID' AND Status = 'Inactive'";
                            $select_users = mysqli_query($conn, $sql) or die('query failed');
                            if (mysqli_num_rows($select_users) > 0){
                                while ($fetch_users = mysqli_fetch_assoc($select_users)){
                                    $patientID = $fetch_users['patient_id'];
                                    $caseDesc = $fetch_users['case_description'];
                                    $status = $fetch_users['Status'];

                                    $sql2 = "SELECT * FROM users WHERE UserID = '$patientID'";
                                    $select_query = mysqli_query($conn, $sql2);

                                    while ($fetch_users2 = mysqli_fetch_array($select_query)){
                                        $Profile_Picture = $fetch_users2['profile_picture'];
                                        $ClientFName = $fetch_users2['first_name'];
                                        $ClientLName = $fetch_users2['last_name'];
                                        $Client_Email = $fetch_users2['email'];
                                        $DOB = $fetch_users2['dob'];
                                        $Client_PhoneNumber = $fetch_users2['phone_num'];

                                        ?>
                                        <tr>
                                            <td><?php echo $patientID ?></td>
                                            <td><img width="28" height="28" src="assets/uploaded_img/<?php echo $Profile_Picture ?>" class="rounded-circle m-r-5" alt=""> <?php echo $ClientFName ?> </td>
                                            <td><?php echo $ClientLName ?></td>
                                            <td><?php echo $DOB ?></td>
                                            <td><?php echo $Client_Email ?></td>
                                            <td><?php echo $Client_PhoneNumber ?></td>
                                            <td><?php
                                                if ($status == "Active"){
                                                    echo "<span class='custom-badge status-green'>$status</span>";
                                                } else{
                                                    echo "<span class='custom-badge status-red'>$status</span>";
                                                }
                                                ?>

                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="patient-records.php?=<?php echo $patientID ?>"><i class="fa fa-envelope m-r-5"></i> Records</a>
                                                        <!--<a class="dropdown-item" href="clients-therapist.php?delete=<?php /*echo $patientID */?>" type="submit"  onclick="return confirm('Are you sure you want to drop this client case')"><i class="fa fa-trash-o m-r-5 delete-btn"></i> Delete</a>-->
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
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
