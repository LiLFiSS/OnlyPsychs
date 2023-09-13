<?php
$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

session_start();

$admin_UID = $_SESSION['admin_UID'];
$firstName = $_SESSION['adminName'];

if (!isset($admin_UID)) {
    header("Location: login.php");
}

$query = "SELECT * FROM users where UserID = '$admin_UID'";
$queryResult = mysqli_query($conn, $query);

while ($rows = mysqli_fetch_array($queryResult)){
    $lName = $rows['last_name'];
    $PFP = $rows['profile_picture'];
}

$PP = $PFP;

if (isset($_GET['delete'])){
$delete_id = $_GET['delete'];
$sql3 = " UPDATE logs SET status = 'inactive' WHERE log_ID = '$delete_id' ";
$delete_query = mysqli_query($conn, $sql3);

if ($delete_query){
    date_default_timezone_set('America/Port_of_Spain');

    $log_name = $firstName ." ". $lName;
    $description = 'has removed';
    $task = 'Log Entry';
    $time = date("Y/m/d h:i:sa");

    $log_insert = " INSERT INTO logs (log_user, userID, log_description, task, log_time, status) 
                    VALUES  ('$log_name', '$admin_UID', '$description', '$task', '$time', 'active') ";
    $result = mysqli_query($conn, $log_insert);

    echo "<div class='alert alert-success mov' role='alert'> Log Entry Deleted! </div>";

    /*header( "refresh:4;url=activities.php" );*/
} else {
    echo "<div class='alert alert-danger mov' role='alert'> Error Deleting! </div>";
}
}

?>


<!DOCTYPE html>
<html lang="en">


<!-- activities22:59-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link href="assets/img/OnlyPsychs-dark-blue-icon.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Activity Logs</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!--[if lt IE 9]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<?php
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
?>
<div class="main-wrapper">
    <div class="header">
        <div class="header-left">
            <a href="admin-home.php" class="logo">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img
                        src="assets/img/OnlyPsychs-black-white-words.png" height="30"></span>
            </a>
        </div>
        <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
        <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
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
            <li class="nav-item dropdown has-arrow">
                <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img"><img class="rounded-circle" src="assets/uploaded_img/<?php echo $PP?>" width="40" alt="Admin">
                            <span class="status online"></span></span>
                    <span><?php echo $firstName ?></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="profile.html">My Profile</a>
                    <a class="dropdown-item" href="edit-profile.html">Edit Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
        <div class="dropdown mobile-user-menu float-right">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                    class="fa fa-ellipsis-v"></i></a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile.html">My Profile</a>
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
                    <li>
                        <a href="therapists.php"><i class="fa fa-user-md"></i> <span>Therapists</span></a>
                    </li>
                    <li>
                        <a href="patients.php"><i class="fa fa-users"></i> <span>Clients</span></a>
                    </li>
                    <li>
                        <a href="users.php"><i class="fa fa-user"></i> <span>Users</span></a>
                    </li>
                    <!--<li>
                        <a href="question-bank.php"><i class="fa fa-check"></i> <span>Question Bank</span></a>
                    </li>-->
                    <li>
                        <a href="schedule.php"><i class="fa fa-calendar-check-o"></i>
                            <span>Therapists Schedule</span></a>
                    </li>
                    <li>
                        <a href="reviews.php"><i class="fa fa-star"></i> <span>Reviews</span></a>
                    </li>
                    <li class="active">
                        <a href="activities.php"><i class="fa fa-bell-o"></i> <span>Activities</span></a>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="fa fa-envelope"></i> <span> Messages</span> <span
                                class="menu-arrow"></span></a>
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
                <div class="col-sm-12">
                    <h4 class="page-title">Activities <a href="activities-trash.php" class="trash-can"><i class="fa fa-trash-o"></i></a> </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="activity">
                        <div class="activity-box">
                            <ul class="activity-list">
                                <?php
                                $sql = "SELECT * FROM logs WHERE status = 'active'  ORDER BY log_ID DESC ";
                                $select_logs = mysqli_query($conn, $sql) or die('query failed');
                                if (mysqli_num_rows($select_logs) > 0) {
                                    while ($fetch_logs = mysqli_fetch_assoc($select_logs)) {
                                        $userID = $fetch_logs['userID'];
                                        $sql4 = "SELECT * FROM users WHERE UserID = '$userID'";
                                        $result4 = mysqli_query($conn, $sql4);
                                        while ($fetch_users = mysqli_fetch_array($result4)){
                                            $pfp = $fetch_users['profile_picture'];
                                        ?>
                                        <li>
                                            <div class="activity-user">
                                                <a href="profile.html" title="<?php echo $fetch_logs['log_user'] ?>" data-toggle="tooltip" class="avatar">
                                                    <img alt="Lesley Grauer" src="assets/uploaded_img/<?php echo $pfp ?>" class="img-fluid rounded-circle">
                                                </a>
                                            </div>
                                            <div class="activity-content">
                                                <div class="timeline-content">
                                                    <a href="profile.html" class="name"><?php echo $fetch_logs['log_user']; ?></a> <?php echo $fetch_logs['log_description']; ?>
                                                    <a href="#"><?php echo $fetch_logs['task']; ?></a>
                                                    <span class="time"><?php echo $fetch_logs['log_time']; ?></span>
                                                </div>
                                            </div>
                                            <a class="activity-delete" href="activities.php?delete=<?php echo $fetch_logs['log_ID']; ?> " onclick="return confirm('Are you sure you want to delete this log entry?');" title="Delete" type="submit">&times;</a>
                                        </li>
                                        <?php
                                        }
                                    }
                                } else {
                                    echo '<p>No Activities Yet</p>';
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="delete_patient" class="modal fade delete-modal" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="#">
                    <div class="modal-body text-center">
                        <img src="assets/img/sent.png" alt="" width="50" height="46">
                        <input type="hidden" name="delete_id" id="delete_id">
                        <h3>Log Deleted Successfully!</h3>
                        <div class="m-t-20"> <a href="#" class="btn btn-white" data-dismiss="modal">Close</a>
                            <!--<button type="submit" class="btn btn-danger" name="delete">Delete</button>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="sidebar-overlay" data-reff=""></div>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/app.js"></script>

<!--<script>
    $(document).ready(function(){
        $('#addEventBtn').on('click', function(e){
            e.preventDefault();
            localStorage.setItem('openModal', '#addEventModal');
            let href = e.target.href;
            window.location.replace(href);
        });
    })
</script>-->

</body>


<!-- activities22:59-->
</html>