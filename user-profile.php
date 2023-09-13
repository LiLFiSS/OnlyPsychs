<?php

session_start();

$UserID = $_SESSION['user_UID'];

if (!isset($_SESSION['user_UID'])){
    header("Location: login.php");
}

$email = $_SESSION['user_Email'];
$firstName = $_SESSION['user_FirstName'];
$lastName = $_SESSION['user_LastName'];

$conn = mysqli_connect('localhost', 'root', '', 'onlypsychs_db');
mysqli_select_db($conn, 'onlypsychs_db') or die("cannot select DB");

$sql_pfp = "SELECT * FROM users WHERE UserID = '$UserID'";
$result2 = mysqli_query($conn, $sql_pfp);

while ($row = mysqli_fetch_array($result2)){
    $PFP = $row['profile_picture'];
    $dob = $row['dob'];
    $gender = $row['gender'];
    $phone_num = $row['phone_num'];
}

if ($dob == null || $dob == ''){
    $DOB = "xx-xx-xxxx";
} else {
    $DOB = $dob;
}

$PP = $PFP;

$find_case = "SELECT * FROM cases WHERE patient_id = '$UserID'";
$find_query = mysqli_query($conn, $find_case);

if (mysqli_num_rows($find_query) > 0){
    while ($fetch_therapist = mysqli_fetch_array($find_query)){
        $ID = $fetch_therapist['therapist_id'];
    }
} else {
    $ID = '---';
}

$TID = $ID;
if ($TID != '---'){
    $therapist_details = "SELECT * FROM users WHERE UserID = '$TID'";
    $therapist_query = mysqli_query($conn, $therapist_details);

    while ($fetch_info = mysqli_fetch_array($therapist_query)){
        $therapist_FName = $fetch_info['first_name'];
        $therapist_LName = $fetch_info['last_name'];
    }

    $therapist_Name = $therapist_FName ." ". $therapist_LName;
} else {
    $therapist_Name = "unassigned";
}

$sql2 = "SELECT * FROM user_custom_profile WHERE UserID = '$UserID'";
$query = mysqli_query($conn, $sql2);

while ($rows = mysqli_fetch_array($query)){
    $bio = $rows['bio'];
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OnlyPsychs - My Profile</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/assets/img/favicon.png" rel="icon">
    <link href="assets/img/Final2.ico" rel="shortcut icon" type="image/x-icon">
    <link href="assets/assets/img/apple-touch-icon.png" rel="apple-touch-icon">


    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Template Main CSS File -->
    <link href="assets/assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>

        .btn-success{
            --bs-btn-active-bg: #198754;
            --bs-btn-active-border-color:#198754
            --bs-btn-border-color:#94c045;
        }

        .btn-success{
            background-color: #94c045;
            border-color: #94c045;
            color: #fff;
        }

        .thanks{
            background-color: #646c55;
            color: #fff;
            border: 1px solid #646c55;
            padding: 5px;
            border-radius: 6px
        }

        .bar-chart > .legend > .item.text-right:before {
            right: 0;
            left: auto;
        }

    </style>

</head>

<body>

<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <div class="logo">
            <!--<h1 class="text-light"><a href="index.html">Serenity</a></h1>-->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="user-home.php"><img src="assets/img/OnlyPsychs-logo-green.png" alt="" class="img-fluid"><span class="logo-wrds" style="margin-left: 5px;"><img src="assets/img/OnlyPsychs-black-green-wrds.png" height="45"></span></a>
            <!--<img alt="" height="45" src="assets/img/OnlyPsycs-logo.png" width="45"> <span><img src="assets/img/OnlyPsychs-black-white-words.png" height="30"></span>-->
        </div>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a class="active" href="user-home.php">Home</a></li>
                <li class="dropdown"><a href="#"><span>About</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="user-about.php">About</a></li>
                        <li><a href="user-view-therapists.php">Our Therapists</a></li>
                        <!--<li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                            <ul>
                                <li><a href="#">Deep Drop Down 1</a></li>
                                <li><a href="#">Deep Drop Down 2</a></li>
                                <li><a href="#">Deep Drop Down 3</a></li>
                                <li><a href="#">Deep Drop Down 4</a></li>
                                <li><a href="#">Deep Drop Down 5</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </li>
                <li><a href="user-services.php">Services</a></li>
                <li><a href="user-faq.php">FAQ</a></li>
                <li><a href="user-contact.php">Contact</a></li>



                <li class="dropdown profile-view-2">
                    <a href="#">
                        <img alt="pfp" class="rounded-circle" height="35" src="assets/uploaded_img/<?php echo $PP; ?>">
                        <span><?php echo $firstName ?></span> <i class="bi bi-chevron-down"></i>
                    </a>
                    <ul>
                        <li><a href="user-profile.php">My Profile</a></li>
                        <?php
                        $notification_query = " SELECT * FROM notifications WHERE receiverID = '$UserID' AND status = 'active' ";
                        $select_notifications = mysqli_query($conn, $notification_query) or die('query failed');
                        $notifications_count = mysqli_num_rows($select_notifications);
                        ?>
                        <li><a href="">Notifications <span style="background-color: red; color: #fff; padding: 1px 6px; border-radius: 8px"><?php echo $notifications_count ?></span> </a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>

            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

    </div>
</header><!-- End Header -->



<main id="main">


<section>
    <div class="container">
        <div class="row" style=" margin-top: 30px;">
            <div class="col-sm-7 col-6">
                <h4 class="page-title">My Profile</h4>
            </div>

            <div class="col-sm-5 col-6 m-b-30 " style="display: flex; justify-content: flex-end">
                <a href="edit-profile-user.php" class="btn btn-success btn-rounded"><i class="bi bi-pen"></i> Edit Profile</a>
            </div>
        </div>
        <div class="card-box profile-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img class="avatar" src="assets/uploaded_img/<?php echo $PP ?>" alt=""></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0"><?php echo $firstName ." ". $lastName ?></h3>
                                        <small class="text-muted"></small>
                                        <div class="staff-id">User ID : UID-00<?php echo  $UserID ?></div>
                                        <!--<div class="staff-msg"><a href="#" class="btn btn-primary">Send Message</a></div>-->
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <span class="title">Phone Number:</span>
                                            <span class="text"><a href="#"><?php echo $phone_num?></a></span>
                                        </li>
                                        <li>
                                            <span class="title">Email:</span>
                                            <span class="text"><a href="#"><?php echo $email ?></a></span>
                                        </li>
                                        <li>
                                            <span class="title">Birthday:</span>
                                        <span class="text"><?php echo $DOB ?></span>
                                        </li>

                                        <li>
                                            <span class="title">Gender:</span>
                                            <span class="text"><?php echo $gender ?></span>
                                        </li>

                                        <li>
                                            <span class="title">Assigned Therapist:</span>
                                            <span class="text"><a href="user-view-therapist-profile.php?id=<?php echo $TID ?>"><?php echo $therapist_Name ?></a> </span>
                                            <!--<span class="text"><?php /*echo $therapist_FName ." ". $therapist_LName */?></span>-->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-tabs">
            <ul class="nav nav-tabs nav-tabs-bottom">
                <li class="nav-item"><a class="nav-link active" href="#about-cont" data-toggle="tab">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab2" data-toggle="tab">Notifications</a></li>
                <li class="nav-item"><a class="nav-link" href="#bottom-tab3" data-toggle="tab">Questionnaire</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane show active" id="about-cont">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-box">
                                <h3 class="card-title">About Me</h3>
                                <div class="experience-box">
                                    <div class="bio-box">
                                        <?php echo
                                        $bio;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="bottom-tab2">
                    <div class="col-md-12">
                        <div class="activity">
                            <div class="activity-box">
                                <ul class="activity-list">
                                    <?php
                                    $sql = "SELECT * FROM notifications WHERE receiverID = '$UserID' AND status = 'Active' ORDER BY sent_date DESC ";
                                    $select_notifs = mysqli_query($conn, $sql) or die('query failed');
                                    if (mysqli_num_rows($select_notifs) > 0) {
                                        while ($fetch_notifs = mysqli_fetch_assoc($select_notifs)) {
                                            $senderID = $fetch_notifs['sender_ID'];
                                            $description = $fetch_notifs['description'];
                                            $sent_date = $fetch_notifs['sent_date'];

                                            $sender_details = "SELECT * FROM users WHERE UserID = '$senderID' AND status = 'Active' ";
                                            $sender_details_query = mysqli_query($conn, $sender_details);

                                            while ($fetch_sender_details = mysqli_fetch_array($sender_details_query)){
                                                $sender_FName = $fetch_sender_details['first_name'];
                                                $sender_LName = $fetch_sender_details['last_name'];
                                                $sender_pfp = $fetch_sender_details['profile_picture'];
                                                ?>
                                                <li>
                                                    <div class="activity-user">
                                                        <a href="user-view-therapist-profile.php?id=<?php echo $senderID?>" title="<?php echo $sender_FName ." ". $sender_LName ?>" data-toggle="tooltip" class="avatar">
                                                            <img alt="pfp" src="assets/uploaded_img/<?php echo $sender_pfp ?>" class="img-fluid rounded-circle">
                                                        </a>
                                                    </div>
                                                    <div class="activity-content">
                                                        <div class="timeline-content">
                                                            <a href="user-view-therapist-profile.php?id=<?php echo $senderID?>" class="name"><?php echo $sender_FName ." ". $sender_LName ?></a> <?php echo $description ?>
                                                            <!--<a href="#"><?php /*echo $fetch_notifs['task']; */?></a>-->
                                                            <span class="time"><?php echo $sent_date; ?></span>
                                                        </div>
                                                    </div>
                                                    <a class="activity-delete" href="activities.php?delete=<?php echo $fetch_notifs['NID']; ?> " onclick="return confirm('Are you sure you want to delete this notification from view?');" title="Delete" type="submit">&times;</a>
                                                </li>
                                                <?php
                                            }
                                        }
                                    } else {
                                        echo '<p>No Notifications Yet</p>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="bottom-tab3">
                    <div class="table-responsive">
                        <table class="table table-border table-striped custom-table datatable mb-0">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Questionnaire Type</th>
                                <th>Completion Date</th>
                                <th style="display: flex; justify-content: flex-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql = "SELECT * FROM questionnaire WHERE UserID = '$UserID'";
                            $select_questions = mysqli_query($conn, $sql) or die('query failed');
                            if (mysqli_num_rows($select_questions) > 0){
                                while ($fetch_questionnaire = mysqli_fetch_assoc($select_questions)){
                                    ?>
                                    <tr>
                                        <td>QN-00<?php echo $fetch_questionnaire['QID'] ?></td>
                                        <td><?php echo $fetch_questionnaire['Questionnaire_Type'];?></td>
                                        <td><?php echo $fetch_questionnaire['Completion_Date']; ?></td>
                                        <td style="display: flex; justify-content: flex-end;">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots-vertical"></i></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="edit-user.php?id=<?php echo $fetch_questionnaire['QID']; ?>"><i class="bi bi-view-list m-r-5"></i> View</a>
                                                    <!--<a class="dropdown-item" href="#" ><i class="fa fa-trash-o m-r-5 delete-btn"></i> Delete</a>-->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            } else{
                                echo '<p>No Questionnaire Completed Yet. Take one <a href="get-started-page.php">now</a></p>';
                            }

                            ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-info">
                    <a href="landing-page.php"><img src="assets/img/OnlyPsychs-white-green-wrds.png" height="60"></a>
                    <p>Cras fermentum odio eu feugiat lide par naso tierra.
                        Justo eget nada terra videa magna derita valies darta
                        donna mare fermentum iaculis eu non diam phasellus.
                        Scelerisque felis imperdiet proin fermentum leo.
                        Amet volutpat consequat mauris nunc congue.</p>
                </div>

                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h4>Contact Us</h4>
                    <p>
                        A108 Adam Street <br>
                        Somewhere, SF 535022<br>
                        Trinidad <br>
                        <strong>Phone:</strong> +1 868 9594 555<br>
                        <strong>Email:</strong> onlypsychs@gmail.com<br>
                    </p>

                    <div class="social-links">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>

                </div>

                <div class="col-lg-3 col-md-6 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna veniam enim veniam illum dolore legam minim quorum culpa amet magna export quem marada parida nodela caramase seza.</p>
                    <form action="" method="post">
                        <input type="email" name="email"><input type="submit" value="Subscribe">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy; Copyright <strong><span>OnlyPsychs</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            Designed by <a href="https://twitter.com/elonmusk">Kaizha Brathwaite - 84109</a>
        </div>
    </div>
</footer><!-- End Footer -->


<!--<div id="preloader"></div>-->
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script>
    function ($) {
        "use strict";

        $(window).on('load', function() {
            var pre_loader = $('#preloader');
            pre_loader.fadeOut('slow', function(){
                $(this).remove();
            });
        });
    };
</script>

<!-- Vendor JS Files -->
<script src="assets/assets/vendor/purecounter/purecounter_vanilla.js"></script>
<script src="assets/assets/vendor/aos/aos.js"></script>
<script src="assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="assets/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/assets/vendor/waypoints/noframework.waypoints.js"></script>
<script src="assets/assets/vendor/php-email-form/validate.js"></script>

<script src="assets/js/jquery-3.2.1.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/app.js"></script>

<!-- Template Main JS File -->
<script src="assets/assets/js/main.js"></script>

</body>

</html>
