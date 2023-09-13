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

$sql = "SELECT * FROM users WHERE UserID = '$therapist_UID'";
$result = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_array($result)){
    $PFP = $rows['profile_picture'];
    $gender = $rows['gender'];
    $dob = $rows['dob'];
    $phone_num = $rows['phone_num'];
    $userID = $rows['UserID'];
    $username = $rows['username'];
    $password = $rows['user_password'];
    $email = $rows['email'];
}

$PP = $PFP;
$Gender = $gender;
$Birthday = $dob;
$PhoneNumber = $phone_num;
$TUserID = $userID;
$Email = $email;
$Username = $username;
$Password = $password;

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


    $institution_3 = $fetch_Therapist['institution_3'];
    $degree_3 = $fetch_Therapist['degree_3'];
    $start_3 = $fetch_Therapist['start_year_3'];
    $end_3 = $fetch_Therapist['end_year_3'];

    $institution_2 = $fetch_Therapist['institution_name_2'];
    $degree_2 = $fetch_Therapist['degree_2'];
    $start_2 = $fetch_Therapist['start_year_2'];
    $end_2 = $fetch_Therapist['end_year_2'];

    $institution_1 = $fetch_Therapist['institution_name_1'];
    $degree_1 = $fetch_Therapist['degree_1'];
    $start_1 = $fetch_Therapist['start_year_1'];
    $end_1 = $fetch_Therapist['end_year_1'];

    $exp3 = $fetch_Therapist['job_title_3'];
    $exp_start3 = $fetch_Therapist['exp_start_year_3'];
    $exp_end3 = $fetch_Therapist['exp_end_year_3'];

    $exp2 = $fetch_Therapist['job_title_2'];
    $exp_start2 = $fetch_Therapist['experience_start_year_2'];
    $exp_end2 = $fetch_Therapist['experience_end_year_2'];

    $exp1 = $fetch_Therapist['job_title_1'];
    $exp_start1 = $fetch_Therapist['experience_start_year_1'];
    $exp_end1 = $fetch_Therapist['experience_end_year_1'];

    $bio = $fetch_Therapist['biography'];
}

$Office_Address = $address;
$Office_City = $city;
$Office_Country = $country;
$Therapist_License1 = $license1;
$Therapist_License2 = $license2;
$License_Num1 = $license_num1;
$License_Num2 = $license_num2;

$Institution_3 = $institution_3;
$Degree_3 = $degree_3;
$Start_Year_3 = $start_3;
$End_year_3 = $end_3;

$Institution_2 = $institution_2;
$Degree_2 = $degree_2;
$Start_Year_2 = $start_2;
$End_year_2 = $end_2;

$Institution_1 = $institution_1;
$Degree_1 = $degree_1;
$Start_Year_1 = $start_1;
$End_year_1 = $end_1;

$Bio = $bio;


if (isset($_POST['update'])){
    $Updated_FirstName = $_POST['first-name'];
    $Updated_LastName = $_POST['last-name'];
    $Updated_DOB = $_POST['date-of-birth'];
    $Updated_Gender = $_POST['gender-update'];
    $Updated_OfficeAddress = $_POST['address'];
    $Updated_City = $_POST['city'];
    $Updated_Country = $_POST['country'];
    $Updated_PhoneNumber = $_POST['phone-number'];
    $Updated_Bio = $_POST['biography'];

    /* ---------------------Education--------------------- */

    /*Education Most Recent*/
    $Updated_EDU_Institute_3 = $_POST['edu-name-3'];
    $Updated_EDU_Degree_3 = $_POST['edu-degree-3'];
    $Updated_EDU_Start_Year_3 = $_POST['edu-start-year-3'];
    $Updated_EDU_End_Year_3 = $_POST['edu-end-year-3'];

    /*Education Mid-Recent*/
    $Updated_EDU_Institute_2 = $_POST['edu-name-2'];
    $Updated_EDU_Degree_2 = $_POST['edu-degree-2'];
    $Updated_EDU_Start_Year_2 = $_POST['edu-start-year-2'];
    $Updated_EDU_End_Year_2 = $_POST['edu-end-year-2'];

    /*Education Least Recent*/
    $Updated_EDU_Institute_1 = $_POST['edu-name-1'];
    $Updated_EDU_Degree_1 = $_POST['edu-degree-1'];
    $Updated_EDU_Start_Year_1 = $_POST['edu-start-year-1'];
    $Updated_EDU_End_Year_1 = $_POST['edu-end-year-1'];

    /* ---------------------Experience--------------------- */

    /*Experience Most Recent*/
    $Updated_EXP_Job_Title_3 = $_POST['exp-pos-3'];
    $Updated_EXP_Start_Year_3 = $_POST['exp-start-year-3'];
    $Updated_EXP_End_Year_3 = $_POST['exp-end-year-3'];

    /*Experience Mid-Recent*/
    $Updated_EXP_Job_Title_2 = $_POST['exp-pos-2'];
    $Updated_EXP_Start_Year_2 = $_POST['exp-start-year-2'];
    $Updated_EXP_End_Year_2 = $_POST['exp-end-year-2'];

    /*Experience Least Recent*/
    $Updated_EXP_Job_Title_1 = $_POST['exp-pos-1'];
    $Updated_EXP_Start_Year_1 = $_POST['exp-start-year-1'];
    $Updated_EXP_End_Year_1 = $_POST['exp-end-year-1'];

    /* ---------------------License---------------------*/

    $Updated_License_Name_1 = $_POST['license-name-1'];
    $Updated_License_Number_1 = $_POST['license-number-1'];

    $Updated_License_Name_2 = $_POST['license-name-2'];
    $Updated_License_Number_2 = $_POST['license-number-2'];


    /* ---------------------Specialization---------------------*/


    /*Lets Update Boi*/
    $update = " UPDATE therapist SET firstName = '$Updated_FirstName', lastName = '$Updated_LastName', 
                                        address = '$Updated_OfficeAddress', office_city = '$Updated_City', office_country = '$Updated_Country',
                                        institution_name_1 = '$Updated_EDU_Institute_1', degree_1 = '$Updated_EDU_Degree_1', start_year_1 = '$Updated_EDU_Start_Year_1', end_year_1 = '$Updated_EDU_End_Year_1',
                                        institution_name_2 = '$Updated_EDU_Institute_2', degree_2 = '$Updated_EDU_Degree_2', start_year_2 = '$Updated_EDU_Start_Year_2', end_year_2 = '$Updated_EDU_End_Year_2',
                                        institution_3 = '$Updated_EDU_Institute_3', degree_3 = '$Updated_EDU_Degree_3', start_year_3 = $Updated_EDU_Start_Year_3, end_year_3  = '$Updated_EDU_End_Year_3',
                                        job_title_1 = '$Updated_EXP_Job_Title_1', experience_start_year_1 = '$Updated_EXP_Start_Year_1', experience_end_year_1 = '$Updated_EXP_End_Year_1',
                                        job_title_2 = '$Updated_EXP_Job_Title_2', experience_start_year_2 = '$Updated_EXP_Start_Year_2', experience_end_year_2 = '$Updated_EXP_End_Year_2',
                                        job_title_3 = '$Updated_EXP_Job_Title_3', exp_start_year_3 = '$Updated_EXP_Start_Year_3', exp_end_year_3 = '$Updated_EXP_End_Year_3',
                                        biography = '$Updated_Bio', license_1 = '$Updated_License_Name_1', license_num_1 = '$Updated_License_Number_1', license_2 = '$Updated_License_Name_2', license_num_2 = '$Updated_License_Number_2'
                                        WHERE UserID = '$therapist_UID' ";
    $update_therapists = mysqli_query($conn, $update);

    $update2 = " UPDATE users SET first_name = '$Updated_FirstName', last_name = '$Updated_LastName', 
                                    phone_num = '$Updated_PhoneNumber', gender = '$Updated_Gender', dob = '$Updated_DOB' 
                            WHERE UserID = '$therapist_UID' ";
    $update_user = mysqli_query($conn, $update2);

    if ($update_therapists && $update_user){
        date_default_timezone_set('America/Port_of_Spain');
        $log_name = $firstName ." ". $lastName;
        $UserID = $TUserID;
        $description = 'has edited therapist information for ' .$firstName ." ". $lastName. ' using';
        $task = 'Edit Therapist Profile';
        $time = date("Y/m/d h:i:sa");

        $sqlLog = "INSERT INTO logs (userID, log_user, log_description, task, log_time, status) VALUES ('$UserID', '$log_name', '$description', '$task', '$time', 'active')";
        $log_result = mysqli_query($conn, $sqlLog);

        echo "<div class='alert alert-success mov' role='alert'> Your Profile Has Been Updated Successfully! Redirecting... </div>";
        header( "refresh:20;url=profile-therapist.php" );
    } else {
        echo "<div class='alert alert-danger mov' role='alert'> Error Updating Profile! </div>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">


<!-- edit-profile23:03-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link href="assets/img/OnlyPsychs-3-x.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Edit Therapist Profile</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
    </style>

</head>

<body>
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
                        <span class="user-img"><img class="rounded-circle" src="assets/uploaded_img/<?php echo $PP; ?>" width="40" alt="Admin">
							<span class="status online"></span></span>
                    <span><?php echo $firstName; ?></span>
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
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Edit Profile</h4>
                </div>
            </div>
            <form method="post" onsubmit="return emptyConfirmPasswordBox()">
                <div class="card-box">
                    <h3 class="card-title">Basic Information</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-img-wrap">
                                <img class="inline-block" src="assets/uploaded_img/<?php echo $PP?>" alt="user">
                                <div class="fileupload btn">
                                    <span class="btn-text">edit</span>
                                    <input class="upload" name="pfp-edit" type="file">
                                </div>
                            </div>
                            <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">First Name</label>
                                            <input type="text" name="first-name" class="form-control floating" value="<?php echo $firstName; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Last Name</label>
                                            <input type="text" name="last-name" class="form-control floating" value="<?php echo $lastName; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus">
                                            <label class="focus-label">Date of Birth</label>
                                            <div class="cal-icon">
                                                <input class="form-control floating datetimepicker" name="date-of-birth" type="text" value="<?php echo $dob ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-focus select-focus">
                                            <label class="focus-label">Gender</label>
                                            <select name="gender-update" class="select form-control floating" required>
                                                <option value="Male" <?php if ($Gender === "Male")echo 'selected="selected"';?>>Male</option>
                                                <option value="Female" <?php if ($Gender === "Female")echo 'selected="selected"';?>>Female</option>
                                                <option value="Other"<?php if ($Gender === "other")echo 'selected="selected"';?>>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- -------------------------- Account Information -------------------------- -->

                <div class="card-box">
                    <h3 class="card-title">Account Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Username</label>
                                <input type="text" name="username" class="form-control floating" value="<?php echo $Username; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Email</label>
                                <input type="text" name="email" class="form-control floating" value="<?php echo $Email; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Password</label>
                                <input type="password" name="user-password" id="password" class="form-control floating" onfocus="passwordBoxFocus();" value="<?php echo $Password; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Confirm Password</label>
                                <input type="password" name="confirm-password" id="confirm-password" class="form-control floating" value="" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    let password_box = document.getElementById("password");
                    let confirm_password_box = document.getElementById("confirm-password");

                    function passwordBoxFocus() {
                        confirm_password_box.disabled = false;
                    }

                    function emptyConfirmPasswordBox() {
                        if (confirm_password_box.disabled === false){
                            if (confirm_password_box.value() === ''){
                                alert('Password Modified! Please confirm new password to proceed!')
                                document.addEventListener('submit', (e) =>{
                                    e.preventDefault()
                                });
                                return false;
                            }
                        }
                    }
                </script>

                <!-- -------------------------- Contact Information -------------------------- -->

                <div class="card-box">
                    <h3 class="card-title">Contact Information</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-focus">
                                <label class="focus-label">Office Address</label>
                                <input type="text" name="address" class="form-control floating" value="<?php echo $Office_Address; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">City</label>
                                <input type="text" name="city" class="form-control floating" value="<?php echo $Office_City; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Country</label>
                                <input type="text" name="country" class="form-control floating" value="<?php echo $Office_Country; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Postal Code</label>
                                <input type="text" class="form-control floating" value="10523">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Phone Number</label>
                                <input type="text" name="phone-number" class="form-control floating" value="<?php echo $PhoneNumber; ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <!--Biography-->

                <div class="card-box">
                    <h3 class="card-title">Biography</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea name="biography" class="form-control" placeholder="<?php echo $Bio; ?>" id="floatingTextarea2" style="height: 100px"></textarea>
                                <label for="floatingTextarea2"></label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-box">
                    <h3 class="card-title">Education Information <span class="text-muted" style="font-size: 12px; font-weight: 300; margin-left: 5px;">Highest</span></h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Institution</label>
                                <input name="edu-name-3" type="text" class="form-control floating" value="<?php echo $Institution_3; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Degree</label>
                                <input name="edu-degree-3" type="text" class="form-control floating" value="<?php echo $Degree_3; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Start Year</label>
                                <div class="cal-icon">
                                    <input type="text" name="edu-start-year-3" class="form-control floating" value="<?php echo $Start_Year_3 ;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Complete Date</label>
                                <div class="cal-icon">
                                    <input type="text" name="edu-end-year-3" class="form-control floating" value="<?php echo  $End_year_3; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-more">
                        <button class="btn" style="background-color: #5D3FD3; color: #fff;" type="button" onclick="showBox1()" id="add-more-edu-1" ><i class="fa fa-plus"></i> Add More Institutions</button>
                    </div>-->


                </div>

                <!--More Education Info-->

                <div class="card-box edu-box-2" id="box-2" style="display: revert">
                    <h3 class="card-title">Education Information </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Institution</label>
                                <input type="text" name="edu-name-2" class="form-control floating" value="<?php echo $Institution_2; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Degree</label>
                                <input type="text" name="edu-degree-2" class="form-control floating" value="<?php echo $Degree_2; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Start Year</label>
                                <div class="cal-icon">
                                    <input type="text" name="edu-start-year-2" class="form-control floating" value="<?php echo $Start_Year_2 ;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Complete Date</label>
                                <div class="cal-icon">
                                    <input type="text" name="edu-end-year-2" class="form-control floating" value="<?php echo $End_year_2; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-more-2">
                        <button type="button" onclick="showBox2()" class="btn" style="background-color: #5D3FD3; color: #fff;" id="add-more-edu-2"><i class="fa fa-plus"></i> Add More Institutions</button>
                        <button type="button" onclick="hideBox1()" class="btn btn-danger" id="remove-edu-1"><i class="fa fa-minus-circle"></i> </button>
                    </div>-->
                </div>

                <!--More Education Experience 3-->

                <div class="card-box edu-box-3" id="box-3" style="display: revert">
                    <h3 class="card-title">Education Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Institution</label>
                                <input type="text" name="edu-name-1" class="form-control floating" value="<?php echo $Institution_1; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Degree</label>
                                <input type="text" name="edu-degree-1" class="form-control floating" value="<?php echo $Degree_1; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Start Year</label>
                                <div class="cal-icon">
                                    <input type="text" name="edu-start-year-1" class="form-control floating" value="<?php echo $Start_Year_1 ;?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Complete Date</label>
                                <div class="cal-icon">
                                    <input type="text" name="edu-end-year-1" class="form-control floating" value="<?php echo $End_year_1; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-more-edu-3">
                        <button type="button" onclick="hideBox2()"  class="btn btn-danger" id="remove-edu-2"><i class="fa fa-minus-circle"></i> </button>
                    </div>-->
                </div>

                <script>

                    let edu_box = document.getElementById("box-2");
                    let edu_box_2 = document.getElementById("box-3")
                    let btn_div = document.getElementById("add-more");
                    let btn_div_2 = document.getElementById("add-more-edu-2");

                    let removeEduBtn_1 = document.getElementById("remove-edu-1");
                    let removeEduBtn_2 = document.getElementById("remove-edu-2");

                    function showBox1() {
                        edu_box.style.display = "block";
                        btn_div.style.display = "none";
                    }

                    function showBox2() {
                        edu_box_2.style.display = "block";
                        btn_div_2.style.display = "none";
                        removeEduBtn_1.style.display = "none";
                    }

                    function hideBox1(){
                        edu_box.style.display = "none";
                        btn_div.style.display = "revert";
                    }

                    function hideBox2() {
                        edu_box_2.style.display = "none";
                        btn_div_2.style.display = "revert";
                        removeEduBtn_1.style.display = "revert";
                    }
                </script>

                <!--Experience Information-->
                <div class="card-box">
                    <h3 class="card-title">Experience Information <span class="text-muted" style="font-size: 12px; font-weight: 300; margin-left: 5px;">Most Recent</span></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-focus">
                                <label class="focus-label">Job Position</label>
                                <input type="text" name="exp-pos-3" class="form-control floating" value="<?php echo $exp3; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Period From</label>
                                <div class="cal-icon">
                                    <input type="text" name="exp-start-year-3" class="form-control floating" value="<?php echo $exp_start3; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Period To</label>
                                <div class="cal-icon">
                                    <input type="text" name="exp-end-year-3" class="form-control floating " value="<?php echo $exp_end3; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-more-1">
                        <button type="button" onclick="showExpBox1();" id="add-exp-btn-1" class="btn" style="background-color: #5D3FD3; color: #fff;"><i class="fa fa-plus"></i> Add More Experience</button>
                    </div>-->
                </div>

                <!--EXPERIENCE INFORMATION 2-->

                <div class="card-box exp-box-1" id="exp-box-1" style="display: revert">
                    <h3 class="card-title">Experience Information</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-focus">
                                <label class="focus-label">Job Position</label>
                                <input type="text" name="exp-pos-2" class="form-control floating" value="<?php echo $exp2; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Period From</label>
                                <div class="cal-icon">
                                    <input type="text" name="exp-start-year-2" class="form-control floating" value="<?php echo $exp_start2; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Period To</label>
                                <div class="cal-icon">
                                    <input type="text" name="exp-end-year-2" class="form-control floating " value="<?php echo $exp_end2; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-more-2">
                        <button type="button" onclick="showExpBox2();" class="btn" id="add-exp-btn-2" style="background-color: #5D3FD3; color: #fff;"><i class="fa fa-plus"></i> Add More Experience</button>
                        <button type="button" onclick="removeExpBox1();"  class="btn btn-danger" id="remove-exp-1"><i class="fa fa-minus-circle"></i> </button>
                    </div>-->
                </div>

                <!--EXPERIENCE INFORMATION 3-->

                <div class="card-box exp-box-2" id="exp-box-2" style="display: revert">
                    <h3 class="card-title">Experience Information <span class="text-muted" style="font-size: 12px; font-weight: 300; margin-left: 5px;">Least Recent</span></h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-focus">
                                <label class="focus-label">Job Position</label>
                                <input type="text" name="exp-pos-1" class="form-control floating" value="<?php echo $exp1; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Period From</label>
                                <div class="cal-icon">
                                    <input type="text" name="exp-start-year-1" class="form-control floating" value="<?php echo $exp_start1; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">Period To</label>
                                <div class="cal-icon">
                                    <input type="text" name="exp-end-year-1" class="form-control floating " value="<?php echo $exp_end1; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-more">
                        <a href="#" class="btn "><i class="fa fa-plus"></i> Add More Experience</a>
                        <button type="button" onclick="removeExpBox2()"  class="btn btn-danger" id="remove-exp-2"><i class="fa fa-minus-circle"></i> </button>
                    </div>-->
                </div>

                <script>
                    let exp_box1 = document.getElementById("exp-box-1")
                    let exp_btn1 = document.getElementById("add-exp-btn-1");

                    let add_more_btn_div = document.getElementById("add-more-1");
                    let add_more_btn_div2 = document.getElementById("add-more-2");

                    let exp_box2 = document.getElementById("exp-box-2");
                    let exp_btn2 = document.getElementById("add-exp-btn-2");

                    let remove_exp_btn_1 = document.getElementById("remove-exp-1");
                    let remove_exp_btn_2 = document.getElementById("remove-exp-2");

                    // Show Experience Boxes On CLick
                    function showExpBox1() {
                        exp_box1.style.display = "block";
                        add_more_btn_div.style.display = "none";
                    }

                    function showExpBox2(){
                        exp_box2.style.display = "block";
                        exp_btn2.style.display = "none";
                        remove_exp_btn_1.style.display = "none";
                        /*add_more_btn_div2.style.display = "none";*/
                    }

                    // Remove Experience Boxes On CLick

                    function removeExpBox1() {
                        exp_box1.style.display = "none";
                        add_more_btn_div.style.display = "revert";
                    }

                    function removeExpBox2(){
                        exp_box2.style.display = "none";
                        exp_btn2.style.display = "revert";
                        remove_exp_btn_1.style.display = "revert";
                    }

                </script>

                <div class="card-box">
                    <h3 class="card-title">License Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">License Name</label>
                                <input type="text" name="license-name-1" class="form-control floating" value="<?php echo $Therapist_License1; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">License Number</label>
                                <input type="text" name="license-number-1" class="form-control floating" value="<?php echo $License_Num1 ?>">
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-moreL-1">
                        <button type="button" onclick="showLicenseBox()" id="add-lic-btn-1" class="btn" style="background-color: #5D3FD3; color: #fff;"><i class="fa fa-plus"></i> Add Another License</button>
                    </div>-->
                </div>

                <div class="card-box license-box" id="lic-box" style="display: revert">
                    <h3 class="card-title">License Information</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">License Name</label>
                                <input type="text" name="license-name-2" class="form-control floating" value="<?php echo $Therapist_License2 ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-focus">
                                <label class="focus-label">License Number</label>
                                <input type="text" name="license-number-2" class="form-control floating" value="<?php echo $License_Num2 ?>">
                            </div>
                        </div>
                    </div>
                    <!--<div class="add-more" id="add-moreL-1">
                        <button type="button" onclick="hideLicenseBox();"  class="btn btn-danger" id="remove-exp-2"><i class="fa fa-minus-circle"></i> </button>
                    </div>-->
                </div>

                <script>
                    let license_box1 = document.getElementById("lic-box");
                    let add_license_div = document.getElementById("add-moreL-1");
                    let add_license_btn = document.getElementById("add-lic-btn-1");

                    function showLicenseBox() {
                        license_box1.style.display = "block";
                        add_license_div.style.display = "none";
                    }

                    function hideLicenseBox() {
                        license_box1.style.display = "none";
                        add_license_div.style.display = "revert";
                    }
                </script>

                <div class="text-center m-t-20">
                    <button class="btn submit-btn" style="background-color: #5D3FD3; color: #fff;" name="update" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="sidebar-overlay" data-reff=""></div>
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="js/script.js"></script>
</body>


<!-- edit-profile23:05-->
</html>
