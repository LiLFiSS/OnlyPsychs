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

$PP = $PFP;

$TID = $_GET['id'];

$get_therapist = "SELECT * FROM users WHERE UserID = '$TID'";
$therapist_result = mysqli_query($conn, $get_therapist);

while ($row21 = mysqli_fetch_array($therapist_result)){
    $TPFP = $row21['profile_picture'];
    $Tgender = $row21['gender'];
    $Tdob = $row21['dob'];
    $Tphone_num = $row21['phone_num'];
    $TuserID = $row21['UserID'];
    $TFName = $row21['first_name'];
    $TLName = $row21['last_name'];
    $therapist_Email = $row21['email'];
}

$TPP = $TPFP;
$TGender = $Tgender;
$DOB = $Tdob;
$PhoneNumber = $Tphone_num;
$TEmail = $therapist_Email;

$sql_t = " SELECT * FROM therapist WHERE UserID = '$TID' ";
$query = mysqli_query($conn, $sql_t);

while ($fetch_Therapist = mysqli_fetch_array($query)){
$address = $fetch_Therapist['address'];
$city = $fetch_Therapist['office_city'];
$country = $fetch_Therapist['office_country'];
$license1 = $fetch_Therapist['license_1'];
$license2 = $fetch_Therapist['license_2'];

    if ($license2 != '' || $license2 != null){
        $license1 = $license1 .",";
    }

}

$Office_Address = $address ." ". $city ." ". $country;
$Therapist_License1 = $license1;
$Therapist_License2 = $license2;

/*$find_case = "SELECT * FROM cases WHERE patient_id = '$UserID'";
$find_query = mysqli_query($conn, $find_case);

while ($fetch_therapist = mysqli_fetch_array($find_query)){
    $ID = $fetch_therapist['therapist_id'];
}

$TID = $ID;

$therapist_details = "SELECT * FROM users WHERE UserID = '$TID'";
$therapist_query = mysqli_query($conn, $therapist_details);

while ($fetch_info = mysqli_fetch_array($therapist_query)){
    $therapist_FName = $fetch_info['first_name'];
    $therapist_LName = $fetch_info['last_name'];
}*/

if (isset($_POST["submit"])){
    $review_content = $_POST['review-content'];

    date_default_timezone_set('America/Port_of_Spain');
    $time = date("Y/m/d h:i:sa");

    $review_insert = "INSERT INTO reviews (TID, CID, post_content, submit_date) 
                        VALUES ('$TID', '$UserID', '" . mysqli_real_escape_string($conn, $review_content) . "', '$time')";
    $insert_query = mysqli_query($conn, $review_insert);

    if ($review_insert){
        echo "<div class='alert alert-success mov-2' role='alert'> Review Posted! Redirecting, Please wait... </div>";
        header( "refresh:10;url=user-home.php");
    } else {
        echo "<div class='alert alert-danger mov-2' role='alert'> Error Posting Review! </div>";
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>OnlyPsychs - Leave a Review</title>
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

<div class="container">
    <div class="content">
        <div class="row ">
            <div class="col-sm-12 mt-4">
                <h4 class="page-title">Leave a kind review for your therapist</h4>
            </div>
        </div>

        <div class="card-box profile-header mb-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img class="avatar" src="assets/uploaded_img/<?php echo $TPP ?>" alt=""></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">Dr. <?php echo $TFName ." ". $TLName ?></h3>
                                        <small class="text-muted">Psychologist <?php echo $Therapist_License1 ." ". $Therapist_License2; ?></small>
                                        <!--<div class="staff-id">Employee ID : DR-0001</div>-->
                                        <!--<div class="staff-msg"><a href="chat.html" class="btn btn-primary">Send Message</a></div>-->
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <span class="title">Contact Number:</span>
                                            <span class="text"><a href="#"><?php echo $PhoneNumber; ?></a></span>
                                        </li>
                                        <li>
                                            <span class="title">Email:</span>
                                            <span class="text"><a href="#"><?php echo $TEmail ?></a></span>
                                        </li>
                                        <li>
                                            <span class="title">Birthday:</span>
                                            <span class="text"><?php echo $DOB; ?></span>
                                        </li>
                                        <li>
                                            <span class="title">Address:</span>
                                            <span class="text"><?php echo $Office_Address ?></span>
                                        </li>
                                        <li>
                                            <span class="title">Gender:</span>
                                            <span class="text"><?php echo $TGender; ?></span>
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
            <div class="col-sm-12">
                <div class="card-box">
                    <form method="post">
                        <div class="form-group">
                            <textarea rows="10" cols="5" name="review-content" class="form-control summernote" required placeholder="Say something nice...."></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <div class="text-center compose-btn">
                                <button class="btn btn-primary" name="submit" type="submit"><span>Oh yeah, Post it!</span><i class="fa fa-send m-l-5"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


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
