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

$sql_t = " SELECT * FROM therapist WHERE UserID = '$therapist_UID' ";
$query = mysqli_query($conn, $sql_t);

while ($fetch_Therapist = mysqli_fetch_array($query)){
    $address = $fetch_Therapist['address'];
    $city = $fetch_Therapist['office_city'];
    $country = $fetch_Therapist['office_country'];
    $license1 = $fetch_Therapist['license_1'];
    $license2 = $fetch_Therapist['license_2'];
    $license_num1 = $fetch_Therapist['license_num_1'];
    $license_num2 = $fetch_Therapist['license_num_2'];
    $bio = $fetch_Therapist['biography'];

    $edu_name1 = $fetch_Therapist['institution_name_1'];
    $edu_degree1 = $fetch_Therapist['degree_1'];
    $edu_sy1 = $fetch_Therapist['start_year_1'];
    $edu_ey1 = $fetch_Therapist['end_year_1'];

    $edu_name2 = $fetch_Therapist['institution_name_2'];
    $edu_degree2 = $fetch_Therapist['degree_2'];
    $edu_sy2 = $fetch_Therapist['start_year_2'];
    $edu_ey2 = $fetch_Therapist['end_year_2'];

    $edu_name3 = $fetch_Therapist['institution_3'];
    $edu_degree3 = $fetch_Therapist['degree_3'];
    $edu_sy3 = $fetch_Therapist['start_year_3'];
    $edu_ey3 = $fetch_Therapist['end_year_3'];

    $exp_jd1 = $fetch_Therapist['job_title_1'];
    $exp_sy1 = $fetch_Therapist['experience_start_year_1'];
    $exp_ey1 = $fetch_Therapist['experience_end_year_2'];

    $exp_jd2 = $fetch_Therapist['job_title_2'];
    $exp_sy2 = $fetch_Therapist['experience_start_year_2'];
    $exp_ey2 = $fetch_Therapist['experience_end_year_2'];

    $exp_jd3 = $fetch_Therapist['job_title_3'];
    $exp_sy3 = $fetch_Therapist['exp_start_year_3'];
    $exp_ey3 = $fetch_Therapist['exp_end_year_3'];

    if ($license2 != '' || $license2 != null){
        $license1 = $license1 .",";
    }

}


$Office_Address = $address;
$Office_City = $city;
$Office_Country = $country;
$Therapist_License1 = $license1;
$Therapist_License2 = $license2;
$License_Num1 = $license_num1;
$License_Num2 = $license_num2;

$Bio = $bio;

/*--------EDUCATION--------*/

$EDU_name1 = $edu_name1;
$EDU_Degree1 = $edu_degree1;
$EDU_SY1 = $edu_sy1;
$EDU_EY1 = $edu_ey1;

$EDU_name2 = $edu_name2;
$EDU_Degree2 = $edu_degree2;
$EDU_SY2 = $edu_sy2;
$EDU_EY2 = $edu_ey2;

$EDU_name3 = $edu_name3;
$EDU_Degree3 = $edu_degree3;
$EDU_SY3 = $edu_sy3;
$EDU_EY3 = $edu_ey3;

/*--------EXPERIENCE--------*/

$EXP_JD1 = $exp_jd1;
$EXP_SY1 = $exp_sy1;
$EXP_EY1 = $exp_ey1;

$EXP_JD2 = $exp_jd2;
$EXP_SY2 = $exp_sy2;
$EXP_EY2 = $exp_ey2;

$EXP_JD3 = $exp_jd3;
$EXP_SY3 = $exp_sy3;
$EXP_EY3 = $exp_ey3;


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
    <div class="header" style="background-color: transparent;">
        <div class="header-left">
            <a href="therapist-home.php" class="logo">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img src="assets/img/Only-Psychs-logo-all-white.png" height="30"></span>
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

    <div class="landing-page-bg-img"></div>
    <div class="get-started mt-4">
        <div class="get-started-title"><h1>Welcome to OnlyPsychs <br> <?php echo $firstName ." " . $lastName ."!" ?></h1></div>
        <div class="get-started-msg">As a new therapist on OnlyPsychs, let's customize your profile so your potential clients can know who you are!</div>
        <div class="get-started-btn"><a href="create-therapist-profile.php">Customize Your Profile Now!</a></div>
    </div>


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

