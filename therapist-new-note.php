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

//  CLIENT INFORMATION

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

    $Date = $client_dob;
    $Date = explode('-', $Date);
    $Year = $Date[2];
    $Year_Current = date("Y");
    $Age = $Year_Current - $Year;
}

if (isset($_POST["submit"])){
    date_default_timezone_set('America/Port_of_Spain');
    $note_title = $_POST['note-title'];
    $note_content = $_POST['note-content'];

    $TID = $therapist_UID;
    $creation_date = date("Y/m/d h:i:sa");
    $last_updated = date("Y/m/d h:i:sa");


    $new_note = "INSERT INTO records (TID, CID, title, content, creation_date, last_update) 
            VALUES ('$TID', '$CID', '" . mysqli_real_escape_string($conn, $note_title) . "', '" . mysqli_real_escape_string($conn, $note_content) . "', '$creation_date', '$last_updated')";
    $insert_query = mysqli_query($conn, $new_note);

    if ($insert_query){
        date_default_timezone_set('America/Port_of_Spain');

        $log_name = $firstName ." ". $lastName;
        $description = 'has added a new note entry for ';
        $task = 'Add New Record';
        $time = date("Y/m/d h:i:sa");

        $log_insert = " INSERT INTO logs (log_user, userID, log_description, task, log_time, status) 
                    VALUES  ('$log_name', '$therapist_UID', '$description', '$task', '$time', 'active') ";
        $result = mysqli_query($conn, $log_insert);

        echo "<div class='alert alert-success mov' role='alert'> Record Added! </div>";
    } else {
        echo "<div class='alert alert-danger mov' role='alert'> Error Adding Record! </div>";
    }


}

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, user-scalable=0" name="viewport">
    <link href="assets/img/OnlyPsychs-3-x.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Create Note Entry</title>
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
                        <a href="admin-home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
                    </li>
                    <li>
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

            <div class="client-content notes__sidebar">
                <div class="picture-wrap">
                    <a href="#"><img class="" src="assets/uploaded_img/<?php echo $client_picture?>" alt=""></a>

                </div>
                <div class="client-info">
                    <p >Name: <span><?php echo $client_first_name ." ". $client_last_name ?></span></p>
                    <p>Age: <span><?php echo $Age ?></span></p>
                </div>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="notes" id="app">
                    <div class="notes__sidebar">
                        <input class="notes__add" name="submit" type="submit" value="Save Note">
                        <div class="notes__list">
                            <?php
                            $select_notes = "SELECT * FROM records WHERE CID = '$CID' AND TID = '$therapist_UID'";
                            $note_query = mysqli_query($conn, $select_notes);
                            if (mysqli_num_rows($note_query) > 0){
                                while ($fetch_notes = mysqli_fetch_array($note_query)){
                                    $saved_title = $fetch_notes['title'];
                                    $updated2 = $fetch_notes['last_update'];
                                    $recordID = $fetch_notes['recordID'];
                                    ?>
                                    <a href="view-note.php?rid=<?php echo $recordID ?>">
                                        <div class="notes__list-item notes__list-item--selected mb-2">
                                            <div class="notes__small-title"><?php echo $saved_title ?></div>
                                            <div class="notes__small-body">Hidden Note Content</div>
                                            <div class="notes__small-updated"><?php echo $updated2 ?></div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            } else {
                                echo "<div>No Notes Added Yet</div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="notes__preview">
                        <input class="notes__title" name="note-title" type="text" placeholder="Title..." required>
                        <textarea class="notes__body" rows="30" name="note-content" placeholder="Content goes here..." required></textarea>
                    </div>
                </div>
            </form>
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
