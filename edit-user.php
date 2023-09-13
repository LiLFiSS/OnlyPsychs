<?php
$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

session_start();

$admin_UID = $_SESSION['admin_UID'];
$firstName = $_SESSION['adminName'];

if (!isset($admin_UID)){
    header("Location: login.php");
}

$query = "SELECT * FROM users where UserID = '$admin_UID'";
$queryResult = mysqli_query($conn, $query);

while ($rows = mysqli_fetch_array($queryResult)){
    $lName = $rows['last_name'];
}


$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE UserID = '$id'";
$result = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_array($result)){
    $First_Name = $rows['first_name'];
    $Last_Name = $rows['last_name'];
    $Phone_Num = $rows['phone_num'];
    $Email = $rows['email'];
    $Gender = $rows['gender'];
    $User_Type = $rows['user_type'];
    $Status = $rows['status'];
    $Username = $rows['username'];
    $Password = $rows['user_password'];
    $DOB = $rows['dob'];
    $PFP = $rows['profile_picture'];
}

$FN = $First_Name;
$LN = $Last_Name;
$UT = $User_Type;


$nameRegex = "/^[A-Z]'?[- a-zA-Z-À-ÿ]*$/";
$emailRegex = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
$phoneNumRegex = "/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/";
$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/";

$flag = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["first-name"])) {
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>First Name Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($nameRegex, $_POST["first-name"]) == 0)) {
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>First Name contains illegal characters!</div>";
            $flag = false;

            $First_Name_Updated = "";
        } else {
            $First_Name_Updated = $_POST['first-name'];
        }
    }

//    Last Name Validation

    if (empty($_POST["last-name"])) {
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Last Name Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($nameRegex, $_POST["last-name"]) == 0)) {
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Last Name contains illegal characters!</div>";
            $flag = false;

            $Last_Name_Updated = "";
        } else {
            $Last_Name_Updated = $_POST['last-name'];
        }
    }

//    Phone Number Validation

    if (empty($_POST["phone-no"])) {
        echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Phone Number Field is Empty!</div>";
        $flag = false;
    } else {
        if ((preg_match($phoneNumRegex, $_POST["phone-no"]) == 0)) {
            echo "<div class='alert alert-danger mov flex-column align-content-center' role='alert'>Phone Number Format Illegal!</div>";
            $flag = false;

            $Phone_Num_Updated = "";
        } else {
            $Phone_Num_Updated = $_POST['phone-no'];
        }
    }


    if ($flag) {

        $Username_Updated = $_POST['username'];
        $DOB_Updated = $_POST['dob'];
        $Gender_Updated = $_POST['gender'];
        $Status_Updated = $_POST['status'];
        $User_Type_Updated = $_POST['user-type'];


        if ($User_Type_Updated == 'therapist') {
            $find = " SELECT * FROM therapist where UserID = '$id'";
            $find_result = mysqli_query($conn, $find);
            if (mysqli_num_rows($find_result) < 1) {
                $sql_insert = " INSERT INTO therapist (UserID, firstName, lastName, address, office_city, office_country, institution_name_1, degree_1, start_year_1, end_year_1, institution_name_2, degree_2, start_year_2, end_year_2, institution_3, degree_3, start_year_3, end_year_3, job_title_1, experience_start_year_1, experience_end_year_1, job_title_2, experience_start_year_2, experience_end_year_2, job_title_3, exp_start_year_3, exp_end_year_3, biography, license_1, license_num_1, license_2, license_num_2)  
                        VALUES ('$id', '$First_Name_Updated', '$Last_Name_Updated', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '','','','','','','','', '', '') ";
                $insert_result = mysqli_query($conn, $sql_insert);

                date_default_timezone_set('America/Port_of_Spain');
                $log_name_2 = $firstName . " " . $lName;
                $description_2 = 'has set user type for ' . $FN . " " . $LN . ' from ' . $UT . ' to';
                $task_2 = 'Therapist';
                $time_2 = date("Y/m/d h:i:sa");

                $log_insert = " INSERT INTO logs (log_user, log_description, task, log_time, status) 
                        VALUES ('$log_name_2','$description_2', '$task_2', '$time_2', 'active' )";
                $log_request = mysqli_query($conn, $log_insert);
            }
        }

        $sql2 = "UPDATE users SET first_name = '$First_Name_Updated', last_name = '$Last_Name_Updated', 
                                phone_num = '$Phone_Num_Updated', gender = '$Gender_Updated', username = '$Username_Updated', 
                                user_type = '$User_Type_Updated', status = '$Status_Updated', dob = '$DOB_Updated' WHERE UserID = '$id'";
        $update_user = mysqli_query($conn, $sql2);

        $PFP_Update_Image = $_FILES['update_image']['name'];
        $PFP_Update_Image_TMP_Name = $_FILES['update_image']['tmp_name'];
        $PFP_Update_Image_Size = $_FILES['update_image']['size'];
        $update_folder = 'assets/uploaded_img/' . $PFP_Update_Image;
        $update_old_image = $_POST['update_old_image'];

        if (!empty($PFP_Update_Image)) {
            if ($PFP_Update_Image_Size > 2000000) {
                echo "<div class='alert alert-danger mov' role='alert'> FILE TOO LARGE! </div>";
            } else {
                $sql3 = "UPDATE users SET profile_picture = '$PFP_Update_Image' WHERE  UserID = '$id'";
                mysqli_query($conn, $sql3) or die('query failed');
                move_uploaded_file($PFP_Update_Image_TMP_Name, $update_folder);
                $path = 'assets/uploaded_img/' . $update_old_image;
                unlink($update_old_image);
            }
        }

        if ($update_user) {
            $First_Name = "";
            $Last_Name = "";
            $Phone_Num = "";
            $Email = "";
            $Username = "";
            $Password = "";
            $DOB = "";

            date_default_timezone_set('America/Port_of_Spain');
            $log_name = $firstName . " " . $lName . " $admin_UID";
            $description = 'has edited user information for ' . $FN . " " . $LN . ' using';
            $task = 'Edit User';
            $time = date("Y/m/d h:i:sa");

            $sqlLog = "INSERT INTO logs (log_user, log_description, task, log_time, status) VALUES ('$log_name', '$description', '$task', '$time', 'active')";
            $log_result = mysqli_query($conn, $sqlLog);

            echo "<div class='alert alert-success mov' role='alert'> User Info Updated Successfully! Redirecting... </div>";
            header("refresh:4;url=users.php");
        } else {
            echo "<div class='alert alert-danger mov' role='alert'> Error Updating User Info! </div>";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">


<!-- edit-user24:06-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link href="assets/img/OnlyPsychs-dark-blue-icon.ico" rel="shortcut icon" type="image/x-icon">
    <title>OnlyPsychs - Edit User</title>
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
ini_set('error_reporting', E_ALL);
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);
?>

<div class="main-wrapper">
    <div class="header">
        <div class="header-left">
            <a href="admin-home.php" class="logo">
                <img alt="" height="45" src="assets/img/OnlyPsycs-logo-light.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-photoshop-edit-x.png" height="30"></span>
            </a>
        </div>
        <a id="toggle_btn" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
        <a id="mobile_btn" class="mobile_btn float-left" href="#sidebar"><i class="fa fa-bars"></i></a>
        <ul class="nav user-menu float-right">
            <li class="nav-item dropdown d-none d-sm-block">
                <?php
                $notification_query = " SELECT * FROM logs WHERE status = 'active' ";
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
                            $sql_2 = " SELECT * FROM logs WHERE status = 'active' ";
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
                        <span class="user-img"><img class="rounded-circle" src="assets/img/user.jpg" width="40" alt="Admin">
                                <!--<span class="status online"></span>-->
                        </span>
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
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
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
                        <a href="patients.php"><i class="fa fa-wheelchair"></i> <span>Patients</span></a>
                    </li>
                    <li class="active">
                        <a href="users.php"><i class="fa fa-user"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="question-bank.php"><i class="fa fa-check"></i> <span>Question Bank</span></a>
                    </li>
                    <li>
                        <a href="schedule.php"><i class="fa fa-calendar-check-o"></i> <span>Therapists Schedule</span></a>
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
                <div class="col-lg-8 offset-lg-2">
                    <h4 class="page-title">Edit User</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input style="border: 1px solid #888;" class="form-control" type="text" name="first-name" value="<?php echo $First_Name; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input style="border: 1px solid #888;" class="form-control" type="text" name="last-name" value="<?php echo $Last_Name; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input style="border: 1px solid #888;" class="form-control" type="text" name="username" autocomplete="off" value="<?php echo $Username; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input style="border: 1px solid #888;" class="form-control" type="email" name="user-email" value="<?php echo $Email ?>" disabled required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input style="border: 1px solid #888;" class="form-control" type="password" name="user-password" value="<?php echo $Password ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password </label>
                                    <input style="border: 1px solid #888;" class="form-control" type="password" name="confirm-password" value="<?php echo $Password ?>" disabled>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Date of Birth</label>
                                    <div class="cal-icon">
                                        <input style="border: 1px solid #888;" type="text" class="form-control datetimepicker" name="dob" value="<?php echo $DOB?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group gender-select">
                                    <label class="gen-label">Gender:</label>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" class="form-check-input" <?php if ($Gender === "Male")echo 'checked="checked"';?> value="male" required>Male
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" class="form-check-input" <?php if ($Gender === "Female")echo 'checked="checked"';?> value="female" required>Female
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" class="form-check-input" <?php if ($Gender === "Other")echo 'checked="checked"';?> value="other" required>Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input style="border: 1px solid #888;" class="form-control" autocomplete="off" type="text" name="phone-no" value="<?php echo $Phone_Num; ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Your avatar:</label>
                                    <div class="profile-upload">
                                        <div class="upload-img">
                                            <img alt="PFP" src="assets/uploaded_img/<?php echo $PFP; ?>">
                                        </div>
                                        <div class="upload-input">
                                            <input type="hidden" name="update_old_image" value="assets/uploaded_img/<?php echo $PFP; ?>">
                                            <input style="border: 1px solid #888;" type="file" class="form-control" name="update_image" accept="image/jpeg, image/jpg, image/png">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group col-sm-6 col-md-6 pull-left">
                                    <label class="display-block">Status: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="doctor_active" <?php if ($Status === "active")echo 'checked="checked"';?> value="active" required>
                                        <label class="form-check-label" for="doctor_active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="doctor_inactive" <?php if ($Status === "inactive")echo 'checked="checked"';?> value="inactive" required>
                                        <label class="form-check-label" for="doctor_inactive">Inactive</label>
                                    </div>
                                </div>

                                <div class="form-group col-sm-6 col-md-6 pull-right">
                                    <label class="display-block">User Type: </label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="user-type" id="user_admin" <?php if ($User_Type === "admin")echo 'checked="checked"';?> value="admin" required>
                                        <label class="form-check-label" for="user_admin">Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="user-type" id="user_therapist" <?php if ($User_Type === "therapist")echo 'checked="checked"';?> value="therapist" required>
                                        <label class="form-check-label" for="user_therapist">Therapist</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="user-type" id="user_client" <?php if ($User_Type === "user")echo 'checked="checked"';?> value="user" required>
                                        <label class="form-check-label" for="user_client">Client</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn" type="submit" name="submit">Save</button>
                        </div>
                    </form>
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
<script src="assets/js/select2.min.js"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/app.js"></script>
</body>


</html>
